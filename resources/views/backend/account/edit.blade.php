@extends('backend.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-modern mx-3" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-person-gear me-2" style="color:#6366f1;"></i>Edit Account</h4>
                    <p class="text-muted small mb-0">Update your profile details and social links</p>
                </div>
                <a href="{{ url('/admin/account') }}" class="btn btn-outline-secondary rounded-3 px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ url('/admin/account/update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Basic Info --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Basic Information</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">Full Name</label>
                                <input type="text" id="name" name="name"
                                       class="form-control form-control-lg"
                                       value="{{ $account->name ?? '' }}"
                                       placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">
                                    <i class="bi bi-envelope me-1" style="color:#6366f1;"></i> Email
                                </label>
                                <input type="email" id="email" name="email"
                                       class="form-control form-control-lg"
                                       value="{{ $account->email ?? '' }}"
                                       placeholder="hello@example.com">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium">
                                    <i class="bi bi-whatsapp me-1" style="color:#25D366;"></i> WhatsApp Number
                                </label>
                                <input type="text" id="phone" name="phone"
                                       class="form-control form-control-lg"
                                       value="{{ $account->phone ?? '' }}"
                                       placeholder="+8801XXXXXXXXX">
                                <div class="form-text mt-1">Used for the WhatsApp floating button.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Profile Picture --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-image me-2" style="color:#6366f1;"></i>Profile Picture</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <div>
                                <img id="preview"
                                     @if(isset($account) && $account->image)
                                         src="{{ config('app.storage_url') }}{{ $account->image }}"
                                     @else
                                         src=""
                                     @endif
                                     class="rounded-circle border shadow-sm"
                                     style="width:110px; height:110px; object-fit:cover; @if(!isset($account) || !$account->image) display:none; @endif">
                                <div id="previewPlaceholder"
                                     @if(isset($account) && $account->image) style="display:none;" @endif
                                     class="rounded-circle d-inline-flex align-items-center justify-content-center border shadow-sm"
                                     style="width:110px; height:110px; background:#f1f5f9; color:#94a3b8; font-size:2.5rem;">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div>
                                <input type="file" accept="image/*" id="image" name="image"
                                       class="form-control" onchange="previewImage(event)">
                                <div class="form-text mt-1">Recommended: Square image, at least 200x200px.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-share me-2" style="color:#6366f1;"></i>Social Links</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="github" class="form-label fw-medium"><i class="bi bi-github me-1"></i> GitHub</label>
                                <input type="url" id="github" name="github" class="form-control"
                                       value="{{ $account->github ?? '' }}" placeholder="https://github.com/username">
                            </div>
                            <div class="col-md-6">
                                <label for="linkedin" class="form-label fw-medium"><i class="bi bi-linkedin me-1" style="color:#0a66c2;"></i> LinkedIn</label>
                                <input type="url" id="linkedin" name="linkedin" class="form-control"
                                       value="{{ $account->linkedin ?? '' }}" placeholder="https://linkedin.com/in/username">
                            </div>
                            <div class="col-md-6">
                                <label for="facebook" class="form-label fw-medium"><i class="bi bi-facebook me-1" style="color:#1877f2;"></i> Facebook</label>
                                <input type="url" id="facebook" name="facebook" class="form-control"
                                       value="{{ $account->facebook ?? '' }}" placeholder="https://facebook.com/username">
                            </div>
                            <div class="col-md-6">
                                <label for="twitter" class="form-label fw-medium"><i class="bi bi-twitter-x me-1"></i> Twitter / X</label>
                                <input type="url" id="twitter" name="twitter" class="form-control"
                                       value="{{ $account->twitter ?? '' }}" placeholder="https://twitter.com/username">
                            </div>
                            <div class="col-md-6">
                                <label for="youtube" class="form-label fw-medium"><i class="bi bi-youtube me-1 text-danger"></i> YouTube</label>
                                <input type="url" id="youtube" name="youtube" class="form-control"
                                       value="{{ $account->youtube ?? '' }}" placeholder="https://youtube.com/@channel">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CV Upload --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-pdf me-2" style="color:#6366f1;"></i>CV / Resume</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <input type="file" accept=".pdf,.doc,.docx" id="cv" name="cv" class="form-control">
                        <div class="form-text mt-1">Maximum 5MB. Accepted: PDF, DOC, DOCX.</div>
                        @if(isset($account) && $account->cv)
                            <div class="mt-3 d-flex align-items-center gap-3 flex-wrap">
                                <a href="{{ config('app.storage_url') }}{{ $account->cv }}"
                                   target="_blank" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                    <i class="bi bi-eye me-1"></i> View Current CV
                                </a>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remove_cv" id="removeCv" value="1">
                                    <label class="form-check-label text-danger small" for="removeCv">Remove existing CV</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ url('/admin/account') }}" class="btn btn-light border rounded-3 px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-3 px-5" style="background:#6366f1; border-color:#6366f1;">
                        <i class="bi bi-check-circle me-1"></i> Update Profile
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('previewPlaceholder');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'inline-block';
        if (placeholder) placeholder.style.display = 'none';
    }
}
</script>

@endsection
