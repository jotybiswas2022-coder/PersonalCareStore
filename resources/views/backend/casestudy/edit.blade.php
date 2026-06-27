@extends('backend.app')

@section('content')

<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2" style="color:#6366f1;"></i>Edit Case Study</h4>
                    <p class="text-muted small mb-0">Update details for <strong>{{ $caseStudy->title }}</strong></p>
                </div>
                <a href="{{ route('admin.casestudies.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('admin.casestudies.update', $caseStudy->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Basic Info --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Basic Information</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $caseStudy->title) }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="client" class="form-label fw-medium">Client</label>
                                <input type="text" id="client" name="client"
                                       class="form-control @error('client') is-invalid @enderror"
                                       value="{{ old('client', $caseStudy->client) }}">
                                @error('client')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label fw-medium">Category</label>
                                <input type="text" id="category" name="category"
                                       class="form-control @error('category') is-invalid @enderror"
                                       value="{{ old('category', $caseStudy->category) }}">
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Problem / Solution / Result --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-diagram-3 me-2" style="color:#6366f1;"></i>Case Study Details</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="problem" class="form-label fw-medium">Problem <span class="text-danger">*</span></label>
                                <textarea id="problem" name="problem" rows="5"
                                          class="form-control @error('problem') is-invalid @enderror"
                                          required>{{ old('problem', $caseStudy->problem) }}</textarea>
                                @error('problem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="solution" class="form-label fw-medium">Solution <span class="text-danger">*</span></label>
                                <textarea id="solution" name="solution" rows="5"
                                          class="form-control @error('solution') is-invalid @enderror"
                                          required>{{ old('solution', $caseStudy->solution) }}</textarea>
                                @error('solution')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="result" class="form-label fw-medium">Result <span class="text-danger">*</span></label>
                                <textarea id="result" name="result" rows="5"
                                          class="form-control @error('result') is-invalid @enderror"
                                          required>{{ old('result', $caseStudy->result) }}</textarea>
                                @error('result')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Info --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-gear me-2" style="color:#6366f1;"></i>Additional Information</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="technologies" class="form-label fw-medium">Technologies</label>
                                <input type="text" id="technologies" name="technologies"
                                       class="form-control @error('technologies') is-invalid @enderror"
                                       value="{{ old('technologies', $caseStudy->technologies) }}">
                                @error('technologies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="url" class="form-label fw-medium">Project URL</label>
                                <input type="url" id="url" name="url"
                                       class="form-control @error('url') is-invalid @enderror"
                                       value="{{ old('url', $caseStudy->url) }}">
                                @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="sort_order" class="form-label fw-medium">Sort Order</label>
                                <input type="number" id="sort_order" name="sort_order" min="0"
                                       class="form-control @error('sort_order') is-invalid @enderror"
                                       value="{{ old('sort_order', $caseStudy->sort_order) }}">
                                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Image --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-image me-2" style="color:#6366f1;"></i>Case Study Image</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div>
                                @if($caseStudy->image)
                                    <img src="{{ config('app.storage_url') }}{{ $caseStudy->image }}"
                                         id="preview"
                                         class="rounded shadow-sm"
                                         style="width:120px; height:80px; object-fit:cover;">
                                    <div id="previewPlaceholder" style="display:none;"
                                         class="rounded d-inline-flex align-items-center justify-content-center"
                                         style="width:120px; height:80px; background:#f1f5f9; color:#94a3b8; font-size:2rem;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @else
                                    <div id="previewPlaceholder"
                                         class="rounded d-inline-flex align-items-center justify-content-center"
                                         style="width:120px; height:80px; background:#f1f5f9; color:#94a3b8; font-size:2rem;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                    <img id="preview" src="" style="display:none; width:120px; height:80px; object-fit:cover;"
                                         class="rounded shadow-sm">
                                @endif
                            </div>
                            <div>
                                <input type="file" accept="image/*" id="image" name="image"
                                       class="form-control @error('image') is-invalid @enderror"
                                       onchange="previewImage(event)">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body px-4 py-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $caseStudy->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.casestudies.index') }}" class="btn btn-light border rounded-3 px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-3 px-5" style="background:#6366f1; border-color:#6366f1;">
                        <i class="bi bi-check-circle me-1"></i> Update Case Study
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@section('scripts')
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

@endsection
