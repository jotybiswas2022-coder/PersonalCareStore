@extends('frontend.layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    /* ─────────────── BREADCRUMB ─────────────── */
    .breadcrumb-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.25rem 1.5rem 0;
    }
    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
    }
    .breadcrumb a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
        padding: 0.125rem 0;
    }
    .breadcrumb a:hover { color: #2E8B57; }
    .breadcrumb .sep {
        color: #d1d5db;
        font-size: 0.75rem;
    }
    .breadcrumb .current {
        color: #212529;
        font-weight: 500;
    }

    /* ─────────────── PRODUCT LAYOUT ─────────────── */
    .product-main {
        max-width: 1280px;
        margin: 1.5rem auto 0;
        padding: 0 1.5rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
    }

    /* ─────────────── GALLERY ─────────────── */
    .gallery-wrap {
        position: sticky;
        top: 6rem;
    }
    .main-image-wrap {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        overflow: hidden;
        position: relative;
        aspect-ratio: 4 / 3;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .main-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .main-image-wrap:hover img {
        transform: scale(1.05);
    }
    .main-image-wrap .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f9fafb, #f3f4f6);
        color: #d1d5db;
    }
    .main-image-wrap .like-btn {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        z-index: 2;
    }
    .main-image-wrap .like-btn:hover {
        background: #fee2e2;
        color: #ef4444;
        transform: scale(1.1);
    }

    /* Thumbnails */
    .thumbnails {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.5rem;
        margin-top: 0.75rem;
    }
    .thumbnails .thumb {
        border-radius: 0.5rem;
        border: 2px solid transparent;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
        aspect-ratio: 1;
        background: #f9fafb;
    }
    .thumbnails .thumb:hover { border-color: #2E8B57; opacity: 0.8; }
    .thumbnails .thumb.active { border-color: #2E8B57; box-shadow: 0 0 0 2px rgba(46,139,87,0.15); }
    .thumbnails .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumbnails .thumb .no-thumb {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
    }

    /* ─────────────── PRODUCT DETAILS ─────────────── */
    .details-wrap { min-width: 0; }
    .details-wrap .cat-link {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #2E8B57;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.5rem;
        transition: color 0.2s;
    }
    .details-wrap .cat-link:hover { color: #1B5E20; }
    .details-wrap h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #212529;
        line-height: 1.3;
        letter-spacing: -0.02em;
    }
    .details-wrap .brand-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.375rem;
        flex-wrap: wrap;
    }
    .details-wrap .brand {
        font-size: 0.8125rem;
        color: #6b7280;
    }
    .details-wrap .brand span { font-weight: 600; color: #374151; }
    .details-wrap .rating-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #fef9c3;
        color: #854d0e;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.125rem 0.5rem;
        border-radius: 0.25rem;
    }

    /* Price */
    .details-wrap .price-block {
        margin-top: 1.25rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #F0FDF4, #ffffff);
        border-radius: 0.75rem;
        border: 1px solid rgba(46,139,87,0.12);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .details-wrap .price-block .current {
        font-size: 2rem;
        font-weight: 800;
        color: #2E8B57;
        letter-spacing: -0.02em;
    }
    .details-wrap .price-block .old {
        font-size: 1.125rem;
        color: #9ca3af;
        text-decoration: line-through;
    }
    .details-wrap .price-block .discount-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.125rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #dc2626;
        color: #fff;
    }
    .details-wrap .price-block .reg {
        font-size: 2rem;
        font-weight: 800;
        color: #212529;
        letter-spacing: -0.02em;
    }

    /* Stock */
    .details-wrap .stock-row {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .details-wrap .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 500;
    }
    .details-wrap .stock-badge.in {
        background: #f0fdf4;
        color: #166534;
    }
    .details-wrap .stock-badge.out {
        background: #fef2f2;
        color: #dc2626;
    }
    .details-wrap .sku {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-left: auto;
    }

    /* Short description */
    .details-wrap .short-desc {
        margin-top: 1.25rem;
        color: #6b7280;
        font-size: 0.9375rem;
        line-height: 1.7;
    }

    /* Add to cart */
    .details-wrap .cart-form {
        margin-top: 1.5rem;
    }
    .details-wrap .cart-row {
        display: flex;
        gap: 1rem;
        align-items: stretch;
    }
    .details-wrap .qty-wrap {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #ffffff;
    }
    .details-wrap .qty-wrap button {
        width: 2.5rem;
        height: 2.75rem;
        border: none;
        background: #f9fafb;
        color: #374151;
        font-size: 1.125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .details-wrap .qty-wrap button:hover { background: #e5e7eb; }
    .details-wrap .qty-wrap input {
        width: 3rem;
        text-align: center;
        border: none;
        border-left: 1px solid #e5e7eb;
        border-right: 1px solid #e5e7eb;
        height: 2.75rem;
        font-size: 0.9375rem;
        font-weight: 600;
        outline: none;
        -moz-appearance: textfield;
    }
    .details-wrap .qty-wrap input::-webkit-inner-spin-button,
    .details-wrap .qty-wrap input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .details-wrap .atc-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
        border: none;
        padding: 0 2rem;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(46,139,87,0.2);
        text-decoration: none;
    }
    .details-wrap .atc-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(46,139,87,0.3);
    }
    .details-wrap .atc-btn:active { transform: translateY(0); }
    .details-wrap .atc-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* ─────────────── DESCRIPTION TAB ─────────────── */
    .desc-section {
        max-width: 1280px;
        margin: 3rem auto 0;
        padding: 0 1.5rem;
    }
    .desc-section .tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 2rem;
    }
    .desc-section .tabs button {
        padding: 0.75rem 1.5rem;
        border: none;
        background: none;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
    }
    .desc-section .tabs button:hover { color: #374151; }
    .desc-section .tabs button.active {
        color: #2E8B57;
        border-bottom-color: #2E8B57;
    }
    .desc-section .tab-content {
        display: none;
    }
    .desc-section .tab-content.active {
        display: block;
    }
    .desc-section .tab-content p {
        color: #374151;
        line-height: 1.8;
        font-size: 0.9375rem;
    }

    /* ─────────────── REVIEWS ─────────────── */
    .reviews-section {
        max-width: 1280px;
        margin: 3rem auto 0;
        padding: 0 1.5rem;
    }
    .reviews-section .section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .reviews-section .section-title h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
    }
    .reviews-section .section-title .avg-rating {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fef9c3;
        padding: 0.375rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #854d0e;
    }
    .reviews-section .section-title .avg-rating svg { color: #eab308; }

    .review-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: box-shadow 0.2s;
    }
    .review-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .review-card .review-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .review-card .reviewer-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .review-card .avatar {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2E8B57;
        font-size: 0.8125rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .review-card .reviewer-name {
        font-weight: 600;
        color: #212529;
        font-size: 0.9375rem;
    }
    .review-card .reviewer-name small {
        font-weight: 400;
        color: #9ca3af;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    .review-card .stars {
        display: flex;
        gap: 0.125rem;
        margin-top: 0.25rem;
    }
    .review-card .stars svg { width: 0.875rem; height: 0.875rem; }
    .review-card .stars .filled { color: #eab308; }
    .review-card .stars .empty { color: #e5e7eb; }
    .review-card .review-title {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-left: 0.375rem;
    }
    .review-card .review-body {
        margin-top: 0.75rem;
        color: #6b7280;
        line-height: 1.6;
        font-size: 0.875rem;
    }
    .review-card .review-image {
        margin-top: 0.75rem;
    }
    .review-card .review-image img {
        max-width: 12rem;
        max-height: 8rem;
        border-radius: 0.5rem;
        object-fit: cover;
        border: 1px solid #e9ecef;
    }
    .review-card .admin-reply {
        margin-top: 1rem;
        padding: 1rem 1.25rem;
        background: #F0FDF4;
        border-radius: 0.5rem;
        border-left: 3px solid #2E8B57;
    }
    .review-card .admin-reply .label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #166534;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .review-card .admin-reply .text {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.5;
    }
    .no-reviews {
        text-align: center;
        padding: 4rem 2rem;
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
    }
    .no-reviews .icon {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 1rem;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }
    .no-reviews h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }
    .no-reviews p { color: #6b7280; font-size: 0.875rem; }

    /* ─────────────── RELATED PRODUCTS ─────────────── */
    .related-section {
        max-width: 1280px;
        margin: 3rem auto 4rem;
        padding: 0 1.5rem;
    }
    .related-section .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .related-section .section-header h2 {
        font-size: 1.625rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: -0.02em;
    }
    .related-section .section-header a {
        font-size: 0.875rem;
        color: #2E8B57;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        transition: color 0.2s;
    }
    .related-section .section-header a:hover { color: #1B5E20; }
    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    .related-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
    }
    .related-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.1);
        border-color: rgba(46,139,87,0.25);
    }
    .related-card .img-wrap {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #f9fafb;
        display: block;
    }
    .related-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .related-card:hover .img-wrap img { transform: scale(1.1); }
    .related-card .img-wrap .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
    }
    .related-card .img-wrap .r-badges {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        z-index: 2;
    }
    .related-card .img-wrap .r-badge {
        display: inline-flex;
        padding: 0.125rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .r-badge.discount { background: #dc2626; color: #fff; }
    .r-badge.sold-out { background: #6b7280; color: #fff; }
    .related-card .info {
        padding: 0.875rem 1rem 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .related-card .info .r-cat {
        font-size: 0.6875rem;
        font-weight: 500;
        color: #2E8B57;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.25rem;
    }
    .related-card .info .name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #212529;
        text-decoration: none;
        transition: color 0.2s;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.35;
        min-height: 2.4em;
    }
    .related-card .info .name:hover { color: #2E8B57; }
    .related-card .info .r-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.375rem;
        flex-wrap: wrap;
    }
    .related-card .info .r-rating {
        display: inline-flex;
        align-items: center;
        gap: 0.125rem;
        font-size: 0.6875rem;
        color: #eab308;
    }
    .related-card .info .r-stock {
        font-size: 0.625rem;
        font-weight: 500;
    }
    .related-card .info .r-stock.in { color: #166534; }
    .related-card .info .r-stock.out { color: #dc2626; }
    .related-card .info .r-price {
        margin-top: auto;
        padding-top: 0.625rem;
        display: flex;
        align-items: baseline;
        gap: 0.375rem;
        flex-wrap: wrap;
    }
    .related-card .info .r-price .current {
        font-size: 1.0625rem;
        font-weight: 700;
        color: #2E8B57;
    }
    .related-card .info .r-price .old {
        font-size: 0.75rem;
        color: #9ca3af;
        text-decoration: line-through;
    }
    .related-card .info .r-atc {
        margin-top: 0.625rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        background: linear-gradient(135deg, #FFD166, #F0C14B);
        color: #212529;
        border: none;
        padding: 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .related-card .info .r-atc:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(255,209,102,0.35);
    }
    .related-card .info .r-atc.sold-out {
        background: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
        pointer-events: none;
    }
    .related-card .info .r-atc svg {
        width: 12px;
        height: 12px;
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1100px) {
        .related-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 900px) {
        .product-main { grid-template-columns: 1fr; gap: 2rem; }
        .related-grid { grid-template-columns: repeat(3, 1fr); }
        .gallery-wrap { position: static; }
        .main-image-wrap { aspect-ratio: 4 / 3; }
        .details-wrap h1 { font-size: 1.375rem; }
        .details-wrap .price-block .current,
        .details-wrap .price-block .reg { font-size: 1.5rem; }
    }
    @media (max-width: 640px) {
        .breadcrumb-wrap { padding: 1rem 1rem 0; }
        .product-main { padding: 0 1rem; margin-top: 1rem; }
        .details-wrap .price-block { padding: 1rem; }
        .details-wrap .price-block .current,
        .details-wrap .price-block .reg { font-size: 1.25rem; }
        .details-wrap .cart-row { flex-direction: column; }
        .details-wrap .atc-btn { padding: 0.75rem; }
        .desc-section { margin-top: 2rem; padding: 0 1rem; }
        .reviews-section { padding: 0 1rem; }
        .related-section { padding: 0 1rem; }
        .related-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    }
    @media (max-width: 480px) {
        .related-grid { grid-template-columns: repeat(2, 1fr); gap: 0.625rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    .product-main {
        animation: fadeUp 0.4s ease-out;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div class="breadcrumb-wrap">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="sep">›</span>
        <a href="{{ route('products.index') }}">Products</a>
        @if($product->category)
            <span class="sep">›</span>
            <a href="{{ route('products.byCategory', $product->category_id) }}">{{ $product->category->name }}</a>
        @endif
        <span class="sep">›</span>
        <span class="current">{{ $product->name }}</span>
    </nav>
</div>

{{-- Product Main Section --}}
<div class="product-main">
    {{-- Gallery --}}
    <div class="gallery-wrap">
        <div class="main-image-wrap">
            @if($product->images && count($product->images) > 0)
                <img id="mainImage" src="{{ $product->image_urls[0] }}" alt="{{ $product->name }}">
                <button class="like-btn" title="Add to wishlist">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                    </svg>
                </button>
            @else
                <div class="no-image">
                    <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        @if($product->images && count($product->images) > 1)
            <div class="thumbnails" id="thumbnails">
                @foreach($product->images as $index => $image)
                    <div class="thumb {{ $index === 0 ? 'active' : '' }}" onclick="changeImage(this, '{{ config('app.storage_url') . ltrim(preg_replace('#^storage/#', '', $image), '/') }}')">
                        <img src="{{ config('app.storage_url') . ltrim(preg_replace('#^storage/#', '', $image), '/') }}" alt="{{ $product->name }}">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Details --}}
    <div class="details-wrap">
        @if($product->category)
            <a href="{{ route('products.byCategory', $product->category_id) }}" class="cat-link">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                {{ $product->category->name }}
            </a>
        @endif

        <h1>{{ $product->name }}</h1>

        <div class="brand-row">
            @if($product->brand)
                <p class="brand">by <span>{{ $product->brand }}</span></p>
            @endif
            <span class="rating-badge">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                {{ number_format($product->reviews->avg('rating') ?? 0, 1) }}
            </span>
        </div>

        {{-- Price --}}
        <div class="price-block">
            @if($product->sale_price)
                @if($product->discount_percent)
                    <span class="current">{{ currencyFormat($product->final_price) }}</span>
                    <span class="old">{{ currencyFormat($product->sale_price) }}</span>
                    <span class="discount-badge">-{{ $product->discount_percent }}%</span>
                @else
                    <span class="current">{{ currencyFormat($product->sale_price) }}</span>
                    <span class="old">{{ currencyFormat($product->price) }}</span>
                @endif
            @else
                <span class="reg">{{ currencyFormat($product->price) }}</span>
            @endif
        </div>

        {{-- Stock Status --}}
        <div class="stock-row">
            @if($product->stock_quantity > 0)
                <span class="stock-badge in">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    In Stock ({{ $product->stock_quantity }} available)
                </span>
            @else
                <span class="stock-badge out">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Out of Stock
                </span>
            @endif
            @if($product->sku)
                <span class="sku">SKU: {{ $product->sku }}</span>
            @endif
        </div>

        {{-- Short Description --}}
        @if($product->short_description)
            <p class="short-desc">{{ $product->short_description }}</p>
        @endif

        {{-- Add to Cart --}}
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-form">
            @csrf
            <div class="cart-row">
                <div class="qty-wrap">
                    <button type="button" onclick="decrementQty()" aria-label="Decrease quantity">−</button>
                    <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ min($product->stock_quantity, 99) }}" readonly>
                    <button type="button" onclick="incrementQty()" aria-label="Increase quantity">+</button>
                </div>
                <button type="submit" class="atc-btn" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                    </svg>
                    Add to Cart
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabs: Description / Details --}}
@if($product->description)
    <div class="desc-section">
        <div class="tabs">
            <button class="active" onclick="switchTab(this, 'desc')">Description</button>
        </div>
        <div class="tab-content active" id="tab-desc">
            <p>{{ $product->description }}</p>
        </div>
    </div>
@endif

{{-- Reviews --}}
<div class="reviews-section">
    <div class="section-title">
        <h2>Customer Reviews ({{ $product->reviews->count() }})</h2>
        @if($product->reviews->count() > 0)
            <span class="avg-rating">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                {{ number_format($product->reviews->avg('rating'), 1) }} / 5
            </span>
        @endif
    </div>

    @if($product->reviews->count() > 0)
        @foreach($product->reviews as $review)
            <div class="review-card">
                <div class="review-top">
                    <div class="reviewer-info">
                        <div class="avatar">{{ strtoupper(substr($review->guest_name ?? $review->user->name ?? 'A', 0, 1)) }}</div>
                        <div>
                            <p class="reviewer-name">
                                {{ $review->guest_name ?? $review->user->name ?? 'Anonymous' }}
                                <small>{{ $review->created_at->diffForHumans() }}</small>
                            </p>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="{{ $i <= $review->rating ? 'filled' : 'empty' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                @if($review->title)
                                    <span class="review-title">- {{ $review->title }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <p class="review-body">{{ $review->body }}</p>

                @if($review->image)
                    <div class="review-image">
                        <img src="{{ $review->image_url }}" alt="Review image">
                    </div>
                @endif

                @if($review->admin_reply)
                    <div class="admin-reply">
                        <p class="label">Store Response</p>
                        <p class="text">{{ $review->admin_reply }}</p>
                    </div>
                @elseif(auth()->check() && auth()->user()->is_admin)
                    <div class="admin-reply" style="background: #F8F9FA; border-left-color: #2E8B57;">
                        <p class="label" style="color: #2E8B57;">Reply as Store</p>
                        <form method="POST" action="{{ route('reviews.reply', $review->id) }}" style="margin-top: 0.5rem;">
                            @csrf
                            <textarea name="admin_reply" rows="2" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8125rem; outline: none; resize: vertical; transition: border-color 0.2s;" placeholder="Write your reply..." onfocus="this.style.borderColor='#2E8B57'" onblur="this.style.borderColor='#d1d5db'"></textarea>
                            <button type="submit" style="margin-top: 0.375rem; background: linear-gradient(135deg, #2E8B57, #3CB371); color: #fff; border: none; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 2px 6px rgba(46,139,87,0.3)'" onmouseout="this.style.boxShadow='none'">Send Reply</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="no-reviews">
            <div class="icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                </svg>
            </div>
            <h3>No reviews yet</h3>
            <p>Be the first to share your thoughts on this product!</p>
        </div>
    @endif
</div>

{{-- Related Products --}}
@if($relatedProducts->count() > 0)
    <div class="related-section">
        <div class="section-header">
            <h2>You May Also Like</h2>
            <a href="{{ route('products.index') }}">
                View All
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="related-grid">
            @foreach($relatedProducts as $related)
                <div class="related-card">
                    <a href="{{ route('products.show', $related->id) }}" class="img-wrap">
                        @if($related->images && count($related->images) > 0)
                            <img src="{{ $related->image_urls[0] }}" alt="{{ $related->name }}" loading="lazy">
                        @else
                            <div class="no-image">
                                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Badges --}}
                        <div class="r-badges">
                            @if($related->discount_percent)
                                <span class="r-badge discount">-{{ $related->discount_percent }}%</span>
                            @endif
                            @if($related->stock_quantity < 1)
                                <span class="r-badge sold-out">Sold Out</span>
                            @endif
                        </div>
                    </a>
                    <div class="info">
                        <div class="r-cat">{{ $related->category->name ?? 'Uncategorized' }}</div>
                        <a href="{{ route('products.show', $related->id) }}" class="name">{{ $related->name }}</a>

                        {{-- Meta row --}}
                        <div class="r-meta">
                            <span class="r-rating">
                                <svg width="10" height="10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ number_format($related->reviews->avg('rating') ?? 0, 1) }}
                            </span>
                            @if($related->stock_quantity > 0)
                                <span class="r-stock in">● In Stock</span>
                            @else
                                <span class="r-stock out">● Out of Stock</span>
                            @endif
                        </div>

                        {{-- Price --}}
                        <div class="r-price">
                            @if($related->sale_price)
                                <span class="current">{{ currencyFormat($related->final_price) }}</span>
                                <span class="old">{{ currencyFormat($related->sale_price) }}</span>
                            @else
                                <span class="current">{{ currencyFormat($related->price) }}</span>
                            @endif
                        </div>

                        {{-- Add to Cart --}}
                        <form action="{{ route('cart.add', $related->id) }}" method="POST">
                            @csrf
                            @if($related->stock_quantity > 0)
                                <button type="submit" class="r-atc">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                                    Add to Cart
                                </button>
                            @else
                                <button type="button" class="r-atc sold-out" disabled>Unavailable</button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // ── Thumbnail switcher ──
    function changeImage(el, src) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('#thumbnails .thumb').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    // ── Quantity control ──
    function decrementQty() {
        const input = document.getElementById('qtyInput');
        const val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    }
    function incrementQty() {
        const input = document.getElementById('qtyInput');
        const max = parseInt(input.max) || 99;
        const val = parseInt(input.value) || 1;
        if (val < max) input.value = val + 1;
    }

    // ── Tab switcher ──
    function switchTab(btn, tabId) {
        document.querySelectorAll('.tabs button').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>
@endpush
