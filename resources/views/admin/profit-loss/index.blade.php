@extends('admin.layouts.app')

@push('styles')
<style>
/* ── Animations ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes pulseGlow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50%      { opacity: 0.6; transform: scale(1.05); }
}
.pl-animate { animation: fadeUp 0.5s ease-out both; }
.pl-animate-d1 { animation-delay: 0.05s; }
.pl-animate-d2 { animation-delay: 0.1s; }
.pl-animate-d3 { animation-delay: 0.15s; }
.pl-animate-d4 { animation-delay: 0.2s; }

/* ── Hero ── */
.pl-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #14291e 40%, #1a3328 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.pl-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(16,185,129,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(52,211,153,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(5,150,105,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.pl-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.pl-hero .hero-inner {
    position: relative;
    z-index: 1;
}
.pl-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.pl-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(16,185,129,0.18);
    border-radius: 0.75rem;
    color: #34d399;
    flex-shrink: 0;
}
.pl-hero .hero-icon svg { width: 24px; height: 24px; }
.pl-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.pl-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}

/* ── Filter Bar ── */
.pl-filter {
    background: #fff;
    border-radius: 0.75rem;
    border: 1px solid #e9edf4;
    padding: 1.125rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.pl-filter .filter-group { }
.pl-filter label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.3rem;
}
.pl-filter input[type="date"] {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    color: #111827;
    background: #fff;
    outline: none;
    transition: all 0.2s ease;
    font-family: inherit;
}
.pl-filter input[type="date"]:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
}
.pl-filter .btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1.125rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.pl-filter .btn:hover { transform: translateY(-1px); }
.pl-filter .btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    box-shadow: 0 2px 6px rgba(16,185,129,0.2);
}
.pl-filter .btn-primary:hover {
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
}
.pl-filter .btn-secondary {
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
}
.pl-filter .btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

/* ── Summary Cards ── */
.pl-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.pl-scard {
    background: #fff;
    border-radius: 0.75rem;
    border: 1px solid #e9edf4;
    padding: 1rem 1.125rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.25s ease;
}
.pl-scard:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.pl-scard .sc-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.625rem;
}
.pl-scard .sc-icon svg { width: 16px; height: 16px; }
.pl-scard .sc-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.125rem;
}
.pl-scard .sc-value {
    font-size: 1.15rem;
    font-weight: 800;
    color: #111827;
}
.pl-scard .sc-value.green { color: #059669; }
.pl-scard .sc-value.red { color: #dc2626; }

/* ── Card ── */
.pl-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.pl-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Table ── */
.pl-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .pl-table-wrap {
        transform: rotateX(180deg);
    }
    .pl-table-wrap .pl-table {
        transform: rotateX(180deg);
    }
}
.pl-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}
.pl-table thead th {
    text-align: left;
    padding: 0.75rem 1rem;
    font-size: 0.6rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: #f8fafc;
    border-bottom: 2px solid #e9edf4;
    white-space: nowrap;
}
.pl-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.pl-table tbody tr:last-child td { border-bottom: none; }
.pl-table tbody tr { transition: background 0.15s ease; }
.pl-table tbody tr:hover td { background: #ecfdf5; }
.pl-table tbody tr:active td { background: #d1fae5; }

/* ── Order Link ── */
.pl-order-link {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: color 0.2s;
}
.pl-order-link:hover { color: #4338ca; text-decoration: underline; }

/* ── Product Cell ── */
.pl-prod-cell {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}
.pl-prod-cell .pl-img {
    width: 2.25rem;
    height: 2.25rem;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
    background: #f3f4f6;
}
.pl-prod-cell .pl-img-placeholder {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.6rem;
    flex-shrink: 0;
    border: 1px solid #e5e7eb;
}
.pl-prod-cell .pl-prod-name {
    font-weight: 500;
    color: #111827;
    font-size: 0.85rem;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 160px;
}

/* ── Price Cells ── */
.pl-price {
    font-weight: 600;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
}
.pl-price.sub { color: #374151; }

/* ── Profit/Loss Badge ── */
.pl-pl-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.78rem;
    font-weight: 700;
    font-family: 'Courier New', monospace;
}
.pl-pl-badge.profit {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.pl-pl-badge.loss {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}
.pl-pl-badge .pl-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
}
.pl-pl-badge.profit .pl-dot { background: #10b981; }
.pl-pl-badge.loss .pl-dot { background: #ef4444; }

/* ── Date Cell ── */
.pl-date {
    white-space: nowrap;
    font-size: 0.8rem;
    color: #6b7280;
}

/* ── Empty State ── */
.pl-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.pl-empty .empty-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3.5rem;
    height: 3.5rem;
    background: #f3f4f6;
    border-radius: 1rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}
.pl-empty .empty-icon svg { width: 28px; height: 28px; }
.pl-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.pl-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Pagination ── */
.pl-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #edf2f7;
}
.pl-pagination nav { display: flex; justify-content: center; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .pl-hero { padding: 1.75rem 1.5rem; }
    .pl-summary { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .pl-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .pl-hero .hero-text h1 { font-size: 1.15rem; }
    .pl-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .pl-hero .hero-icon svg { width: 20px; height: 20px; }
    .pl-hero .hero-left { gap: 0.75rem; }
    .pl-summary { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .pl-scard { padding: 0.75rem 0.875rem; }
    .pl-scard .sc-value { font-size: 1rem; }
    .pl-scard .sc-icon { width: 1.75rem; height: 1.75rem; }
    .pl-scard .sc-icon svg { width: 14px; height: 14px; }
    .pl-filter { padding: 0.875rem 1rem; gap: 0.625rem; }
    .pl-filter input[type="date"] { flex: 1; min-width: 120px; }
    .pl-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .pl-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .pl-prod-cell .pl-img,
    .pl-prod-cell .pl-img-placeholder { width: 1.75rem; height: 1.75rem; }
    .pl-prod-cell .pl-prod-name { max-width: 100px; font-size: 0.78rem; }
    .pl-price { font-size: 0.78rem; }
    .pl-pl-badge { font-size: 0.72rem; padding: 0.2rem 0.5rem; }
    .pl-pagination { padding: 0.75rem 1rem; }
}
@media (max-width: 480px) {
    .pl-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .pl-hero .hero-text h1 { font-size: 1rem; }
    .pl-hero .hero-text p { font-size: 0.75rem; }
    .pl-summary { grid-template-columns: repeat(2, 1fr); }
    .pl-scard { padding: 0.625rem 0.75rem; }
    .pl-scard .sc-value { font-size: 0.9rem; }
    .pl-scard .sc-icon { width: 1.5rem; height: 1.5rem; }
    .pl-scard .sc-icon svg { width: 12px; height: 12px; }
    .pl-scard .sc-label { font-size: 0.6rem; }
    .pl-table { min-width: 600px; }
    .pl-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .pl-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .pl-prod-cell .pl-img,
    .pl-prod-cell .pl-img-placeholder { width: 1.5rem; height: 1.5rem; }
    .pl-prod-cell .pl-prod-name { max-width: 70px; font-size: 0.72rem; }
    .pl-price { font-size: 0.72rem; }
    .pl-pl-badge { font-size: 0.68rem; padding: 0.15rem 0.4rem; }
    .pl-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="pl-hero pl-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="hero-text">
                <h1>Profit &amp; Loss</h1>
                <p>Analyze revenue, costs, and profitability by date range</p>
            </div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="pl-filter pl-animate pl-animate-d1">
    <form class="pl-filter" method="GET" action="{{ route('admin.profit-loss.index') }}" style="border:none;padding:0;margin:0;box-shadow:none;width:100%;">
        <div class="filter-group">
            <label for="date_from">Date From</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
        </div>
        <div class="filter-group">
            <label for="date_to">Date To</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
        </div>
        <button type="submit" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 22 7 16 13 16 21 8 21 8 13 2 7 2 3 22 3"/></svg>
            Filter
        </button>
        @if(request('date_from') || request('date_to'))
            <a href="{{ route('admin.profit-loss.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Clear
            </a>
        @endif
    </form>
</div>

{{-- Summary Cards --}}
@if($summary)
    @php
        $profitLoss = $summary->total_revenue - $summary->total_base_cost;
    @endphp
    <div class="pl-summary pl-animate pl-animate-d2">
        <div class="pl-scard">
            <div class="sc-icon" style="background:#eef2ff;color:#6366f1;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
            </div>
            <div class="sc-label">Orders</div>
            <div class="sc-value">{{ $summary->total_orders }}</div>
        </div>
        <div class="pl-scard">
            <div class="sc-icon" style="background:#dbeafe;color:#2563eb;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="sc-label">Items Sold</div>
            <div class="sc-value">{{ $summary->total_qty }}</div>
        </div>
        <div class="pl-scard">
            <div class="sc-icon" style="background:#ecfdf5;color:#059669;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="sc-label">Revenue (Sale)</div>
            <div class="sc-value green">{{ currencyFormat($summary->total_revenue) }}</div>
        </div>
        <div class="pl-scard">
            <div class="sc-icon" style="background:#fef3c7;color:#d97706;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div class="sc-label">Base Cost</div>
            <div class="sc-value">{{ currencyFormat($summary->total_base_cost) }}</div>
        </div>
        <div class="pl-scard">
            <div class="sc-icon" style="background:{{ $profitLoss >= 0 ? '#ecfdf5' : '#fef2f2' }};color:{{ $profitLoss >= 0 ? '#059669' : '#dc2626' }};">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="sc-label">Profit / Loss</div>
            <div class="sc-value {{ $profitLoss >= 0 ? 'green' : 'red' }}">
                {{ $profitLoss >= 0 ? '+' : '' }}{{ currencyFormat($profitLoss) }}
            </div>
        </div>
    </div>
@endif

{{-- Main Card --}}
<div class="pl-card pl-animate {{ $summary ? 'pl-animate-d3' : 'pl-animate-d2' }}">
    <div class="pl-table-wrap">
        <table class="pl-table">
            <thead>
                <tr>
                    <th style="width:12%;">Order</th>
                    <th style="width:9%;">Date</th>
                    <th style="width:24%;">Product</th>
                    <th style="width:11%;">Base Price</th>
                    <th style="width:11%;">Sell Price</th>
                    <th style="width:6%;">Qty</th>
                    <th style="width:12%;">Subtotal</th>
                    <th style="width:15%;">Profit/Loss</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    @php
                        $bp = $item->base_price ?: 0;
                        $sp = $item->product_price;
                        $itemProfit = ($sp - $bp) * $item->quantity;
                        $images = $item->images ? json_decode($item->images, true) : null;
                        $imgUrl = null;
                        if ($images && count($images) > 0) {
                            $imgUrl = config('app.storage_url') . '/' . $images[0];
                        }
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $item->order_id) }}" class="pl-order-link">{{ $item->order_number }}</a>
                        </td>
                        <td>
                            <span class="pl-date">{{ \Carbon\Carbon::parse($item->order_date)->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="pl-prod-cell">
                                @if($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="" class="pl-img">
                                @else
                                    <div class="pl-img-placeholder">N/A</div>
                                @endif
                                <span class="pl-prod-name">{{ $item->product_name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="pl-price" style="color:#6b7280;">{{ currencyFormat($bp) }}</span>
                        </td>
                        <td>
                            <span class="pl-price" style="color:#059669;">{{ currencyFormat($sp) }}</span>
                        </td>
                        <td>
                            <span style="font-weight:600;">{{ $item->quantity }}</span>
                        </td>
                        <td>
                            <span class="pl-price sub">{{ currencyFormat($item->subtotal) }}</span>
                        </td>
                        <td>
                            <span class="pl-pl-badge {{ $itemProfit >= 0 ? 'profit' : 'loss' }}">
                                <span class="pl-dot"></span>
                                {{ $itemProfit >= 0 ? '+' : '' }}{{ currencyFormat($itemProfit) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="pl-empty">
                                <div class="empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <div class="empty-title">No data found</div>
                                <div class="empty-sub">No order items found for the selected date range.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($items, 'links'))
        <div class="pl-pagination">
            {{ $items->links() }}
        </div>
    @endif
</div>
@endsection
