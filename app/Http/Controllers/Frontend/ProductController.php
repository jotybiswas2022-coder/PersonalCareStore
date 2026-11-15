<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of active products.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with('category')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        $product = Product::where('is_active', true)
            ->with(['category', 'reviews' => function ($query) {
                $query->where('is_approved', true)->latest();
            }])
            ->findOrFail($id);

        $relatedProducts = Product::with('reviews')->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        $inWishlist = auth()->check() && Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        return view('frontend.products.show', compact('product', 'relatedProducts', 'inWishlist'));
    }

    /**
     * Display products by category.
     */
    public function byCategory(string $categoryId)
    {
        $category = Category::where('is_active', true)->findOrFail($categoryId);

        $products = Product::where('is_active', true)
            ->where('category_id', $categoryId)
            ->with('category')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.products.index', compact('products', 'categories', 'category'));
    }
}
