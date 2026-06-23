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
.filter-group select, .filter-group input[type="text"] { width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.875rem; font-family: var(--font); background: var(--white); outline: none; transition: border-color 0.2s; }
.filter-group select:focus, .filter-group input:focus { border-color: var(--primary); }
.range-inputs { display: flex; gap: 0.5rem; align-items: center; }
.range-inputs input { width: 100%; padding: 0.5rem 0.625rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.8125rem; font-family: var(--font); outline: none; }
.range-inputs span { color: var(--text-muted); font-size: 0.8125rem; }
.checkbox-group { display: flex; flex-direction: column; gap: 0.5rem; }
.checkbox-group label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 400; color: var(--text); cursor: pointer; margin-bottom: 0; }
.checkbox-group input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--primary); }
.filter-reset { display: block; width: 100%; padding: 0.625rem; text-align: center; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-sm); color: var(--text-muted); font-size: 0.8125rem; font-weight: 500; cursor: pointer; transition: all 0.2s; margin-top: 1rem; }
.filter-reset:hover { background: #FEE2E2; color: #EF4444; border-color: #FEE2E2; }
.search-results-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.search-results-header h2 { font-size: 1.25rem; font-weight: 700; color: var(--secondary); }
.search-results-header p { color: var(--text-muted); font-size: 0.875rem; }
.search-results-header .sort-select { padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.8125rem; font-family: var(--font); outline: none; background: var(--white); }
.results-grid { display: grid; grid-template-columns: 1fr; gap: 1.25rem; }
.prop-card-h { display: flex; background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); overflow: hidden; transition: all 0.3s; }
.prop-card-h:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.prop-card-h .p-img { width: 280px; min-height: 200px; flex-shrink: 0; background: linear-gradient(135deg, #E2E8F0, #CBD5E1); position: relative; }
.prop-card-h .p-img .p-badges { position: absolute; top: 10px; left: 10px; display: flex; gap: 0.375rem; }
.prop-card-h .p-img .p-badge { padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.625rem; font-weight: 600; }
.prop-card-h .p-img .p-price { position: absolute; bottom: 10px; left: 10px; background: rgba(15,23,42,0.85); color: #fff; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.9375rem; font-weight: 700; }
.prop-card-h .p-img .p-price small { font-size: 0.625rem; opacity: 0.7; }
.prop-card-h .p-body { flex: 1; padding: 1.25rem; display: flex; flex-direction: column; }
.prop-card-h .p-body .p-title { font-size: 1.0625rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem; }
.prop-card-h .p-body .p-location { display: flex; align-items: center; gap: 0.375rem; color: var(--text-muted); font-size: 0.8125rem; margin-bottom: 0.75rem; }
.prop-card-h .p-body .p-desc { font-size: 0.8125rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.prop-card-h .p-body .p-meta { display: flex; gap: 1.25rem; margin-bottom: 1rem; }
.prop-card-h .p-body .p-meta span { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: var(--text-muted); }
.prop-card-h .p-body .p-meta span svg { color: var(--primary); }
.prop-card-h .p-body .p-actions { display: flex; gap: 0.75rem; margin-top: auto; }
.prop-card-h .p-body .p-actions a { padding: 0.5rem 1.25rem; border-radius: var(--radius-sm); font-size: 0.8125rem; font-weight: 600; transition: all 0.2s; text-decoration: none; text-align: center; }
@media (max-width: 768px) { .prop-card-h { flex-direction: column; } .prop-card-h .p-img { width: 100%; min-height: 200px; } }
.pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem; }
.pagination a { padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.8125rem; color: var(--text); text-decoration: none; transition: all 0.2s; }
.pagination a:hover, .pagination a.active { background: var(--primary); color: #fff; border-color: var(--primary); }
</style>
@endpush

@section('content')
<div class="container">
    <div class="search-layout">
        <aside class="filter-sidebar">
            <div class="filter-card">
                <h3>Filters <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/></svg></h3>
                <form>
                    <div class="filter-group">
                        <label>Location</label>
                        <select>
                            <option>All Locations</option>
                            <option>Dhaka</option>
                            <option>Chattogram</option>
                            <option>Khulna</option>
                            <option>Rajshahi</option>
                            <option>Sylhet</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Property Type</label>
                        <select>
                            <option>All Types</option>
                            <option>Flat</option>
                            <option>House</option>
                            <option>Sublet</option>
                            <option>Bachelor Mess</option>
                            <option>Office</option>
                            <option>Shop</option>
                            <option>Hostel</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Rent Range (BDT)</label>
                        <div class="range-inputs">
                            <input type="text" placeholder="Min" value="0">
                            <span>—</span>
                            <input type="text" placeholder="Max" value="Any">
                        </div>
                    </div>
                    <div class="filter-group">
                        <label>Bedrooms</label>
                        <select>
                            <option>Any</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4+</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Bathrooms</label>
                        <select>
                            <option>Any</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4+</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Furnishing</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Furnished</label>
                            <label><input type="checkbox"> Semi-Furnished</label>
                            <label><input type="checkbox"> Unfurnished</label>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label>Tenant Preference</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Family</label>
                            <label><input type="checkbox"> Bachelor</label>
                            <label><input type="checkbox"> Office/Commercial</label>
                        </div>
                    </div>
                    <button type="button" class="filter-reset">Reset Filters</button>
                </form>
            </div>
        </aside>
        <div>
            <div class="search-results-header">
                <div><h2>Available Properties</h2><p>Showing 1–6 of 1,250 results</p></div>
                <select class="sort-select">
                    <option>Sort: Latest</option>
                    <option>Sort: Price (Low)</option>
                    <option>Sort: Price (High)</option>
                    <option>Sort: Most Popular</option>
                </select>
            </div>
            <div class="results-grid">
                <div class="prop-card-h">
                    <div class="p-img">
                        <div style="padding:2rem; display:flex; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                        <div class="p-badges"><span class="p-badge" style="background:var(--accent);color:var(--secondary)">Featured</span><span class="p-badge" style="background:var(--success);color:#fff">Verified</span></div>
                        <div class="p-price">BDT 15,000 <small>/mo</small></div>
                    </div>
                    <div class="p-body">
                        <h3 class="p-title">Modern 2BHK Apartment in Gulshan</h3>
                        <div class="p-location"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Gulshan-1, Dhaka</div>
                        <p class="p-desc">A beautiful modern apartment with premium finishes, ample natural light, and easy access to shopping, dining, and transportation.</p>
                        <div class="p-meta">
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 2 Bed</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> 2 Bath</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> 1,200 sqft</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> Family</span>
                        </div>
                        <div class="p-actions">
                            <a href="{{ route('property-detail') }}" class="btn btn-primary btn-sm">View Details</a>
                            <a href="#" class="btn btn-outline btn-sm">Contact Owner</a>
                        </div>
                    </div>
                </div>
                <div class="prop-card-h">
                    <div class="p-img">
                        <div style="padding:2rem; display:flex; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11m16-11v11M8 14v3m4-3v3m4-3v3"/></svg></div>
                        <div class="p-badges"><span class="p-badge" style="background:var(--primary);color:#fff">New</span><span class="p-badge" style="background:var(--success);color:#fff">Verified</span></div>
                        <div class="p-price">BDT 25,000 <small>/mo</small></div>
                    </div>
                    <div class="p-body">
                        <h3 class="p-title">Spacious 4BHK Family House</h3>
                        <div class="p-location"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Dhanmondi 32, Dhaka</div>
                        <p class="p-desc">A spacious family home with a large garden, modern kitchen, and plenty of room for a growing family in a peaceful neighborhood.</p>
                        <div class="p-meta">
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 4 Bed</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> 3 Bath</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> 2,500 sqft</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> Family</span>
                        </div>
                        <div class="p-actions">
                            <a href="{{ route('property-detail') }}" class="btn btn-primary btn-sm">View Details</a>
                            <a href="#" class="btn btn-outline btn-sm">Contact Owner</a>
                        </div>
                    </div>
                </div>
                <div class="prop-card-h">
                    <div class="p-img">
                        <div style="padding:2rem; display:flex; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg></div>
                        <div class="p-badges"><span class="p-badge" style="background:var(--accent);color:var(--secondary)">Featured</span><span class="p-badge" style="background:var(--primary);color:#fff">New</span></div>
                        <div class="p-price">BDT 8,000 <small>/mo</small></div>
                    </div>
                    <div class="p-body">
                        <h3 class="p-title">Cozy Sublet Room in Banani</h3>
                        <div class="p-location"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Banani DOHS, Dhaka</div>
                        <p class="p-desc">A comfortable furnished room in a shared apartment. Perfect for young professionals. All utilities included in the rent.</p>
                        <div class="p-meta">
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 1 Bed</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> 1 Bath</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> Furnished</span>
                            <span><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> Bachelor</span>
                        </div>
                        <div class="p-actions">
                            <a href="{{ route('property-detail') }}" class="btn btn-primary btn-sm">View Details</a>
                            <a href="#" class="btn btn-outline btn-sm">Contact Owner</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">Next &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
