@extends('frontend.layouts.app')

@section('title', isset($order) ? 'Order ' . $order->order_number : (isset($orders) ? 'Your Orders' : 'Track Order'))

@push('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .track-hero {
        background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 50%, #FEFCE8 100%);
        padding: 2.5rem 1rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .track-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .track-hero h1 { font-size: 1.75rem; font-weight: 700; color: #212529; letter-spacing: -0.02em; position: relative; }
    .track-hero p { color: #6b7280; font-size: 0.875rem; margin-top: 0.375rem; position: relative; }

    /* ─────────────── LAYOUT ─────────────── */
    .track-wrap { max-width: 42rem; margin: 0 auto; padding: 1.5rem 1rem 4rem; animation: fadeUp 0.4s ease-out; }

    /* ─────────────── SEARCH FORM ─────────────── */
    .search-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .search-card .search-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3rem; height: 3rem;
        background: #E8F5E9;
        border-radius: 50%;
        margin: 0 auto 1rem;
        color: #2E8B57;
    }
    .search-card h2 { text-align: center; font-size: 1.125rem; font-weight: 600; color: #212529; margin-bottom: 0.25rem; }
    .search-card .sub { text-align: center; color: #6b7280; font-size: 0.8125rem; margin-bottom: 1.5rem; }
    .field { margin-bottom: 1rem; }
    .field label { display: block; font-size: 0.8125rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem; }
    .field label .opt { color: #9ca3af; font-weight: 400; }
    .field input {
        width: 100%; padding: 0.625rem 0.875rem;
        border: 1.5px solid #d1d5db; border-radius: 0.5rem;
        font-size: 0.875rem; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .field input:focus { border-color: #2E8B57; box-shadow: 0 0 0 3px rgba(46,139,87,0.1); }
    .field .err { color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; }
    .btn-track {
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371); color: #fff; border: none;
        padding: 0.75rem; border-radius: 0.5rem; font-size: 0.9375rem; font-weight: 600;
        cursor: pointer; transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(46,139,87,0.2);
    }
    .btn-track:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(46,139,87,0.3); }

    /* ─────────────── ALERTS ─────────────── */
    .alert-box {
        display: flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 1rem; border-radius: 0.5rem;
        font-size: 0.875rem; margin-bottom: 1rem;
    }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

    /* ─────────────── STATUS BADGE ─────────────── */
    .status-badge {
        display: inline-flex; padding: 0.125rem 0.625rem;
        border-radius: 9999px; font-size: 0.75rem; font-weight: 500;
    }

    /* ─────────────── ORDER LIST ─────────────── */
    .order-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .order-list-card {
        background: #ffffff; border-radius: 0.75rem;
        border: 1px solid #e9ecef; padding: 1.25rem;
        cursor: pointer; transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .order-list-card:hover {
        transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        border-color: rgba(46,139,87,0.2);
    }
    .order-list-card .row {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.5rem;
    }
    .order-list-card .order-num {
        font-weight: 600; color: #212529; font-size: 0.9375rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .order-list-card .copy-link {
        font-size: 0.6875rem; color: #2E8B57; cursor: pointer;
        font-weight: 500; transition: color 0.2s;
    }
    .order-list-card .copy-link:hover { color: #1B5E20; }
    .order-list-card .date { font-size: 0.75rem; color: #6b7280; margin-top: 0.125rem; }
    .order-list-card .right { display: flex; align-items: center; gap: 0.75rem; }
    .order-list-card .amount { font-weight: 700; color: #2E8B57; font-size: 0.9375rem; }

    .inline-search {
        background: #ffffff; border-radius: 0.75rem;
        border: 1px solid #e9ecef; padding: 1.5rem; margin-top: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .inline-search h3 { font-size: 0.9375rem; font-weight: 600; color: #212529; margin-bottom: 0.75rem; }
    .inline-search .inline-row { display: flex; gap: 0.75rem; align-items: flex-end; }
    .inline-search .inline-row .field { flex: 1; margin-bottom: 0; }
    .inline-search .inline-row .btn-small {
        padding: 0.625rem 1.25rem; background: #2E8B57; color: #fff;
        border: none; border-radius: 0.5rem; font-size: 0.8125rem;
        font-weight: 600; cursor: pointer; white-space: nowrap;
        transition: background 0.2s;
    }
    .inline-search .inline-row .btn-small:hover { background: #217645; }
    @media (max-width: 480px) {
        .inline-search .inline-row { flex-direction: column; align-items: stretch; }
    }

    /* ─────────────── ORDER DETAIL ─────────────── */
    .detail-header {
        background: #ffffff; border-radius: 0.75rem;
        border: 1px solid #e9ecef; padding: 1.25rem 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .detail-header .top {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.5rem;
    }
    .detail-header h2 { font-size: 1.125rem; font-weight: 700; color: #212529; }
    .detail-header .copy-link {
        font-size: 0.75rem; color: #2E8B57; cursor: pointer;
        font-weight: 500; transition: color 0.2s;
    }
    .detail-header .copy-link:hover { color: #1B5E20; }
    .detail-header .meta { font-size: 0.8125rem; color: #6b7280; margin-top: 0.25rem; }

    /* Status timeline */
    .status-timeline { margin-top: 1.5rem; padding: 0 0.5rem; }
    .tl-step { display: flex; gap: 0.75rem; margin-bottom: 1.25rem; position: relative; }
    .tl-step:last-child { margin-bottom: 0; }
    .tl-step .tl-dot {
        width: 1.5rem; height: 1.5rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 0.625rem; font-weight: 700;
        border: 2px solid #d1d5db; background: #fff; color: #9ca3af;
        position: relative; z-index: 1;
    }
    .tl-step.done .tl-dot { background: #2E8B57; border-color: #2E8B57; color: #fff; }
    .tl-step.active .tl-dot { background: #2E8B57; border-color: #2E8B57; color: #fff; box-shadow: 0 0 0 3px rgba(46,139,87,0.15); }
    .tl-step.active .tl-label .tl-title { color: #2E8B57; font-weight: 600; }
    .tl-step .tl-line {
        position: absolute; top: 1.5rem; left: 0.6875rem;
        width: 2px; height: calc(100% + 0.25rem);
        background: #d1d5db; z-index: 0;
    }
    .tl-step:last-child .tl-line { display: none; }
    .tl-step.done .tl-line { background: #2E8B57; }
    .tl-step .tl-label { padding-top: 0.125rem; }
    .tl-step .tl-label .tl-title { font-size: 0.875rem; font-weight: 500; color: #374151; }
    .tl-step .tl-label .tl-desc { font-size: 0.75rem; color: #9ca3af; }
    .tl-step.done .tl-label .tl-title { color: #166534; }

    .detail-section {
        background: #ffffff; border-radius: 0.75rem;
        border: 1px solid #e9ecef; padding: 1.25rem 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        margin-top: 1rem;
    }
    .detail-section h3 {
        font-size: 0.9375rem; font-weight: 600; color: #212529;
        margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;
    }
    .info-row {
        display: flex; justify-content: space-between; font-size: 0.8125rem;
        padding: 0.375rem 0;
    }
    .info-row .lbl { color: #6b7280; }
    .info-row .val { font-weight: 500; color: #374151; }

    .items-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
    .items-table th {
        text-align: left; padding: 0.5rem 0.25rem; font-size: 0.6875rem;
        font-weight: 600; color: #6b7280; text-transform: uppercase;
        border-bottom: 1px solid #e9ecef;
    }
    .items-table td { padding: 0.5rem 0.25rem; border-bottom: 1px solid #f3f4f6; }
    .items-table tr:last-child td { border-bottom: none; }

    .grand-total {
        display: flex; justify-content: space-between;
        margin-top: 0.75rem; padding-top: 0.75rem;
        border-top: 1.5px solid #e9ecef;
    }
    .grand-total .lbl { font-size: 1rem; font-weight: 600; color: #212529; }
    .grand-total .val { font-size: 1.0625rem; font-weight: 700; color: #2E8B57; }

    .addr-text { font-size: 0.8125rem; color: #374151; line-height: 1.7; }

    .back-link {
        display: inline-flex; align-items: center; gap: 0.375rem;
        margin-top: 1.5rem; color: #2E8B57;
        text-decoration: none; font-size: 0.8125rem; font-weight: 500;
        transition: color 0.2s;
    }
    .back-link:hover { color: #1B5E20; }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 900px) {
        .track-hero h1 { font-size: 1.5rem; }
        .order-list-card .row { flex-direction: column; align-items: flex-start; }
        .order-list-card .right { width: 100%; justify-content: space-between; }
        .inline-search .inline-row { flex-direction: column; align-items: stretch; }
    }
    @media (max-width: 640px) {
        .track-hero { padding: 1.5rem 1rem 1.25rem; }
        .track-hero h1 { font-size: 1.375rem; }
        .track-wrap { padding: 1rem 1rem 3rem; }
        .search-card { padding: 1.25rem; }
        .detail-section { padding: 1rem 1.125rem; }
        .detail-header { padding: 1rem 1.125rem; }
        .detail-header .top { flex-direction: column; align-items: flex-start; }
        .track-hero { padding: 1.25rem 1rem 1rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
{{-- Hero --}}
<section class="track-hero">
    <h1>
        @if(isset($order)) Order {{ $order->order_number }}
        @elseif(isset($orders)) Your Orders
        @else Track Your Order
        @endif
    </h1>
    <p>
        @if(isset($order)) Real-time status and details for your order.
        @elseif(isset($orders)) Showing all orders for the email you provided.
        @else Enter your details to find your order.
        @endif
    </p>
</section>

<div class="track-wrap">
    {{-- Error --}}
    @if(session('error'))
        <div class="alert-box alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ─── SINGLE ORDER VIEW ─── --}}
    @if(isset($order))
        <div class="detail-header">
            <div class="top">
                <div>
                    <h2>Order {{ $order->order_number }}</h2>
                    <p class="meta">Placed on {{ $order->created_at->format('F d, Y \\a\\t h:i A') }}</p>
                </div>
                <span class="copy-link" onclick="copyText('{{ $order->order_number }}', this)">Copy Order Number</span>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="detail-section">
            <div class="status-timeline">
                @php
                    $steps = [
                        ['key' => 'placed', 'title' => 'Order Placed', 'desc' => 'Your order has been placed successfully.'],
                        ['key' => 'processing', 'title' => 'Processing', 'desc' => 'Your order is being prepared.'],
                        ['key' => 'shipped', 'title' => 'Shipped', 'desc' => 'Your order has been handed to the delivery service.'],
                        ['key' => 'delivered', 'title' => 'Delivered', 'desc' => 'Your order has been delivered.'],
                    ];
                    $statusOrder = ['pending' => 'placed', 'processing' => 'processing', 'shipped' => 'shipped', 'delivered' => 'delivered'];
                    $currentKey = $statusOrder[$order->status] ?? 'placed';
                    $reached = false;
                @endphp
                @foreach($steps as $i => $step)
                    @php
                        if ($step['key'] === $currentKey) { $reached = true; $cls = 'active'; }
                        elseif (!$reached) { $cls = 'done'; }
                        else { $cls = ''; }

                        if ($order->status === 'cancelled') {
                            $cls = $i === 0 ? 'done' : '';
                        }
                    @endphp
                    <div class="tl-step {{ $cls }}">
                        <div class="tl-dot">
                            @if($order->status === 'cancelled' && $i === 0)
                                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            @elseif($cls === 'done' || $cls === 'active')
                                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <div class="tl-line"></div>
                        <div class="tl-label">
                            <div class="tl-title">
                                @if($order->status === 'cancelled' && $i === 0)
                                    Cancelled
                                @else
                                    {{ $step['title'] }}
                                @endif
                            </div>
                            <div class="tl-desc">
                                @if($order->status === 'cancelled' && $i === 0)
                                    This order has been cancelled.
                                @else
                                    {{ $step['desc'] }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Items --}}
        <div class="detail-section">
            <h3>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Items Ordered ({{ $order->items->count() }})
            </h3>
            <table class="items-table">
                <thead>
                    <tr><th>Product</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Price</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td style="text-align:center;">{{ $item->quantity }}</td>
                            <td style="text-align:right; font-weight:500;">{{ currencyFormat($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="grand-total">
                <span class="lbl">Total</span>
                <span class="val">{{ currencyFormat($order->total) }}</span>
            </div>
        </div>

        {{-- Shipping Address --}}
        @if($order->shippingAddress)
            <div class="detail-section">
                <h3>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Shipping Address
                </h3>
                <p class="addr-text">
                    {{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}<br>
                    {{ $order->shippingAddress->address_line1 }}@if($order->shippingAddress->address_line2), {{ $order->shippingAddress->address_line2 }}@endif<br>
                    {{ $order->shippingAddress->city }}{{ $order->shippingAddress->state ? ', ' . $order->shippingAddress->state : '' }} {{ $order->shippingAddress->postal_code }}<br>
                    {{ $order->shippingAddress->country }}
                </p>
            </div>
        @endif

        {{-- Payment Status --}}
        <div class="detail-section">
            <h3>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Payment
            </h3>
            <div class="info-row">
                <span class="lbl">Status</span>
                <span class="status-badge" style="background: {{ $order->payment_status === 'paid' || $order->payment_status === 'approved' ? '#f0fdf4' : ($order->payment_status === 'rejected' || $order->payment_status === 'cancelled' ? '#fef2f2' : '#fef9c3') }}; color: {{ $order->payment_status === 'paid' || $order->payment_status === 'approved' ? '#166534' : ($order->payment_status === 'rejected' || $order->payment_status === 'cancelled' ? '#dc2626' : '#854d0e') }};">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>

        <a href="{{ route('track-order.index') }}" class="back-link">&larr; Track Another Order</a>

    {{-- ─── ORDER LIST VIEW ─── --}}
    @elseif(isset($orders))
        <p style="text-align:center; color:#6b7280; font-size:0.8125rem; margin-bottom:1.25rem;">
            Showing orders for <strong style="color:#212529;">{{ old('email') }}</strong>
        </p>

        <div class="order-list">
            @foreach($orders as $o)
                <div class="order-list-card" onclick="location.href='{{ route('track-order.show', ['id' => $o->id, 'email' => old('email')]) }}'">
                    <div class="row">
                        <div>
                            <div class="order-num">
                                {{ $o->order_number }}
                                <span class="copy-link" onclick="event.stopPropagation(); copyText('{{ $o->order_number }}', this)">Copy</span>
                            </div>
                            <div class="date">{{ $o->created_at->format('M d, Y \\a\\t h:i A') }}</div>
                        </div>
                        <div class="right">
                            <span class="status-badge" style="background: {{ $o->status === 'cancelled' ? '#fef2f2' : ($o->status === 'pending' ? '#fef9c3' : ($o->status === 'processing' ? '#dbeafe' : ($o->status === 'shipped' ? '#e0e7ff' : ($o->status === 'delivered' ? '#f0fdf4' : '#fef2f2')))) }}; color: {{ $o->status === 'cancelled' ? '#991b1b' : ($o->status === 'pending' ? '#854d0e' : ($o->status === 'processing' ? '#1e40af' : ($o->status === 'shipped' ? '#3730a3' : ($o->status === 'delivered' ? '#166534' : '#991b1b')))) }};">
                                {{ ucfirst($o->status) }}
                            </span>
                            <span class="amount">{{ currencyFormat($o->total) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Inline search for specific order --}}
        <div class="inline-search">
            <h3>Have your order number?</h3>
            <form action="{{ route('track-order.lookup') }}" method="POST" class="inline-row">
                @csrf
                <input type="hidden" name="email" value="{{ old('email') }}">
                <div class="field">
                    <input type="text" name="order_number" placeholder="Enter order number..." value="{{ old('order_number') }}">
                </div>
                <button type="submit" class="btn-small">Search</button>
            </form>
        </div>

        <a href="{{ route('track-order.index') }}" class="back-link">&larr; Track with Different Email</a>

    {{-- ─── SEARCH FORM ─── --}}
    @else
        <div class="search-card">
            <div class="search-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <h2>Find Your Order</h2>
            <p class="sub">Enter your email to see all orders, or enter your order number for a specific search.</p>

            <form action="{{ route('track-order.lookup') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="order_number">Order Number <span class="opt">(optional)</span></label>
                    <input type="text" name="order_number" id="order_number" value="{{ old('order_number') }}" placeholder="e.g. ORD-ABC123DEFG">
                    @error('order_number')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                    @error('email')<p class="err">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-track">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    Track Order
                </button>
            </form>
        </div>
    @endif
</div>

<script>
    function copyText(text, el) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = el.textContent;
            el.textContent = 'Copied!';
            el.style.color = '#16a34a';
            setTimeout(() => {
                el.textContent = orig;
                el.style.color = '';
            }, 2000);
        }).catch(() => {
            // Fallback for older browsers
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        });
    }
</script>
@endsection
