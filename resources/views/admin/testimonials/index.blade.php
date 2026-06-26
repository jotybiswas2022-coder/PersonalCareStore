@extends('admin.layouts.app')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tl-animate { animation: fadeUp 0.5s ease-out both; }
.tl-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
    overflow: hidden;
    isolation: isolate;
}
.tl-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.tl-hero .hero-content { flex: 1; min-width: 0; }
.tl-hero h1 { color: #fff; font-size: 1.5rem; font-weight: 800; letter-spacing: -0.03em; }
.tl-hero p { color: rgba(255,255,255,0.5); font-size: 0.875rem; margin-top: 0.25rem; }
.tl-hero .hero-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.625rem 1.25rem; background: #6366f1; color: #fff;
    border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600;
    text-decoration: none; transition: all 0.2s; white-space: nowrap;
}
.tl-hero .hero-btn:hover { background: #4f46e5; transform: translateY(-1px); }

.tl-card {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 0.75rem;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.tl-table { width: 100%; border-collapse: collapse; }
.tl-table th {
    text-align: left; font-size: 0.75rem; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.05em;
    padding: 0.875rem 1.25rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb;
}
.tl-table td {
    padding: 1rem 1.25rem; font-size: 0.875rem; color: #374151;
    border-bottom: 1px solid #f3f4f6; vertical-align: middle;
}
.tl-table tr:last-child td { border-bottom: none; }
.tl-table tr:hover td { background: #f9fafb; }
.tl-name { font-weight: 600; color: #111827; }
.tl-content-cell { max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #6b7280; }
.tl-status {
    display: inline-flex; align-items: center;
    padding: 0.2rem 0.625rem; border-radius: 9999px;
    font-size: 0.75rem; font-weight: 600; gap: 0.25rem;
}
.tl-status.active { background: #d1fae5; color: #065f46; }
.tl-status.inactive { background: #fef3c7; color: #92400e; }
.tl-actions { display: flex; gap: 0.375rem; }
.tl-actions a, .tl-actions button {
    display: inline-flex; align-items: center; gap: 0.25rem;
    padding: 0.375rem 0.75rem; border-radius: 0.375rem;
    font-size: 0.75rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all 0.2s;
}
.tl-btn-edit { background: #eef2ff; color: #4f46e5; }
.tl-btn-edit:hover { background: #e0e7ff; }
.tl-btn-delete { background: #fef2f2; color: #dc2626; }
.tl-btn-delete:hover { background: #fee2e2; }
.stars { color: #f59e0b; letter-spacing: 1px; }
.tl-empty {
    text-align: center; padding: 3rem 1rem; color: #9ca3af;
}
.tl-empty svg { margin-bottom: 0.75rem; opacity: 0.3; }
.tl-empty h3 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.25rem; }
.tl-empty p { font-size: 0.8125rem; }

@media (hover:none) and (pointer:coarse) {
    .tl-hero .hero-btn:hover { transform:none; background:#6366f1; }
    .tl-btn-edit:hover { background:#eef2ff; }
    .tl-btn-delete:hover { background:#fef2f2; }
    .tl-table tr:hover td { background:transparent; }
    .tl-table tr:active td { background:#f9fafb; }
}
@media (max-width:768px) {
    .tl-hero { margin:-1rem -1rem 1rem; padding:1.25rem 1rem 1.5rem; }
    .tl-hero h1 { font-size:1.2rem; }
    .tl-hero p { font-size:0.75rem; }
    .tl-hero .hero-btn { padding:0.5rem 0.875rem; font-size:0.75rem; }
    .tl-hero .hero-btn svg { width:12px; height:12px; }
    .tl-card { border-radius:0.625rem; overflow-x:auto; -webkit-overflow-scrolling:touch; }
    .tl-card::before { content:'\2190  Swipe \2192'; display:block; text-align:center; font-size:0.55rem; color:#94a3b8; padding:0.3125rem; background:#f8fafc; border-bottom:1px solid #f1f5f9; letter-spacing:0.05em; }
    .tl-table { min-width:600px; }
    .tl-table th { padding:0.625rem 0.875rem; font-size:0.65rem; }
    .tl-table td { padding:0.75rem 0.875rem; font-size:0.78125rem; }
    .tl-content-cell { max-width:180px; }
    .tl-btn-edit, .tl-btn-delete { padding:0.3125rem 0.5rem; font-size:0.6875rem; }
    .tl-btn-edit svg, .tl-btn-delete svg { width:10px; height:10px; }
}
@media (max-width:480px) {
    .tl-hero { margin:-0.75rem -0.5rem 0.75rem; padding:1rem 0.75rem 1.25rem; }
    .tl-hero .hero-inner { flex-direction:column; align-items:stretch; gap:0.75rem; }
    .tl-hero h1 { font-size:1rem; }
    .tl-hero p { font-size:0.6875rem; }
    .tl-hero .hero-btn { justify-content:center; padding:0.5rem 0.75rem; font-size:0.71875rem; }
    .tl-card { border-radius:0.5rem; }
    .tl-card::before { font-size:0.5rem; padding:0.25rem; }
    .tl-table { min-width:520px; }
    .tl-table th { padding:0.4375rem 0.625rem; font-size:0.5625rem; }
    .tl-table td { padding:0.5625rem 0.625rem; font-size:0.6875rem; }
    .tl-content-cell { max-width:130px; }
    .tl-name { font-size:0.75rem; }
    .tl-status { font-size:0.625rem; padding:0.125rem 0.4375rem; }
    .stars { font-size:0.75rem; }
    .tl-actions { gap:0.25rem; }
    .tl-actions a, .tl-actions button { padding:0.25rem 0.4375rem; font-size:0.625rem; }
    .tl-btn-edit svg, .tl-btn-delete svg { width:9px; height:9px; }
    .tl-empty { padding:2rem 0.75rem; }
    .tl-empty h3 { font-size:0.875rem; }
    .tl-empty p { font-size:0.71875rem; }
    .tl-empty svg { width:32px; height:32px; }
}
</style>
@endpush

@section('content')
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div class="hero-content">
            <h1>Testimonials</h1>
            <p>Manage customer testimonials displayed on the home page.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="hero-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Testimonial
        </a>
    </div>
</div>

@if(session('success'))
    <div style="padding:0.875rem 1.25rem; background:#d1fae5; color:#065f46; border-radius:0.5rem; margin-bottom:1rem; font-size:0.875rem; font-weight:500; display:flex; align-items:center; gap:0.5rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="tl-card tl-animate" style="animation-delay:0.1s">
    @if($testimonials->count())
        <table class="tl-table">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Role</th>
                    <th>Content</th>
                    <th>Rating</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $t)
                    <tr>
                        <td><span class="tl-name">{{ $t->author_name }}</span></td>
                        <td style="color:#6b7280;">{{ $t->author_role }}</td>
                        <td><span class="tl-content-cell">{{ $t->content }}</span></td>
                        <td><span class="stars">{{ $t->stars }}</span></td>
                        <td style="color:#6b7280;">{{ $t->sort_order }}</td>
                        <td>
                            <span class="tl-status {{ $t->is_active ? 'active' : 'inactive' }}">
                                {{ $t->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="tl-actions" style="justify-content:flex-end;">
                                <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="tl-btn-edit">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $t->id) }}" onsubmit="return confirm('Delete this testimonial?')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="tl-btn-delete">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="tl-empty">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0118.8-4.3M22 12.5a10 10 0 01-18.8 4.2"/></svg>
            <h3>No testimonials yet</h3>
            <p>Get started by adding your first testimonial.</p>
        </div>
    @endif
</div>

@if($testimonials->hasPages())
    <div style="margin-top:1.5rem;">
        {{ $testimonials->links('vendor.pagination.custom') }}
    </div>
@endif
@endsection
