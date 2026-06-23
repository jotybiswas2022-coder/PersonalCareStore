@extends('frontend.layouts.app')

@section('title', 'Login')

@push('styles')
<style>
    /* ─── HERO ─── */
    .auth-hero {
        background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 50%, #FEFCE8 100%);
        padding: 2.5rem 1rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .auth-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .auth-hero h1 { font-size: 1.75rem; font-weight: 700; color: #212529; letter-spacing: -0.02em; position: relative; }
    .auth-hero p { color: #6b7280; font-size: 0.875rem; margin-top: 0.375rem; position: relative; }

    /* ─── WRAP ─── */
    .auth-wrap {
        max-width: 28rem; margin: 0 auto;
        padding: 2rem 1rem 4rem;
        animation: authFadeUp 0.4s ease-out;
    }

    /* ─── CARD ─── */
    .auth-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .auth-card .auth-icon {
        display: flex; align-items: center; justify-content: center;
        width: 3rem; height: 3rem;
        background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
        border-radius: 50%;
        margin: 0 auto 1rem;
        color: #2E8B57;
    }
    .auth-card h2 { text-align: center; font-size: 1.25rem; font-weight: 700; color: #212529; margin-bottom: 0.25rem; }
    .auth-card .sub { text-align: center; color: #6b7280; font-size: 0.8125rem; margin-bottom: 1.5rem; }

    /* ─── ALERTS ─── */
    .alert-box {
        display: flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 1rem; border-radius: 0.5rem;
        font-size: 0.8125rem; margin-bottom: 1rem;
    }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
    .alert-error ul { list-style: none; margin: 0; padding: 0; }
    .alert-error ul li + li { margin-top: 0.125rem; }

    /* ─── FIELDS ─── */
    .field { margin-bottom: 1.125rem; }
    .field label { display: block; font-size: 0.8125rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem; }
    .field .input-wrap {
        position: relative;
    }
    .field .input-wrap .input-icon {
        position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
        color: #9ca3af; pointer-events: none;
        display: flex; align-items: center;
    }
    .field input {
        width: 100%; padding: 0.625rem 0.875rem 0.625rem 2.25rem;
        border: 1.5px solid #d1d5db; border-radius: 0.5rem;
        font-size: 0.875rem; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        color: #212529;
    }
    .field input:focus { border-color: #2E8B57; box-shadow: 0 0 0 3px rgba(46,139,87,0.1); }
    /* ─── CHECKBOX ─── */
    .remember-row { display: flex; align-items: center; margin-bottom: 1.25rem; }
    .remember-row input[type="checkbox"] {
        width: 1rem; height: 1rem;
        border: 1.5px solid #d1d5db; border-radius: 0.25rem;
        accent-color: #2E8B57; cursor: pointer;
    }
    .remember-row label {
        margin-left: 0.5rem; font-size: 0.8125rem; color: #6b7280; cursor: pointer;
        user-select: none;
    }

    /* ─── BUTTON ─── */
    .btn-auth {
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371); color: #fff; border: none;
        padding: 0.75rem; border-radius: 0.5rem; font-size: 0.9375rem; font-weight: 600;
        cursor: pointer; transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(46,139,87,0.2);
    }
    .btn-auth:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(46,139,87,0.3); }
    .btn-auth:active { transform: translateY(0); }

    /* ─── LINKS ─── */
    .auth-links { text-align: center; margin-top: 1rem; }
    .auth-links a {
        font-size: 0.8125rem; color: #2E8B57; text-decoration: none;
        font-weight: 500; transition: color 0.2s;
    }
    .auth-links a:hover { color: #1B5E20; }

    /* ─── DIVIDER ─── */
    .auth-divider {
        margin-top: 1.5rem; padding-top: 1.5rem;
        border-top: 1px solid #e9ecef; text-align: center;
    }
    .auth-divider p { font-size: 0.8125rem; color: #6b7280; }
    .auth-divider p a { color: #2E8B57; text-decoration: none; font-weight: 600; transition: color 0.2s; }
    .auth-divider p a:hover { color: #1B5E20; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 640px) {
        .auth-hero { padding: 1.5rem 1rem 1.25rem; }
        .auth-hero h1 { font-size: 1.375rem; }
        .auth-wrap { padding: 1.25rem 1rem 3rem; }
        .auth-card { padding: 1.25rem; }
    }

    /* ─── ANIMATIONS ─── */
    @keyframes authFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<section class="auth-hero">
    <h1>Welcome Back</h1>
    <p>Sign in to your account to continue shopping</p>
</section>

<div class="auth-wrap">
    <div class="auth-card">
        {{-- Icon --}}
        <div class="auth-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13 12H3"/>
            </svg>
        </div>
        <h2>Login</h2>
        <p class="sub">Enter your credentials to access your account</p>

        {{-- Status --}}
        @if(session('status'))
            <div class="alert-box alert-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('status') }}
            </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert-box alert-error">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
            </div>

            <div class="remember-row">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Remember me</label>
            </div>

            <button type="submit" class="btn-auth">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13 12H3"/></svg>
                Sign In
            </button>

            <div class="auth-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                @endif
            </div>
        </form>

        <div class="auth-divider">
            <p>Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
        </div>
    </div>
</div>
@endsection
