<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_reserves_stock_and_creates_order(): void
    {
        $product = $this->makeProduct(stock: 5);

        $sessionId = $this->seedCart($product, 2);

        $response = $this->post(route('checkout.process'), $this->checkoutPayload());

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $order = Order::firstOrFail();

        $this->assertNotNull($order->stock_reserved_at);
        $this->assertSame(3, $product->fresh()->stock_quantity);
        $this->assertSame(2, (int) $order->items()->sum('quantity'));
        $this->assertSame(0, Cart::where('session_id', $sessionId)->count());
    }

    public function test_checkout_is_rejected_when_stock_is_insufficient(): void
    {
        $product = $this->makeProduct(stock: 1);

        $sessionId = $this->seedCart($product, 3);

        $response = $this->post(route('checkout.process'), $this->checkoutPayload());

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');

        $this->assertSame(0, Order::count());
        $this->assertSame(1, $product->fresh()->stock_quantity);
        $this->assertSame(1, Cart::where('session_id', $sessionId)->count());
    }

    public function test_checkout_is_rejected_for_inactive_products(): void
    {
        $product = $this->makeProduct(stock: 5);
        $product->update(['is_active' => false]);

        $sessionId = $this->seedCart($product, 1);

        $response = $this->post(route('checkout.process'), $this->checkoutPayload());

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');

        $this->assertSame(0, Order::count());
        $this->assertSame(5, $product->fresh()->stock_quantity);
    }

    public function test_cancelling_an_order_restores_reserved_stock_once(): void
    {
        $product = $this->makeProduct(stock: 3);
        $user = User::factory()->create();

        $order = Order::create([
            'order_number' => 'ORD-TEST-1',
            'guest_email' => $user->email,
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 200,
            'total' => 200,
            'stock_reserved_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 100,
            'quantity' => 2,
            'subtotal' => 200,
        ]);

        $this->actingAs($user)
            ->patch(route('orders.cancel', $order->id))
            ->assertRedirect(route('orders.index'));

        $this->assertSame(5, $product->fresh()->stock_quantity);
        $this->assertNull($order->fresh()->stock_reserved_at);

        // A second release must not hand the units out again.
        $order->fresh()->releaseStock();
        $this->assertSame(5, $product->fresh()->stock_quantity);
    }

    public function test_payment_proof_requires_the_checkout_session(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-TEST-2',
            'guest_email' => 'buyer@example.com',
            'status' => 'pending',
            'subtotal' => 100,
            'total' => 100,
        ]);

        $this->startSession();
        session()->put('checkout_email', 'someone-else@example.com');

        $this->post(route('checkout.proof', $order->id), [
            'payment_method_used' => 'bkash',
            'transaction_id' => 'TX123',
        ])->assertNotFound();

        $this->assertNull($order->fresh()->proof_image);
        $this->assertSame('unpaid', $order->fresh()->payment_status);
    }

    /**
     * Seed the cart for the session the request will actually use, and send
     * that session id as the (encrypted) session cookie.
     */
    private function seedCart(Product $product, int $quantity): string
    {
        $this->startSession();

        $sessionId = session()->getId();

        Cart::create([
            'session_id' => $sessionId,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        $this->withCookie(config('session.cookie'), $sessionId);

        return $sessionId;
    }

    private function makeProduct(int $stock, float $price = 100): Product
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
            'short_description' => 'Test',
            'price' => $price,
            'stock_quantity' => $stock,
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
