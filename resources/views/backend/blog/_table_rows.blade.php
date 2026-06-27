@forelse($posts as $post)
    <tr>
        <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
        <td>
            @if($post->featured_image)
                <img src="{{ config('app.storage_url') }}{{ $post->featured_image }}"
                     alt="{{ $post->title }}"
                     class="rounded" style="width:55px; height:38px; object-fit:cover;">
            @else
                <div class="rounded d-inline-flex align-items-center justify-content-center"
                     style="width:55px; height:38px; background:#f1f5f9; color:#cbd5e1;">
                    <i class="bi bi-image"></i>
                </div>
            @endif
        </td>
        <td>
            <div class="fw-semibold">{{ $post->title }}</div>
            <a href="{{ url('/blog/' . $post->slug) }}" target="_blank" class="small text-decoration-none" style="color:#6366f1;">
                <i class="bi bi-box-arrow-up-right"></i> View
            </a>
        </td>
        <td>
            @if($post->category)
                <span class="badge rounded-pill px-3 py-1" style="background:rgba(99,102,241,0.08); color:#6366f1; font-weight:500;">
                    {{ $post->category }}
                </span>
            @else
                <span class="text-muted small">—</span>
            @endif
        </td>
        <td class="small text-muted">{{ $post->author->name ?? 'Unknown' }}</td>
        <td class="small">
            <span class="badge rounded-pill px-3 py-1" style="background:#f1f5f9; color:#475569; font-weight:500; font-size:0.75rem;">
                <i class="bi bi-calendar3 me-1"></i>{{ $post->formatted_date }}
            </span>
        </td>
        <td>
            <a href="{{ route('admin.blog.toggleStatus', $post->id) }}"
               class="badge rounded-pill px-3 py-1 text-decoration-none status-badge {{ $post->is_published ? 'published-badge' : 'draft-badge' }}"
               data-title="{{ $post->title }}">
                {{ $post->is_published ? 'Published' : 'Draft' }}
            </a>
        </td>
        <td>
            <div class="d-flex gap-1">
                <a href="{{ route('admin.blog.edit', $post->id) }}"
                   class="btn btn-sm btn-outline-primary rounded-3 px-2">
                    <i class="bi bi-pencil"></i>
                </a>
                <button type="button"
                        class="btn btn-sm btn-outline-danger rounded-3 px-2 delete-btn"
                        data-id="{{ $post->id }}"
                        data-title="{{ $post->title }}">
                    <i class="bi bi-trash"></i>
                </button>
                <form id="delete-form-{{ $post->id }}"
                      action="{{ route('admin.blog.destroy', $post->id) }}"
                      method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-5">
            <div class="empty-state">
                <i class="bi bi-search" style="font-size:2rem; color:#94a3b8; display:block; margin-bottom:0.5rem;"></i>
                <div class="fw-semibold mb-2">No Posts Found</div>
                <p class="text-muted small">Try adjusting your search terms.</p>
            </div>
        </td>
    </tr>
@endforelse
