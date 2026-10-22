@extends('frontend.layouts.app')

@section('title', 'My Orders')

@push('styles')
<style>
    /* ─── HERO ─── */
    .orders-hero {
        background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 50%, #FEFCE8 100%);
        padding: 2.5rem 1rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .orders-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .orders-hero h1 { font-size: 1.75rem; font-weight: 700; color: #212529; letter-spacing: -0.02em; position: relative; }
    .orders-hero p { color: #6b7280; font-size: 0.875rem; margin-top: 0.375rem; position: relative; }

    /* ─── WRAP ─── */
    .orders-wrap { max-width: 56rem; margin: 0 auto; padding: 1.5rem 1rem 4rem; animation: ordFadeUp 0.4s ease-out; }

    /* ─── ALERT ─── */
    .alert-box {
        display: flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 1rem; border-radius: 0.5rem;
        font-size: 0.8125rem; margin-bottom: 1.25rem;
    }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

    /* ─── SUMMARY ─── */
    .ord-summary {
        display: flex; align-items: center; justify-content: space-between;
        gap: 0.75rem; margin-bottom: 1.25rem; flex-wrap: wrap;
    }
    .ord-summary .total-badge {
        display: inline-flex; align-items: center; gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        background: #ffffff; border: 1px solid #e9ecef;
        border-radius: 9999px; font-size: 0.8125rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .ord-summary .total-badge strong { color: #212529; }

    /* ─── ORDER CARDS ─── */
    .ord-list { display: flex; flex-direction: column; gap: 0.75rem; }

    .ord-card {
        background: #ffffff; border-radius: 0.75rem;
        border: 1px solid #e9ecef; padding: 1.125rem 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .ord-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        border-color: rgba(46,139,87,0.2);
    }
    .ord-card:active { transform: translateY(0); }

    .ord-card .ord-top {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.5rem;
    }
    .ord-card .ord-num {
        display: flex; align-items: center; gap: 0.5rem;
        font-weight: 600; font-size: 0.9375rem; color: #212529;
    }
    .ord-card .ord-num .copy-btn {
        font-size: 0.6875rem; color: #2E8B57; cursor: pointer;
        font-weight: 500; background: none; border: none; padding: 0;
        transition: color 0.2s;
    }
    .ord-card .ord-num .copy-btn:hover { color: #1B5E20; }

    .ord-card .ord-meta {
        display: flex; align-items: center; gap: 1rem;
        font-size: 0.75rem; color: #9ca3af; margin-top: 0.25rem;
    }
    .ord-card .ord-meta span { display: flex; align-items: center; gap: 0.25rem; }

    .ord-card .ord-bottom {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.75rem; margin-top: 0.75rem;
        padding-top: 0.75rem; border-top: 1px solid #f3f4f6;
    }
    .ord-card .ord-bottom .right { display: flex; align-items: center; gap: 0.75rem; }

    .ord-card .ord-amount { font-weight: 700; font-size: 1.0625rem; color: #2E8B57; }
    .ord-card .ord-pmt {
        font-size: 0.6875rem; color: #9ca3af;
        display: flex; align-items: center; gap: 0.25rem;
    }

    /* ─── STATUS BADGES ─── */
    .s-badge {
        display: inline-flex; flex-direction: column; align-items: center;
        padding: 0.1875rem 0.75rem; border-radius: 9999px;
        font-size: 0.6875rem; font-weight: 600; line-height: 1.4;
        text-align: center;
    }
    .s-badge .sub { font-size: 0.6rem; font-weight: 400; opacity: 0.85; }

    /* ─── ACTION BUTTONS ─── */
    .ord-actions { display: flex; align-items: center; gap: 0.5rem; }
    .btn-view {
        display: inline-flex; align-items: center; gap: 0.375rem;
        padding: 0.375rem 0.875rem; border-radius: 0.5rem;
        font-size: 0.75rem; font-weight: 600;
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff; text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(46,139,87,0.15);
    }
    .btn-view:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(46,139,87,0.25); color: #fff; }

    .btn-cancel {
        display: inline-flex; align-items: center; gap: 0.375rem;
        padding: 0.375rem 0.75rem; border-radius: 0.5rem;
        font-size: 0.75rem; font-weight: 600;
        background: #ffffff; color: #ef4444;
        border: 1.5px solid #fecaca; cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-cancel:hover { background: #fef2f2; border-color: #fca5a5; }

    /* ─── EMPTY STATE ─── */
    .ord-empty {
        padding: 4rem 2rem; text-align: center;
        background: #ffffff; border-radius: 0.75rem;
        border: 1px solid #e9ecef;
    }
    .ord-empty .empty-icon {
        display: flex; align-items: center; justify-content: center;
        width: 4rem; height: 4rem; margin: 0 auto 1rem;
        background: #F0FDF4; border-radius: 50%; color: #2E8B57;
    }
    .ord-empty h3 { font-size: 1.125rem; font-weight: 600; color: #212529; margin-bottom: 0.25rem; }
    .ord-empty p { font-size: 0.8125rem; color: #6b7280; margin-bottom: 1.25rem; }
    .ord-empty .shop-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371); color: #fff;
        padding: 0.625rem 1.5rem; border-radius: 0.5rem;
        text-decoration: none; font-size: 0.875rem; font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(46,139,87,0.2);
    }
    .ord-empty .shop-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(46,139,87,0.3); }

    /* ─── PAGINATION ─── */
    .ord-pagi { margin-top: 1.5rem; display: flex; justify-content: center; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .orders-hero { padding: 1.5rem 1rem 1.25rem; }
        .orders-hero h1 { font-size: 1.375rem; }
        .orders-wrap { padding: 1rem 1rem 3rem; }
        .ord-summary { flex-direction: column; align-items: flex-start; gap: 0.25rem; }
    }
    @media (max-width: 480px) {
        .ord-card .ord-top { flex-direction: column; align-items: flex-start; }
        .ord-card .ord-bottom { flex-direction: column; align-items: flex-start; }
        .ord-card .ord-bottom .right { width: 100%; justify-content: space-between; }
        .ord-card { padding: 0.875rem 1rem; }
    }

    /* ─── ANIMATIONS ─── */
    @keyframes ordFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<section class="orders-hero">
    <h1>My Orders</h1>
    <p>Track and manage all your orders in one place</p>
</section>

<div class="orders-wrap">
    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert-box alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary --}}
    <div class="ord-summary">
        <span class="total-badge">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M15 3v18M3 9h18M3 15h18"/></svg>
            Total Orders: <strong>{{ $orders->total() }}</strong>
        </span>
        @if($orders->count() < $orders->total())
            <span style="font-size:0.75rem;color:#9ca3af;">Showing page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>
        @endif
    </div>

    {{-- Order List --}}
    @if($orders->count() > 0)
        <div class="ord-list">
            @foreach($orders as $order)
                <div class="ord-card" onclick="window.location='{{ route('orders.show', $order->id) }}'">
                    {{-- Top Row --}}
                    <div class="ord-top">
                        <div>
                            <div class="ord-num">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M15 3v18M3 9h18M3 15h18"/></svg>
                                {{ $order->order_number }}
                                <span class="copy-btn" onclick="event.stopPropagation(); copyOrder('{{ $order->order_number }}', this)">Copy</span>
                            </div>
                            <div class="ord-meta">
                                <span>
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $order->created_at->format('M d, Y \\a\\t h:i A') }}
                                </span>
                                <span>
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $order->email ?? 'Guest' }}
                                </span>
                            </div>
                        </div>
                        {{-- Status Badge --}}
                        <span class="s-badge" style="background: {{ $order->status === 'cancelled' ? '#fef2f2' : ($order->status === 'pending' ? '#fef9c3' : ($order->status === 'processing' ? '#dbeafe' : ($order->status === 'shipped' ? '#e0e7ff' : ($order->status === 'delivered' ? '#f0fdf4' : '#fef2f2')))) }}; color: {{ $order->status === 'cancelled' ? '#991b1b' : ($order->status === 'pending' ? '#854d0e' : ($order->status === 'processing' ? '#1e40af' : ($order->status === 'shipped' ? '#3730a3' : ($order->status === 'delivered' ? '#166534' : '#991b1b')))) }};">
                            {{ ucfirst($order->status) }}
                            @if($order->status === 'cancelled' && $order->cancelled_by)
                                <span class="sub">by {{ $order->cancelled_by === 'user' ? 'You' : 'Admin' }}</span>
                            @endif
                        </span>
                    </div>

                    {{-- Bottom Row --}}
                    <div class="ord-bottom">
                        <div class="ord-amount">{{ currencyFormat($order->total) }}</div>
                        <div class="right">
                            {{-- Payment Status --}}
                            <span class="ord-pmt">
                                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                <span style="font-weight:500;color:{{ $order->payment_status === 'paid' || $order->payment_status === 'approved' ? '#166534' : ($order->payment_status === 'rejected' || $order->payment_status === 'cancelled' ? '#991b1b' : '#854d0e') }};">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </span>
                            {{-- Actions --}}
                            <div class="ord-actions" onclick="event.stopPropagation();">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    View
                                </a>
                                @if(in_array($order->status, ['pending', 'processing']))
                                    <button type="button" class="btn-cancel" onclick="event.stopPropagation(); confirmCancel({{ $order->id }}, '{{ $order->order_number }}')">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="ord-pagi">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="ord-empty">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M15 3v18M3 9h18M3 15h18"/></svg>
            </div>
            <h3>No orders yet</h3>
            <p>You haven't placed any orders yet. Start shopping to see your orders here.</p>
            <a href="{{ route('products.index') }}" class="shop-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                Browse Products
            </a>
        </div>
    @endif
</div>

{{-- SweetAlert & JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const cancelUrl = '{{ route("orders.cancel", "_id_") }}';
    const csrfToken = '{{ csrf_token() }}';

    function copyOrder(text, el) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = el.textContent;
            el.textContent = 'Copied!';
            el.style.color = '#16a34a';
            setTimeout(() => {
                el.textContent = orig;
                el.style.color = '';
            }, 1800);
        }).catch(() => {
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

    function confirmCancel(orderId, orderNumber) {
        Swal.fire({
            title: 'Cancel Order?',
            html: `Are you sure you want to cancel order <strong>${orderNumber}</strong>?<br><br>This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Cancel It',
            cancelButtonText: 'Keep Order',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(cancelUrl.replace('_id_', orderId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({ '_method': 'PATCH', '_token': csrfToken })
                }).then(res => {
                    if (!res.ok) throw new Error('Failed to cancel order');
                    return res;
                }).catch(err => {
                    Swal.showValidationMessage('Something went wrong. Please try again.');
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Cancelled!',
                    text: `Order ${orderNumber} has been cancelled.`,
                    icon: 'success',
                    confirmButtonColor: '#2E8B57',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.reload();
                });
            }
        });
    }
</script>
@endsection
