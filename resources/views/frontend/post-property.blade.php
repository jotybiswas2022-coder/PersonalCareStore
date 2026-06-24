@extends('frontend.layouts.app')

@section('title', 'Post a Property')

@push('styles')
<style>
body { background: var(--navy); }

@keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
@keyframes slideIn { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
@keyframes spin { to { transform: rotate(360deg); } }
.pp-animate { animation: fadeUp 0.6s ease-out both; }

.pp-hero {
    background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 50%, #0F172A 100%);
    padding: 3rem 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.pp-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 800px 500px at 20% 40%, rgba(37,99,235,0.12) 0%, transparent 60%), radial-gradient(ellipse 600px 400px at 80% 60%, rgba(245,158,11,0.06) 0%, transparent 60%);
    pointer-events: none;
}
.pp-hero h1 { font-size: 2.25rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.5rem; position: relative; }
.pp-hero p { color: rgba(255,255,255,0.5); font-size: 1rem; position: relative; max-width: 32rem; margin: 0 auto; }

.pp-wrap { max-width: 820px; margin: 0 auto; padding: 2.5rem 1.5rem; }

.pp-msg {
    margin-bottom: 1.5rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-weight: 500;
    animation: fadeUp 0.35s ease-out;
}
.pp-msg.success {
    background: rgba(16,185,129,0.12);
    border: 1px solid rgba(16,185,129,0.2);
    color: #34D399;
    box-shadow: 0 4px 16px rgba(16,185,129,0.08);
}
.pp-msg.error {
    background: rgba(239,68,68,0.12);
    border: 1px solid rgba(239,68,68,0.2);
    color: #F87171;
    box-shadow: 0 4px 16px rgba(239,68,68,0.08);
}

.progress-wrap { position: relative; margin-bottom: 2rem; padding: 1.5rem 0 1rem; }
.progress-track {
    position: absolute; top: 50%; left: 10%; right: 10%; height: 2px;
    background: rgba(255,255,255,0.06); transform: translateY(-50%); z-index: 0;
}
.progress-track-fill {
    position: absolute; top: 50%; left: 10%; height: 2px;
    background: linear-gradient(90deg, var(--primary), #7C3AED);
    transform: translateY(-50%); z-index: 1; transition: width 0.4s ease; width: 0%;
}
.progress-steps { display: flex; justify-content: space-between; position: relative; z-index: 2; }
.progress-step { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; cursor: default; }
.progress-step .step-circle {
    width: 2.5rem; height: 2.5rem; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.875rem;
    background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.3);
    transition: all 0.3s; border: 2px solid transparent;
}
.progress-step.active .step-circle {
    background: #fff; color: var(--primary); border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
}
.progress-step.completed .step-circle {
    background: #10B981; color: #fff; border-color: #10B981;
}
.progress-step .step-label { font-size: 0.75rem; font-weight: 500; color: rgba(255,255,255,0.3); transition: all 0.3s; }
.progress-step.active .step-label { color: var(--primary); font-weight: 600; }
.progress-step.completed .step-label { color: #34D399; font-weight: 600; }
@media (max-width: 640px) { .progress-step .step-label { display: none; } }

.form-card {
    background: linear-gradient(135deg, rgba(15,23,42,0.55), rgba(15,23,42,0.7));
    backdrop-filter: blur(40px) saturate(1.4);
    -webkit-backdrop-filter: blur(40px) saturate(1.4);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    animation: slideIn 0.35s ease-out;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
}
.form-card .card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.75rem; padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.form-card .card-header h3 {
    font-size: 1.125rem; font-weight: 700; color: #fff;
    display: flex; align-items: center; gap: 0.5rem;
}
.form-card .card-header h3 svg { color: var(--primary); }
.form-card .card-header .badge {
    font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    background: rgba(37,99,235,0.1); color: var(--accent);
    white-space: nowrap;
}
@media (max-width: 640px) { .form-card { padding: 1.25rem; } .form-card .card-header { flex-direction: column; gap: 0.5rem; align-items: flex-start; } }

.form-step { display: none; }
.form-step.active { display: block; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.5rem; }
@media (max-width: 640px) { .form-row { grid-template-columns: 1fr; } }

.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: rgba(255,255,255,0.7); margin-bottom: 0.375rem; }
.form-group label .required { color: #EF4444; }
.form-group label .optional { font-weight: 400; color: rgba(255,255,255,0.3); font-size: 0.75rem; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 0.6875rem 0.875rem;
    border: 1.5px solid rgba(255,255,255,0.08);
    border-radius: 10px; font-size: 0.875rem; font-family: var(--font);
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
.form-group select option { background: #0A0F1E; color: #fff; }
.form-group textarea { resize: vertical; min-height: 100px; }
.form-group .help-text { font-size: 0.75rem; color: rgba(255,255,255,0.3); margin-top: 0.25rem; }
.form-group .field-error { font-size: 0.72rem; color: #EF4444; font-weight: 500; margin-top: 0.25rem; }

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

.upload-area {
    border: 2px dashed rgba(255,255,255,0.08);
    border-radius: 12px; padding: 2.5rem; text-align: center;
    cursor: pointer; transition: all 0.2s;
    background: rgba(0,0,0,0.1);
}
.upload-area:hover, .upload-area.dragover { border-color: var(--primary); background: rgba(37,99,235,0.05); }
.upload-area .upload-icon { color: rgba(255,255,255,0.2); margin-bottom: 0.75rem; }
.upload-area p { font-size: 0.9375rem; font-weight: 600; color: rgba(255,255,255,0.6); }
.upload-area span { font-size: 0.8125rem; color: rgba(255,255,255,0.3); }
.upload-preview { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 0.75rem; margin-top: 1rem; }
.upload-preview .preview-item {
    aspect-ratio: 1; border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.06);
    overflow: hidden; position: relative;
    background: rgba(0,0,0,0.2);
}
.upload-preview .preview-item img { width: 100%; height: 100%; object-fit: cover; }
.upload-preview .preview-item .remove {
    position: absolute; top: 4px; right: 4px;
    width: 1.25rem; height: 1.25rem;
    background: rgba(239,68,68,0.9); border: none; border-radius: 50%;
    color: #fff; font-size: 0.75rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.upload-preview .preview-item .remove:hover { background: #DC2626; transform: scale(1.1); }

.form-nav {
    display: flex; justify-content: space-between; gap: 1rem;
    margin-top: 2rem; padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
}
.form-nav .btn { min-width: 140px; justify-content: center; }
.form-nav .btn-prev {
    background: rgba(255,255,255,0.04);
    color: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.06);
}
.form-nav .btn-prev:hover { background: rgba(255,255,255,0.08); color: #fff; }
.form-nav .btn-right { margin-left: auto; }
@media (max-width: 640px) { .form-nav { flex-direction: column-reverse; } .form-nav .btn { width: 100%; } .form-nav .btn-right { margin-left: 0; } }

.error-summary {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.15);
    border-radius: 12px; padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex; align-items: flex-start; gap: 0.625rem;
}
.error-summary svg { color: #F87171; flex-shrink: 0; margin-top: 2px; }
.error-summary .error-text { font-size: 0.85rem; color: #FCA5A5; font-weight: 500; }

.spinner {
    display: inline-block; width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

.success-screen { text-align: center; padding: 3rem 2rem; }
.success-screen .success-icon {
    width: 4.5rem; height: 4.5rem;
    background: rgba(16,185,129,0.15);
    border: 1px solid rgba(16,185,129,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 4px 20px rgba(16,185,129,0.1);
}
.success-screen .success-icon svg { color: #34D399; }
.success-screen h2 { font-size: 1.625rem; font-weight: 800; color: #fff; margin-bottom: 0.75rem; }
.success-screen p { color: rgba(255,255,255,0.4); font-size: 0.9375rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto; line-height: 1.6; }
</style>
@endpush

@section('content')
<div class="pp-hero pp-animate">
    <h1>Post Your Property</h1>
    <p>List your rental property and connect with thousands of potential tenants across Bangladesh.</p>
</div>

<div class="pp-wrap">
    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="pp-msg success pp-animate">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error-summary pp-animate">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="error-text">Please fix the {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} below.</span>
        </div>
    @endif

    {{-- Progress Bar --}}
    <div class="progress-wrap pp-animate" style="animation-delay:0.05s">
        <div class="progress-track"></div>
        <div class="progress-track-fill" id="progressFill"></div>
        <div class="progress-steps">
            <div class="progress-step active" data-step="1">
                <div class="step-circle">1</div>
                <span class="step-label">Basic Info</span>
            </div>
            <div class="progress-step" data-step="2">
                <div class="step-circle">2</div>
                <span class="step-label">Details</span>
            </div>
            <div class="progress-step" data-step="3">
                <div class="step-circle">3</div>
                <span class="step-label">Media & Contact</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('post-property.store') }}" enctype="multipart/form-data" id="propertyForm" novalidate>
        @csrf

        {{-- ═══════ STEP 1: Basic Info ═══════ --}}
        <div class="form-step active" data-step="1">
            <div class="form-card pp-animate" style="animation-delay:0.1s">
                <div class="card-header">
                    <h3>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                        Basic Information
                    </h3>
                    <span class="badge">* Required</span>
                </div>

                <div class="form-row">
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
                        <label for="listing_type">Listing Type <span class="required">*</span></label>
                        <select id="listing_type" name="listing_type" class="{{ $errors->has('listing_type') ? 'input-error' : '' }}" required>
                            <option value="">Select</option>
                            <option value="for_rent" {{ old('listing_type') == 'for_rent' ? 'selected' : '' }}>For Rent</option>
                            <option value="for_sublet" {{ old('listing_type') == 'for_sublet' ? 'selected' : '' }}>For Sublet</option>
                            <option value="for_lease" {{ old('listing_type') == 'for_lease' ? 'selected' : '' }}>For Lease</option>
                        </select>
                        @error('listing_type')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Property Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Modern 2BHK Apartment in Gulshan" class="{{ $errors->has('title') ? 'input-error' : '' }}" required>
                    <span class="help-text">A clear title helps your listing get more views.</span>
                    @error('title')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea id="description" name="description" placeholder="Describe your property in detail — number of rooms, floor, condition, nearby amenities, etc." class="{{ $errors->has('description') ? 'input-error' : '' }}" required>{{ old('description') }}</textarea>
                    @error('description')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="monthly_rent">Rent Amount (BDT) <span class="required">*</span></label>
                        <input type="number" id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent') }}" placeholder="e.g. 15000" min="0" class="{{ $errors->has('monthly_rent') ? 'input-error' : '' }}" required>
                        @error('monthly_rent')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="security_deposit">Security Deposit <span class="optional">(optional)</span></label>
                        <input type="number" id="security_deposit" name="security_deposit" value="{{ old('security_deposit') }}" placeholder="e.g. 30000" min="0" class="{{ $errors->has('security_deposit') ? 'input-error' : '' }}">
                        @error('security_deposit')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-nav">
                <div></div>
                <button type="button" class="btn btn-primary btn-right" onclick="goToStep(2)">Next Step &rarr;</button>
            </div>
        </div>

        {{-- ═══════ STEP 2: Details ═══════ --}}
        <div class="form-step" data-step="2">
            <div class="form-card pp-animate" style="animation-delay:0.1s">
                <div class="card-header">
                    <h3>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        Property Details
                    </h3>
                    <span class="badge">* Required</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="bedrooms">Bedrooms <span class="required">*</span></label>
                        <select id="bedrooms" name="bedrooms" class="{{ $errors->has('bedrooms') ? 'input-error' : '' }}" required>
                            <option value="">Select</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}{{ $i >= 5 ? '+' : '' }}</option>
                            @endfor
                        </select>
                        @error('bedrooms')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="bathrooms">Bathrooms <span class="required">*</span></label>
                        <select id="bathrooms" name="bathrooms" class="{{ $errors->has('bathrooms') ? 'input-error' : '' }}" required>
                            <option value="">Select</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('bathrooms') == $i ? 'selected' : '' }}>{{ $i }}{{ $i >= 5 ? '+' : '' }}</option>
                            @endfor
                        </select>
                        @error('bathrooms')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="floor_number">Floor Number <span class="optional">(optional)</span></label>
                        <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number') }}" placeholder="e.g. 3" min="0" class="{{ $errors->has('floor_number') ? 'input-error' : '' }}">
                        @error('floor_number')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="total_floors">Total Floors <span class="optional">(optional)</span></label>
                        <input type="number" id="total_floors" name="total_floors" value="{{ old('total_floors') }}" placeholder="e.g. 8" min="0" class="{{ $errors->has('total_floors') ? 'input-error' : '' }}">
                        @error('total_floors')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="property_size">Square Footage <span class="optional">(optional)</span></label>
                        <input type="number" id="property_size" name="property_size" value="{{ old('property_size') }}" placeholder="e.g. 1200" min="0" step="0.01" class="{{ $errors->has('property_size') ? 'input-error' : '' }}">
                        @error('property_size')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="furnishing">Furnishing <span class="optional">(optional)</span></label>
                        <select id="furnishing" name="furnishing" class="{{ $errors->has('furnishing') ? 'input-error' : '' }}">
                            <option value="">Select</option>
                            <option value="furnished" {{ old('furnishing') == 'furnished' ? 'selected' : '' }}>Furnished</option>
                            <option value="semi_furnished" {{ old('furnishing') == 'semi_furnished' ? 'selected' : '' }}>Semi-Furnished</option>
                            <option value="unfurnished" {{ old('furnishing') == 'unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                        </select>
                        @error('furnishing')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tenant_preference">Tenant Preference <span class="required">*</span></label>
                        <select id="tenant_preference" name="tenant_preference" class="{{ $errors->has('tenant_preference') ? 'input-error' : '' }}" required>
                            <option value="">Select</option>
                            <option value="any" {{ old('tenant_preference') == 'any' ? 'selected' : '' }}>Any</option>
                            <option value="family" {{ old('tenant_preference') == 'family' ? 'selected' : '' }}>Family</option>
                            <option value="bachelor" {{ old('tenant_preference') == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                            <option value="student" {{ old('tenant_preference') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="office" {{ old('tenant_preference') == 'office' ? 'selected' : '' }}>Office / Commercial</option>
                        </select>
                        @error('tenant_preference')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="available_from">Available From <span class="required">*</span></label>
                        <input type="date" id="available_from" name="available_from" value="{{ old('available_from') }}" class="{{ $errors->has('available_from') ? 'input-error' : '' }}" required>
                        @error('available_from')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Location Section --}}
                <div class="form-section-divider">
                    <span class="divider-label">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Location
                    </span>
                    <span class="divider-line"></span>
                </div>

                <div class="form-row">
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
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="area_location">Area / Neighborhood <span class="required">*</span></label>
                        <input type="text" id="area_location" name="area_location" value="{{ old('area_location') }}" placeholder="e.g. Gulshan, Banani" class="{{ $errors->has('area_location') ? 'input-error' : '' }}" required>
                        @error('area_location')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="full_address">Full Address <span class="required">*</span></label>
                        <input type="text" id="full_address" name="full_address" value="{{ old('full_address') }}" placeholder="Full address including house, road, block" class="{{ $errors->has('full_address') ? 'input-error' : '' }}" required>
                        @error('full_address')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-nav">
                <button type="button" class="btn btn-prev" onclick="goToStep(1)">&larr; Previous</button>
                <button type="button" class="btn btn-primary" onclick="goToStep(3)">Next Step &rarr;</button>
            </div>
        </div>

        {{-- ═══════ STEP 3: Media & Contact ═══════ --}}
        <div class="form-step" data-step="3">
            <div class="form-card pp-animate" style="animation-delay:0.1s">
                <div class="card-header">
                    <h3>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Photos & Contact
                    </h3>
                    <span class="badge">* Required</span>
                </div>

                <div class="form-group">
                    <label for="fileInput">Upload Photos <span class="required">*</span> <span class="optional">(Max 5, at least 1 required)</span></label>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="12" y1="8" x2="12" y2="16"/></svg></div>
                        <p>Click or drag & drop to upload</p>
                        <span>JPG, PNG, WEBP (Max 2MB each)</span>
                    </div>
                    <input type="file" id="fileInput" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" style="display:none">
                    <div class="upload-preview" id="uploadPreview"></div>
                    @error('images')<span class="field-error">{{ $message }}</span>@enderror
                    @error('images.*')<span class="field-error" style="display:block;margin-top:0.25rem;">{{ $message }}</span>@enderror
                </div>

                <div class="form-section-divider">
                    <span class="divider-label">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        Contact Information
                    </span>
                    <span class="divider-line"></span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_name">Your Name <span class="required">*</span></label>
                        <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name') }}" placeholder="Your full name" class="{{ $errors->has('contact_name') ? 'input-error' : '' }}" required>
                        @error('contact_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="e.g. 01700000000" class="{{ $errors->has('contact_phone') ? 'input-error' : '' }}" required>
                        @error('contact_phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_email">Email <span class="optional">(optional)</span></label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" placeholder="your@email.com" class="{{ $errors->has('contact_email') ? 'input-error' : '' }}">
                        @error('contact_email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="preferred_contact_method">Preferred Contact Method <span class="optional">(optional)</span></label>
                        <select id="preferred_contact_method" name="preferred_contact_method" class="{{ $errors->has('preferred_contact_method') ? 'input-error' : '' }}">
                            <option value="">Select</option>
                            <option value="phone" {{ old('preferred_contact_method') == 'phone' ? 'selected' : '' }}>Phone Call</option>
                            <option value="whatsapp" {{ old('preferred_contact_method') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="email" {{ old('preferred_contact_method') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="any" {{ old('preferred_contact_method') == 'any' ? 'selected' : '' }}>Any</option>
                        </select>
                        @error('preferred_contact_method')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-nav">
                <button type="button" class="btn btn-prev" onclick="goToStep(2)">&larr; Previous</button>
                <button type="submit" class="btn btn-success" id="submitBtn" style="background:var(--success);color:#fff;box-shadow:0 4px 14px rgba(16,185,129,0.3);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Submit Property
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
(function() {
    // ─── Multi-step navigation ───
    let currentStep = 1;
    const form = document.getElementById('propertyForm');
    const submitBtn = document.getElementById('submitBtn');

    function updateProgress() {
        const fill = document.getElementById('progressFill');
        fill.style.width = ((currentStep - 1) / 2 * 100) + '%';

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
        if (step > currentStep) {
            const currentStepEl = document.querySelector('.form-step.active');
            let valid = true;
            currentStepEl.querySelectorAll('[required]').forEach(field => {
                if (!field.value || field.value.trim() === '') {
                    field.classList.add('input-error');
                    valid = false;
                } else {
                    field.classList.remove('input-error');
                }
            });
            if (!valid) {
                const firstError = currentStepEl.querySelector('.input-error');
                if (firstError) firstError.focus();
                return;
            }
        }
        currentStep = step;
        updateProgress();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Clear error on input
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', function() { this.classList.remove('input-error'); });
        el.addEventListener('change', function() { this.classList.remove('input-error'); });
    });

    // ─── Form submission loading ───
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner"></span> Submitting...';
    });

    // ─── Image Upload ───
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const preview = document.getElementById('uploadPreview');
    let selectedFiles = [];

    uploadArea.addEventListener('click', () => fileInput.click());
    uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('dragover'); });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
    uploadArea.addEventListener('drop', e => { e.preventDefault(); uploadArea.classList.remove('dragover'); handleFiles(e.dataTransfer.files); });
    fileInput.addEventListener('change', () => handleFiles(fileInput.files));

    function handleFiles(files) {
        const remaining = Math.max(0, 5 - selectedFiles.length);
        const allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        for (let f of files) {
            if (selectedFiles.length >= remaining) break;
            if (!allowed.includes(f.type)) continue;
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
        preview.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${e.target.result}"><button type="button" class="remove" data-index="${index}">×</button>`;
                div.querySelector('.remove').addEventListener('click', () => removeFile(index));
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        fileInput.files = dt.files;
    }

    // ─── Jump to error step on validation failure ───
    @if($errors->any())
        (function() {
            let errorStep = 1;
            document.querySelectorAll('.field-error').forEach(el => {
                const step = el.closest('.form-step');
                if (step && step.dataset.step) {
                    errorStep = Math.min(errorStep, parseInt(step.dataset.step));
                }
            });
            currentStep = errorStep;
            updateProgress();
        })();
    @endif
})();
</script>
@endpush
