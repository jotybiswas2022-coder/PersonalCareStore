@extends('frontend.layouts.app')

@section('title', 'Search Properties')

@push('styles')
<style>
.search-layout { display: grid; grid-template-columns: 320px 1fr; gap: 2rem; align-items: start; padding: 2rem 0; }
@media (max-width: 1024px) { .search-layout { grid-template-columns: 1fr; } }
.filter-sidebar { position: sticky; top: 84px; }
@media (max-width: 1024px) { .filter-sidebar { position: static; } }
.filter-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; }
.filter-card h3 { font-size: 1rem; font-weight: 700; color: var(--secondary); margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; }
.filter-group { margin-bottom: 1.25rem; }
.filter-group:last-child { margin-bottom: 0; }
.filter-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.filter-group select, .filter-group input[type="text"], .filter-group input[type="number"] { width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.875rem; font-family: var(--font); background: var(--white); outline: none; transition: border-color 0.2s; }
.filter-group select:focus, .filter-group input:focus { border-color: var(--primary); }
.range-inputs { display: flex; gap: 0.5rem; align-items: center; }
.range-inputs input { width: 100%; padding: 0.5rem 0.625rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.8125rem; font-family: var(--font); outline: none; }
.range-inputs span { color: var(--text-muted); font-size: 0.8125rem; }
.checkbox-group { display: flex; flex-direction: column; gap: 0.5rem; }
.checkbox-group label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 400; color: var(--text); cursor: pointer; margin-bottom: 0; }
.checkbox-group input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--primary); }
.filter-reset { display: block; width: 100%; padding: 0.625rem; text-align: center; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-sm); color: var(--text-muted); font-size: 0.8125rem; font-weight: 500; cursor: pointer; transition: all 0.2s; margin-top: 1rem; }
.filter-reset:hover { background: #FEE2E2; color: #EF4444; border-color: #FEE2E2; }
.filter-apply { display: block; width: 100%; padding: 0.625rem; text-align: center; background: var(--primary); color: #fff; border: none; border-radius: var(--radius-sm); font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s; margin-top: 0.75rem; font-family: var(--font); }
.filter-apply:hover { background: var(--primary-dark, #1D4ED8); }
.search-results-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.search-results-header h2 { font-size: 1.25rem; font-weight: 700; color: var(--secondary); }
.search-results-header p { color: var(--text-muted); font-size: 0.875rem; }
.search-results-header .sort-select { padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.8125rem; font-family: var(--font); outline: none; background: var(--white); }
.results-grid { display: grid; grid-template-columns: 1fr; gap: 1.25rem; }
.prop-card-h { display: flex; background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); overflow: hidden; transition: all 0.3s; }
.prop-card-h:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.prop-card-h .p-img { width: 280px; min-height: 200px; flex-shrink: 0; background: linear-gradient(135deg, #E2E8F0, #CBD5E1); position: relative; overflow: hidden; }
.prop-card-h .p-img img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.prop-card-h .p-img .p-badges { position: absolute; top: 10px; left: 10px; display: flex; gap: 0.375rem; z-index: 1; }
.prop-card-h .p-img .p-badge { padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.625rem; font-weight: 600; }
.prop-card-h .p-img .p-price { position: absolute; bottom: 10px; left: 10px; background: rgba(15,23,42,0.85); color: #fff; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.9375rem; font-weight: 700; z-index: 1; }
.prop-card-h .p-img .p-price small { font-size: 0.625rem; opacity: 0.7; }
.prop-card-h .p-body { flex: 1; padding: 1.25rem; display: flex; flex-direction: column; }
.prop-card-h .p-body .p-title { font-size: 1.0625rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem; }
.prop-card-h .p-body .p-location { display: flex; align-items: center; gap: 0.375rem; color: var(--text-muted); font-size: 0.8125rem; margin-bottom: 0.75rem; }
.prop-card-h .p-body .p-desc { font-size: 0.8125rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.prop-card-h .p-body .p-meta { display: flex; gap: 1.25rem; margin-bottom: 1rem; flex-wrap: wrap; }
.prop-card-h .p-body .p-meta span { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: var(--text-muted); }
.prop-card-h .p-body .p-meta span svg { color: var(--primary); }
.prop-card-h .p-body .p-actions { display: flex; gap: 0.75rem; margin-top: auto; }
.prop-card-h .p-body .p-actions a { padding: 0.5rem 1.25rem; border-radius: var(--radius-sm); font-size: 0.8125rem; font-weight: 600; transition: all 0.2s; text-decoration: none; text-align: center; }
@media (max-width: 768px) { .prop-card-h { flex-direction: column; } .prop-card-h .p-img { width: 100%; min-height: 200px; } }
.pagination-wrap { display: flex; justify-content: center; margin-top: 2rem; }
.pagination-wrap .pagination { display: flex; gap: 0.375rem; list-style: none; padding: 0; margin: 0; }
.pagination-wrap .page-item .page-link { display: flex; align-items: center; justify-content: center; min-width: 2.25rem; padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.8125rem; color: var(--text); text-decoration: none; transition: all 0.2s; background: var(--white); }
.pagination-wrap .page-item .page-link:hover { background: var(--bg); border-color: var(--primary); color: var(--primary); }
.pagination-wrap .page-item.active .page-link { background: var(--primary); color: #fff; border-color: var(--primary); }
.pagination-wrap .page-item.disabled .page-link { opacity: 0.4; pointer-events: none; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="search-layout">
        <aside class="filter-sidebar">
            <div class="filter-card">
                <h3>Filters <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/></svg></h3>
                <form method="GET" action="{{ route('search') }}">
                    <div class="filter-group">
                        <label>Location</label>
                        <select name="division">
                            <option value="">All Locations</option>
                            @foreach(['Dhaka','Chattogram','Khulna','Rajshahi','Sylhet','Barisal','Rangpur','Mymensingh'] as $div)
                                <option value="{{ $div }}" {{ request('division') === $div ? 'selected' : '' }}>{{ $div }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Property Type</label>
                        <select name="property_type">
                            <option value="">All Types</option>
                            @foreach(['Flat','House','Sublet','Bachelor Mess','Office','Shop','Hostel','Room'] as $type)
                                <option value="{{ $type }}" {{ request('property_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Rent Range (BDT)</label>
                        <div class="range-inputs">
                            <input type="number" name="min_rent" placeholder="Min" value="{{ request('min_rent') }}">
                            <span>—</span>
                            <input type="number" name="max_rent" placeholder="Max" value="{{ request('max_rent') }}">
                        </div>
                    </div>
                    <div class="filter-group">
                        <label>Bedrooms</label>
                        <select name="bedrooms">
                            <option value="">Any</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                            <option value="4+" {{ request('bedrooms') === '4+' ? 'selected' : '' }}>4+</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Bathrooms</label>
                        <select name="bathrooms">
                            <option value="">Any</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                            <option value="4+" {{ request('bathrooms') === '4+' ? 'selected' : '' }}>4+</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Furnishing</label>
                        <div class="checkbox-group">
                            @foreach(['Furnished','Semi-Furnished','Unfurnished'] as $f)
                                <label>
                                    <input type="checkbox" name="furnishing[]" value="{{ $f }}" {{ in_array($f, (array) request('furnishing')) ? 'checked' : '' }}>
                                    {{ $f }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter-group">
                        <label>Tenant Preference</label>
                        <div class="checkbox-group">
                            @foreach(['Family','Bachelor','Office/Commercial'] as $t)
                                <label>
                                    <input type="checkbox" name="tenant_preference[]" value="{{ $t }}" {{ in_array($t, (array) request('tenant_preference')) ? 'checked' : '' }}>
                                    {{ $t }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="filter-apply">Apply Filters</button>
                    <a href="{{ route('search') }}" class="filter-reset" style="text-decoration:none;">Reset Filters</a>
                </form>
            </div>
        </aside>
        <div>
            <div class="search-results-header">
                <div>
                    <h2>Available Properties</h2>
                    <p>Showing {{ $properties->firstItem() ?? 0 }}–{{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} results</p>
                </div>
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                    <form method="GET" action="{{ route('search') }}" id="searchForm" style="display:contents;">
                        @foreach(request()->except('search', 'sort', 'page') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <div style="position:relative;">
                            <input type="text" name="search" placeholder="Search properties..." value="{{ request('search') }}" id="liveSearch" style="padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:0.8125rem;font-family:var(--font);outline:none;width:220px;transition:border-color 0.2s;box-sizing:border-box;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="position:absolute;left:0.625rem;top:50%;transform:translateY(-50%);color:var(--text-light);pointer-events:none;"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        </div>
                        <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Sort: Latest</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Sort: Price (Low)</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Sort: Price (High)</option>
                    </select>
                </form>
            </div>
            <div class="results-grid">
                @forelse($properties as $property)
                    <div class="prop-card-h">
                        <div class="p-img">
                            @if($property->first_image)
                                <img src="{{ $property->first_image }}" alt="{{ $property->title }}">
                            @else
                                <div style="padding:2rem; display:flex; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                </div>
                            @endif
                            <div class="p-badges">
                                @if($property->status === 'approved')
                                    <span class="p-badge" style="background:var(--success);color:#fff">Verified</span>
                                @endif
                            </div>
                            <div class="p-price">BDT {{ number_format($property->monthly_rent) }} <small>/mo</small></div>
                        </div>
                        <div class="p-body">
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
                                <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> {{ $property->tenant_preference }}</span>
                            </div>
                            <div class="p-actions">
                                <a href="{{ route('property-detail', $property->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                <a href="tel:{{ $property->contact_phone }}" class="btn btn-outline btn-sm">Contact Owner</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1; text-align:center; padding:3rem 1rem;">
                        <div style="font-size:2.5rem; margin-bottom:1rem;">🏠</div>
                        <h3 style="font-size:1.25rem; font-weight:700; color:var(--secondary); margin-bottom:0.5rem;">No Properties Found</h3>
                        <p style="color:var(--text-muted); font-size:0.9375rem;">Try adjusting your filters to find more results.</p>
                    </div>
                @endforelse
            </div>
            @if($properties->hasPages())
                <div class="pagination-wrap">
                    {{ $properties->onEachSide(1)->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
