@extends('frontend.layouts.app')

@section('title', 'Order ' . $order->order_number)

@push('styles')
<style>
    /* ── Hero Banner ── */
    .ord-hero {
        background: linear-gradient(135deg, #1a5c3a 0%, #2E8B57 50%, #3CB371 100%);
        padding: 2.5rem 1.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .ord-hero::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -10%;
        width: 20rem;
        height: 20rem;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .ord-hero .back-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 1;
    }
    .ord-hero .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        color: rgba(255,255,255,0.85);
        text-decoration: none;
        font-size: 0.825rem;
        font-weight: 500;
        transition: color 0.2s;
    }
    .ord-hero .back-link:hover { color: #fff; }
    .ord-hero .copy-btn {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: #fff;
        padding: 0.3rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: background 0.2s;
    }
    .ord-hero .copy-btn:hover { background: rgba(255,255,255,0.25); }
    .ord-hero h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }
    .ord-hero .ord-date {
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }

    /* ── Page Wrap ── */
    .ord-wrap {
        max-width: 56rem;
        margin: 0 auto;
        padding: 1.5rem 1rem 4rem;
    }
    .ord-grid { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Alert Messages ── */
    .alert-box {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        line-height: 1.5;
    }
    .alert-box svg { flex-shrink: 0; margin-top: 1px; }
    .alert-box.alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }
    .alert-box.alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* ── Status Card ── */
    .stat-card {
        background: #fff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .stat-card .stat-hdr {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .stat-card .stat-hdr h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .stat-card .stat-hdr h2 svg { color: #2E8B57; }
    .s-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1.6;
    }
    .s-badge .sub {
        display: block;
        font-size: 0.65rem;
        font-weight: 500;
        line-height: 1.2;
        opacity: 0.85;
    }

    /* ── Timeline ── */

    .timeline {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-top: 1rem;
    position: relative;
}

    .tl-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
        flex: 1;
    }
    .tl-step .tl-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        border: 2.5px solid #d1d5db;
        background: #fff;
        color: #9ca3af;
        transition: all 0.3s;
    }
    .tl-step.done .tl-icon {
        background: #2E8B57;
        border-color: #2E8B57;
        color: #fff;
    }
    .tl-step.done .tl-icon svg { width: 1rem; height: 1rem; }
    .tl-step.active .tl-icon {
        border-color: #2E8B57;
        color: #2E8B57;
        background: #f0fdf4;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.15);
    }
    .tl-step .tl-lbl {
        font-size: 0.7rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .tl-step.done .tl-lbl { color: #2E8B57; }
    .tl-step.active .tl-lbl { color: #2E8B57; }
    .tl-step .tl-desc {
        font-size: 0.65rem;
        color: #9ca3af;
        max-width: 6rem;
        line-height: 1.3;
    }

    /* ── Card ── */
    .ord-card {
        background: #fff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .ord-card h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .ord-card h2 svg { color: #2E8B57; }

    /* ── Items Table ── */
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table thead th {
        text-align: left;
        padding: 0.5rem 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f3f4f6;
    }
    .items-table tbody td {
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .items-table tbody tr:last-child td { border-bottom: none; }
    .items-table .item-name { font-weight: 500; color: #212529; }
    .items-table .item-price { color: #6b7280; }

    /* ── Totals ── */
    .totals { margin-top: 0.75rem; border-top: 1px solid #e5e7eb; padding-top: 0.75rem; }
    .totals .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.375rem;
        font-size: 0.85rem;
    }
    .totals .row .lbl { color: #6b7280; }
    .totals .row .val { font-weight: 500; color: #374151; }
    .totals .grand-total {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid #e5e7eb;
        font-size: 1.1rem;
        font-weight: 700;
        color: #212529;
    }
    .totals .grand-total .val { color: #2E8B57; }

    /* ── Address ── */
    .addr-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    .addr-item {}
    .addr-item .lbl {
        font-size: 0.7rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.15rem;
    }
    .addr-item .val {
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.5;
    }
    .addr-full { grid-column: 1 / -1; }

    /* ── Payment Proof ── */
    .proof-img {
        max-width: 100%;
        max-height: 20rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        margin-top: 0.75rem;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .proof-img:hover { opacity: 0.9; }

    /* ── Submit Payment ── */
    .submit-pmt {
        text-align: center;
        padding: 2rem 1.5rem;
    }
    .submit-pmt p {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    .btn-pmt {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #FFD166, #f0b840);
        color: #212529;
        padding: 0.625rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s;
        box-shadow: 0 4px 12px rgba(255,209,102,0.3);
    }
    .btn-pmt:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(255,209,102,0.4);
    }

    /* ── Reviews ── */
    .rv-block {
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    .rv-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .rv-block .rv-prod {
        font-weight: 500;
        font-size: 0.875rem;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    .rv-block .rv-form {}
    .rv-block .rv-form label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.25rem;
    }
    .rv-block .rv-form select,
    .rv-block .rv-form textarea {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .rv-block .rv-form select:focus,
    .rv-block .rv-form textarea:focus { border-color: #2E8B57; box-shadow: 0 0 0 3px rgba(46,139,87,0.1); }
    .rv-block .rv-form textarea { resize: vertical; min-height: 4rem; }
    .rv-block .rv-form .field { margin-bottom: 0.75rem; }
    .rv-block .rv-form .file-input { font-size: 0.8125rem; }
    .rv-block .rv-form .cur-img { margin-top: 0.375rem; display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
    .rv-block .rv-form .cur-img img {
        max-width: 5rem;
        border-radius: 0.375rem;
        border: 1px solid #e5e7eb;
    }
    .rv-block .rv-form .btn-del-img {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 0.3rem 0.6rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .rv-block .rv-form .btn-del-img:hover {
        background: #fee2e2;
        border-color: #fca5a5;
    }
    .btn-rv {
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
    }
    .btn-rv:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(46,139,87,0.3);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ord-hero { padding: 2rem 1rem 1.5rem; }
        .ord-hero h1 { font-size: 1.25rem; }
        .ord-wrap { padding: 1rem 0.75rem 3rem; }
        .stat-card, .ord-card { padding: 1.25rem; }
        .timeline { gap: 0.25rem; }
        .timeline::before { left: 1rem; right: 1rem; }
        .tl-step .tl-icon { width: 2.125rem; height: 2.125rem; font-size: 0.7rem; }
        .tl-step .tl-lbl { font-size: 0.6rem; }
        .tl-step .tl-desc { display: none; }
        .addr-grid { grid-template-columns: 1fr; }
        .items-table thead th,
        .items-table tbody td { padding: 0.4rem 0.35rem; font-size: 0.8rem; }
        .items-table thead th:nth-child(1),
        .items-table tbody td:nth-child(1) { width: 3rem; }
        .items-table thead th:nth-child(5),
        .items-table tbody td:nth-child(5) { display: none; }
    }
    @media (max-width: 480px) {
        .ord-hero { padding: 1.5rem 0.75rem 1.25rem; }
        .ord-hero h1 { font-size: 1.1rem; }
        .stat-card .stat-hdr { flex-direction: column; align-items: flex-start; }
        .stat-card .stat-hdr .badge-group { align-self: flex-start; }
        .timeline { gap: 0; }
        .timeline::before { left: 0.5rem; right: 0.5rem; }
        .tl-step .tl-icon { width: 1.75rem; height: 1.75rem; font-size: 0.6rem; border-width: 2px; }
        .tl-step .tl-lbl { font-size: 0.55rem; }
    }
</style>
@endpush

@section('content')
<div class="ord-hero">
    <div class="back-row" style="max-width:56rem;margin-left:auto;margin-right:auto;width:100%;">
        <a href="{{ route('orders.index') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to My Orders
        </a>
        <button class="copy-btn" onclick="copyOrder()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
            <span id="copyLabel">Copy Order #</span>
        </button>
    </div>
    <h1>Order {{ $order->order_number }}</h1>
    <p class="ord-date">Placed on {{ $order->created_at->format('F d, Y \\a\\t h:i A') }}</p>
</div>

<div class="ord-wrap">
    <div class="ord-grid">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert-box alert-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box alert-error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Status Card with Timeline --}}
        <div class="stat-card">
            <div class="stat-hdr">
                <h2>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                    Order Status
                </h2>
                <div class="badge-group" style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => '#fef9c3', 'fg' => '#854d0e'],
                            'processing' => ['bg' => '#dbeafe', 'fg' => '#1e40af'],
                            'shipped' => ['bg' => '#e0e7ff', 'fg' => '#3730a3'],
                            'delivered' => ['bg' => '#f0fdf4', 'fg' => '#166534'],
                            'cancelled' => ['bg' => '#fef2f2', 'fg' => '#991b1b'],
                        ];
                        $sc = $statusColors[$order->status] ?? ['bg' => '#f3f4f6', 'fg' => '#374151'];
                        $pmColors = [
                            'unpaid' => ['bg' => '#fef9c3', 'fg' => '#854d0e'],
                            'pending' => ['bg' => '#fef9c3', 'fg' => '#854d0e'],
                            'paid' => ['bg' => '#f0fdf4', 'fg' => '#166534'],
                            'approved' => ['bg' => '#f0fdf4', 'fg' => '#166534'],
                            'rejected' => ['bg' => '#fef2f2', 'fg' => '#991b1b'],
                            'cancelled' => ['bg' => '#fef2f2', 'fg' => '#991b1b'],
                        ];
                        $pmc = $pmColors[$order->payment_status] ?? ['bg' => '#f3f4f6', 'fg' => '#374151'];
                    @endphp
                    <span class="s-badge" style="background:{{ $sc['bg'] }};color:{{ $sc['fg'] }};">
                        {{ ucfirst($order->status) }}
                        @if($order->status === 'cancelled' && $order->cancelled_by)
                            <span class="sub">by {{ $order->cancelled_by === 'user' ? 'You' : 'Admin' }}</span>
                        @endif
                    </span>
                    <span class="s-badge" style="background:{{ $pmc['bg'] }};color:{{ $pmc['fg'] }};">
                        Payment: {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>

            {{-- Timeline --}}
            @php
                $steps = [
                    ['key' => 'placed',    'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>', 'lbl' => 'Ordered', 'desc' => 'Order has been placed'],
                    ['key' => 'processing', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>', 'lbl' => 'Processing', 'desc' => 'Preparing your order'],
                    ['key' => 'shipped',    'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>', 'lbl' => 'Shipped', 'desc' => 'Out for delivery'],
                    ['key' => 'delivered',  'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>', 'lbl' => 'Delivered', 'desc' => 'Order completed'],
                ];
                $statusOrder = ['pending' => 'placed', 'processing' => 'processing', 'shipped' => 'shipped', 'delivered' => 'delivered'];
                $currentKey = $statusOrder[$order->status] ?? 'placed';
                $reached = false;
                // If cancelled, mark step 1 as X icon, rest grey
                $isCancelled = $order->status === 'cancelled';
            @endphp
            <div class="timeline" style="background:linear-gradient(to right, #e5e7eb, #e5e7eb) no-repeat center 1.125rem / calc(100% - 3rem) 3px;">
                @foreach($steps as $i => $step)
                    @php
                        if (!$isCancelled) {
                            if ($step['key'] === $currentKey) {
                                $cls = 'active';
                                $reached = true;
                            } elseif (!$reached) {
                                $cls = 'done';
                            } else {
                                $cls = '';
                            }
                        } else {
                            $cls = $i === 0 ? 'done' : '';
                        }
                    @endphp
                    <div class="tl-step {{ $cls }}">
                        <div class="tl-icon">
                            @if($isCancelled && $i === 0)
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            @elseif($cls === 'done' && !($isCancelled && $i === 0))
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            @elseif($cls === 'active')
                                <span style="width:10px;height:10px;border-radius:50%;background:#2E8B57;"></span>
                            @else
                                <span>{{ $i + 1 }}</span>
                            @endif
                        </div>
                        @if($isCancelled && $i === 0)
                            <div class="tl-lbl" style="color:#dc2626;">Cancelled</div>
                            <div class="tl-desc" style="color:#dc2626;">This order has been cancelled.</div>
                        @else
                            <div class="tl-lbl">{!! $step['lbl'] !!}</div>
                            <div class="tl-desc">{{ $step['desc'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Items Card --}}
        <div class="ord-card">
            <h2>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                Order Items
            </h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:4.5rem;">Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->product && $item->product->images && count($item->product->images) > 0)
                                    <img src="{{ $item->product->image_urls[0] }}" alt="{{ $item->product_name }}" style="width:3.5rem;height:3.5rem;object-fit:cover;border-radius:0.5rem;border:1px solid #e5e7eb;">
                                @else
                                    <div style="width:3.5rem;height:3.5rem;background:#f3f4f6;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;font-size:0.7rem;color:#9ca3af;">N/A</div>
                                @endif
                            </td>
                            <td class="item-name">{{ $item->product_name }}</td>
                            <td class="item-price">{{ currencyFormat($item->product_price) }}</td>
                            <td style="text-align:center;">{{ $item->quantity }}</td>
                            <td style="text-align:right;font-weight:500;">{{ currencyFormat($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                <div class="grand-total">
                    <span>Total</span>
                    <span class="val">{{ currencyFormat($order->total) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        @if($order->shippingAddress)
            <div class="ord-card">
                <h2>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Shipping Address
                </h2>
                <div class="addr-grid">
                    <div class="addr-item addr-full">
                        <div class="lbl">Full Name</div>
                        <div class="val">{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</div>
                    </div>
                    <div class="addr-item addr-full">
                        <div class="lbl">Address</div>
                        <div class="val">
                            {{ $order->shippingAddress->address_line1 }}
                            @if($order->shippingAddress->address_line2)<br>{{ $order->shippingAddress->address_line2 }}@endif
                        </div>
                    </div>
                    <div class="addr-item">
                        <div class="lbl">City</div>
                        <div class="val">{{ $order->shippingAddress->city }}</div>
                    </div>
                    <div class="addr-item">
                        <div class="lbl">State / District</div>
                        <div class="val">{{ $order->shippingAddress->state ?? 'N/A' }}</div>
                    </div>
                    <div class="addr-item">
                        <div class="lbl">Postal Code</div>
                        <div class="val">{{ $order->shippingAddress->postal_code }}</div>
                    </div>
                    <div class="addr-item">
                        <div class="lbl">Country</div>
                        <div class="val">{{ $order->shippingAddress->country }}</div>
                    </div>
                    <div class="addr-item">
                        <div class="lbl">Phone</div>
                        <div class="val">{{ $order->shippingAddress->phone }}</div>
                    </div>
                    <div class="addr-item">
                        <div class="lbl">Email</div>
                        <div class="val">{{ $order->shippingAddress->email }}</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Payment Proof --}}
        @if($order->proof_image)
            <div class="ord-card">
                <h2>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Payment Proof
                </h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                    <div>
                        <div style="font-size:0.7rem;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.15rem;">Transaction ID</div>
                        <div style="font-size:0.875rem;color:#374151;">{{ $order->transaction_id ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.15rem;">Status</div>
                        <div>
                            <span class="s-badge" style="background:{{ $pmc['bg'] }};color:{{ $pmc['fg'] }};">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <img src="{{ $order->proof_image_url }}" alt="Payment Proof" class="proof-img" onclick="window.open(this.src,'_blank')">
            </div>
        @endif

        {{-- Submit Payment --}}
        @if(($order->payment_status === 'unpaid' || $order->payment_status === 'pending') && $order->status !== 'cancelled')
            <div class="ord-card submit-pmt">
                <p>Your payment is pending. Please submit your payment proof to complete the order.</p>
                <a href="{{ route('checkout.success', $order->id) }}" class="btn-pmt">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Submit Payment Proof
                </a>
            </div>
        @endif

        {{-- Reviews --}}
        @if($order->status === 'delivered')
            <div class="ord-card">
                <h2>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Reviews
                </h2>
                @foreach($order->items as $item)
                    @php $rv = $reviews->get($item->product_id);  @endphp
                    <div class="rv-block">
                        <div class="rv-prod">{{ $item->product_name }}</div>
                        <form class="rv-form" method="POST" action="{{ $rv ? route('reviews.update', $rv->id) : route('reviews.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if($rv) @method('PUT') @endif
                            @if(!$rv)
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            @endif
                            <div class="field">
                                <label for="rating_{{ $item->product_id }}">Rating <span style="color:#ef4444;">*</span></label>
                                <select name="rating" id="rating_{{ $item->product_id }}" required>
                                    <option value="">Select</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ $rv && $rv->rating == $i ? 'selected' : '' }}>{{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'][$i - 1] }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="field">
                                <label for="body_{{ $item->product_id }}">Review <span style="color:#9ca3af;font-weight:400;">(optional)</span></label>
                                <textarea name="body" id="body_{{ $item->product_id }}" placeholder="Share your experience with this product...">{{ $rv->body ?? '' }}</textarea>
                            </div>
                            <div class="field">
                                <label for="image_{{ $item->product_id }}">
                                    Image <span style="color:#9ca3af;font-weight:400;">(optional)</span>
                                    @if($rv && $rv->image) <span style="color:#6b7280;font-weight:400;">— leave empty to keep current</span> @endif
                                </label>
                                <input type="file" name="image" id="image_{{ $item->product_id }}" accept="image/*" class="file-input">
                                @if($rv && $rv->image_url)
                                    <div class="cur-img">
                                        <img src="{{ $rv->image_url }}" alt="Current review image">
                                        <button type="button" class="btn-del-img" onclick="confirmDeleteImage({{ $rv->id }})">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            Delete Image
                                        </button>
                                        <form id="deleteImageForm-{{ $rv->id }}" method="POST" action="{{ route('reviews.deleteImage', $rv->id) }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn-rv">{{ $rv ? 'Update Review' : 'Submit Review' }}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function copyOrder() {
    const text = '{{ $order->order_number }}';
    const label = document.getElementById('copyLabel');
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
            label.textContent = 'Copied!';
            setTimeout(() => { label.textContent = 'Copy Order #'; }, 2000);
        });
    } else {
        // Fallback
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        label.textContent = 'Copied!';
        setTimeout(() => { label.textContent = 'Copy Order #'; }, 2000);
    }
}

function confirmDeleteImage(reviewId) {
    Swal.fire({
        title: 'Delete Review Image?',
        text: 'Are you sure you want to delete this review image? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete It',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteImageForm-' + reviewId).submit();
        }
    });
}
</script>
@endsection
