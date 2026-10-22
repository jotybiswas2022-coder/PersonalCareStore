@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@push('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .cart-hero {
        background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 50%, #FEFCE8 100%);
        padding: 2.5rem 1.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .cart-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .cart-hero h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: -0.02em;
        position: relative;
    }
    .cart-hero .count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: rgba(46,139,87,0.10);
        color: #2E8B57;
        font-size: 0.8125rem;
        font-weight: 600;
        padding: 0.375rem 1rem;
        border-radius: 9999px;
        margin-top: 0.5rem;
        border: 1px solid rgba(46,139,87,0.15);
        position: relative;
    }

    /* ─────────────── ALERTS ─────────────── */
    .alert-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.25rem 1.5rem 0;
    }
    .alert {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        animation: slideDown 0.3s ease-out;
    }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

    /* ─────────────── LAYOUT ─────────────── */
    .cart-layout {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 4rem;
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 2rem;
        align-items: start;
    }

    /* ─────────────── CART ITEMS ─────────────── */
    .cart-items-wrap {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        animation: fadeUp 0.4s ease-out;
    }
    .cart-item {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s;
        animation: fadeUp 0.4s ease-out both;
    }
    .cart-item:nth-child(1) { animation-delay: 0.02s; }
    .cart-item:nth-child(2) { animation-delay: 0.06s; }
    .cart-item:nth-child(3) { animation-delay: 0.10s; }
    .cart-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .cart-item .row {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        flex-wrap: wrap;
    }
    .cart-item .thumb {
        width: 5.5rem;
        height: 5.5rem;
        border-radius: 0.625rem;
        overflow: hidden;
        flex-shrink: 0;
        background: #f9fafb;
        border: 1px solid #e9ecef;
    }
    .cart-item .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cart-item .thumb .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
    }

    /* Item details */
    .cart-item .item-info {
        flex: 1;
        min-width: 0;
    }
    .cart-item .item-name {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        text-decoration: none;
        transition: color 0.2s;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cart-item .item-name:hover { color: #2E8B57; }
    .cart-item .item-price {
        font-size: 0.8125rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    .cart-item .discount-note {
        font-size: 0.6875rem;
        color: #dc2626;
        font-weight: 500;
        margin-top: 0.125rem;
    }
    .cart-item .low-stock {
        font-size: 0.6875rem;
        color: #ea580c;
        font-weight: 500;
        margin-top: 0.125rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Quantity control */
    .cart-item .qty-area {
        text-align: center;
    }
    .cart-item .qty-control {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #ffffff;
    }
    .cart-item .qty-control button {
        width: 2.125rem;
        height: 2.125rem;
        border: none;
        background: #f9fafb;
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
    }
    .cart-item .qty-control button:hover:not(:disabled) { background: #e5e7eb; }
    .cart-item .qty-control button:disabled { color: #d1d5db; cursor: not-allowed; }
    .cart-item .qty-control span {
        width: 2.25rem;
        text-align: center;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #212529;
        border-left: 1px solid #e5e7eb;
        border-right: 1px solid #e5e7eb;
        line-height: 2.125rem;
    }
    .cart-item .stock-label {
        font-size: 0.625rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }

    /* Subtotal + Remove */
    .cart-item .subtotal-area {
        text-align: right;
        min-width: 5rem;
    }
    .cart-item .item-subtotal {
        font-size: 1.0625rem;
        font-weight: 700;
        color: #212529;
    }
    .cart-item .remove-btn {
        background: none;
        border: none;
        color: #d1d5db;
        cursor: pointer;
        padding: 0.25rem;
        margin-top: 0.25rem;
        transition: all 0.2s;
        border-radius: 0.25rem;
    }
    .cart-item .remove-btn:hover {
        color: #ef4444;
        background: #fef2f2;
    }

    /* ─────────────── ORDER SUMMARY ─────────────── */
    .summary-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        position: sticky;
        top: 6rem;
        animation: fadeUp 0.4s ease-out 0.15s both;
    }
    .summary-card h2 {
        font-size: 1.0625rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }
    .summary-card .delivery-select {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        background: #ffffff;
        color: #212529;
        outline: none;
        transition: border-color 0.2s;
    }
    .summary-card .delivery-select:focus {
        border-color: #2E8B57;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        padding: 0.5rem 0;
    }
    .summary-row .label { color: #6b7280; }
    .summary-row .value { font-weight: 500; color: #374151; }
    .summary-divider {
        border: none;
        border-top: 1.5px solid #e9ecef;
        margin: 0.75rem 0;
    }
    .checkout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
        text-align: center;
        padding: 0.8125rem 1.5rem;
        border-radius: 0.625rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(46,139,87,0.2);
        margin-top: 0.75rem;
    }
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46,139,87,0.3);
    }
    .checkout-btn svg { transition: transform 0.25s ease; }
    .checkout-btn:hover svg { transform: translateX(4px); }
    .continue-link {
        display: block;
        text-align: center;
        margin-top: 0.75rem;
        font-size: 0.8125rem;
        color: #2E8B57;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    .continue-link:hover { color: #1B5E20; text-decoration: underline; }

    /* ─────────────── EMPTY STATE ─────────────── */
    .empty-cart {
        text-align: center;
        padding: 5rem 2rem;
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        grid-column: 1 / -1;
        animation: fadeUp 0.4s ease-out;
    }
    .empty-cart .empty-icon {
        width: 4.5rem;
        height: 4.5rem;
        margin: 0 auto 1.25rem;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }
    .empty-cart h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.375rem;
    }
    .empty-cart p {
        color: #6b7280;
        font-size: 0.875rem;
        max-width: 20rem;
        margin: 0 auto 1.5rem;
    }
    .empty-cart .shop-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #FFD166, #F0C14B);
        color: #212529;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(255,209,102,0.3);
    }
    .empty-cart .shop-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(255,209,102,0.4);
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 900px) {
        .cart-layout { grid-template-columns: 1fr; }
        .summary-card { position: static; }
    }
    @media (max-width: 640px) {
        .cart-hero { padding: 1.5rem 1rem 1.25rem; }
        .cart-hero h1 { font-size: 1.375rem; }
        .cart-layout { padding: 1rem 1rem 3rem; gap: 1rem; }
        .cart-item { padding: 1rem; }
        .cart-item .row { gap: 0.75rem; }
        .cart-item .thumb { width: 4rem; height: 4rem; }
        .cart-item .item-name { font-size: 0.875rem; }
        .cart-item .item-subtotal { font-size: 0.9375rem; }
        .cart-item .qty-control button { width: 1.875rem; height: 1.875rem; }
        .cart-item .qty-control span { width: 2rem; line-height: 1.875rem; font-size: 0.75rem; }
        .empty-cart { padding: 3rem 1.5rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
{{-- Hero --}}
<section class="cart-hero">
    <h1>Shopping Cart</h1>
    <div class="count-badge">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
        </svg>
        {{ $cartItems->count() }} {{ $cartItems->count() === 1 ? 'item' : 'items' }} in your cart
    </div>
</section>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert-wrap"><div class="alert alert-success"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> {{ session('success') }}</div></div>
@endif
@if(session('error'))
    <div class="alert-wrap"><div class="alert alert-error"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> {{ session('error') }}</div></div>
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

                    {{-- Qty --}}
                    <div class="qty-area">
                        <div class="qty-control" data-cart-id="{{ $item->id }}" data-stock="{{ $item->product->stock_quantity }}">
                            <button type="button" class="qty-minus" {{ $item->quantity <= 1 ? 'disabled' : '' }}>&minus;</button>
                            <span class="qty-value">{{ $item->quantity }}</span>
                            <button type="button" class="qty-plus" {{ $item->quantity >= $item->product->stock_quantity ? 'disabled' : '' }}>+</button>
                        </div>
                        <div class="stock-label">Stock: {{ $item->product->stock_quantity }}</div>
                    </div>

                    {{-- Subtotal + Remove --}}
                    <div class="subtotal-area">
                        <p class="item-subtotal" id="subtotal-{{ $item->id }}">{{ currencyFormat($item->product->final_price * $item->quantity) }}</p>
                        <button type="button" class="remove-btn" onclick="removeItem({{ $item->id }})" title="Remove item">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Summary --}}
    <div class="summary-card">
        <h2>Order Summary</h2>

        <div style="margin-bottom: 0.75rem;">
            <label for="deliveryArea" style="display: block; font-size: 0.75rem; font-weight: 500; color: #6b7280; margin-bottom: 0.375rem;">Delivery Area</label>
            <select id="deliveryArea" onchange="setDeliveryArea(this.value)" class="delivery-select">
                <option value="inside" {{ session('delivery_area', 'inside') === 'inside' ? 'selected' : '' }}>Inside Khulna</option>
                <option value="outside" {{ session('delivery_area') === 'outside' ? 'selected' : '' }}>Outside Khulna</option>
            </select>
        </div>

        <div class="summary-row">
            <span class="label">Subtotal</span>
            <span class="value" id="cartSubtotal">{{ currencyFormat($subtotal) }}</span>
        </div>

        <hr class="summary-divider">

        <a href="{{ route('checkout.index') }}" class="checkout-btn">
            Proceed to Checkout
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
        <a href="{{ route('products.index') }}" class="continue-link">&larr; Continue Shopping</a>
    </div>
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
            heroBadge.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg> ${data.itemCount} ${data.itemCount === 1 ? 'item' : 'items'} in your cart`;
        }

        if (data.empty) {
            const layout = document.querySelector('.cart-layout');
            if (layout) {
                layout.innerHTML =
                    '<div class="empty-cart">' +
                    '<div class="empty-icon">' +
                    '<svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">' +
                    '<path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>' +
                    '</svg></div>' +
                    '<h2>Your cart is empty</h2>' +
                    '<p>Looks like you haven\'t added anything yet.</p>' +
                    '<a href="{{ route("products.index") }}" class="shop-btn">Start Shopping</a>' +
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
        <p>Looks like you haven't added anything yet. Browse our products and find something you love!</p>
        <a href="{{ route('products.index') }}" class="shop-btn">Start Shopping</a>
    </div>
</div>
@endif
@endsection
