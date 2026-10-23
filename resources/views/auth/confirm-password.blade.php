@extends('frontend.layouts.app')

@section('title', 'Confirm Password')

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
            <h2>One quick check and you're <em>back</em> in.</h2>
            <p>Confirm your password to open the secure parts of your account, like order history and saved details.</p>

            <ul class="auth-features">
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    Sensitive pages stay protected
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    </span>
                    Verified before any change is saved
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    Takes only a few seconds
                </li>
            </ul>
        </div>

        <div class="auth-quote">
            <div class="quote-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <p><strong>Why am I seeing this?</strong> This step appears before protected pages so an unlocked device can't change your account settings.</p>
            <div class="who">
                <span class="avatar">S</span>
                <span>Account security &middot; this session only</span>
            </div>
        </div>
    </aside>

    {{-- ══════ FORM PANEL ══════ --}}
    <section class="auth-main" aria-labelledby="confirmHeading">
        <div class="auth-card">
            <span class="eyebrow">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Security check
            </span>

            <h1 id="confirmHeading">Confirm password</h1>
            <p class="sub">Enter your password to continue to this protected area.</p>

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
            <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                @csrf

                <div class="field">
                    <div class="label-row">
                        <label for="password">Password</label>
                    </div>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input id="password" type="password" name="password" required autofocus autocomplete="current-password"
                               placeholder="Enter your password" class="has-toggle {{ $errors->has('password') ? 'has-error' : '' }}">
                        <button type="button" class="pw-toggle" aria-label="Show password" aria-pressed="false">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    Confirm &amp; continue
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>

                <div class="secure-note">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Your password is never stored in plain text.
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    @include('auth.partials.auth-scripts')
@endpush
