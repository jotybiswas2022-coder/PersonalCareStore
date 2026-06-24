@extends('frontend.layouts.app')

@section('title', 'Search Properties')

@push('styles')
<style>
body { background: var(--navy); }

/* ── Layout ── */
.search-layout { display: grid; grid-template-columns: 320px 1fr; gap: 2rem; align-items: start; padding: 2rem 0; }
@media (max-width: 1024px) { .search-layout { grid-template-columns: 1fr; } }
.filter-sidebar { position: sticky; top: 84px; }
@media (max-width: 1024px) { .filter-sidebar { position: static; } }

/* ── Glass Card ── */
.glass-card {
    background: linear-gradient(135deg, rgba(15,23,42,0.55), rgba(15,23,42,0.7));
    backdrop-filter: blur(40px) saturate(1.4);
    -webkit-backdrop-filter: blur(40px) saturate(1.4);
    border-radius: var(--r-lg);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.06);
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    position: relative;
    overflow: hidden;
}
.glass-card::before {
    content: '';
    position: absolute; inset: 0;
    border-radius: var(--r-lg);
    padding: 1px;
    background: linear-gradient(135deg, rgba(96,165,250,0.2), transparent 40%, transparent 60%, rgba(167,139,250,0.12));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite: exclude;
    pointer-events: none;
}
.glass-card:hover { box-shadow: 0 12px 48px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08); transform: translateY(-2px); }

/* ── Filter Sidebar ── */
.filter-card { padding: 1.5rem; }
.filter-card h3 { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; }
.filter-card h3 svg { color: var(--primary); }
.filter-group { margin-bottom: 1.25rem; }
.filter-group:last-child { margin-bottom: 0; }
.filter-group label { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; font-weight: 600; color: rgba(255,255,255,0.6); margin-bottom: 0.5rem; }
.filter-group label .fg-icon { color: var(--primary); opacity: 0.5; }
.filter-group select, .filter-group input[type="text"], .filter-group input[type="number"] { width: 100%; padding: 0.625rem 0.75rem; border: 1px solid rgba(255,255,255,0.06); border-radius: var(--r-sm); font-size: 0.875rem; font-family: var(--font); background: rgba(0,0,0,0.2); color: #fff; outline: none; transition: all 0.25s; box-sizing: border-box; }
.filter-group select:hover, .filter-group input:hover { border-color: rgba(96,165,250,0.15); }
.filter-group select:focus, .filter-group input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
.filter-group select option { background: #0A0F1E; color: #fff; }
.range-inputs { display: flex; gap: 0.5rem; align-items: center; }
.range-inputs input { width: 100%; padding: 0.5rem 0.625rem; border: 1px solid rgba(255,255,255,0.06); border-radius: var(--r-sm); font-size: 0.8125rem; font-family: var(--font); outline: none; background: rgba(0,0,0,0.2); color: #fff; box-sizing: border-box; transition: border-color 0.25s; }
.range-inputs input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
.range-inputs span { color: rgba(255,255,255,0.2); font-size: 0.8125rem; }
.checkbox-group { display: flex; flex-direction: column; gap: 0.5rem; }
.checkbox-group label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 400; color: rgba(255,255,255,0.7); cursor: pointer; transition: color 0.2s; }
.checkbox-group label:hover { color: #fff; }
.checkbox-group input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--primary); cursor: pointer; }
.filter-actions { margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; }
.filter-apply { width: 100%; padding: 0.75rem; text-align: center; background: linear-gradient(135deg, var(--primary), #4F46E5); color: #fff; border: none; border-radius: var(--r-sm); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: var(--font); position: relative; overflow: hidden; }
.filter-apply:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(37,99,235,0.35); }
.filter-apply:active { transform: translateY(0); }
.filter-reset { width: 100%; padding: 0.625rem; text-align: center; background: transparent; border: 1px solid rgba(255,255,255,0.06); border-radius: var(--r-sm); color: rgba(255,255,255,0.35); font-size: 0.8125rem; font-weight: 500; cursor: pointer; transition: all 0.25s; font-family: var(--font); }
.filter-reset:hover { background: rgba(239,68,68,0.08); color: #F87171; border-color: rgba(239,68,68,0.15); }

/* ── Results Header ── */
.search-results-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1.25rem 1.5rem;
    background: rgba(15,23,42,0.3);
    backdrop-filter: blur(20px) saturate(1.3);
    -webkit-backdrop-filter: blur(20px) saturate(1.3);
    border-radius: var(--r-lg);
    border: 1px solid rgba(96,165,250,0.04);
}
.search-results-header h2 { font-size: 1.25rem; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 0.5rem; }
.search-results-header h2 svg { color: var(--primary); }
.search-results-header p { color: rgba(255,255,255,0.4); font-size: 0.875rem; margin-top: 0.25rem; }
.search-results-header .search-tools { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
.search-results-header .sort-select { padding: 0.5rem 2rem 0.5rem 0.75rem; border: 1px solid rgba(255,255,255,0.06); border-radius: var(--r-sm); font-size: 0.8125rem; font-family: var(--font); outline: none; background: rgba(0,0,0,0.2); color: rgba(255,255,255,0.7); transition: all 0.25s; appearance: none; -webkit-appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' fill='none'%3E%3Cpath d='M1 1l4 4 4-4' stroke='rgba(255,255,255,0.3)' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.625rem center; }
.search-results-header .sort-select:hover { border-color: rgba(96,165,250,0.15); }
.search-results-header .sort-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }

/* ── Results Grid ── */
.results-grid { display: grid; grid-template-columns: 1fr; gap: 1.25rem; }

/* ── Property Card ── */
.prop-card-h {
    display: flex;
    border-radius: var(--r-lg);
    overflow: hidden;
    background: rgba(15,23,42,0.4);
    backdrop-filter: blur(16px) saturate(1.3);
    -webkit-backdrop-filter: blur(16px) saturate(1.3);
    border: 1px solid rgba(96,165,250,0.06);
    transition: all 0.5s cubic-bezier(0.16,1,0.3,1);
    position: relative;
}
.prop-card-h::before {
    content: '';
    position: absolute; inset: 0; border-radius: var(--r-lg);
    padding: 1px;
    background: linear-gradient(135deg, rgba(96,165,250,0.08), transparent 50%, transparent 50%, rgba(167,139,250,0.05));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite: exclude;
    pointer-events: none;
}
.prop-card-h:hover { box-shadow: 0 16px 56px rgba(0,0,0,0.4); transform: translateY(-4px); border-color: rgba(96,165,250,0.12); }
.prop-card-h .p-img { width: 280px; min-height: 200px; flex-shrink: 0; background: linear-gradient(135deg, #1E293B, #0F172A); position: relative; overflow: hidden; }
.prop-card-h .p-img img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; transition: transform 0.7s cubic-bezier(0.16,1,0.3,1); }
.prop-card-h:hover .p-img img { transform: scale(1.08); }
.prop-card-h .p-img .p-img-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.3)); pointer-events: none; z-index: 0; }
.prop-card-h .p-img .p-badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 0.375rem; z-index: 2; }
.prop-card-h .p-img .p-badge { padding: 0.25rem 0.625rem; border-radius: 6px; font-size: 0.625rem; font-weight: 700; letter-spacing: 0.03em; text-transform: uppercase; backdrop-filter: blur(4px); }
.prop-card-h .p-img .p-price { position: absolute; bottom: 12px; left: 12px; background: rgba(0,0,0,0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); color: #FCD34D; padding: 0.375rem 1rem; border-radius: 8px; font-size: 1rem; font-weight: 800; z-index: 2; border: 1px solid rgba(255,255,255,0.06); font-family: var(--font-serif); }
.prop-card-h .p-img .p-price small { font-size: 0.625rem; font-weight: 500; opacity: 0.6; color: rgba(255,255,255,0.6); }
.prop-card-h .p-body { flex: 1; padding: 1.25rem 1.5rem; display: flex; flex-direction: column; }
.prop-card-h .p-body .p-title { font-size: 1.125rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; transition: color 0.2s; font-family: var(--font-serif); }
.prop-card-h:hover .p-body .p-title { color: var(--accent); }
.prop-card-h .p-body .p-location { display: flex; align-items: center; gap: 0.375rem; color: rgba(255,255,255,0.35); font-size: 0.8125rem; margin-bottom: 0.75rem; }
.prop-card-h .p-body .p-desc { font-size: 0.8125rem; color: rgba(255,255,255,0.4); line-height: 1.65; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.prop-card-h .p-body .p-meta { display: flex; gap: 1.25rem; margin-bottom: 1rem; flex-wrap: wrap; }
.prop-card-h .p-body .p-meta span { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: rgba(255,255,255,0.45); }
.prop-card-h .p-body .p-meta span svg { color: var(--primary); }
.prop-card-h .p-body .p-meta-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.04); margin: 0.5rem 0; }
.prop-card-h .p-body .p-actions { display: flex; gap: 0.75rem; margin-top: 0.5rem; }
.prop-card-h .p-body .p-actions a { padding: 0.5rem 1.25rem; border-radius: var(--r-sm); font-size: 0.8125rem; font-weight: 600; transition: all 0.25s; text-decoration: none; text-align: center; }
@media (max-width: 768px) { .prop-card-h { flex-direction: column; } .prop-card-h .p-img { width: 100%; min-height: 200px; } }

/* ── Pagination ── */
.pagination-wrap { display: flex; justify-content: center; margin-top: 2.5rem; }
.pagination-wrap .pagination { display: flex; gap: 0.375rem; list-style: none; padding: 0; margin: 0; }
.pagination-wrap .page-item .page-link { display: flex; align-items: center; justify-content: center; min-width: 2.375rem; padding: 0.5rem 0.75rem; border: 1px solid rgba(255,255,255,0.06); border-radius: var(--r-sm); font-size: 0.8125rem; color: rgba(255,255,255,0.5); text-decoration: none; transition: all 0.25s; background: rgba(15,23,42,0.3); backdrop-filter: blur(8px); }
.pagination-wrap .page-item .page-link:hover { background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.2); color: var(--accent); transform: translateY(-1px); }
.pagination-wrap .page-item.active .page-link { background: linear-gradient(135deg, var(--primary), #4F46E5); color: #fff; border-color: transparent; box-shadow: 0 4px 16px rgba(37,99,235,0.3); }
.pagination-wrap .page-item.disabled .page-link { opacity: 0.2; pointer-events: none; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="search-layout">
        <aside class="filter-sidebar">
            <div class="filter-card glass-card">
                <h3><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/></svg> Filters</h3>
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
                    <div class="filter-actions">
                        <button type="submit" class="filter-apply">Apply Filters</button>
                        <a href="{{ route('search') }}" class="filter-reset">Reset Filters</a>
                    </div>
                </form>
            </div>
        </aside>
        <div>
            <div class="search-results-header">
                <div>
                    <h2><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg> Available Properties</h2>
                    <p>Showing {{ $properties->firstItem() ?? 0 }}–{{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} results</p>
                </div>
                <div class="search-tools">
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
                            <input type="text" name="search" placeholder="Search properties..." value="{{ request('search') }}" id="liveSearch" style="padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1px solid rgba(255,255,255,0.06);border-radius:var(--r-sm);font-size:0.8125rem;font-family:var(--font);outline:none;width:220px;transition:all 0.25s;box-sizing:border-box;background:rgba(0,0,0,0.2);color:rgba(255,255,255,0.7);" onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.08)'" onblur="this.style.borderColor='rgba(255,255,255,0.06)';this.style.boxShadow='none'">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="position:absolute;left:0.625rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.2);pointer-events:none;"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
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
                                <div style="padding:2rem; display:flex; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.2);">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                </div>
                            @endif
                            <div class="p-img-overlay"></div>
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
                                <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg> {{ $property->tenant_preference }}</span>
                            </div>
                            <div class="p-meta-divider"></div>
                            <div class="p-actions">
                                <a href="{{ route('property-detail', $property->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                <a href="tel:{{ $property->contact_phone }}" class="btn btn-outline btn-sm">Contact Owner</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1; text-align:center; padding:3rem 1rem;">
                        <div style="font-size:2.5rem; margin-bottom:1rem;">🏠</div>
                        <h3 style="font-size:1.25rem; font-weight:700; color:#fff; margin-bottom:0.5rem;">No Properties Found</h3>
                        <p style="color:rgba(255,255,255,0.4); font-size:0.9375rem;">Try adjusting your filters to find more results.</p>
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
