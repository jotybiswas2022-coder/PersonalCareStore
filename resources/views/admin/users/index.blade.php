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

.user-list { display: flex; flex-direction: column; gap: 0.625rem; }
.user-row {
    display: flex; align-items: center; gap: 0.75rem;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 0.625rem;
    padding: 0.75rem 1rem; transition: all 0.2s;
}
.user-row:hover { border-color: #c7d2fe; box-shadow: 0 1px 4px rgba(99,102,241,0.06); }
.user-serial {
    width: 2rem; text-align: center; font-size: 0.75rem; font-weight: 700;
    color: #9ca3af; flex-shrink: 0;
}
.user-avatar {
    width: 2.25rem; height: 2.25rem; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
}
.user-body { flex: 1; min-width: 0; }
.user-body .name { font-weight: 600; font-size: 0.875rem; color: #111827; }
.user-body .email { font-size: 0.8rem; color: #9ca3af; margin-top: 0.125rem; }
.user-actions { display: flex; gap: 0.25rem; flex-shrink: 0; }
.user-actions a, .user-actions button {
    display: inline-flex; align-items: center; gap: 0.25rem;
    padding: 0.3rem 0.625rem; border-radius: 0.375rem;
    font-size: 0.6875rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all 0.15s;
}
.user-edit { background: #eef2ff; color: #4f46e5; }
.user-edit:hover { background: #e0e7ff; }
.user-delete { background: #fef2f2; color: #dc2626; }
.user-delete:hover { background: #fee2e2; }

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
            <h1>Users</h1>
            <p>Manage registered users (excluding admins).</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div style="padding:0.75rem 1rem; background:#d1fae5; color:#065f46; border-radius:0.5rem; margin-bottom:1rem; font-size:0.8125rem; font-weight:500; display:flex; align-items:center; gap:0.5rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="padding:0.75rem 1rem; background:#fef2f2; color:#dc2626; border-radius:0.5rem; margin-bottom:1rem; font-size:0.8125rem; font-weight:500; display:flex; align-items:center; gap:0.5rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

<div class="user-list tl-animate" style="animation-delay:0.1s">
    @forelse($users as $u)
        <div class="user-row">
            <span class="user-serial">{{ $users->firstItem() + $loop->index }}</span>
            <div class="user-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
            <div class="user-body">
                <div class="name">{{ $u->name }}</div>
                <div class="email">{{ $u->email }}</div>
            </div>
            <div class="user-actions">
                <a href="{{ route('admin.users.edit', $u->id) }}" class="user-edit">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="delete-form" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="button" class="user-delete delete-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="tl-empty">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <h3>No users found</h3>
            <p>There are no registered users yet.</p>
        </div>
    @endforelse
</div>

@if($users->hasPages())
    <div style="margin-top:1.5rem;">
        {{ $users->links('vendor.pagination.custom') }}
    </div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        var form = this.closest('.delete-form');
        Swal.fire({
            title: 'Delete user?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
