@extends('frontend.layouts.app')

@section('title', 'My Orders')

@push('styles')
<style>
    .orders-page {
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
    .orders-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 3.25rem 1.5rem 5rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 420px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            radial-gradient(520px 320px at 0% 100%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .orders-hero::before {
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
    .orders-hero .orb {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }
    .orders-hero .orb-1 {
        width: 420px;
        height: 420px;
        top: -190px;
        right: 2%;
        background: radial-gradient(circle, rgba(72,199,132,0.42), transparent 66%);
        animation: orbf 22s ease-in-out infinite;
    }
    .orders-hero .orb-2 {
        width: 320px;
        height: 320px;
        bottom: -170px;
        left: -60px;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        animation: orbf 28s ease-in-out infinite reverse;
    }
    .orders-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .orders-eyebrow {
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
        width: fit-content;
        animation: fadeUp 0.6s var(--ease) 0.05s both;
    }
    .orders-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #9DF3BE;
        flex-shrink: 0;
    }
    .orders-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(157,243,190,0.55);
        animation: pulse 2.4s ease-out infinite;
    }
    .orders-hero h1 {
        font-size: clamp(2rem, 4vw, 2.875rem);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.045em;
        color: #FFFFFF;
        animation: fadeUp 0.6s var(--ease) 0.16s both;
    }
    .orders-hero h1 em {
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
    .orders-hero p {
        max-width: 34rem;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.68);
        animation: fadeUp 0.6s var(--ease) 0.26s both;
    }

    /* ─────────────── WRAP ─────────────── */
    .orders-wrap {
        max-width: 1180px;
        margin: -2.75rem auto 0;
        padding: 0 1.5rem 4.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    /* ─────────────── ALERT ─────────────── */
    .alert-success {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.875rem 1rem;
        border-radius: 1rem;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        font-size: 0.875rem;
        line-height: 1.55;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: inUp 0.5s var(--ease) backwards;
    }
    .alert-success svg { flex-shrink: 0; margin-top: 0.125rem; }

    /* ─────────────── TOOLBAR ─────────────── */
    .orders-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        padding: 0.875rem 1.25rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 9999px;
        box-shadow: 0 30px 60px -42px rgba(10,60,38,0.55);
        animation: inUp 0.5s var(--ease) 0.05s backwards;
    }
    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    .total-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: #166534;
        font-size: 0.8125rem;
        font-weight: 700;
    }
    .page-info {
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .ghost-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 9999px;
        color: var(--green-deep);
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.25s var(--ease), color 0.25s var(--ease), gap 0.25s var(--ease);
    }
    .ghost-link:hover {
        background: #F3FBF6;
        gap: 0.625rem;
    }

    /* ─────────────── LIST ─────────────── */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .order-card {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: stretch;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        cursor: pointer;
        transition: transform 0.35s var(--ease), box-shadow 0.35s var(--ease), border-color 0.35s var(--ease);
        animation: inUp 0.55s var(--ease) backwards;
    }
    .order-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #7BCB9B 0%, #2E8B57 100%);
    }
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 36px 70px -48px rgba(10,60,38,0.6);
        border-color: #B9E2C9;
    }
    .order-card:active { transform: translateY(-2px); }

    .order-main {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding: 1.5rem;
    }
    .order-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .order-id-group {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }
    .order-id-row {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        flex-wrap: wrap;
    }
    .order-id-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--ink);
    }
    .order-id-label .dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: #7BCB9B;
        box-shadow: 0 0 0 6px rgba(123,203,155,0.12);
    }
    .copy-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        border: 1px solid var(--line);
        background: #FFFFFF;
        color: var(--green-deep);
        font-size: 0.6875rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .copy-pill:hover {
        background: #F3FBF6;
        border-color: #B9E2C9;
    }
    .copy-pill.is-copied {
        background: #F0FDF4;
        border-color: #BBF7D0;
        color: #166534;
    }
    .order-meta-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.875rem;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .order-meta-row .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    .order-meta-row .meta-item svg { color: #93A39A; }

    .order-status-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1.4;
        text-transform: capitalize;
    }
    .status-pill .sub {
        font-size: 0.6875rem;
        font-weight: 600;
        opacity: 0.8;
        text-transform: none;
    }
    .status-pill.is-pending {
        background: #FFF8E6;
        border: 1px solid #FBE7B5;
        color: #8A5A00;
    }
    .status-pill.is-processing {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #1E40AF;
    }
    .status-pill.is-shipped {
        background: #EEF2FF;
        border: 1px solid #C7D2FE;
        color: #3730A3;
    }
    .status-pill.is-delivered {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
    }
    .status-pill.is-cancelled {
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #991B1B;
    }

    .order-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #F1F7F3;
    }
    .order-totals {
        display: flex;
        align-items: baseline;
        gap: 0.625rem;
    }
    .order-totals .label {
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .order-totals .amount {
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--green-deep);
    }
    .payment-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.3125rem 0.75rem;
        border-radius: 9999px;
        background: #F8FAFC;
        border: 1px solid #E5E7EB;
        font-size: 0.75rem;
        font-weight: 600;
        color: #374151;
    }
    .payment-chip.is-paid,
    .payment-chip.is-approved {
        background: #F0FDF4;
        border-color: #BBF7D0;
        color: #166534;
    }
    .payment-chip.is-rejected,
    .payment-chip.is-cancelled {
        background: #FEF2F2;
        border-color: #FBD5D5;
        color: #991B1B;
    }
    .payment-chip.is-pending,
    .payment-chip.is-unpaid {
        background: #FFF8E6;
        border-color: #FBE7B5;
        color: #8A5A00;
    }

    .order-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1.25rem 1.5rem;
        border-left: 1px solid var(--line);
        background: linear-gradient(180deg, #FBFEFC 0%, #F6FAF8 100%);
    }
    .action-stack {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 10rem;
    }
    .btn-solid {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.75rem;
        padding: 0 1.125rem;
        border: none;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #2E8B57 0%, #17603C 100%);
        color: #FFFFFF;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 28px -16px rgba(23,96,60,0.9), inset 0 1px 0 rgba(255,255,255,0.18);
        transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
    }
    .btn-solid::after {
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
    .btn-solid:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px -16px rgba(23,96,60,0.95), inset 0 1px 0 rgba(255,255,255,0.2);
    }
    .btn-solid:hover::after { transform: translateX(420%) rotate(12deg); }
    .btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.75rem;
        padding: 0 1rem;
        border-radius: 0.75rem;
        border: 1px solid var(--line);
        background: #FFFFFF;
        color: #374151;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .btn-ghost:hover {
        background: #F3FBF6;
        border-color: #B9E2C9;
        color: var(--green-deep);
    }
    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.75rem;
        padding: 0 1rem;
        border-radius: 0.75rem;
        border: 1px solid #FBD5D5;
        background: #FFFFFF;
        color: #DC2626;
        font-size: 0.8125rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease);
    }
    .btn-danger:hover {
        background: #FEF2F2;
        border-color: #FCA5A5;
    }

    /* ─────────────── EMPTY STATE ─────────────── */
    .empty-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
        padding: 4rem 2rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
    }
    .empty-card .empty-ic {
        width: 4.25rem;
        height: 4.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: var(--green);
    }
    .empty-card h2 {
        font-size: 1.375rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--ink);
    }
    .empty-card p {
        max-width: 28rem;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: var(--muted);
    }
    .shop-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        height: 3rem;
        padding: 0 1.75rem;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.9375rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 34px -14px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .shop-btn::after {
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
    .shop-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .shop-btn:hover::after { transform: translateX(420%) rotate(12deg); }
    .shop-btn svg { transition: transform 0.3s var(--ease); }
    .shop-btn:hover svg { transform: translateX(4px); }

    /* ─────────────── PAGINATION ─────────────── */
    .orders-pagi {
        display: flex;
        justify-content: center;
        margin-top: 0.5rem;
    }
    .orders-pagi nav { display: flex; flex-wrap: wrap; gap: 0.375rem; }
    .orders-pagi .page-link,
    .orders-pagi .page-item a,
    .orders-pagi .page-item span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.25rem;
        height: 2.25rem;
        padding: 0 0.625rem;
        border-radius: 9999px;
        border: 1px solid var(--line);
        background: var(--surface);
        color: var(--muted);
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .orders-pagi .page-item.active span,
    .orders-pagi .page-item.active .page-link {
        background: linear-gradient(135deg, #2E8B57 0%, #17603C 100%);
        border-color: transparent;
        color: #FFFFFF;
    }
    .orders-pagi .page-item a:hover {
        background: #F3FBF6;
        border-color: #B9E2C9;
        color: var(--green-deep);
    }
    .orders-pagi .page-item.disabled span {
        opacity: 0.4;
        pointer-events: none;
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1024px) {
        .order-card { grid-template-columns: 1fr; }
        .order-actions {
            border-left: none;
            border-top: 1px solid var(--line);
            justify-content: flex-start;
        }
        .action-stack {
            flex-direction: row;
            flex-wrap: wrap;
            min-width: 0;
        }
        .action-stack .btn-solid,
        .action-stack .btn-ghost,
        .action-stack .btn-danger {
            height: 2.625rem;
        }
    }
    @media (max-width: 640px) {
        .orders-hero { padding: 2.25rem 1.25rem 4rem; }
        .orders-wrap { padding: 0 1rem 3.5rem; margin-top: -2.25rem; gap: 1rem; }
        .orders-toolbar {
            border-radius: 1rem;
            flex-direction: column;
            align-items: flex-start;
            padding: 0.875rem 1rem;
        }
        .toolbar-right { width: 100%; justify-content: space-between; }
        .order-main { padding: 1.25rem; }
        .order-head { flex-direction: column; align-items: flex-start; }
        .order-status-group { justify-content: flex-start; }
        .order-footer { flex-direction: column; align-items: flex-start; }
        .order-actions { padding: 1rem 1.25rem; width: 100%; }
        .action-stack { width: 100%; }
        .action-stack .btn-solid,
        .action-stack .btn-ghost,
        .action-stack .btn-danger { flex: 1 1 100%; }
        .empty-card { padding: 3rem 1.5rem; border-radius: 1.25rem; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes inUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes orbf {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(24px, -20px, 0) scale(1.08); }
    }
    @keyframes pulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }

    @media (prefers-reduced-motion: reduce) {
        .orders-eyebrow,
        .orders-hero h1,
        .orders-hero p,
        .alert-success,
        .orders-toolbar,
        .order-card,
        .orders-hero .orb {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
        .orders-eyebrow .pulse::after,
        .btn-solid::after,
        .shop-btn::after,
        .btn-solid svg,
        .shop-btn svg {
            transition: none !important;
            animation: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="orders-page">
    <section class="orders-hero">
        <div aria-hidden="true">
            <span class="orb orb-1"></span>
            <span class="orb orb-2"></span>
        </div>
        <div class="orders-hero-inner">
            <span class="orders-eyebrow">
                <span class="pulse" aria-hidden="true"></span>
                Your account
            </span>
            <h1>My <em>orders</em></h1>
            <p>Track every purchase, check payment status, and manage deliveries in one polished space.</p>
        </div>
    </section>

    <div class="orders-wrap">
        @if(session('success'))
            <div class="alert-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="orders-toolbar">
            <div class="toolbar-left">
                <span class="total-pill">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                    {{ $orders->total() }} order{{ $orders->total() !== 1 ? 's' : '' }}
                </span>
                @if($orders->count() > 0 && $orders->hasPages())
                    <span class="page-info">Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>
                @endif
            </div>
            <div class="toolbar-right">
                <a href="{{ route('products.index') }}" class="ghost-link">
                    Continue shopping
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        </div>

        @if($orders->count() > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    @php
                        $statusClass = match($order->status) {
                            'pending' => 'is-pending',
                            'processing' => 'is-processing',
                            'shipped' => 'is-shipped',
                            'delivered' => 'is-delivered',
                            'cancelled' => 'is-cancelled',
                            default => 'is-pending',
                        };
                        $paymentClass = match($order->payment_status) {
                            'paid', 'approved' => 'is-paid',
                            'rejected', 'cancelled' => 'is-rejected',
                            'pending', 'unpaid' => 'is-pending',
                            default => '',
                        };
                    @endphp
                    <article class="order-card" onclick="window.location='{{ route('orders.show', $order->id) }}'">
                        <div class="order-main">
                            <div class="order-head">
                                <div class="order-id-group">
                                    <div class="order-id-row">
                                        <div class="order-id-label">
                                            <span class="dot" aria-hidden="true"></span>
                                            {{ $order->order_number }}
                                        </div>
                                        <button type="button" class="copy-pill js-copy" onclick="event.stopPropagation(); copyOrderNumber('{{ $order->order_number }}', this)">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                            Copy
                                        </button>
                                    </div>
                                    <div class="order-meta-row">
                                        <div class="meta-item">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            {{ $order->created_at->format('M d, Y') }} &middot; {{ $order->created_at->format('h:i A') }}
                                        </div>
                                        <div class="meta-item">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 4h16v16H4z"/><polyline points="22,6 12,13 2,6"/></svg>
                                            {{ $order->email ?? 'Guest' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="order-status-group">
                                    <span class="status-pill {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                        @if($order->status === 'cancelled' && $order->cancelled_by)
                                            <span class="sub">by {{ $order->cancelled_by === 'user' ? 'You' : 'Admin' }}</span>
                                        @endif
                                    </span>
                                    <span class="payment-chip {{ $paymentClass }}">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                        Payment {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="order-footer">
                                <div class="order-totals">
                                    <span class="label">Order total</span>
                                    <span class="amount">{{ currencyFormat($order->total) }}</span>
                                </div>
                                <div class="payment-chip {{ $paymentClass }}">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                                    {{ ($order->payment_status === 'paid' || $order->payment_status === 'approved') ? 'Payment confirmed' : 'Awaiting payment' }}
                                </div>
                            </div>
                        </div>
                        <div class="order-actions">
                            <div class="action-stack">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn-solid" onclick="event.stopPropagation();">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    View order
                                </a>
                                @if(in_array($order->status, ['pending', 'processing']))
                                    <button type="button" class="btn-danger" onclick="event.stopPropagation(); confirmCancel({{ $order->id }}, '{{ $order->order_number }}')">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        Cancel order
                                    </button>
                                @else
                                    <a href="{{ route('track-order.index') }}" class="btn-ghost" onclick="event.stopPropagation();">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        Track order
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($orders->hasPages())
                <div class="orders-pagi">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="empty-card">
                <div class="empty-ic">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                </div>
                <h2>No orders yet</h2>
                <p>You haven't placed any orders yet. Discover our curated collection and start your first order.</p>
                <a href="{{ route('products.index') }}" class="shop-btn">
                    Shop the collection
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12h15m0 0l-6-6m6 6l-6 6"/></svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const cancelUrl = '{{ route("orders.cancel", "_id_") }}';
    const csrfToken = '{{ csrf_token() }}';

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
            try { document.execCommand('copy'); resolve(); }
            catch (e) { reject(e); }
            finally { document.body.removeChild(area); }
        });
    }

    function copyOrderNumber(text, el) {
        copyToClipboard(text).then(function () {
            if (!el) return;
            const original = el.innerHTML;
            el.classList.add('is-copied');
            el.innerHTML = '<svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied';
            setTimeout(function () {
                el.innerHTML = original;
                el.classList.remove('is-copied');
            }, 1600);
        });
    }

    function confirmCancel(orderId, orderNumber) {
        Swal.fire({
            title: 'Cancel this order?',
            html: `You're about to cancel <strong>${orderNumber}</strong>.<br>This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, cancel order',
            cancelButtonText: 'Keep order',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(cancelUrl.replace('_id_', orderId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({ '_method': 'PATCH', '_token': csrfToken })
                }).then(res => {
                    if (!res.ok) throw new Error('Failed');
                    return res;
                }).catch(() => {
                    Swal.showValidationMessage('Something went wrong. Please try again.');
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Order cancelled',
                    text: `${orderNumber} has been cancelled successfully.`,
                    icon: 'success',
                    confirmButtonColor: '#2E8B57',
                    confirmButtonText: 'Back to orders',
                    timer: 2200,
                    timerProgressBar: true,
                }).then(() => window.location.reload());
            }
        });
    }
</script>
@endpush
