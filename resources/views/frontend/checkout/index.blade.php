@extends('frontend.layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    /* ─────────────── TOKENS / HERO ─────────────── */
    .checkout-page {
        --ink: #10261A;
        --muted: #617067;
        --green: #2E8B57;
        --green-deep: #17603C;
        --gold: #FFD166;
        --mint: #9DF3BE;
        --line: #E4EEE8;
        --surface: #FFFFFF;
        --ease: cubic-bezier(0.22, 1, 0.36, 1);

        background: #F6FAF7;
        padding-bottom: 4.5rem;
    }
    .checkout-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 3rem 1.5rem 4.25rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 420px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            radial-gradient(520px 320px at 0% 100%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .checkout-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.032) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.032) 1px, transparent 1px);
        background-size: 76px 76px;
        -webkit-mask-image: radial-gradient(circle at 50% 40%, #000 0%, transparent 78%);
        mask-image: radial-gradient(circle at 50% 40%, #000 0%, transparent 78%);
        pointer-events: none;
    }
    .checkout-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .checkout-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3125rem 0.75rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #FFE6A8;
    }
    .checkout-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #7BF1A8;
        flex-shrink: 0;
    }
    .checkout-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(123,241,168,0.55);
        animation: chkPulse 2.4s ease-out infinite;
    }
    .checkout-hero h1 {
        font-size: clamp(1.875rem, 3.4vw, 2.75rem);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.045em;
        color: #FFFFFF;
    }
    .checkout-hero h1 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.02em;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 45%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.06em;
    }
    .checkout-hero p {
        max-width: 32rem;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.66);
    }

    /* ─────────────── PROGRESS STEPS ─────────────── */
    .checkout-steps {
        position: relative;
        z-index: 2;
        max-width: 30rem;
        margin: -2.125rem auto 0;
        padding: 0.875rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 9999px;
        box-shadow: 0 30px 60px -40px rgba(10,60,38,0.55);
    }
    .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #93A39A;
        white-space: nowrap;
    }
    .step .circle {
        width: 1.875rem;
        height: 1.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid var(--line);
        background: #F6FAF7;
        color: #93A39A;
        font-size: 0.6875rem;
        font-weight: 800;
        transition: background 0.3s var(--ease), border-color 0.3s var(--ease), color 0.3s var(--ease);
    }
    .step.active { color: var(--ink); }
    .step.active .circle {
        background: linear-gradient(135deg, #FFE08A, #FFD166 55%, #F5C14E);
        border-color: transparent;
        color: #12261B;
        box-shadow: 0 8px 18px -10px rgba(255,209,102,0.95);
    }
    .step.done { color: var(--green-deep); }
    .step.done .circle {
        background: #EDF9F2;
        border-color: #D6F0E0;
        color: #166534;
    }
    .step-line {
        width: 2.5rem;
        height: 2px;
        margin: 0 0.625rem;
        border-radius: 2px;
        background: #E9F0EC;
    }
    .step-line.done { background: linear-gradient(90deg, #7BCB9B, #B9E2C9); }

    /* ─────────────── ALERT ─────────────── */
    .checkout-alert-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 0;
    }
    .checkout-alert {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8125rem 0.9375rem;
        border-radius: 0.875rem;
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        font-size: 0.875rem;
        line-height: 1.5;
        color: #B91C1C;
        animation: chkIn 0.4s var(--ease);
    }
    .checkout-alert svg { flex-shrink: 0; }

    /* ─────────────── LAYOUT ─────────────── */
    .checkout-layout {
        max-width: 1280px;
        margin: 1.75rem auto 0;
        padding: 0 1.5rem;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 2rem;
        align-items: start;
    }

    /* ─────────────── FORM CARD ─────────────── */
    .form-section {
        padding: 1.75rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: chkIn 0.5s var(--ease) backwards;
    }
    .form-section + .form-section { margin-top: 1.25rem; }
    .form-section .section-icon {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--line);
    }
    .form-section .section-icon .ic {
        width: 2.25rem;
        height: 2.25rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.625rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: var(--green);
    }
    .form-section h2 {
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        color: var(--ink);
    }
    .form-section .section-icon p {
        margin-top: 0.125rem;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .form-grid .full-width {
        grid-column: span 2;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group label {
        margin-bottom: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #374151;
    }
    .form-group label .required {
        color: #E11D48;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        height: 3rem;
        padding: 0 0.9375rem;
        border: 1px solid var(--line);
        border-radius: 0.75rem;
        background: var(--surface);
        font-family: inherit;
        font-size: 0.9375rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease);
    }
    .form-group input::placeholder { color: #A9BBAF; }
    .form-group input:hover,
    .form-group select:hover { border-color: #CFD8DD; }
    .form-group input:focus,
    .form-group select:focus {
        border-color: #7BCB9B;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.10);
    }
    .form-group input.error {
        border-color: #F3B4B4;
        background: #FFFAFA;
    }
    .form-group input.error:focus {
        border-color: #EF4444;
        box-shadow: 0 0 0 4px rgba(239,68,68,0.10);
    }
    .form-error {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.375rem;
        font-size: 0.75rem;
        color: #B91C1C;
    }
    .form-error svg { flex-shrink: 0; }

    /* ─────────────── PLACE ORDER ─────────────── */
    .place-order-section {
        margin-top: 1.5rem;
    }
    .place-order-btn {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 3.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        border: none;
        border-radius: 0.875rem;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        cursor: pointer;
        box-shadow: 0 14px 34px -14px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .place-order-btn::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.75) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.75s var(--ease);
        pointer-events: none;
    }
    .place-order-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .place-order-btn:hover::after { transform: translateX(420%) rotate(12deg); }
    .place-order-btn:active { transform: translateY(0); }
    .place-order-btn svg { transition: transform 0.3s var(--ease); }
    .place-order-btn:hover svg { transform: translateX(3px); }

    .trust-badges {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    .trust-badges span {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.4375rem 0.75rem;
        border-radius: 9999px;
        background: var(--surface);
        border: 1px solid var(--line);
        font-size: 0.6875rem;
        font-weight: 600;
        color: #374151;
    }
    .trust-badges svg { color: var(--green); flex-shrink: 0; }

    /* ─────────────── ORDER SUMMARY ─────────────── */
    .summary-card {
        position: sticky;
        top: 5.5rem;
        padding: 1.5rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 34px 64px -52px rgba(10,60,38,0.55);
        animation: chkIn 0.55s var(--ease) 0.1s backwards;
    }
    .summary-card .summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--line);
    }
    .summary-card .summary-header h2 {
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        color: var(--ink);
    }
    .summary-card .summary-header .count {
        padding: 0.1875rem 0.5625rem;
        border-radius: 9999px;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: #166534;
        font-size: 0.6875rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .summary-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #F1F7F3;
    }
    .summary-item:last-of-type { border-bottom: none; padding-bottom: 0.25rem; }
    .summary-item .thumb {
        width: 3.5rem;
        height: 3.5rem;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 0.75rem;
        border: 1px solid var(--line);
        background: radial-gradient(circle at 50% 30%, #FFFFFF 0%, #EAF9EF 60%, #D8F2E2 100%);
    }
    .summary-item .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .summary-item .thumb .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #C3D4C9;
    }
    .summary-item .info {
        flex: 1;
        min-width: 0;
    }
    .summary-item .info .name {
        font-size: 0.8125rem;
        font-weight: 700;
        line-height: 1.35;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .summary-item .info .qty {
        margin-top: 0.1875rem;
        font-size: 0.75rem;
        color: var(--muted);
    }
    .summary-item .info .discount-note {
        display: inline-block;
        margin-top: 0.25rem;
        padding: 0.0625rem 0.4375rem;
        border-radius: 9999px;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        font-size: 0.625rem;
        font-weight: 600;
        color: #166534;
    }
    .summary-item .total {
        font-size: 0.8125rem;
        font-weight: 800;
        color: var(--ink);
        white-space: nowrap;
    }

    /* Totals */
    .summary-totals { margin-top: 0.5rem; }
    .summary-totals .row {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.4375rem 0;
        font-size: 0.8125rem;
    }
    .summary-totals .row .lbl { color: var(--muted); }
    .summary-totals .row .val { font-weight: 600; color: var(--ink); }
    .summary-totals .divider {
        border: none;
        border-top: 1px solid var(--line);
        margin: 0.75rem 0;
    }
    .summary-totals .total-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.75rem 0.875rem;
        border-radius: 0.875rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
    }
    .summary-totals .total-row .lbl {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--ink);
    }
    .summary-totals .total-row .val {
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--green-deep);
    }
    .summary-secure {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        margin-top: 1rem;
        padding-top: 0.875rem;
        border-top: 1px solid var(--line);
        font-size: 0.6875rem;
        color: #93A39A;
    }
    .summary-secure svg { color: var(--green); flex-shrink: 0; }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1024px) {
        .checkout-layout { grid-template-columns: minmax(0, 1fr) 330px; gap: 1.5rem; }
    }
    @media (max-width: 900px) {
        .checkout-layout { grid-template-columns: 1fr; }
        .summary-card { position: static; }
    }
    @media (max-width: 640px) {
        .checkout-hero { padding: 2.25rem 1.25rem 3.5rem; }
        .checkout-hero p { font-size: 0.875rem; }
        .checkout-steps {
            margin: -1.75rem 1rem 0;
            max-width: none;
            padding: 0.75rem 1rem;
        }
        .step .label { display: none; }
        .step.active .label { display: inline; }
        .step .circle { width: 1.625rem; height: 1.625rem; font-size: 0.625rem; }
        .step-line { width: 1.5rem; margin: 0 0.375rem; }
        .checkout-alert-wrap { padding: 1.25rem 1rem 0; }
        .checkout-layout { padding: 0 1rem; margin-top: 1.25rem; }
        .form-section { padding: 1.25rem; border-radius: 1.25rem; }
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .full-width { grid-column: span 1; }
        .summary-card { padding: 1.25rem; border-radius: 1.25rem; }
    }

    /* ─────────────── ANIMATION ─────────────── */
    @keyframes chkIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes chkPulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @media (prefers-reduced-motion: reduce) {
        .checkout-eyebrow .pulse::after,
        .form-section,
        .summary-card,
        .checkout-alert { animation: none !important; }
        .place-order-btn,
        .place-order-btn::after,
        .place-order-btn svg,
        .form-group input,
        .form-group select,
        .step .circle { transition: none !important; }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
{{-- Hero --}}
<section class="checkout-hero">
    <div class="checkout-hero-inner">
        <span class="checkout-eyebrow">
            <span class="pulse" aria-hidden="true"></span>
            Secure checkout
        </span>
        <h1>Complete your <em>order</em></h1>
        <p>Fill in your delivery details and we'll take care of the rest.</p>
    </div>
</section>

{{-- Progress Steps --}}
<div class="checkout-steps">
    <div class="step done">
        <span class="circle">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
        </span>
        <span class="label">Cart</span>
    </div>
    <div class="step-line done"></div>
    <div class="step active">
        <span class="circle">2</span>
        <span class="label">Details</span>
    </div>
    <div class="step-line"></div>
    <div class="step">
        <span class="circle">3</span>
        <span class="label">Confirm</span>
    </div>
</div>

{{-- Error message --}}
@if(session('error'))
    <div class="checkout-alert-wrap">
        <div class="checkout-alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    </div>
@endif

{{-- Main Layout --}}
<div class="checkout-layout">
    {{-- Left: Form --}}
    <div>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            {{-- Shipping Section --}}
            <div class="form-section">
                <div class="section-icon">
                    <span class="ic">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </span>
                    <div>
                        <h2>Shipping information</h2>
                        <p>Where should we deliver your order?</p>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="{{ $errors->has('first_name') ? 'error' : '' }}">
                        @error('first_name')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="{{ $errors->has('last_name') ? 'error' : '' }}">
                        @error('last_name')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="{{ $errors->has('email') ? 'error' : '' }}">
                        @error('email')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone <span class="required">*</span></label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="{{ $errors->has('phone') ? 'error' : '' }}">
                        @error('phone')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="address_line1">Address Line 1 <span class="required">*</span></label>
                        <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" required class="{{ $errors->has('address_line1') ? 'error' : '' }}">
                        @error('address_line1')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="address_line2">Address Line 2</label>
                        <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2') }}" class="{{ $errors->has('address_line2') ? 'error' : '' }}">
                        @error('address_line2')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="city">City / Division <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required class="{{ $errors->has('city') ? 'error' : '' }}">
                        @error('city')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="state">State / Province</label>
                        <input type="text" name="state" id="state" value="{{ old('state') }}" class="{{ $errors->has('state') ? 'error' : '' }}">
                        @error('state')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code <span class="required">*</span></label>
                        <input type="hidden" name="country" value="Bangladesh">
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required class="{{ $errors->has('postal_code') ? 'error' : '' }}">
                        @error('postal_code')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Place Order --}}
            <div class="place-order-section">
                <button type="submit" class="place-order-btn">
                    Place Order
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
                <div class="trust-badges">
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Secure Checkout
                    </span>
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        SSL Encrypted
                    </span>
                </div>
            </div>
        </form>
    </div>

    {{-- Right: Order Summary --}}
    <div class="summary-card">
        <div class="summary-header">
            <h2>Order Summary</h2>
            <span class="count">{{ $cartItems->count() }} item{{ $cartItems->count() !== 1 ? 's' : '' }}</span>
        </div>

        @foreach($cartItems as $item)
            <div class="summary-item">
                <div class="thumb">
                    @if($item->product->images && count($item->product->images) > 0)
                        <img src="{{ $item->product->image_urls[0] }}" alt="{{ $item->product->name }}">
                    @else
                        <div class="no-img">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="info">
                    <p class="name">{{ $item->product->name }}</p>
                    <p class="qty">Qty: {{ $item->quantity }}</p>
                    @if($item->product->discount_name && $item->product->discount_percent)
                        <p class="discount-note">{{ $item->product->discount_name }} ({{ $item->product->discount_percent }}% OFF)</p>
                    @elseif($item->product->discount_name)
                        <p class="discount-note">{{ $item->product->discount_name }}</p>
                    @endif
                </div>
                <span class="total">{{ currencyFormat($item->product->final_price * $item->quantity) }}</span>
            </div>
        @endforeach

        <div class="summary-totals">
            <div class="row">
                <span class="lbl">Subtotal</span>
                <span class="val">{{ currencyFormat($subtotal) }}</span>
            </div>
            <div class="row">
                <span class="lbl">Shipping ({{ $deliveryArea === 'inside' ? 'Inside Khulna' : 'Outside Khulna' }})</span>
                <span class="val">{{ currencyFormat($deliveryCharge) }}</span>
            </div>
            <div class="row">
                <span class="lbl">VAT ({{ $vatPercent }}%)</span>
                <span class="val">{{ currencyFormat($vatAmount) }}</span>
            </div>
            <hr class="divider">
            <div class="total-row">
                <span class="lbl">Total</span>
                <span class="val">{{ currencyFormat($total) }}</span>
            </div>
        </div>

        <div class="summary-secure">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
            Encrypted checkout &middot; your details stay private
        </div>
    </div>
</div>
</div>
@endsection
