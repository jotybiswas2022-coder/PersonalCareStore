@extends('frontend.layouts.app')

@section('title', 'My Messages')

@push('styles')
<style>
    .inbox-page {
        padding: 3.5rem 1.5rem 5rem;
        background: #F6FAF7;
    }
    .inbox-inner { max-width: 1060px; margin: 0 auto; }

    /* Hero */
    .inbox-hero {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
        gap: 2.25rem;
        align-items: center;
        padding: 3rem;
        border-radius: 1.75rem;
        color: #F2FBF5;
        background:
            radial-gradient(115% 90% at 100% 0%, rgba(72,199,132,0.28), transparent 55%),
            linear-gradient(155deg, #0C3D28 0%, #062718 100%);
        box-shadow: 0 35px 70px -55px rgba(5, 40, 26, 0.8);
        animation: inboxRise 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .inbox-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 62px 62px;
        -webkit-mask-image: radial-gradient(circle at 80% 15%, #000, transparent 72%);
        mask-image: radial-gradient(circle at 80% 15%, #000, transparent 72%);
        pointer-events: none;
    }
    .inbox-art {
        position: absolute;
        top: -24%;
        right: -12%;
        width: 48%;
        height: auto;
        opacity: 0.75;
        pointer-events: none;
        animation: inboxSpin 90s linear infinite;
    }
    .inbox-orb {
        position: absolute;
        bottom: -120px;
        left: -90px;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,209,102,0.2), transparent 68%);
        filter: blur(55px);
        pointer-events: none;
        animation: inboxDrift 20s ease-in-out infinite;
    }
    .inbox-copy { position: relative; z-index: 1; }
    .inbox-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #9DF3BE;
        margin-bottom: 0.875rem;
    }
    .inbox-eyebrow::before {
        content: '';
        width: 1.5rem;
        height: 1px;
        background: currentColor;
        opacity: 0.5;
    }
    .inbox-copy h1 {
        font-size: clamp(1.9rem, 3.4vw, 2.6rem);
        font-weight: 800;
        line-height: 1.06;
        letter-spacing: -0.04em;
        color: #FFFFFF;
        margin-bottom: 0.75rem;
    }
    .inbox-copy h1 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.02em;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 50%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.04em;
    }
    .inbox-copy p {
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.7);
        max-width: 26rem;
        margin-bottom: 1.25rem;
    }
    .inbox-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #FFD166;
        text-decoration: none;
        transition: gap 0.25s ease;
    }
    .inbox-link:hover { gap: 0.75rem; }
    .inbox-link svg { flex-shrink: 0; }

    /* Summary panel */
    .inbox-summary,
    .inbox-lookup {
        position: relative;
        z-index: 1;
        padding: 1.5rem;
        border-radius: 1.25rem;
        background: rgba(255,255,255,0.055);
        border: 1px solid rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }
    .summary-label {
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(226,245,232,0.5);
        margin-bottom: 0.5rem;
    }
    .summary-email {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #FFFFFF;
        word-break: break-all;
        line-height: 1.4;
    }
    .summary-email svg { color: #9DF3BE; flex-shrink: 0; }
    .summary-stats {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin: 1.125rem 0;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    .summary-stats .num {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1;
        color: #FFFFFF;
    }
    .summary-stats .lbl {
        display: block;
        margin-top: 0.3125rem;
        font-size: 0.625rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(226,245,232,0.5);
    }
    .summary-divider {
        width: 1px;
        height: 2.25rem;
        background: rgba(255,255,255,0.12);
    }
    .summary-change {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #FFD166;
        text-decoration: none;
        transition: gap 0.25s ease;
    }
    .summary-change:hover { gap: 0.5625rem; }

    /* Lookup panel */
    .lookup-head {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .lookup-ico {
        flex-shrink: 0;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        color: #9DF3BE;
    }
    .lookup-head h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #FFFFFF;
        letter-spacing: -0.01em;
        margin-bottom: 0.1875rem;
    }
    .lookup-head p {
        font-size: 0.75rem;
        line-height: 1.5;
        color: rgba(226,245,232,0.6);
    }
    .lookup-row {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.3125rem;
        border-radius: 0.875rem;
        background: rgba(0,0,0,0.18);
        border: 1px solid rgba(255,255,255,0.14);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .lookup-row:focus-within {
        border-color: rgba(157,243,190,0.55);
        box-shadow: 0 0 0 4px rgba(123,241,168,0.12);
    }
    .lookup-row input {
        flex: 1;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        color: #FFFFFF;
        font-size: 0.8125rem;
        font-family: inherit;
        padding: 0.5rem 0.625rem;
    }
    .lookup-row input::placeholder { color: rgba(226,245,232,0.4); }
    .lookup-row button {
        flex-shrink: 0;
        border: none;
        border-radius: 0.625rem;
        padding: 0.5rem 0.875rem;
        background: #FFD166;
        color: #12261B;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .lookup-row button:hover { background: #FFE08A; transform: translateY(-1px); }
    .lookup-note {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.75rem;
        font-size: 0.6875rem;
        color: rgba(226,245,232,0.45);
    }
    .lookup-note svg { flex-shrink: 0; }

    /* Success alert */
    .inbox-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-top: 1.25rem;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        font-size: 0.8125rem;
        line-height: 1.5;
        animation: inboxRise 0.5s cubic-bezier(0.22, 1, 0.36, 1) 0.1s both;
    }
    .inbox-alert svg { flex-shrink: 0; margin-top: 0.125rem; }

    /* Threads */
    .thread-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .thread-card {
        position: relative;
        padding: 1.5rem;
        border-radius: 1.25rem;
        background: #FFFFFF;
        border: 1px solid #E4EEE8;
        box-shadow: 0 18px 40px -42px rgba(9, 50, 32, 0.4);
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease, border-color 0.3s ease;
        animation: inboxRise 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .thread-card:nth-child(2) { animation-delay: 0.06s; }
    .thread-card:nth-child(3) { animation-delay: 0.12s; }
    .thread-card:nth-child(4) { animation-delay: 0.18s; }
    .thread-card:nth-child(5) { animation-delay: 0.24s; }
    .thread-card:nth-child(n+6) { animation-delay: 0.3s; }
    .thread-card:hover {
        transform: translateY(-2px);
        border-color: #CDEBD8;
        box-shadow: 0 24px 46px -36px rgba(9, 50, 32, 0.5);
    }
    .thread-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 0.875rem;
    }
    .thread-who { display: flex; align-items: center; gap: 0.625rem; min-width: 0; }
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 50%;
        font-weight: 800;
    }
    .avatar-you {
        width: 2.25rem;
        height: 2.25rem;
        font-size: 0.75rem;
        color: #17603C;
        background: linear-gradient(135deg, #EDF9F2, #CDEBD8);
        border: 1px solid #D6F0E0;
    }
    .avatar-store {
        width: 1.75rem;
        height: 1.75rem;
        font-size: 0.6875rem;
        color: #FFD166;
        background: #0E3D27;
    }
    .thread-who .who-name {
        display: block;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #10261A;
        line-height: 1.3;
    }
    .thread-who .when {
        display: block;
        font-size: 0.6875rem;
        color: #7A8B82;
    }
    .thread-status {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .thread-status.replied { background: #EAF8EF; color: #17603C; border: 1px solid #CDEBD8; }
    .thread-status.pending { background: #FFFAEB; color: #8A6100; border: 1px solid #F6E3B4; }
    .thread-message {
        font-size: 0.9375rem;
        line-height: 1.7;
        color: #3A4A41;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .thread-reply {
        margin-top: 1rem;
        padding: 1rem 1.125rem;
        border-radius: 1rem;
        background: #F3FBF6;
        border: 1px solid #DDF1E5;
    }
    .reply-head {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.4375rem;
    }
    .reply-head strong {
        font-size: 0.75rem;
        font-weight: 700;
        color: #17603C;
    }
    .reply-head .when {
        margin-left: auto;
        font-size: 0.6875rem;
        color: #7A8B82;
    }
    .reply-text {
        font-size: 0.875rem;
        line-height: 1.65;
        color: #2C3A32;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .thread-waiting {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.875rem;
        font-size: 0.75rem;
        color: #8A6100;
    }
    .thread-waiting svg { flex-shrink: 0; }

    /* Empty state */
    .inbox-empty {
        margin-top: 1.5rem;
        padding: 3rem 1.5rem;
        text-align: center;
        background: #FFFFFF;
        border: 1px dashed #D9E8DF;
        border-radius: 1.25rem;
        animation: inboxRise 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.1s both;
    }
    .inbox-empty .empty-ico {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 1rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: #2E8B57;
    }
    .inbox-empty h2 {
        font-size: 1.125rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #10261A;
        margin-bottom: 0.375rem;
    }
    .inbox-empty p {
        max-width: 24rem;
        margin: 0 auto 1.25rem;
        font-size: 0.875rem;
        line-height: 1.6;
        color: #617067;
    }
    .empty-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.125rem;
        border-radius: 0.75rem;
        background: #0E3D27;
        color: #F1FBF5;
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .empty-cta:hover { background: #15603C; transform: translateY(-1px); }

    .back-home {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.75rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #17603C;
        text-decoration: none;
        transition: gap 0.25s ease;
    }
    .back-home:hover { gap: 0.75rem; }

    @keyframes inboxRise {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes inboxSpin {
        to { transform: rotate(360deg); }
    }
    @keyframes inboxDrift {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(18px, -16px, 0) scale(1.08); }
    }

    @media (max-width: 900px) {
        .inbox-page { padding: 2.5rem 1.25rem 4rem; }
        .inbox-hero {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 2.25rem;
        }
        .inbox-copy p { max-width: 34rem; }
        .inbox-art { width: 60%; top: -18%; right: -18%; }
    }
    @media (max-width: 560px) {
        .inbox-page { padding: 1.25rem 1rem 2.75rem; }
        .inbox-hero {
            padding: 1.5rem 1.25rem;
            border-radius: 1.25rem;
            gap: 1.25rem;
        }
        .inbox-copy h1 { font-size: 1.8125rem; }
        .inbox-copy p { font-size: 0.8125rem; line-height: 1.6; margin-bottom: 1rem; }
        .inbox-eyebrow { margin-bottom: 0.625rem; }
        .inbox-art { width: 78%; top: -12%; right: -30%; opacity: 0.55; }
        .inbox-summary,
        .inbox-lookup { padding: 1rem; border-radius: 1rem; }
        .summary-stats { margin: 0.875rem 0; padding-top: 0.875rem; }
        .summary-stats .num { font-size: 1.25rem; }
        .lookup-row {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
            background: transparent;
            border: none;
            padding: 0;
        }
        .lookup-row input {
            width: 100%;
            background: rgba(0,0,0,0.18);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 0.625rem;
            padding: 0.625rem 0.75rem;
        }
        .lookup-row button { width: 100%; padding: 0.625rem; }
        .inbox-alert { margin-top: 1rem; }
        .thread-list { margin-top: 1rem; gap: 0.75rem; }
        .thread-card { padding: 1rem; border-radius: 1rem; }
        .thread-head { margin-bottom: 0.625rem; }
        .thread-message { font-size: 0.875rem; line-height: 1.65; }
        .thread-reply { padding: 0.75rem 0.875rem; margin-top: 0.75rem; }
        .reply-head .when { font-size: 0.625rem; }
        .thread-waiting { font-size: 0.6875rem; }
        .inbox-empty { margin-top: 1rem; padding: 2.25rem 1.25rem; border-radius: 1rem; }
        .back-home { margin-top: 1.25rem; }
    }
    @media (prefers-reduced-motion: reduce) {
        .inbox-hero,
        .inbox-alert,
        .thread-card,
        .inbox-empty {
            animation: none !important;
        }
        .inbox-art,
        .inbox-orb { animation: none !important; }
    }
</style>
@endpush

@section('content')
@php $repliedCount = $email ? $messages->whereNotNull('admin_reply')->count() : 0; @endphp

<div class="inbox-page">
    <div class="inbox-inner">
        <section class="inbox-hero">
            <svg class="inbox-art" viewBox="0 0 420 420" fill="none" aria-hidden="true">
                <circle cx="210" cy="210" r="200" stroke="rgba(255,255,255,0.07)"/>
                <circle cx="210" cy="210" r="152" stroke="rgba(157,243,190,0.18)" stroke-dasharray="2 8"/>
                <circle cx="210" cy="210" r="104" stroke="rgba(255,209,102,0.18)"/>
                <path d="M210 140c-30 20-44 48-44 78 30 4 58-6 78-30 18-22 20-48 14-72-18 2-34 10-48 24z" stroke="rgba(157,243,190,0.4)" stroke-width="1.4"/>
                <path d="M196 236c8-30 22-52 44-70" stroke="rgba(255,209,102,0.3)" stroke-width="1.2" stroke-linecap="round"/>
                <circle cx="354" cy="118" r="4" fill="#FFD166" opacity=".8"/>
            </svg>
            <span class="inbox-orb" aria-hidden="true"></span>

            <div class="inbox-copy">
                <span class="inbox-eyebrow">Support inbox</span>
                <h1>My <em>messages</em>.</h1>
                <p>Every question you've sent us and every reply from our care team — in one place.</p>
                <a href="{{ route('home') }}#contact" class="inbox-link">
                    Send a new message
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m0 0l-6-6m6 6l-6 6"/>
                    </svg>
                </a>
            </div>

            @if($email)
                <aside class="inbox-summary">
                    <div class="summary-label">Viewing messages for</div>
                    <div class="summary-email">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $email }}</span>
                    </div>
                    <div class="summary-stats">
                        <div>
                            <span class="num">{{ $messages->count() }}</span>
                            <span class="lbl">Messages</span>
                        </div>
                        <span class="summary-divider" aria-hidden="true"></span>
                        <div>
                            <span class="num">{{ $repliedCount }}</span>
                            <span class="lbl">Replied</span>
                        </div>
                    </div>
                    <a href="{{ route('contact.my-messages') }}" class="summary-change">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v6h6M20 20v-6h-6"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 9A8 8 0 006.3 5.3L4 10m16 4l-2.3 4.7A8 8 0 014 15"/>
                        </svg>
                        Use another email
                    </a>
                </aside>
            @else
                <aside class="inbox-lookup">
                    <div class="lookup-head">
                        <span class="lookup-ico" aria-hidden="true">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <div>
                            <h2>Find your messages</h2>
                            <p>Enter the email address you used when contacting us.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('contact.my-messages') }}">
                        <label for="lookup_email" class="sr-only" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);">Your email address</label>
                        <div class="lookup-row">
                            <input type="email" id="lookup_email" name="email" placeholder="you@example.com" required>
                            <button type="submit">View</button>
                        </div>
                    </form>
                    <p class="lookup-note">
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        We only show conversations sent from this email.
                    </p>
                </aside>
            @endif
        </section>

        @if(session('success'))
            <div class="inbox-alert" role="status">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($email)
            @if($messages->count())
                <div class="thread-list">
                    @foreach($messages as $msg)
                        <article class="thread-card">
                            <div class="thread-head">
                                <div class="thread-who">
                                    <span class="avatar avatar-you" aria-hidden="true">{{ strtoupper(mb_substr($msg->name, 0, 1)) }}</span>
                                    <div>
                                        <span class="who-name">{{ $msg->name }}</span>
                                        <span class="when">{{ $msg->created_at->format('M j, Y · g:i A') }}</span>
                                    </div>
                                </div>
                                @if($msg->admin_reply)
                                    <span class="thread-status replied">
                                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                                        </svg>
                                        Replied
                                    </span>
                                @else
                                    <span class="thread-status pending">
                                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path stroke-linecap="round" d="M12 8v4l3 2"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </div>

                            <div class="thread-message">{{ $msg->message }}</div>

                            @if($msg->admin_reply)
                                <div class="thread-reply">
                                    <div class="reply-head">
                                        <span class="avatar avatar-store" aria-hidden="true">P</span>
                                        <strong>PersonalCareStore</strong>
                                        @if($msg->replied_at)
                                            <span class="when">{{ $msg->replied_at->format('M j, Y · g:i A') }}</span>
                                        @endif
                                    </div>
                                    <div class="reply-text">{{ $msg->admin_reply }}</div>
                                </div>
                            @else
                                <div class="thread-waiting">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" d="M12 8v4l3 2"/>
                                    </svg>
                                    Awaiting reply — we'll email you as soon as we respond.
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="inbox-empty">
                    <div class="empty-ico" aria-hidden="true">
                        <svg width="21" height="21" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2>No messages yet</h2>
                    <p>We couldn't find any conversations sent from this email address.</p>
                    <a href="{{ route('home') }}#contact" class="empty-cta">
                        Send us a message
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m0 0l-6-6m6 6l-6 6"/>
                        </svg>
                    </a>
                </div>
            @endif
        @endif

        <a href="{{ route('home') }}" class="back-home">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H4m0 0l6-6m-6 6l6 6"/>
            </svg>
            Back to home
        </a>
    </div>
</div>
@endsection
