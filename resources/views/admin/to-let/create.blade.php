@extends('admin.layouts.app')

@section('title', 'Post a Property')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(30px); }
    to   { opacity: 1; transform: translateX(0); }
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

/* ── Full-width Form Body ── */
.tl-form-body {
    padding: 2rem 2rem 2.5rem;
    background: #f1f5f9;
}

/* ── Progress Bar ── */
.progress-wrap {
    position: relative;
    margin-bottom: 2rem;
    padding: 1.5rem 0 1rem;
}
.progress-track {
    position: absolute;
    top: 50%;
    left: 10%;
    right: 10%;
    height: 2px;
    background: #e2e8f0;
    transform: translateY(-50%);
    z-index: 0;
}
.progress-track-fill {
    position: absolute;
    top: 50%;
    left: 10%;
    height: 2px;
    background: linear-gradient(90deg, #6366f1, #818cf8);
    transform: translateY(-50%);
    z-index: 1;
    transition: width 0.4s ease;
    width: 0%;
}
.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}
.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}
.progress-step .step-circle {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    background: #e2e8f0;
    color: #94a3b8;
    transition: all 0.3s;
    border: 2px solid transparent;
}
.progress-step.active .step-circle {
    background: #fff;
    color: #6366f1;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
}
.progress-step.completed .step-circle {
    background: #10b981;
    color: #fff;
    border-color: #10b981;
}
.progress-step .step-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: #94a3b8;
    transition: all 0.3s;
}
.progress-step.active .step-label { color: #6366f1; font-weight: 600; }
.progress-step.completed .step-label { color: #10b981; font-weight: 600; }

/* ── Card ── */
.tl-form-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    padding: 2rem 2.5rem;
    width: 100%;
    animation: slideIn 0.35s ease-out;
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

/* ── Form Steps ── */
.form-step { display: none; }
.form-step.active { display: block; }

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
.form-group input.input-error,
.form-group select.input-error,
.form-group textarea.input-error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
}
.form-group textarea { min-height: 100px; resize: vertical; }
.form-group .help-text { font-size: 0.72rem; color: #9ca3af; }
.form-group .field-error {
    font-size: 0.72rem;
    color: #ef4444;
    font-weight: 500;
}

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
    background: rgba(239,68,68,0.85);
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
.image-preview-item .remove-image:hover { background: #dc2626; transform: scale(1.1); }

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
.form-actions.between { justify-content: space-between; }
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
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-prev {
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
.btn-prev:hover { background: #f3f4f6; border-color: #9ca3af; }
.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #fff;
    color: #6b7280;
    border: 1.5px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.btn-cancel:hover { background: #f3f4f6; border-color: #9ca3af; color: #374151; }

/* ── Error Summary ── */
.error-summary {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 0.75rem;
    padding: 0.875rem 1.125rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.625rem;
}
.error-summary svg { color: #ef4444; flex-shrink: 0; margin-top: 1px; }
.error-summary .error-text { font-size: 0.85rem; color: #991b1b; font-weight: 500; }

/* ── Loading Spinner ── */
.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Success Screen ── */
.success-screen {
    text-align: center;
    padding: 4rem 2rem;
}
.success-screen .success-icon {
    width: 5rem;
    height: 5rem;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 4px 20px rgba(16,185,129,0.2);
}
.success-screen .success-icon svg { color: #059669; }
.success-screen h2 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #111827;
    margin-bottom: 0.5rem;
}
.success-screen p {
    color: #6b7280;
    font-size: 0.9375rem;
    margin-bottom: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}
.success-screen .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.success-screen .btn-back:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,0.3); }

/* ── Responsive ── */
@media (max-width: 768px) {
    .tl-form-hero { margin: -1rem -1rem 0; padding: 1.5rem 1rem; }
    .tl-form-hero h1 { font-size: 1.15rem; }
    .tl-form-body { padding: 1rem; }
    .tl-form-card { padding: 1.25rem; }
    .form-actions { flex-direction: column-reverse; align-items: stretch; }
    .form-actions.between { flex-direction: column-reverse; }
    .btn-submit, .btn-prev, .btn-cancel { justify-content: center; text-align: center; }
    .progress-step .step-label { display: none; }
    .progress-track { left: 5%; right: 5%; }
    .progress-track-fill { left: 5%; }
}
@media (max-width: 480px) {
    .tl-form-hero { padding: 1.25rem 0.75rem; }
    .tl-form-hero h1 { font-size: 1rem; }
    .tl-form-body { padding: 0.75rem; }
    .tl-form-card { padding: 1rem; }
    .form-grid-3 { gap: 0.75rem; }
}
</style>
@endpush

@section('content')
<div class="tl-form-hero tl-animate">
    <h1>New Advertisement</h1>
    <p>Create a new To-Let property listing</p>
</div>

<div class="tl-form-body">
    {{-- Progress Bar --}}
    <div class="progress-wrap tl-animate" style="animation-delay:0.05s;">
        <div class="progress-track"></div>
        <div class="progress-track-fill" id="progressFill"></div>
        <div class="progress-steps">
            <div class="progress-step active" data-step="1">
                <div class="step-circle">1</div>
                <span class="step-label">Property Details</span>
            </div>
            <div class="progress-step" data-step="2">
                <div class="step-circle">2</div>
                <span class="step-label">Location</span>
            </div>
            <div class="progress-step" data-step="3">
                <div class="step-circle">3</div>
                <span class="step-label">Contact & Photos</span>
            </div>
        </div>
    </div>

    {{-- Error Summary --}}
    @if($errors->any())
        <div class="error-summary tl-animate" style="animation-delay:0.1s;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="error-text">Please fix the {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} below before submitting.</span>
        </div>
    @endif

    <div class="tl-form-card tl-animate" style="animation-delay:0.1s;">
        {{-- Card Header --}}
        <div class="card-header">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Fill in the property details
            </div>
            <span class="card-badge">All fields marked with * are required</span>
        </div>

        <form method="POST" action="{{ route('admin.to-let.store') }}" enctype="multipart/form-data" id="propertyForm" novalidate>
            @csrf

            {{-- ═══════ STEP 1: Property Details ═══════ --}}
            <div class="form-step active" data-step="1">
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
                        <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Modern 3-Bedroom Flat in Dhanmondi" class="{{ $errors->has('title') ? 'input-error' : '' }}" required>
                        @error('title')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="property_type">Property Type <span class="required">*</span></label>
                        <select id="property_type" name="property_type" class="{{ $errors->has('property_type') ? 'input-error' : '' }}" required>
                            <option value="">Select type</option>
                            <option value="flat" {{ old('property_type') == 'flat' ? 'selected' : '' }}>Flat / Apartment</option>
                            <option value="house" {{ old('property_type') == 'house' ? 'selected' : '' }}>House</option>
                            <option value="sublet" {{ old('property_type') == 'sublet' ? 'selected' : '' }}>Sublet</option>
                            <option value="bachelor_mess" {{ old('property_type') == 'bachelor_mess' ? 'selected' : '' }}>Bachelor Mess</option>
                            <option value="office" {{ old('property_type') == 'office' ? 'selected' : '' }}>Office</option>
                            <option value="shop" {{ old('property_type') == 'shop' ? 'selected' : '' }}>Shop</option>
                            <option value="room" {{ old('property_type') == 'room' ? 'selected' : '' }}>Room</option>
                            <option value="hostel" {{ old('property_type') == 'hostel' ? 'selected' : '' }}>Hostel</option>
                            <option value="other" {{ old('property_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('property_type')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="listing_type">Listing Type</label>
                        <select id="listing_type" name="listing_type" class="{{ $errors->has('listing_type') ? 'input-error' : '' }}">
                            <option value="">Select</option>
                            <option value="for_rent" {{ old('listing_type') == 'for_rent' ? 'selected' : '' }}>For Rent</option>
                            <option value="for_sublet" {{ old('listing_type') == 'for_sublet' ? 'selected' : '' }}>For Sublet</option>
                            <option value="for_lease" {{ old('listing_type') == 'for_lease' ? 'selected' : '' }}>For Lease</option>
                        </select>
                        @error('listing_type')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tenant_preference">Tenant Preference <span class="required">*</span></label>
                        <select id="tenant_preference" name="tenant_preference" class="{{ $errors->has('tenant_preference') ? 'input-error' : '' }}" required>
                            <option value="">Select preference</option>
                            <option value="family" {{ old('tenant_preference') == 'family' ? 'selected' : '' }}>Family</option>
                            <option value="bachelor" {{ old('tenant_preference') == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                            <option value="student" {{ old('tenant_preference') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="any" {{ old('tenant_preference') == 'any' ? 'selected' : '' }}>Any</option>
                        </select>
                        @error('tenant_preference')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="available_from">Available From <span class="required">*</span></label>
                        <input type="date" id="available_from" name="available_from" value="{{ old('available_from') }}" class="{{ $errors->has('available_from') ? 'input-error' : '' }}" required>
                        @error('available_from')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="bedrooms">Bedrooms <span class="required">*</span></label>
                        <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', 1) }}" min="0" class="{{ $errors->has('bedrooms') ? 'input-error' : '' }}" required>
                        @error('bedrooms')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="bathrooms">Bathrooms <span class="required">*</span></label>
                        <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', 1) }}" min="0" class="{{ $errors->has('bathrooms') ? 'input-error' : '' }}" required>
                        @error('bathrooms')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="floor_number">Floor Number</label>
                        <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number') }}" min="0" placeholder="e.g. 3" class="{{ $errors->has('floor_number') ? 'input-error' : '' }}">
                        @error('floor_number')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="total_floors">Total Floors</label>
                        <input type="number" id="total_floors" name="total_floors" value="{{ old('total_floors') }}" min="0" placeholder="e.g. 8" class="{{ $errors->has('total_floors') ? 'input-error' : '' }}">
                        @error('total_floors')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="monthly_rent">Monthly Rent (৳) <span class="required">*</span></label>
                        <input type="number" id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent') }}" min="0" class="{{ $errors->has('monthly_rent') ? 'input-error' : '' }}" required>
                        @error('monthly_rent')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="security_deposit">Security Deposit (৳)</label>
                        <input type="number" id="security_deposit" name="security_deposit" value="{{ old('security_deposit') }}" min="0" placeholder="Optional" class="{{ $errors->has('security_deposit') ? 'input-error' : '' }}">
                        @error('security_deposit')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="property_size">Property Size (sqft)</label>
                        <input type="number" id="property_size" name="property_size" value="{{ old('property_size') }}" min="0" step="0.01" placeholder="Optional" class="{{ $errors->has('property_size') ? 'input-error' : '' }}">
                        <div class="help-text">Total area in square feet</div>
                        @error('property_size')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="furnishing">Furnishing</label>
                        <select id="furnishing" name="furnishing" class="{{ $errors->has('furnishing') ? 'input-error' : '' }}">
                            <option value="">Select</option>
                            <option value="furnished" {{ old('furnishing') == 'furnished' ? 'selected' : '' }}>Furnished</option>
                            <option value="semi_furnished" {{ old('furnishing') == 'semi_furnished' ? 'selected' : '' }}>Semi-Furnished</option>
                            <option value="unfurnished" {{ old('furnishing') == 'unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                        </select>
                        @error('furnishing')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="span-3 form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Describe the property features, amenities, nearby landmarks, transport links, security features, floor level, etc." class="{{ $errors->has('description') ? 'input-error' : '' }}" style="min-height:120px;">{{ old('description') }}</textarea>
                        @error('description')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="form-actions between">
                    <a href="{{ route('admin.to-let.index') }}" class="btn-cancel">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Cancel
                    </a>
                    <button type="button" class="btn-submit" onclick="goToStep(2)">
                        Next Step
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
            </div>

            {{-- ═══════ STEP 2: Location ═══════ --}}
            <div class="form-step" data-step="2">
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
                        <select id="division" name="division" class="{{ $errors->has('division') ? 'input-error' : '' }}" required>
                            <option value="">Select division</option>
                            <option value="Dhaka" {{ old('division') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                            <option value="Chattogram" {{ old('division') == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                            <option value="Rajshahi" {{ old('division') == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                            <option value="Khulna" {{ old('division') == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                            <option value="Barishal" {{ old('division') == 'Barishal' ? 'selected' : '' }}>Barishal</option>
                            <option value="Sylhet" {{ old('division') == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                            <option value="Rangpur" {{ old('division') == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                            <option value="Mymensingh" {{ old('division') == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                        </select>
                        @error('division')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="district">District <span class="required">*</span></label>
                        <input type="text" id="district" name="district" value="{{ old('district') }}" placeholder="e.g. Dhaka" class="{{ $errors->has('district') ? 'input-error' : '' }}" required>
                        @error('district')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="area_location">Area / Location <span class="required">*</span></label>
                        <input type="text" id="area_location" name="area_location" value="{{ old('area_location') }}" placeholder="e.g. Dhanmondi 27" class="{{ $errors->has('area_location') ? 'input-error' : '' }}" required>
                        @error('area_location')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="span-3 form-group">
                        <label for="full_address">Full Address <span class="required">*</span></label>
                        <textarea id="full_address" name="full_address" placeholder="House #, Road #, Block, Area" class="{{ $errors->has('full_address') ? 'input-error' : '' }}" style="min-height:70px;" required>{{ old('full_address') }}</textarea>
                        @error('full_address')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="form-actions between">
                    <button type="button" class="btn-prev" onclick="goToStep(1)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Previous
                    </button>
                    <button type="button" class="btn-submit" onclick="goToStep(3)">
                        Next Step
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
            </div>

            {{-- ═══════ STEP 3: Contact & Photos ═══════ --}}
            <div class="form-step" data-step="3">
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
                        <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name') }}" placeholder="Full name" class="{{ $errors->has('contact_name') ? 'input-error' : '' }}" required>
                        @error('contact_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Contact Phone <span class="required">*</span></label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="e.g. 01XXXXXXXXX" class="{{ $errors->has('contact_phone') ? 'input-error' : '' }}" required>
                        @error('contact_phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" placeholder="your@email.com" class="{{ $errors->has('contact_email') ? 'input-error' : '' }}">
                        @error('contact_email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="preferred_contact_method">Preferred Contact Method</label>
                        <select id="preferred_contact_method" name="preferred_contact_method" class="{{ $errors->has('preferred_contact_method') ? 'input-error' : '' }}">
                            <option value="">Select</option>
                            <option value="phone" {{ old('preferred_contact_method') == 'phone' ? 'selected' : '' }}>Phone Call</option>
                            <option value="whatsapp" {{ old('preferred_contact_method') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="email" {{ old('preferred_contact_method') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="any" {{ old('preferred_contact_method') == 'any' ? 'selected' : '' }}>Any</option>
                        </select>
                        @error('preferred_contact_method')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="span-2 form-group">
                        <label style="visibility:hidden;">_</label>
                        <div class="help-text" style="padding:0.625rem 0.875rem;background:#f8fafc;border-radius:0.5rem;border:1px solid #e2e8f0;font-size:0.78rem;display:flex;align-items:center;gap:0.375rem;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            Tenants will contact you via the phone or method provided above
                        </div>
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

                <div class="form-group" style="max-width:700px;">
                    <label for="imageInput">Upload Photos <span class="required">*</span> <span class="help-text">(Max 5, at least 1 required)</span></label>
                    <div class="image-upload-area" id="imageUploadArea">
                        <div class="upload-icon">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <p><strong>Click to upload</strong> or drag and drop photos</p>
                        <p class="upload-hint">JPEG, PNG, JPG, WebP (max 2MB each, up to 5 photos)</p>
                    </div>
                    <input type="file" id="imageInput" name="images[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="display:none;">
                    <div id="imagePreviewContainer"></div>
                    @error('images')<span class="field-error">{{ $message }}</span>@enderror
                    @error('images.*')<span class="field-error" style="margin-top:0.25rem;display:block;">{{ $message }}</span>@enderror
                </div>

                {{-- Actions --}}
                <div class="form-actions between">
                    <button type="button" class="btn-prev" onclick="goToStep(2)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Previous
                    </button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Create Advertisement
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    // ── Multi-step navigation ──
    let currentStep = 1;

    function updateProgress() {
        const fill = document.getElementById('progressFill');
        const pct = ((currentStep - 1) / 2) * 100;
        fill.style.width = pct + '%';

        document.querySelectorAll('.progress-step').forEach(el => {
            const step = parseInt(el.dataset.step);
            el.classList.remove('active', 'completed');
            if (step === currentStep) el.classList.add('active');
            else if (step < currentStep) el.classList.add('completed');
        });

        document.querySelectorAll('.form-step').forEach(el => {
            el.classList.remove('active');
            if (parseInt(el.dataset.step) === currentStep) {
                el.classList.add('active');
            }
        });
    }

    window.goToStep = function(step) {
        // Basic client-side validation when going forward
        if (step > currentStep) {
            const currentStepEl = document.querySelector('.form-step.active');
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            let valid = true;
            requiredFields.forEach(field => {
                if (!field.value || field.value.trim() === '') {
                    field.classList.add('input-error');
                    valid = false;
                } else {
                    field.classList.remove('input-error');
                }
            });
            if (!valid) {
                // Scroll to the first error
                const firstError = currentStepEl.querySelector('.input-error');
                if (firstError) firstError.focus();
                return;
            }
        }
        currentStep = step;
        updateProgress();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Clear error styling on input
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', function() {
            this.classList.remove('input-error');
        });
        el.addEventListener('change', function() {
            this.classList.remove('input-error');
        });
    });

    // ── Form submission loading state ──
    const form = document.getElementById('propertyForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner"></span> Submitting...';
    });

    // ── Image upload ──
    const uploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    let selectedFiles = [];

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
        const remaining = Math.max(0, 5 - selectedFiles.length);
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

    // ── If there are validation errors, jump to the step with the first error ──
    @if($errors->any())
        (function() {
            const errorFields = document.querySelectorAll('.field-error');
            let errorStep = 1;
            for (let i = 0; i < errorFields.length; i++) {
                const field = errorFields[i];
                const step = field.closest('.form-step');
                if (step && step.dataset.step) {
                    errorStep = Math.min(errorStep, parseInt(step.dataset.step));
                }
            }
            currentStep = errorStep;
            updateProgress();
        })();
    @endif
})();
</script>
@endpush
