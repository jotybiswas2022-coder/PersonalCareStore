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
.ed-animate { animation: fadeUp 0.5s ease-out both; }
.ed-animate-d1 { animation-delay: 0.05s; }
.ed-animate-d2 { animation-delay: 0.1s; }
.ed-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.ed-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.ed-hero::before {
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
.ed-hero::after {
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
.ed-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.ed-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ed-hero .hero-icon {
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
.ed-hero .hero-icon svg { width: 24px; height: 24px; }
.ed-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.ed-hero .hero-text .hero-product-name {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.ed-hero .hero-text .hero-product-name svg {
    width: 12px;
    height: 12px;
    color: rgba(255,255,255,0.3);
}
.ed-hero .btn-back {
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
.ed-hero .btn-back:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* ── Form Card ── */
.ed-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.ed-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.ed-card-body {
    padding: 2rem;
}

/* ── Section ── */
.ed-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #edf2f7;
}
.ed-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.ed-section-heading {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}
.ed-section-heading svg {
    width: 18px;
    height: 18px;
    color: #6366f1;
    flex-shrink: 0;
}
.ed-section-heading .sh-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}
.ed-section-heading .sh-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 0.25rem;
}

/* ── Form Grid ── */
.ed-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}
.ed-grid .full { grid-column: 1 / -1; }
@media (max-width: 1024px) {
    .ed-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .ed-grid { grid-template-columns: 1fr; }
}

/* ── Form Group ── */
.ed-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}
.ed-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.ed-group label .required {
    color: #ef4444;
    font-weight: 700;
}
.ed-group input[type="text"],
.ed-group input[type="number"],
.ed-group input[type="email"],
.ed-group input[type="url"],
.ed-group select,
.ed-group textarea {
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
.ed-group input::placeholder,
.ed-group textarea::placeholder {
    color: #9ca3af;
}
.ed-group input:focus,
.ed-group select:focus,
.ed-group textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.ed-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    padding-right: 2rem;
    cursor: pointer;
}
.ed-group textarea {
    resize: vertical;
    min-height: 80px;
    line-height: 1.5;
}
.ed-group .hint {
    font-size: 0.7rem;
    color: #9ca3af;
    line-height: 1.4;
}
.ed-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.ed-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

/* ── Checkbox ── */
.ed-checkbox {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding-top: 1.75rem;
}
.ed-checkbox input[type="checkbox"] {
    width: 1.1rem;
    height: 1.1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    accent-color: #6366f1;
    cursor: pointer;
    flex-shrink: 0;
}
.ed-checkbox label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
}

/* ── File Input ── */
.ed-file-wrap {
    position: relative;
}
.ed-file-input {
    position: relative;
    border: 2px dashed #d1d5db;
    border-radius: 0.75rem;
    padding: 1.5rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    background: #fafbfc;
}
.ed-file-input:hover {
    border-color: #6366f1;
    background: #f8faff;
}
.ed-file-input input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}
.ed-file-input .file-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    pointer-events: none;
}
.ed-file-input .file-placeholder svg {
    width: 28px;
    height: 28px;
    color: #9ca3af;
}
.ed-file-input .file-placeholder .fp-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}
.ed-file-input .file-placeholder .fp-sub {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* ── Existing Images ── */
.ed-existing-images {
    display: flex;
    gap: 0.625rem;
    flex-wrap: wrap;
    margin-top: 0.75rem;
}
.ed-existing-images .existing-img-wrap {
    position: relative;
    width: 4.5rem;
    height: 4.5rem;
}
.ed-existing-images .existing-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.ed-existing-images .existing-img-wrap .img-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.6);
    color: #fff;
    font-size: 0.55rem;
    text-align: center;
    padding: 0.1rem 0;
    border-radius: 0 0 0.5rem 0.5rem;
    font-weight: 500;
}

.ed-image-preview {
    display: flex;
    gap: 0.625rem;
    margin-top: 0.75rem;
    flex-wrap: wrap;
}
.ed-image-preview img {
    width: 4rem;
    height: 4rem;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    transition: transform 0.2s ease;
}
.ed-image-preview img:hover {
    transform: scale(1.05);
}

/* ── Form Actions ── */
.ed-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.ed-btn {
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
.ed-btn:hover { transform: translateY(-1px); }
.ed-btn:active { transform: translateY(0); }
.ed-btn-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.2);
}
.ed-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(99,102,241,0.3);
}
.ed-btn-secondary {
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
}
.ed-btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* ── Validation Errors Summary ── */
.ed-errors {
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
.ed-errors svg {
    width: 18px;
    height: 18px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 1px;
}
.ed-errors .err-content { flex: 1; }
.ed-errors .err-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 0.25rem;
}
.ed-errors .err-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.ed-errors .err-list li {
    font-size: 0.8rem;
    color: #b91c1c;
    padding: 0.125rem 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.ed-errors .err-list li::before {
    content: '';
    width: 0.3rem;
    height: 0.3rem;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .ed-hero { padding: 1.75rem 1.5rem; }
    .ed-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .ed-card-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .ed-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .ed-hero .hero-text h1 { font-size: 1.15rem; }
    .ed-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .ed-hero .hero-icon svg { width: 20px; height: 20px; }
    .ed-hero .hero-left { gap: 0.75rem; }
    .ed-hero .btn-back { width: 100%; justify-content: center; }
    .ed-card-body { padding: 1.25rem; }
    .ed-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    .ed-section-heading { margin-bottom: 1rem; }
    .ed-section-heading .sh-text { font-size: 0.85rem; }
    .ed-grid { gap: 1rem; }
    .ed-group label { font-size: 0.78rem; }
    .ed-group input[type="text"],
    .ed-group input[type="number"],
    .ed-group select,
    .ed-group textarea { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .ed-actions { flex-direction: column; align-items: stretch; }
    .ed-btn { justify-content: center; }
}
@media (max-width: 480px) {
    .ed-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .ed-hero .hero-text h1 { font-size: 1rem; }
    .ed-hero .hero-text .hero-product-name { font-size: 0.72rem; }
    .ed-card-body { padding: 1rem; }
    .ed-section { margin-bottom: 1.25rem; padding-bottom: 1.25rem; }
    .ed-grid { gap: 0.75rem; }
    .ed-group label { font-size: 0.75rem; }
    .ed-group input[type="text"],
    .ed-group input[type="number"],
    .ed-group select,
    .ed-group textarea { padding: 0.45rem 0.625rem; font-size: 0.78rem; border-radius: 0.5rem; }
    .ed-checkbox { padding-top: 1.25rem; }
    .ed-file-input { padding: 1rem; }
    .ed-file-input .file-placeholder svg { width: 22px; height: 22px; }
    .ed-file-input .file-placeholder .fp-title { font-size: 0.78rem; }
    .ed-file-input .file-placeholder .fp-sub { font-size: 0.7rem; }
    .ed-existing-images .existing-img-wrap { width: 3.5rem; height: 3.5rem; }
    .ed-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
    .ed-errors { padding: 0.75rem 1rem; }
    .ed-errors .err-title { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="ed-hero ed-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Edit Product</h1>
                <div class="hero-product-name">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    {{ Str::limit($product->name, 60) }}
                </div>
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
    <div class="ed-errors ed-animate ed-animate-d1">
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
<div class="ed-card ed-animate ed-animate-d1">
    <div class="ed-card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Basic Information --}}
            <div class="ed-section">
                <div class="ed-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <span class="sh-text">Basic Information</span>
                    <span class="sh-sub">— Product name, description &amp; pricing</span>
                </div>
                <div class="ed-grid">
                    <div class="ed-group full">
                        <label for="name">Product Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required placeholder="Enter product name">
                        @error('name')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="ed-group">
                        <label for="price">Base Price <span class="required">*</span></label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" required placeholder="0.00">
                        @error('price')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="ed-group">
                        <label for="sale_price">Sale Price</label>
                        <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" placeholder="0.00">
                        <span class="hint">Discounted price shown to customers</span>
                        @error('sale_price')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="ed-group">
                        <label for="stock_quantity">Stock Quantity <span class="required">*</span></label>
                        <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required placeholder="0">
                        @error('stock_quantity')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="ed-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ed-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}" placeholder="e.g. Dove, Nivea">
                    </div>

                    <div class="ed-group">
                        <label for="sku">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" placeholder="e.g. PCS-SHAMPOO-001">
                        <span class="hint">Stock Keeping Unit — unique identifier</span>
                        @error('sku')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="ed-checkbox full">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Active — product is visible and available for purchase</label>
                    </div>
                </div>
            </div>

            {{-- Discount --}}
            <div class="ed-section">
                <div class="ed-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span class="sh-text">Discount</span>
                    <span class="sh-sub">— Optional sale settings</span>
                </div>
                <div class="ed-grid">
                    <div class="ed-group">
                        <label for="discount_name">Discount Name</label>
                        <input type="text" name="discount_name" id="discount_name" value="{{ old('discount_name', $product->discount_name) }}" placeholder="e.g. Summer Sale">
                        @error('discount_name')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="ed-group">
                        <label for="discount_percent">Discount %</label>
                        <input type="number" step="0.01" min="0" max="100" name="discount_percent" id="discount_percent" value="{{ old('discount_percent', $product->discount_percent) }}" placeholder="e.g. 10">
                        <span class="hint">Percentage off the sale price</span>
                        @error('discount_percent')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="ed-section">
                <div class="ed-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span class="sh-text">Description</span>
                    <span class="sh-sub">— Product details for customers</span>
                </div>
                <div class="ed-grid">
                    <div class="ed-group full">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" id="short_description" rows="2" placeholder="Brief product summary (max 500 chars)">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div class="ed-group full">
                        <label for="description">Full Description</label>
                        <textarea name="description" id="description" rows="5" placeholder="Detailed product description">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="ed-section" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <div class="ed-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span class="sh-text">Product Images</span>
                    <span class="sh-sub">— Upload or replace product photos</span>
                </div>
                <div class="ed-grid">
                    <div class="ed-group full">
                        @if($product->images)
                            <div class="ed-existing-images">
                                @foreach($product->images as $img)
                                    <div class="existing-img-wrap">
                                        <img src="{{ config('app.storage_url') . ltrim(preg_replace('#^storage/#', '', $img), '/') }}" alt="Product Image">
                                        <span class="img-label">Current</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="ed-file-wrap" @if($product->images) style="margin-top:0.75rem;" @endif>
                            <div class="ed-file-input" id="fileDropArea">
                                <input type="file" name="images[]" id="images" multiple accept="image/*">
                                <div class="file-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span class="fp-title">Click to upload or drag &amp; drop</span>
                                    <span class="fp-sub">JPEG, PNG, JPG, GIF, WebP — up to 10MB each</span>
                                </div>
                            </div>
                            <div class="ed-image-preview" id="imagePreview"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="ed-actions" style="margin-top:2rem;">
                <button type="submit" class="ed-btn ed-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="ed-btn ed-btn-secondary">
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
