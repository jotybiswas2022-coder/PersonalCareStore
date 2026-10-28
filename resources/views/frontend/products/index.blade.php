@extends('frontend.layouts.app')

@section('title', isset($category) ? $category->name : 'Products')
@section('meta_description', isset($category) && $category->description ? Str::limit(strip_tags($category->description), 160) : 'Browse our complete collection of premium personal care and home care products.')

@push('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .shop-hero {
        position: relative;
        overflow: hidden;
        padding: 3.25rem 1.5rem 3.5rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 520px at 88% 0%, rgba(46,139,87,0.35), transparent 62%),
            radial-gradient(600px 400px at 0% 100%, rgba(255,209,102,0.1), transparent 68%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .shop-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 70px 70px;
        -webkit-mask-image: radial-gradient(circle at 50% 40%, #000, transparent 75%);
        mask-image: radial-gradient(circle at 50% 40%, #000, transparent 75%);
        pointer-events: none;
    }
    .shop-hero-art {
        position: absolute;
        top: -28%;
        right: -8%;
        width: 42%;
        height: auto;
        opacity: 0.7;
        pointer-events: none;
        animation: shopSpin 90s linear infinite;
    }
    .shop-orb {
        position: absolute;
        bottom: -130px;
        left: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,209,102,0.2), transparent 68%);
        filter: blur(60px);
        pointer-events: none;
        animation: shopDrift 22s ease-in-out infinite;
    }
    .shop-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(0, 0.92fr);
        gap: 2.75rem;
        align-items: center;
    }
    .shop-eyebrow {
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
    .shop-eyebrow::before {
        content: '';
        width: 1.5rem;
        height: 1px;
        background: currentColor;
        opacity: 0.5;
    }
    .shop-copy h1 {
        font-size: clamp(2.1rem, 4.1vw, 3rem);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.045em;
        color: #FFFFFF;
        margin-bottom: 0.875rem;
    }
    .shop-copy h1 em {
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
    .shop-copy p {
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.7);
        max-width: 30rem;
    }
    .shop-search-card {
        position: relative;
        z-index: 1;
        padding: 1.375rem;
        border-radius: 1.25rem;
        background: rgba(255,255,255,0.055);
        border: 1px solid rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }
    .shop-search-label {
        display: block;
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(226,245,232,0.5);
        margin-bottom: 0.5rem;
    }
    .shop-search-row {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.3125rem;
        border-radius: 0.875rem;
        background: rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.14);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .shop-search-row:focus-within {
        border-color: rgba(157,243,190,0.55);
        box-shadow: 0 0 0 4px rgba(123,241,168,0.12);
    }
    .shop-search-row > svg {
        margin-left: 0.4375rem;
        color: rgba(226,245,232,0.55);
        flex-shrink: 0;
    }
    .shop-search-row input {
        flex: 1;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        color: #FFFFFF;
        font-size: 0.8125rem;
        font-family: inherit;
        padding: 0.5rem 0.25rem;
    }
    .shop-search-row input::placeholder { color: rgba(226,245,232,0.4); }
    .shop-search-row input[type="search"]::-webkit-search-cancel-button { -webkit-appearance: none; }
    .shop-search-row button {
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
    .shop-search-row button:hover { background: #FFE08A; transform: translateY(-1px); }
    .shop-search-clear {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        color: rgba(226,245,232,0.55);
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .shop-search-clear:hover { background: rgba(255,255,255,0.1); color: #FFFFFF; }
    .shop-search-hint {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.75rem;
        font-size: 0.6875rem;
        color: rgba(226,245,232,0.45);
    }
    .shop-search-hint svg { color: #FFD166; flex-shrink: 0; }

    /* ─────────────── MAIN ─────────────── */
    .shop-main {
        padding: 2rem 1.5rem 5rem;
        background: #F6FAF7;
    }
    .shop-toolbar {
        max-width: 1280px;
        margin: 0 auto 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .shop-chips {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding-bottom: 0.125rem;
        max-width: 100%;
    }
    .shop-chips::-webkit-scrollbar { display: none; }
    .shop-chip {
        flex-shrink: 0;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        border: 1px solid #E4EEE8;
        background: #FFFFFF;
        color: #41524A;
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }
    .shop-chip:hover {
        border-color: #BFE3CC;
        color: #17603C;
        transform: translateY(-1px);
    }
    .shop-chip.is-active {
        background: #0E3D27;
        border-color: #0E3D27;
        color: #FFFFFF;
    }
    .shop-count {
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7A8B82;
        white-space: nowrap;
    }
    .shop-search-note {
        max-width: 1280px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        flex-wrap: wrap;
        font-size: 0.8125rem;
        color: #5C6B62;
    }
    .shop-search-note strong { color: #10261A; }
    .shop-search-note a {
        color: #17603C;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid rgba(23,96,60,0.3);
    }
    .shop-search-note a:hover { border-color: #17603C; }

    /* ─────────────── PRODUCT GRID ─────────────── */
    .shop-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.25rem;
    }
    .shop-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #FFFFFF;
        border: 1px solid #E4EEE8;
        border-radius: 1.25rem;
        box-shadow: 0 16px 36px -42px rgba(9, 50, 32, 0.4);
        transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease, border-color 0.3s ease;
        animation: shopRise 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .shop-card:nth-child(2) { animation-delay: 0.05s; }
    .shop-card:nth-child(3) { animation-delay: 0.1s; }
    .shop-card:nth-child(4) { animation-delay: 0.15s; }
    .shop-card:nth-child(5) { animation-delay: 0.2s; }
    .shop-card:nth-child(6) { animation-delay: 0.25s; }
    .shop-card:nth-child(7) { animation-delay: 0.3s; }
    .shop-card:nth-child(8) { animation-delay: 0.35s; }
    .shop-card:nth-child(9) { animation-delay: 0.4s; }
    .shop-card:nth-child(10) { animation-delay: 0.45s; }
    .shop-card:nth-child(11) { animation-delay: 0.5s; }
    .shop-card:nth-child(12) { animation-delay: 0.55s; }
    .shop-card:hover {
        transform: translateY(-5px);
        border-color: #CDEBD8;
        box-shadow: 0 26px 48px -32px rgba(9, 50, 32, 0.45);
    }
    .shop-media {
        position: relative;
        display: block;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #F3F8F4;
    }
    .shop-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .shop-card:hover .shop-media img { transform: scale(1.06); }
    .shop-noimg {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #C7D6CD;
        background: #F3F8F4;
    }
    .shop-badges {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.375rem;
        z-index: 2;
    }
    .shop-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5625rem;
        border-radius: 9999px;
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        box-shadow: 0 4px 10px -4px rgba(0,0,0,0.3);
    }
    .shop-badge.deal { background: linear-gradient(135deg, #E05252, #C43D3D); color: #FFFFFF; }
    .shop-badge.out { background: rgba(16,38,26,0.78); color: #FFFFFF; }
    .shop-view {
        position: absolute;
        left: 50%;
        bottom: 0.75rem;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        padding: 0.4375rem 0.75rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.94);
        border: 1px solid rgba(255,255,255,0.7);
        box-shadow: 0 10px 24px -12px rgba(0,0,0,0.4);
        color: #10261A;
        font-size: 0.6875rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        transform: translate(-50%, 8px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .shop-card:hover .shop-view { opacity: 1; transform: translate(-50%, 0); }
    .shop-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 1rem 1.125rem 1.125rem;
    }
    .shop-cat {
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #2E8B57;
        margin-bottom: 0.3125rem;
    }
    .shop-name {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 0.9375rem;
        font-weight: 700;
        line-height: 1.35;
        letter-spacing: -0.015em;
        color: #10261A;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .shop-name:hover { color: #2E8B57; }
    .shop-deal {
        margin-top: 0.375rem;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #C2410C;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .shop-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-top: auto;
        padding-top: 0.75rem;
    }
    .shop-price {
        display: flex;
        align-items: baseline;
        gap: 0.375rem;
        flex-wrap: wrap;
        min-width: 0;
    }
    .shop-price .now {
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #10261A;
    }
    .shop-price .was {
        font-size: 0.75rem;
        color: #9AA9A0;
        text-decoration: line-through;
    }
    .shop-stock {
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .shop-stock.in { color: #17603C; }
    .shop-stock.in::before {
        content: '';
        width: 0.375rem;
        height: 0.375rem;
        border-radius: 50%;
        background: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.12);
    }
    .shop-stock.out { color: #B45309; }
    .shop-form { margin-top: 0.75rem; }
    .shop-add {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: none;
        border-radius: 0.625rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 60%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.55);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }
    .shop-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px -12px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.55);
    }
    .shop-add:active { transform: translateY(0); }
    .shop-add.is-disabled {
        background: #EEF3EF;
        color: #9AA9A0;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    /* ─────────────── EMPTY ─────────────── */
    .shop-empty {
        grid-column: 1 / -1;
        padding: 3.5rem 1.5rem;
        text-align: center;
        background: #FFFFFF;
        border: 1px dashed #D9E8DF;
        border-radius: 1.25rem;
    }
    .shop-empty .empty-ico {
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
    .shop-empty h2 {
        font-size: 1.125rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #10261A;
        margin-bottom: 0.375rem;
    }
    .shop-empty p {
        max-width: 26rem;
        margin: 0 auto 1.25rem;
        font-size: 0.875rem;
        line-height: 1.6;
        color: #617067;
    }
    .shop-empty-cta {
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
    .shop-empty-cta:hover { background: #15603C; transform: translateY(-1px); }

    /* ─────────────── PAGINATION ─────────────── */
    .shop-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.375rem;
        flex-wrap: wrap;
        margin-top: 2.5rem;
    }
    .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.25rem;
        height: 2.25rem;
        padding: 0 0.625rem;
        border-radius: 0.625rem;
        border: 1px solid #E4EEE8;
        background: #FFFFFF;
        color: #41524A;
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }
    a.page-link:hover { border-color: #BFE3CC; color: #17603C; }
    .page-link.is-current {
        background: #0E3D27;
        border-color: #0E3D27;
        color: #FFFFFF;
    }
    .page-link.is-disabled { color: #C7D6CD; cursor: not-allowed; }

    @keyframes shopRise {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes shopSpin {
        to { transform: rotate(360deg); }
    }
    @keyframes shopDrift {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(18px, -16px, 0) scale(1.08); }
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1100px) {
        .shop-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 900px) {
        .shop-hero { padding: 2.5rem 1.25rem 2.75rem; }
        .shop-hero-inner { grid-template-columns: 1fr; gap: 1.5rem; }
        .shop-hero-art { width: 52%; top: -22%; right: -14%; }
        .shop-main { padding: 1.75rem 1.25rem 4rem; }
    }
    @media (max-width: 820px) {
        .shop-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
    }
    @media (max-width: 560px) {
        .shop-hero { padding: 2rem 1rem 2.25rem; }
        .shop-copy h1 { font-size: 1.75rem; }
        .shop-copy p { font-size: 0.8125rem; line-height: 1.6; }
        .shop-eyebrow { margin-bottom: 0.625rem; }
        .shop-hero-art { width: 70%; top: -12%; right: -22%; opacity: 0.55; }
        .shop-search-card { padding: 1rem; border-radius: 1rem; }
        .shop-search-row input { font-size: 0.8125rem; }
        .shop-main { padding: 1.25rem 1rem 3rem; }
        .shop-toolbar { margin-bottom: 1rem; gap: 0.75rem; }
        .shop-chip { padding: 0.4375rem 0.875rem; font-size: 0.75rem; }
        .shop-count { font-size: 0.625rem; }
        .shop-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.75rem; }
        .shop-card { border-radius: 1rem; }
        .shop-body { padding: 0.75rem; }
        .shop-cat { font-size: 0.5625rem; margin-bottom: 0.25rem; }
        .shop-name { font-size: 0.8125rem; }
        .shop-deal { font-size: 0.625rem; margin-top: 0.25rem; }
        .shop-bottom { padding-top: 0.5rem; gap: 0.375rem; }
        .shop-price .now { font-size: 0.9375rem; }
        .shop-price .was { font-size: 0.6875rem; }
        .shop-stock.in { display: none; }
        .shop-stock.out { font-size: 0.5625rem; }
        .shop-add { padding: 0.5rem; font-size: 0.6875rem; }
        .shop-view { display: none; }
        .shop-badges { top: 0.5rem; left: 0.5rem; }
        .shop-badge { font-size: 0.5625rem; padding: 0.1875rem 0.4375rem; }
        .shop-empty { padding: 2.5rem 1.25rem; border-radius: 1rem; }
    }
    @media (prefers-reduced-motion: reduce) {
        .shop-card,
        .shop-hero-art,
        .shop-orb {
            animation: none !important;
        }
    }
</style>
@endpush

@section('content')
    @php
        $pageDescription = isset($category)
            ? ($category->description ?: 'Explore our handpicked ' . $category->name . ' essentials — quality you can trust, delivered to your door.')
            : 'Browse our complete collection of premium personal care and home care products — picked for quality, packed with care.';
    @endphp

    <!-- ════════ SHOP HERO ════════ -->
    <section class="shop-hero">
        <svg class="shop-hero-art" viewBox="0 0 420 420" fill="none" aria-hidden="true">
            <circle cx="210" cy="210" r="200" stroke="rgba(255,255,255,0.07)"/>
            <circle cx="210" cy="210" r="152" stroke="rgba(157,243,190,0.18)" stroke-dasharray="2 8"/>
            <circle cx="210" cy="210" r="104" stroke="rgba(255,209,102,0.18)"/>
            <path d="M210 140c-30 20-44 48-44 78 30 4 58-6 78-30 18-22 20-48 14-72-18 2-34 10-48 24z" stroke="rgba(157,243,190,0.4)" stroke-width="1.4"/>
            <path d="M196 236c8-30 22-52 44-70" stroke="rgba(255,209,102,0.3)" stroke-width="1.2" stroke-linecap="round"/>
            <circle cx="354" cy="118" r="4" fill="#FFD166" opacity=".8"/>
        </svg>
        <span class="shop-orb" aria-hidden="true"></span>

        <div class="shop-hero-inner">
            <div class="shop-copy">
                <span class="shop-eyebrow">{{ isset($category) ? 'Category' : 'The collection' }}</span>
                <h1>
                    @if(isset($category))
                        {{ $category->name }}
                    @else
                        Care, <em>curated</em>.
                    @endif
                </h1>
                <p>{{ $pageDescription }}</p>
            </div>

            <div class="shop-search-card">
                <span class="shop-search-label">Search the collection</span>
                <form method="GET" action="{{ url()->current() }}" role="search">
                    <div class="shop-search-row">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="search" id="liveSearch" name="search" value="{{ request('search') }}"
                               placeholder="Serum, shampoo, care…" aria-label="Search products">
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="shop-search-clear" aria-label="Clear search">&times;</a>
                        @endif
                        <button type="submit">Search</button>
                    </div>
                </form>
                <p class="shop-search-hint">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
                    Try “serum”, “hair” or “daily care”.
                </p>
            </div>
        </div>
    </section>

    <!-- ════════ PRODUCTS ════════ -->
    <section class="shop-main">
        <div class="shop-toolbar">
            <div class="shop-chips">
                <a href="{{ route('products.index', request('search') ? ['search' => request('search')] : []) }}"
                   class="shop-chip {{ !isset($category) ? 'is-active' : '' }}">All products</a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.byCategory', array_merge([$cat->id], request('search') ? ['search' => request('search')] : [])) }}"
                       class="shop-chip {{ isset($category) && $category->id === $cat->id ? 'is-active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <span class="shop-count">{{ $products->total() }} {{ $products->total() === 1 ? 'product' : 'products' }}</span>
        </div>

        @if(request('search'))
            <div class="shop-search-note">
                <span>Showing results for “<strong>{{ request('search') }}</strong>”</span>
                <a href="{{ url()->current() }}">Clear search</a>
            </div>
        @endif

        <div class="shop-grid">
            @forelse($products as $product)
                <article class="shop-card">
                    <a href="{{ route('products.show', $product->id) }}" class="shop-media">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ $product->image_urls[0] }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="shop-noimg">
                                <svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="shop-badges">
                            @if($product->discount_percent)
                                <span class="shop-badge deal">-{{ $product->discount_percent }}%</span>
                            @endif
                            @if($product->stock_quantity < 1)
                                <span class="shop-badge out">Sold out</span>
                            @endif
                        </div>

                        <span class="shop-view">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Quick view
                        </span>
                    </a>

                    <div class="shop-body">
                        <div class="shop-cat">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        <a href="{{ route('products.show', $product->id) }}" class="shop-name">{{ $product->name }}</a>

                        @if($product->discount_percent && $product->discount_name)
                            <div class="shop-deal">{{ $product->discount_name }} · {{ $product->discount_percent }}% off</div>
                        @elseif($product->discount_percent)
                            <div class="shop-deal">{{ $product->discount_percent }}% off — limited time</div>
                        @elseif($product->discount_name)
                            <div class="shop-deal">{{ $product->discount_name }}</div>
                        @endif

                        <div class="shop-bottom">
                            <div class="shop-price">
                                @if($product->sale_price)
                                    <span class="now">{{ currencyFormat($product->final_price) }}</span>
                                    <span class="was">{{ currencyFormat($product->sale_price) }}</span>
                                @else
                                    <span class="now">{{ currencyFormat($product->price) }}</span>
                                @endif
                            </div>
                            @if($product->stock_quantity > 0)
                                <span class="shop-stock in">In stock</span>
                            @else
                                <span class="shop-stock out">Sold out</span>
                            @endif
                        </div>

                        <form class="shop-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            @if($product->stock_quantity > 0)
                                <button type="submit" class="shop-add">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                                    </svg>
                                    Add to cart
                                </button>
                            @else
                                <button type="button" class="shop-add is-disabled" disabled>Unavailable</button>
                            @endif
                        </form>
                    </div>
                </article>
            @empty
                <div class="shop-empty">
                    <div class="empty-ico" aria-hidden="true">
                        <svg width="21" height="21" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h2>No products found</h2>
                    <p>{{ isset($category) ? 'No products in this category yet — check back soon for new arrivals.' : 'Try a different search or browse the full collection to find what you need.' }}</p>
                    <a href="{{ route('products.index') }}" class="shop-empty-cta">
                        Browse all products
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m0 0l-6-6m6 6l-6 6"/>
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            @php
                $pageStart = max(1, $products->currentPage() - 2);
                $pageEnd = min($products->lastPage(), $pageStart + 4);
                $pageStart = max(1, $pageEnd - 4);
            @endphp
            <nav class="shop-pagination" aria-label="Pagination">
                @if($products->onFirstPage())
                    <span class="page-link is-disabled" aria-disabled="true" aria-label="Previous page">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                    </span>
                @else
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous page" rel="prev">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                    </a>
                @endif

                @for($page = $pageStart; $page <= $pageEnd; $page++)
                    @if($page === $products->currentPage())
                        <span class="page-link is-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor

                @if($products->hasMorePages())
                    <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next page" rel="next">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/>
                        </svg>
                    </a>
                @else
                    <span class="page-link is-disabled" aria-disabled="true" aria-label="Next page">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/>
                        </svg>
                    </span>
                @endif
            </nav>
        @endif
    </section>
@endsection
