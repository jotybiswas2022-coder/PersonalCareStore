@extends('frontend.layouts.app')

@section('title', 'Verify Email')

@section('hide-footer', true)

@push('styles')
    @include('auth.partials.auth-styles')
@endpush

@section('content')
<div class="auth-page">

    {{-- ══════ FORM PANEL ONLY - MOBILE SHORT & CLEAN ══════ --}}
    <section class="auth-main" aria-labelledby="verifyHeading">
        <div class="auth-card">
            <span class="eyebrow">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/><polyline points="22 6 12 13 2 6"/></svg>
                One last step
            </span>

            <h1 id="verifyHeading">Verify your email</h1>
            <p class="sub">
                We sent a verification link to <strong>{{ Auth::user()->email }}</strong>.
                Open it to activate your account.
            </p>

            {{-- Status --}}
            @if (session('status') == 'verification-link-sent')
                <div class="alert-box alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>A fresh verification link is on its way to your inbox.</span>
                </div>
            @endif

            <div class="auth-form">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-auth">
                        Resend verification email
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-auth-ghost is-danger">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Log out
                    </button>
                </form>

                <div class="secure-note">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/><polyline points="22 6 12 13 2 6"/></svg>
                    No email yet? Check your spam or promotions folder.
                </div>
            </div>

            <div class="auth-divider">Wrong email address?</div>
            <p class="signup-row">
                <a href="{{ route('profile.edit') }}">Update it in your profile</a>
            </p>
        </div>
    </section>
</div>

@endpush('scripts')
    @include('auth.partials.auth-scripts')
@endpush