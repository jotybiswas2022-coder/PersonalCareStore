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
.cr-animate { animation: fadeUp 0.5s ease-out both; }
.cr-animate-d1 { animation-delay: 0.05s; }
.cr-animate-d2 { animation-delay: 0.1s; }
.cr-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.cr-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.cr-hero::before {
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
.cr-hero::after {
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
.cr-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.cr-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.cr-hero .hero-icon {
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
.cr-hero .hero-icon svg { width: 24px; height: 24px; }
.cr-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.cr-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}
.cr-hero .btn-back {
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
.cr-hero .btn-back:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* ── Form Card ── */
.cr-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.cr-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.cr-card-body {
    padding: 2rem;
}

/* ── Section ── */
.cr-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #edf2f7;
}
.cr-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.cr-section-heading {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}
.cr-section-heading svg {
    width: 18px;
    height: 18px;
    color: #6366f1;
    flex-shrink: 0;
}
.cr-section-heading .sh-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}
.cr-section-heading .sh-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 0.25rem;
}

/* ── Form Grid ── */
.cr-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}
.cr-grid .full { grid-column: 1 / -1; }
.cr-grid .half { grid-column: span 1; }
@media (max-width: 1024px) {
    .cr-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .cr-grid { grid-template-columns: 1fr; }
}

/* ── Form Group ── */
.cr-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}
.cr-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.cr-group label .required {
    color: #ef4444;
    font-weight: 700;
}
.cr-group input[type="text"],
.cr-group input[type="number"],
.cr-group input[type="email"],
.cr-group input[type="url"],
.cr-group select,
.cr-group textarea {
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
.cr-group input::placeholder,
.cr-group textarea::placeholder {
    color: #9ca3af;
}
.cr-group input:focus,
.cr-group select:focus,
.cr-group textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.cr-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    padding-right: 2rem;
    cursor: pointer;
}
.cr-group textarea {
    resize: vertical;
    min-height: 80px;
    line-height: 1.5;
}
.cr-group .hint {
    font-size: 0.7rem;
    color: #9ca3af;
    line-height: 1.4;
}
.cr-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.cr-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

/* ── Checkbox ── */
.cr-checkbox {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding-top: 1.75rem;
}
.cr-checkbox input[type="checkbox"] {
    width: 1.1rem;
    height: 1.1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    accent-color: #6366f1;
    cursor: pointer;
    flex-shrink: 0;
}
.cr-checkbox label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
}

/* ── File Input ── */
.cr-file-wrap {
    position: relative;
}
.cr-file-input {
    position: relative;
    border: 2px dashed #d1d5db;
    border-radius: 0.75rem;
    padding: 1.5rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    background: #fafbfc;
}
.cr-file-input:hover {
    border-color: #6366f1;
    background: #f8faff;
}
.cr-file-input input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}
.cr-file-input .file-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    pointer-events: none;
}
.cr-file-input .file-placeholder svg {
    width: 28px;
    height: 28px;
    color: #9ca3af;
}
.cr-file-input .file-placeholder .fp-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}
.cr-file-input .file-placeholder .fp-sub {
    font-size: 0.75rem;
    color: #9ca3af;
}
.cr-image-preview {
    display: flex;
    gap: 0.625rem;
    margin-top: 0.75rem;
    flex-wrap: wrap;
}
.cr-image-preview img {
    width: 4rem;
    height: 4rem;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    transition: transform 0.2s ease;
}
.cr-image-preview img:hover {
    transform: scale(1.05);
}

/* ── Form Actions ── */
.cr-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.cr-btn {
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
.cr-btn:hover { transform: translateY(-1px); }
.cr-btn:active { transform: translateY(0); }
.cr-btn-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.2);
}
.cr-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(99,102,241,0.3);
}
.cr-btn-secondary {
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
}
.cr-btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* ── Validation Errors Summary ── */
.cr-errors {
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
.cr-errors svg {
    width: 18px;
    height: 18px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 1px;
}
.cr-errors .err-content { flex: 1; }
.cr-errors .err-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 0.25rem;
}
.cr-errors .err-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.cr-errors .err-list li {
    font-size: 0.8rem;
    color: #b91c1c;
    padding: 0.125rem 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.cr-errors .err-list li::before {
    content: '';
    width: 0.3rem;
    height: 0.3rem;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .cr-hero { padding: 1.75rem 1.5rem; }
    .cr-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .cr-card-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .cr-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .cr-hero .hero-text h1 { font-size: 1.15rem; }
    .cr-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .cr-hero .hero-icon svg { width: 20px; height: 20px; }
    .cr-hero .hero-left { gap: 0.75rem; }
    .cr-hero .btn-back { width: 100%; justify-content: center; }
    .cr-card-body { padding: 1.25rem; }
    .cr-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    .cr-section-heading { margin-bottom: 1rem; }
    .cr-section-heading .sh-text { font-size: 0.85rem; }
    .cr-grid { gap: 1rem; }
    .cr-group label { font-size: 0.78rem; }
    .cr-group input[type="text"],
    .cr-group input[type="number"],
    .cr-group select,
    .cr-group textarea { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .cr-actions { flex-direction: column; align-items: stretch; }
    .cr-btn { justify-content: center; }
}
@media (max-width: 480px) {
    .cr-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .cr-hero .hero-text h1 { font-size: 1rem; }
    .cr-hero .hero-text p { font-size: 0.75rem; }
    .cr-card-body { padding: 1rem; }
    .cr-section { margin-bottom: 1.25rem; padding-bottom: 1.25rem; }
    .cr-grid { gap: 0.75rem; }
    .cr-group label { font-size: 0.75rem; }
    .cr-group input[type="text"],
    .cr-group input[type="number"],
    .cr-group select,
    .cr-group textarea { padding: 0.45rem 0.625rem; font-size: 0.78rem; border-radius: 0.5rem; }
    .cr-checkbox { padding-top: 1.25rem; }
    .cr-file-input { padding: 1rem; }
    .cr-file-input .file-placeholder svg { width: 22px; height: 22px; }
    .cr-file-input .file-placeholder .fp-title { font-size: 0.78rem; }
    .cr-file-input .file-placeholder .fp-sub { font-size: 0.7rem; }
    .cr-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
    .cr-errors { padding: 0.75rem 1rem; }
    .cr-errors .err-title { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="cr-hero cr-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="hero-text">
                <h1>Add Product</h1>
                <p>Create a new product for your store</p>
            </div>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Products
        </a>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="cr-errors cr-animate cr-animate-d1">
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
<div class="cr-card cr-animate cr-animate-d1">
    <div class="cr-card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Information --}}
            <div class="cr-section">
                <div class="cr-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <span class="sh-text">Basic Information</span>
                    <span class="sh-sub">— Product name, description &amp; pricing</span>
                </div>
                <div class="cr-grid">
                    <div class="cr-group full">
                        <label for="name">Product Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Enter product name">
                        @error('name')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cr-group">
                        <label for="price">Base Price <span class="required">*</span></label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required placeholder="0.00">
                        @error('price')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cr-group">
                        <label for="sale_price">Sale Price</label>
                        <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" placeholder="0.00">
                        <span class="hint">Discounted price shown to customers</span>
                        @error('sale_price')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cr-group">
                        <label for="stock_quantity">Stock Quantity <span class="required">*</span></label>
                        <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" required placeholder="0">
                        @error('stock_quantity')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cr-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="cr-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}" placeholder="e.g. Dove, Nivea">
                    </div>

                    <div class="cr-group">
                        <label for="sku">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" placeholder="e.g. PCS-SHAMPOO-001">
                        <span class="hint">Stock Keeping Unit — unique identifier</span>
                        @error('sku')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cr-checkbox full">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active">Active — product is visible and available for purchase</label>
                    </div>
                </div>
            </div>

            {{-- Discount --}}
            <div class="cr-section">
                <div class="cr-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span class="sh-text">Discount</span>
                    <span class="sh-sub">— Optional sale settings</span>
                </div>
                <div class="cr-grid">
                    <div class="cr-group">
                        <label for="discount_name">Discount Name</label>
                        <input type="text" name="discount_name" id="discount_name" value="{{ old('discount_name') }}" placeholder="e.g. Summer Sale">
                        @error('discount_name')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cr-group">
                        <label for="discount_percent">Discount %</label>
                        <input type="number" step="0.01" min="0" max="100" name="discount_percent" id="discount_percent" value="{{ old('discount_percent') }}" placeholder="e.g. 10">
                        <span class="hint">Percentage off the sale price</span>
                        @error('discount_percent')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="cr-section">
                <div class="cr-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span class="sh-text">Description</span>
                    <span class="sh-sub">— Product details for customers</span>
                </div>
                <div class="cr-grid">
                    <div class="cr-group full">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" id="short_description" rows="2" placeholder="Brief product summary (max 500 chars)">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="cr-group full">
                        <label for="description">Full Description</label>
                        <textarea name="description" id="description" rows="5" placeholder="Detailed product description">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="cr-section" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <div class="cr-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span class="sh-text">Product Images</span>
                    <span class="sh-sub">— Upload product photos</span>
                </div>
                <div class="cr-grid">
                    <div class="cr-group full">
                        <div class="cr-file-wrap">
                            <div class="cr-file-input" id="fileDropArea">
                                <input type="file" name="images[]" id="images" multiple accept="image/*">
                                <div class="file-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span class="fp-title">Click to upload or drag &amp; drop</span>
                                    <span class="fp-sub">JPEG, PNG, JPG, GIF, WebP — up to 10MB each</span>
                                </div>
                            </div>
                            <div class="cr-image-preview" id="imagePreview"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="cr-actions" style="margin-top:2rem;">
                <button type="submit" class="cr-btn cr-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="cr-btn cr-btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview on file selection
    document.getElementById('images').addEventListener('change', function () {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        for (const file of this.files) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
