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
.rv-animate { animation: fadeUp 0.5s ease-out both; }
.rv-animate-d1 { animation-delay: 0.05s; }
.rv-animate-d2 { animation-delay: 0.1s; }
.rv-animate-d3 { animation-delay: 0.15s; }
.rv-animate-d4 { animation-delay: 0.2s; }
.rv-animate-d5 { animation-delay: 0.25s; }

/* ── Hero ── */
.rv-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1f1533 40%, #2a1744 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.rv-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(236,72,153,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(244,114,182,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(219,39,119,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.rv-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(236,72,153,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.rv-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.rv-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.rv-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(236,72,153,0.18);
    border-radius: 0.75rem;
    color: #f472b6;
    flex-shrink: 0;
}
.rv-hero .hero-icon svg { width: 24px; height: 24px; }
.rv-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.rv-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}

/* ── Stats Grid ── */
.rv-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.rv-stat {
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
.rv-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.rv-stat .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    flex-shrink: 0;
}
.rv-stat .stat-icon svg { width: 18px; height: 18px; }
.rv-stat .stat-info { flex: 1; min-width: 0; }
.rv-stat .stat-info .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.rv-stat .stat-info .stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-top: 0.125rem;
}
.rv-stat .stat-icon.total { background: #fdf2f8; color: #ec4899; }
.rv-stat .stat-icon.approved { background: #ecfdf5; color: #10b981; }
.rv-stat .stat-icon.pending { background: #fffbeb; color: #f59e0b; }
.rv-stat .stat-icon.replied { background: #eef2ff; color: #6366f1; }
.rv-stat .stat-icon.rating { background: #fff7ed; color: #f97316; }

/* ── Success Message ── */
.rv-msg {
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
.rv-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Card ── */
.rv-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.rv-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Toolbar ── */
.rv-toolbar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #edf2f7;
    flex-wrap: wrap;
}
.rv-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.rv-search-wrap .search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    display: flex;
}
.rv-search-wrap .search-icon svg { width: 16px; height: 16px; }
.rv-search-wrap input {
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
.rv-search-wrap input::placeholder { color: #9ca3af; }
.rv-search-wrap input:focus {
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236,72,153,0.1);
}
.rv-search-spinner {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #e5e7eb;
    border-top-color: #ec4899;
    border-radius: 50%;
    animation: rvSpin 0.6s linear infinite;
    display: none;
    flex-shrink: 0;
}
@keyframes rvSpin { to { transform: rotate(360deg); } }

/* ── Table ── */
.rv-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .rv-table-wrap {
        transform: rotateX(180deg);
    }
    .rv-table-wrap .rv-table {
        transform: rotateX(180deg);
    }
}
.rv-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}
.rv-table thead th {
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
.rv-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.rv-table tbody tr:last-child td { border-bottom: none; }
.rv-table tbody tr { transition: background 0.15s ease; }
.rv-table tbody tr:hover td { background: #fdf2f8; }
.rv-table tbody tr:active td { background: #fce7f3; }

/* ── Product Image Cell ── */
.rv-prod-img {
    width: 2.5rem;
    height: 2.5rem;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    display: block;
    background: #f3f4f6;
}
.rv-prod-placeholder {
    width: 2.5rem;
    height: 2.5rem;
    background: #f3f4f6;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.6rem;
    border: 1px solid #e5e7eb;
}

/* ── Product Link ── */
.rv-prod-link {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: color 0.2s;
}
.rv-prod-link:hover { color: #4338ca; text-decoration: underline; }

/* ── Reviewer Cell ── */
.rv-reviewer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.rv-reviewer .rv-avatar {
    width: 1.75rem;
    height: 1.75rem;
    border-radius: 9999px;
    background: #fdf2f8;
    color: #ec4899;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: 700;
    flex-shrink: 0;
}
.rv-reviewer .rv-name {
    font-weight: 500;
    color: #111827;
    font-size: 0.85rem;
}

/* ── Stars ── */
.rv-stars {
    color: #f59e0b;
    font-size: 0.85rem;
    white-space: nowrap;
    letter-spacing: 1px;
}

/* ── Review Body ── */
.rv-body {
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #6b7280;
    font-size: 0.85rem;
    display: block;
}

/* ── Review Image Thumb ── */
.rv-thumb-wrap {
    position: relative;
    display: inline-block;
}
.rv-thumb-wrap img {
    width: 2.5rem;
    height: 2.5rem;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    transition: transform 0.2s ease;
    display: block;
}
.rv-thumb-wrap img:hover {
    transform: scale(1.1);
}
.rv-thumb-wrap .thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s ease;
    cursor: pointer;
}
.rv-thumb-wrap:hover .thumb-overlay {
    opacity: 1;
}
.rv-thumb-wrap .thumb-overlay svg {
    width: 14px;
    height: 14px;
    color: #fff;
}
.rv-thumb-none {
    color: #d1d5db;
    font-size: 0.8rem;
}

/* ── Reply Badge ── */
.rv-reply-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.rv-reply-badge.replied {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.rv-reply-badge.replied .badge-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #10b981;
}
.rv-reply-badge.no-reply {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}
.rv-reply-badge.no-reply .badge-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #f59e0b;
}

/* ── Date Cell ── */
.rv-date {
    white-space: nowrap;
    font-size: 0.8rem;
    color: #6b7280;
}

/* ── Count ── */
.rv-count {
    padding: 0.75rem 1.5rem;
    font-size: 0.78rem;
    color: #6b7280;
    border-top: 1px solid #edf2f7;
}

/* ── Empty State ── */
.rv-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.rv-empty .empty-icon {
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
.rv-empty .empty-icon svg { width: 28px; height: 28px; }
.rv-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.rv-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Pagination ── */
.rv-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #edf2f7;
}
.rv-pagination nav { display: flex; justify-content: center; }
.rv-pagination .pagination { margin: 0; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .rv-hero { padding: 1.75rem 1.5rem; }
    .rv-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .rv-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .rv-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .rv-hero .hero-text h1 { font-size: 1.15rem; }
    .rv-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .rv-hero .hero-icon svg { width: 20px; height: 20px; }
    .rv-hero .hero-left { gap: 0.75rem; }
    .rv-stats { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .rv-stat { padding: 0.75rem 0.875rem; }
    .rv-stat .stat-icon { width: 1.75rem; height: 1.75rem; }
    .rv-stat .stat-icon svg { width: 14px; height: 14px; }
    .rv-stat .stat-info .stat-value { font-size: 1rem; }
    .rv-toolbar { padding: 1rem; flex-direction: column; align-items: stretch; }
    .rv-search-wrap { min-width: 0; }
    .rv-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .rv-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .rv-prod-img, .rv-prod-placeholder { width: 2rem; height: 2rem; }
    .rv-reviewer .rv-avatar { width: 1.5rem; height: 1.5rem; font-size: 0.6rem; }
    .rv-reviewer .rv-name { font-size: 0.8rem; }
    .rv-body { max-width: 120px; font-size: 0.78rem; }
    .rv-thumb-wrap img { width: 2rem; height: 2rem; }
    .rv-pagination { padding: 0.75rem 1rem; }
}
@media (max-width: 480px) {
    .rv-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .rv-hero .hero-text h1 { font-size: 1rem; }
    .rv-hero .hero-text p { font-size: 0.75rem; }
    .rv-stats { grid-template-columns: repeat(2, 1fr); }
    .rv-stat { padding: 0.625rem 0.75rem; gap: 0.625rem; }
    .rv-stat .stat-icon { width: 1.5rem; height: 1.5rem; }
    .rv-stat .stat-icon svg { width: 12px; height: 12px; }
    .rv-stat .stat-info .stat-label { font-size: 0.6rem; }
    .rv-stat .stat-info .stat-value { font-size: 0.9rem; }
    .rv-table { min-width: 600px; }
    .rv-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .rv-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .rv-prod-img, .rv-prod-placeholder { width: 1.75rem; height: 1.75rem; }
    .rv-reviewer .rv-avatar { width: 1.25rem; height: 1.25rem; font-size: 0.55rem; }
    .rv-reviewer .rv-name { font-size: 0.75rem; }
    .rv-body { max-width: 80px; font-size: 0.72rem; }
    .rv-thumb-wrap img { width: 1.75rem; height: 1.75rem; }
    .rv-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="rv-hero rv-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div class="hero-text">
                <h1>Reviews</h1>
                <p>Manage customer reviews for your products</p>
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="rv-stats rv-animate rv-animate-d1">
    <div class="rv-stat">
        <div class="stat-icon total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Reviews</div>
            <div class="stat-value">{{ $totalReviews }}</div>
        </div>
    </div>
    <div class="rv-stat">
        <div class="stat-icon approved">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Approved</div>
            <div class="stat-value">{{ $approvedReviews }}</div>
        </div>
    </div>
    <div class="rv-stat">
        <div class="stat-icon pending">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $pendingReviews }}</div>
        </div>
    </div>
    <div class="rv-stat">
        <div class="stat-icon replied">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Replied</div>
            <div class="stat-value">{{ $repliedReviews }}</div>
        </div>
    </div>
    <div class="rv-stat">
        <div class="stat-icon rating">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Avg Rating</div>
            <div class="stat-value">{{ $avgRating ? number_format($avgRating, 1) : '0.0' }}</div>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="rv-msg success rv-animate rv-animate-d2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Main Card --}}
<div class="rv-card rv-animate rv-animate-d2">
    {{-- Toolbar --}}
    <div class="rv-toolbar">
        <div class="rv-search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" id="search-input" placeholder="Search by product, reviewer, or review content..." autocomplete="off">
        </div>
        <div class="rv-search-spinner" id="search-spinner"></div>
    </div>

    {{-- Table --}}
    <div id="reviews-table">
        @include('admin.reviews._table')
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search-input');
    const tableContainer = document.getElementById('reviews-table');
    const spinner = document.getElementById('search-spinner');
    let debounceTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const q = this.value.trim();
        debounceTimer = setTimeout(() => fetchReviews(q), 300);
    });

    async function fetchReviews(search) {
        spinner.style.display = 'block';
        try {
            const params = new URLSearchParams({ search });
            if (!search) params.delete('search');
            const res = await fetch(`{{ route('admin.reviews.index') }}?${params}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            tableContainer.innerHTML = data.html;
        } catch (e) {
            console.error('Search failed', e);
        } finally {
            spinner.style.display = 'none';
        }
    }
</script>
@endpush
