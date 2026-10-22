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
.pr-animate { animation: fadeUp 0.5s ease-out both; }
.pr-animate-d1 { animation-delay: 0.05s; }
.pr-animate-d2 { animation-delay: 0.1s; }
.pr-animate-d3 { animation-delay: 0.15s; }
.pr-animate-d4 { animation-delay: 0.2s; }
.pr-animate-d5 { animation-delay: 0.25s; }

/* ── Page Wrap ── */
.pr-page { }

/* ── Hero ── */
.pr-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.pr-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(99,102,241,0.15) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(139,92,246,0.1) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(59,130,246,0.08) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.pr-hero::after {
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
.pr-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.pr-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.pr-hero .hero-icon {
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
.pr-hero .hero-icon svg { width: 24px; height: 24px; }
.pr-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.pr-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}
.pr-hero .btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    border: none;
    color: #fff;
    border-radius: 0.625rem;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(99,102,241,0.25);
    white-space: nowrap;
}
.pr-hero .btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(99,102,241,0.35);
}

/* ── Stats Grid ── */
.pr-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.pr-stat {
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
.pr-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.pr-stat .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    flex-shrink: 0;
}
.pr-stat .stat-icon svg { width: 18px; height: 18px; }
.pr-stat .stat-info { flex: 1; min-width: 0; }
.pr-stat .stat-info .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.pr-stat .stat-info .stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-top: 0.125rem;
}
.pr-stat .stat-icon.total { background: #eef2ff; color: #6366f1; }
.pr-stat .stat-icon.active { background: #ecfdf5; color: #10b981; }
.pr-stat .stat-icon.inactive { background: #fef2f2; color: #ef4444; }
.pr-stat .stat-icon.instock { background: #ecfdf5; color: #10b981; }
.pr-stat .stat-icon.outstock { background: #fef2f2; color: #ef4444; }

/* ── Success Message ── */
.pr-msg {
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
.pr-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Card ── */
.pr-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.pr-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Toolbar ── */
.pr-toolbar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #edf2f7;
    flex-wrap: wrap;
}
.pr-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.pr-search-wrap .search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    display: flex;
}
.pr-search-wrap .search-icon svg { width: 16px; height: 16px; }
.pr-search-wrap input {
    width: 100%;
    padding: 0.6rem 1rem 0.6rem 2.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    color: #111827;
    background: #fff;
    outline: none;
    transition: all 0.2s ease;
}
.pr-search-wrap input::placeholder { color: #9ca3af; }
.pr-search-wrap input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.pr-toolbar .btn-clear {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.6rem 1.125rem;
    background: #fff;
    border: 1px solid #d1d5db;
    color: #6b7280;
    border-radius: 0.625rem;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.pr-toolbar .btn-clear:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #374151;
}

/* ── Table ── */
.pr-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .pr-table-wrap {
        transform: rotateX(180deg);
    }
    .pr-table-wrap .pr-table {
        transform: rotateX(180deg);
    }
}
.pr-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}
.pr-table thead th {
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
.pr-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.pr-table tbody tr:last-child td { border-bottom: none; }
.pr-table tbody tr { transition: background 0.15s ease; }
.pr-table tbody tr:hover td { background: #f8faff; }
.pr-table tbody tr:active td { background: #f1f4fd; }

/* ── Product Cell ── */
.pr-product-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.pr-product-cell .pr-img {
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 0.5rem;
    object-fit: cover;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
    background: #f3f4f6;
}
.pr-product-cell .pr-img-placeholder {
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 0.5rem;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.65rem;
    flex-shrink: 0;
    border: 1px solid #e5e7eb;
}
.pr-product-cell .pr-info { min-width: 0; }
.pr-product-cell .pr-info .pr-name {
    font-weight: 600;
    color: #111827;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
}
.pr-product-cell .pr-info .pr-category {
    font-size: 0.75rem;
    color: #6b7280;
    display: block;
    margin-top: 0.125rem;
}

/* ── Price Cell ── */
.pr-price-cell {
    white-space: nowrap;
}
.pr-price-cell .price-base {
    font-weight: 600;
    color: #374151;
}
.pr-price-cell .price-sep {
    color: #d1d5db;
    margin: 0 0.25rem;
    font-size: 0.75rem;
}
.pr-price-cell .price-sale {
    font-weight: 600;
    color: #059669;
}

/* ── Stock Cell ── */
.pr-stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.2rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 600;
}
.pr-stock-badge.in-stock {
    background: #ecfdf5;
    color: #065f46;
}
.pr-stock-badge.out-of-stock {
    background: #fef2f2;
    color: #991b1b;
}
.pr-stock-badge .stock-dot {
    width: 0.4rem;
    height: 0.4rem;
    border-radius: 50%;
}
.pr-stock-badge.in-stock .stock-dot { background: #10b981; }
.pr-stock-badge.out-of-stock .stock-dot { background: #ef4444; }

/* ── Discount Badge ── */
.pr-discount-cell { text-align: center; }
.pr-discount-badge {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1px solid #fde68a;
    border-radius: 0.5rem;
    padding: 0.25rem 0.625rem;
    line-height: 1.2;
}
.pr-discount-badge .discount-pct {
    font-size: 0.85rem;
    font-weight: 700;
    color: #b45309;
}
.pr-discount-badge .discount-name {
    font-size: 0.6rem;
    font-weight: 600;
    color: #92400e;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.pr-discount-none {
    color: #d1d5db;
    font-size: 0.85rem;
}

/* ── Status Badge ── */
.pr-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.pr-status-badge.active {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.pr-status-badge.inactive {
    background: linear-gradient(135deg, #fef2f2, #fce4e4);
    color: #991b1b;
    border: 1px solid #fecaca;
}
.pr-status-badge .status-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
}
.pr-status-badge.active .status-dot { background: #10b981; }
.pr-status-badge.inactive .status-dot { background: #ef4444; }

/* ── Actions ── */
.pr-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.375rem;
}
.pr-actions .btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.45rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}
.pr-actions .btn-action:hover { transform: translateY(-1px); }
.pr-actions .btn-edit {
    background: #eef2ff;
    color: #4f46e5;
    border: 1px solid #c7d2fe;
}
.pr-actions .btn-edit:hover {
    background: #e0e7ff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.15);
}
.pr-actions .btn-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.pr-actions .btn-delete:hover {
    background: #fce4e4;
    box-shadow: 0 2px 8px rgba(220,38,38,0.15);
}

/* ── Empty State ── */
.pr-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.pr-empty .empty-icon {
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
.pr-empty .empty-icon svg { width: 28px; height: 28px; }
.pr-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.pr-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Pagination ── */
.pr-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #edf2f7;
}
.pr-pagination nav { display: flex; justify-content: center; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .pr-hero { padding: 1.75rem 1.5rem; }
    .pr-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .pr-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .pr-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .pr-hero .hero-text h1 { font-size: 1.15rem; }
    .pr-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .pr-hero .hero-icon svg { width: 20px; height: 20px; }
    .pr-hero .hero-left { gap: 0.75rem; }
    .pr-hero .btn-add { width: 100%; justify-content: center; }
    .pr-stats { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .pr-stat { padding: 0.75rem 0.875rem; }
    .pr-stat .stat-icon { width: 1.75rem; height: 1.75rem; }
    .pr-stat .stat-icon svg { width: 14px; height: 14px; }
    .pr-stat .stat-info .stat-value { font-size: 1rem; }
    .pr-toolbar { padding: 1rem; flex-direction: column; align-items: stretch; }
    .pr-search-wrap { min-width: 0; }
    .pr-toolbar .btn-clear { justify-content: center; }
    .pr-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .pr-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .pr-product-cell .pr-img, .pr-product-cell .pr-img-placeholder { width: 2.25rem; height: 2.25rem; }
    .pr-product-cell .pr-info .pr-name { max-width: 120px; font-size: 0.8rem; }
    .pr-actions .btn-action { padding: 0.35rem 0.5rem; font-size: 0.72rem; }
    .pr-pagination { padding: 0.75rem 1rem; }
}
@media (max-width: 480px) {
    .pr-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .pr-hero .hero-text h1 { font-size: 1rem; }
    .pr-hero .hero-text p { font-size: 0.75rem; }
    .pr-stats { grid-template-columns: repeat(2, 1fr); }
    .pr-stat { padding: 0.625rem 0.75rem; gap: 0.625rem; }
    .pr-stat .stat-icon { width: 1.5rem; height: 1.5rem; }
    .pr-stat .stat-icon svg { width: 12px; height: 12px; }
    .pr-stat .stat-info .stat-label { font-size: 0.6rem; }
    .pr-stat .stat-info .stat-value { font-size: 0.9rem; }
    .pr-table { min-width: 420px; }
    .pr-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .pr-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .pr-product-cell { gap: 0.5rem; }
    .pr-product-cell .pr-img, .pr-product-cell .pr-img-placeholder { width: 2rem; height: 2rem; }
    .pr-product-cell .pr-info .pr-name { max-width: 80px; font-size: 0.75rem; }
    .pr-product-cell .pr-info .pr-category { font-size: 0.65rem; }
    .pr-actions { gap: 0.25rem; }
    .pr-actions .btn-action { padding: 0.3rem 0.4rem; font-size: 0.68rem; }
    .pr-discount-badge { padding: 0.15rem 0.4rem; }
    .pr-discount-badge .discount-pct { font-size: 0.75rem; }
    .pr-discount-badge .discount-name { font-size: 0.55rem; }
    .pr-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="pr-hero pr-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="hero-text">
                <h1>Products</h1>
                <p>Manage all your store products</p>
            </div>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-add">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Product
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="pr-stats pr-animate pr-animate-d1">
    <div class="pr-stat">
        <div class="stat-icon total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="pr-stat">
        <div class="stat-icon active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Active</div>
            <div class="stat-value">{{ $activeProducts }}</div>
        </div>
    </div>
    <div class="pr-stat">
        <div class="stat-icon inactive">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Inactive</div>
            <div class="stat-value">{{ $inactiveProducts }}</div>
        </div>
    </div>
    <div class="pr-stat">
        <div class="stat-icon instock">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">In Stock</div>
            <div class="stat-value">{{ $inStock }}</div>
        </div>
    </div>
    <div class="pr-stat">
        <div class="stat-icon outstock">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Out of Stock</div>
            <div class="stat-value">{{ $outOfStock }}</div>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="pr-msg success pr-animate pr-animate-d2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Main Card --}}
<div class="pr-card pr-animate pr-animate-d2">
    {{-- Toolbar --}}
    <div class="pr-toolbar">
        <div class="pr-search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" id="liveSearch" value="{{ request('search') }}" placeholder="Search by name, SKU, or brand..." autocomplete="off">
        </div>
        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="btn-clear">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Clear
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="pr-table-wrap">
        <table class="pr-table">
            <thead>
                <tr>
                    <th style="width:5%;">Image</th>
                    <th style="width:28%;">Product</th>
                    <th style="width:18%;">Price (Base | Sale)</th>
                    <th style="width:10%;">Stock</th>
                    <th style="width:12%;" class="pr-discount-cell">Discount</th>
                    <th style="width:10%;">Status</th>
                    <th style="width:17%;" class="right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ $product->image_urls[0] }}" alt="{{ $product->name }}" style="width:2.75rem;height:2.75rem;border-radius:0.5rem;object-fit:cover;border:1px solid #e5e7eb;display:block;">
                            @else
                                <div class="pr-img-placeholder">N/A</div>
                            @endif
                        </td>
                        <td>
                            <div class="pr-product-cell">
                                <div class="pr-info">
                                    <span class="pr-name">{{ $product->name }}</span>
                                    <span class="pr-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="pr-price-cell">
                                <span class="price-base">{{ currencyFormat($product->price) }}</span>
                                @if($product->sale_price)
                                    <span class="price-sep">|</span>
                                    <span class="price-sale">{{ currencyFormat($product->sale_price) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="pr-stock-badge {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                <span class="stock-dot"></span>
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="pr-discount-cell">
                            @if($product->discount_percent)
                                <div class="pr-discount-badge">
                                    <span class="discount-pct">{{ $product->discount_percent }}%</span>
                                    @if($product->discount_name)
                                        <span class="discount-name">{{ $product->discount_name }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="pr-discount-none">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="pr-status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="pr-actions">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-edit">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-action btn-delete delete-btn">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="pr-empty">
                                <div class="empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                                </div>
                                <div class="empty-title">No products yet</div>
                                <div class="empty-sub">Get started by adding your first product.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="pr-pagination">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Delete confirmation
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;
        const form = btn.closest('.delete-form');
        const name = form.closest('tr')?.querySelector('.pr-name')?.textContent?.trim() || 'this product';
        Swal.fire({
            title: 'Delete Product?',
            text: `Are you sure you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });

    // Live search with debounce
    let debounceTimer;
    const searchInput = document.getElementById('liveSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const val = this.value.trim();
                const url = new URL('{{ route('admin.products.index') }}');
                if (val) url.searchParams.set('search', val);
                window.location.href = url.toString();
            }, 400);
        });
    }
</script>
@endpush
