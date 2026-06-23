@extends('frontend.layouts.app')

@section('title', 'Post a Property')

@push('styles')
<style>
.post-page { max-width: 800px; margin: 0 auto; padding: 2.5rem 1.5rem; }
.post-header { text-align: center; margin-bottom: 2.5rem; }
.post-header h1 { font-size: 2rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.5rem; }
.post-header p { color: var(--text-muted); font-size: 0.9375rem; }
.progress-bar { display: flex; justify-content: center; gap: 0; margin-bottom: 3rem; position: relative; }
.progress-bar::before { content: ''; position: absolute; top: 50%; left: 15%; right: 15%; height: 2px; background: var(--border); transform: translateY(-50%); z-index: 0; }
.progress-step { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; position: relative; z-index: 1; width: 33.33%; }
.progress-step .step-circle { width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; background: var(--border); color: var(--text-muted); transition: all 0.3s; }
.progress-step.active .step-circle { background: var(--primary); color: #fff; box-shadow: 0 0 0 4px var(--primary-light); }
.progress-step.completed .step-circle { background: var(--success); color: #fff; }
.progress-step .step-label { font-size: 0.8125rem; font-weight: 500; color: var(--text-muted); }
.progress-step.active .step-label { color: var(--primary); font-weight: 600; }
.progress-step.completed .step-label { color: var(--success); }
.form-section { display: none; }
.form-section.active { display: block; animation: fadeIn 0.3s ease-out; }
.form-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 2rem; }
.form-card h3 { font-size: 1.125rem; font-weight: 700; color: var(--secondary); margin-bottom: 1.5rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
@media (max-width: 640px) { .form-row { grid-template-columns: 1fr; } }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--text); margin-bottom: 0.375rem; }
.form-group label .required { color: #EF4444; }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.6875rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.875rem; font-family: var(--font); background: var(--white); outline: none; transition: all 0.2s; }
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
.form-group textarea { resize: vertical; min-height: 100px; }
.form-group .help-text { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem; }
.upload-area { border: 2px dashed var(--border); border-radius: var(--radius-sm); padding: 2.5rem; text-align: center; cursor: pointer; transition: all 0.2s; }
.upload-area:hover, .upload-area.dragover { border-color: var(--primary); background: var(--primary-light); }
.upload-area .upload-icon { font-size: 2.5rem; color: var(--primary); margin-bottom: 0.75rem; }
.upload-area p { font-size: 0.9375rem; font-weight: 600; color: var(--text); margin-bottom: 0.25rem; }
.upload-area span { font-size: 0.8125rem; color: var(--text-muted); }
.upload-preview { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 1rem; }
.upload-preview .preview-item { width: 100px; height: 100px; border-radius: var(--radius-sm); border: 1px solid var(--border); overflow: hidden; position: relative; background: var(--bg); display: flex; align-items: center; justify-content: center; }
.upload-preview .preview-item .remove { position: absolute; top: 4px; right: 4px; width: 1.25rem; height: 1.25rem; background: rgba(239,68,68,0.9); border: none; border-radius: 50%; color: #fff; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.form-nav { display: flex; justify-content: space-between; gap: 1rem; margin-top: 2rem; }
.form-nav .btn { min-width: 140px; justify-content: center; }
.form-nav .btn-prev { background: var(--bg); color: var(--text); border: 1px solid var(--border); }
.form-nav .btn-prev:hover { background: var(--border); }
.success-screen { text-align: center; padding: 4rem 2rem; }
.success-screen .success-icon { width: 5rem; height: 5rem; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
.success-screen .success-icon svg { color: var(--success); }
.success-screen h2 { font-size: 1.75rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.5rem; }
.success-screen p { color: var(--text-muted); font-size: 0.9375rem; margin-bottom: 2rem; }
</style>
@endpush

@section('content')
<div class="post-page">
    <div class="post-header">
        <h1>Post Your Property</h1>
        <p>List your rental property and connect with thousands of potential tenants across Bangladesh.</p>
    </div>

    <div class="progress-bar">
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

    <form id="postPropertyForm">
        <div class="form-section active" data-step="1">
            <div class="form-card">
                <h3>Basic Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Property Type <span class="required">*</span></label>
                        <select required>
                            <option value="">Select type</option>
                            <option>Flat</option>
                            <option>House</option>
                            <option>Sublet</option>
                            <option>Bachelor Mess</option>
                            <option>Office</option>
                            <option>Shop</option>
                            <option>Hostel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Listing Type <span class="required">*</span></label>
                        <select required>
                            <option value="">Select</option>
                            <option>For Rent</option>
                            <option>For Sublet</option>
                            <option>For Lease</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Property Title <span class="required">*</span></label>
                    <input type="text" placeholder="e.g. Modern 2BHK Apartment in Gulshan" required>
                    <span class="help-text">A clear title helps your listing get more views.</span>
                </div>
                <div class="form-group">
                    <label>Description <span class="required">*</span></label>
                    <textarea placeholder="Describe your property in detail — number of rooms, floor, condition, nearby amenities, etc." required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Rent Amount (BDT) <span class="required">*</span></label>
                        <input type="number" placeholder="e.g. 15000" required>
                    </div>
                    <div class="form-group">
                        <label>Security Deposit</label>
                        <input type="number" placeholder="e.g. 30000">
                    </div>
                </div>
            </div>
            <div class="form-nav">
                <div></div>
                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next Step &rarr;</button>
            </div>
        </div>

        <div class="form-section" data-step="2">
            <div class="form-card">
                <h3>Property Details</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Bedrooms <span class="required">*</span></label>
                        <select required>
                            <option value="">Select</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bathrooms <span class="required">*</span></label>
                        <select required>
                            <option value="">Select</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5+</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Floor Number</label>
                        <input type="number" placeholder="e.g. 3">
                    </div>
                    <div class="form-group">
                        <label>Total Floors</label>
                        <input type="number" placeholder="e.g. 8">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Square Footage</label>
                        <input type="number" placeholder="e.g. 1200">
                    </div>
                    <div class="form-group">
                        <label>Furnishing</label>
                        <select>
                            <option value="">Select</option>
                            <option>Furnished</option>
                            <option>Semi-Furnished</option>
                            <option>Unfurnished</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tenant Preference</label>
                        <select>
                            <option value="">Any</option>
                            <option>Family</option>
                            <option>Bachelor</option>
                            <option>Office/Commercial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Available From</label>
                        <input type="date">
                    </div>
                </div>
                <div class="form-group">
                    <label>Location <span class="required">*</span></label>
                    <input type="text" placeholder="Full address including area, city, and street" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Area/City <span class="required">*</span></label>
                        <select required>
                            <option value="">Select city</option>
                            <option>Dhaka</option>
                            <option>Chattogram</option>
                            <option>Khulna</option>
                            <option>Rajshahi</option>
                            <option>Sylhet</option>
                            <option>Barishal</option>
                            <option>Rangpur</option>
                            <option>Mymensingh</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Neighborhood</label>
                        <input type="text" placeholder="e.g. Gulshan, Banani">
                    </div>
                </div>
            </div>
            <div class="form-nav">
                <button type="button" class="btn btn-prev" onclick="prevStep(1)">&larr; Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next Step &rarr;</button>
            </div>
        </div>

        <div class="form-section" data-step="3">
            <div class="form-card">
                <h3>Photos & Contact</h3>
                <div class="form-group">
                    <label>Upload Photos <span class="required">*</span></label>
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                        <div class="upload-icon"><svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="12" y1="8" x2="12" y2="16"/></svg></div>
                        <p>Click or drag & drop to upload</p>
                        <span>JPG, PNG, WEBP (Max 10MB each)</span>
                        <input type="file" id="fileInput" multiple accept="image/*" style="display:none">
                    </div>
                    <div class="upload-preview" id="uploadPreview"></div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Your Name <span class="required">*</span></label>
                        <input type="text" placeholder="Your full name" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number <span class="required">*</span></label>
                        <input type="tel" placeholder="e.g. 01700000000" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label>Preferred Contact Method</label>
                        <select>
                            <option>Phone Call</option>
                            <option>WhatsApp</option>
                            <option>Email</option>
                            <option>Any</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-nav">
                <button type="button" class="btn btn-prev" onclick="prevStep(2)">&larr; Previous</button>
                <button type="button" class="btn btn-success" onclick="submitForm()" style="background:var(--success);color:#fff;box-shadow:0 4px 14px rgba(16,185,129,0.3);">Submit Property</button>
            </div>
        </div>

        <div class="form-section" data-step="success">
            <div class="form-card success-screen">
                <div class="success-icon"><svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></div>
                <h2>Property Posted Successfully!</h2>
                <p>Your property has been submitted for verification. You'll hear from us within 24 hours. In the meantime, explore other properties on BasaFinder.</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Back to Home</a>
            </div>
        </div>
    </form>
</div>

<script>
let currentStep = 1;
const totalSteps = 3;

function updateProgress() {
    document.querySelectorAll('.progress-step').forEach(el => {
        const step = parseInt(el.dataset.step);
        el.classList.remove('active', 'completed');
        if (step === currentStep) el.classList.add('active');
        else if (step < currentStep) el.classList.add('completed');
    });
    document.querySelectorAll('.form-section').forEach(el => {
        el.classList.remove('active');
        if (el.dataset.step == currentStep || el.dataset.step === 'success' && currentStep > totalSteps) {
            el.classList.add('active');
        }
    });
}

function nextStep(step) {
    currentStep = step;
    updateProgress();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    currentStep = step;
    updateProgress();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function submitForm() {
    currentStep = 4;
    updateProgress();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const preview = document.getElementById('uploadPreview');

uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('dragover'); });
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
uploadArea.addEventListener('drop', e => { e.preventDefault(); uploadArea.classList.remove('dragover'); handleFiles(e.dataTransfer.files); });
fileInput.addEventListener('change', () => handleFiles(fileInput.files));

function handleFiles(files) {
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;"><button type="button" class="remove" onclick="this.parentElement.remove()">×</button>`;
            preview.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
