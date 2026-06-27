@extends('backend.app')

@section('content')

<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2" style="color:#6366f1;"></i>Edit Post</h4>
                    <p class="text-muted small mb-0">Update details for <strong>{{ $post->title }}</strong></p>
                </div>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Title & Category --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Post Details</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $post->title) }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="category" class="form-label fw-medium">Category</label>
                                <input type="text" id="category" name="category"
                                       class="form-control @error('category') is-invalid @enderror"
                                       value="{{ old('category', $post->category) }}" placeholder="e.g. Laravel, Tutorial">
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-text-paragraph me-2" style="color:#6366f1;"></i>Content</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <label for="content" class="form-label fw-medium">Content <span class="text-danger">*</span></label>
                        <textarea id="content" name="content" rows="14"
                                  class="form-control @error('content') is-invalid @enderror"
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        <div class="mt-3">
                            <label for="excerpt" class="form-label fw-medium">Excerpt (Short Summary)</label>
                            <textarea id="excerpt" name="excerpt" rows="2"
                                      class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Meta & Image --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-sliders me-2" style="color:#6366f1;"></i>Meta & Settings</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tags" class="form-label fw-medium">Tags</label>
                                <input type="text" id="tags" name="tags"
                                       class="form-control @error('tags') is-invalid @enderror"
                                       value="{{ old('tags', $post->tags) }}" placeholder="e.g. Laravel, PHP, Tutorial">
                                <div class="form-text mt-1">Separate with commas</div>
                                @error('tags')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="featured_image" class="form-label fw-medium">Featured Image</label>
                                @if($post->featured_image)
                                    <div class="mb-2">
                                        <img src="{{ config('app.storage_url') }}{{ $post->featured_image }}"
                                             alt="{{ $post->title }}"
                                             class="rounded shadow-sm" style="max-width:180px; max-height:90px; object-fit:cover;">
                                    </div>
                                @endif
                                <input type="file" accept="image/*" id="featured_image" name="featured_image"
                                       class="form-control @error('featured_image') is-invalid @enderror"
                                       onchange="previewImage(event)">
                                @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-2 d-flex align-items-end pb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_published" name="is_published"
                                           value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium" for="is_published">Published</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3" id="previewContainer" style="display:none;">
                            <img id="preview" src="" class="rounded shadow-sm" style="max-width:300px; max-height:160px; object-fit:cover;">
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-light border rounded-3 px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-3 px-5" style="background:#6366f1; border-color:#6366f1;">
                        <i class="bi bi-check-circle me-1"></i> Update Post
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
    const container = document.getElementById('previewContainer');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        container.style.display = 'block';
    }
}
</script>
@endsection

@endsection
