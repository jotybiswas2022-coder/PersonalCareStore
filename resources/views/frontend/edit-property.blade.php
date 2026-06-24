@extends('frontend.layouts.app')

@section('title', 'Edit Property')

@push('styles')
<style>
body { background: var(--navy); }

@keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
@keyframes spin { to { transform: rotate(360deg); } }
.ep-animate { animation: fadeUp 0.5s ease-out both; }

.ep-hero {
    background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 50%, #0F172A 100%);
    padding: 2.5rem 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.ep-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 800px 500px at 20% 40%, rgba(37,99,235,0.12) 0%, transparent 60%), radial-gradient(ellipse 600px 400px at 80% 60%, rgba(245,158,11,0.06) 0%, transparent 60%);
    pointer-events: none;
}
.ep-hero h1 { font-size: 1.75rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; margin-bottom: 0.25rem; position: relative; display: flex; align-items: center; justify-content: center; gap: 0.75rem; flex-wrap: wrap; }
.ep-hero .hero-badge {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;
}
.ep-hero .hero-badge.pending { background: rgba(245,158,11,0.2); color: #fbbf24; }
.ep-hero .hero-badge.approved { background: rgba(16,185,129,0.2); color: #34d399; }
.ep-hero .hero-badge.rejected { background: rgba(239,68,68,0.2); color: #f87171; }
.ep-hero p { color: rgba(255,255,255,0.5); font-size: 0.875rem; position: relative; }

.ep-wrap { max-width: 820px; margin: 0 auto; padding: 2rem 1.5rem; }

.ep-card {
    background: linear-gradient(135deg, rgba(15,23,42,0.55), rgba(15,23,42,0.7));
    backdrop-filter: blur(40px) saturate(1.4);
    -webkit-backdrop-filter: blur(40px) saturate(1.4);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.06);
    padding: 2rem 2.5rem;
    transition: all 0.3s;
}
.ep-card .card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.75rem; padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.ep-card .card-header .card-title { font-size: 1.05rem; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 0.5rem; }
.ep-card .card-header .card-title svg { color: var(--primary); }
.ep-card .card-header .card-badge { font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(37,99,235,0.1); color: var(--accent); }

@media (max-width: 768px) {
    .ep-card { padding: 1.25rem; }
    .ep-card .card-header { flex-direction: column; gap: 0.5rem; align-items: flex-start; }
}

.form-section-divider {
    margin: 1.5rem 0; padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; gap: 0.75rem;
}
.form-section-divider .divider-label {
    font-size: 0.78rem; font-weight: 700; color: var(--accent);
    text-transform: uppercase; letter-spacing: 0.04em;
    display: flex; align-items: center; gap: 0.5rem;
}
.form-section-divider .divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, rgba(255,255,255,0.06), transparent); }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media (max-width: 640px) { .form-row { grid-template-columns: 1fr; } }
.form-row .span-2 { grid-column: span 2; }
@media (max-width: 640px) { .form-row .span-2 { grid-column: span 1; } }

.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: rgba(255,255,255,0.7); margin-bottom: 0.375rem; }
.form-group label .required { color: #EF4444; }
.form-group label .optional { font-weight: 400; color: rgba(255,255,255,0.3); font-size: 0.75rem; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 0.6875rem 0.875rem;
    border: 1.5px solid rgba(255,255,255,0.08);
    border-radius: 10px;
    font-size: 0.875rem; font-family: var(--font);
    background: rgba(0,0,0,0.2);
    outline: none; transition: all 0.2s;
    color: #fff; box-sizing: border-box;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
}
.form-group input.input-error, .form-group select.input-error, .form-group textarea.input-error {
    border-color: #EF4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
}
.form-group textarea { resize: vertical; min-height: 100px; }
.form-group select option { background: #0A0F1E; color: #fff; }
.form-group .help-text { font-size: 0.75rem; color: rgba(255,255,255,0.3); margin-top: 0.25rem; }
.form-group .field-error { font-size: 0.72rem; color: #EF4444; font-weight: 500; margin-top: 0.25rem; }

.existing-images {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.75rem; margin-top: 0.75rem;
}
.existing-image-item {
    position: relative; aspect-ratio: 1; border-radius: 10px;
    overflow: hidden; border: 1px solid rgba(255,255,255,0.06);
}
.existing-image-item img { width: 100%; height: 100%; object-fit: cover; }
.existing-image-item .del-existing {
    position: absolute; top: 4px; right: 4px;
    width: 1.25rem; height: 1.25rem;
    background: rgba(239,68,68,0.85); color: #fff;
    border: none; border-radius: 50%; font-size: 0.65rem;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; z-index: 2; line-height: 1;
}
.existing-image-item .del-existing:hover { background: #b91c1c; transform: scale(1.15); }
.existing-image-item.removing { opacity: 0.3; pointer-events: none; transition: opacity 0.3s; }

.upload-area {
    border: 2px dashed rgba(255,255,255,0.08);
    border-radius: 12px; padding: 2rem; text-align: center;
    cursor: pointer; transition: all 0.2s;
    background: rgba(0,0,0,0.1);
}
.upload-area:hover, .upload-area.dragover { border-color: var(--primary); background: rgba(37,99,235,0.05); }
.upload-area .upload-icon { color: rgba(255,255,255,0.2); margin-bottom: 0.5rem; }
.upload-area p { font-size: 0.875rem; font-weight: 600; color: rgba(255,255,255,0.5); }
.upload-area .upload-hint { font-size: 0.75rem; color: rgba(255,255,255,0.25); margin-top: 0.25rem; }
.upload-preview {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.75rem; margin-top: 1rem;
}
.upload-preview .preview-item {
    position: relative; aspect-ratio: 1; border-radius: 10px;
    overflow: hidden; border: 1px solid rgba(255,255,255,0.06);
    background: rgba(0,0,0,0.2);
}
.upload-preview .preview-item img { width: 100%; height: 100%; object-fit: cover; }
.upload-preview .preview-item .remove {
    position: absolute; top: 4px; right: 4px;
    width: 1.25rem; height: 1.25rem;
    background: rgba(239,68,68,0.85); color: #fff;
    border: none; border-radius: 50%; font-size: 0.65rem;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.upload-preview .preview-item .remove:hover { background: #b91c1c; transform: scale(1.15); }

.form-actions {
    display: flex; align-items: center; justify-content: flex-end;
    gap: 0.75rem; margin-top: 2rem; padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
}
.form-actions .btn-back {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.75rem 1.5rem; background: rgba(255,255,255,0.04);
    color: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px; font-size: 0.875rem; font-weight: 500;
    cursor: pointer; transition: all 0.2s; text-decoration: none;
}
.form-actions .btn-back:hover { background: rgba(255,255,255,0.08); color: #fff; }
.form-actions .btn-submit {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, var(--primary), #4F46E5);
    color: #fff; border: none; border-radius: 12px;
    font-size: 0.875rem; font-weight: 600; cursor: pointer;
    transition: all 0.2s;
}
.form-actions .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(37,99,235,0.3); }

@media (max-width: 640px) {
    .form-actions { flex-direction: column-reverse; align-items: stretch; }
    .form-actions .btn-back, .form-actions .btn-submit { justify-content: center; text-align: center; }
}

/* ─── Info Banner ─── */
.ep-info {
    margin-bottom: 1.5rem;
    padding: 0.875rem 1.25rem;
    border-radius: 12px;
    font-size: 0.8125rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-weight: 500;
    background: rgba(245,158,11,0.08);
    border: 1px solid rgba(245,158,11,0.15);
    color: #FCD34D;
    animation: fadeUp 0.35s ease-out;
}
.ep-info svg { flex-shrink: 0; }
</style>
@endpush

@section('content')
<div class="ep-hero ep-animate">
    <h1>
        Edit Property
        <span class="hero-badge {{ $property->status }}">{{ ucfirst($property->status) }}</span>
    </h1>
    <p>Update your property listing — it will need re-approval after editing</p>
</div>

<div class="ep-wrap">
    <div class="ep-info">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        Editing this property will reset its status to <strong>Pending</strong> — an admin must re-approve it.
    </div>

    <div class="ep-card ep-animate" style="animation-delay:0.1s;">
        <div class="card-header">
            <div class="card-title">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Property #{{ $property->id }}
            </div>
            <span class="card-badge">* Required fields</span>
        </div>

        <form method="POST" action="{{ route('my-properties.update', $property->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Property Details --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Property Details
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-row">
                <div class="span-2 form-group">
                    <label for="title">Property Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $property->title) }}" placeholder="e.g. Modern 3-Bedroom Flat in Dhanmondi" required>
                    @error('title')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="property_type">Property Type <span class="required">*</span></label>
                    <select id="property_type" name="property_type" required>
                        @foreach(['Flat','House','Sublet','Bachelor Mess','Office','Shop','Hostel','Room','Other'] as $type)
                            <option value="{{ $type }}" {{ old('property_type', $property->property_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('property_type')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="listing_type">Listing Type <span class="optional">(optional)</span></label>
                    <select id="listing_type" name="listing_type">
                        <option value="">Select type</option>
                        <option value="rent" {{ old('listing_type', $property->listing_type) === 'rent' ? 'selected' : '' }}>For Rent</option>
                        <option value="sale" {{ old('listing_type', $property->listing_type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bedrooms">Bedrooms <span class="required">*</span></label>
                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" required>
                    @error('bedrooms')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="bathrooms">Bathrooms <span class="required">*</span></label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" required>
                    @error('bathrooms')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="monthly_rent">Monthly Rent (BDT) <span class="required">*</span></label>
                    <input type="number" id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent', $property->monthly_rent) }}" min="0" required>
                    @error('monthly_rent')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="security_deposit">Security Deposit <span class="optional">(optional)</span></label>
                    <input type="number" id="security_deposit" name="security_deposit" value="{{ old('security_deposit', $property->security_deposit) }}" min="0" placeholder="BDT">
                </div>
                <div class="form-group">
                    <label for="property_size">Property Size (sqft) <span class="optional">(optional)</span></label>
                    <input type="number" id="property_size" name="property_size" value="{{ old('property_size', $property->property_size) }}" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="floor_number">Floor Number <span class="optional">(optional)</span></label>
                    <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number', $property->floor_number) }}" min="0">
                </div>
                <div class="form-group">
                    <label for="total_floors">Total Floors <span class="optional">(optional)</span></label>
                    <input type="number" id="total_floors" name="total_floors" value="{{ old('total_floors', $property->total_floors) }}" min="0">
                </div>
                <div class="form-group">
                    <label for="furnishing">Furnishing <span class="optional">(optional)</span></label>
                    <select id="furnishing" name="furnishing">
                        <option value="">Select</option>
                        @foreach(['Furnished','Semi-Furnished','Unfurnished'] as $f)
                            <option value="{{ $f }}" {{ old('furnishing', $property->furnishing) === $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tenant_preference">Tenant Preference <span class="required">*</span></label>
                    <select id="tenant_preference" name="tenant_preference" required>
                        @foreach(['Family','Bachelor','Office/Commercial','Any'] as $t)
                            <option value="{{ $t }}" {{ old('tenant_preference', $property->tenant_preference) === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('tenant_preference')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="available_from">Available From <span class="required">*</span></label>
                    <input type="date" id="available_from" name="available_from" value="{{ old('available_from', $property->available_from?->format('Y-m-d')) }}" required>
                    @error('available_from')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2 form-group">
                    <label for="description">Description <span class="optional">(optional)</span></label>
                    <textarea id="description" name="description" placeholder="Describe the property features, amenities, nearby landmarks, etc." style="min-height:100px;">{{ old('description', $property->description) }}</textarea>
                </div>
            </div>

            {{-- Location --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Location
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="division">Division <span class="required">*</span></label>
                    <select id="division" name="division" required>
                        @foreach(['Dhaka','Chattogram','Rajshahi','Khulna','Barishal','Sylhet','Rangpur','Mymensingh'] as $div)
                            <option value="{{ $div }}" {{ old('division', $property->division) === $div ? 'selected' : '' }}>{{ $div }}</option>
                        @endforeach
                    </select>
                    @error('division')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="district">District <span class="required">*</span></label>
                    <input type="text" id="district" name="district" value="{{ old('district', $property->district) }}" placeholder="e.g. Dhaka" required>
                    @error('district')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="area_location">Area / Location <span class="required">*</span></label>
                    <input type="text" id="area_location" name="area_location" value="{{ old('area_location', $property->area_location) }}" placeholder="e.g. Dhanmondi 27" required>
                    @error('area_location')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2 form-group">
                    <label for="full_address">Full Address <span class="required">*</span></label>
                    <textarea id="full_address" name="full_address" placeholder="House #, Road #, Block, Area" style="min-height:70px;" required>{{ old('full_address', $property->full_address) }}</textarea>
                    @error('full_address')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Contact --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                    Contact Information
                </div>
                <div class="divider-line"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_name">Contact Name <span class="required">*</span></label>
                    <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', $property->contact_name) }}" placeholder="Full name" required>
                    @error('contact_name')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_phone">Contact Phone <span class="required">*</span></label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $property->contact_phone) }}" placeholder="e.g. 01XXXXXXXXX" required>
                    @error('contact_phone')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_email">Contact Email <span class="optional">(optional)</span></label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $property->contact_email) }}" placeholder="email@example.com">
                </div>
                <div class="form-group">
                    <label for="preferred_contact_method">Preferred Contact Method <span class="optional">(optional)</span></label>
                    <select id="preferred_contact_method" name="preferred_contact_method">
                        <option value="">Select</option>
                        <option value="phone" {{ old('preferred_contact_method', $property->preferred_contact_method) === 'phone' ? 'selected' : '' }}>Phone</option>
                        <option value="email" {{ old('preferred_contact_method', $property->preferred_contact_method) === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="both" {{ old('preferred_contact_method', $property->preferred_contact_method) === 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>
            </div>

            {{-- Images --}}
            <div class="form-section-divider">
                <div class="divider-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Property Photos
                </div>
                <div class="divider-line"></div>
            </div>

            @if($property->images && count($property->images) > 0)
                <div style="margin-bottom:1.25rem;">
                    <label style="font-size:0.8rem;font-weight:600;color:rgba(255,255,255,0.5);display:block;margin-bottom:0.5rem;">Current Photos ({{ count($property->images) }})</label>
                    <div class="existing-images" id="existingImages">
                        @foreach($property->all_images as $i => $img)
                            <div class="existing-image-item" data-idx="{{ $i }}">
                                <img src="{{ $img }}" alt="Property photo">
                                <button type="button" class="del-existing" onclick="removeExistingImage(this)" title="Delete this photo">&times;</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <input type="hidden" name="delete_images" id="deleteImages" value="">

            <div class="form-group">
                <label>Add More Photos <span class="optional">(optional, max 5 total)</span></label>
                <div class="upload-area" id="imageUploadArea">
                    <div class="upload-icon">
                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <p><strong>Click to upload</strong> or drag and drop photos</p>
                    <p class="upload-hint">JPEG, PNG, JPG, WebP (max 2MB each, up to 5 photos total)</p>
                </div>
                <input type="file" id="imageInput" name="images[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="display:none;">
                <div class="upload-preview" id="imagePreviewContainer"></div>
                @error('images.*')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('my-properties') }}" class="btn-back">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back to My Properties
                </a>
                <button type="submit" class="btn-submit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update Property
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function removeExistingImage(btn) {
    var item = btn.parentElement;
    var idx = item.getAttribute('data-idx');
    item.classList.add('removing');
    var input = document.getElementById('deleteImages');
    var deleted = input.value ? input.value.split(',').map(Number) : [];
    if (!deleted.includes(idx)) { deleted.push(idx); }
    input.value = deleted.join(',');
}

// Image upload preview
const uploadArea = document.getElementById('imageUploadArea');
const imageInput = document.getElementById('imageInput');
const previewContainer = document.getElementById('imagePreviewContainer');
let selectedFiles = [];

uploadArea.addEventListener('click', () => imageInput.click());
uploadArea.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.classList.add('dragover'); });
uploadArea.addEventListener('dragleave', () => { uploadArea.classList.remove('dragover'); });
uploadArea.addEventListener('drop', (e) => { e.preventDefault(); uploadArea.classList.remove('dragover'); handleFiles(e.dataTransfer.files); });
imageInput.addEventListener('change', () => { handleFiles(imageInput.files); });

function handleFiles(files) {
    const existingCount = {{ count($property->images ?? []) }};
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

function removeFile(index) { selectedFiles.splice(index, 1); updatePreview(); updateFileInput(); }

function updatePreview() {
    previewContainer.innerHTML = '';
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `<img src="${e.target.result}" alt="Preview ${index + 1}"><button type="button" class="remove" data-index="${index}">&times;</button>`;
            div.querySelector('.remove').addEventListener('click', () => removeFile(index));
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
