<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_asked_to_sign_in_before_saving(): void
    {
        $product = $this->makeProduct();

        $this->post(route('wishlist.toggle'), ['product_id' => $product->id])
            ->assertRedirect(route('login'));

        $this->assertSame(0, Wishlist::count());
    }

    public function test_saving_and_removing_a_product_toggles_the_wishlist(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct();

        $this->actingAs($user)
            ->post(route('wishlist.toggle'), ['product_id' => $product->id])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($user)
            ->get(route('wishlist.index'))
            ->assertOk()
            ->assertSee($product->name);

        $this->actingAs($user)
            ->post(route('wishlist.toggle'), ['product_id' => $product->id])
            ->assertRedirect();

        $this->assertSame(0, Wishlist::count());
    }

    public function test_the_product_page_marks_saved_products_as_active(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct();

        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)
            ->get(route('products.show', $product->id))
            ->assertOk()
            ->assertSee('aria-pressed="true"', false)
            ->assertSee('Remove from wishlist', false);
    }

    public function test_customers_cannot_delete_another_customers_wishlist_row(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $product = $this->makeProduct();

        $wishlist = Wishlist::create(['user_id' => $owner->id, 'product_id' => $product->id]);

        $this->actingAs($other)
            ->delete(route('wishlist.destroy', $wishlist->id))
            ->assertNotFound();

        $this->assertDatabaseHas('wishlists', ['id' => $wishlist->id]);
    }

    private function makeProduct(): Product
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
            'stock_quantity' => 5,
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }
}
