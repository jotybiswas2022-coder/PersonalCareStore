@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tl-animate { animation: fadeUp 0.4s ease-out both; }

.tl-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
    overflow: hidden;
    isolation: isolate;
}
.tl-hero .hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: space-between; gap: 1.5rem;
}
.tl-hero .hero-content { flex: 1; min-width: 0; }
.tl-hero h1 { color: #fff; font-size: 1.375rem; font-weight: 800; letter-spacing: -0.03em; }
.tl-hero p { color: rgba(255,255,255,0.5); font-size: 0.8125rem; margin-top: 0.125rem; }
.tl-hero .hero-btn {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.5rem 1.125rem; background: #6366f1; color: #fff;
    border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600;
    text-decoration: none; transition: all 0.2s; white-space: nowrap;
}
.tl-hero .hero-btn:hover { background: #4f46e5; transform: translateY(-1px); }

.pol-list { display: flex; flex-direction: column; gap: 0.625rem; }
.pol-row {
    display: flex; align-items: center; gap: 0.75rem;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 0.625rem;
    padding: 0.875rem 1rem; transition: all 0.2s;
}
.pol-row:hover { border-color: #c7d2fe; box-shadow: 0 1px 4px rgba(99,102,241,0.06); }
.pol-icon {
    width: 2.5rem; height: 2.5rem; border-radius: 0.5rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.25rem;
}
.pol-body { flex: 1; min-width: 0; }
.pol-body .t { font-weight: 600; font-size: 0.9375rem; color: #111827; }
.pol-body .s { font-size: 0.78rem; color: #9ca3af; margin-top: 0.125rem; text-transform: capitalize; }
.pol-badge {
    display: inline-flex; align-items: center; padding: 0.15rem 0.5rem;
    border-radius: 9999px; font-size: 0.6875rem; font-weight: 600; flex-shrink: 0;
}
.pol-badge.on { background: #d1fae5; color: #065f46; }
.pol-badge.off { background: #fef3c7; color: #92400e; }
.pol-actions { display: flex; gap: 0.25rem; flex-shrink: 0; }
.pol-actions a, .pol-actions button {
    display: inline-flex; align-items: center; gap: 0.25rem;
    padding: 0.3rem 0.625rem; border-radius: 0.375rem;
    font-size: 0.6875rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all 0.15s;
}
.pol-edit { background: #eef2ff; color: #4f46e5; }
.pol-edit:hover { background: #e0e7ff; }
.pol-delete { background: #fef2f2; color: #dc2626; }
.pol-delete:hover { background: #fee2e2; }

.tl-empty {
    text-align: center; padding: 3rem 1rem; color: #9ca3af;
}
.tl-empty svg { margin-bottom: 0.75rem; opacity: 0.3; }
.tl-empty h3 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.25rem; }
.tl-empty p { font-size: 0.8125rem; }
</style>
@endpush

@section('content')
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div class="hero-content">
            <h1>Policy Pages</h1>
            <p>Manage Privacy Policy, Terms of Service, and Cookie Policy.</p>
        </div>
        <a href="{{ route('admin.policies.create') }}" class="hero-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Policy
        </a>
    </div>
</div>

@if(session('success'))
    <div style="padding:0.75rem 1rem; background:#d1fae5; color:#065f46; border-radius:0.5rem; margin-bottom:1rem; font-size:0.8125rem; font-weight:500; display:flex; align-items:center; gap:0.5rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="pol-list tl-animate" style="animation-delay:0.1s">
    @forelse($policies as $p)
        @php
            $icons = [
                'privacy_policy'   => ['icon' => 'bi-shield-lock',    'bg' => '#eef2ff'],
                'terms_of_service' => ['icon' => 'bi-file-text',      'bg' => '#fef3c7'],
                'cookie_policy'    => ['icon' => 'bi-cookie',         'bg' => '#d1fae5'],
            ];
            $meta = $icons[$p->type] ?? ['icon' => 'bi-file-earmark-text', 'bg' => '#f3f4f6'];
        @endphp
        <div class="pol-row">
            <div class="pol-icon" style="background:{{ $meta['bg'] }}"><i class="{{ $meta['icon'] }}"></i></div>
            <div class="pol-body">
                <div class="t">{{ $p->title }}</div>
                <div class="s">{{ str_replace('_', ' ', $p->type) }} &middot; Updated {{ $p->updated_at->diffForHumans() }}</div>
            </div>
            <span class="pol-badge {{ $p->is_active ? 'on' : 'off' }}">{{ $p->is_active ? 'Active' : 'Inactive' }}</span>
            <div class="pol-actions">
                <a href="{{ route('admin.policies.edit', $p->id) }}" class="pol-edit">Edit</a>
                <form method="POST" action="{{ route('admin.policies.destroy', $p->id) }}" onsubmit="return confirm('Delete this policy page?')" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="pol-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="tl-empty">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <h3>No policy pages yet</h3>
            <p>Create your first policy page to get started.</p>
        </div>
    @endforelse
</div>

@if($policies->hasPages())
    <div style="margin-top:1.5rem;">
        {{ $policies->links('vendor.pagination.custom') }}
    </div>
@endif
@endsection
