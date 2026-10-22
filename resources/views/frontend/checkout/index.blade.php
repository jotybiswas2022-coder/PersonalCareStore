@extends('frontend.layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    /* ─────────────── CHECKOUT HEADER ─────────────── */
    .checkout-hero {
        background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 50%, #FEFCE8 100%);
        padding: 2.5rem 1.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .checkout-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .checkout-hero h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: -0.02em;
        position: relative;
    }
    .checkout-hero p {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 0.375rem;
        position: relative;
    }

    /* ─────────────── PROGRESS STEPS ─────────────── */
    .checkout-steps {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
    }
    .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #9ca3af;
    }
    .step .circle {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        border: 2px solid #d1d5db;
        color: #9ca3af;
        background: #fff;
        transition: all 0.3s ease;
    }
    .step.active .circle {
        background: #2E8B57;
        border-color: #2E8B57;
        color: #fff;
    }
    .step.active { color: #2E8B57; }
    .step.done .circle {
        background: #2E8B57;
        border-color: #2E8B57;
        color: #fff;
    }
    .step.done { color: #166534; }
    .step .label { display: none; }
    .step.active .label,
    .step.done .label { display: inline; }
    .step-line {
        width: 3rem;
        height: 2px;
        background: #d1d5db;
        margin: 0 0.5rem;
    }
    .step-line.done { background: #2E8B57; }

    /* ─────────────── LAYOUT ─────────────── */
    .checkout-layout {
        max-width: 1280px;
        margin: 1.5rem auto;
        padding: 0 1.5rem 4rem;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }

    /* ─────────────── FORM ─────────────── */
    .form-section {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 1.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .form-section + .form-section { margin-top: 1.25rem; }
    .form-section .section-icon {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .form-section .section-icon svg {
        color: #2E8B57;
    }
    .form-section h2 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .form-grid .full-width {
        grid-column: span 2;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.375rem;
    }
    .form-group label .required {
        color: #ef4444;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        background: #ffffff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.1);
    }
    .form-group input.error {
        border-color: #ef4444;
    }
    .form-error {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* ─────────────── PLACE ORDER ─────────────── */
    .place-order-section {
        margin-top: 1.5rem;
    }
    .place-order-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 0.625rem;
        font-size: 1.0625rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(46,139,87,0.25);
    }
    .place-order-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46,139,87,0.35);
    }
    .place-order-btn:active { transform: translateY(0); }
    .place-order-btn svg { transition: transform 0.25s ease; }
    .place-order-btn:hover svg { transform: translateX(4px); }

    .trust-badges {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    .trust-badges span {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
    .trust-badges svg { color: #2E8B57; }

    /* ─────────────── ORDER SUMMARY SIDEBAR ─────────────── */
    .summary-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        position: sticky;
        top: 6rem;
    }
    .summary-card .summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    .summary-card .summary-header h2 {
        font-size: 1.0625rem;
        font-weight: 600;
        color: #212529;
    }
    .summary-card .summary-header .count {
        background: #f3f4f6;
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
    }
    .summary-item {
        display: flex;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .summary-item:last-child { border-bottom: none; }
    .summary-item .thumb {
        width: 3.25rem;
        height: 3.25rem;
        border-radius: 0.5rem;
        overflow: hidden;
        flex-shrink: 0;
        background: #f9fafb;
        border: 1px solid #e9ecef;
    }
    .summary-item .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .summary-item .thumb .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
    }
    .summary-item .info {
        flex: 1;
        min-width: 0;
    }
    .summary-item .info .name {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #212529;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .summary-item .info .qty {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.125rem;
    }
    .summary-item .info .discount-note {
        font-size: 0.625rem;
        color: #dc2626;
        font-weight: 500;
    }
    .summary-item .total {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #212529;
        white-space: nowrap;
    }

    /* Totals */
    .summary-totals { margin-top: 0.5rem; }
    .summary-totals .row {
        display: flex;
        justify-content: space-between;
        padding: 0.375rem 0;
        font-size: 0.8125rem;
    }
    .summary-totals .row .lbl { color: #6b7280; }
    .summary-totals .row .val { font-weight: 500; color: #374151; }
    .summary-totals .divider {
        border: none;
        border-top: 1.5px solid #e9ecef;
        margin: 0.625rem 0;
    }
    .summary-totals .total-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0 0;
    }
    .summary-totals .total-row .lbl {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
    }
    .summary-totals .total-row .val {
        font-size: 1.125rem;
        font-weight: 700;
        color: #2E8B57;
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 900px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
        .summary-card { position: static; }
    }
    @media (max-width: 640px) {
        .checkout-hero { padding: 1.5rem 1rem 1.25rem; }
        .checkout-hero h1 { font-size: 1.375rem; }
        .checkout-hero p { font-size: 0.8125rem; }
        .checkout-steps { padding: 1rem 1rem 0; }
        .step .circle { width: 1.75rem; height: 1.75rem; font-size: 0.6875rem; }
        .step-line { width: 2rem; }
        .step .label { display: none !important; }
        .checkout-layout { padding: 1rem 1rem 3rem; }
        .form-section { padding: 1.25rem; }
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .full-width { grid-column: span 1; }
        .summary-card { padding: 1.25rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    .checkout-layout {
        animation: fadeUp 0.4s ease-out;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
{{-- Hero --}}
<section class="checkout-hero">
    <h1>Checkout</h1>
    <p>Almost there! Fill in your details to complete your order.</p>
</section>

{{-- Progress Steps --}}
<div class="checkout-steps">
    <div class="step done">
        <span class="circle">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
        </span>
        <span class="label">Cart</span>
    </div>
    <div class="step-line done"></div>
    <div class="step active">
        <span class="circle">2</span>
        <span class="label">Details</span>
    </div>
    <div class="step-line"></div>
    <div class="step">
        <span class="circle">3</span>
        <span class="label">Confirm</span>
    </div>
</div>

{{-- Error message --}}
@if(session('error'))
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    </div>
@endif

{{-- Main Layout --}}
<div class="checkout-layout">
    {{-- Left: Form --}}
    <div>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            {{-- Shipping Section --}}
            <div class="form-section">
                <div class="section-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h2>Shipping Information</h2>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="{{ $errors->has('first_name') ? 'error' : '' }}">
                        @error('first_name')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="{{ $errors->has('last_name') ? 'error' : '' }}">
                        @error('last_name')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="{{ $errors->has('email') ? 'error' : '' }}">
                        @error('email')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone <span class="required">*</span></label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="{{ $errors->has('phone') ? 'error' : '' }}">
                        @error('phone')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="address_line1">Address Line 1 <span class="required">*</span></label>
                        <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" required class="{{ $errors->has('address_line1') ? 'error' : '' }}">
                        @error('address_line1')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="address_line2">Address Line 2</label>
                        <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2') }}" class="{{ $errors->has('address_line2') ? 'error' : '' }}">
                        @error('address_line2')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="city">City / Division <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required class="{{ $errors->has('city') ? 'error' : '' }}">
                        @error('city')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="state">State / Province</label>
                        <input type="text" name="state" id="state" value="{{ old('state') }}" class="{{ $errors->has('state') ? 'error' : '' }}">
                        @error('state')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code <span class="required">*</span></label>
                        <input type="hidden" name="country" value="Bangladesh">
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required class="{{ $errors->has('postal_code') ? 'error' : '' }}">
                        @error('postal_code')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Place Order --}}
            <div class="place-order-section">
                <button type="submit" class="place-order-btn">
                    Place Order
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
                <div class="trust-badges">
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Secure Checkout
                    </span>
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        SSL Encrypted
                    </span>
                </div>
            </div>
        </form>
    </div>

    {{-- Right: Order Summary --}}
    <div class="summary-card">
        <div class="summary-header">
            <h2>Order Summary</h2>
            <span class="count">{{ $cartItems->count() }} item{{ $cartItems->count() !== 1 ? 's' : '' }}</span>
        </div>

        @foreach($cartItems as $item)
            <div class="summary-item">
                <div class="thumb">
                    @if($item->product->images && count($item->product->images) > 0)
                        <img src="{{ $item->product->image_urls[0] }}" alt="{{ $item->product->name }}">
                    @else
                        <div class="no-img">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="info">
                    <p class="name">{{ $item->product->name }}</p>
                    <p class="qty">Qty: {{ $item->quantity }}</p>
                    @if($item->product->discount_name && $item->product->discount_percent)
                        <p class="discount-note">{{ $item->product->discount_name }} ({{ $item->product->discount_percent }}% OFF)</p>
                    @elseif($item->product->discount_name)
                        <p class="discount-note">{{ $item->product->discount_name }}</p>
                    @endif
                </div>
                <span class="total">{{ currencyFormat($item->product->final_price * $item->quantity) }}</span>
            </div>
        @endforeach

        <div class="summary-totals">
            <div class="row">
                <span class="lbl">Subtotal</span>
                <span class="val">{{ currencyFormat($subtotal) }}</span>
            </div>
            <div class="row">
                <span class="lbl">Shipping ({{ $deliveryArea === 'inside' ? 'Inside Khulna' : 'Outside Khulna' }})</span>
                <span class="val">{{ currencyFormat($deliveryCharge) }}</span>
            </div>
            <div class="row">
                <span class="lbl">VAT ({{ $vatPercent }}%)</span>
                <span class="val">{{ currencyFormat($vatAmount) }}</span>
            </div>
            <hr class="divider">
            <div class="total-row">
                <span class="lbl">Total</span>
                <span class="val">{{ currencyFormat($total) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
