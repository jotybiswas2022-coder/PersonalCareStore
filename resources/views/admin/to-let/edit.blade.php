@extends('admin.layouts.app')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tl-animate { animation: fadeUp 0.5s ease-out both; }

/* ── Hero ── */
.tl-form-hero {
    margin: -2rem -2rem 0;
    padding: 2.5rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1a1a2e 40%, #16213e 100%);
    position: relative;
    overflow: hidden;
}
.tl-form-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(99,102,241,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(129,140,248,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.tl-form-hero h1 { font-size: 1.5rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; position: relative; }
.tl-form-hero p { font-size: 0.8125rem; color: rgba(255,255,255,0.5); margin-top: 0.125rem; position: relative; }
.tl-form-hero .hero-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-left: 0.75rem;
    vertical-align: middle;
    position: relative;
}
.tl-form-hero .hero-status.pending { background: rgba(245,158,11,0.2); color: #fbbf24; }
.tl-form-hero .hero-status.approved { background: rgba(16,185,129,0.2); color: #34d399; }
.tl-form-hero .hero-status.rejected { background: rgba(239,68,68,0.2); color: #f87171; }

/* ── Full-width Form Body ── */
.tl-form-body {
    padding: 2rem 2rem 2.5rem;
    background: #f1f5f9;
}

/* ── Card ── */
.tl-form-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    padding: 2rem 2.5rem;
    width: 100%;
}
.tl-form-card .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding-bottom: 1.25rem;
    border-bottom: 2px solid #f1f5f9;
}
.tl-form-card .card-header .card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.tl-form-card .card-header .card-title svg { color: #6366f1; }
.tl-form-card .card-header .card-badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    background: #eef2ff;
    color: #4f46e5;
}

/* ── 3-Column Form Grid ── */
.form-grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1.25rem 1.5rem;
}
.form-grid-3 .span-2 { grid-column: span 2; }
.form-grid-3 .span-3 { grid-column: span 3; }

@media (max-width: 1200px) {
    .form-grid-3 { grid-template-columns: 1fr 1fr; }
    .form-grid-3 .span-2 { grid-column: span 2; }
    .form-grid-3 .span-3 { grid-column: span 2; }
}
@media (max-width: 768px) {
    .form-grid-3 { grid-template-columns: 1fr; }
    .form-grid-3 .span-2 { grid-column: span 1; }
    .form-grid-3 .span-3 { grid-column: span 1; }
}

/* ── Form Group ── */
.form-group { display: flex; flex-direction: column; gap: 0.375rem; }
.form-group label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #374151;
}
.form-group label .required { color: #ef4444; }
.form-group input,
.form-group select,
.form-group textarea {
    padding: 0.625rem 0.875rem;
    border: 1.5px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    outline: none;
    transition: all 0.2s;
    background: #fff;
    font-family: inherit;
    color: #111827;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.form-group textarea { min-height: 100px; resize: vertical; }
.form-group .help-text { font-size: 0.72rem; color: #9ca3af; }

/* ── Section Devider ── */
.form-section-divider {
    margin: 1.75rem 0;
    padding-top: 1.75rem;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.form-section-divider .divider-label {
    font-size: 0.82rem;
    font-weight: 700;
    color: #6366f1;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.form-section-divider .divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, #e2e8f0, transparent);
}

/* ── Existing Images ── */
.existing-images {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 0.75rem;
    margin-top: 0.75rem;
}
.existing-image-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
.existing-image-item img { width: 100%; height: 100%; object-fit: cover; }

/* ── Image Upload Area ── */
.image-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 0.75rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: #fafafa;
}
.image-upload-area:hover { border-color: #6366f1; background: #f5f3ff; }
.image-upload-area.dragover { border-color: #6366f1; background: #eef2ff; }
.image-upload-area .upload-icon { color: #9ca3af; margin-bottom: 0.75rem; }
.image-upload-area p { font-size: 0.875rem; color: #6b7280; }
.image-upload-area .upload-hint { font-size: 0.75rem; color: #9ca3af; margin-top: 0.375rem; }
#imagePreviewContainer {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 0.75rem;
    margin-top: 1rem;
}
.image-preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
.image-preview-item img { width: 100%; height: 100%; object-fit: cover; }
.image-preview-item .remove-image {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    width: 1.25rem;
    height: 1.25rem;
    background: rgba(0,0,0,0.6);
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 0.65rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.image-preview-item .remove-image:hover { background: rgba(220,38,38,0.8); }

/* ── Form Actions ── */
.form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f1f5f9;
}
.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,0.3); }
.btn-submit:active { transform: translateY(0); }
.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #fff;
    color: #374151;
    border: 1.5px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.btn-cancel:hover { background: #f3f4f6; border-color: #9ca3af; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .tl-form-hero { margin: -1rem -1rem 0; padding: 1.5rem 1rem; }
    .tl-form-hero h1 { font-size: 1.15rem; }
    .tl-form-body { padding: 1rem; }
    .tl-form-card { padding: 1.25rem; }
    .form-actions { flex-direction: column-reverse; align-items: stretch; }
    .btn-submit, .btn-cancel { justify-content: center; text-align: center; }
}
@media (max-width: 480px) {
    .tl-form-hero { padding: 1.25rem 0.75rem; }
    .tl-form-hero h1 { font-size: 1rem; }
    .tl-form-body { padding: 0.75rem; }
    .tl-form-card { padding: 1rem; }
}
</style>
@endpush

@section('content')
<div class="tl-form-hero tl-animate">
    <div style="display:flex;align-items:center;flex-wrap:wrap;gap:0.5rem;">
        <h1>Edit Advertisement</h1>
        <span class="hero-status {{ $advertisement->status }}">{{ ucfirst($advertisement->status) }}</span>
    </div>
    <p>Update property listing details</p>
</div>

<div class="tl-form-body">
    <div class="tl-form-card tl-animate" style="animation-delay:0.1s;">
        {{-- Card Header --}}
        <div class="card-header">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Edit property listing #{{ $advertisement->id }}
            </div>
            <span class="card-badge">All fields marked with * are required</span>
        </div>

        <form method="POST" action="{{ route('admin.to-let.update', $advertisement->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- ───────────── Property Details ───────────── --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    Property Details
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-grid-3">
                <div class="span-3 form-group">
                    <label for="title">Property Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $advertisement->title) }}" placeholder="e.g. Modern 3-Bedroom Flat in Dhanmondi" required>
                </div>
                <div class="form-group">
                    <label for="property_type">Property Type <span class="required">*</span></label>
                    <select id="property_type" name="property_type" required>
                        <option value="flat" {{ (old('property_type', $advertisement->property_type) == 'flat') ? 'selected' : '' }}>Flat / Apartment</option>
                        <option value="house" {{ (old('property_type', $advertisement->property_type) == 'house') ? 'selected' : '' }}>House</option>
                        <option value="sublet" {{ (old('property_type', $advertisement->property_type) == 'sublet') ? 'selected' : '' }}>Sublet</option>
                        <option value="bachelor_mess" {{ (old('property_type', $advertisement->property_type) == 'bachelor_mess') ? 'selected' : '' }}>Bachelor Mess</option>
                        <option value="office" {{ (old('property_type', $advertisement->property_type) == 'office') ? 'selected' : '' }}>Office</option>
                        <option value="shop" {{ (old('property_type', $advertisement->property_type) == 'shop') ? 'selected' : '' }}>Shop</option>
                        <option value="room" {{ (old('property_type', $advertisement->property_type) == 'room') ? 'selected' : '' }}>Room</option>
                        <option value="hostel" {{ (old('property_type', $advertisement->property_type) == 'hostel') ? 'selected' : '' }}>Hostel</option>
                        <option value="other" {{ (old('property_type', $advertisement->property_type) == 'other') ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tenant_preference">Tenant Preference <span class="required">*</span></label>
                    <select id="tenant_preference" name="tenant_preference" required>
                        <option value="family" {{ (old('tenant_preference', $advertisement->tenant_preference) == 'family') ? 'selected' : '' }}>Family</option>
                        <option value="bachelor" {{ (old('tenant_preference', $advertisement->tenant_preference) == 'bachelor') ? 'selected' : '' }}>Bachelor</option>
                        <option value="student" {{ (old('tenant_preference', $advertisement->tenant_preference) == 'student') ? 'selected' : '' }}>Student</option>
                        <option value="any" {{ (old('tenant_preference', $advertisement->tenant_preference) == 'any') ? 'selected' : '' }}>Any</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="available_from">Available From <span class="required">*</span></label>
                    <input type="date" id="available_from" name="available_from" value="{{ old('available_from', $advertisement->available_from->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label for="bedrooms">Bedrooms <span class="required">*</span></label>
                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $advertisement->bedrooms) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label for="bathrooms">Bathrooms <span class="required">*</span></label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $advertisement->bathrooms) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label for="monthly_rent">Monthly Rent (৳) <span class="required">*</span></label>
                    <input type="number" id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent', $advertisement->monthly_rent) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label for="property_size">Property Size (sqft)</label>
                    <input type="number" id="property_size" name="property_size" value="{{ old('property_size', $advertisement->property_size) }}" min="0" step="0.01" placeholder="Optional">
                    <div class="help-text">Total area in square feet</div>
                </div>
                <div class="span-3 form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Describe the property features, amenities, nearby landmarks, transport links, security features, floor level, etc." style="min-height:120px;">{{ old('description', $advertisement->description) }}</textarea>
                </div>
            </div>

            {{-- ───────────── Location ───────────── --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Location
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label for="division">Division <span class="required">*</span></label>
                    <select id="division" name="division" required>
                        @foreach(['Dhaka','Chattogram','Rajshahi','Khulna','Barishal','Sylhet','Rangpur','Mymensingh'] as $div)
                            <option value="{{ $div }}" {{ (old('division', $advertisement->division) == $div) ? 'selected' : '' }}>{{ $div }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="district">District <span class="required">*</span></label>
                    <input type="text" id="district" name="district" value="{{ old('district', $advertisement->district) }}" placeholder="e.g. Dhaka" required>
                </div>
                <div class="form-group">
                    <label for="area_location">Area / Location <span class="required">*</span></label>
                    <input type="text" id="area_location" name="area_location" value="{{ old('area_location', $advertisement->area_location) }}" placeholder="e.g. Dhanmondi 27" required>
                </div>
                <div class="span-3 form-group">
                    <label for="full_address">Full Address <span class="required">*</span></label>
                    <textarea id="full_address" name="full_address" placeholder="House #, Road #, Block, Area" style="min-height:70px;" required>{{ old('full_address', $advertisement->full_address) }}</textarea>
                </div>
            </div>

            {{-- ───────────── Contact ───────────── --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Contact Information
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label for="contact_name">Contact Name <span class="required">*</span></label>
                    <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', $advertisement->contact_name) }}" placeholder="Full name" required>
                </div>
                <div class="form-group">
                    <label for="contact_phone">Contact Phone <span class="required">*</span></label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $advertisement->contact_phone) }}" placeholder="e.g. 01XXXXXXXXX" required>
                </div>
                <div class="form-group">
                    <label class="help-text" style="visibility:hidden;">_</label>
                    <div class="help-text" style="padding:0.625rem 0.875rem;background:#f8fafc;border-radius:0.5rem;border:1px solid #e2e8f0;font-size:0.78rem;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle;margin-right:0.25rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Tenants will contact you via this phone number
                    </div>
                </div>
            </div>

            {{-- ───────────── Status & Admin Note ───────────── --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Status & Notes
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="pending" {{ old('status', $advertisement->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $advertisement->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $advertisement->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="span-2 form-group">
                    <label for="admin_note">Admin Note</label>
                    <textarea id="admin_note" name="admin_note" placeholder="Any internal note about this listing" style="min-height:70px;">{{ old('admin_note', $advertisement->admin_note) }}</textarea>
                </div>
            </div>

            {{-- ───────────── Images ───────────── --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Property Photos
                </div>
                <div class="divider-line"></div>
            </div>

            @if($advertisement->images && count($advertisement->images) > 0)
                <div style="margin-bottom:1.25rem;">
                    <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.5rem;">Current Photos ({{ count($advertisement->images) }})</label>
                    <div class="existing-images">
                        @foreach($advertisement->all_images as $img)
                            <div class="existing-image-item">
                                <img src="{{ $img }}" alt="Property photo">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="form-group" style="max-width:700px;">
                <label>Add More Photos (optional)</label>
                <div class="image-upload-area" id="imageUploadArea">
                    <div class="upload-icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <p><strong>Click to upload</strong> or drag and drop additional photos</p>
                    <p class="upload-hint">JPEG, PNG, JPG, WebP (max 2MB each, up to 5 photos total)</p>
                </div>
                <input type="file" id="imageInput" name="images[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="display:none;">
                <div id="imagePreviewContainer"></div>
                @error('images.*')<div style="color:#ef4444;font-size:0.78rem;margin-top:0.25rem;">{{ $message }}</div>@enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.to-let.index') }}" class="btn-cancel">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update Advertisement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const uploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    let selectedFiles = [];

    // Prevent form submission on Enter key in select fields
    document.querySelectorAll('select').forEach(s => {
        s.addEventListener('keydown', e => { if (e.key === 'Enter') e.preventDefault(); });
    });

    uploadArea.addEventListener('click', () => imageInput.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    imageInput.addEventListener('change', () => {
        handleFiles(imageInput.files);
    });

    function handleFiles(files) {
        const existingCount = {{ count($advertisement->images ?? []) }};
        const remaining = Math.max(0, 5 - existingCount - selectedFiles.length);
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        for (let f of files) {
            if (selectedFiles.length >= remaining) break;
            if (!allowedTypes.includes(f.type)) continue;
            if (f.size > 2 * 1024 * 1024) continue;
            selectedFiles.push(f);
        }
        updatePreview();
        updateFileInput();
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
        updateFileInput();
    }

    function updatePreview() {
        previewContainer.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'image-preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="remove-image" data-index="${index}">&times;</button>
                `;
                div.querySelector('.remove-image').addEventListener('click', () => removeFile(index));
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        imageInput.files = dt.files;
    }
</script>
@endpush
