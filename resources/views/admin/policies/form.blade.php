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
.tf-group { margin-bottom: 1.25rem; }
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
.tf-group textarea { min-height: 300px; resize: vertical; font-family: monospace; font-size: 0.8125rem; line-height: 1.6; }
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
</style>
@endpush

@section('content')
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div>
            <h1>{{ isset($policy) ? 'Edit Policy' : 'New Policy' }}</h1>
            <p>{{ isset($policy) ? 'Update this policy page.' : 'Create a new policy page.' }}</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ isset($policy) ? route('admin.policies.update', $policy->id) : route('admin.policies.store') }}" class="tf-card tl-animate" style="animation-delay:0.1s">
    @csrf
    @if(isset($policy)) @method('PUT') @endif

    @if($errors->any())
        <div style="padding:0.875rem 1.25rem; background:#fef2f2; color:#dc2626; border-radius:0.5rem; margin-bottom:1.25rem; font-size:0.875rem;">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
        <div class="tf-group">
            <label for="type">Type</label>
            <select id="type" name="type" required>
                <option value="">-- Select Type --</option>
                <option value="privacy_policy" {{ old('type', $policy->type ?? '') == 'privacy_policy' ? 'selected' : '' }}>Privacy Policy</option>
                <option value="terms_of_service" {{ old('type', $policy->type ?? '') == 'terms_of_service' ? 'selected' : '' }}>Terms of Service</option>
                <option value="cookie_policy" {{ old('type', $policy->type ?? '') == 'cookie_policy' ? 'selected' : '' }}>Cookie Policy</option>
            </select>
        </div>
        <div class="tf-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $policy->title ?? '') }}" required>
        </div>
    </div>

    <div class="tf-group">
        <label for="content">Content (HTML)</label>
        <textarea id="content" name="content" required>{{ old('content', $policy->content ?? '') }}</textarea>
        <div class="tf-hint">You can use HTML tags for formatting (h2, p, ul, li, strong, etc.).</div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
        <div></div>
        <div class="tf-group">
            <div class="tf-check" style="padding-top:1.5rem;">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $policy->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active">Active</label>
            </div>
        </div>
    </div>

    <div class="tf-actions">
        <button type="submit" class="tf-btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ isset($policy) ? 'Update Policy' : 'Create Policy' }}
        </button>
        <a href="{{ route('admin.policies.index') }}" class="tf-btn-secondary">Cancel</a>
    </div>
</form>
@endsection
