@extends('admin.layouts.app')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tl-animate { animation: fadeUp 0.5s ease-out both; }
.tl-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
    overflow: hidden;
    isolation: isolate;
}
.tl-hero .hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.5rem;
}
.tl-hero h1 { color: #fff; font-size: 1.5rem; font-weight: 800; letter-spacing: -0.03em; }
.tl-hero p { color: rgba(255,255,255,0.5); font-size: 0.875rem; margin-top: 0.25rem; }

.tf-card {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 0.75rem;
    padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.tf-group { margin-bottom: 1.25rem; }
.tf-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.375rem; }
.tf-group input {
    width: 100%; padding: 0.625rem 0.875rem;
    border: 1px solid #d1d5db; border-radius: 0.5rem;
    font-size: 0.875rem; font-family: inherit; color: #111827;
    outline: none; transition: border-color 0.2s; background: #fff;
}
.tf-group input:focus {
    border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.tf-hint { font-size: 0.75rem; color: #9ca3af; margin-top: 0.25rem; }
.tf-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb; }
.tf-btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.625rem 1.5rem; background: #6366f1; color: #fff;
    border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
}
.tf-btn-primary:hover { background: #4f46e5; }
.tf-btn-secondary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.625rem 1.5rem; background: #fff; color: #374151;
    border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
}
.tf-btn-secondary:hover { background: #f9fafb; }
</style>
@endpush

@section('content')
<div class="tl-hero tl-animate">
    <div class="hero-inner">
        <div>
            <h1>Edit User</h1>
            <p>Update user details for <strong>{{ $user->name }}</strong>.</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="tf-card tl-animate" style="animation-delay:0.1s">
    @csrf
    @method('PUT')

    @if($errors->any())
        <div style="padding:0.875rem 1.25rem; background:#fef2f2; color:#dc2626; border-radius:0.5rem; margin-bottom:1.25rem; font-size:0.875rem;">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="tf-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div class="tf-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div class="tf-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" placeholder="Leave blank to keep current">
        <div class="tf-hint">Minimum 8 characters. Leave empty to keep the current password.</div>
    </div>
    <div class="tf-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
    </div>

    <div class="tf-actions">
        <button type="submit" class="tf-btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Update User
        </button>
        <a href="{{ route('admin.users.index') }}" class="tf-btn-secondary">Cancel</a>
    </div>
</form>
@endsection
