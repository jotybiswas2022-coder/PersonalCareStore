@extends('frontend.layouts.app')

@section('title', $policy->title . ' — BasaFinder')

@push('styles')
<style>
.policy-section {
    padding: 4rem 0;
    min-height: 60vh;
}
.policy-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
}
.policy-header {
    text-align: center;
    margin-bottom: 2.5rem;
}
.policy-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #111827;
    letter-spacing: -0.03em;
}
.policy-header p {
    color: #9ca3af;
    font-size: 0.875rem;
    margin-top: 0.375rem;
}
.policy-divider {
    width: 3rem;
    height: 3px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 2px;
    margin: 1rem auto 0;
}
.policy-content {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 2.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    line-height: 1.8;
    color: #374151;
    font-size: 0.9375rem;
}
.policy-content h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
}
.policy-content h2:first-child {
    margin-top: 0;
}
.policy-content p {
    margin-bottom: 1rem;
}
.policy-content ul {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}
.policy-content ul li {
    margin-bottom: 0.375rem;
    list-style-type: disc;
}
.policy-content strong {
    font-weight: 600;
    color: #111827;
}
@media (max-width: 640px) {
    .policy-section { padding: 2rem 0; }
    .policy-header h1 { font-size: 1.5rem; }
    .policy-content { padding: 1.5rem; border-radius: 0.75rem; font-size: 0.875rem; }
    .policy-content h2 { font-size: 1.125rem; }
}
</style>
@endpush

@section('content')
<section class="policy-section">
    <div class="policy-container">
        <div class="policy-header">
            <h1>{{ $policy->title }}</h1>
            <p>Last updated: {{ $policy->updated_at->format('F d, Y') }}</p>
            <div class="policy-divider"></div>
        </div>
        <div class="policy-content">
            {!! $policy->content !!}
        </div>
    </div>
</section>
@endsection
