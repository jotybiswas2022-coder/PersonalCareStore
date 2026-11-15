<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_valid_coupon_is_applied_to_the_cart(): void
    {
        $product = $this->makeProduct();
        $this->seedCart($product, 2);
        $this->makeCoupon(['code' => 'SAVE10', 'value' => 10]);

        $this->post(route('cart.coupon.apply'), ['code' => 'save10'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame('SAVE10', session('coupon_code'));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('SAVE10')
            ->assertSee(currencyFormat(20));
    }

    public function test_an_unknown_coupon_is_rejected(): void
    {
        $product = $this->makeProduct();
        $this->seedCart($product, 1);

        $this->post(route('cart.coupon.apply'), ['code' => 'NOPE'])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertNull(session('coupon_code'));
    }

    public function test_coupons_below_the_minimum_subtotal_are_rejected(): void
    {
        $product = $this->makeProduct();
        $this->seedCart($product, 1);
        $this->makeCoupon(['code' => 'BIG', 'value' => 10, 'min_subtotal' => 500]);

        $this->post(route('cart.coupon.apply'), ['code' => 'BIG'])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertNull(session('coupon_code'));
    }

    public function test_expired_and_exhausted_coupons_are_rejected(): void
    {
        $product = $this->makeProduct();
        $this->seedCart($product, 1);

        $this->makeCoupon(['code' => 'OLD', 'expires_at' => now()->subDay()]);
        $this->post(route('cart.coupon.apply'), ['code' => 'OLD'])->assertSessionHas('error');

        $this->makeCoupon(['code' => 'USED', 'usage_limit' => 1, 'used_count' => 1]);
        $this->post(route('cart.coupon.apply'), ['code' => 'USED'])->assertSessionHas('error');

        $this->assertNull(session('coupon_code'));
    }

    public function test_checkout_applies_the_discount_and_counts_the_usage(): void
    {
        $product = $this->makeProduct();
        $this->seedCart($product, 2, coupon: 'SAVE10');
        $coupon = $this->makeCoupon(['code' => 'SAVE10', 'value' => 10]);

        $this->post(route('checkout.process'), $this->checkoutPayload())->assertRedirect();

        $order = Order::firstOrFail();

        $this->assertSame('SAVE10', $order->coupon_code);
        $this->assertSame('20.00', (string) $order->discount);
        $this->assertSame('180.00', (string) $order->total);
        $this->assertSame(1, $coupon->fresh()->used_count);
        $this->assertNull(session('coupon_code'));
    }

    public function test_checkout_stops_when_the_coupon_became_invalid(): void
    {
        $product = $this->makeProduct();
        $this->seedCart($product, 2, coupon: 'SAVE10');
        $this->makeCoupon(['code' => 'SAVE10', 'value' => 10, 'usage_limit' => 1, 'used_count' => 1]);

        $this->post(route('checkout.process'), $this->checkoutPayload())
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('error');

        $this->assertSame(0, Order::count());
        $this->assertSame(10, $product->fresh()->stock_quantity);
    }

    public function test_fixed_coupons_never_exceed_the_subtotal(): void
    {
        $product = $this->makeProduct(price: 100);
        $this->seedCart($product, 1, coupon: 'BIGFIX');
        $this->makeCoupon(['code' => 'BIGFIX', 'type' => 'fixed', 'value' => 500]);

        $this->post(route('checkout.process'), $this->checkoutPayload())->assertRedirect();

        $order = Order::firstOrFail();

        $this->assertSame('100.00', (string) $order->discount);
        $this->assertSame('0.00', (string) $order->total);
    }

    public function test_admins_can_manage_coupons(): void
    {
        $admin = \App\Models\User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get(route('admin.coupons.index'))->assertOk()->assertSee('No coupons yet');
        $this->actingAs($admin)->get(route('admin.coupons.create'))->assertOk()->assertSee('Coupon code');

        $this->actingAs($admin)->post(route('admin.coupons.store'), [
            'code' => 'eid20',
            'type' => 'percent',
            'value' => 20,
            'min_subtotal' => 100,
            'is_active' => 1,
        ])->assertRedirect(route('admin.coupons.index'));

        $coupon = Coupon::firstOrFail();
        $this->assertSame('EID20', $coupon->code);

        $this->actingAs($admin)->get(route('admin.coupons.edit', $coupon->id))->assertOk()->assertSee('EID20');

        $this->actingAs($admin)->put(route('admin.coupons.update', $coupon->id), [
            'code' => 'EID20',
            'type' => 'fixed',
            'value' => 50,
            'min_subtotal' => 0,
        ])->assertRedirect(route('admin.coupons.index'));

        $this->assertSame('50.00', (string) $coupon->fresh()->value);
        $this->assertFalse($coupon->fresh()->is_active);

        $this->actingAs($admin)->patch(route('admin.coupons.toggle', $coupon->id))->assertRedirect();
        $this->assertTrue($coupon->fresh()->is_active);

        $this->actingAs($admin)->delete(route('admin.coupons.destroy', $coupon->id))->assertRedirect();
        $this->assertSame(0, Coupon::count());
    }

    public function test_percentage_coupons_cannot_exceed_one_hundred(): void
    {
        $admin = \App\Models\User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.coupons.store'), [
            'code' => 'BAD',
            'type' => 'percent',
            'value' => 150,
            'is_active' => 1,
        ])->assertSessionHasErrors('value');

        $this->assertSame(0, Coupon::count());
    }

    private function makeCoupon(array $attributes = []): Coupon
    {
        return Coupon::create(array_merge([
            'code' => 'SAVE10',
            'type' => 'percent',
            'value' => 10,
            'min_subtotal' => 0,
            'is_active' => true,
        ], $attributes));
    }

    private function seedCart(Product $product, int $quantity, ?string $coupon = null): string
    {
        $this->startSession();

        $sessionId = session()->getId();

        Cart::create([
            'session_id' => $sessionId,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        if ($coupon) {
            session()->put('coupon_code', $coupon);
        }

        $this->withCookie(config('session.cookie'), $sessionId);

        return $sessionId;
    }

    private function makeProduct(float $price = 100): Product
    {
        $category = Category::create([
            'name' => 'Personal Care',
            'slug' => 'personal-care',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        return Product::create([
            'name' => 'Hand Sanitizer',
            'slug' => 'hand-sanitizer',
            'description' => '<p>Test product</p>',
            'price' => $price,
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }

    private function checkoutPayload(): array
    {
        return [
            'first_name' => 'Test',
            'last_name' => 'Buyer',
            'email' => 'buyer@example.com',
            'phone' => '01700000000',
            'address_line1' => '1 Test Road',
            'city' => 'Khulna',
            'postal_code' => '9100',
            'country' => 'Bangladesh',
        ];
    }
}
