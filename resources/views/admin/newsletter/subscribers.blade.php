@extends('admin.layouts.app')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tl-animate { animation: fadeUp 0.4s ease-out both; }

.tl-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
    overflow: hidden;
    isolation: isolate;
}
.tl-hero .hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: space-between; gap: 1.5rem;
}
.tl-hero .hero-content { flex: 1; min-width: 0; }
.tl-hero h1 { color: #fff; font-size: 1.375rem; font-weight: 800; letter-spacing: -0.03em; }
.tl-hero p { color: rgba(255,255,255,0.5); font-size: 0.8125rem; margin-top: 0.125rem; }

.subscriber-list { display: flex; flex-direction: column; gap: 0.625rem; }
.subscriber-row {
    display: flex; align-items: center; gap: 0.75rem;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 0.625rem;
    padding: 0.75rem 1rem; transition: all 0.2s;
}
.subscriber-row:hover { border-color: #c7d2fe; box-shadow: 0 1px 4px rgba(99,102,241,0.06); }
.subscriber-avatar {
    width: 2.25rem; height: 2.25rem; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
}
.subscriber-body { flex: 1; min-width: 0; }
.subscriber-body .email { font-weight: 600; font-size: 0.875rem; color: #111827; }
.subscriber-body .date { font-size: 0.8rem; color: #9ca3af; margin-top: 0.125rem; }
.subscriber-actions { display: flex; gap: 0.25rem; flex-shrink: 0; }
.subscriber-actions button {
    display: inline-flex; align-items: center; gap: 0.25rem;
    padding: 0.3rem 0.625rem; border-radius: 0.375rem;
    font-size: 0.6875rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all 0.15s;
}
.subscriber-delete { background: #fef2f2; color: #dc2626; }
.subscriber-delete:hover { background: #fee2e2; }

.tl-empty {
    text-align: center; padding: 3rem 1rem; color: #9ca3af;
}
.tl-empty svg { margin-bottom: 0.75rem; opacity: 0.3; }
.tl-empty h3 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.25rem; }
.tl-empty p { font-size: 0.8125rem; }
</style>
@endpush

@section('content')
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div class="hero-content">
            <h1>Newsletter Subscribers</h1>
            <p>Users who subscribed to your newsletter.</p>
        </div>
        <a href="{{ route('admin.newsletter.send') }}" class="hero-btn" style="display:inline-flex;align-items:center;gap:0.375rem;padding:0.5rem 1.125rem;background:#6366f1;color:#fff;border-radius:0.5rem;font-size:0.8125rem;font-weight:600;text-decoration:none;transition:all 0.2s;white-space:nowrap;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Send Newsletter
        </a>
    </div>
</div>

@if(session('success'))
    <div style="padding:0.75rem 1rem;background:#d1fae5;color:#065f46;border-radius:0.5rem;margin-bottom:1rem;font-size:0.8125rem;font-weight:500;display:flex;align-items:center;gap:0.5rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="subscriber-list tl-animate" style="animation-delay:0.1s">
    @forelse($subscribers as $s)
        <div class="subscriber-row">
            <div class="subscriber-avatar">{{ strtoupper(substr($s->email, 0, 1)) }}</div>
            <div class="subscriber-body">
                <div class="email">{{ $s->email }}</div>
                <div class="date">Subscribed {{ $s->created_at->format('M d, Y \a\t h:i A') }}</div>
            </div>
            <div class="subscriber-actions">
                <form method="POST" action="{{ route('admin.newsletter.destroy', $s->id) }}" class="delete-form" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="button" class="subscriber-delete delete-btn">Remove</button>
                </form>
            </div>
        </div>
    @empty
        <div class="tl-empty">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <h3>No subscribers yet</h3>
            <p>Newsletter signups will appear here.</p>
        </div>
    @endforelse
</div>

@if($subscribers->hasPages())
    <div style="margin-top:1.5rem;">{{ $subscribers->links('vendor.pagination.custom') }}</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        var form = this.closest('.delete-form');
        Swal.fire({
            title: 'Remove subscriber?',
            text: 'This will unsubscribe this email.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
