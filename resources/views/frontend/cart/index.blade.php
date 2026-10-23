@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@push('styles')
<style>
    /* ═══════════════ TOKENS ═══════════════ */
    .cart-page {
        --ink: #10261A;
        --muted: #617067;
        --green: #2E8B57;
        --green-deep: #17603C;
        --gold: #FFD166;
        --mint: #9DF3BE;
        --line: #E4EEE8;
        --surface: #FFFFFF;
        --ease: cubic-bezier(0.22, 1, 0.36, 1);

        background: #F6FAF7;
        padding-bottom: 4.5rem;
    }

    /* ═══════════════ HERO ═══════════════ */
    .cart-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 3rem 1.5rem 3.25rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 400px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            radial-gradient(520px 320px at 0% 100%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .cart-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.032) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.032) 1px, transparent 1px);
        background-size: 76px 76px;
        -webkit-mask-image: radial-gradient(circle at 50% 40%, #000 0%, transparent 78%);
        mask-image: radial-gradient(circle at 50% 40%, #000 0%, transparent 78%);
        pointer-events: none;
    }
    .cart-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .cart-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3125rem 0.75rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #FFE6A8;
        animation: cartIn 0.6s var(--ease) both;
    }
    .cart-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #7BF1A8;
        flex-shrink: 0;
    }
    .cart-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(123,241,168,0.55);
        animation: cartPulse 2.4s ease-out infinite;
    }
    .cart-hero h1 {
        font-size: clamp(1.875rem, 3.4vw, 2.75rem);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.045em;
        color: #FFFFFF;
        animation: cartIn 0.7s var(--ease) 0.06s both;
    }
    .cart-hero h1 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.02em;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 45%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.06em;
    }
    .count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.375rem 0.8125rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: rgba(233,247,238,0.85);
        font-size: 0.8125rem;
        font-weight: 500;
        animation: cartIn 0.7s var(--ease) 0.12s both;
    }
    .count-badge svg { color: var(--mint); flex-shrink: 0; }

    /* ═══════════════ ALERTS ═══════════════ */
    .alert-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 0;
    }
    .alert {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8125rem 0.9375rem;
        border-radius: 0.875rem;
        font-size: 0.875rem;
        line-height: 1.5;
        animation: cartSlide 0.3s var(--ease);
    }
    .alert svg { flex-shrink: 0; }
    .alert-success {
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: #166534;
    }
    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #B91C1C;
    }

    /* ═══════════════ LAYOUT ═══════════════ */
    .cart-layout {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2.25rem 1.5rem 0;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 2rem;
        align-items: start;
    }

    /* ═══════════════ ITEMS ═══════════════ */
    .cart-items-wrap {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        min-width: 0;
    }
    .cart-item {
        padding: 1.125rem 1.25rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.25rem;
        transition: border-color 0.3s ease, box-shadow 0.4s var(--ease), transform 0.4s var(--ease);
        animation: cartItemIn 0.5s var(--ease) backwards;
    }
    .cart-item:nth-child(1) { animation-delay: 0.03s; }
    .cart-item:nth-child(2) { animation-delay: 0.07s; }
    .cart-item:nth-child(3) { animation-delay: 0.11s; }
    .cart-item:nth-child(4) { animation-delay: 0.15s; }
    .cart-item:nth-child(5) { animation-delay: 0.19s; }
    .cart-item:hover {
        border-color: #CFE9DA;
        box-shadow: 0 26px 48px -40px rgba(10,60,38,0.55);
        transform: translateY(-2px);
    }
    .cart-item .row {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        flex-wrap: wrap;
    }

    /* Thumb */
    .cart-item .thumb {
        width: 5.5rem;
        height: 5.5rem;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 1rem;
        border: 1px solid var(--line);
        background: radial-gradient(circle at 50% 30%, #FFFFFF 0%, #EAF9EF 60%, #D8F2E2 100%);
    }
    .cart-item .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s var(--ease);
    }
    .cart-item:hover .thumb img { transform: scale(1.06); }
    .cart-item .thumb .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #C3D4C9;
    }

    /* Info */
    .cart-item .item-info { flex: 1; min-width: 0; }
    .cart-item .item-name {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.35;
        letter-spacing: -0.015em;
        color: var(--ink);
        text-decoration: none;
        transition: color 0.25s var(--ease);
    }
    .cart-item .item-name:hover { color: var(--green-deep); }
    .cart-item .item-price {
        margin-top: 0.25rem;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .cart-item .discount-note {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.3125rem;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #166534;
    }
    .cart-item .low-stock {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.3125rem;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #8A5B00;
    }
    .cart-item .low-stock svg { flex-shrink: 0; }

    /* Quantity */
    .cart-item .qty-area { text-align: center; }
    .cart-item .qty-control {
        display: flex;
        align-items: center;
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 0.875rem;
        background: var(--surface);
        box-shadow: 0 12px 24px -24px rgba(10,60,38,0.65);
    }
    .cart-item .qty-control button {
        width: 2.25rem;
        height: 2.375rem;
        border: none;
        background: transparent;
        color: var(--ink);
        font-size: 1rem;
        font-weight: 600;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.25s var(--ease), color 0.25s var(--ease);
    }
    .cart-item .qty-control button:hover:not(:disabled) {
        background: #EDF9F2;
        color: var(--green-deep);
    }
    .cart-item .qty-control button:disabled { color: #C3D4C9; cursor: not-allowed; }
    .cart-item .qty-control span {
        width: 2.5rem;
        border-left: 1px solid var(--line);
        border-right: 1px solid var(--line);
        background: #F6FAF7;
        text-align: center;
        line-height: 2.375rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: var(--ink);
    }
    .cart-item .stock-label {
        margin-top: 0.3125rem;
        font-size: 0.625rem;
        letter-spacing: 0.04em;
        color: #93A39A;
    }

    /* Subtotal / remove */
    .cart-item .subtotal-area {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.375rem;
        min-width: 5.5rem;
        text-align: right;
    }
    .cart-item .item-subtotal {
        font-size: 1.125rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--ink);
    }
    .cart-item .remove-btn {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 50%;
        background: transparent;
        color: #B4C6BB;
        cursor: pointer;
        transition: color 0.25s var(--ease), background 0.25s var(--ease), border-color 0.25s var(--ease);
    }
    .cart-item .remove-btn:hover {
        color: #E11D48;
        background: #FEF2F2;
        border-color: #FBD5D5;
    }

    /* ═══════════════ SUMMARY ═══════════════ */
    .summary-card {
        position: sticky;
        top: 5.5rem;
        padding: 1.75rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 34px 64px -52px rgba(10,60,38,0.55);
        animation: cartItemIn 0.55s var(--ease) 0.12s backwards;
    }
    .summary-card h2 {
        margin-bottom: 1.125rem;
        padding-bottom: 0.875rem;
        border-bottom: 1px solid var(--line);
        font-size: 1.125rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--ink);
    }
    .summary-card .delivery-label {
        display: block;
        margin-bottom: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--muted);
    }
    .summary-card .delivery-select {
        width: 100%;
        padding: 0.6875rem 0.875rem;
        border: 1px solid var(--line);
        border-radius: 0.75rem;
        background: #F6FAF7;
        font-family: inherit;
        font-size: 0.8125rem;
        color: var(--ink);
        outline: none;
        cursor: pointer;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease);
    }
    .summary-card .delivery-select:focus {
        border-color: #7BCB9B;
        background: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.10);
    }
    .summary-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.875rem;
    }
    .summary-row .label { color: var(--muted); }
    .summary-row .value { font-weight: 700; color: var(--ink); }
    .summary-divider {
        border: none;
        border-top: 1px solid var(--line);
        margin: 0.75rem 0;
    }
    .summary-note {
        margin-top: 0.375rem;
        font-size: 0.75rem;
        line-height: 1.5;
        color: #93A39A;
    }

    .checkout-btn {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        height: 3rem;
        margin-top: 1rem;
        border: none;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.9375rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 14px 34px -14px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .checkout-btn::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.75) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.75s var(--ease);
        pointer-events: none;
    }
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .checkout-btn:hover::after { transform: translateX(420%) rotate(12deg); }
    .checkout-btn svg { transition: transform 0.3s var(--ease); }
    .checkout-btn:hover svg { transform: translateX(3px); }

    .continue-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        margin-top: 0.875rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--green-deep);
        text-decoration: none;
        transition: color 0.25s var(--ease), gap 0.25s var(--ease);
    }
    .continue-link:hover { color: var(--ink); gap: 0.625rem; }

    .summary-secure {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        margin-top: 1rem;
        padding-top: 0.875rem;
        border-top: 1px solid var(--line);
        font-size: 0.6875rem;
        color: #93A39A;
    }
    .summary-secure svg { color: var(--green); flex-shrink: 0; }

    /* ═══════════════ EMPTY STATE ═══════════════ */
    .empty-cart {
        grid-column: 1 / -1;
        padding: 4.5rem 2rem;
        text-align: center;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        animation: cartItemIn 0.5s var(--ease) backwards;
    }
    .empty-cart .empty-icon {
        width: 4.5rem;
        height: 4.5rem;
        margin: 0 auto 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1.25rem;
        background: linear-gradient(135deg, #EDF9F2, #D9F2E3);
        border: 1px solid #D6F0E0;
        color: var(--green);
        animation: cartFloat 6s ease-in-out infinite;
    }
    .empty-cart h2 {
        font-size: 1.375rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--ink);
        margin-bottom: 0.375rem;
    }
    .empty-cart p {
        max-width: 24rem;
        margin: 0 auto 1.5rem;
        font-size: 0.875rem;
        line-height: 1.65;
        color: var(--muted);
    }
    .empty-cart .shop-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 34px -14px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .empty-cart .shop-btn::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.75) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.75s var(--ease);
        pointer-events: none;
    }
    .empty-cart .shop-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .empty-cart .shop-btn:hover::after { transform: translateX(420%) rotate(12deg); }
    .empty-cart .shop-btn svg { transition: transform 0.3s var(--ease); }
    .empty-cart .shop-btn:hover svg { transform: translateX(3px); }

    /* ═══════════════ RESPONSIVE ═══════════════ */
    @media (max-width: 1024px) {
        .cart-layout { grid-template-columns: minmax(0, 1fr) 330px; gap: 1.5rem; }
    }
    @media (max-width: 900px) {
        .cart-layout { grid-template-columns: 1fr; padding-top: 1.75rem; }
        .summary-card { position: static; }
    }
    @media (max-width: 640px) {
        .cart-hero { padding: 2.25rem 1.25rem 2.5rem; }
        .cart-layout { padding: 1.5rem 1rem 0; }
        .alert-wrap { padding: 1.25rem 1rem 0; }
        .cart-item { padding: 1rem; }
        .cart-item .row { gap: 0.875rem; }
        .cart-item .thumb { width: 4.25rem; height: 4.25rem; border-radius: 0.875rem; }
        .cart-item .item-name { font-size: 0.9375rem; }
        .cart-item .subtotal-area { min-width: 0; margin-left: auto; }
        .cart-item .item-subtotal { font-size: 1rem; }
        .cart-item .stock-label { display: none; }
        .summary-card { padding: 1.375rem; border-radius: 1.25rem; }
        .empty-cart { padding: 3.25rem 1.5rem; }
        .empty-cart h2 { font-size: 1.25rem; }
    }

    /* ═══════════════ ANIMATION ═══════════════ */
    @keyframes cartIn {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes cartItemIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes cartSlide {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes cartPulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @keyframes cartFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .cart-eyebrow,
        .cart-hero h1,
        .count-badge,
        .alert,
        .cart-item,
        .summary-card,
        .empty-cart,
        .empty-cart .empty-icon {
            animation: none !important;
        }
        .cart-eyebrow .pulse::after { animation: none !important; }
        .cart-item,
        .cart-item .thumb img,
        .checkout-btn,
        .checkout-btn::after,
        .checkout-btn svg,
        .empty-cart .shop-btn,
        .empty-cart .shop-btn::after,
        .empty-cart .shop-btn svg {
            transition: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="cart-page">
    {{-- Hero --}}
    <section class="cart-hero">
        <div class="cart-hero-inner">
            <span class="cart-eyebrow">
                <span class="pulse" aria-hidden="true"></span>
                Your bag
            </span>
            <h1>Shopping <em>cart</em></h1>
            <div class="count-badge">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
                {{ $cartItems->count() }} {{ $cartItems->count() === 1 ? 'item' : 'items' }} in your cart
            </div>
        </div>
    </section>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-wrap">
            <div class="alert alert-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-wrap">
            <div class="alert alert-error">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="cart-layout">
            {{-- Items --}}
            <div class="cart-items-wrap">
                @foreach($cartItems as $item)
                    <div class="cart-item" id="cart-item-{{ $item->id }}">
                        <div class="row">
                            {{-- Thumb --}}
                            <div class="thumb">
                                @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ $item->product->image_urls[0] }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="no-img">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="item-info">
                                <a href="{{ route('products.show', $item->product_id) }}" class="item-name">{{ $item->product->name }}</a>
                                <p class="item-price">{{ currencyFormat($item->product->final_price) }} each</p>
                                @if($item->product->discount_percent && $item->product->discount_name)
                                    <p class="discount-note">{{ $item->product->discount_name }} ({{ $item->product->discount_percent }}% OFF)</p>
                                @elseif($item->product->discount_name)
                                    <p class="discount-note">{{ $item->product->discount_name }}</p>
                                @elseif($item->product->sale_price && $item->product->discount_percent)
                                    <p class="discount-note">{{ $item->product->discount_percent }}% OFF &mdash; Was {{ currencyFormat($item->product->sale_price) }}</p>
                                @endif
                                @if($item->product->stock_quantity < 5)
                                    <p class="low-stock">
                                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        Only {{ $item->product->stock_quantity }} left in stock
                                    </p>
                                @endif
                            </div>

                            {{-- Quantity --}}
                            <div class="qty-area">
                                <div class="qty-control" data-cart-id="{{ $item->id }}" data-stock="{{ $item->product->stock_quantity }}">
                                    <button type="button" class="qty-minus" aria-label="Decrease quantity" {{ $item->quantity <= 1 ? 'disabled' : '' }}>&minus;</button>
                                    <span class="qty-value">{{ $item->quantity }}</span>
                                    <button type="button" class="qty-plus" aria-label="Increase quantity" {{ $item->quantity >= $item->product->stock_quantity ? 'disabled' : '' }}>+</button>
                                </div>
                                <div class="stock-label">Stock: {{ $item->product->stock_quantity }}</div>
                            </div>

                            {{-- Subtotal + Remove --}}
                            <div class="subtotal-area">
                                <p class="item-subtotal" id="subtotal-{{ $item->id }}">{{ currencyFormat($item->product->final_price * $item->quantity) }}</p>
                                <button type="button" class="remove-btn" onclick="removeItem({{ $item->id }})" title="Remove item" aria-label="Remove {{ $item->product->name }}">
                                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <aside class="summary-card">
                <h2>Order summary</h2>

                <div style="margin-bottom: 0.875rem;">
                    <label for="deliveryArea" class="delivery-label">Delivery area</label>
                    <select id="deliveryArea" onchange="setDeliveryArea(this.value)" class="delivery-select">
                        <option value="inside" {{ session('delivery_area', 'inside') === 'inside' ? 'selected' : '' }}>Inside Khulna</option>
                        <option value="outside" {{ session('delivery_area') === 'outside' ? 'selected' : '' }}>Outside Khulna</option>
                    </select>
                </div>

                <div class="summary-row">
                    <span class="label">Subtotal</span>
                    <span class="value" id="cartSubtotal">{{ currencyFormat($subtotal) }}</span>
                </div>
                <p class="summary-note">Delivery charge is confirmed on the checkout page.</p>

                <hr class="summary-divider">

                <a href="{{ route('checkout.index') }}" class="checkout-btn">
                    Proceed to checkout
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('products.index') }}" class="continue-link">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Continue shopping
                </a>

                <div class="summary-secure">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    Secure checkout &middot; protected payments
                </div>
            </aside>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const csrfToken = '{{ csrf_token() }}';
            const updateUrl = '{{ route("cart.update", "_id_") }}';
            const removeUrl = '{{ route("cart.remove", "_id_") }}';

            function setDeliveryArea(area) {
                fetch('{{ route("cart.deliveryArea") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ area: area })
                });
            }

            document.addEventListener('click', function (e) {
                const container = e.target.closest('.qty-control');
                if (!container) return;

                const cartId = container.dataset.cartId;
                const stock = parseInt(container.dataset.stock);
                const span = container.querySelector('.qty-value');
                let qty = parseInt(span.textContent);
                const isPlus = e.target.closest('.qty-plus');
                const isMinus = e.target.closest('.qty-minus');
                if (!isPlus && !isMinus) return;

                if (isPlus) { if (qty >= stock) return; qty++; }
                else { if (qty <= 1) return; qty--; }

                updateQuantity(cartId, qty, container, span, stock);
            });

            async function updateQuantity(cartId, qty, container, span, stock) {
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('quantity', qty);

                try {
                    const res = await fetch(updateUrl.replace('_id_', cartId), {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });
                    const data = await res.json();

                    if (data.removed) {
                        const item = document.getElementById('cart-item-' + cartId);
                        item.style.transition = 'opacity 0.3s, transform 0.3s';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(20px)';
                        setTimeout(() => { item.remove(); updateCartSummary(data); }, 300);
                        return;
                    }
                    if (data.error) {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: data.error });
                        return;
                    }

                    span.textContent = qty;
                    container.querySelector('.qty-minus').disabled = qty <= 1;
                    container.querySelector('.qty-plus').disabled = qty >= stock;

                    const subtotalEl = document.getElementById('subtotal-' + cartId);
                    if (subtotalEl) subtotalEl.textContent = data.subtotal;

                    const summaryValue = document.getElementById('cartSubtotal');
                    if (summaryValue) summaryValue.textContent = data.cartSubtotal;
                } catch (err) {
                    console.error('Cart update failed', err);
                }
            }

            async function removeItem(cartId) {
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('_method', 'DELETE');

                const item = document.getElementById('cart-item-' + cartId);
                if (!item) return;

                item.style.transition = 'opacity 0.3s, transform 0.3s';
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';

                try {
                    const res = await fetch(removeUrl.replace('_id_', cartId), {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });
                    const data = await res.json();
                    item.remove();
                    updateCartSummary(data);
                } catch (err) {
                    item.style.opacity = '1';
                    item.style.transform = 'none';
                }
            }

            function updateCartSummary(data) {
                const summaryValue = document.getElementById('cartSubtotal');
                if (summaryValue && data.cartSubtotal) summaryValue.textContent = data.cartSubtotal;

                const heroBadge = document.querySelector('.count-badge');
                if (heroBadge && data.itemCount !== undefined) {
                    heroBadge.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg> ' + data.itemCount + ' ' + (data.itemCount === 1 ? 'item' : 'items') + ' in your cart';
                }

                if (data.empty) {
                    const layout = document.querySelector('.cart-layout');
                    if (layout) {
                        layout.innerHTML =
                            '<div class="empty-cart">' +
                                '<div class="empty-icon">' +
                                    '<svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>' +
                                '</div>' +
                                '<h2>Your cart is empty</h2>' +
                                '<p>Looks like you haven\'t added anything yet. Browse the collection and find something you love.</p>' +
                                '<a href="{{ route("products.index") }}" class="shop-btn">Start shopping <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M4 12h15m0 0l-6-6m6 6l-6 6"/></svg></a>' +
                            '</div>';
                    }
                }
            }
        </script>
        @endpush
    @else
        <div class="cart-layout">
            <div class="empty-cart">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                </div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added anything yet. Browse the collection and find something you love.</p>
                <a href="{{ route('products.index') }}" class="shop-btn">
                    Start shopping
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M4 12h15m0 0l-6-6m6 6l-6 6"/></svg>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
