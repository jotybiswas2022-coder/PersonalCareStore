@extends('frontend.layouts.app')

@section('title', 'Reset Password')

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
            <h2>Choose a new password and get back to <em>shopping</em>.</h2>
            <p>Pick something strong and unique to keep your account and order history protected.</p>

            <ul class="auth-features">
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    Use at least 8 characters
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    </span>
                    Stored securely and never shared
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    </span>
                    Your saved details stay untouched
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
    <section class="auth-main" aria-labelledby="resetHeading">
        <div class="auth-card">
            <span class="eyebrow">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                New password
            </span>

            <h1 id="resetHeading">Reset password</h1>
            <p class="sub">Enter your email and choose a new password for your account.</p>

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
            <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="field">
                    <div class="label-row">
                        <label for="email">Email address</label>
                    </div>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                               placeholder="you@example.com" class="{{ $errors->has('email') ? 'has-error' : '' }}">
                    </div>
                </div>

                <div class="field">
                    <div class="label-row">
                        <label for="password">New password</label>
                    </div>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               placeholder="At least 8 characters" class="has-toggle {{ $errors->has('password') ? 'has-error' : '' }}">
                        <button type="button" class="pw-toggle" aria-label="Show password" aria-pressed="false">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                    <p class="pass-hint">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Must be at least 8 characters
                    </p>
                </div>

                <div class="field">
                    <div class="label-row">
                        <label for="password_confirmation">Confirm new password</label>
                    </div>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/><polyline points="9 14 11 16 15 12"/></svg>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               placeholder="Re-enter your password" class="has-toggle">
                        <button type="button" class="pw-toggle" aria-label="Show password" aria-pressed="false">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    Reset password
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>

                <div class="secure-note">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Your information is encrypted and never shared.
                </div>
            </form>

            <div class="auth-divider">All done?</div>
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
