<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartMergeTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_cart_is_moved_to_the_account_on_login(): void
    {
        $product = $this->makeProduct(stock: 10);
        $sessionId = $this->seedGuestCart($product, 2);

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseMissing('carts', ['session_id' => $sessionId]);
    }

    public function test_merge_combines_duplicate_rows_and_respects_stock(): void
    {
        $product = $this->makeProduct(stock: 5);
        $sessionId = $this->seedGuestCart($product, 3);

        $user = User::factory()->create();
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 4,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertSame(1, Cart::where('user_id', $user->id)->count());
        $this->assertSame(5, (int) Cart::where('user_id', $user->id)->value('quantity'));
        $this->assertSame(0, Cart::where('session_id', $sessionId)->count());
    }

    public function test_logged_in_carts_are_stored_against_the_user(): void
    {
        $product = $this->makeProduct(stock: 4);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.add', $product->id), ['quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'session_id' => null,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user)
            ->get(route('cart.index'))
            ->assertOk()
            ->assertSee($product->name);
    }

    private function seedGuestCart(Product $product, int $quantity): string
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

    private function makeProduct(int $stock): Product
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
            'price' => 100,
            'stock_quantity' => $stock,
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }
}
