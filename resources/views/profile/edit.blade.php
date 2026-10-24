@extends('frontend.layouts.app')

@section('title', 'My Profile')

@push('styles')
<style>
    .pf-page {
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
    }

    /* ─────────────── HERO ─────────────── */
    .pf-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 3rem 1.5rem 5rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 440px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            radial-gradient(520px 320px at 0% 100%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .pf-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.032) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.032) 1px, transparent 1px);
        background-size: 76px 76px;
        -webkit-mask-image: radial-gradient(circle at 50% 38%, #000 0%, transparent 78%);
        mask-image: radial-gradient(circle at 50% 38%, #000 0%, transparent 78%);
        pointer-events: none;
    }
    .pf-hero .orb {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }
    .pf-hero .orb-1 {
        width: 420px;
        height: 420px;
        top: -200px;
        right: 2%;
        background: radial-gradient(circle, rgba(72,199,132,0.42), transparent 66%);
        animation: pfOrb 22s ease-in-out infinite;
    }
    .pf-hero .orb-2 {
        width: 320px;
        height: 320px;
        bottom: -180px;
        left: -60px;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        animation: pfOrb 28s ease-in-out infinite reverse;
    }
    .pf-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 860px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .pf-identity {
        display: flex;
        align-items: center;
        gap: 1.125rem;
        min-width: 0;
        animation: pfFadeUp 0.6s var(--ease) 0.05s both;
    }
    .pf-avatar {
        width: 4rem;
        height: 4rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1.125rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        box-shadow: 0 18px 34px -16px rgba(255,209,102,0.85), inset 0 1px 0 rgba(255,255,255,0.6);
    }
    .pf-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3125rem 0.75rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #FFE6A8;
        width: fit-content;
        margin-bottom: 0.5rem;
    }
    .pf-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #9DF3BE;
        flex-shrink: 0;
    }
    .pf-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(157,243,190,0.55);
        animation: pfPulse 2.4s ease-out infinite;
    }
    .pf-hero h1 {
        font-size: clamp(1.5rem, 3.2vw, 2.125rem);
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -0.04em;
        color: #FFFFFF;
        overflow-wrap: anywhere;
    }
    .pf-hero .pf-mail {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: rgba(226,245,232,0.68);
        overflow-wrap: anywhere;
    }
    .pf-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        animation: pfFadeUp 0.6s var(--ease) 0.16s both;
    }
    .pf-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.8125rem;
        border-radius: 9999px;
        border: 1px solid rgba(255,255,255,0.16);
        background: rgba(255,255,255,0.08);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        font-size: 0.75rem;
        font-weight: 700;
        color: rgba(233,247,238,0.88);
        white-space: nowrap;
    }
    .pf-chip svg { flex-shrink: 0; opacity: 0.8; }
    .pf-chip.is-ok {
        border-color: rgba(157,243,190,0.4);
        background: rgba(157,243,190,0.14);
        color: #D8FBE6;
    }
    .pf-chip.is-warn {
        border-color: rgba(255,209,102,0.4);
        background: rgba(255,209,102,0.14);
        color: #FFE6A8;
    }
    .pf-chip.is-warn svg { opacity: 0.95; }

    /* ─────────────── WRAP ─────────────── */
    .pf-wrap {
        position: relative;
        z-index: 1;
        max-width: 860px;
        margin: -2.75rem auto 0;
        padding: 0 1.5rem 4.5rem;
    }
    .pf-grid {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    /* ─────────────── CARD ─────────────── */
    .pf-card {
        position: relative;
        overflow: hidden;
        padding: 1.75rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: pfCardIn 0.55s var(--ease) backwards;
    }
    .pf-grid > .pf-card:nth-child(1) { animation-delay: 0.05s; }
    .pf-grid > .pf-card:nth-child(2) { animation-delay: 0.11s; }
    .pf-grid > .pf-card:nth-child(3) { animation-delay: 0.17s; }

    .pf-card-head {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        margin-bottom: 1.375rem;
    }
    .pf-card-ico {
        width: 2.5rem;
        height: 2.5rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: var(--green);
        transition: transform 0.35s var(--ease), background 0.3s var(--ease), color 0.3s var(--ease);
    }
    .pf-card:hover .pf-card-ico {
        transform: rotate(-6deg) scale(1.06);
        background: var(--green);
        color: #FFFFFF;
    }
    .pf-card-head-text { min-width: 0; flex: 1; }
    .pf-card-head h2 {
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--ink);
    }
    .pf-card-head p {
        margin-top: 0.1875rem;
        font-size: 0.8125rem;
        line-height: 1.6;
        color: var(--muted);
    }
    .pf-tag {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        border: 1px solid transparent;
        font-size: 0.6875rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .pf-tag.is-danger { background: #FEF2F2; border-color: #FBD5D5; color: #991B1B; }

    /* ─────────────── FIELDS ─────────────── */
    .pf-field { margin-bottom: 1rem; }
    .pf-field label {
        display: block;
        margin-bottom: 0.375rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.01em;
        color: #3A4A41;
    }
    .pf-field .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .pf-field .input-icon {
        position: absolute;
        left: 0.8125rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        color: #9BAF9F;
        pointer-events: none;
        transition: color 0.25s var(--ease);
    }
    .pf-field input {
        width: 100%;
        padding: 0.75rem 0.9375rem 0.75rem 2.5rem;
        border: 1px solid var(--line);
        border-radius: 0.875rem;
        background: #FBFEFC;
        font-family: inherit;
        font-size: 0.875rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease);
    }
    .pf-field input::placeholder { color: #A3B3A9; }
    .pf-field input:focus {
        background: #FFFFFF;
        border-color: #8FD3AA;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.1);
    }
    .pf-field .input-wrap:focus-within .input-icon { color: var(--green); }
    .pf-field .error {
        margin-top: 0.3125rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #DC2626;
    }

    /* ─────────────── VERIFY BOX ─────────────── */
    .verify-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.75rem;
        padding: 0.75rem 0.9375rem;
        border: 1px dashed #F5D48A;
        border-radius: 0.875rem;
        background: #FFFAEC;
        font-size: 0.8125rem;
        line-height: 1.55;
        color: #8A5A00;
    }
    .verify-box svg { flex-shrink: 0; color: #B98400; }
    .verify-box button {
        padding: 0;
        border: none;
        background: none;
        color: var(--green-deep);
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: underline;
        text-underline-offset: 2px;
        cursor: pointer;
        transition: color 0.25s var(--ease);
    }
    .verify-box button:hover { color: #0F4A2D; }
    .verify-box .sent {
        width: 100%;
        font-size: 0.75rem;
        font-weight: 700;
        color: #166534;
    }

    /* ─────────────── ACTIONS ─────────────── */
    .pf-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1.375rem;
    }
    .btn-primary {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.875rem;
        padding: 0 1.375rem;
        border: none;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #2E8B57 0%, #17603C 100%);
        color: #FFFFFF;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 14px 28px -16px rgba(23,96,60,0.9), inset 0 1px 0 rgba(255,255,255,0.18);
        transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
    }
    .btn-primary::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.22) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.7s var(--ease);
        pointer-events: none;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px -16px rgba(23,96,60,0.95), inset 0 1px 0 rgba(255,255,255,0.2);
    }
    .btn-primary:hover::after { transform: translateX(420%) rotate(12deg); }
    .btn-primary svg { flex-shrink: 0; }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.75rem;
        padding: 0 1.125rem;
        border-radius: 0.75rem;
        border: 1px solid var(--line);
        background: #FFFFFF;
        color: #3A4A41;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .btn-secondary:hover {
        background: #F3FBF6;
        border-color: #B9E2C9;
        color: var(--green-deep);
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.875rem;
        padding: 0 1.25rem;
        border: 1px solid #FBD5D5;
        border-radius: 0.875rem;
        background: #FEF2F2;
        color: #DC2626;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .btn-danger:hover {
        background: #FEE2E2;
        border-color: #FCA5A5;
        color: #B91C1C;
    }

    .success-msg {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #166534;
        animation: pfFadeUp 0.4s var(--ease) both;
    }

    /* ─────────────── DANGER CARD ─────────────── */
    .pf-card.is-danger {
        border-color: #FBD5D5;
        background: linear-gradient(180deg, #FFF8F8 0%, #FFFFFF 55%);
    }
    .pf-card.is-danger .pf-card-ico {
        background: #FEF2F2;
        border-color: #FBD5D5;
        color: #DC2626;
    }
    .pf-card.is-danger:hover .pf-card-ico {
        background: #DC2626;
        border-color: #DC2626;
        color: #FFFFFF;
    }

    /* ─────────────── MODAL ─────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 60;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        background: rgba(3,25,15,0.55);
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        width: 100%;
        max-width: 28rem;
        padding: 1.75rem;
        border-radius: 1.25rem;
        background: #FFFFFF;
        border: 1px solid var(--line);
        box-shadow: 0 40px 80px -30px rgba(3,25,15,0.6);
        animation: pfModalIn 0.25s var(--ease) both;
    }
    .modal-box h3 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #991B1B;
        margin-bottom: 0.5rem;
    }
    .modal-box > p {
        margin-bottom: 1.25rem;
        font-size: 0.8125rem;
        line-height: 1.65;
        color: var(--muted);
    }
    .modal-box .pf-field input { padding-left: 0.9375rem; }
    .modal-box .pf-field input:focus {
        border-color: #FCA5A5;
        background: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(220,38,38,0.1);
    }
    .modal-actions {
        display: flex;
        gap: 0.625rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 640px) {
        .pf-hero { padding: 2rem 1rem 4rem; }
        .pf-hero-inner { gap: 1rem; }
        .pf-avatar { width: 3.25rem; height: 3.25rem; font-size: 1.25rem; border-radius: 0.9375rem; }
        .pf-wrap { padding: 0 1rem 3.5rem; margin-top: -2.25rem; }
        .pf-grid { gap: 1rem; }
        .pf-card { padding: 1.25rem; border-radius: 1.25rem; }
        .pf-card-head { gap: 0.75rem; }
        .pf-card-head p { font-size: 0.75rem; }
        .pf-actions .btn-primary,
        .pf-actions .btn-danger { flex: 1 1 100%; }
        .modal-actions > * { flex: 1 1 auto; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes pfFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pfCardIn {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pfOrb {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(24px, -20px, 0) scale(1.08); }
    }
    @keyframes pfPulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @keyframes pfModalIn {
        from { opacity: 0; transform: translateY(10px) scale(0.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @media (prefers-reduced-motion: reduce) {
        .pf-hero .orb,
        .pf-identity,
        .pf-chips,
        .pf-card,
        .pf-eyebrow .pulse::after,
        .success-msg {
            animation: none !important;
        }
        .btn-primary::after { transition: none !important; }
    }
</style>
@endpush

@section('content')
<div class="pf-page">
    <section class="pf-hero">
        <span class="orb orb-1" aria-hidden="true"></span>
        <span class="orb orb-2" aria-hidden="true"></span>
        <div class="pf-hero-inner">
            <div class="pf-identity">
                <div class="pf-avatar" aria-hidden="true">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div>
                    <span class="pf-eyebrow">
                        <span class="pulse" aria-hidden="true"></span>
                        My account
                    </span>
                    <h1>{{ $user->name }}</h1>
                    <p class="pf-mail">{{ $user->email }}</p>
                </div>
            </div>

            <div class="pf-chips">
                <span class="pf-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Member since {{ $user->created_at->format('M Y') }}
                </span>
                <span class="pf-chip {{ $user->is_admin ? 'is-warn' : 'is-ok' }}">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $user->is_admin ? 'Administrator' : 'Customer' }}
                </span>
            </div>
        </div>
    </section>

    <div class="pf-wrap">
        <div class="pf-grid">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
