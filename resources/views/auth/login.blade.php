@extends('frontend.layouts.app')

@section('title', 'Login')

@section('hide-footer', true)

@push('styles')
    @include('auth.partials.auth-styles')
@endpush

@section('content')
<div class="auth-page">

    {{-- ══════ BRAND PANEL ══════ --}}
    <aside class="auth-aside">
        <a href="{{ route('home') }}" class="auth-brand">
            <span class="mark">P</span>
            <span>PersonalCareStore</span>
        </a>

        <div class="auth-pitch">
            <h2>Welcome back. Your everyday essentials are <em>waiting</em>.</h2>
            <p>Sign in to reorder favourites, track deliveries and keep your care routine running without a hitch.</p>

            <ul class="auth-features">
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    </span>
                    Secure checkout &amp; protected payments
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </span>
                    Fast delivery across the country
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    </span>
                    100% genuine, quality-checked products
                </li>
            </ul>
        </div>

        <div class="auth-quote">
            <div class="stars">
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <p>&ldquo;Ordering is effortless and everything arrives on time. My monthly essentials never run out anymore.&rdquo;</p>
            <div class="who">
                <span class="avatar">AR</span>
                <span>Verified customer &middot; repeat buyer</span>
            </div>
        </div>
    </aside>

    {{-- ══════ FORM PANEL ══════ --}}
    <section class="auth-main" aria-labelledby="loginHeading">
        <div class="auth-card">
            <span class="eyebrow">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Account access
            </span>

            <h1 id="loginHeading">Sign in</h1>
            <p class="sub">Enter your details below to continue to your account.</p>

            {{-- Status --}}
            @if(session('status'))
                <div class="alert-box alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="alert-box alert-error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="field">
                    <div class="label-row">
                        <label for="email">Email address</label>
                    </div>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="you@example.com" class="{{ $errors->has('email') ? 'has-error' : '' }}">
                    </div>
                </div>

                <div class="field">
                    <div class="label-row">
                        <label for="password">Password</label>
                    </div>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="Enter your password" class="has-toggle {{ $errors->has('password') ? 'has-error' : '' }}">
                        <button type="button" class="pw-toggle" aria-label="Show password" aria-pressed="false">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <label class="check" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-auth">
                    Sign in
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>

                <div class="secure-note">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Your information is encrypted and never shared.
                </div>
            </form>

            <div class="auth-divider">New to PersonalCareStore?</div>
            <p class="signup-row">
                <a href="{{ route('register') }}">Create an account</a> — it only takes a minute.
            </p>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    @include('auth.partials.auth-scripts')
@endpush
