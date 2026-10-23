@extends('frontend.layouts.app')

@section('title', 'Verify Email')

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
            <h2>Just one click and your account is <em>live</em>.</h2>
            <p>Verify your email so order updates, delivery notices and password reset links always reach the right inbox.</p>

            <ul class="auth-features">
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/><polyline points="22 6 12 13 2 6"/></svg>
                    </span>
                    Order and delivery updates
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="7.5" cy="15.5" r="4.5"/><path d="M11 12L21 2M17 6l3 3M15 8l2.5 2.5"/></svg>
                    </span>
                    Password reset when you need it
                </li>
                <li>
                    <span class="fi">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    </span>
                    No marketing spam, ever
                </li>
            </ul>
        </div>

        <div class="auth-quote">
            <div class="quote-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
            </div>
            <p><strong>Link not arriving?</strong> It can take a minute, and sometimes lands in spam. Our team can resend it for you.</p>
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
@endsection
