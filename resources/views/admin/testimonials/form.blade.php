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
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.5rem;
}
.tl-hero h1 { color: #fff; font-size: 1.5rem; font-weight: 800; letter-spacing: -0.03em; }
.tl-hero p { color: rgba(255,255,255,0.5); font-size: 0.875rem; margin-top: 0.25rem; }

.tf-card {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 0.75rem;
    padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.tf-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.tf-group { margin-bottom: 1.25rem; }
.tf-group.full { grid-column: 1 / -1; }
.tf-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.375rem; }
.tf-group input, .tf-group textarea, .tf-group select {
    width: 100%; padding: 0.625rem 0.875rem;
    border: 1px solid #d1d5db; border-radius: 0.5rem;
    font-size: 0.875rem; font-family: inherit; color: #111827;
    outline: none; transition: border-color 0.2s; background: #fff;
}
.tf-group input:focus, .tf-group textarea:focus, .tf-group select:focus {
    border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.tf-group textarea { min-height: 120px; resize: vertical; }
.tf-hint { font-size: 0.75rem; color: #9ca3af; margin-top: 0.25rem; }
.tf-check { display: flex; align-items: center; gap: 0.625rem; padding-top: 0.375rem; }
.tf-check input[type="checkbox"] { width: 1.125rem; height: 1.125rem; accent-color: #6366f1; }
.tf-check label { margin-bottom: 0; cursor: pointer; }
.tf-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb; }
.tf-btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.625rem 1.5rem; background: #6366f1; color: #fff;
    border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
}
.tf-btn-primary:hover { background: #4f46e5; }
.tf-btn-secondary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.625rem 1.5rem; background: #fff; color: #374151;
    border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
}
.tf-btn-secondary:hover { background: #f9fafb; }
.star-rating { display: flex; gap: 0.25rem; direction: rtl; }
.star-rating input { display: none; }
.star-rating label { font-size: 1.75rem; color: #d1d5db; cursor: pointer; transition: color 0.15s; }
.star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: #f59e0b; }
</style>
@endpush

@section('content')
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div>
            <h1>{{ isset($testimonial) ? 'Edit Testimonial' : 'New Testimonial' }}</h1>
            <p>{{ isset($testimonial) ? 'Update testimonial details.' : 'Add a new customer testimonial.' }}</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" class="tf-card tl-animate" style="animation-delay:0.1s">
    @csrf
    @if(isset($testimonial)) @method('PUT') @endif

    @if($errors->any())
        <div style="padding:0.875rem 1.25rem; background:#fef2f2; color:#dc2626; border-radius:0.5rem; margin-bottom:1.25rem; font-size:0.875rem;">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="tf-row">
        <div class="tf-group">
            <label for="author_name">Author Name</label>
            <input type="text" id="author_name" name="author_name" value="{{ old('author_name', $testimonial->author_name ?? '') }}" required>
        </div>
        <div class="tf-group">
            <label for="author_role">Author Role</label>
            <input type="text" id="author_role" name="author_role" value="{{ old('author_role', $testimonial->author_role ?? '') }}" placeholder="e.g. Renter, Dhaka" required>
        </div>
        <div class="tf-group full">
            <label for="content">Testimonial Content</label>
            <textarea id="content" name="content" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
        </div>
        <div class="tf-group">
            <label>Rating</label>
            <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ (old('rating', $testimonial->rating ?? 5) == $i) ? 'checked' : '' }}>
                    <label for="star{{ $i }}" title="{{ $i }} stars">★</label>
                @endfor
            </div>
        </div>
        <div class="tf-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0">
            <div class="tf-hint">Lower numbers appear first.</div>
        </div>
        <div class="tf-group full">
            <div class="tf-check">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active">Active</label>
            </div>
        </div>
    </div>

    <div class="tf-actions">
        <button type="submit" class="tf-btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ isset($testimonial) ? 'Update Testimonial' : 'Create Testimonial' }}
        </button>
        <a href="{{ route('admin.testimonials.index') }}" class="tf-btn-secondary">Cancel</a>
    </div>
</form>
@endsection
