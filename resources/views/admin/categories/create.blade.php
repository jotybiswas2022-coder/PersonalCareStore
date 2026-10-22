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
.cc-animate { animation: fadeUp 0.5s ease-out both; }
.cc-animate-d1 { animation-delay: 0.05s; }
.cc-animate-d2 { animation-delay: 0.1s; }
.cc-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.cc-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.cc-hero::before {
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
.cc-hero::after {
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
.cc-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.cc-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.cc-hero .hero-icon {
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
.cc-hero .hero-icon svg { width: 24px; height: 24px; }
.cc-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.cc-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}
.cc-hero .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.125rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.75);
    border-radius: 0.625rem;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s ease;
    backdrop-filter: blur(4px);
}
.cc-hero .btn-back:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* ── Form Card ── */
.cc-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.cc-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.cc-card-body {
    padding: 2rem;
}

/* ── Section ── */
.cc-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #edf2f7;
}
.cc-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.cc-section-heading {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}
.cc-section-heading svg {
    width: 18px;
    height: 18px;
    color: #f59e0b;
    flex-shrink: 0;
}
.cc-section-heading .sh-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}
.cc-section-heading .sh-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 0.25rem;
}

/* ── Form Grid ── */
.cc-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}
.cc-grid .full { grid-column: 1 / -1; }
@media (max-width: 640px) {
    .cc-grid { grid-template-columns: 1fr; }
}

/* ── Form Group ── */
.cc-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}
.cc-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.cc-group label .required {
    color: #ef4444;
    font-weight: 700;
}
.cc-group input[type="text"],
.cc-group textarea {
    width: 100%;
    padding: 0.6rem 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    color: #111827;
    background: #fff;
    outline: none;
    transition: all 0.2s ease;
    font-family: inherit;
}
.cc-group input::placeholder,
.cc-group textarea::placeholder {
    color: #9ca3af;
}
.cc-group input:focus,
.cc-group textarea:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,0.1);
}
.cc-group textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.5;
}
.cc-group .hint {
    font-size: 0.7rem;
    color: #9ca3af;
    line-height: 1.4;
}
.cc-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.cc-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

/* ── Form Actions ── */
.cc-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.cc-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.5rem;
    border: none;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.cc-btn:hover { transform: translateY(-1px); }
.cc-btn:active { transform: translateY(0); }
.cc-btn-primary {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    box-shadow: 0 2px 8px rgba(245,158,11,0.2);
}
.cc-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(245,158,11,0.3);
}
.cc-btn-secondary {
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
}
.cc-btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* ── Validation Errors Summary ── */
.cc-errors {
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #fef2f2, #fce4e4);
    border: 1px solid #fecaca;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    animation: fadeUp 0.35s ease-out;
}
.cc-errors svg {
    width: 18px;
    height: 18px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 1px;
}
.cc-errors .err-content { flex: 1; }
.cc-errors .err-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 0.25rem;
}
.cc-errors .err-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.cc-errors .err-list li {
    font-size: 0.8rem;
    color: #b91c1c;
    padding: 0.125rem 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.cc-errors .err-list li::before {
    content: '';
    width: 0.3rem;
    height: 0.3rem;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .cc-hero { padding: 1.75rem 1.5rem; }
    .cc-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .cc-card-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .cc-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .cc-hero .hero-text h1 { font-size: 1.15rem; }
    .cc-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .cc-hero .hero-icon svg { width: 20px; height: 20px; }
    .cc-hero .hero-left { gap: 0.75rem; }
    .cc-hero .btn-back { width: 100%; justify-content: center; }
    .cc-card-body { padding: 1.25rem; }
    .cc-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    .cc-section-heading { margin-bottom: 1rem; }
    .cc-section-heading .sh-text { font-size: 0.85rem; }
    .cc-grid { gap: 1rem; }
    .cc-group label { font-size: 0.78rem; }
    .cc-group input[type="text"],
    .cc-group textarea { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .cc-actions { flex-direction: column; align-items: stretch; }
    .cc-btn { justify-content: center; }
}
@media (max-width: 480px) {
    .cc-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .cc-hero .hero-text h1 { font-size: 1rem; }
    .cc-hero .hero-text p { font-size: 0.75rem; }
    .cc-card-body { padding: 1rem; }
    .cc-section { margin-bottom: 1.25rem; padding-bottom: 1.25rem; }
    .cc-grid { gap: 0.75rem; }
    .cc-group label { font-size: 0.75rem; }
    .cc-group input[type="text"],
    .cc-group textarea { padding: 0.45rem 0.625rem; font-size: 0.78rem; border-radius: 0.5rem; }
    .cc-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
    .cc-errors { padding: 0.75rem 1rem; }
    .cc-errors .err-title { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="cc-hero cc-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Add Category</h1>
                <p>Create a new product category</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Categories
        </a>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="cc-errors cc-animate cc-animate-d1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div class="err-content">
            <div class="err-title">{{ $errors->count() }} validation error{{ $errors->count() !== 1 ? 's' : '' }}</div>
            <ul class="err-list">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- Form Card --}}
<div class="cc-card cc-animate cc-animate-d1">
    <div class="cc-card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            {{-- Category Details --}}
            <div class="cc-section" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <div class="cc-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <span class="sh-text">Category Details</span>
                    <span class="sh-sub">— Name and description</span>
                </div>
                <div class="cc-grid">
                    <div class="cc-group full">
                        <label for="name">Category Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Enter category name">
                        @error('name')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cc-group full">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" placeholder="Describe this category (optional)">{{ old('description') }}</textarea>
                        <span class="hint">A brief description helps customers understand what products belong in this category.</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="cc-actions" style="margin-top:2rem;">
                <button type="submit" class="cc-btn cc-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="cc-btn cc-btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
