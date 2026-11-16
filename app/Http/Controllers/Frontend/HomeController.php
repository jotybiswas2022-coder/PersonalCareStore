<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderByDesc('is_featured')
            ->latest()
            ->take(8)
            ->get();

        $navCategories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('frontend.home', compact('featuredProducts', 'navCategories'));
    }
}
