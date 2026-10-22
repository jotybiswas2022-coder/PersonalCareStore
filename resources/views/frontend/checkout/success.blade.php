@extends('frontend.layouts.app')

@section('title', $order->proof_image ? 'Order Confirmed' : 'Payment Required')

@push('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .success-hero {
        background: linear-gradient(135deg, {{ $order->proof_image ? '#F0FDF4' : '#FEFCE8' }} 0%, #FFFFFF 50%, #F8F9FA 100%);
        padding: 2.5rem 1.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .success-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, {{ $order->proof_image ? 'rgba(46,139,87,0.07)' : 'rgba(255,209,102,0.10)' }} 0%, transparent 70%);
        pointer-events: none;
    }
    .success-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, {{ $order->proof_image ? 'rgba(255,209,102,0.07)' : 'rgba(46,139,87,0.06)' }} 0%, transparent 70%);
        pointer-events: none;
    }
    .success-hero .icon-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 4.5rem;
        height: 4.5rem;
        border-radius: 50%;
        margin-bottom: 1.25rem;
        animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
    }
    .success-hero .icon-wrap.confirmed { background: #f0fdf4; }
    .success-hero .icon-wrap.pending { background: #fef9c3; }
    .success-hero .icon-wrap svg { width: 2.25rem; height: 2.25rem; }
    .success-hero .icon-wrap .check { color: #16a34a; }
    .success-hero .icon-wrap .warn { color: #d97706; }
    .success-hero h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: -0.02em;
        position: relative;
        animation: fadeSlideUp 0.5s ease-out 0.1s both;
    }
    .success-hero p {
        color: #6b7280;
        font-size: 0.9375rem;
        margin-top: 0.5rem;
        max-width: 28rem;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        animation: fadeSlideUp 0.5s ease-out 0.2s both;
    }

    /* ─────────────── STATUS BAR ─────────────── */
    .status-bar {
        max-width: 48rem;
        margin: 1.5rem auto 0;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
    }
    .status-step {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #9ca3af;
    }
    .status-step .dot {
        width: 1.5rem; height: 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.625rem;
        font-weight: 700;
        border: 2px solid #d1d5db;
        background: #fff;
        transition: all 0.3s;
    }
    .status-step.done .dot {
        background: #2E8B57; border-color: #2E8B57; color: #fff;
    }
    .status-step.active .dot {
        background: #2E8B57; border-color: #2E8B57; color: #fff;
    }
    .status-step.active { color: #2E8B57; }
    .status-step.done { color: #166534; }
    .status-line {
        width: 2.5rem; height: 2px;
        background: #d1d5db;
        margin: 0 0.375rem;
    }
    .status-line.done { background: #2E8B57; }

    /* ─────────────── LAYOUT ─────────────── */
    .success-layout {
        max-width: 48rem;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 4rem;
        animation: fadeSlideUp 0.5s ease-out 0.25s both;
    }

    /* ─────────────── ORDER CARD ─────────────── */
    .order-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .order-card .section {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }
    .order-card .section:last-child { border-bottom: none; }
    .order-card .section.highlight {
        background: linear-gradient(135deg, #F0FDF4 0%, #ffffff 100%);
    }

    /* Order info row */
    .order-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .order-info .lbl { font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; }
    .order-info .order-num {
        font-size: 1.125rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: -0.01em;
    }
    .order-info .order-num .copy-btn {
        background: none; border: none;
        color: #9ca3af; cursor: pointer;
        padding: 0.125rem; margin-left: 0.375rem;
        vertical-align: middle;
        transition: color 0.2s;
    }
    .order-info .order-num .copy-btn:hover { color: #2E8B57; }
    .order-info .order-date { font-size: 0.8125rem; color: #6b7280; text-align: right; line-height: 1.4; }
    .order-info .order-date strong { color: #212529; font-weight: 600; }

    /* Items */
    .items-section h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .items-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.625rem 0.75rem;
        background: #F8F9FA;
        border-radius: 0.5rem;
        gap: 0.75rem;
    }
    .item-row .item-name { font-weight: 500; color: #212529; font-size: 0.875rem; }
    .item-row .item-meta { font-size: 0.75rem; color: #9ca3af; margin-top: 0.125rem; }
    .item-row .item-subtotal { font-weight: 600; color: #212529; font-size: 0.875rem; white-space: nowrap; }

    /* Totals */
    .totals { font-size: 0.875rem; }
    .totals .row { display: flex; justify-content: space-between; padding: 0.375rem 0; }
    .totals .row .lbl { color: #6b7280; }
    .totals .row .val { font-weight: 500; color: #374151; }
    .totals .divider { border: none; border-top: 1.5px solid #e9ecef; margin: 0.625rem 0; }
    .totals .grand-total { display: flex; justify-content: space-between; }
    .totals .grand-total .lbl { font-size: 1rem; font-weight: 600; color: #212529; }
    .totals .grand-total .val { font-size: 1.125rem; font-weight: 700; color: #2E8B57; }

    /* Address */
    .address-section h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .address-section p {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.7;
    }

    /* Payment status row */
    .status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .status-row .lbl { font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; }
    .status-row .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 500;
    }
    .status-row .status-badge.pending {
        background: #fef9c3;
        color: #854d0e;
    }
    .status-row .status-badge.paid {
        background: #f0fdf4;
        color: #166534;
    }
    .status-row .order-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 500;
        background: #f3f4f6;
        color: #374151;
        text-transform: capitalize;
    }

    /* ─────────────── PAYMENT DETAILS ─────────────── */
    .payment-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        margin-top: 1.5rem;
        animation: fadeSlideUp 0.5s ease-out 0.3s both;
    }
    .payment-card .header {
        background: #F0FDF4;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .payment-card .header svg { color: #2E8B57; }
    .payment-card .header h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #1B5E20;
    }
    .payment-card .body { padding: 1.25rem 1.5rem; }
    .payment-card .detail-row {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .payment-card .detail-row:last-child { border-bottom: none; }
    .payment-card .detail-label {
        width: 8rem;
        font-size: 0.8125rem;
        color: #6b7280;
        flex-shrink: 0;
    }
    .payment-card .detail-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: #212529;
    }
    .payment-card .instructions {
        margin-top: 0.75rem;
        padding: 0.75rem 1rem;
        background: #F8F9FA;
        border-radius: 0.5rem;
        border-left: 3px solid #2E8B57;
        font-size: 0.8125rem;
        color: #374151;
        line-height: 1.6;
    }

    /* ─────────────── PROOF FORM / SUBMITTED ─────────────── */
    .proof-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        margin-top: 1.5rem;
        animation: fadeSlideUp 0.5s ease-out 0.35s both;
    }
    .proof-card .header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .proof-card .header svg { color: #2E8B57; }
    .proof-card .header h2 { font-size: 1rem; font-weight: 600; color: #212529; }
    .proof-card .body { padding: 1.25rem 1.5rem; }

    .proof-card .form-group { margin-bottom: 1.25rem; }
    .proof-card .form-group label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.375rem;
    }
    .proof-card .form-group input[type="text"],
    .proof-card .form-group input[type="file"] {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .proof-card .form-group input:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.1);
    }
    .proof-card .form-group .file-hint {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }
    .proof-card .already-submitted {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 0.5rem;
        color: #166534;
        font-size: 0.875rem;
    }
    .proof-card .already-submitted svg { flex-shrink: 0; margin-top: 0.125rem; }
    .proof-card .proof-preview {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }
    .proof-card .proof-preview .label {
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .proof-card .proof-preview img {
        width: 10rem;
        height: 10rem;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(46,139,87,0.2);
    }
    .submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(46,139,87,0.3);
    }

    /* ─────────────── ACTIONS ─────────────── */
    .actions {
        margin-top: 2rem;
        text-align: center;
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeSlideUp 0.5s ease-out 0.4s both;
    }
    .actions .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #FFD166, #F0C14B);
        color: #212529;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(255,209,102,0.3);
    }
    .actions .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(255,209,102,0.4);
    }
    .actions .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #2E8B57;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .actions .btn-secondary:hover { color: #1B5E20; background: #F0FDF4; }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 640px) {
        .success-hero { padding: 1.5rem 1rem 1.25rem; }
        .success-hero h1 { font-size: 1.375rem; }
        .success-hero .icon-wrap { width: 3.5rem; height: 3.5rem; }
        .success-hero .icon-wrap svg { width: 1.75rem; height: 1.75rem; }
        .status-bar { padding: 0 1rem; }
        .status-line { width: 1.5rem; }
        .success-layout { padding: 1rem 1rem 3rem; }
        .order-card .section { padding: 1rem 1.125rem; }
        .item-row { flex-wrap: wrap; }
        .payment-card .body { padding: 1rem 1.125rem; }
        .proof-card .body { padding: 1rem 1.125rem; }
        .payment-card .detail-label { width: 6rem; }
        .proof-card .proof-preview img { width: 8rem; height: 8rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.3); }
        50% { transform: scale(1.1); }
        70% { transform: scale(0.9); }
        100% { opacity: 1; transform: scale(1); }
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
{{-- Hero --}}
<section class="success-hero">
    <div class="icon-wrap {{ $order->proof_image ? 'confirmed' : 'pending' }}">
        @if($order->proof_image)
            <svg class="check" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        @else
            <svg class="warn" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        @endif
    </div>
    <h1>{{ $order->proof_image ? 'Order Confirmed!' : 'Payment Required' }}</h1>
    <p>{{ $order->proof_image ? 'Thank you for your purchase. Your payment proof has been received and is being reviewed.' : 'Please submit your payment proof to confirm your order.' }}</p>
</section>

{{-- Status bar --}}
<div class="status-bar">
    <div class="status-step done"><span class="dot"><svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></span> Ordered</div>
    <div class="status-line done"></div>
    <div class="status-step {{ $order->proof_image ? 'done' : 'active' }}"><span class="dot">{{ $order->proof_image ? '✓' : '2' }}</span> {{ $order->proof_image ? 'Paid' : 'Payment' }}</div>
    <div class="status-line {{ $order->proof_image ? 'done' : '' }}"></div>
    <div class="status-step"><span class="dot">3</span> Shipped</div>
</div>

{{-- Main content --}}
<div class="success-layout">
    {{-- Order card --}}
    <div class="order-card">
        <div class="section highlight">
            <div class="order-info">
                <div>
                    <p class="lbl">Order Number</p>
                    <p class="order-num">
                        {{ $order->order_number }}
                        <button class="copy-btn" onclick="copyOrderNumber()" title="Copy order number">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                            </svg>
                        </button>
                    </p>
                </div>
                <div class="order-date">
                    <p class="lbl">Order Date</p>
                    <strong>{{ $order->created_at->format('F d, Y') }}</strong>
                    <br>
                    <span>{{ $order->created_at->format('h:i A') }}</span>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="section items-section">
            <h2>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Items Ordered ({{ $order->items->count() }})
            </h2>
            <div class="items-list">
                @foreach($order->items as $item)
                    <div class="item-row">
                        <div>
                            <p class="item-name">{{ $item->product_name }}</p>
                            <p class="item-meta">Qty: {{ $item->quantity }} × {{ currencyFormat($item->product_price) }}</p>
                        </div>
                        <p class="item-subtotal">{{ currencyFormat($item->subtotal) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Totals --}}
        <div class="section">
            <div class="totals">
                <div class="row">
                    <span class="lbl">Subtotal</span>
                    <span class="val">{{ currencyFormat($order->subtotal) }}</span>
                </div>
                <div class="row">
                    <span class="lbl">Shipping</span>
                    <span class="val">{{ currencyFormat($order->shipping_cost) }}</span>
                </div>
                <div class="row">
                    <span class="lbl">VAT</span>
                    <span class="val">{{ currencyFormat($order->tax) }}</span>
                </div>
                <hr class="divider">
                <div class="grand-total">
                    <span class="lbl">Total</span>
                    <span class="val">{{ currencyFormat($order->total) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        @if($order->shippingAddress)
            <div class="section address-section">
                <h2>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Shipping Address
                </h2>
                <p>
                    {{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}<br>
                    {{ $order->shippingAddress->address_line1 }}@if($order->shippingAddress->address_line2), {{ $order->shippingAddress->address_line2 }}@endif<br>
                    {{ $order->shippingAddress->city }}{{ $order->shippingAddress->state ? ', ' . $order->shippingAddress->state : '' }} {{ $order->shippingAddress->postal_code }}<br>
                    {{ $order->shippingAddress->country }}
                </p>
            </div>
        @endif

        {{-- Payment & Status --}}
        <div class="section">
            <div class="status-row">
                <div>
                    <p class="lbl">Payment Status</p>
                    <span class="status-badge {{ $order->payment_status === 'paid' ? 'paid' : 'pending' }}">
                        @if($order->payment_status === 'paid')
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        @endif
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <span class="order-status-badge">{{ ucfirst($order->status) }}</span>
            </div>
        </div>
    </div>

    {{-- Payment Details --}}
    @if($paymentDetails->count() > 0)
        @foreach($paymentDetails as $detail)
            <div class="payment-card">
                <div class="header">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    <h2>Payment Details</h2>
                </div>
                <div class="body">
                    <div class="detail-row">
                        <span class="detail-label">Bank Name</span>
                        <span class="detail-value">{{ $detail->bank_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Account Number</span>
                        <span class="detail-value">{{ $detail->account_number }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Account Holder</span>
                        <span class="detail-value">{{ $detail->account_holder }}</span>
                    </div>
                    @if($detail->instructions)
                        <div class="instructions">{!! nl2br(e($detail->instructions)) !!}</div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    {{-- Payment Proof --}}
    @if($order->status === 'cancelled')
        <div class="proof-card">
            <div class="header" style="background:#fef2f2;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#dc2626;">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <h2 style="color:#991b1b;">Order Cancelled</h2>
            </div>
            <div class="body">
                <div class="already-submitted" style="background:#fef2f2; border-color:#fecaca; color:#991b1b;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;color:#dc2626;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <div>
                        This order has been <strong>cancelled</strong>. Payment proof can no longer be submitted for cancelled orders.
                    </div>
                </div>
            </div>
        </div>
    @elseif($order->proof_image)
        <div class="proof-card">
            <div class="header">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <h2>Payment Proof Submitted</h2>
            </div>
            <div class="body">
                <div class="already-submitted">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink: 0;"><polyline points="20 6 9 17 4 12"/></svg>
                    <div>
                        Your payment proof has been submitted successfully. <strong>Transaction ID:</strong> {{ $order->transaction_id }}
                    </div>
                </div>
                <div class="proof-preview">
                    <p class="label">Uploaded Screenshot</p>
                    <img src="{{ config('app.storage_url') . preg_replace('#^storage/#', '', $order->proof_image) }}" alt="Payment Proof">
                </div>
            </div>
        </div>
    @else
        <div class="proof-card">
            <div class="header">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                </svg>
                <h2>Submit Payment Proof</h2>
            </div>
            <div class="body">
                <form action="{{ route('checkout.proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="transaction_id">Transaction ID <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" required placeholder="e.g. TRX123456789">
                        @error('transaction_id')<p style="color:#ef4444; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="proof_image">Payment Screenshot <span style="color:#ef4444;">*</span></label>
                        <input type="file" name="proof_image" id="proof_image" accept="image/*" required>
                        <p class="file-hint">Accepted formats: JPEG, PNG, JPG, GIF, WebP (max 10MB)</p>
                        @error('proof_image')<p style="color:#ef4444; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="submit-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Submit Payment
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- Actions --}}
    @if($order->proof_image)
        <div class="actions">
            <a href="{{ route('products.index') }}" class="btn-primary">
                Continue Shopping
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="{{ route('home') }}" class="btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Back to Home
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function copyOrderNumber() {
        const text = '{{ $order->order_number }}';
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.querySelector('.copy-btn');
            btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
            setTimeout(() => {
                btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>';
            }, 2000);
        });
    }
</script>
@endpush
