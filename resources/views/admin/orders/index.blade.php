@extends('admin.layouts.app')

@push('styles')
<style>
/* ── Hero ── */
.ord-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    margin: -2rem -2rem 1.5rem;
    padding: 2rem 2rem 2.5rem;
    position: relative;
    overflow: hidden;
}
.ord-hero::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -5%;
    width: 25rem;
    height: 25rem;
    background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.ord-hero::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: 10%;
    width: 15rem;
    height: 15rem;
    background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.ord-hero .hero-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
    z-index: 1;
}
.ord-hero h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.ord-hero h1 svg { color: #818cf8; }
.ord-hero p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}

/* ── Stats Pills ── */
.ord-stats {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
}
.ord-stats .stat-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.3rem 0.75rem 0.3rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    transition: all 0.2s;
}
.ord-stats .stat-pill .dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    flex-shrink: 0;
}
.ord-stats .stat-pill strong { font-weight: 700; }
.ord-stats .stat-pill:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

/* ── Card ── */
.ord-card {
    background: #fff;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

/* ── Success Msg ── */
.ord-success {
    margin-bottom: 1rem;
    padding: 0.75rem 1rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* ── Filters ── */
.ord-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 1rem;
}
.ord-filters .fi {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.825rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fff;
}
.ord-filters .fi:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.ord-filters .fi-search { flex: 1; min-width: 200px; }
.ord-filters .fi-date { width: 150px; }
.ord-filters .btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: #6366f1;
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.825rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.ord-filters .btn-filter:hover { background: #4f46e5; }
.ord-filters .btn-clear {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: #fff;
    color: #6b7280;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.825rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.ord-filters .btn-clear:hover { background: #f9fafb; border-color: #9ca3af; }

/* ── Table ── */
.ord-table-wrap {
    overflow-x: auto;
}
.ord-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}
.ord-table thead th {
    text-align: left;
    padding: 0.75rem 0.5rem;
    font-size: 0.65rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 2px solid #e5e7eb;
}
.ord-table tbody tr {
    border-bottom: 1px solid #f3f4f6;
    transition: background 0.15s;
}
.ord-table tbody tr:hover { background: #f8faff; }
.ord-table tbody td {
    padding: 0.75rem 0.5rem;
    font-size: 0.85rem;
    color: #374151;
}
.ord-table .ord-num { font-weight: 600; color: #111827; }
.ord-table .ord-total { font-weight: 600; }
.ord-table .ord-date { color: #6b7280; font-size: 0.8rem; }
.ord-table .ord-empty {
    text-align: center;
    padding: 2.5rem;
    color: #9ca3af;
}
.ord-table .ord-empty svg { margin: 0 auto 0.5rem; display: block; }

/* Status Badge */
.ord-badge {
    display: inline-flex;
    flex-direction: column;
    padding: 0.125rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 600;
    line-height: 1.4;
}
.ord-badge .sub { font-size: 0.55rem; font-weight: 500; opacity: 0.75; }

/* View Link */
.ord-view {
    color: #6366f1;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 600;
    transition: color 0.2s;
}
.ord-view:hover { color: #4f46e5; text-decoration: underline; }

/* ── Pagination ── */
.ord-pagi {
    margin-top: 1rem;
    display: flex;
    justify-content: center;
}
.ord-pagi nav [rel] { display: flex; gap: 0.25rem; flex-wrap: wrap; }
.ord-pagi a, .ord-pagi span {
    padding: 0.4rem 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    color: #374151;
    text-decoration: none;
    transition: all 0.2s;
}
.ord-pagi a:hover { background: #f3f4f6; border-color: #d1d5db; }
.ord-pagi span[aria-current="page"] {
    background: #6366f1;
    border-color: #6366f1;
    color: #fff;
    font-weight: 600;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .ord-hero { margin: -1rem -1rem 1rem; padding: 1.25rem 1rem 1.5rem; }
    .ord-hero h1 { font-size: 1.15rem; flex-wrap: wrap; }
    .ord-card { padding: 1rem; }
    .ord-filters .fi-search { min-width: 140px; }
    .ord-filters .fi-date { width: 130px; }
    .ord-stats { gap: 0.375rem; }
    .ord-stats .stat-pill { font-size: 0.65rem; padding: 0.2rem 0.5rem 0.2rem 0.375rem; }
    .ord-table-wrap { overflow-x: auto; }
    .ord-table { min-width: 480px; }
    .ord-table thead th { padding: 0.5rem 0.375rem; font-size: 0.6rem; }
    .ord-table tbody td { padding: 0.5rem 0.375rem; font-size: 0.78rem; }
}
@media (max-width: 480px) {
    .ord-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1rem 0.75rem 1.25rem; }
    .ord-hero h1 { font-size: 1rem; }
    .ord-card { padding: 0.75rem; border-radius: 0.5rem; }
    .ord-filters { gap: 0.375rem; }
    .ord-filters .fi { font-size: 0.75rem; padding: 0.375rem 0.5rem; }
    .ord-filters .fi-search { min-width: 100%; }
    .ord-filters .fi-date { width: calc(50% - 0.25rem); }
    .ord-filters .btn-filter { font-size: 0.75rem; padding: 0.375rem 0.75rem; }
    .ord-table { min-width: 400px; }
    .ord-table thead th { padding: 0.375rem 0.25rem; font-size: 0.55rem; }
    .ord-table tbody td { padding: 0.375rem 0.25rem; font-size: 0.72rem; }
    .ord-stats .stat-pill { font-size: 0.6rem; padding: 0.15rem 0.4rem 0.15rem 0.3rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="ord-hero">
    <div class="hero-row">
        <div>
            <h1>
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                Orders
            </h1>
            <p>Manage all customer orders</p>
        </div>
    </div>
</div>

<div class="ord-card">

    {{-- Stats --}}
    <div class="ord-stats">
        <span class="stat-pill"><span class="dot" style="background:#6b7280;"></span> Total: <strong>{{ $totalOrders }}</strong></span>
        <span class="stat-pill" style="background:#fef9c3;border-color:#fde68a;"><span class="dot" style="background:#f59e0b;"></span> Pending: <strong>{{ $pendingCount }}</strong></span>
        <span class="stat-pill" style="background:#dbeafe;border-color:#bfdbfe;"><span class="dot" style="background:#3b82f6;"></span> Processing: <strong>{{ $processingCount }}</strong></span>
        <span class="stat-pill" style="background:#e0e7ff;border-color:#c7d2fe;"><span class="dot" style="background:#8b5cf6;"></span> Shipped: <strong>{{ $shippedCount }}</strong></span>
        <span class="stat-pill" style="background:#f0fdf4;border-color:#bbf7d0;"><span class="dot" style="background:#16a34a;"></span> Delivered: <strong>{{ $deliveredCount }}</strong></span>
        <span class="stat-pill" style="background:#fef2f2;border-color:#fecaca;"><span class="dot" style="background:#ef4444;"></span> Cancelled: <strong>{{ $cancelledCount }}</strong></span>
        <span class="stat-pill"><span class="dot" style="background:#9ca3af;"></span> Unpaid: <strong>{{ $unpaidCount }}</strong></span>
        <span class="stat-pill" style="background:#dbeafe;border-color:#bfdbfe;"><span class="dot" style="background:#2563eb;"></span> Paid: <strong>{{ $paidCount }}</strong></span>
        <span class="stat-pill" style="background:#f0fdf4;border-color:#bbf7d0;"><span class="dot" style="background:#059669;"></span> Approved: <strong>{{ $approvedCount }}</strong></span>
        <span class="stat-pill" style="background:#fef2f2;border-color:#fecaca;"><span class="dot" style="background:#dc2626;"></span> Rejected: <strong>{{ $rejectedCount }}</strong></span>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="ord-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="ord-filters">
        <input type="text" id="liveSearch" value="{{ request('search') }}" placeholder="Search by order # or email..." class="fi fi-search">
        <input type="date" id="dateFrom" value="{{ request('date_from') }}" class="fi fi-date">
        <input type="date" id="dateTo" value="{{ request('date_to') }}" class="fi fi-date">
        <button id="filterBtn" class="btn-filter">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            Filter
        </button>
        @if(request('search') || request('date_from') || request('date_to'))
            <a href="{{ route('admin.orders.index') }}" class="btn-clear">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Clear
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="ord-table-wrap">
        <table class="ord-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="ord-num">{{ $order->order_number }}</td>
                        <td>{{ $order->email ?? 'N/A' }}</td>
                        <td class="ord-total">{{ currencyFormat($order->total) }}</td>
                        <td>
                            <span class="ord-badge" style="background:{{ $order->status === 'pending' ? '#fef9c3' : ($order->status === 'processing' ? '#dbeafe' : ($order->status === 'shipped' ? '#e0e7ff' : ($order->status === 'delivered' ? '#f0fdf4' : '#fef2f2'))) }};color:{{ $order->status === 'pending' ? '#854d0e' : ($order->status === 'processing' ? '#1e40af' : ($order->status === 'shipped' ? '#3730a3' : ($order->status === 'delivered' ? '#166534' : '#991b1b'))) }};">
                                {{ ucfirst($order->status) }}
                                @if($order->status === 'cancelled' && $order->cancelled_by)
                                    <span class="sub">by {{ ucfirst($order->cancelled_by) }}</span>
                                @endif
                            </span>
                        </td>
                        <td class="ord-date">{{ $order->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="ord-view">
                                View &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="ord-empty">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                No orders yet.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="ord-pagi">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    let debounceTimer;
    document.getElementById('liveSearch').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { applyFilters(); }, 400);
    });
    document.getElementById('filterBtn').addEventListener('click', function () { applyFilters(); });
    function applyFilters() {
        const search = document.getElementById('liveSearch').value.trim();
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;
        const url = new URL(window.location.origin + window.location.pathname);
        if (search) url.searchParams.set('search', search);
        if (dateFrom) url.searchParams.set('date_from', dateFrom);
        if (dateTo) url.searchParams.set('date_to', dateTo);
        window.location.href = url.toString();
    }
</script>
@endpush
