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
.tl-animate { animation: fadeUp 0.5s ease-out both; }
.tl-animate-d1 { animation-delay: 0.05s; }
.tl-animate-d2 { animation-delay: 0.1s; }
.tl-animate-d3 { animation-delay: 0.15s; }
.tl-animate-d4 { animation-delay: 0.2s; }

/* ── Hero ── */
.tl-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
    overflow: hidden;
    isolation: isolate;
}
.tl-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(99,102,241,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(129,140,248,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(59,130,246,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.tl-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.tl-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.tl-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.tl-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(99,102,241,0.18);
    border-radius: 0.75rem;
    color: #818cf8;
    flex-shrink: 0;
}
.tl-hero .hero-icon svg { width: 24px; height: 24px; }
.tl-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.tl-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}
.tl-hero .hero-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.tl-hero .btn-create {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.125rem;
    background: linear-gradient(135deg, #818cf8, #6366f1);
    color: #fff;
    border-radius: 0.5rem;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(99,102,241,0.3);
}
.tl-hero .btn-create:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(99,102,241,0.4);
}

/* ── Stats Grid ── */
.tl-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.tl-stat {
    background: #fff;
    border: 1px solid #e9edf4;
    border-radius: 0.75rem;
    padding: 1rem 1.125rem;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.25s ease;
}
.tl-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.tl-stat .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    flex-shrink: 0;
}
.tl-stat .stat-icon svg { width: 18px; height: 18px; }
.tl-stat .stat-info { flex: 1; min-width: 0; }
.tl-stat .stat-info .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.tl-stat .stat-info .stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-top: 0.125rem;
}
.tl-stat .stat-icon.total { background: #eef2ff; color: #6366f1; }
.tl-stat .stat-icon.pending { background: #fffbeb; color: #f59e0b; }
.tl-stat .stat-icon.approved { background: #ecfdf5; color: #10b981; }
.tl-stat .stat-icon.rejected { background: #fef2f2; color: #ef4444; }

/* ── Success Message ── */
.tl-msg {
    margin-bottom: 1.25rem;
    padding: 0.875rem 1.125rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-weight: 500;
    animation: fadeUp 0.35s ease-out;
}
.tl-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Card ── */
.tl-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.tl-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Table ── */
.tl-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .tl-table-wrap {
        transform: rotateX(180deg);
    }
    .tl-table-wrap .tl-table {
        transform: rotateX(180deg);
    }
}
.tl-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}
.tl-table thead th {
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
.tl-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.tl-table tbody tr:last-child td { border-bottom: none; }
.tl-table tbody tr { transition: background 0.15s ease; }
.tl-table tbody tr:hover td { background: #eef2ff; }
.tl-table tbody tr:active td { background: #e0e7ff; }

/* ── Title Cell ── */
.tl-title-cell {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}
.tl-title-cell .tl-thumb {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    object-fit: cover;
    background: #f3f4f6;
    flex-shrink: 0;
}
.tl-title-cell .tl-title-info { min-width: 0; }
.tl-title-cell .tl-title-info .tl-title {
    font-weight: 600;
    color: #111827;
    display: block;
    font-size: 0.85rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 180px;
}
.tl-title-cell .tl-title-info .tl-type {
    font-size: 0.72rem;
    color: #6b7280;
    display: block;
    margin-top: 0.05rem;
}

/* ── Contact Cell ── */
.tl-contact {
    font-size: 0.82rem;
}
.tl-contact .tl-name { font-weight: 500; color: #111827; }
.tl-contact .tl-phone { font-size: 0.75rem; color: #6b7280; display: block; margin-top: 0.1rem; }

/* ── Location Cell ── */
.tl-location {
    font-size: 0.82rem;
    color: #374151;
}
.tl-location .tl-area { font-weight: 500; }
.tl-location .tl-district { font-size: 0.75rem; color: #6b7280; display: block; }

/* ── Rent Cell ── */
.tl-rent {
    font-weight: 700;
    color: #059669;
    font-size: 0.9rem;
    white-space: nowrap;
}

/* ── Status Badge ── */
.tl-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.72rem;
    font-weight: 600;
    white-space: nowrap;
}
.tl-status.pending {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}
.tl-status.pending .status-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #f59e0b;
}
.tl-status.approved {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.tl-status.approved .status-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #10b981;
}
.tl-status.rejected {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}
.tl-status.rejected .status-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #ef4444;
}

/* ── Actions ── */
.tl-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.25rem;
    flex-wrap: nowrap;
}
.tl-actions .btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    width: 2rem;
    height: 2rem;
    padding: 0;
    border-radius: 0.5rem;
    font-size: 0;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    position: relative;
}
.tl-actions .btn-action svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
}
.tl-actions .btn-action:hover {
    transform: translateY(-1px);
}
.tl-actions .btn-action:active {
    transform: scale(0.92);
}
.tl-actions .btn-action::after {
    content: attr(data-tip);
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%;
    transform: translateX(-50%) scale(0.9);
    background: #1e293b;
    color: #f1f5f9;
    font-size: 0.65rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.18s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    letter-spacing: 0.01em;
}
.tl-actions .btn-action::before {
    content: '';
    position: absolute;
    bottom: calc(100% + 2px);
    left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: #1e293b;
    opacity: 0;
    pointer-events: none;
    transition: all 0.18s ease;
}
.tl-actions .btn-action:hover::after,
.tl-actions .btn-action:hover::before {
    opacity: 1;
}
.tl-actions .btn-action:hover::after {
    transform: translateX(-50%) scale(1);
}
.tl-actions .btn-approve {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}
.tl-actions .btn-approve:hover {
    background: #d1fae5;
    box-shadow: 0 2px 8px rgba(16,185,129,0.2);
    color: #047857;
}
.tl-actions .btn-reject {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.tl-actions .btn-reject:hover {
    background: #fce4e4;
    box-shadow: 0 2px 8px rgba(220,38,38,0.2);
    color: #b91c1c;
}
.tl-actions .btn-edit {
    background: #eef2ff;
    color: #4f46e5;
    border: 1px solid #c7d2fe;
}
.tl-actions .btn-edit:hover {
    background: #e0e7ff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.2);
    color: #4338ca;
}
.tl-actions .btn-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.tl-actions .btn-delete:hover {
    background: #fce4e4;
    box-shadow: 0 2px 8px rgba(220,38,38,0.2);
    color: #b91c1c;
}

/* ── Empty State ── */
.tl-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.tl-empty .empty-icon {
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
.tl-empty .empty-icon svg { width: 28px; height: 28px; }
.tl-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.tl-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Pagination ── */
.tl-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #edf2f7;
}
.tl-pagination nav { display: flex; justify-content: center; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .tl-hero { padding: 1.75rem 1.5rem; }
    .tl-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .tl-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .tl-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .tl-hero .hero-text h1 { font-size: 1.15rem; }
    .tl-stats { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .tl-stat { padding: 0.75rem 0.875rem; }
    .tl-table { min-width: 650px; }
    .tl-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .tl-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .tl-actions .btn-action { width: 1.75rem; height: 1.75rem; }
    .tl-actions .btn-action svg { width: 12px; height: 12px; }
    .tl-title-cell .tl-title-info .tl-title { max-width: 120px; }
}
@media (max-width: 480px) {
    .tl-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .tl-hero .hero-text h1 { font-size: 1rem; }
    .tl-stats { grid-template-columns: repeat(2, 1fr); }
    .tl-table { min-width: 550px; }
    .tl-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .tl-actions { gap: 0.2rem; }
    .tl-actions .btn-action { width: 1.625rem; height: 1.625rem; }
    .tl-actions .btn-action svg { width: 11px; height: 11px; }
    .tl-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="hero-text">
                <h1>To-Let Advertisements</h1>
                <p>Manage rental property listings from users</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.to-let.create') }}" class="btn-create">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Advertisement
            </a>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="tl-stats tl-animate tl-animate-d1">
    <div class="tl-stat">
        <div class="stat-icon total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total</div>
            <div class="stat-value">{{ $total }}</div>
        </div>
    </div>
    <div class="tl-stat">
        <div class="stat-icon pending">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $pending }}</div>
        </div>
    </div>
    <div class="tl-stat">
        <div class="stat-icon approved">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Approved</div>
            <div class="stat-value">{{ $approved }}</div>
        </div>
    </div>
    <div class="tl-stat">
        <div class="stat-icon rejected">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Rejected</div>
            <div class="stat-value">{{ $rejected }}</div>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="tl-msg success tl-animate tl-animate-d2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Main Card --}}
<div class="tl-card tl-animate tl-animate-d2">
    <div class="tl-table-wrap">
        <table class="tl-table">
            <thead>
                <tr>
                    <th style="width:22%;">Property</th>
                    <th style="width:14%;">Contact</th>
                    <th style="width:16%;">Location</th>
                    <th style="width:10%;">Rent</th>
                    <th style="width:10%;">Status</th>
                    <th style="width:10%;">Date</th>
                    <th style="width:18%;" class="right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advertisements as $ad)
                    <tr>
                        <td>
                            <div class="tl-title-cell">
                                @if($ad->first_image)
                                    <img src="{{ $ad->first_image }}" alt="{{ $ad->title }}" class="tl-thumb">
                                @else
                                    <div class="tl-thumb" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:0.7rem;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                                <div class="tl-title-info">
                                    <span class="tl-title">{{ $ad->title }}</span>
                                    <span class="tl-type">{{ ucfirst(str_replace('_', ' ', $ad->property_type)) }} · {{ $ad->bedrooms }} Bed</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="tl-contact">
                                <span class="tl-name">{{ $ad->contact_name }}</span>
                                <span class="tl-phone">{{ $ad->contact_phone }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="tl-location">
                                <span class="tl-area">{{ $ad->area_location }}</span>
                                <span class="tl-district">{{ $ad->district }}, {{ $ad->division }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="tl-rent">৳{{ number_format($ad->monthly_rent, 0) }}</span>
                        </td>
                        <td>
                            <span class="tl-status {{ $ad->status }}">
                                <span class="status-dot"></span>
                                {{ ucfirst($ad->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="tl-date" style="font-size:0.78rem;color:#6b7280;white-space:nowrap;">{{ $ad->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="tl-actions">
                                @if($ad->status === 'pending')
                                    <form action="{{ route('admin.to-let.approve', $ad->id) }}" method="POST" style="display:inline;" class="approve-form">
                                        @csrf
                                        <button type="button" class="btn-action btn-approve approve-btn" data-tip="Approve">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.to-let.reject', $ad->id) }}" method="POST" style="display:inline;" class="reject-form">
                                        @csrf
                                        <button type="button" class="btn-action btn-reject reject-btn" data-tip="Reject">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        </button>
                                    </form>
                                @elseif($ad->status === 'approved')
                                    <form action="{{ route('admin.to-let.reject', $ad->id) }}" method="POST" style="display:inline;" class="reject-form">
                                        @csrf
                                        <button type="button" class="btn-action btn-reject reject-btn" data-tip="Reject">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.to-let.approve', $ad->id) }}" method="POST" style="display:inline;" class="approve-form">
                                        @csrf
                                        <button type="button" class="btn-action btn-approve approve-btn" data-tip="Approve">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.to-let.edit', $ad->id) }}" class="btn-action btn-edit" data-tip="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('admin.to-let.destroy', $ad->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-action btn-delete delete-btn" data-tip="Delete">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="tl-empty">
                                <div class="empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                </div>
                                <div class="empty-title">No advertisements yet</div>
                                <div class="empty-sub">To-Let advertisements will appear here once users submit them.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($advertisements->hasPages())
        <div class="tl-pagination">
            {{ $advertisements->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Approve confirmation
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.approve-btn');
        if (!btn) return;
        const form = btn.closest('.approve-form');
        const title = form.closest('tr')?.querySelector('.tl-title')?.textContent?.trim() || 'this advertisement';
        Swal.fire({
            title: 'Approve Advertisement?',
            text: `Are you sure you want to approve "${title}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, approve it!'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });

    // Reject confirmation with note prompt
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.reject-btn');
        if (!btn) return;
        const form = btn.closest('.reject-form');
        const title = form.closest('tr')?.querySelector('.tl-title')?.textContent?.trim() || 'this advertisement';
        Swal.fire({
            title: 'Reject Advertisement?',
            text: `Are you sure you want to reject "${title}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, reject it!',
            input: 'textarea',
            inputPlaceholder: 'Reason for rejection (optional)',
            inputAttributes: { maxlength: 500 },
            preConfirm: () => {
                const note = Swal.getInput()?.value || '';
                // Add hidden input for admin_note
                let input = form.querySelector('input[name="admin_note"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'admin_note';
                    form.appendChild(input);
                }
                input.value = note;
                form.submit();
            }
        });
    });

    // Delete confirmation
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;
        const form = btn.closest('.delete-form');
        const title = form.closest('tr')?.querySelector('.tl-title')?.textContent?.trim() || 'this advertisement';
        Swal.fire({
            title: 'Delete Advertisement?',
            text: `Are you sure you want to delete "${title}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });
</script>
@endpush
