@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

@section('hide-footer', true)

@push('styles')
    @include('auth.partials.auth-styles')
@endpush

@section('content')
    @php($s = settings())
<div class="auth-page">

    {{-- ══════ BRAND PANEL ══════ --}}
    <aside class="auth-aside">
        <a href="{{ route('home') }}" class="auth-brand">
            <span class="mark">P</span>
            <span>PersonalCareStore</span>
        </a>

        <div class="auth-pitch">
            <h2>Locked out? We'll get you back in, <em>safely</em>.</h2>
            <p>Request a one-time reset link by email, then choose a new password in a couple of minutes.</p>

            <ul class="auth-features">
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    </span>
                    Single-use links that expire quickly
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    Passwords are never emailed to you
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    </span>
                    Your orders stay safe while you reset
                </li>
            </ul>
        </div>

        <div class="auth-quote">
            <div class="quote-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
            </div>
            <p><strong>Still need help?</strong> Our support team can verify your account and help you regain access.</p>
            <div class="who">
                <span class="avatar">?</span>
                <span>
                    @if($s && $s->contact_email)
                        <a href="mailto:{{ $s->contact_email }}" style="color: #FFD166; text-decoration: none;">{{ $s->contact_email }}</a>
                    @else
                        Support &middot; replies within 24 hours
                    @endif
                </span>
            </div>
        </div>
    </aside>

    {{-- ══════ FORM PANEL ══════ --}}
    <section class="auth-main" aria-labelledby="forgotHeading">
        <div class="auth-card">
            <span class="eyebrow">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="7.5" cy="15.5" r="4.5"/><path d="M11 12L21 2M17 6l3 3M15 8l2.5 2.5"/></svg>
                Password recovery
            </span>

            <h1 id="forgotHeading">Forgot password?</h1>
            <p class="sub">Enter the email address on your account and we'll send you a reset link.</p>

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
            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
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

                <button type="submit" class="btn-auth">
                    Send reset link
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                </button>

                <div class="secure-note">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    The link expires shortly after it is sent.
                </div>
            </form>

            <div class="auth-divider">Remembered your password?</div>
            <p class="signup-row">
                <a href="{{ route('login') }}">Back to sign in</a>
            </p>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    @include('auth.partials.auth-scripts')
@endpush
