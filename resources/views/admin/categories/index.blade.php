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
.ci-animate { animation: fadeUp 0.5s ease-out both; }
.ci-animate-d1 { animation-delay: 0.05s; }
.ci-animate-d2 { animation-delay: 0.1s; }
.ci-animate-d3 { animation-delay: 0.15s; }
.ci-animate-d4 { animation-delay: 0.2s; }
.ci-animate-d5 { animation-delay: 0.25s; }

/* ── Hero ── */
.ci-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.ci-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(245,158,11,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(251,191,36,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(234,179,8,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.ci-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.ci-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.ci-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ci-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(245,158,11,0.18);
    border-radius: 0.75rem;
    color: #fbbf24;
    flex-shrink: 0;
}
.ci-hero .hero-icon svg { width: 24px; height: 24px; }
.ci-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.ci-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}
.ci-hero .btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: none;
    color: #fff;
    border-radius: 0.625rem;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(245,158,11,0.25);
    white-space: nowrap;
}
.ci-hero .btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(245,158,11,0.35);
}

/* ── Stats Grid ── */
.ci-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.ci-stat {
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
.ci-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.ci-stat .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    flex-shrink: 0;
}
.ci-stat .stat-icon svg { width: 18px; height: 18px; }
.ci-stat .stat-info { flex: 1; min-width: 0; }
.ci-stat .stat-info .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ci-stat .stat-info .stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-top: 0.125rem;
}
.ci-stat .stat-icon.total { background: #fffbeb; color: #f59e0b; }
.ci-stat .stat-icon.active { background: #eef2ff; color: #6366f1; }

/* ── Success Message ── */
.ci-msg {
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
.ci-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Card ── */
.ci-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.ci-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Toolbar ── */
.ci-toolbar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #edf2f7;
    flex-wrap: wrap;
}
.ci-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.ci-search-wrap .search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    display: flex;
}
.ci-search-wrap .search-icon svg { width: 16px; height: 16px; }
.ci-search-wrap input {
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
.ci-search-wrap input::placeholder { color: #9ca3af; }
.ci-search-wrap input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,0.1);
}
.ci-toolbar .btn-clear {
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
.ci-toolbar .btn-clear:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #374151;
}

/* ── Table ── */
.ci-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .ci-table-wrap {
        transform: rotateX(180deg);
    }
    .ci-table-wrap .ci-table {
        transform: rotateX(180deg);
    }
}
.ci-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 500px;
}
.ci-table thead th {
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
.ci-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.ci-table tbody tr:last-child td { border-bottom: none; }
.ci-table tbody tr { transition: background 0.15s ease; }
.ci-table tbody tr:hover td { background: #f8faff; }
.ci-table tbody tr:active td { background: #f1f4fd; }

/* ── Category Name Cell ── */
.ci-name-cell {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}
.ci-name-cell .name-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    background: #fffbeb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f59e0b;
    flex-shrink: 0;
}
.ci-name-cell .name-icon svg { width: 14px; height: 14px; }
.ci-name-cell .name-info { min-width: 0; }
.ci-name-cell .name-info .cat-name {
    font-weight: 600;
    color: #111827;
    display: block;
}
.ci-name-cell .name-info .cat-slug {
    font-size: 0.72rem;
    color: #9ca3af;
    display: block;
    margin-top: 0.075rem;
}

/* ── Description Cell ── */
.ci-desc-text {
    color: #6b7280;
    font-size: 0.85rem;
    max-width: 280px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
}

/* ── Actions ── */
.ci-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.375rem;
}
.ci-actions .btn-action {
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
.ci-actions .btn-action:hover { transform: translateY(-1px); }
.ci-actions .btn-edit {
    background: #eef2ff;
    color: #4f46e5;
    border: 1px solid #c7d2fe;
}
.ci-actions .btn-edit:hover {
    background: #e0e7ff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.15);
}
.ci-actions .btn-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.ci-actions .btn-delete:hover {
    background: #fce4e4;
    box-shadow: 0 2px 8px rgba(220,38,38,0.15);
}

/* ── Empty State ── */
.ci-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.ci-empty .empty-icon {
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
.ci-empty .empty-icon svg { width: 28px; height: 28px; }
.ci-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.ci-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .ci-hero { padding: 1.75rem 1.5rem; }
    .ci-hero .hero-inner { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 768px) {
    .ci-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .ci-hero .hero-text h1 { font-size: 1.15rem; }
    .ci-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .ci-hero .hero-icon svg { width: 20px; height: 20px; }
    .ci-hero .hero-left { gap: 0.75rem; }
    .ci-hero .btn-add { width: 100%; justify-content: center; }
    .ci-toolbar { padding: 1rem; flex-direction: column; align-items: stretch; }
    .ci-search-wrap { min-width: 0; }
    .ci-toolbar .btn-clear { justify-content: center; }
    .ci-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .ci-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .ci-name-cell .name-icon { width: 1.75rem; height: 1.75rem; }
    .ci-name-cell .name-icon svg { width: 12px; height: 12px; }
    .ci-name-cell .name-info .cat-name { font-size: 0.8rem; }
    .ci-name-cell .name-info .cat-slug { font-size: 0.65rem; }
    .ci-desc-text { max-width: 160px; font-size: 0.78rem; }
    .ci-actions .btn-action { padding: 0.35rem 0.5rem; font-size: 0.72rem; }
}
@media (max-width: 480px) {
    .ci-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .ci-hero .hero-text h1 { font-size: 1rem; }
    .ci-hero .hero-text p { font-size: 0.75rem; }
    .ci-table { min-width: 380px; }
    .ci-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .ci-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .ci-name-cell { gap: 0.5rem; }
    .ci-name-cell .name-icon { width: 1.5rem; height: 1.5rem; }
    .ci-name-cell .name-icon svg { width: 10px; height: 10px; }
    .ci-name-cell .name-info .cat-name { font-size: 0.75rem; }
    .ci-name-cell .name-info .cat-slug { font-size: 0.6rem; }
    .ci-desc-text { max-width: 120px; font-size: 0.72rem; }
    .ci-actions { gap: 0.25rem; }
    .ci-actions .btn-action { padding: 0.3rem 0.4rem; font-size: 0.68rem; }
    .ci-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="ci-hero ci-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Categories</h1>
                <p>Organize your products into categories</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-add">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Category
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="ci-stats ci-animate ci-animate-d1">
    <div class="ci-stat">
        <div class="stat-icon total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Categories</div>
            <div class="stat-value">{{ $totalCategories }}</div>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="ci-msg success ci-animate ci-animate-d2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Main Card --}}
<div class="ci-card ci-animate ci-animate-d2">
    {{-- Toolbar --}}
    <div class="ci-toolbar">
        <div class="ci-search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" id="liveSearch" value="{{ request('search') }}" placeholder="Search categories..." autocomplete="off">
        </div>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="btn-clear">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Clear
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="ci-table-wrap">
        <table class="ci-table">
            <thead>
                <tr>
                    <th style="width:35%;">Name</th>
                    <th style="width:45%;">Description</th>
                    <th style="width:20%;" class="right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <div class="ci-name-cell">
                                <div class="name-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                                <div class="name-info">
                                    <span class="cat-name">{{ $category->name }}</span>
                                    @if($category->slug)
                                        <span class="cat-slug">/{{ $category->slug }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="ci-desc-text">{{ $category->description ? Str::limit($category->description, 60) : '—' }}</span>
                        </td>
                        <td>
                            <div class="ci-actions">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-action btn-edit">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" class="delete-form">
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
                        <td colspan="3">
                            <div class="ci-empty">
                                <div class="empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                                <div class="empty-title">No categories yet</div>
                                <div class="empty-sub">Get started by adding your first category.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
        const name = form.closest('tr')?.querySelector('.cat-name')?.textContent?.trim() || 'this category';
        Swal.fire({
            title: 'Delete Category?',
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
                const url = new URL('{{ route('admin.categories.index') }}');
                if (val) url.searchParams.set('search', val);
                window.location.href = url.toString();
            }, 400);
        });
    }
</script>
@endpush
