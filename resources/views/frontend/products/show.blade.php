@extends('frontend.layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit(strip_tags($product->description), 160))
@section('canonical', route('products.show', $product->id))
@section('og_type', 'product')
@section('og_image', $product->images && count($product->images) > 0 ? $product->image_urls[0] : asset('logo.svg'))

@push('styles')
<style>
    /* ═══════════════ TOKENS / SHELL ═══════════════ */
    .pdp {
        --ink: #10261A;
        --muted: #617067;
        --green: #2E8B57;
        --green-deep: #17603C;
        --gold: #FFD166;
        --gold-light: #FFE08A;
        --mint: #9DF3BE;
        --line: #E4EEE8;
        --surface: #FFFFFF;
        --ease: cubic-bezier(0.22, 1, 0.36, 1);

        background: #F6FAF7;
        padding-bottom: 4.5rem;
    }
    .pdp-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* ─────────────── BREADCRUMB ─────────────── */
    .pdp-crumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.4375rem;
        padding-top: 1.25rem;
        font-size: 0.8125rem;
    }
    .pdp-crumb a {
        color: var(--muted);
        text-decoration: none;
        transition: color 0.25s var(--ease);
    }
    .pdp-crumb a:hover { color: var(--green-deep); }
    .pdp-crumb .sep { color: #B4C6BB; }
    .pdp-crumb .current {
        max-width: 24rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--ink);
        font-weight: 600;
    }

    /* ─────────────── MAIN GRID ─────────────── */
    .pdp-main {
        display: grid;
        grid-template-columns: minmax(0, 1.04fr) minmax(0, 1fr);
        gap: 3.5rem;
        align-items: start;
        margin-top: 1.75rem;
    }

    /* ─────────────── GALLERY ─────────────── */
    .pdp-gallery {
        position: sticky;
        top: 5.5rem;
        min-width: 0;
    }
    .pdp-stage {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        border-radius: 1.75rem;
        border: 1px solid var(--line);
        background: radial-gradient(circle at 50% 22%, #FFFFFF 0%, #EAF9EF 48%, #D8F2E2 100%);
        box-shadow: 0 34px 64px -48px rgba(10,60,38,0.5);
    }
    .pdp-stage img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1.75rem;
        transition: transform 0.6s var(--ease);
    }
    .pdp-stage:hover img { transform: scale(1.05); }
    .pdp-stage .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #B4C6BB;
    }
    .pdp-flags {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        z-index: 2;
    }
    .pdp-flag {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.3125rem 0.6875rem;
        border-radius: 9999px;
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }
    .pdp-flag.sale {
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        box-shadow: 0 10px 22px -12px rgba(255,209,102,0.95);
    }
    .pdp-flag.out {
        background: rgba(16,38,26,0.88);
        color: #F2FBF5;
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
    }
    .pdp-like {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.9);
        background: rgba(255,255,255,0.75);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: var(--muted);
        cursor: pointer;
        z-index: 2;
        box-shadow: 0 12px 26px -18px rgba(10,60,38,0.7);
        transition: color 0.28s var(--ease), background 0.28s var(--ease), transform 0.28s var(--ease);
    }
    .pdp-like:hover {
        color: #E11D48;
        background: #FFFFFF;
        transform: scale(1.08);
    }

    /* Thumbnails */
    .pdp-thumbs {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.625rem;
        margin-top: 0.75rem;
    }
    .pdp-thumbs .thumb {
        aspect-ratio: 1;
        padding: 0.25rem;
        border-radius: 0.875rem;
        border: 1.5px solid var(--line);
        background: var(--surface);
        overflow: hidden;
        cursor: pointer;
        transition: border-color 0.28s var(--ease), transform 0.28s var(--ease), box-shadow 0.28s var(--ease);
    }
    .pdp-thumbs .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.625rem;
    }
    .pdp-thumbs .thumb:hover {
        border-color: #B9E2C9;
        transform: translateY(-2px);
    }
    .pdp-thumbs .thumb.active {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(46,139,87,0.14);
    }

    /* ─────────────── DETAILS ─────────────── */
    .pdp-info { min-width: 0; }
    .pdp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--green);
        text-decoration: none;
        margin-bottom: 0.875rem;
        transition: color 0.25s var(--ease);
    }
    .pdp-eyebrow::before {
        content: '';
        width: 1.5rem;
        height: 1px;
        background: currentColor;
        opacity: 0.5;
    }
    .pdp-eyebrow:hover { color: var(--green-deep); }

    .pdp-info h1 {
        font-size: clamp(1.75rem, 3vw, 2.5rem);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -0.04em;
        color: var(--ink);
    }
    .pdp-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 0.9375rem;
    }
    .pdp-brand { font-size: 0.8125rem; color: var(--muted); }
    .pdp-brand span { color: var(--ink); font-weight: 600; }
    .pdp-rating {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .pdp-rating .stars { display: flex; gap: 0.0625rem; color: #F5B93C; }
    .pdp-rating .stars .empty { color: #E3EBE6; }
    .pdp-rating strong { color: var(--ink); font-weight: 700; }
    .pdp-rating a {
        color: var(--green-deep);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid rgba(23,96,60,0.3);
        transition: border-color 0.25s var(--ease);
    }
    .pdp-rating a:hover { border-color: var(--green-deep); }

    /* Price */
    .pdp-price {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
        padding: 1.25rem 1.5rem;
        border-radius: 1.25rem;
        border: 1px solid var(--line);
        background: linear-gradient(135deg, #FFFFFF 0%, #EDF9F2 100%);
        box-shadow: 0 26px 48px -40px rgba(10,60,38,0.45);
    }
    .pdp-price .amount {
        font-size: clamp(1.75rem, 2.6vw, 2.25rem);
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.04em;
        color: var(--ink);
    }
    .pdp-price .was {
        font-size: 1rem;
        color: #9AA79F;
        text-decoration: line-through;
    }
    .pdp-price .save {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        padding: 0.3125rem 0.6875rem;
        border-radius: 9999px;
        background: linear-gradient(135deg, #FFE08A, #FFD166 55%, #F5C14E);
        color: #12261B;
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        box-shadow: 0 8px 18px -10px rgba(255,209,102,0.9);
    }

    /* Stock */
    .pdp-stock-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .pdp-stock {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.4375rem 0.8125rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
    }
    .pdp-stock .dot {
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: currentColor;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.12);
    }
    .pdp-stock.in { background: #EDF9F2; border: 1px solid #D6F0E0; color: #166534; }
    .pdp-stock.low { background: #FFF8E6; border: 1px solid #FBE3AE; color: #8A5B00; }
    .pdp-stock.low .dot { box-shadow: 0 0 0 3px rgba(245,185,60,0.16); }
    .pdp-stock.out { background: #FEF2F2; border: 1px solid #FBD5D5; color: #B91C1C; }
    .pdp-stock.out .dot { box-shadow: 0 0 0 3px rgba(225,29,72,0.12); }
    .pdp-sku { margin-left: auto; font-size: 0.75rem; color: #93A39A; }

    .pdp-desc {
        margin-top: 1.375rem;
        max-width: 42rem;
        font-size: 0.9375rem;
        line-height: 1.8;
        color: var(--muted);
    }

    /* Add to cart */
    .pdp-cart { margin-top: 2rem; }
    .pdp-cart-row {
        display: flex;
        align-items: stretch;
        gap: 0.875rem;
    }
    .pdp-qty {
        display: flex;
        align-items: center;
        border: 1.5px solid var(--line);
        border-radius: 1rem;
        overflow: hidden;
        background: var(--surface);
        box-shadow: 0 18px 38px -28px rgba(10,60,38,0.7);
    }
    .pdp-qty button {
        width: 3rem;
        height: 3.5rem;
        border: none;
        background: transparent;
        color: var(--ink);
        font-size: 1.25rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.25s var(--ease), color 0.25s var(--ease);
    }
    .pdp-qty button:hover { background: #F0FAF4; color: var(--green-deep); }
    .pdp-qty button:active { background: #E6F7EE; }
    .pdp-qty input {
        width: 3.25rem;
        height: 3.5rem;
        border: none;
        border-left: 1.5px solid var(--line);
        border-right: 1.5px solid var(--line);
        background: linear-gradient(180deg, #F8FCFA 0%, #F2F9F6 100%);
        text-align: center;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 800;
        color: var(--ink);
        outline: none;
        -moz-appearance: textfield;
    }
    .pdp-qty input::-webkit-inner-spin-button,
    .pdp-qty input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .pdp-atc {
        position: relative;
        overflow: hidden;
        flex: 1;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        border: none;
        border-radius: 1rem;
        background: linear-gradient(135deg, #22C55E 0%, #16A34A 55%, #15803D 100%);
        color: #FFFFFF;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        cursor: pointer;
        box-shadow: 0 18px 40px -16px rgba(22,163,74,0.95), inset 0 1px 0 rgba(255,255,255,0.25);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease), filter 0.3s var(--ease);
    }
    .pdp-atc::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.4) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.8s var(--ease);
        pointer-events: none;
    }
    .pdp-atc:hover {
        transform: translateY(-3px);
        filter: brightness(1.02);
        box-shadow: 0 24px 48px -14px rgba(22,163,74,1), inset 0 1px 0 rgba(255,255,255,0.3);
    }
    .pdp-atc:hover::after { transform: translateX(420%) rotate(12deg); }
    .pdp-atc:active { transform: translateY(-1px); }
    .pdp-atc:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
        filter: none !important;
    }
    .pdp-atc svg { transition: transform 0.3s var(--ease); flex-shrink: 0; }
    .pdp-atc:hover svg { transform: translateX(3px); }

    /* Trust chips */
    .pdp-trust {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    .pdp-trust span {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.5rem 0.75rem;
        border-radius: 9999px;
        background: var(--surface);
        border: 1px solid var(--line);
        font-size: 0.75rem;
        font-weight: 600;
        color: #374151;
        transition: border-color 0.25s var(--ease), transform 0.25s var(--ease);
    }
    .pdp-trust span:hover { border-color: #B9E2C9; transform: translateY(-1px); }
    .pdp-trust svg { color: var(--green); flex-shrink: 0; }

    /* ─────────────── SECTIONS ─────────────── */
    .pdp-section {
        max-width: 1280px;
        margin: 3.75rem auto 0;
        padding: 0 1.5rem;
    }
    .pdp-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.75rem;
    }
    .pdp-section-head h2 {
        font-size: clamp(1.5rem, 2.6vw, 2.125rem);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -0.04em;
        color: var(--ink);
    }
    .pdp-section-head h2 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.025em;
        background: linear-gradient(100deg, #2E8B57 0%, #4EB47C 55%, #7BCB9B 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.04em;
    }
    .pdp-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--green-deep);
        text-decoration: none;
        padding-bottom: 0.1875rem;
        border-bottom: 1px solid rgba(23,96,60,0.25);
        transition: gap 0.25s var(--ease), border-color 0.25s var(--ease);
    }
    .pdp-link:hover { gap: 0.75rem; border-color: var(--green-deep); }

    .pdp-card {
        padding: 2rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
    }
    .pdp-prose {
        font-size: 0.9375rem;
        line-height: 1.85;
        color: #374151;
        max-width: 62rem;
    }

    /* ─────────────── REVIEWS ─────────────── */
    .pdp-avg {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4375rem 0.9375rem;
        border-radius: 9999px;
        background: #FFF8E6;
        border: 1px solid #FBE3AE;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #8A5B00;
    }
    .pdp-avg svg { color: #F5B93C; }

    .pdp-review {
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.25rem;
        transition: box-shadow 0.4s var(--ease), border-color 0.3s ease;
    }
    .pdp-review:hover {
        box-shadow: 0 26px 48px -38px rgba(10,60,38,0.45);
        border-color: #CFE9DA;
    }
    .pdp-reviewer {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .pdp-avatar {
        width: 2.5rem;
        height: 2.5rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #BFF3D2, #7BD9A1);
        color: #0A2C1C;
        font-size: 0.8125rem;
        font-weight: 800;
    }
    .pdp-reviewer-name {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--ink);
    }
    .pdp-reviewer-name small {
        margin-left: 0.5rem;
        font-size: 0.75rem;
        font-weight: 400;
        color: #93A39A;
    }
    .pdp-stars {
        display: flex;
        gap: 0.125rem;
        margin-top: 0.25rem;
    }
    .pdp-stars svg { width: 0.875rem; height: 0.875rem; }
    .pdp-stars .filled { color: #F5B93C; }
    .pdp-stars .empty { color: #E3EBE6; }
    .pdp-review-title {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #374151;
        margin-left: 0.375rem;
    }
    .pdp-review-body {
        margin-top: 0.875rem;
        font-size: 0.9375rem;
        line-height: 1.75;
        color: var(--muted);
    }
    .pdp-review-img { margin-top: 0.875rem; }
    .pdp-review-img img {
        max-width: 12rem;
        max-height: 8rem;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 1px solid var(--line);
    }
    .pdp-reply {
        margin-top: 1rem;
        padding: 1rem 1.25rem;
        border-radius: 0.875rem;
        background: #EDF9F2;
        border-left: 3px solid var(--green);
    }
    .pdp-reply .label {
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #166534;
        margin-bottom: 0.3125rem;
    }
    .pdp-reply .text {
        font-size: 0.875rem;
        line-height: 1.65;
        color: #374151;
    }
    .pdp-reply--form { background: #F6FAF7; border-left-color: #B9E2C9; }
    .pdp-reply--form .label { color: var(--green-deep); }
    .pdp-textarea {
        width: 100%;
        margin-top: 0.5rem;
        padding: 0.625rem 0.75rem;
        border: 1px solid var(--line);
        border-radius: 0.625rem;
        background: var(--surface);
        font-family: inherit;
        font-size: 0.8125rem;
        line-height: 1.5;
        color: var(--ink);
        resize: vertical;
        outline: none;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease);
    }
    .pdp-textarea:focus {
        border-color: #7BCB9B;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.10);
    }
    .pdp-reply-btn {
        margin-top: 0.5rem;
        padding: 0.5rem 0.9375rem;
        border: none;
        border-radius: 0.625rem;
        background: var(--green-deep);
        color: #F1FBF5;
        font-family: inherit;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.25s var(--ease), transform 0.25s var(--ease);
    }
    .pdp-reply-btn:hover { background: #1F7A4D; transform: translateY(-1px); }

    .pdp-empty {
        padding: 3.5rem 2rem;
        text-align: center;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
    }
    .pdp-empty .ico {
        width: 3.25rem;
        height: 3.25rem;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: var(--green);
    }
    .pdp-empty h3 {
        font-size: 1.125rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--ink);
        margin-bottom: 0.25rem;
    }
    .pdp-empty p { font-size: 0.875rem; color: var(--muted); }

    /* ─────────────── RELATED ─────────────── */
    .pdp-related-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.25rem;
    }
    .pdp-related {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.25rem;
        transition: transform 0.45s var(--ease), box-shadow 0.45s var(--ease), border-color 0.3s ease;
    }
    .pdp-related:hover {
        transform: translateY(-6px);
        box-shadow: 0 28px 52px -30px rgba(10,60,38,0.4);
        border-color: #B9E2C9;
    }
    .pdp-related .shot {
        position: relative;
        display: block;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #F1F7F3;
    }
    .pdp-related .shot img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s var(--ease);
    }
    .pdp-related:hover .shot img { transform: scale(1.08); }
    .pdp-related .shot .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #C3D4C9;
    }
    .pdp-related .flags {
        position: absolute;
        top: 0.625rem;
        left: 0.625rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        z-index: 2;
    }
    .pdp-related .flag {
        display: inline-flex;
        padding: 0.1875rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.5625rem;
        font-weight: 800;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }
    .pdp-related .flag.sale { background: var(--gold); color: #12261B; }
    .pdp-related .flag.out { background: rgba(16,38,26,0.88); color: #F2FBF5; }
    .pdp-related .body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 0.875rem 1rem 1rem;
    }
    .pdp-related .cat {
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--green);
        margin-bottom: 0.25rem;
    }
    .pdp-related .name {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.4em;
        font-size: 0.875rem;
        font-weight: 700;
        line-height: 1.35;
        letter-spacing: -0.015em;
        color: var(--ink);
        text-decoration: none;
        transition: color 0.25s var(--ease);
    }
    .pdp-related .name:hover { color: var(--green-deep); }
    .pdp-related .meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.375rem;
        font-size: 0.6875rem;
        color: var(--muted);
    }
    .pdp-related .meta .rate { display: inline-flex; align-items: center; gap: 0.125rem; color: #F5B93C; font-weight: 700; }
    .pdp-related .meta .in { color: #166534; font-weight: 600; }
    .pdp-related .meta .out { color: #B91C1C; font-weight: 600; }
    .pdp-related .price {
        display: flex;
        align-items: baseline;
        gap: 0.375rem;
        flex-wrap: wrap;
        margin-top: auto;
        padding-top: 0.625rem;
    }
    .pdp-related .price .now {
        font-size: 1.0625rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--ink);
    }
    .pdp-related .price .was {
        font-size: 0.75rem;
        color: #9AA79F;
        text-decoration: line-through;
    }
    .pdp-related .atc {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        width: 100%;
        margin-top: 0.625rem;
        padding: 0.5625rem;
        border: none;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #FFE08A, #FFD166 55%, #F5C14E);
        color: #12261B;
        font-family: inherit;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 10px 24px -14px rgba(255,209,102,0.9);
        transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
    }
    .pdp-related .atc:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 28px -14px rgba(255,209,102,1);
    }
    .pdp-related .atc:disabled,
    .pdp-related .atc.sold-out {
        background: #E8EFEB;
        color: #93A39A;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    /* ─────────────── REVEAL / MOTION ─────────────── */
    [data-reveal] {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.75s var(--ease), transform 0.75s var(--ease);
        transition-delay: var(--reveal-delay, 0s);
    }
    [data-reveal].is-visible {
        opacity: 1;
        transform: none;
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1100px) {
        .pdp-related-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 960px) {
        .pdp-main { grid-template-columns: 1fr; gap: 2rem; }
        .pdp-gallery { position: static; }
        .pdp-stage { border-radius: 1.25rem; }
        .pdp-info h1 { font-size: clamp(1.5rem, 4.6vw, 2rem); }
    }
    @media (max-width: 640px) {
        html, body { overflow-x: hidden; }
        .pdp { padding-bottom: 2.5rem; overflow-x: hidden; }
        .pdp-container { padding: 0 0.75rem; width: 100%; max-width: 100%; box-sizing: border-box; }
        .pdp-crumb { padding-top: 0.75rem; font-size: 0.6875rem; gap: 0.3125rem; flex-wrap: nowrap; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .pdp-crumb::-webkit-scrollbar { display: none; }
        .pdp-crumb .current { max-width: 10rem; }
        .pdp-main { gap: 1.5rem; margin-top: 1rem; }
        .pdp-gallery { width: 100%; max-width: 100%; }
        .pdp-stage { border-radius: 1rem; width: 100%; }
        .pdp-stage img { padding: 0.875rem; }
        .pdp-flags { top: 0.625rem; left: 0.625rem; gap: 0.1875rem; }
        .pdp-flag { padding: 0.1875rem 0.4375rem; font-size: 0.5rem; }
        .pdp-like { top: 0.625rem; right: 0.625rem; width: 2rem; height: 2rem; }
        .pdp-thumbs { grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.4375rem; margin-top: 0.625rem; }
        .pdp-thumbs .thumb { border-radius: 0.625rem; }
        .pdp-info { width: 100%; max-width: 100%; }
        .pdp-info h1 { font-size: clamp(1.25rem, 6.5vw, 1.625rem); }
        .pdp-eyebrow { font-size: 0.625rem; letter-spacing: 0.12em; margin-bottom: 0.625rem; }
        .pdp-meta { gap: 0.5rem; margin-top: 0.625rem; }
        .pdp-rating, .pdp-brand { font-size: 0.6875rem; }
        .pdp-price { padding: 0.75rem 0.875rem; border-radius: 0.875rem; gap: 0.5rem; flex-wrap: wrap; }
        .pdp-price .amount { font-size: clamp(1.375rem, 7.5vw, 1.75rem); }
        .pdp-price .was { font-size: 0.8125rem; }
        .pdp-price .save { margin-left: 0; font-size: 0.5625rem; padding: 0.1875rem 0.5rem; }
        .pdp-stock-row { gap: 0.4375rem; }
        .pdp-stock { font-size: 0.6875rem; padding: 0.3125rem 0.625rem; }
        .pdp-sku { margin-left: 0; width: 100%; order: 3; font-size: 0.6875rem; }
        .pdp-desc { margin-top: 0.875rem; font-size: 0.8125rem; line-height: 1.65; }
        .pdp-cart { margin-top: 1.125rem; }
        .pdp-cart-row { flex-direction: column; gap: 0.625rem; }
        .pdp-qty { align-self: stretch; width: 100%; border-radius: 0.875rem; }
        .pdp-qty button { width: 3rem; height: 3rem; font-size: 1.125rem; }
        .pdp-qty input { flex: 1; height: 3rem; font-size: 0.9375rem; }
        .pdp-atc { width: 100%; height: 3rem; font-size: 0.875rem; border-radius: 0.875rem; gap: 0.625rem; box-shadow: 0 16px 34px -14px rgba(22,163,74,0.9); }
        .pdp-trust { margin-top: 1rem; gap: 0.3125rem; }
        .pdp-trust span { font-size: 0.625rem; padding: 0.375rem 0.5rem; gap: 0.3125rem; }
        .pdp-section { margin-top: 2rem; padding: 0 0.75rem; width: 100%; max-width: 100%; box-sizing: border-box; }
        .pdp-section-head { margin-bottom: 1rem; gap: 0.75rem; }
        .pdp-section-head h2 { font-size: clamp(1.125rem, 6vw, 1.5rem); }
        .pdp-link { font-size: 0.75rem; }
        .pdp-card { padding: 1rem; border-radius: 0.875rem; }
        .pdp-prose { font-size: 0.8125rem; line-height: 1.7; }
        .pdp-avg { font-size: 0.6875rem; padding: 0.3125rem 0.75rem; }
        .pdp-review { padding: 0.875rem; border-radius: 0.875rem; margin-bottom: 0.75rem; }
        .pdp-reviewer { gap: 0.5rem; }
        .pdp-avatar { width: 2rem; height: 2rem; font-size: 0.6875rem; }
        .pdp-reviewer-name { font-size: 0.8125rem; }
        .pdp-reviewer-name small { display: block; margin-left: 0; margin-top: 0.0625rem; font-size: 0.6875rem; }
        .pdp-stars svg { width: 0.75rem; height: 0.75rem; }
        .pdp-review-title { font-size: 0.75rem; }
        .pdp-review-body { font-size: 0.8125rem; line-height: 1.65; margin-top: 0.625rem; }
        .pdp-review-img img { max-width: 100%; width: 100%; height: auto; border-radius: 0.625rem; }
        .pdp-reply { padding: 0.75rem 0.875rem; border-radius: 0.75rem; }
        .pdp-reply .label { font-size: 0.5625rem; }
        .pdp-reply .text { font-size: 0.8125rem; }
        .pdp-textarea { font-size: 0.8125rem; }
        .pdp-reply-btn { font-size: 0.75rem; padding: 0.4375rem 0.75rem; }
        .pdp-related-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.5rem; }
        .pdp-related { border-radius: 0.875rem; }
        .pdp-related .shot { aspect-ratio: 1 / 1; }
        .pdp-related .body { padding: 0.625rem; gap: 0.375rem; }
        .pdp-related .cat { font-size: 0.5rem; }
        .pdp-related .name { font-size: 0.75rem; line-height: 1.4; }
        .pdp-related .meta { font-size: 0.625rem; }
        .pdp-related .meta .rate { padding: 0.125rem 0.375rem; }
        .pdp-related .price { gap: 0.375rem; }
        .pdp-related .price .now { font-size: 0.8125rem; }
        .pdp-related .price .was { font-size: 0.6875rem; }
        .pdp-related .atc { font-size: 0.6875rem; height: 2rem; border-radius: 0.625rem; }
        .pdp-related .flags { top: 0.375rem; left: 0.375rem; }
        .pdp-related .flag { font-size: 0.5rem; padding: 0.125rem 0.375rem; }
        .pdp-empty { padding: 2rem 1rem; }
        .pdp-empty h3 { font-size: 1rem; }
        .pdp-empty p { font-size: 0.8125rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        [data-reveal] {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
        .pdp-stage img,
        .pdp-thumbs .thumb,
        .pdp-related,
        .pdp-related .shot img,
        .pdp-atc,
        .pdp-atc::after,
        .pdp-like,
        .pdp-trust span {
            transition: none !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $reviewCount = $product->reviews->count();
    $avgRating = $reviewCount ? $product->reviews->avg('rating') : 0;
    $avgRounded = (int) round($avgRating);
    $inStock = $product->stock_quantity > 0;
    $lowStock = $inStock && $product->stock_quantity <= 5;
@endphp

<div class="pdp">
    <div class="pdp-container">
        {{-- Breadcrumb --}}
        <nav class="pdp-crumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">›</span>
            <a href="{{ route('products.index') }}">Products</a>
            @if($product->category)
                <span class="sep">›</span>
                <a href="{{ route('products.byCategory', $product->category_id) }}">{{ $product->category->name }}</a>
            @endif
            <span class="sep">›</span>
            <span class="current">{{ $product->name }}</span>
        </nav>

        <div class="pdp-main">
            {{-- ══════ GALLERY ══════ --}}
            <div class="pdp-gallery" data-reveal>
                <div class="pdp-stage">
                    @if($product->images && count($product->images) > 0)
                        <img id="mainImage" src="{{ $product->image_urls[0] }}" alt="{{ $product->name }}">
                    @else
                        <div class="no-image">
                            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    @if($product->discount_percent || ! $inStock)
                        <div class="pdp-flags">
                            @if($product->discount_percent)
                                <span class="pdp-flag sale">−{{ $product->discount_percent }}% off</span>
                            @endif
                            @if(! $inStock)
                                <span class="pdp-flag out">Sold out</span>
                            @endif
                        </div>
                    @endif

                    @if($product->images && count($product->images) > 0)
                        <button class="pdp-like" title="Add to wishlist" aria-label="Add to wishlist">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                            </svg>
                        </button>
                    @endif
                </div>

                @if($product->images && count($product->images) > 1)
                    <div class="pdp-thumbs" id="thumbnails">
                        @foreach($product->images as $index => $image)
                            <div class="thumb {{ $index === 0 ? 'active' : '' }}" onclick="changeImage(this, '{{ config('app.storage_url') . ltrim(preg_replace('#^storage/#', '', $image), '/') }}')">
                                <img src="{{ config('app.storage_url') . ltrim(preg_replace('#^storage/#', '', $image), '/') }}" alt="{{ $product->name }} — view {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ══════ DETAILS ══════ --}}
            <div class="pdp-info" data-reveal style="--reveal-delay: 0.08s;">
                @if($product->category)
                    <a href="{{ route('products.byCategory', $product->category_id) }}" class="pdp-eyebrow">
                        {{ $product->category->name }}
                    </a>
                @endif

                <h1>{{ $product->name }}</h1>

                <div class="pdp-meta">
                    @if($product->brand)
                        <p class="pdp-brand">by <span>{{ $product->brand }}</span></p>
                    @endif

                    <span class="pdp-rating">
                        <span class="stars" aria-hidden="true">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="{{ $i <= $avgRounded ? '' : 'empty' }}" width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </span>
                        <strong>{{ number_format($avgRating, 1) }}</strong>
                        <a href="#reviews">({{ $reviewCount }} {{ \Illuminate\Support\Str::plural('review', $reviewCount) }})</a>
                    </span>
                </div>

                {{-- Price --}}
                <div class="pdp-price">
                    @if($product->sale_price)
                        @if($product->discount_percent)
                            <span class="amount">{{ currencyFormat($product->final_price) }}</span>
                            <span class="was">{{ currencyFormat($product->sale_price) }}</span>
                            <span class="save">Save {{ $product->discount_percent }}%</span>
                        @else
                            <span class="amount">{{ currencyFormat($product->sale_price) }}</span>
                            <span class="was">{{ currencyFormat($product->price) }}</span>
                        @endif
                    @else
                        <span class="amount">{{ currencyFormat($product->price) }}</span>
                    @endif
                </div>

                {{-- Stock --}}
                <div class="pdp-stock-row">
                    @if($inStock)
                        <span class="pdp-stock {{ $lowStock ? 'low' : 'in' }}">
                            <span class="dot" aria-hidden="true"></span>
                            {{ $lowStock ? 'Only '.$product->stock_quantity.' left in stock' : 'In stock ('.$product->stock_quantity.' available)' }}
                        </span>
                    @else
                        <span class="pdp-stock out">
                            <span class="dot" aria-hidden="true"></span>
                            Out of stock
                        </span>
                    @endif
                    @if($product->sku)
                        <span class="pdp-sku">SKU: {{ $product->sku }}</span>
                    @endif
                </div>

                @if($product->short_description)
                    <p class="pdp-desc">{{ $product->short_description }}</p>
                @endif

                {{-- Add to cart --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="pdp-cart">
                    @csrf
                    <div class="pdp-cart-row">
                        <div class="pdp-qty">
                            <button type="button" onclick="decrementQty()" aria-label="Decrease quantity">−</button>
                            <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ min($product->stock_quantity, 99) }}" readonly>
                            <button type="button" onclick="incrementQty()" aria-label="Increase quantity">+</button>
                        </div>
                        <button type="submit" class="pdp-atc" {{ $inStock ? '' : 'disabled' }}>
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                            </svg>
                            {{ $inStock ? 'Add to cart' : 'Out of stock' }}
                        </button>
                    </div>
                </form>

                {{-- Trust --}}
                <div class="pdp-trust">
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                        Secure checkout
                    </span>
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        Fast delivery
                    </span>
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                        100% genuine
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════ DESCRIPTION ══════ --}}
    @if($product->description)
        <section class="pdp-section" data-reveal>
            <div class="pdp-section-head">
                <h2>About this <em>product</em></h2>
            </div>
            <div class="pdp-card">
                <div class="pdp-prose">{!! nl2br(e($product->description)) !!}</div>
            </div>
        </section>
    @endif

    {{-- ══════ REVIEWS ══════ --}}
    <section class="pdp-section" id="reviews" data-reveal>
        <div class="pdp-section-head">
            <h2>Customer <em>reviews</em></h2>
            @if($reviewCount > 0)
                <span class="pdp-avg">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{ number_format($avgRating, 1) }} / 5 &middot; {{ $reviewCount }} {{ \Illuminate\Support\Str::plural('review', $reviewCount) }}
                </span>
            @endif
        </div>

        @if($reviewCount > 0)
            @foreach($product->reviews as $review)
                <article class="pdp-review">
                    <div class="pdp-reviewer">
                        <div class="pdp-avatar">{{ strtoupper(substr($review->guest_name ?? $review->user->name ?? 'A', 0, 1)) }}</div>
                        <div>
                            <p class="pdp-reviewer-name">
                                {{ $review->guest_name ?? $review->user->name ?? 'Anonymous' }}
                                <small>{{ $review->created_at->diffForHumans() }}</small>
                            </p>
                            <div class="pdp-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="{{ $i <= $review->rating ? 'filled' : 'empty' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                @if($review->title)
                                    <span class="pdp-review-title">— {{ $review->title }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p class="pdp-review-body">{{ $review->body }}</p>

                    @if($review->image)
                        <div class="pdp-review-img">
                            <img src="{{ $review->image_url }}" alt="Review image">
                        </div>
                    @endif

                    @if($review->admin_reply)
                        <div class="pdp-reply">
                            <p class="label">Store response</p>
                            <p class="text">{{ $review->admin_reply }}</p>
                        </div>
                    @elseif(auth()->check() && auth()->user()->is_admin)
                        <div class="pdp-reply pdp-reply--form">
                            <p class="label">Reply as store</p>
                            <form method="POST" action="{{ route('reviews.reply', $review->id) }}">
                                @csrf
                                <textarea class="pdp-textarea" name="admin_reply" rows="2" placeholder="Write your reply..."></textarea>
                                <button type="submit" class="pdp-reply-btn">Send reply</button>
                            </form>
                        </div>
                    @endif
                </article>
            @endforeach
        @else
            <div class="pdp-empty">
                <div class="ico">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                </div>
                <h3>No reviews yet</h3>
                <p>Be the first to share your thoughts on this product.</p>
            </div>
        @endif
    </section>

    {{-- ══════ RELATED ══════ --}}
    @if($relatedProducts->count() > 0)
        <section class="pdp-section" data-reveal>
            <div class="pdp-section-head">
                <h2>You may also <em>like</em></h2>
                <a href="{{ route('products.index') }}" class="pdp-link">
                    View all
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="pdp-related-grid">
                @foreach($relatedProducts as $related)
                    <article class="pdp-related">
                        <a href="{{ route('products.show', $related->id) }}" class="shot">
                            @if($related->images && count($related->images) > 0)
                                <img src="{{ $related->image_urls[0] }}" alt="{{ $related->name }}" loading="lazy">
                            @else
                                <div class="no-image">
                                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                            @if($related->discount_percent || $related->stock_quantity < 1)
                                <div class="flags">
                                    @if($related->discount_percent)
                                        <span class="flag sale">−{{ $related->discount_percent }}%</span>
                                    @endif
                                    @if($related->stock_quantity < 1)
                                        <span class="flag out">Sold out</span>
                                    @endif
                                </div>
                            @endif
                        </a>

                        <div class="body">
                            <div class="cat">{{ $related->category->name ?? 'Uncategorized' }}</div>
                            <a href="{{ route('products.show', $related->id) }}" class="name">{{ $related->name }}</a>

                            <div class="meta">
                                <span class="rate">
                                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ number_format($related->reviews->avg('rating') ?? 0, 1) }}
                                </span>
                                @if($related->stock_quantity > 0)
                                    <span class="in">● In stock</span>
                                @else
                                    <span class="out">● Out of stock</span>
                                @endif
                            </div>

                            <div class="price">
                                @if($related->sale_price)
                                    <span class="now">{{ currencyFormat($related->final_price) }}</span>
                                    <span class="was">{{ currencyFormat($related->sale_price) }}</span>
                                @else
                                    <span class="now">{{ currencyFormat($related->price) }}</span>
                                @endif
                            </div>

                            <form action="{{ route('cart.add', $related->id) }}" method="POST">
                                @csrf
                                @if($related->stock_quantity > 0)
                                    <button type="submit" class="atc">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                                        Add to cart
                                    </button>
                                @else
                                    <button type="button" class="atc sold-out" disabled>Unavailable</button>
                                @endif
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // ── Thumbnail switcher ──
    function changeImage(el, src) {
        var main = document.getElementById('mainImage');
        if (main) main.src = src;
        document.querySelectorAll('#thumbnails .thumb').forEach(function (t) {
            t.classList.remove('active');
        });
        el.classList.add('active');
    }

    // ── Quantity control ──
    function decrementQty() {
        var input = document.getElementById('qtyInput');
        var val = parseInt(input.value, 10) || 1;
        if (val > 1) input.value = val - 1;
    }
    function incrementQty() {
        var input = document.getElementById('qtyInput');
        var max = parseInt(input.max, 10) || 99;
        var val = parseInt(input.value, 10) || 1;
        if (val < max) input.value = val + 1;
    }

    // ── Reveal on scroll (same behaviour as the home page) ──
    (function () {
        var els = document.querySelectorAll('[data-reveal]');
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (reduceMotion || !('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

        els.forEach(function (el) { observer.observe(el); });
    })();
</script>
@endpush
