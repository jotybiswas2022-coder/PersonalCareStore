@extends('frontend.layouts.app')

@section('title', $order->status === 'cancelled' ? 'Order Cancelled' : (($order->payment_status === 'paid' || $order->proof_image) ? 'Order Confirmed' : 'Payment Required'))

@push('styles')
<style>
    /* ─────────────── TOKENS ─────────────── */
    .success-page {
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

    /* ─────────────── HERO ─────────────── */
    .success-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 3.25rem 1.5rem 4.5rem;
        text-align: center;
        color: #F2FBF5;
        background:
            radial-gradient(900px 420px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            radial-gradient(520px 320px at 0% 100%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .success-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.032) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.032) 1px, transparent 1px);
        background-size: 76px 76px;
        -webkit-mask-image: radial-gradient(circle at 50% 36%, #000 0%, transparent 78%);
        mask-image: radial-gradient(circle at 50% 36%, #000 0%, transparent 78%);
        pointer-events: none;
    }
    .success-hero .orb {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }
    .success-hero .orb-1 {
        width: 420px;
        height: 420px;
        top: -190px;
        right: 2%;
        background: radial-gradient(circle, rgba(72,199,132,0.45), transparent 66%);
        animation: sOrb 22s ease-in-out infinite;
    }
    .success-hero .orb-2 {
        width: 320px;
        height: 320px;
        bottom: -170px;
        left: -60px;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        animation: sOrb 28s ease-in-out infinite reverse;
    }
    .success-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 42rem;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .success-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.875rem;
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
        animation: sFadeUp 0.6s var(--ease) 0.05s both;
    }
    .success-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #7BF1A8;
        flex-shrink: 0;
    }
    .success-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(123,241,168,0.55);
        animation: sPulse 2.4s ease-out infinite;
    }
    .success-eyebrow.is-pending { color: #FFE6A8; }
    .success-eyebrow.is-pending .pulse { background: #FFD166; }
    .success-eyebrow.is-pending .pulse::after { border-color: rgba(255,209,102,0.55); }
    .success-eyebrow.is-cancelled { color: #FCA5A5; }
    .success-eyebrow.is-cancelled .pulse { background: #F87171; }
    .success-eyebrow.is-cancelled .pulse::after { border-color: rgba(248,113,113,0.55); }

    /* Animated mark */
    .success-mark {
        position: relative;
        width: 6.25rem;
        height: 6.25rem;
        margin: 1.5rem auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        animation: sMarkIn 0.85s var(--ease) 0.16s forwards;
    }
    .success-mark .mark-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 1px solid rgba(157,243,190,0.4);
        animation: sRing 3.4s ease-out infinite;
    }
    .success-mark .mark-ring.r2 { animation-delay: 1.7s; }
    .success-mark .mark-core {
        position: relative;
        z-index: 2;
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(140deg, #3CB371 0%, #2E8B57 55%, #17603C 100%);
        color: #ECFFF4;
        box-shadow:
            0 22px 45px -18px rgba(46,139,87,0.9),
            inset 0 1px 0 rgba(255,255,255,0.35),
            0 0 0 8px rgba(255,255,255,0.04);
    }
    .success-mark .mark-core svg { width: 2.25rem; height: 2.25rem; }
    .success-mark .check-path {
        stroke-dasharray: 42;
        stroke-dashoffset: 42;
        animation: sDraw 0.55s var(--ease) 0.62s forwards;
    }
    .success-mark .spark {
        position: absolute;
        width: 0.375rem;
        height: 0.375rem;
        border-radius: 50%;
        background: #FFD166;
        opacity: 0;
        animation: sTwinkle 3.6s ease-in-out infinite;
    }
    .success-mark .spark.s1 { top: 6%; right: 12%; animation-delay: 0.5s; }
    .success-mark .spark.s2 { bottom: 10%; left: 6%; background: #9DF3BE; animation-delay: 1.7s; }
    .success-mark .spark.s3 { top: 40%; left: -4%; width: 0.25rem; height: 0.25rem; animation-delay: 2.6s; }
    .success-mark .spark.s4 { bottom: 2%; right: 18%; width: 0.25rem; height: 0.25rem; background: #9DF3BE; animation-delay: 3.1s; }

    .success-mark.is-pending .mark-ring { border-color: rgba(255,209,102,0.42); }
    .success-mark.is-pending .mark-core {
        background: linear-gradient(140deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        box-shadow:
            0 22px 45px -18px rgba(255,209,102,0.85),
            inset 0 1px 0 rgba(255,255,255,0.6),
            0 0 0 8px rgba(255,255,255,0.04);
    }
    .success-mark.is-cancelled .mark-ring { border-color: rgba(248,113,113,0.42); }
    .success-mark.is-cancelled .mark-core {
        background: linear-gradient(140deg, #F87171 0%, #DC2626 55%, #991B1B 100%);
        color: #FFF5F5;
        box-shadow:
            0 22px 45px -18px rgba(220,38,38,0.8),
            inset 0 1px 0 rgba(255,255,255,0.25),
            0 0 0 8px rgba(255,255,255,0.04);
    }

    .success-hero h1 {
        font-size: clamp(2rem, 4vw, 2.875rem);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.045em;
        color: #FFFFFF;
        animation: sFadeUp 0.6s var(--ease) 0.28s both;
    }
    .success-hero h1 em {
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
    .success-hero h1 em.is-pending {
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 60%, #FFE6A8 100%);
        -webkit-background-clip: text;
        background-clip: text;
    }
    .success-hero h1 em.is-cancelled {
        background: linear-gradient(100deg, #FECACA 0%, #FCA5A5 55%, #F87171 100%);
        -webkit-background-clip: text;
        background-clip: text;
    }
    .success-hero p {
        max-width: 34rem;
        margin: 0.75rem auto 0;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.68);
        animation: sFadeUp 0.6s var(--ease) 0.38s both;
    }

    /* Order chip */
    .order-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        margin-top: 1.5rem;
        padding: 0.4375rem 0.5rem 0.4375rem 1rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        animation: sFadeUp 0.6s var(--ease) 0.48s both;
    }
    .order-chip .chip-label {
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(226,245,232,0.55);
    }
    .order-chip strong {
        font-size: 0.875rem;
        font-weight: 700;
        letter-spacing: 0.015em;
        color: #FFFFFF;
        white-space: nowrap;
    }
    .order-chip .copy-btn {
        width: 2rem;
        height: 2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.08);
        color: #9DF3BE;
        cursor: pointer;
        transition: background 0.25s var(--ease), color 0.25s var(--ease), transform 0.25s var(--ease);
    }
    .order-chip .copy-btn:hover {
        background: rgba(123,241,168,0.16);
        transform: translateY(-1px);
    }
    .order-chip .copy-btn.is-copied {
        background: rgba(123,241,168,0.22);
        color: #FFFFFF;
    }

    /* ─────────────── PROGRESS STEPS ─────────────── */
    .success-steps {
        position: relative;
        z-index: 2;
        max-width: 38rem;
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
    .success-steps .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #93A39A;
        white-space: nowrap;
    }
    .success-steps .step .circle {
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
        flex-shrink: 0;
        transition: background 0.3s var(--ease), border-color 0.3s var(--ease), color 0.3s var(--ease);
    }
    .success-steps .step.active { color: var(--ink); }
    .success-steps .step.active .circle {
        background: linear-gradient(135deg, #FFE08A, #FFD166 55%, #F5C14E);
        border-color: transparent;
        color: #12261B;
        box-shadow: 0 8px 18px -10px rgba(255,209,102,0.95);
    }
    .success-steps .step.done { color: var(--green-deep); }
    .success-steps .step.done .circle {
        background: #EDF9F2;
        border-color: #D6F0E0;
        color: #166534;
    }
    .success-steps .step.cancelled { color: #B91C1C; }
    .success-steps .step.cancelled .circle {
        background: #FEF2F2;
        border-color: #FBD5D5;
        color: #DC2626;
    }
    .success-steps .step-line {
        width: 2.5rem;
        height: 2px;
        margin: 0 0.625rem;
        border-radius: 2px;
        background: #E9F0EC;
    }
    .success-steps .step-line.done { background: linear-gradient(90deg, #7BCB9B, #B9E2C9); }

    /* ─────────────── ALERTS ─────────────── */
    .session-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.875rem 1rem;
        margin-bottom: 1.25rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        line-height: 1.55;
        animation: sIn 0.5s var(--ease) backwards;
    }
    .session-alert svg { flex-shrink: 0; margin-top: 0.125rem; }
    .session-alert.is-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
    }
    .session-alert.is-error {
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #B91C1C;
    }

    /* ─────────────── LAYOUT ─────────────── */
    .success-layout {
        max-width: 1180px;
        margin: 1.75rem auto 0;
        padding: 0 1.5rem;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 2rem;
        align-items: start;
    }
    .success-main,
    .success-aside {
        min-width: 0;
    }
    .success-aside {
        position: sticky;
        top: 5.5rem;
        align-self: start;
        height: fit-content;
    }

    /* ─────────────── PANELS ─────────────── */
    .panel {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        overflow: hidden;
        animation: sIn 0.55s var(--ease) var(--d, 0s) backwards;
    }
    .panel + .panel { margin-top: 1.25rem; }
    .panel-head {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1.375rem 1.5rem;
        border-bottom: 1px solid var(--line);
    }
    .panel-head .ic {
        width: 2.375rem;
        height: 2.375rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: var(--green);
    }
    .panel-head h2 {
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        color: var(--ink);
    }
    .panel-head p {
        margin-top: 0.125rem;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .panel-body { padding: 1.5rem; }

    /* ─────────────── ITEMS ─────────────── */
    .item-row {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid #F1F7F3;
    }
    .item-row:first-child { padding-top: 0; }
    .item-row:last-child { padding-bottom: 0; border-bottom: none; }
    .item-row .thumb {
        width: 4rem;
        height: 4rem;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 0.875rem;
        border: 1px solid var(--line);
        background: radial-gradient(circle at 50% 30%, #FFFFFF 0%, #EAF9EF 60%, #D8F2E2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .item-row .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .item-row .thumb .no-img { color: #B9CFC1; }
    .item-row .item-info { flex: 1; min-width: 0; }
    .item-row .item-name {
        font-size: 0.9375rem;
        font-weight: 700;
        line-height: 1.35;
        color: var(--ink);
    }
    .item-row .item-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.375rem;
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: var(--muted);
    }
    .item-row .qty-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.0625rem 0.5rem;
        border-radius: 9999px;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        font-size: 0.6875rem;
        font-weight: 700;
        color: #166534;
    }
    .item-row .item-subtotal {
        font-size: 0.9375rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--ink);
        white-space: nowrap;
    }

    /* ─────────────── SHIPPING / INFO ─────────────── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem 1.25rem;
    }
    .info-grid .full { grid-column: 1 / -1; }
    .info-label {
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #93A39A;
        margin-bottom: 0.25rem;
    }
    .info-value {
        font-size: 0.9375rem;
        line-height: 1.6;
        color: #374151;
    }
    .info-value strong {
        font-weight: 700;
        color: var(--ink);
    }
    .info-value a {
        color: var(--green-deep);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s var(--ease);
    }
    .info-value a:hover { color: var(--green); text-decoration: underline; text-underline-offset: 3px; }

    /* ─────────────── PAYMENT DETAILS ─────────────── */
    .bank-card {
        padding: 1.125rem 1.25rem;
        border: 1px solid var(--line);
        border-radius: 1rem;
        background: linear-gradient(160deg, #FBFEFC 0%, #F5FBF7 100%);
    }
    .bank-card + .bank-card { margin-top: 0.875rem; }
    .bank-card .bank-head {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--line);
        font-size: 0.8125rem;
        font-weight: 800;
        letter-spacing: 0.02em;
        color: var(--ink);
    }
    .bank-card .bank-head svg { color: var(--green); flex-shrink: 0; }
    .bank-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.4375rem 0;
        font-size: 0.8125rem;
    }
    .bank-row + .bank-row { border-top: 1px dashed #E7F0EA; }
    .bank-row .lbl { color: var(--muted); flex-shrink: 0; }
    .bank-row .val {
        font-weight: 700;
        color: var(--ink);
        text-align: right;
        word-break: break-word;
    }
    .bank-row .val.with-copy {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    .mini-copy {
        width: 1.625rem;
        height: 1.625rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: 1px solid var(--line);
        background: #FFFFFF;
        color: #93A39A;
        cursor: pointer;
        transition: color 0.2s var(--ease), border-color 0.2s var(--ease), background 0.2s var(--ease);
    }
    .mini-copy:hover { color: var(--green); border-color: #B9E2C9; background: #F0FDF4; }
    .mini-copy.is-copied { color: #166534; border-color: #BBF7D0; background: #F0FDF4; }
    .bank-instructions {
        margin-top: 0.875rem;
        padding: 0.75rem 0.9375rem;
        border-radius: 0.75rem;
        background: #FFFDF6;
        border: 1px solid #FBEBC0;
        border-left: 3px solid var(--gold);
        font-size: 0.8125rem;
        line-height: 1.65;
        color: #6B5A2E;
    }

    /* ─────────────── PROOF ─────────────── */
    .proof-submitted {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        border-radius: 0.875rem;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        font-size: 0.875rem;
        line-height: 1.6;
    }
    .proof-submitted svg { flex-shrink: 0; margin-top: 0.125rem; }
    .proof-submitted strong { font-weight: 800; }
    .proof-cancelled {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        border-radius: 0.875rem;
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #991B1B;
        font-size: 0.875rem;
        line-height: 1.6;
    }
    .proof-cancelled svg { flex-shrink: 0; margin-top: 0.125rem; color: #DC2626; }
    .proof-preview {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--line);
    }
    .proof-preview .label {
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #93A39A;
        margin-bottom: 0.625rem;
    }
    .proof-preview .shot {
        position: relative;
        display: inline-block;
        overflow: hidden;
        border-radius: 1rem;
        border: 1px solid var(--line);
        box-shadow: 0 18px 36px -28px rgba(10,60,38,0.6);
    }
    .proof-preview img {
        display: block;
        width: 12rem;
        height: 12rem;
        object-fit: cover;
        transition: transform 0.5s var(--ease);
    }
    .proof-preview .shot:hover img { transform: scale(1.05); }

    .proof-form .form-group { margin-bottom: 1.25rem; }
    .proof-form .form-group:last-of-type { margin-bottom: 1.5rem; }
    .proof-form label {
        display: block;
        margin-bottom: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #374151;
    }
    .proof-form label .required { color: #E11D48; }
    .proof-form input[type="text"],
    .proof-form input[type="file"] {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 0.75rem;
        background: var(--surface);
        font-family: inherit;
        font-size: 0.9375rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease);
    }
    .proof-form input[type="text"] {
        height: 3rem;
        padding: 0 0.9375rem;
    }
    .proof-form input[type="text"]::placeholder { color: #A9BBAF; }
    .proof-form input[type="file"] {
        padding: 0.5rem 0.625rem;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .proof-form input[type="file"]::file-selector-button {
        margin-right: 0.75rem;
        padding: 0.5rem 0.875rem;
        border: 1px solid #D6F0E0;
        border-radius: 0.5rem;
        background: #EDF9F2;
        color: #166534;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s var(--ease);
    }
    .proof-form input[type="file"]::file-selector-button:hover { background: #D6F5E2; }
    .proof-form input:hover { border-color: #CFD8DD; }
    .proof-form input:focus {
        border-color: #7BCB9B;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.10);
    }
    .proof-form .file-hint {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.4375rem;
        font-size: 0.75rem;
        color: #93A39A;
    }
    .proof-form .file-hint svg { flex-shrink: 0; color: var(--green); }
    .form-error {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.375rem;
        font-size: 0.75rem;
        color: #B91C1C;
    }
    .form-error svg { flex-shrink: 0; }

    /* ─────────────── BUTTONS ─────────────── */
    .s-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 3.125rem;
        padding: 0 1.5rem;
        border: none;
        border-radius: 0.875rem;
        font-family: inherit;
        font-size: 0.9375rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease), background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .s-btn-gold {
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        box-shadow: 0 14px 34px -14px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
    }
    .s-btn-gold::after {
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
    .s-btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .s-btn-gold:hover::after { transform: translateX(420%) rotate(12deg); }
    .s-btn-gold svg { transition: transform 0.3s var(--ease); }
    .s-btn-gold:hover svg { transform: translateX(3px); }
    .s-btn-green {
        background: linear-gradient(135deg, #2E8B57 0%, #17603C 100%);
        color: #FFFFFF;
        box-shadow: 0 14px 30px -14px rgba(23,96,60,0.85), inset 0 1px 0 rgba(255,255,255,0.18);
    }
    .s-btn-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 38px -16px rgba(23,96,60,0.95), inset 0 1px 0 rgba(255,255,255,0.2);
    }
    .s-btn-outline {
        background: #FFFFFF;
        border: 1px solid var(--line);
        color: var(--green-deep);
    }
    .s-btn-outline:hover {
        border-color: #B9E2C9;
        background: #F3FBF6;
        transform: translateY(-1px);
    }
    .s-btn:active { transform: translateY(0); }

    /* ─────────────── SUMMARY ASIDE ─────────────── */
    .success-main,
    .success-aside { min-width: 0; }
    .summary-card {
        position: static;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 34px 64px -52px rgba(10,60,38,0.55);
        overflow: hidden;
        animation: sIn 0.55s var(--ease) 0.1s backwards;
    }
    .summary-head {
        padding: 1.5rem 1.5rem 1.25rem;
        border-bottom: 1px solid var(--line);
        background: linear-gradient(160deg, #FBFEFC 0%, #F5FBF7 100%);
    }
    .summary-head .summary-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .summary-head h2 {
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        color: var(--ink);
    }
    .summary-head .count {
        padding: 0.1875rem 0.5625rem;
        border-radius: 9999px;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: #166534;
        font-size: 0.6875rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .summary-meta { display: flex; flex-direction: column; gap: 0.625rem; }
    .summary-meta .meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        font-size: 0.8125rem;
    }
    .summary-meta .meta-row .lbl { color: var(--muted); }
    .summary-meta .meta-row .val {
        font-weight: 700;
        color: var(--ink);
        text-align: right;
        word-break: break-word;
    }
    .summary-meta .meta-row .val.order-num {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 700;
        line-height: 1.6;
        white-space: nowrap;
    }
    .status-badge.is-paid {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
    }
    .status-badge.is-pending {
        background: #FFF8E6;
        border: 1px solid #FBE7B5;
        color: #8A5A00;
    }
    .status-badge.is-cancelled {
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #991B1B;
    }
    .status-badge.is-neutral {
        background: #F3F4F6;
        border: 1px solid #E5E7EB;
        color: #374151;
    }

    .summary-totals { padding: 1.25rem 1.5rem; }
    .summary-totals .row {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.375rem 0;
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
        padding: 0.8125rem 0.9375rem;
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

    .summary-actions {
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
        padding: 0 1.5rem 1.5rem;
    }
    .summary-actions .s-btn { width: 100%; }
    .summary-note {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        border-top: 1px solid var(--line);
        background: #FBFEFC;
        font-size: 0.75rem;
        line-height: 1.55;
        color: #93A39A;
    }
    .summary-note svg { flex-shrink: 0; color: var(--green); margin-top: 0.0625rem; }
    .summary-note strong { color: #374151; font-weight: 600; }

    .help-card {
        position: relative;
        overflow: hidden;
        margin-top: 1.25rem;
        padding: 1.375rem 1.5rem;
        border-radius: 1.25rem;
        color: #F2FBF5;
        background:
            radial-gradient(90% 140% at 92% 0%, rgba(72,199,132,0.35), transparent 60%),
            linear-gradient(160deg, #0C3D28 0%, #072B1C 100%);
        box-shadow: 0 28px 50px -34px rgba(4,32,20,0.8);
        animation: sIn 0.55s var(--ease) 0.2s backwards;
    }
    .help-card .help-ic {
        width: 2.25rem;
        height: 2.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        color: var(--mint);
        margin-bottom: 0.875rem;
    }
    .help-card h3 {
        font-size: 0.9375rem;
        font-weight: 800;
        letter-spacing: -0.015em;
        color: #FFFFFF;
        margin-bottom: 0.375rem;
    }
    .help-card p {
        font-size: 0.8125rem;
        line-height: 1.65;
        color: rgba(226,245,232,0.66);
        margin-bottom: 1rem;
    }
    .help-card .help-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #FFE6A8;
        text-decoration: none;
        transition: gap 0.25s var(--ease), color 0.25s var(--ease);
    }
    .help-card .help-link:hover { gap: 0.6875rem; color: #FFFFFF; }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1024px) {
        .success-layout { grid-template-columns: minmax(0, 1fr) 330px; gap: 1.5rem; }
    }
    @media (max-width: 900px) {
        .success-layout { grid-template-columns: 1fr; }
        .success-aside {
            position: static;
            top: auto;
            order: -1;
        }
        .summary-card { position: static; }
        .help-card { display: none; }
    }
    @media (max-width: 640px) {
        .success-hero { padding: 2.25rem 1.25rem 3.5rem; }
        .success-hero h1 { font-size: clamp(1.75rem, 8vw, 2.25rem); }
        .success-hero p { font-size: 0.875rem; }
        .success-mark { width: 5.25rem; height: 5.25rem; margin: 1.25rem auto 1.25rem; }
        .success-mark .mark-core { width: 4.25rem; height: 4.25rem; }
        .success-mark .mark-core svg { width: 1.875rem; height: 1.875rem; }
        .order-chip { margin-top: 1.25rem; }
        .order-chip .chip-label { display: none; }
        .success-steps {
            margin: -1.75rem 1rem 0;
            max-width: none;
            padding: 0.75rem 1rem;
        }
        .success-steps .step .label { display: none; }
        .success-steps .step.active .label,
        .success-steps .step.cancelled .label { display: inline; }
        .success-steps .step .circle { width: 1.625rem; height: 1.625rem; font-size: 0.625rem; }
        .success-steps .step-line { width: 1rem; margin: 0 0.3125rem; }
        .success-layout { padding: 0 1rem; margin-top: 1.25rem; gap: 1.25rem; }
        .panel { border-radius: 1.25rem; }
        .panel-head { padding: 1.125rem 1.25rem; }
        .panel-body { padding: 1.25rem; }
        .summary-card { border-radius: 1.25rem; }
        .summary-head { padding: 1.25rem; }
        .summary-totals { padding: 1.125rem 1.25rem; }
        .summary-actions { padding: 0 1.25rem 1.25rem; }
        .summary-note { padding: 0.875rem 1.25rem; }
        .info-grid { grid-template-columns: 1fr; }
        .item-row .thumb { width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; }
        .item-row .item-name { font-size: 0.875rem; }
        .item-row .item-subtotal { font-size: 0.875rem; }
        .proof-preview img { width: 9rem; height: 9rem; }
    }
    @media (max-width: 400px) {
        .item-row { flex-wrap: wrap; }
        .item-row .item-subtotal { margin-left: 4.375rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes sFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes sIn {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes sMarkIn {
        0% { opacity: 0; transform: scale(0.55); }
        60% { opacity: 1; transform: scale(1.06); }
        100% { opacity: 1; transform: scale(1); }
    }
    @keyframes sRing {
        0% { opacity: 0.85; transform: scale(0.82); }
        75%, 100% { opacity: 0; transform: scale(1.55); }
    }
    @keyframes sDraw {
        to { stroke-dashoffset: 0; }
    }
    @keyframes sTwinkle {
        0%, 100% { opacity: 0; transform: scale(0.4); }
        50% { opacity: 0.95; transform: scale(1); }
    }
    @keyframes sPulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @keyframes sOrb {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(24px, -20px, 0) scale(1.08); }
    }

    @media (prefers-reduced-motion: reduce) {
        .success-eyebrow,
        .success-eyebrow .pulse::after,
        .success-mark,
        .success-mark .mark-ring,
        .success-mark .check-path,
        .success-mark .spark,
        .success-hero h1,
        .success-hero p,
        .order-chip,
        .panel,
        .summary-card,
        .help-card,
        .session-alert,
        .success-hero .orb {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
        .success-mark .check-path { stroke-dashoffset: 0; }
        .s-btn,
        .s-btn-gold::after,
        .s-btn svg,
        .mini-copy,
        .order-chip .copy-btn,
        .proof-form input,
        .proof-preview img {
            transition: none !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $isCancelled = $order->status === 'cancelled';
    $isPaid = $order->payment_status === 'paid' || !empty($order->proof_image);
    $heroState = $isCancelled ? 'cancelled' : ($isPaid ? 'confirmed' : 'pending');

    $statusRank = ['pending' => 0, 'processing' => 1, 'shipped' => 2, 'delivered' => 3][$order->status] ?? 0;
    $paymentStep = $isCancelled ? 'cancelled' : ($isPaid ? 'done' : 'active');
    $processingStep = $isCancelled ? '' : ($statusRank >= 1 ? 'done' : ($isPaid ? 'active' : ''));
    $deliveryStep = $isCancelled ? '' : ($order->status === 'delivered' ? 'done' : ($order->status === 'shipped' ? 'active' : ''));

    $contactEmail = $order->shippingAddress->email ?? $order->guest_email;
    $itemCount = $order->items->sum('quantity');
    $paymentTone = $isCancelled ? 'is-cancelled' : ($isPaid ? 'is-paid' : 'is-pending');
    $orderTone = $isCancelled ? 'is-cancelled' : ($order->status === 'delivered' ? 'is-paid' : 'is-neutral');
@endphp

<div class="success-page">
    {{-- ═══════ HERO ═══════ --}}
    <section class="success-hero">
        <div aria-hidden="true">
            <span class="orb orb-1"></span>
            <span class="orb orb-2"></span>
        </div>

        <div class="success-hero-inner">
            <span class="success-eyebrow {{ $heroState === 'pending' ? 'is-pending' : ($heroState === 'cancelled' ? 'is-cancelled' : '') }}">
                <span class="pulse" aria-hidden="true"></span>
                @if($isCancelled)
                    Order update
                @elseif($isPaid)
                    Payment received
                @else
                    Order received
                @endif
            </span>

            <div class="success-mark {{ $heroState === 'pending' ? 'is-pending' : ($heroState === 'cancelled' ? 'is-cancelled' : '') }}" aria-hidden="true">
                <span class="mark-ring"></span>
                <span class="mark-ring r2"></span>
                <span class="spark s1"></span>
                <span class="spark s2"></span>
                <span class="spark s3"></span>
                <span class="spark s4"></span>
                <span class="mark-core">
                    @if($isCancelled)
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    @elseif($isPaid)
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline class="check-path" points="20 6 9 17 4 12"/>
                        </svg>
                    @else
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <polyline points="12 7 12 12 15.5 14"/>
                        </svg>
                    @endif
                </span>
            </div>

            <h1>
                @if($isCancelled)
                    Order <em class="is-cancelled">cancelled</em>
                @elseif($isPaid)
                    Order <em>confirmed</em>
                @else
                    One step to <em class="is-pending">confirm</em>
                @endif
            </h1>

            <p>
                @if($isCancelled)
                    This order has been cancelled. If this was not expected, our support team is here to help.
                @elseif($isPaid)
                    Thank you for your purchase. Your payment proof has been received and your order is now being reviewed.
                @else
                    Your order is saved. Submit your payment proof below so we can start preparing it for delivery.
                @endif
            </p>

            <div class="order-chip">
                <span class="chip-label">Order</span>
                <strong>{{ $order->order_number }}</strong>
                <button type="button" class="copy-btn js-copy-order" onclick="copyOrderNumber(this)" aria-label="Copy order number" title="Copy order number">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- ═══════ PROGRESS STEPS ═══════ --}}
    <div class="success-steps">
        <div class="step done">
            <span class="circle">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="label">Ordered</span>
        </div>
        <div class="step-line done"></div>
        <div class="step {{ $paymentStep }}">
            <span class="circle">
                @if($paymentStep === 'done')
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                @elseif($paymentStep === 'cancelled')
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                @else
                    2
                @endif
            </span>
            <span class="label">Payment</span>
        </div>
        <div class="step-line {{ $paymentStep === 'done' ? 'done' : '' }}"></div>
        <div class="step {{ $processingStep }}">
            <span class="circle">
                @if($processingStep === 'done')
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                @else
                    3
                @endif
            </span>
            <span class="label">Processing</span>
        </div>
        <div class="step-line {{ $processingStep === 'done' ? 'done' : '' }}"></div>
        <div class="step {{ $deliveryStep }}">
            <span class="circle">
                @if($deliveryStep === 'done')
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                @else
                    4
                @endif
            </span>
            <span class="label">Delivered</span>
        </div>
    </div>

    {{-- ═══════ MAIN CONTENT ═══════ --}}
    <div class="success-layout">
        <div class="success-main">
            @if(session('success'))
                <div class="session-alert is-success">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="session-alert is-error">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Items --}}
            <section class="panel" style="--d:.05s">
                <div class="panel-head">
                    <span class="ic">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    <div>
                        <h2>Items ordered</h2>
                        <p>{{ $order->items->count() }} product{{ $order->items->count() !== 1 ? 's' : '' }} &middot; {{ $itemCount }} item{{ $itemCount !== 1 ? 's' : '' }} in total</p>
                    </div>
                </div>
                <div class="panel-body">
                    @foreach($order->items as $item)
                        <div class="item-row">
                            <div class="thumb">
                                @if($item->product && $item->product->images && count($item->product->images) > 0)
                                    <img src="{{ $item->product->image_urls[0] }}" alt="{{ $item->product_name }}">
                                @else
                                    <span class="no-img">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <path d="M21 15l-5-5L5 21"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            <div class="item-info">
                                <p class="item-name">{{ $item->product_name }}</p>
                                <div class="item-meta">
                                    <span>{{ currencyFormat($item->product_price) }} each</span>
                                    <span class="qty-pill">Qty {{ $item->quantity }}</span>
                                </div>
                            </div>
                            <p class="item-subtotal">{{ currencyFormat($item->subtotal) }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Shipping --}}
            @if($order->shippingAddress)
                <section class="panel" style="--d:.1s">
                    <div class="panel-head">
                        <span class="ic">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </span>
                        <div>
                            <h2>Delivery details</h2>
                            <p>Where your order is heading</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="info-grid">
                            <div class="full">
                                <p class="info-label">Recipient</p>
                                <p class="info-value"><strong>{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</strong></p>
                            </div>
                            <div class="full">
                                <p class="info-label">Address</p>
                                <p class="info-value">
                                    {{ $order->shippingAddress->address_line1 }}@if($order->shippingAddress->address_line2), {{ $order->shippingAddress->address_line2 }}@endif<br>
                                    {{ $order->shippingAddress->city }}{{ $order->shippingAddress->state ? ', ' . $order->shippingAddress->state : '' }} {{ $order->shippingAddress->postal_code }}<br>
                                    {{ $order->shippingAddress->country }}
                                </p>
                            </div>
                            <div>
                                <p class="info-label">Phone</p>
                                <p class="info-value"><a href="tel:{{ $order->shippingAddress->phone }}">{{ $order->shippingAddress->phone }}</a></p>
                            </div>
                            <div>
                                <p class="info-label">Email</p>
                                <p class="info-value"><a href="mailto:{{ $order->shippingAddress->email }}">{{ $order->shippingAddress->email }}</a></p>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- Payment details --}}
            @if($paymentDetails->count() > 0)
                <section class="panel" style="--d:.15s">
                    <div class="panel-head">
                        <span class="ic">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                        </span>
                        <div>
                            <h2>Payment details</h2>
                            <p>{{ $isPaid ? 'Payment information for this order' : 'Use one of the accounts below to pay' }}</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        @foreach($paymentDetails as $detail)
                            <div class="bank-card">
                                <div class="bank-head">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 21h18M5 21V10M19 21V10M3 10l9-6 9 6M9 21v-7h6v7"/>
                                    </svg>
                                    {{ $detail->bank_name }}
                                </div>
                                <div class="bank-row">
                                    <span class="lbl">Account number</span>
                                    <span class="val with-copy">
                                        {{ $detail->account_number }}
                                        <button type="button" class="mini-copy js-copy-text" data-copy="{{ $detail->account_number }}" onclick="copyTextFrom(this)" aria-label="Copy account number" title="Copy account number">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                                <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                                <div class="bank-row">
                                    <span class="lbl">Account holder</span>
                                    <span class="val">{{ $detail->account_holder }}</span>
                                </div>
                                @if($detail->instructions)
                                    <div class="bank-instructions">{!! nl2br(e($detail->instructions)) !!}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Payment proof --}}
            @if($isCancelled)
                <section class="panel" style="--d:.2s">
                    <div class="panel-head">
                        <span class="ic" style="background:#FEF2F2;border-color:#FBD5D5;color:#DC2626;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                        </span>
                        <div>
                            <h2>Order cancelled</h2>
                            <p>Payment proof is no longer required</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="proof-cancelled">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                This order has been <strong>cancelled</strong>. Payment proof can no longer be submitted for cancelled orders.
                            </div>
                        </div>
                    </div>
                </section>
            @elseif($order->proof_image)
                <section class="panel" style="--d:.2s">
                    <div class="panel-head">
                        <span class="ic">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </span>
                        <div>
                            <h2>Payment proof submitted</h2>
                            <p>We are reviewing your payment</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="proof-submitted">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <div>
                                Your payment proof has been submitted successfully.<br>
                                <strong>Transaction ID:</strong> {{ $order->transaction_id }}
                            </div>
                        </div>
                        <div class="proof-preview">
                            <p class="label">Uploaded screenshot</p>
                            <a class="shot" href="{{ $order->proof_image_url }}" target="_blank" rel="noopener" aria-label="Open payment proof in a new tab">
                                <img src="{{ $order->proof_image_url }}" alt="Payment proof">
                            </a>
                        </div>
                    </div>
                </section>
            @else
                <section class="panel" style="--d:.2s">
                    <div class="panel-head">
                        <span class="ic">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                        </span>
                        <div>
                            <h2>Submit payment proof</h2>
                            <p>Complete your order in one quick step</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('checkout.proof', $order->id) }}" method="POST" enctype="multipart/form-data" class="proof-form">
                            @csrf
                    <div class="form-group">
                        <label for="payment_method_used">Payment Method Used <span class="required">*</span></label>
                        <select name="payment_method_used" id="payment_method_used" required style="width:100%; padding:0.875rem 1rem; border-radius:0.875rem; border:1px solid #DCE7E1; font-size:0.9375rem;">
                            <option value="">Select payment method</option>
                            @if(isset($paymentDetails) && $paymentDetails->count() > 0)
                                @foreach($paymentDetails as $pd)
                                    <option value="{{ strtolower(str_replace(' ', '_', $pd->bank_name)) }}" {{ old('payment_method_used') == strtolower(str_replace(' ', '_', $pd->bank_name)) ? 'selected' : '' }}>{{ $pd->bank_name }}</option>
                                @endforeach
                            @else
                                <option value="bkash" {{ old('payment_method_used') == 'bkash' ? 'selected' : '' }}>bKash</option>
                                <option value="nagad" {{ old('payment_method_used') == 'nagad' ? 'selected' : '' }}>Nagad</option>
                                <option value="rocket" {{ old('payment_method_used') == 'rocket' ? 'selected' : '' }}>Rocket</option>
                                <option value="bank" {{ old('payment_method_used') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            @endif
                        </select>
                        @error('payment_method_used')
                            <p class="form-error">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="transaction_id">Transaction ID <span class="required">*</span></label>
                        <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" required placeholder="e.g. TRX123456789" autocomplete="off">
                        @error('transaction_id')
                            <p class="form-error">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="proof_image">Payment screenshot <span class="required">*</span></label>
                        <input type="file" name="proof_image" id="proof_image" accept="image/*" required onchange="previewProofImage(this)">
                        <div id="proofPreviewWrap" style="display:none; margin-top:0.875rem;">
                            <p class="label" style="font-size:0.8125rem; font-weight:600; margin-bottom:0.5rem; color:#374151;">Image Preview</p>
                            <div style="position:relative; display:inline-block;">
                                <img id="proofPreviewImg" src="" alt="Preview" style="max-width:200px; max-height:200px; border-radius:0.75rem; border:1px solid #e5e7eb; display:block;">
                                <button type="button" onclick="removeProofPreview()" style="position:absolute; top:-8px; right:-8px; background:#dc2626; color:white; border:none; border-radius:50%; width:24px; height:24px; cursor:pointer; font-size:14px; line-height:1;">&times;</button>
                            </div>
                        </div>
                        <p class="file-hint">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                            JPEG, PNG, JPG, GIF or WebP &middot; max 10MB
                        </p>
                        @error('proof_image')
                            <p class="form-error">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                            <button type="submit" class="s-btn s-btn-green">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Submit payment
                            </button>
                        </form>
                    </div>
                </section>
            @endif
        </div>

        {{-- ═══════ SUMMARY ASIDE ═══════ --}}
        <aside class="success-aside">
            <div class="summary-card">
                <div class="summary-head">
                    <div class="summary-top">
                        <h2>Order summary</h2>
                        <span class="count">{{ $itemCount }} item{{ $itemCount !== 1 ? 's' : '' }}</span>
                    </div>
                    <div class="summary-meta">
                        <div class="meta-row">
                            <span class="lbl">Order number</span>
                            <span class="val order-num">
                                {{ $order->order_number }}
                                <button type="button" class="mini-copy js-copy-order" onclick="copyOrderNumber(this)" aria-label="Copy order number" title="Copy order number">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="meta-row">
                            <span class="lbl">Placed on</span>
                            <span class="val">{{ $order->created_at->format('M d, Y') }} &middot; {{ $order->created_at->format('h:i A') }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="lbl">Payment</span>
                            <span class="status-badge {{ $paymentTone }}">
                                @if($isPaid && !$isCancelled)
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                @endif
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="meta-row">
                            <span class="lbl">Order status</span>
                            <span class="status-badge {{ $orderTone }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </div>

                <div class="summary-totals">
                    <div class="row">
                        <span class="lbl">Subtotal</span>
                        <span class="val">{{ currencyFormat($order->subtotal) }}</span>
                    </div>
                    <div class="row">
                        <span class="lbl">Shipping</span>
                        <span class="val">{{ currencyFormat($order->shipping_cost) }}</span>
                    </div>
                    <div class="row">
                        <span class="lbl">VAT</span>
                        <span class="val">{{ currencyFormat($order->tax) }}</span>
                    </div>
                    <hr class="divider">
                    <div class="total-row">
                        <span class="lbl">Total</span>
                        <span class="val">{{ currencyFormat($order->total) }}</span>
                    </div>
                </div>

                <div class="summary-actions">
                    <a href="{{ route('products.index') }}" class="s-btn s-btn-gold">
                        Continue shopping
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="{{ route('track-order.index') }}" class="s-btn s-btn-outline">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Track your order
                    </a>
                </div>

                @if($contactEmail)
                    <div class="summary-note">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Order updates are sent to <strong>{{ $contactEmail }}</strong></span>
                    </div>
                @endif
            </div>

            <div class="help-card">
                <span class="help-ic">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                    </svg>
                </span>
                <h3>Need a hand?</h3>
                <p>Questions about your order or payment? Our care team is happy to help.</p>
                <a href="{{ route('track-order.index') }}" class="help-link">
                    Check order status
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewProofImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('proofPreviewImg').src = e.target.result;
                document.getElementById('proofPreviewWrap').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function removeProofPreview() {
        var input = document.getElementById('proof_image');
        if (input) input.value = '';
        var wrap = document.getElementById('proofPreviewWrap');
        if (wrap) wrap.style.display = 'none';
        var img = document.getElementById('proofPreviewImg');
        if (img) img.src = '';
    }

    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        }

        return new Promise(function (resolve, reject) {
            const area = document.createElement('textarea');
            area.value = text;
            area.setAttribute('readonly', '');
            area.style.position = 'fixed';
            area.style.top = '-9999px';
            document.body.appendChild(area);
            area.select();

            try {
                document.execCommand('copy');
                resolve();
            } catch (error) {
                reject(error);
            } finally {
                document.body.removeChild(area);
            }
        });
    }

    function flashCopied(button) {
        if (!button) return;

        const original = button.innerHTML;
        button.classList.add('is-copied');
        button.innerHTML = '<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

        window.setTimeout(function () {
            button.innerHTML = original;
            button.classList.remove('is-copied');
        }, 1700);
    }

    function copyOrderNumber(button) {
        copyToClipboard(@json($order->order_number)).then(function () {
            document.querySelectorAll('.js-copy-order').forEach(flashCopied);
        }).catch(function () {});
    }

    function copyTextFrom(button) {
        copyToClipboard(button.getAttribute('data-copy') || '').then(function () {
            flashCopied(button);
        }).catch(function () {});
    }
</script>
@endpush
