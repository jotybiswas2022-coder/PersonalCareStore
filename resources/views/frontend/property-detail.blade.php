@extends('frontend.layouts.app')

@section('title', 'Property Details')

@push('styles')
<style>
.prop-detail { max-width: 1280px; margin: 0 auto; padding: 2rem 1.5rem; }
.prop-gallery { display: grid; grid-template-columns: 2fr 1fr; grid-template-rows: 300px 300px; gap: 0.75rem; border-radius: var(--radius); overflow: hidden; margin-bottom: 2rem; }
.prop-gallery .gallery-main { grid-row: 1 / -1; background: linear-gradient(135deg, #E2E8F0, #CBD5E1); position: relative; display: flex; align-items: center; justify-content: center; }
.prop-gallery .gallery-item { background: linear-gradient(135deg, #E2E8F0, #CBD5E1); position: relative; display: flex; align-items: center; justify-content: center; }
.prop-gallery .gallery-item svg { opacity: 0.3; }
.gallery-badges { position: absolute; top: 16px; left: 16px; display: flex; gap: 0.5rem; z-index: 1; }
.gallery-badge { padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
.gallery-cta { position: absolute; bottom: 16px; right: 16px; background: rgba(15,23,42,0.75); backdrop-filter: blur(8px); color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; font-family: var(--font); transition: all 0.2s; }
.gallery-cta:hover { background: rgba(15,23,42,0.9); }
@media (max-width: 768px) { .prop-gallery { grid-template-columns: 1fr; grid-template-rows: 250px 120px 120px; } .prop-gallery .gallery-main { grid-row: auto; } }
.prop-content { display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start; }
@media (max-width: 1024px) { .prop-content { grid-template-columns: 1fr; } }
.prop-info { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 2rem; }
.prop-info .prop-title { font-size: 1.75rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.5rem; }
.prop-info .prop-address { display: flex; align-items: center; gap: 0.375rem; color: var(--text-muted); font-size: 0.9375rem; margin-bottom: 1.25rem; }
.prop-info .prop-price-row { display: flex; align-items: baseline; gap: 0.75rem; margin-bottom: 1.5rem; }
.prop-info .prop-price-row .price { font-size: 2rem; font-weight: 800; color: var(--primary); }
.prop-info .prop-price-row .price small { font-size: 0.9375rem; font-weight: 400; color: var(--text-muted); }
.prop-info .prop-price-row .status { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
.status-available { background: #D1FAE5; color: #065F46; }
.status-rented { background: #FEE2E2; color: #991B1B; }
.prop-meta-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; padding: 1.25rem; background: var(--bg); border-radius: var(--radius-sm); margin-bottom: 1.5rem; }
.prop-meta-item { text-align: center; }
.prop-meta-item .pm-icon { color: var(--primary); margin-bottom: 0.375rem; }
.prop-meta-item .pm-value { font-size: 1rem; font-weight: 700; color: var(--secondary); }
.prop-meta-item .pm-label { font-size: 0.75rem; color: var(--text-muted); }
@media (max-width: 640px) { .prop-meta-grid { grid-template-columns: repeat(2, 1fr); } }
.prop-section { margin-bottom: 2rem; }
.prop-section h3 { font-size: 1.125rem; font-weight: 700; color: var(--secondary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--bg); }
.prop-section p, .prop-section li { font-size: 0.9375rem; color: var(--text); line-height: 1.7; }
.amenities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 0.75rem; }
.amenity-item { display: flex; align-items: center; gap: 0.625rem; padding: 0.625rem 0.875rem; background: var(--bg); border-radius: var(--radius-sm); font-size: 0.875rem; color: var(--text); }
.amenity-item svg { color: var(--success); flex-shrink: 0; }
.prop-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }
.owner-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; text-align: center; }
.owner-card .owner-avatar { width: 4rem; height: 4rem; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.375rem; margin: 0 auto 0.75rem; }
.owner-card h4 { font-size: 1.0625rem; font-weight: 700; color: var(--secondary); }
.owner-card .owner-status { display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; color: var(--success); font-weight: 500; margin-bottom: 1rem; }
.owner-card .owner-status .dot { width: 0.375rem; height: 0.375rem; background: var(--success); border-radius: 50%; }
.owner-card .owner-contact { display: flex; flex-direction: column; gap: 0.625rem; }
.owner-card .owner-contact a { display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; border-radius: var(--radius-sm); font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.owner-card .owner-contact .btn-call { background: var(--primary); color: #fff; }
.owner-card .owner-contact .btn-call:hover { background: var(--primary-dark); }
.owner-card .owner-contact .btn-whatsapp { background: #25D366; color: #fff; }
.owner-card .owner-contact .btn-whatsapp:hover { background: #1DA851; }
.owner-card .owner-contact .btn-message { background: var(--bg); color: var(--text); border: 1px solid var(--border); }
.owner-card .owner-contact .btn-message:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary-light); }
.map-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; }
.map-card h4 { font-size: 1rem; font-weight: 700; color: var(--secondary); margin-bottom: 1rem; }
.map-placeholder { height: 200px; background: var(--bg); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.875rem; }
</style>
@endpush

@section('content')
<div class="prop-detail">
    <div class="prop-gallery">
        <div class="gallery-main">
            <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <div class="gallery-badges">
                <span class="gallery-badge" style="background:var(--accent);color:var(--secondary)">Featured</span>
                <span class="gallery-badge" style="background:var(--success);color:#fff">Verified Owner</span>
                <span class="gallery-badge" style="background:var(--primary);color:#fff">New Listing</span>
            </div>
            <button class="gallery-cta">View All Photos</button>
        </div>
        <div class="gallery-item"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>
        <div class="gallery-item"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>
    </div>

    <div class="prop-content">
        <div class="prop-info">
            <h1 class="prop-title">Modern 2BHK Apartment in Gulshan</h1>
            <div class="prop-address"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> House 12, Road 7, Gulshan-1, Dhaka 1212</div>
            <div class="prop-price-row">
                <span class="price">BDT 15,000 <small>/month</small></span>
                <span class="status status-available">Available</span>
            </div>

            <div class="prop-meta-grid">
                <div class="prop-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                    <div class="pm-value">2</div>
                    <div class="pm-label">Bedrooms</div>
                </div>
                <div class="prop-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg></div>
                    <div class="pm-value">2</div>
                    <div class="pm-label">Bathrooms</div>
                </div>
                <div class="prop-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg></div>
                    <div class="pm-value">1,200</div>
                    <div class="pm-label">Sq. Ft.</div>
                </div>
                <div class="prop-meta-item">
                    <div class="pm-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg></div>
                    <div class="pm-value">3rd</div>
                    <div class="pm-label">Floor</div>
                </div>
            </div>

            <div class="prop-section">
                <h3>Description</h3>
                <p>Beautiful modern apartment located in the heart of Gulshan. This premium 2-bedroom apartment offers stunning city views, premium finishes, and easy access to all major amenities. The apartment features a spacious living room, modern kitchen with built-in cabinets, two bedrooms with attached bathrooms, and a balcony with panoramic views. Ideal for small families or professionals looking for a premium living experience in Dhaka's most sought-after neighborhood.</p>
            </div>

            <div class="prop-section">
                <h3>Amenities & Features</h3>
                <div class="amenities-grid">
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Air Conditioning</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Fully Furnished</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> WiFi Ready</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Parking</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> CCTV Security</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Lift/Elevator</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Generator</div>
                    <div class="amenity-item"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Water Supply</div>
                </div>
            </div>

            <div class="prop-section">
                <h3>Location</h3>
                <div class="map-placeholder">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="margin-right:0.5rem;"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Map loaded here
                </div>
            </div>
        </div>

        <div class="prop-sidebar">
            <div class="owner-card">
                <div class="owner-avatar">AR</div>
                <h4>Abdur Rahman</h4>
                <div class="owner-status"><span class="dot"></span> Verified Owner</div>
                <div class="owner-contact">
                    <a href="tel:+8801700000000" class="btn-call"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg> Call Now</a>
                    <a href="https://wa.me/8801700000000" class="btn-whatsapp"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg> WhatsApp</a>
                    <a href="#" class="btn-message"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg> Send Message</a>
                </div>
            </div>

            <div class="map-card">
                <h4>Location Map</h4>
                <div class="map-placeholder">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="margin-right:0.375rem;"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Interactive Map
                </div>
            </div>

            <div class="owner-card">
                <h4 style="margin-bottom:0.75rem;">Rental Summary</h4>
                <div style="text-align:left;">
                    <div style="display:flex;justify-content:space-between;padding:0.375rem 0;font-size:0.875rem;color:var(--text-muted);border-bottom:1px solid var(--border);"><span>Rent</span><span style="font-weight:600;color:var(--text);">BDT 15,000</span></div>
                    <div style="display:flex;justify-content:space-between;padding:0.375rem 0;font-size:0.875rem;color:var(--text-muted);border-bottom:1px solid var(--border);"><span>Security Deposit</span><span style="font-weight:600;color:var(--text);">BDT 30,000</span></div>
                    <div style="display:flex;justify-content:space-between;padding:0.375rem 0;font-size:0.875rem;color:var(--text-muted);border-bottom:1px solid var(--border);"><span>Service Charge</span><span style="font-weight:600;color:var(--text);">BDT 1,500</span></div>
                    <div style="display:flex;justify-content:space-between;padding:0.375rem 0;font-size:0.875rem;color:var(--text-muted);"><span>Available From</span><span style="font-weight:600;color:var(--text);">Immediate</span></div>
                </div>
            </div>

            <a href="#" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">Schedule a Visit</a>
        </div>
    </div>
</div>
@endsection
