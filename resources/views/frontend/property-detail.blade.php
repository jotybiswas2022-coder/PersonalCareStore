@extends('frontend.layouts.app')

@section('title', $property->title . ' - BasaFinder')

@push('styles')
<style>
/* ─── Animations ─── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes slideLeft {
    from { opacity: 0; transform: translateX(30px); }
    to   { opacity: 1; transform: translateX(0); }
}
.pd-animate { animation: fadeUp 0.6s ease-out both; }
.pd-animate-d1 { animation-delay: 0.1s; }
.pd-animate-d2 { animation-delay: 0.2s; }
.pd-animate-d3 { animation-delay: 0.3s; }

/* ─── Breadcrumb ─── */
.pd-breadcrumb {
    max-width: 1280px;
    margin: 0 auto;
    padding: 1rem 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: var(--text-muted);
}
.pd-breadcrumb a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
.pd-breadcrumb a:hover { color: var(--primary); }
.pd-breadcrumb .sep { color: var(--border); }

/* ─── Layout ─── */
.pd-wrap {
    max-width: 1280px;
    margin: 0 auto;
    padding: 1.5rem 1.5rem 3rem;
}

/* ─── Gallery ─── */
.pd-gallery {
    margin-bottom: 2rem;
}
.pd-gallery .gallery-main {
    position: relative;
    background: linear-gradient(135deg, #E2E8F0, #CBD5E1);
    border-radius: 20px;
    overflow: hidden;
    height: 460px;
    box-shadow: 0 4px 24px rgba(15,23,42,0.08);
}
.pd-gallery .gallery-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.35s ease;
}
.pd-gallery .gallery-counter {
    position: absolute;
    bottom: 16px;
    right: 16px;
    background: rgba(15,23,42,0.7);
    backdrop-filter: blur(8px);
    color: #fff;
    padding: 0.375rem 0.875rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    z-index: 2;
    letter-spacing: 0.03em;
}
.gallery-badges {
    position: absolute;
    top: 16px;
    left: 16px;
    display: flex;
    gap: 0.5rem;
    z-index: 2;
    flex-wrap: wrap;
}
.gallery-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}
.gallery-badge.featured { background: rgba(245,158,11,0.9); color: #fff; }
.gallery-badge.verified { background: rgba(16,185,129,0.9); color: #fff; }
.gallery-badge.new { background: rgba(37,99,235,0.9); color: #fff; }
.gallery-badge.type {
    background: rgba(15,23,42,0.75);
    color: #fff;
}
.pd-gallery .gallery-thumbs {
    display: flex;
    gap: 0.625rem;
    margin-top: 0.75rem;
    padding: 0.75rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow-x: auto;
}
.pd-gallery .gallery-thumbs .thumb {
    flex-shrink: 0;
    width: 96px;
    height: 72px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.2s, transform 0.2s;
    background: linear-gradient(135deg, #E2E8F0, #CBD5E1);
    box-shadow: 0 1px 4px rgba(15,23,42,0.06);
}
.pd-gallery .gallery-thumbs .thumb:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
}
.pd-gallery .gallery-thumbs .thumb.active {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}
.pd-gallery .gallery-thumbs .thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
@media (max-width: 768px) {
    .pd-gallery .gallery-main { height: 280px; }
    .pd-gallery .gallery-thumbs .thumb { width: 72px; height: 56px; }
}

/* ─── Content ─── */
.pd-content {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2rem;
    align-items: start;
}
@media (max-width: 1024px) { .pd-content { grid-template-columns: 1fr; } }

/* ─── Info Panel ─── */
.pd-info {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2rem;
}
.pd-info .pd-title {
    font-size: 1.625rem;
    font-weight: 800;
    color: var(--secondary);
    margin-bottom: 0.375rem;
    line-height: 1.2;
}
.pd-info .pd-title .pd-type-badge {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--primary);
    background: var(--primary-light);
    padding: 0.15rem 0.5rem;
    border-radius: 4px;
    vertical-align: middle;
    margin-left: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.pd-info .pd-address {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 1.25rem;
}
.pd-info .pd-price-row {
    display: flex;
    align-items: baseline;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.pd-info .pd-price-row .price {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
}
.pd-info .pd-price-row .price small {
    font-size: 0.875rem;
    font-weight: 400;
    color: var(--text-muted);
}
.pd-info .pd-price-row .status {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.status-approved { background: #D1FAE5; color: #065F46; }
.status-pending { background: #FEF3C7; color: #92400E; }
.status-rejected { background: #FEE2E2; color: #991B1B; }

/* ─── Meta Grid ─── */
.pd-meta-grid {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.5rem;
    padding: 1.25rem;
    background: var(--bg);
    border-radius: 12px;
    margin-bottom: 1.5rem;
    justify-content: space-around;
}
.pd-meta-item {
    flex: 1;
    min-width: 0;
}
.pd-meta-item {
    text-align: center;
    padding: 0.5rem;
}
.pd-meta-item .pm-icon {
    color: var(--primary);
    margin-bottom: 0.25rem;
}
.pd-meta-item .pm-value {
    font-size: 1rem;
    font-weight: 700;
    color: var(--secondary);
}
.pd-meta-item .pm-label {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-top: 0.125rem;
}

/* ─── Sections ─── */
.pd-section { margin-bottom: 2rem; }
.pd-section:last-child { margin-bottom: 0; }
.pd-section h3 {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--secondary);
    margin-bottom: 0.875rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--bg);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.pd-section h3 svg { color: var(--primary); }
.pd-section p, .pd-section li {
    font-size: 0.9375rem;
    color: var(--text);
    line-height: 1.75;
}
.pd-desc {
    font-size: 0.9375rem;
    color: var(--text);
    line-height: 1.75;
    white-space: pre-line;
}

/* ─── Detail List ─── */
.pd-details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
}
.pd-detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    background: var(--bg);
    border-radius: 8px;
    font-size: 0.85rem;
}
.pd-detail-item .dd-label { color: var(--text-muted); }
.pd-detail-item .dd-value { font-weight: 600; color: var(--text); }

/* ─── Sidebar ─── */
.pd-sidebar { display: flex; flex-direction: column; gap: 1.25rem; }

/* ─── Owner Card ─── */
.pd-owner-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
}
.pd-owner-card .owner-avatar {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), rgba(167,139,250,0.2));
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.375rem;
    margin: 0 auto 0.75rem;
}
.pd-owner-card h4 { font-size: 1.0625rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.125rem; }
.pd-owner-card .owner-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
}
.pd-owner-card .owner-status {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--success);
    font-weight: 500;
    margin-bottom: 1rem;
}
.pd-owner-card .owner-status .dot {
    width: 0.375rem;
    height: 0.375rem;
    background: var(--success);
    border-radius: 50%;
    animation: pulse-dot2 2s ease-in-out infinite;
}
@keyframes pulse-dot2 { 0%,100% { opacity: 1; } 50% { opacity: 0.5; } }
.pd-owner-card .owner-contact { display: flex; flex-direction: column; gap: 0.625rem; }
.pd-owner-card .owner-contact a,
.pd-owner-card .owner-contact button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    border: none;
    cursor: pointer;
    font-family: var(--font);
}
.pd-owner-card .owner-contact .btn-call { background: var(--primary); color: #fff; }
.pd-owner-card .owner-contact .btn-call:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,99,235,0.3); }
.pd-owner-card .owner-contact .btn-whatsapp { background: #25D366; color: #fff; }
.pd-owner-card .owner-contact .btn-whatsapp:hover { background: #1DA851; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,165,82,0.3); }
.pd-owner-card .owner-contact .btn-email { background: var(--bg); color: var(--text); border: 1px solid var(--border); }
.pd-owner-card .owner-contact .btn-email:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary); }

/* ─── Summary Card ─── */
.pd-summary-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem;
}
.pd-summary-card h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--secondary);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--bg);
}
.pd-summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.85rem;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
}
.pd-summary-row:last-child { border-bottom: none; }
.pd-summary-row .sv-value { font-weight: 600; color: var(--text); }

/* ─── Location Card ─── */
.pd-map-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem;
}
.pd-map-card h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--secondary);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--bg);
}

/* ─── Contact Method Badge ─── */
.contact-method-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.7rem;
    color: var(--primary);
    background: var(--primary-light);
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-weight: 500;
}

/* ─── CTA Button ─── */
.pd-cta-btn {
    width: 100%;
    justify-content: center;
    padding: 0.875rem;
    font-size: 0.9375rem;
}

/* ─── Loading State ─── */
.pd-loading {
    text-align: center;
    padding: 4rem 2rem;
}
.pd-loading .spinner {
    width: 2.5rem;
    height: 2.5rem;
    border: 3px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 1rem;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div class="pd-breadcrumb pd-animate">
    <a href="{{ route('home') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('search') }}">Properties</a>
    <span class="sep">›</span>
    <span>{{ $property->title }}</span>
</div>

<div class="pd-wrap">
    {{-- Gallery --}}
    @php
        $allImages = $property->all_images;
        $firstImage = $property->first_image;
        $propertyTypeLabel = ucfirst(str_replace('_', ' ', $property->property_type));
        $totalImages = count($allImages);
    @endphp

    <div class="pd-gallery pd-animate pd-animate-d1">
        <div class="gallery-main" id="galleryMain">
            @if($firstImage)
                <img id="mainGalleryImg" src="{{ $firstImage }}" alt="{{ $property->title }}">
            @else
                <div style="display:flex;align-items:center;justify-content:center;height:100%;">
                    <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.5" opacity="0.3">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
            @endif
            <div class="gallery-badges">
                <span class="gallery-badge featured">Featured</span>
                <span class="gallery-badge verified">Verified</span>
                <span class="gallery-badge type">{{ $propertyTypeLabel }}</span>
            </div>
            @if($totalImages > 1)
                <div class="gallery-counter" id="galleryCounter">1 / {{ $totalImages }}</div>
            @endif
        </div>
        @if($totalImages > 1)
            <div class="gallery-thumbs" id="galleryThumbs">
                @foreach($allImages as $i => $img)
                    <div class="thumb {{ $i === 0 ? 'active' : '' }}" data-src="{{ $img }}" data-index="{{ $i + 1 }}" onclick="switchGalleryImage(this)">
                        <img src="{{ $img }}" alt="">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
    function switchGalleryImage(el) {
        var src = el.getAttribute('data-src');
        var main = document.getElementById('mainGalleryImg');
        if (main) { main.src = src; }
        var thumbs = document.querySelectorAll('#galleryThumbs .thumb');
        thumbs.forEach(function(t) { t.classList.remove('active'); });
        el.classList.add('active');
        var counter = document.getElementById('galleryCounter');
        if (counter) { counter.textContent = el.getAttribute('data-index') + ' / ' + thumbs.length; }
    }
    </script>

    <div class="pd-content">
        {{-- Main Info --}}
        <div class="pd-info pd-animate pd-animate-d2">
            <h1 class="pd-title">
                {{ $property->title }}
                <span class="pd-type-badge">{{ $propertyTypeLabel }}</span>
            </h1>

            <div class="pd-address">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                {{ $property->full_address }}, {{ $property->area_location }}, {{ $property->district }}, {{ $property->division }}
            </div>

            <div class="pd-price-row">
                <span class="price">BDT {{ number_format($property->monthly_rent, 0) }} <small>/month</small></span>
                <span class="status status-{{ $property->status }}">{{ ucfirst($property->status) }}</span>
            </div>

            {{-- Meta Grid --}}
            <div class="pd-meta-grid">
                <div class="pd-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                    <div class="pm-value">{{ $property->bedrooms }}</div>
                    <div class="pm-label">Bedrooms</div>
                </div>
                <div class="pd-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg></div>
                    <div class="pm-value">{{ $property->bathrooms }}</div>
                    <div class="pm-label">Bathrooms</div>
                </div>
                @if($property->property_size)
                <div class="pd-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg></div>
                    <div class="pm-value">{{ number_format($property->property_size) }}</div>
                    <div class="pm-label">Sq. Ft.</div>
                </div>
                @endif
                @if($property->floor_number)
                <div class="pd-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="22" x2="15" y2="22"/><path d="M8 7l4-3 4 3"/></svg></div>
                    <div class="pm-value">{{ $property->floor_number }}{{ $property->total_floors ? '/'.$property->total_floors : '' }}</div>
                    <div class="pm-label">Floor</div>
                </div>
                @endif
                @if($property->furnishing)
                <div class="pd-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                    <div class="pm-value">{{ ucfirst(str_replace('_', ' ', $property->furnishing)) }}</div>
                    <div class="pm-label">Furnishing</div>
                </div>
                @endif
                @if($property->listing_type)
                <div class="pd-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                    <div class="pm-value">{{ ucfirst(str_replace('_', ' ', $property->listing_type)) }}</div>
                    <div class="pm-label">Listing Type</div>
                </div>
                @endif
            </div>

            {{-- Description --}}
            @if($property->description)
            <div class="pd-section">
                <h3>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Description
                </h3>
                <div class="pd-desc">{{ $property->description }}</div>
            </div>
            @endif

            {{-- Property Details --}}
            <div class="pd-section">
                <h3>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Property Details
                </h3>
                <div class="pd-details-grid">
                    <div class="pd-detail-item">
                        <span class="dd-label">Property Type</span>
                        <span class="dd-value">{{ $propertyTypeLabel }}</span>
                    </div>
                    @if($property->listing_type)
                    <div class="pd-detail-item">
                        <span class="dd-label">Listing Type</span>
                        <span class="dd-value">{{ ucfirst(str_replace('_', ' ', $property->listing_type)) }}</span>
                    </div>
                    @endif
                    <div class="pd-detail-item">
                        <span class="dd-label">Bedrooms</span>
                        <span class="dd-value">{{ $property->bedrooms }}</span>
                    </div>
                    <div class="pd-detail-item">
                        <span class="dd-label">Bathrooms</span>
                        <span class="dd-value">{{ $property->bathrooms }}</span>
                    </div>
                    @if($property->floor_number)
                    <div class="pd-detail-item">
                        <span class="dd-label">Floor</span>
                        <span class="dd-value">{{ $property->floor_number }}{{ $property->total_floors ? ' of '.$property->total_floors : '' }}</span>
                    </div>
                    @endif
                    @if($property->property_size)
                    <div class="pd-detail-item">
                        <span class="dd-label">Property Size</span>
                        <span class="dd-value">{{ number_format($property->property_size) }} sqft</span>
                    </div>
                    @endif
                    @if($property->furnishing)
                    <div class="pd-detail-item">
                        <span class="dd-label">Furnishing</span>
                        <span class="dd-value">{{ ucfirst(str_replace('_', ' ', $property->furnishing)) }}</span>
                    </div>
                    @endif
                    <div class="pd-detail-item">
                        <span class="dd-label">Tenant Preference</span>
                        <span class="dd-value">{{ ucfirst($property->tenant_preference) }}</span>
                    </div>
                    @if($property->available_from)
                    <div class="pd-detail-item">
                        <span class="dd-label">Available From</span>
                        <span class="dd-value">{{ $property->available_from->format('M d, Y') }}</span>
                    </div>
                    @endif
                    @if($property->security_deposit)
                    <div class="pd-detail-item">
                        <span class="dd-label">Security Deposit</span>
                        <span class="dd-value">BDT {{ number_format($property->security_deposit) }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="pd-sidebar pd-animate pd-animate-d3">
            {{-- Owner Card --}}
            <div class="pd-owner-card">
                <div class="owner-avatar">
                    {{ substr($property->contact_name, 0, 1) }}{{ strpos($property->contact_name, ' ') !== false ? substr($property->contact_name, strpos($property->contact_name, ' ') + 1, 1) : '' }}
                </div>
                <h4>{{ $property->contact_name }}</h4>
                <div class="owner-label">Property Owner</div>
                <div class="owner-status">
                    <span class="dot"></span> Verified Owner
                </div>
                <div class="owner-contact">
                    <a href="tel:{{ $property->contact_phone }}" class="btn-call">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        Call {{ $property->contact_phone }}
                    </a>
                    <a href="https://wa.me/88{{ preg_replace('/[^0-9]/', '', $property->contact_phone) }}" class="btn-whatsapp" target="_blank">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @if($property->contact_email)
                    <a href="mailto:{{ $property->contact_email }}" class="btn-email">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Send Email
                    </a>
                    @endif
                </div>
                @if($property->preferred_contact_method)
                    <div style="margin-top:0.75rem;">
                        <span class="contact-method-badge">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                            Prefers {{ ucfirst($property->preferred_contact_method) }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Rental Summary --}}
            <div class="pd-summary-card">
                <h4>Rental Summary</h4>
                <div class="pd-summary-row">
                    <span>Monthly Rent</span>
                    <span class="sv-value">BDT {{ number_format($property->monthly_rent) }}</span>
                </div>
                @if($property->security_deposit)
                <div class="pd-summary-row">
                    <span>Security Deposit</span>
                    <span class="sv-value">BDT {{ number_format($property->security_deposit) }}</span>
                </div>
                @endif
                <div class="pd-summary-row">
                    <span>Bedrooms</span>
                    <span class="sv-value">{{ $property->bedrooms }}</span>
                </div>
                <div class="pd-summary-row">
                    <span>Bathrooms</span>
                    <span class="sv-value">{{ $property->bathrooms }}</span>
                </div>
                @if($property->property_size)
                <div class="pd-summary-row">
                    <span>Property Size</span>
                    <span class="sv-value">{{ number_format($property->property_size) }} sqft</span>
                </div>
                @endif
                @if($property->available_from)
                <div class="pd-summary-row">
                    <span>Available From</span>
                    <span class="sv-value">{{ $property->available_from->format('M d, Y') }}</span>
                </div>
                @endif
                @if($property->floor_number)
                <div class="pd-summary-row">
                    <span>Floor</span>
                    <span class="sv-value">{{ $property->floor_number }}{{ $property->total_floors ? '/'.$property->total_floors : '' }}</span>
                </div>
                @endif
            </div>

            {{-- Location --}}
            <div class="pd-map-card">
                <h4>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="vertical-align:middle;margin-right:6px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Location
                </h4>
                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                    <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid var(--border);font-size:0.85rem;">
                        <span style="color:var(--text-muted);">Division</span>
                        <span style="font-weight:600;color:var(--text);">{{ $property->division }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid var(--border);font-size:0.85rem;">
                        <span style="color:var(--text-muted);">District</span>
                        <span style="font-weight:600;color:var(--text);">{{ $property->district }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid var(--border);font-size:0.85rem;">
                        <span style="color:var(--text-muted);">Area</span>
                        <span style="font-weight:600;color:var(--text);">{{ $property->area_location }}</span>
                    </div>
                    <div style="display:flex;flex-direction:column;padding:0.5rem 0;font-size:0.85rem;gap:0.25rem;">
                        <span style="color:var(--text-muted);">Full Address</span>
                        <span style="font-weight:600;color:var(--text);">{{ $property->full_address }}</span>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <a href="tel:{{ $property->contact_phone }}" class="btn btn-primary pd-cta-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                Call to Inquire
            </a>
        </div>
    </div>
</div>
@endsection
