@extends('frontend.layouts.app')

@section('title', 'My Properties')

@push('styles')
<style>
body { background: var(--navy); }

/* ── Hero ── */
.mp-hero {
    background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 50%, #0F172A 100%);
    padding: 3rem 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.mp-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 40%, rgba(37,99,235,0.12) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 60%, rgba(245,158,11,0.06) 0%, transparent 60%);
    pointer-events: none;
}
.mp-hero h1 { font-size: 2rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; margin-bottom: 0.375rem; position: relative; }
.mp-hero p { color: rgba(255,255,255,0.5); font-size: 0.9375rem; position: relative; }

/* ─── Layout ─── */
.mp-wrap { max-width: 960px; margin: 0 auto; padding: 2.5rem 1.5rem; }

/* ─── Stats Bar ─── */
.mp-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.mp-stat {
    flex: 1;
    min-width: 120px;
    background: linear-gradient(135deg, rgba(15,23,42,0.55), rgba(15,23,42,0.7));
    backdrop-filter: blur(40px) saturate(1.4);
    -webkit-backdrop-filter: blur(40px) saturate(1.4);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border: 1px solid rgba(255,255,255,0.06);
    text-align: center;
    transition: all 0.3s;
}
.mp-stat:hover { border-color: rgba(96,165,250,0.15); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
.mp-stat .num { font-size: 1.5rem; font-weight: 800; color: #fff; }
.mp-stat .label { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 0.125rem; }
.mp-stat.pending .num { color: #FBBF24; }
.mp-stat.approved .num { color: #34D399; }
.mp-stat.rejected .num { color: #F87171; }

/* ─── Empty State ─── */
.mp-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, rgba(15,23,42,0.4), rgba(15,23,42,0.6));
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.04);
}
.mp-empty .icon { font-size: 3rem; margin-bottom: 1rem; }
.mp-empty h3 { font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
.mp-empty p { color: rgba(255,255,255,0.4); font-size: 0.9rem; margin-bottom: 1.5rem; }
.mp-empty a { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, var(--primary), #4F46E5); color: #fff; border-radius: 12px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.25s; }
.mp-empty a:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,0.3); }

/* ─── Property Card ─── */
.prop-card-h {
    display: flex;
    background: linear-gradient(135deg, rgba(15,23,42,0.55), rgba(15,23,42,0.7));
    backdrop-filter: blur(40px) saturate(1.4);
    -webkit-backdrop-filter: blur(40px) saturate(1.4);
    border-radius: var(--r-lg);
    border: 1px solid rgba(255,255,255,0.06);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    margin-bottom: 1rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}
.prop-card-h:hover { border-color: rgba(96,165,250,0.15); transform: translateY(-2px); box-shadow: 0 12px 48px rgba(0,0,0,0.35); }
.prop-card-h .p-img {
    width: 260px;
    min-height: 200px;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #0F172A, #1E3A5F);
}
.prop-card-h .p-img img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.prop-card-h .p-img .p-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(90deg, rgba(15,23,42,0.4), transparent 40%, transparent 60%, rgba(15,23,42,0.1));
    pointer-events: none;
}
.prop-card-h .p-badges { position: absolute; top: 0.75rem; left: 0.75rem; display: flex; gap: 0.375rem; flex-wrap: wrap; }
.prop-card-h .p-badge {
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.prop-card-h .p-badge.pending { background: rgba(245,158,11,0.2); color: #FBBF24; }
.prop-card-h .p-badge.approved { background: rgba(16,185,129,0.2); color: #34D399; }
.prop-card-h .p-badge.rejected { background: rgba(239,68,68,0.2); color: #F87171; }
.prop-card-h .p-price {
    position: absolute;
    bottom: 0.75rem;
    right: 0.75rem;
    background: linear-gradient(135deg, var(--primary), #4F46E5);
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    color: #fff;
    font-weight: 700;
    font-size: 0.8125rem;
}
.prop-card-h .p-price small { font-weight: 400; font-size: 0.7rem; opacity: 0.8; }

.prop-card-h .p-body {
    flex: 1;
    padding: 1.25rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-width: 0;
}
.prop-card-h .p-body .p-title { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.prop-card-h .p-body .p-location { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: rgba(255,255,255,0.45); margin-bottom: 0.75rem; }
.prop-card-h .p-body .p-location svg { flex-shrink: 0; }
.prop-card-h .p-body .p-desc { font-size: 0.8125rem; color: rgba(255,255,255,0.4); margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.prop-card-h .p-body .p-meta { display: flex; gap: 1.25rem; margin-bottom: 0.75rem; flex-wrap: wrap; }
.prop-card-h .p-body .p-meta span { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: rgba(255,255,255,0.45); }
.prop-card-h .p-body .p-meta span svg { color: var(--primary); }
.prop-card-h .p-body .p-meta-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.04); margin: 0.375rem 0; }
.prop-card-h .p-body .p-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.prop-card-h .p-body .p-actions a, .prop-card-h .p-body .p-actions button {
    padding: 0.5rem 1rem;
    border-radius: var(--r-sm);
    font-size: 0.78rem;
    font-weight: 600;
    transition: all 0.25s;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    border: none;
    font-family: var(--font);
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}
.prop-card-h .p-body .p-actions .btn-view { background: rgba(37,99,235,0.1); color: var(--accent); }
.prop-card-h .p-body .p-actions .btn-view:hover { background: rgba(37,99,235,0.2); }
.prop-card-h .p-body .p-actions .btn-edit { background: rgba(245,158,11,0.1); color: #FCD34D; }
.prop-card-h .p-body .p-actions .btn-edit:hover { background: rgba(245,158,11,0.2); }
.prop-card-h .p-body .p-actions .btn-delete { background: rgba(239,68,68,0.1); color: #F87171; }
.prop-card-h .p-body .p-actions .btn-delete:hover { background: rgba(239,68,68,0.2); }

@media (max-width: 768px) {
    .prop-card-h { flex-direction: column; }
    .prop-card-h .p-img { width: 100%; min-height: 180px; }
    .mp-hero h1 { font-size: 1.5rem; }
    .mp-wrap { padding: 1.5rem 1rem; }
    .mp-stat { min-width: 80px; padding: 1rem; }
    .mp-stat .num { font-size: 1.15rem; }
    .prop-card-h .p-body { padding: 1rem; }
    .prop-card-h .p-body .p-actions { gap: 0.5rem; }
    .prop-card-h .p-body .p-actions a, .prop-card-h .p-body .p-actions button { font-size: 0.7rem; padding: 0.4rem 0.75rem; }
}

/* ─── Pagination ─── */
.pagination-wrap { display: flex; justify-content: center; margin-top: 2.5rem; }
.pagination-wrap .pagination { display: flex; gap: 0.375rem; list-style: none; padding: 0; margin: 0; }
.pagination-wrap .page-item .page-link { display: flex; align-items: center; justify-content: center; min-width: 2.375rem; padding: 0.5rem 0.75rem; border: 1px solid rgba(255,255,255,0.06); border-radius: var(--r-sm); font-size: 0.8125rem; color: rgba(255,255,255,0.5); text-decoration: none; transition: all 0.25s; background: rgba(15,23,42,0.3); backdrop-filter: blur(8px); }
.pagination-wrap .page-item .page-link:hover { background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.2); color: var(--accent); transform: translateY(-1px); }
.pagination-wrap .page-item.active .page-link { background: linear-gradient(135deg, var(--primary), #4F46E5); color: #fff; border-color: transparent; box-shadow: 0 4px 16px rgba(37,99,235,0.3); }
.pagination-wrap .page-item.disabled .page-link { opacity: 0.2; pointer-events: none; }
</style>
@endpush

@section('content')
<div class="mp-hero">
    <h1>My Properties</h1>
    <p>Manage your posted rental listings</p>
</div>

<div class="mp-wrap">
    @php
        $total = $properties->total();
        $pending = $properties->filter(fn($p) => $p->status === 'pending')->count();
        $approved = $properties->filter(fn($p) => $p->status === 'approved')->count();
        $rejected = $properties->filter(fn($p) => $p->status === 'rejected')->count();
    @endphp

    <div class="mp-stats">
        <div class="mp-stat">
            <div class="num">{{ $total }}</div>
            <div class="label">Total</div>
        </div>
        <div class="mp-stat pending">
            <div class="num">{{ $pending }}</div>
            <div class="label">Pending</div>
        </div>
        <div class="mp-stat approved">
            <div class="num">{{ $approved }}</div>
            <div class="label">Approved</div>
        </div>
        <div class="mp-stat rejected">
            <div class="num">{{ $rejected }}</div>
            <div class="label">Rejected</div>
        </div>
    </div>

    @forelse($properties as $property)
        <div class="prop-card-h">
            <div class="p-img">
                @if($property->first_image)
                    <img src="{{ $property->first_image }}" alt="{{ $property->title }}">
                @else
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.15);">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                @endif
                <div class="p-img-overlay"></div>
                <div class="p-badges">
                    <span class="p-badge {{ $property->status }}">{{ ucfirst($property->status) }}</span>
                </div>
                <div class="p-price">BDT {{ number_format($property->monthly_rent) }} <small>/mo</small></div>
            </div>
            <div class="p-body">
                <div>
                    <h3 class="p-title">{{ $property->title }}</h3>
                    <div class="p-location">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $property->area_location }}, {{ $property->district }}
                    </div>
                    <p class="p-desc">{{ $property->description ?: 'No description available.' }}</p>
                    <div class="p-meta">
                        <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> {{ $property->bedrooms }} {{ Str::plural('Bed', $property->bedrooms) }}</span>
                        <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> {{ $property->bathrooms }} {{ Str::plural('Bath', $property->bathrooms) }}</span>
                        @if($property->property_size)
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> {{ number_format($property->property_size) }} sqft</span>
                        @endif
                    </div>
                </div>
                <div class="p-meta-divider"></div>
                <div class="p-actions">
                    <a href="{{ route('property-detail', $property->id) }}" class="btn-view">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        View
                    </a>
                    <a href="{{ route('my-properties.edit', $property->id) }}" class="btn-edit">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <button type="button" class="btn-delete" onclick="confirmDelete({{ $property->id }}, '{{ addslashes($property->title) }}')">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="mp-empty">
            <div class="icon"><svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1" style="color:rgba(255,255,255,0.2)"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
            <h3>No Properties Posted Yet</h3>
            <p>You haven't posted any rental properties yet. List your first property today!</p>
            <a href="{{ route('post-property') }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Post Your First Property
            </a>
        </div>
    @endforelse

    @if($properties->hasPages())
        <div class="pagination-wrap">
            {{ $properties->onEachSide(1)->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Delete Property?',
        text: 'Are you sure you want to delete "' + title + '"? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        background: '#0F172A',
        color: '#fff',
    }).then((result) => {
        if (result.isConfirmed) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('my-properties.destroy', '') }}/' + id;
            form.innerHTML = '@csrf @method('DELETE')';
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
