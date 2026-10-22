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
.pd-animate { animation: fadeUp 0.5s ease-out both; }
.pd-animate-d1 { animation-delay: 0.05s; }
.pd-animate-d2 { animation-delay: 0.1s; }
.pd-animate-d3 { animation-delay: 0.15s; }
.pd-animate-d4 { animation-delay: 0.2s; }
.pd-animate-d5 { animation-delay: 0.25s; }

/* ── Hero ── */
.pd-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.pd-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(59,130,246,0.15) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(96,165,250,0.1) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(37,99,235,0.08) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.pd-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.pd-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.pd-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.pd-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(59,130,246,0.18);
    border-radius: 0.75rem;
    color: #60a5fa;
    flex-shrink: 0;
}
.pd-hero .hero-icon svg { width: 24px; height: 24px; }
.pd-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.pd-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}
.pd-hero .btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    color: #fff;
    border-radius: 0.625rem;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(59,130,246,0.25);
    white-space: nowrap;
}
.pd-hero .btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(59,130,246,0.35);
}

/* ── Stats Grid ── */
.pd-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.pd-stat {
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
.pd-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.pd-stat .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    flex-shrink: 0;
}
.pd-stat .stat-icon svg { width: 18px; height: 18px; }
.pd-stat .stat-info { flex: 1; min-width: 0; }
.pd-stat .stat-info .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.pd-stat .stat-info .stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-top: 0.125rem;
}
.pd-stat .stat-icon.total { background: #eef2ff; color: #6366f1; }
.pd-stat .stat-icon.active { background: #ecfdf5; color: #10b981; }
.pd-stat .stat-icon.inactive { background: #fef2f2; color: #ef4444; }

/* ── Success Message ── */
.pd-msg {
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
.pd-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Card ── */
.pd-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.pd-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Toolbar ── */
.pd-toolbar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #edf2f7;
    flex-wrap: wrap;
}
.pd-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.pd-search-wrap .search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    display: flex;
}
.pd-search-wrap .search-icon svg { width: 16px; height: 16px; }
.pd-search-wrap input {
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
.pd-search-wrap input::placeholder { color: #9ca3af; }
.pd-search-wrap input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
.pd-search-spinner {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #e5e7eb;
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: pdSpin 0.6s linear infinite;
    display: none;
    flex-shrink: 0;
}
@keyframes pdSpin { to { transform: rotate(360deg); } }

/* ── Table ── */
.pd-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .pd-table-wrap {
        transform: rotateX(180deg);
    }
    .pd-table-wrap .pd-table {
        transform: rotateX(180deg);
    }
}
.pd-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 550px;
}
.pd-table thead th {
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
.pd-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.pd-table tbody tr:last-child td { border-bottom: none; }
.pd-table tbody tr { transition: background 0.15s ease; }
.pd-table tbody tr:hover td { background: #eff6ff; }
.pd-table tbody tr:active td { background: #dbeafe; }

/* ── Bank Cell ── */
.pd-bank-cell {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}
.pd-bank-cell .bank-icon {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    background: #eef2ff;
    color: #6366f1;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pd-bank-cell .bank-icon svg { width: 16px; height: 16px; }
.pd-bank-cell .bank-info { min-width: 0; }
.pd-bank-cell .bank-info .bank-name {
    font-weight: 600;
    color: #111827;
    display: block;
    font-size: 0.85rem;
}
.pd-bank-cell .bank-info .bank-holder {
    font-size: 0.72rem;
    color: #6b7280;
    display: block;
    margin-top: 0.05rem;
}

/* ── Account Cell ── */
.pd-account {
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    color: #374151;
    letter-spacing: 0.5px;
    background: #f9fafb;
    padding: 0.2rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-block;
}

/* ── Status Badge ── */
.pd-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.pd-status.active {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.pd-status.active .sdot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #10b981;
}
.pd-status.inactive {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}
.pd-status.inactive .sdot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #ef4444;
}

/* ── Actions ── */
.pd-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.375rem;
}
.pd-actions .btn-action {
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
.pd-actions .btn-action:hover { transform: translateY(-1px); }
.pd-actions .btn-edit {
    background: #eef2ff;
    color: #4f46e5;
    border: 1px solid #c7d2fe;
}
.pd-actions .btn-edit:hover {
    background: #e0e7ff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.15);
}
.pd-actions .btn-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.pd-actions .btn-delete:hover {
    background: #fce4e4;
    box-shadow: 0 2px 8px rgba(220,38,38,0.15);
}

/* ── Empty State ── */
.pd-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.pd-empty .empty-icon {
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
.pd-empty .empty-icon svg { width: 28px; height: 28px; }
.pd-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.pd-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Pagination ── */
.pd-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #edf2f7;
}
.pd-pagination nav { display: flex; justify-content: center; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .pd-hero { padding: 1.75rem 1.5rem; }
    .pd-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .pd-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .pd-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .pd-hero .hero-text h1 { font-size: 1.15rem; }
    .pd-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .pd-hero .hero-icon svg { width: 20px; height: 20px; }
    .pd-hero .hero-left { gap: 0.75rem; }
    .pd-hero .btn-add { width: 100%; justify-content: center; }
    .pd-stats { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .pd-stat { padding: 0.75rem 0.875rem; }
    .pd-stat .stat-icon { width: 1.75rem; height: 1.75rem; }
    .pd-stat .stat-icon svg { width: 14px; height: 14px; }
    .pd-stat .stat-info .stat-value { font-size: 1rem; }
    .pd-toolbar { padding: 1rem; flex-direction: column; align-items: stretch; }
    .pd-search-wrap { min-width: 0; }
    .pd-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .pd-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .pd-bank-cell .bank-icon { width: 1.75rem; height: 1.75rem; }
    .pd-bank-cell .bank-icon svg { width: 14px; height: 14px; }
    .pd-bank-cell .bank-info .bank-name { font-size: 0.8rem; }
    .pd-bank-cell .bank-info .bank-holder { font-size: 0.65rem; }
    .pd-account { font-size: 0.78rem; }
    .pd-actions .btn-action { padding: 0.35rem 0.5rem; font-size: 0.72rem; }
    .pd-pagination { padding: 0.75rem 1rem; }
}
@media (max-width: 480px) {
    .pd-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .pd-hero .hero-text h1 { font-size: 1rem; }
    .pd-hero .hero-text p { font-size: 0.75rem; }
    .pd-stats { grid-template-columns: repeat(2, 1fr); }
    .pd-stat { padding: 0.625rem 0.75rem; gap: 0.625rem; }
    .pd-stat .stat-icon { width: 1.5rem; height: 1.5rem; }
    .pd-stat .stat-icon svg { width: 12px; height: 12px; }
    .pd-stat .stat-info .stat-label { font-size: 0.6rem; }
    .pd-stat .stat-info .stat-value { font-size: 0.9rem; }
    .pd-table { min-width: 450px; }
    .pd-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .pd-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .pd-bank-cell .bank-icon { width: 1.5rem; height: 1.5rem; }
    .pd-bank-cell .bank-icon svg { width: 12px; height: 12px; }
    .pd-bank-cell .bank-info .bank-name { font-size: 0.75rem; }
    .pd-bank-cell .bank-info .bank-holder { font-size: 0.6rem; }
    .pd-account { font-size: 0.72rem; }
    .pd-actions { gap: 0.25rem; }
    .pd-actions .btn-action { padding: 0.3rem 0.4rem; font-size: 0.68rem; }
    .pd-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="pd-hero pd-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div class="hero-text">
                <h1>Payment Details</h1>
                <p>Manage bank accounts and payment instructions</p>
            </div>
        </div>
        <a href="{{ route('admin.payment-details.create') }}" class="btn-add">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="pd-stats pd-animate pd-animate-d1">
    <div class="pd-stat">
        <div class="stat-icon total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Accounts</div>
            <div class="stat-value">{{ $totalCount }}</div>
        </div>
    </div>
    <div class="pd-stat">
        <div class="stat-icon active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Active</div>
            <div class="stat-value">{{ $activeCount }}</div>
        </div>
    </div>
    <div class="pd-stat">
        <div class="stat-icon inactive">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Inactive</div>
            <div class="stat-value">{{ $inactiveCount }}</div>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="pd-msg success pd-animate pd-animate-d2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Main Card --}}
<div class="pd-card pd-animate pd-animate-d2">
    {{-- Toolbar --}}
    <div class="pd-toolbar">
        <div class="pd-search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" id="search-input" placeholder="Search by bank, account number, or holder..." autocomplete="off">
        </div>
        <div class="pd-search-spinner" id="search-spinner"></div>
    </div>

    {{-- Table --}}
    <div id="pd-table">
        @include('admin.payment-details._table')
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Delete confirmation
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;
        const form = btn.closest('.delete-form');
        const bankName = form.closest('tr')?.querySelector('.bank-name')?.textContent?.trim() || 'this account';
        Swal.fire({
            title: 'Delete Payment Detail?',
            text: `Are you sure you want to delete ${bankName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });

    // AJAX Search
    const searchInput = document.getElementById('search-input');
    const tableContainer = document.getElementById('pd-table');
    const spinner = document.getElementById('search-spinner');

    searchInput?.addEventListener('input', function () {
        clearTimeout(this._timer);
        const q = this.value.trim();
        this._timer = setTimeout(async () => {
            spinner.style.display = 'block';
            try {
                const params = new URLSearchParams({ search: q });
                if (!q) params.delete('search');
                const res = await fetch('{{ route('admin.payment-details.index') }}?' + params, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                tableContainer.innerHTML = data.html;
            } catch (e) {
                console.error('Search failed', e);
            } finally {
                spinner.style.display = 'none';
            }
        }, 300);
    });
</script>
@endpush
