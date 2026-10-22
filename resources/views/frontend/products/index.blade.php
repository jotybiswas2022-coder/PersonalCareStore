@extends('frontend.layouts.app')

@section('title', isset($category) ? $category->name : 'Products')

@push('styles')
<style>
    /* ─────────────── PAGE HERO ─────────────── */
    .products-hero {
        background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 50%, #FEFCE8 100%);
        padding: 3rem 1rem 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .products-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .products-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,209,102,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .products-hero h1 {
        font-size: 2.25rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: 0.5rem;
        letter-spacing: -0.03em;
        position: relative;
    }
    .products-hero p {
        color: #6b7280;
        font-size: 1rem;
        max-width: 32rem;
        margin: 0 auto;
        line-height: 1.6;
        position: relative;
    }
    .products-hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(46,139,87,0.10);
        color: #2E8B57;
        font-size: 0.8125rem;
        font-weight: 600;
        padding: 0.375rem 1rem;
        border-radius: 9999px;
        margin-bottom: 1rem;
        border: 1px solid rgba(46,139,87,0.15);
    }
    .products-hero .hero-badge span {
        width: 0.5rem; height: 0.5rem;
        background: #2E8B57;
        border-radius: 50%;
    }

    /* ─────────────── TOOLBAR ─────────────── */
    .products-toolbar {
        max-width: 1280px;
        margin: 1.5rem auto 0;
        padding: 0 1.5rem;
    }
    .toolbar-inner {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .search-wrap {
        flex: 1;
        min-width: 14rem;
        position: relative;
    }
    .search-wrap svg {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        pointer-events: none;
    }
    .search-wrap input {
        width: 100%;
        padding: 0.625rem 0.875rem 0.625rem 2.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-wrap input:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.1);
    }

    /* ─────────────── CATEGORY CHIPS ─────────────── */
    .category-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }
    .category-chips .label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #6b7280;
        margin-right: 0.25rem;
    }
    .chip {
        text-decoration: none;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    .chip-all {
        background: #f3f4f6;
        color: #374151;
        border-color: #e5e7eb;
    }
    .chip-all:hover { background: #e5e7eb; }
    .chip-all.active {
        background: #2E8B57;
        color: #fff;
        border-color: #2E8B57;
    }
    .chip-cat {
        background: #f3f4f6;
        color: #374151;
        border-color: #e5e7eb;
    }
    .chip-cat:hover { background: #e5e7eb; }
    .chip-cat.active {
        background: #2E8B57;
        color: #fff;
        border-color: #2E8B57;
    }

    /* ─────────────── PRODUCT GRID ─────────────── */
    .products-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.5rem 4rem;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    /* ─────────────── PRODUCT CARD ─────────────── */
    .product-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: rgba(46,139,87,0.2);
    }

    /* Image wrapper */
    .product-card .img-wrap {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #f9fafb;
    }
    .product-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .img-wrap img {
        transform: scale(1.08);
    }
    .product-card .img-wrap .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
        background: #f9fafb;
    }

    /* Badges */
    .product-card .badges {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        z-index: 2;
    }
    .product-card .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 0.375rem;
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .badge-discount {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: #fff;
    }
    .badge-out-of-stock {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: #fff;
    }
    .badge-new {
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
    }

    /* Quick action overlay */
    .product-card .quick-actions {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        opacity: 0;
        transform: translateX(8px);
        transition: all 0.3s ease;
        z-index: 2;
    }
    .product-card:hover .quick-actions {
        opacity: 1;
        transform: translateX(0);
    }
    .product-card .quick-btn {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        background: rgba(255,255,255,0.95);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        text-decoration: none;
    }
    .product-card .quick-btn:hover {
        background: #2E8B57;
        color: #fff;
        transform: scale(1.1);
    }

    /* Card body */
    .product-card .card-body {
        padding: 1rem 1.25rem 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-card .cat-name {
        font-size: 0.75rem;
        font-weight: 500;
        color: #2E8B57;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.375rem;
    }
    .product-card .product-name {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        text-decoration: none;
        transition: color 0.2s;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-card .product-name:hover {
        color: #2E8B57;
    }

    /* Price & Stock row */
    .product-card .price-stock {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 0.75rem;
    }
    .product-card .price-area {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .product-card .current-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
    }
    .product-card .old-price {
        font-size: 0.8125rem;
        color: #9ca3af;
        text-decoration: line-through;
    }
    .product-card .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.6875rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }
    .product-card .stock-badge.in-stock {
        background: #f0fdf4;
        color: #166534;
    }
    .product-card .stock-badge.out-of-stock {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Discount notice */
    .product-card .discount-note {
        font-size: 0.6875rem;
        color: #dc2626;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* Add to cart */
    .product-card .cart-form {
        margin-top: 0.75rem;
    }
    .product-card .atc-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #FFD166, #F0C14B);
        color: #212529;
        border: none;
        padding: 0.625rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .product-card .atc-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255,209,102,0.4);
    }
    .product-card .atc-btn:active {
        transform: translateY(0);
    }
    .product-card .atc-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    .product-card .atc-btn.sold-out {
        background: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }
    .product-card .atc-btn.sold-out:hover {
        transform: none;
        box-shadow: none;
    }

    /* ─────────────── PAGINATION ─────────────── */
    .pagination-wrap {
        margin-top: 2.5rem;
        display: flex;
        justify-content: center;
    }
    .pagination-wrap nav {
        display: flex;
        gap: 0.375rem;
        flex-wrap: wrap;
    }
    .pagination-wrap a,
    .pagination-wrap span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.25rem;
        height: 2.25rem;
        padding: 0 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    .pagination-wrap a {
        background: #ffffff;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    .pagination-wrap a:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    .pagination-wrap span.current {
        background: #2E8B57;
        color: #fff;
        border-color: #2E8B57;
    }
    .pagination-wrap span.disabled {
        color: #d1d5db;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
    }

    /* ─────────────── EMPTY STATE ─────────────── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        grid-column: 1 / -1;
    }
    .empty-state .empty-icon {
        width: 4rem;
        height: 4rem;
        margin: 0 auto 1rem;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }
    .empty-state h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }
    .empty-state p {
        color: #6b7280;
        font-size: 0.875rem;
        max-width: 20rem;
        margin: 0 auto;
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 768px) {
        .products-hero { padding: 2rem 1rem 1.5rem; }
        .products-hero h1 { font-size: 1.625rem; }
        .products-hero p { font-size: 0.875rem; }
        .toolbar-inner { flex-direction: column; padding: 1rem; }
        .search-wrap { min-width: 0; width: 100%; }
        .category-chips .label { display: none; }
        .products-container { padding: 0 1rem 3rem; }
        .product-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
        .product-card .card-body { padding: 0.75rem; }
        .product-card .current-price { font-size: 1rem; }
        .product-card .quick-actions { opacity: 1; transform: translateX(0); }
        .quick-actions .quick-btn { width: 2rem; height: 2rem; }
    }

    @media (max-width: 480px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    }

    /* ─────────────── ENTRY ANIMATION ─────────────── */
    .product-card {
        opacity: 0;
        transform: translateY(20px);
        animation: cardIn 0.4s ease forwards;
    }
    .product-card:nth-child(1) { animation-delay: 0.02s; }
    .product-card:nth-child(2) { animation-delay: 0.06s; }
    .product-card:nth-child(3) { animation-delay: 0.10s; }
    .product-card:nth-child(4) { animation-delay: 0.14s; }
    .product-card:nth-child(5) { animation-delay: 0.18s; }
    .product-card:nth-child(6) { animation-delay: 0.22s; }
    .product-card:nth-child(7) { animation-delay: 0.26s; }
    .product-card:nth-child(8) { animation-delay: 0.30s; }
    .product-card:nth-child(9) { animation-delay: 0.34s; }
    .product-card:nth-child(10) { animation-delay: 0.38s; }
    .product-card:nth-child(11) { animation-delay: 0.42s; }
    .product-card:nth-child(12) { animation-delay: 0.46s; }

    @keyframes cardIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
{{-- Hero Banner --}}
<section class="products-hero">
    <div class="hero-badge"><span></span> Our Collection</div>
    <h1>{{ isset($category) ? $category->name : 'All Products' }}</h1>
    @if(isset($category) && $category->description)
        <p>{{ $category->description }}</p>
    @else
        <p>Browse our complete collection of premium personal care and home care products.</p>
    @endif
</section>

{{-- Toolbar: Search + Categories --}}
<div class="products-toolbar">
    <div class="toolbar-inner">
        {{-- Search --}}
        <div class="search-wrap">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" id="liveSearch" value="{{ request('search') }}" placeholder="Search products..." autofocus>
            @if(request('search'))
                <a href="{{ route('products.index') }}"
                   style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: #ffffff; color: #6b7280; border: 1px solid #d1d5db; padding: 0.25rem 0.625rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.75rem; font-weight: 500; transition: background 0.2s;"
                   onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#ffffff'">Clear</a>
            @endif
        </div>

        {{-- Categories --}}
        @if(isset($categories) && $categories->count() > 0)
            <div class="category-chips">
                <span class="label">Categories:</span>
                <a href="{{ route('products.index', request('search') ? ['search' => request('search')] : []) }}"
                   class="chip chip-all {{ !isset($category) ? 'active' : '' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.byCategory', array_merge([$cat->id], request('search') ? ['search' => request('search')] : [])) }}"
                       class="chip chip-cat {{ isset($category) && $category->id === $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Products Grid --}}
<div class="products-container">
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    {{-- Image --}}
                    <a href="{{ route('products.show', $product->id) }}" class="img-wrap">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ $product->image_urls[0] }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="no-image">
                                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Badges --}}
                        <div class="badges">
                            @if($product->discount_percent)
                                <span class="badge badge-discount">-{{ $product->discount_percent }}%</span>
                            @endif
                            @if($product->stock_quantity < 1)
                                <span class="badge badge-out-of-stock">Out of Stock</span>
                            @endif
                        </div>

                        {{-- Quick actions --}}
                        <div class="quick-actions">
                            <a href="{{ route('products.show', $product->id) }}" class="quick-btn" title="View details">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="card-body">
                        <div class="cat-name">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        <a href="{{ route('products.show', $product->id) }}" class="product-name">{{ $product->name }}</a>

                        {{-- Discount notice --}}
                        @if($product->discount_percent && $product->discount_name)
                            <div class="discount-note">{{ $product->discount_name }} ({{ $product->discount_percent }}% OFF)</div>
                        @elseif($product->discount_name && !$product->discount_percent)
                            <div class="discount-note">{{ $product->discount_name }}</div>
                        @elseif($product->discount_percent && !$product->discount_name)
                            <div class="discount-note">{{ $product->discount_percent }}% OFF — Limited Time</div>
                        @endif

                        {{-- Price & Stock --}}
                        <div class="price-stock">
                            <div class="price-area">
                                @if($product->sale_price)
                                    <span class="current-price">{{ currencyFormat($product->final_price) }}</span>
                                    <span class="old-price">{{ currencyFormat($product->sale_price) }}</span>
                                @else
                                    <span class="current-price">{{ currencyFormat($product->price) }}</span>
                                @endif
                            </div>
                            @if($product->stock_quantity > 0)
                                <span class="stock-badge in-stock">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    In Stock
                                </span>
                            @else
                                <span class="stock-badge out-of-stock">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        {{-- Add to Cart --}}
                        <form class="cart-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            @if($product->stock_quantity > 0)
                                <button type="submit" class="atc-btn">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                                    </svg>
                                    Add to Cart
                                </button>
                            @else
                                <button type="button" class="atc-btn sold-out" disabled>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                    Unavailable
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="pagination-wrap">
                {{ $products->links() }}
            </div>
        @endif
    @else
        {{-- Empty state --}}
        <div class="product-grid">
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <h3>No products found</h3>
                <p>{{ isset($category) ? 'No products in this category yet. Check back soon for new arrivals!' : 'Try adjusting your search or browse our categories to find what you need.' }}</p>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Debounced live search
    let debounceTimer;
    const searchInput = document.getElementById('liveSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const val = this.value.trim();
                const url = new URL(window.location.origin + window.location.pathname);
                if (val) url.searchParams.set('search', val);
                window.location.href = url.toString();
            }, 400);
        });
    }
</script>
@endpush
