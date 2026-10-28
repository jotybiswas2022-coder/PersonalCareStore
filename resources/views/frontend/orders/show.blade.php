@extends('frontend.layouts.app')

@section('title', 'Order ' . $order->order_number)

@php
    $statusPill = match($order->status) {
        'pending' => 'pill-pending',
        'processing' => 'pill-processing',
        'shipped' => 'pill-shipped',
        'delivered' => 'pill-delivered',
        'cancelled' => 'pill-cancelled',
        default => 'pill-neutral',
    };

    $paymentPill = match($order->payment_status) {
        'paid', 'approved' => 'pill-delivered',
        'rejected', 'cancelled' => 'pill-cancelled',
        'pending', 'unpaid' => 'pill-pending',
        default => 'pill-neutral',
    };

    $paymentLabel = match($order->payment_status) {
        'paid' => 'Payment confirmed',
        'approved' => 'Payment approved',
        'pending' => 'Payment pending',
        'rejected' => 'Payment rejected',
        'cancelled' => 'Payment cancelled',
        default => 'Awaiting payment',
    };
@endphp

@push('styles')
<style>
    .od-page {
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
    .od-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 2rem 1.5rem 5rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 460px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            radial-gradient(520px 320px at 0% 100%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .od-hero::before {
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
    .od-hero .orb {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }
    .od-hero .orb-1 {
        width: 420px;
        height: 420px;
        top: -200px;
        right: 2%;
        background: radial-gradient(circle, rgba(72,199,132,0.42), transparent 66%);
        animation: odOrb 22s ease-in-out infinite;
    }
    .od-hero .orb-2 {
        width: 320px;
        height: 320px;
        bottom: -180px;
        left: -60px;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        animation: odOrb 28s ease-in-out infinite reverse;
    }
    .od-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1120px;
        margin: 0 auto;
    }
    .od-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.75rem;
        animation: odFadeUp 0.6s var(--ease) 0.02s both;
    }
    .od-back {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.4375rem 0.875rem 0.4375rem 0.6875rem;
        border-radius: 9999px;
        border: 1px solid rgba(255,255,255,0.14);
        background: rgba(255,255,255,0.06);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: rgba(233,247,238,0.86);
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease), color 0.28s var(--ease), gap 0.28s var(--ease);
    }
    .od-back:hover {
        gap: 0.625rem;
        color: #FFFFFF;
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.26);
    }
    .od-copy {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        padding: 0.4375rem 0.875rem;
        border-radius: 9999px;
        border: 1px solid rgba(255,209,102,0.35);
        background: rgba(255,209,102,0.12);
        color: #FFE6A8;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease), color 0.28s var(--ease);
    }
    .od-copy:hover {
        background: rgba(255,209,102,0.22);
        border-color: rgba(255,209,102,0.55);
        color: #FFF4D2;
    }
    .od-copy.is-copied {
        background: rgba(157,243,190,0.16);
        border-color: rgba(157,243,190,0.5);
        color: #D8FBE6;
    }
    .od-eyebrow {
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
        margin-bottom: 0.875rem;
        animation: odFadeUp 0.6s var(--ease) 0.06s both;
    }
    .od-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #9DF3BE;
        flex-shrink: 0;
    }
    .od-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(157,243,190,0.55);
        animation: odPulse 2.4s ease-out infinite;
    }
    .od-hero h1 {
        font-size: clamp(1.75rem, 3.6vw, 2.5rem);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -0.04em;
        color: #FFFFFF;
        animation: odFadeUp 0.6s var(--ease) 0.14s both;
    }
    .od-hero h1 em {
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
        word-break: break-word;
    }
    .od-hero .od-date {
        margin-top: 0.625rem;
        font-size: 0.875rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.68);
        animation: odFadeUp 0.6s var(--ease) 0.22s both;
    }
    .od-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1.25rem;
        animation: odFadeUp 0.6s var(--ease) 0.3s both;
    }

    /* ─────────────── BADGES ─────────────── */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.8125rem;
        border-radius: 9999px;
        border: 1px solid transparent;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1.5;
        text-transform: capitalize;
        white-space: nowrap;
    }
    .pill .sub {
        font-size: 0.6875rem;
        font-weight: 600;
        opacity: 0.8;
        text-transform: none;
    }
    .pill-pending { background: #FFF8E6; border-color: #FBE7B5; color: #8A5A00; }
    .pill-processing { background: #EFF6FF; border-color: #BFDBFE; color: #1E40AF; }
    .pill-shipped { background: #EEF2FF; border-color: #C7D2FE; color: #3730A3; }
    .pill-delivered { background: #EDF9F2; border-color: #BBF7D0; color: #166534; }
    .pill-cancelled { background: #FEF2F2; border-color: #FBD5D5; color: #991B1B; }
    .pill-neutral { background: #F4F7F5; border-color: #E4EEE8; color: #47554D; }

    /* ─────────────── LAYOUT ─────────────── */
    .od-wrap {
        position: relative;
        z-index: 1;
        max-width: 1120px;
        margin: -2.75rem auto 0;
        padding: 0 1.5rem 4.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .od-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(0, 0.9fr);
        gap: 1.25rem;
        align-items: start;
    }
    .od-main,
    .od-side {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        min-width: 0;
    }
    .od-side {
        position: sticky;
        top: 5.5rem;
    }

    /* ─────────────── CARDS ─────────────── */
    .od-card {
        position: relative;
        overflow: hidden;
        padding: 1.5rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: odCardIn 0.55s var(--ease) backwards;
    }
    .od-main > .od-card:nth-child(1) { animation-delay: 0.04s; }
    .od-main > .od-card:nth-child(2) { animation-delay: 0.1s; }
    .od-main > .od-card:nth-child(3) { animation-delay: 0.16s; }
    .od-main > .od-card:nth-child(4) { animation-delay: 0.22s; }
    .od-side > .od-card:nth-child(1) { animation-delay: 0.08s; }
    .od-side > .od-card:nth-child(2) { animation-delay: 0.14s; }
    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.125rem;
    }
    .card-head h2 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9375rem;
        font-weight: 800;
        letter-spacing: -0.015em;
        color: var(--ink);
    }
    .card-head h2 svg { color: var(--green); flex-shrink: 0; }
    .card-hint {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--muted);
    }

    /* ─────────────── TIMELINE ─────────────── */
    .tl {
        position: relative;
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    .tl::before {
        content: '';
        position: absolute;
        top: 1.25rem;
        left: 2rem;
        right: 2rem;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, #D6F0E0, #E7F0EA);
    }
    .tl-step {
        position: relative;
        z-index: 1;
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.5rem;
    }
    .tl-icon {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 2px solid #DCE9E2;
        background: #FFFFFF;
        color: #9BAF9F;
        font-size: 0.75rem;
        font-weight: 800;
        transition: background 0.3s var(--ease), border-color 0.3s var(--ease), color 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .tl-step.done .tl-icon {
        background: linear-gradient(135deg, #2E8B57 0%, #17603C 100%);
        border-color: transparent;
        color: #FFFFFF;
        box-shadow: 0 12px 24px -14px rgba(23,96,60,0.95);
    }
    .tl-step.active .tl-icon {
        background: #EDF9F2;
        border-color: var(--green);
        color: var(--green-deep);
        box-shadow: 0 0 0 6px rgba(46,139,87,0.12);
    }
    .tl-step.cancelled .tl-icon {
        background: #FEF2F2;
        border-color: #FCA5A5;
        color: #DC2626;
    }
    .tl-step.active .tl-icon .dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: var(--green);
        animation: odDot 1.9s ease-in-out infinite;
    }
    .tl-lbl {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: var(--muted);
    }
    .tl-step.done .tl-lbl,
    .tl-step.active .tl-lbl { color: var(--green-deep); }
    .tl-step.cancelled .tl-lbl { color: #DC2626; }
    .tl-desc {
        font-size: 0.6875rem;
        line-height: 1.45;
        color: #8A9A91;
        max-width: 8rem;
    }
    .tl-step.cancelled .tl-desc { color: #DC2626; }

    /* ─────────────── ITEMS ─────────────── */
    .item-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .item-row {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.75rem;
        border: 1px solid #F1F7F3;
        border-radius: 1rem;
        background: #FBFEFC;
        transition: border-color 0.3s var(--ease), background 0.3s var(--ease);
    }
    .item-row:hover {
        border-color: #D6F0E0;
        background: #F7FDF9;
    }
    .item-thumb {
        width: 3.25rem;
        height: 3.25rem;
        flex-shrink: 0;
        border-radius: 0.75rem;
        border: 1px solid var(--line);
        background: #F2F8F4;
        object-fit: cover;
    }
    .item-thumb.empty {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: #9BAF9F;
    }
    .item-info { min-width: 0; flex: 1; }
    .item-name {
        font-size: 0.875rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        color: var(--ink);
        overflow-wrap: anywhere;
    }
    .item-meta {
        margin-top: 0.1875rem;
        font-size: 0.75rem;
        color: var(--muted);
    }
    .item-amount {
        font-size: 0.875rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--green-deep);
        white-space: nowrap;
    }

    /* ─────────────── SUMMARY ─────────────── */
    .sum-rows { display: flex; flex-direction: column; gap: 0.625rem; }
    .sum-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 0.75rem;
        font-size: 0.8125rem;
    }
    .sum-row .lbl { color: var(--muted); }
    .sum-row .val { font-weight: 700; color: #3A4A41; }
    .sum-total {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 0.75rem;
        margin-top: 0.875rem;
        padding-top: 0.875rem;
        border-top: 1px dashed #DCE9E2;
    }
    .sum-total .lbl {
        font-size: 0.8125rem;
        font-weight: 700;
        color: var(--ink);
    }
    .sum-total .val {
        font-size: 1.375rem;
        font-weight: 800;
        letter-spacing: -0.035em;
        color: var(--green-deep);
    }
    .sum-foot {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #F1F7F3;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }
    .sum-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        font-size: 0.75rem;
        color: var(--muted);
    }
    .sum-line .val {
        font-weight: 700;
        color: #3A4A41;
    }

    /* ─────────────── ADDRESS ─────────────── */
    .addr-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.875rem 1rem;
    }
    .addr-item.addr-full { grid-column: 1 / -1; }
    .addr-item .lbl {
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8A9A91;
        margin-bottom: 0.1875rem;
    }
    .addr-item .val {
        font-size: 0.8125rem;
        line-height: 1.6;
        color: #3A4A41;
        overflow-wrap: anywhere;
    }

    /* ─────────────── PROOF ─────────────── */
    .proof-img {
        display: block;
        width: 100%;
        max-height: 22rem;
        object-fit: contain;
        margin-top: 0.875rem;
        padding: 0.5rem;
        border: 1px solid var(--line);
        border-radius: 1rem;
        background: #FBFEFC;
        cursor: pointer;
        transition: border-color 0.28s var(--ease), transform 0.28s var(--ease);
    }
    .proof-img:hover {
        border-color: #B9E2C9;
        transform: translateY(-2px);
    }

    /* ─────────────── ALERTS ─────────────── */
    .alert-box {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.875rem 1rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        line-height: 1.55;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: odCardIn 0.5s var(--ease) backwards;
    }
    .alert-box svg { flex-shrink: 0; margin-top: 0.125rem; }
    .alert-box.alert-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
    }
    .alert-box.alert-error {
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #991B1B;
    }

    /* ─────────────── BUTTONS ─────────────── */
    .btn-solid {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.875rem;
        padding: 0 1.25rem;
        border: none;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #2E8B57 0%, #17603C 100%);
        color: #FFFFFF;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 28px -16px rgba(23,96,60,0.9), inset 0 1px 0 rgba(255,255,255,0.18);
        transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
        cursor: pointer;
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
    .btn-solid svg { flex-shrink: 0; }

    .btn-gold {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 2.875rem;
        padding: 0 1.375rem;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 34px -16px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 38px -18px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .btn-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        height: 2.25rem;
        padding: 0 0.75rem;
        border-radius: 0.625rem;
        border: 1px solid #FBD5D5;
        background: #FEF2F2;
        color: #DC2626;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease);
    }
    .btn-soft:hover {
        background: #FEE2E2;
        border-color: #FCA5A5;
    }

    /* ─────────────── PAYMENT CTA ─────────────── */
    .pay-cta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1.25rem;
        border: 1px dashed #F5D48A;
        border-radius: 1rem;
        background: linear-gradient(135deg, #FFFAEC 0%, #FFF6DF 100%);
    }
    .pay-cta .pay-copy {
        min-width: 0;
        flex: 1;
    }
    .pay-cta .pay-copy strong {
        display: block;
        font-size: 0.875rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #6B4700;
    }
    .pay-cta .pay-copy span {
        display: block;
        margin-top: 0.1875rem;
        font-size: 0.75rem;
        line-height: 1.55;
        color: #8A5A00;
    }

    /* ─────────────── REVIEWS ─────────────── */
    .reviews-card { grid-column: 1 / -1; }
    .rv-block {
        padding: 1.125rem 0;
        border-bottom: 1px solid #F1F7F3;
    }
    .rv-block:first-of-type { padding-top: 0; }
    .rv-block:last-child { padding-bottom: 0; border-bottom: none; }
    .rv-prod {
        font-size: 0.875rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: var(--ink);
        margin-bottom: 0.75rem;
    }
    .rv-form .field { margin-bottom: 0.875rem; }
    .rv-form label {
        display: block;
        margin-bottom: 0.3125rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #3A4A41;
    }
    .rv-form select,
    .rv-form textarea {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1px solid var(--line);
        border-radius: 0.75rem;
        background: #FBFEFC;
        font-family: inherit;
        font-size: 0.8125rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease);
    }
    .rv-form select:focus,
    .rv-form textarea:focus {
        background: #FFFFFF;
        border-color: #8FD3AA;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.1);
    }
    .rv-form textarea { resize: vertical; min-height: 4.5rem; }
    .rv-form .file-input {
        font-size: 0.75rem;
        color: var(--muted);
    }
    .rv-form .cur-img {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }
    .rv-form .cur-img img {
        max-width: 5rem;
        border-radius: 0.5rem;
        border: 1px solid var(--line);
    }

    /* ─────────────── EMPTY ─────────────── */
    .items-empty {
        padding: 1.5rem;
        border: 1px dashed var(--line);
        border-radius: 1rem;
        text-align: center;
        font-size: 0.8125rem;
        color: var(--muted);
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1024px) {
        .od-layout { grid-template-columns: 1fr; }
        .od-side { position: static; }
    }
    @media (max-width: 640px) {
        .od-hero { padding: 1.5rem 1rem 4rem; }
        .od-wrap { padding: 0 1rem 3.5rem; margin-top: -2.25rem; gap: 1rem; }
        .od-layout,
        .od-main,
        .od-side { gap: 1rem; }
        .od-card { padding: 1.25rem; border-radius: 1.25rem; }
        .tl { gap: 0.25rem; }
        .tl::before { left: 1.25rem; right: 1.25rem; }
        .tl-icon { width: 2.125rem; height: 2.125rem; font-size: 0.6875rem; }
        .tl-lbl { font-size: 0.6875rem; }
        .tl-desc { display: none; }
        .item-row { padding: 0.625rem; gap: 0.75rem; }
        .item-thumb { width: 2.75rem; height: 2.75rem; }
        .item-name { font-size: 0.8125rem; }
        .addr-grid { grid-template-columns: 1fr; }
        .pay-cta { flex-direction: column; align-items: stretch; }
        .pay-cta .btn-gold { width: 100%; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes odFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes odCardIn {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes odOrb {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(24px, -20px, 0) scale(1.08); }
    }
    @keyframes odPulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @keyframes odDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.25); opacity: 0.75; }
    }

    @media (prefers-reduced-motion: reduce) {
        .od-hero .orb,
        .od-eyebrow,
        .od-hero h1,
        .od-hero .od-date,
        .od-chips,
        .od-top,
        .od-card,
        .alert-box,
        .tl-step.active .tl-icon .dot,
        .od-eyebrow .pulse::after {
            animation: none !important;
        }
        .btn-solid::after {
            transition: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="od-page">
    <section class="od-hero">
        <span class="orb orb-1" aria-hidden="true"></span>
        <span class="orb orb-2" aria-hidden="true"></span>
        <div class="od-hero-inner">
            <div class="od-top">
                <a href="{{ route('orders.index') }}" class="od-back">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
                    My orders
                </a>
                <button type="button" class="od-copy" onclick="copyOrder(this)">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                    <span id="copyLabel">Copy order #</span>
                </button>
            </div>

            <span class="od-eyebrow">
                <span class="pulse" aria-hidden="true"></span>
                Order details
            </span>
            <h1>Order <em>{{ $order->order_number }}</em></h1>
            <p class="od-date">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>

            <div class="od-chips">
                <span class="pill {{ $statusPill }}">
                    {{ ucfirst($order->status) }}
                    @if($order->status === 'cancelled' && $order->cancelled_by)
                        <span class="sub">by {{ $order->cancelled_by === 'user' ? 'You' : 'Admin' }}</span>
                    @endif
                </span>
                <span class="pill {{ $paymentPill }}">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    {{ $paymentLabel }}
                </span>
            </div>
        </div>
    </section>

    <div class="od-wrap">
        @if(session('success'))
            <div class="alert-box alert-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box alert-error">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="od-layout">
            <div class="od-main">
                {{-- Status + timeline --}}
                <div class="od-card">
                    <div class="card-head">
                        <h2>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Order journey
                        </h2>
                        <span class="card-hint">{{ $order->items->sum('quantity') }} item{{ $order->items->sum('quantity') === 1 ? '' : 's' }}</span>
                    </div>

                    @php
                        $steps = [
                            ['key' => 'placed', 'lbl' => 'Ordered', 'desc' => 'Order placed'],
                            ['key' => 'processing', 'lbl' => 'Processing', 'desc' => 'Preparing your order'],
                            ['key' => 'shipped', 'lbl' => 'Shipped', 'desc' => 'Out for delivery'],
                            ['key' => 'delivered', 'lbl' => 'Delivered', 'desc' => 'Order completed'],
                        ];
                        $statusOrder = ['pending' => 'placed', 'processing' => 'processing', 'shipped' => 'shipped', 'delivered' => 'delivered'];
                        $currentKey = $statusOrder[$order->status] ?? 'placed';
                        $isCancelled = $order->status === 'cancelled';
                        $reached = false;
                    @endphp

                    <div class="tl" role="list" aria-label="Order progress">
                        @foreach($steps as $i => $step)
                            @php
                                if ($isCancelled) {
                                    $cls = $i === 0 ? 'cancelled' : '';
                                } elseif ($step['key'] === $currentKey) {
                                    $cls = 'active';
                                    $reached = true;
                                } elseif (!$reached) {
                                    $cls = 'done';
                                } else {
                                    $cls = '';
                                }
                            @endphp
                            <div class="tl-step {{ $cls }}" role="listitem">
                                <div class="tl-icon">
                                    @if($isCancelled && $i === 0)
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    @elseif($cls === 'done')
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    @elseif($cls === 'active')
                                        <span class="dot" aria-hidden="true"></span>
                                    @else
                                        <span>{{ $i + 1 }}</span>
                                    @endif
                                </div>
                                @if($isCancelled && $i === 0)
                                    <div class="tl-lbl">Cancelled</div>
                                    <div class="tl-desc">This order was cancelled.</div>
                                @else
                                    <div class="tl-lbl">{{ $step['lbl'] }}</div>
                                    <div class="tl-desc">{{ $step['desc'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Items --}}
                <div class="od-card">
                    <div class="card-head">
                        <h2>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                            Items in this order
                        </h2>
                        <span class="card-hint">{{ $order->items->count() }} product{{ $order->items->count() === 1 ? '' : 's' }}</span>
                    </div>

                    @if($order->items->count() > 0)
                        <ul class="item-list">
                            @foreach($order->items as $item)
                                <li class="item-row">
                                    @if($item->product && $item->product->images && count($item->product->images) > 0)
                                        <img src="{{ $item->product->image_urls[0] }}" alt="{{ $item->product_name }}" class="item-thumb">
                                    @else
                                        <div class="item-thumb empty">N/A</div>
                                    @endif
                                    <div class="item-info">
                                        <div class="item-name">{{ $item->product_name }}</div>
                                        <div class="item-meta">{{ currencyFormat($item->product_price) }} &times; {{ $item->quantity }}</div>
                                    </div>
                                    <div class="item-amount">{{ currencyFormat($item->subtotal) }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="items-empty">No items recorded for this order.</div>
                    @endif
                </div>

                {{-- Payment proof --}}
                @if($order->proof_image)
                    <div class="od-card">
                        <div class="card-head">
                            <h2>
                                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Payment proof
                            </h2>
                            <span class="pill {{ $paymentPill }}">{{ $paymentLabel }}</span>
                        </div>
                        <div class="addr-grid">
                            <div class="addr-item addr-full">
                                <div class="lbl">Transaction ID</div>
                                <div class="val">{{ $order->transaction_id ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div style="position: relative; margin-top: 1rem;">
                            <a href="javascript:void(0);" onclick="openProofModal('{{ $order->proof_image_url }}')">
                                <img src="{{ $order->proof_image_url }}" alt="Payment proof" class="proof-img" style="cursor: zoom-in; max-width: 100%;">
                            </a>
                            <button type="button" onclick="openProofModal('{{ $order->proof_image_url }}')" style="position: absolute; bottom: 0.75rem; right: 0.75rem; background: rgba(0,0,0,0.8); color: white; border: none; padding: 0.375rem 0.875rem; border-radius: 0.5rem; font-size: 0.75rem; cursor: pointer; z-index: 10;">🔍 View Full Size</button>
                        </div>
                        @if($order->payment_status === 'paid' || $order->payment_status === 'pending')
                            <form action="{{ route('checkout.proof', $order->id) }}" method="POST" style="margin-top: 0.75rem;">
                                @csrf
                                <input type="hidden" name="transaction_id" value="{{ $order->transaction_id }}">
                                <input type="hidden" name="delete_proof" value="1">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete the payment proof?')" style="background: #dc2626; color: white; border: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.8125rem; cursor: pointer;">Delete Proof</button>
                            </form>
                        @endif
                    </div>
                @endif

                {{-- Submit payment --}}
                @if(($order->payment_status === 'unpaid' || $order->payment_status === 'pending') && $order->status !== 'cancelled')
                    <div class="od-card">
                        <div class="pay-cta">
                            <div class="pay-copy">
                                <strong>Payment still pending</strong>
                                <span>Upload your payment proof so we can confirm this order and start preparing it.</span>
                            </div>
                            <a href="{{ route('checkout.success', $order->id) }}" class="btn-gold">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                Submit payment proof
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <aside class="od-side">
                {{-- Summary --}}
                <div class="od-card">
                    <div class="card-head">
                        <h2>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Order summary
                        </h2>
                    </div>

                    <div class="sum-rows">
                        <div class="sum-row">
                            <span class="lbl">Subtotal</span>
                            <span class="val">{{ currencyFormat($order->subtotal) }}</span>
                        </div>
                        <div class="sum-row">
                            <span class="lbl">Shipping</span>
                            <span class="val">{{ currencyFormat($order->shipping_cost) }}</span>
                        </div>
                        <div class="sum-row">
                            <span class="lbl">VAT</span>
                            <span class="val">{{ currencyFormat($order->tax) }}</span>
                        </div>
                    </div>

                    <div class="sum-total">
                        <span class="lbl">Total</span>
                        <span class="val">{{ currencyFormat($order->total) }}</span>
                    </div>

                    <div class="sum-foot">
                        <div class="sum-line">
                            <span>Payment</span>
                            <span class="val">{{ $paymentLabel }}</span>
                        </div>
                        <div class="sum-line">
                            <span>Placed</span>
                            <span class="val">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping address --}}
                @if($order->shippingAddress)
                    <div class="od-card">
                        <div class="card-head">
                            <h2>
                                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Delivery details
                            </h2>
                        </div>
                        <div class="addr-grid">
                            <div class="addr-item addr-full">
                                <div class="lbl">Recipient</div>
                                <div class="val">{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</div>
                            </div>
                            <div class="addr-item addr-full">
                                <div class="lbl">Address</div>
                                <div class="val">
                                    {{ $order->shippingAddress->address_line1 }}
                                    @if($order->shippingAddress->address_line2)<br>{{ $order->shippingAddress->address_line2 }}@endif
                                </div>
                            </div>
                            <div class="addr-item">
                                <div class="lbl">City</div>
                                <div class="val">{{ $order->shippingAddress->city }}</div>
                            </div>
                            <div class="addr-item">
                                <div class="lbl">State / District</div>
                                <div class="val">{{ $order->shippingAddress->state ?? 'N/A' }}</div>
                            </div>
                            <div class="addr-item">
                                <div class="lbl">Postal code</div>
                                <div class="val">{{ $order->shippingAddress->postal_code }}</div>
                            </div>
                            <div class="addr-item">
                                <div class="lbl">Country</div>
                                <div class="val">{{ $order->shippingAddress->country }}</div>
                            </div>
                            <div class="addr-item">
                                <div class="lbl">Phone</div>
                                <div class="val">{{ $order->shippingAddress->phone }}</div>
                            </div>
                            <div class="addr-item">
                                <div class="lbl">Email</div>
                                <div class="val">{{ $order->shippingAddress->email }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </aside>

            {{-- Reviews --}}
            @if($order->status === 'delivered')
                <div class="od-card reviews-card">
                    <div class="card-head">
                        <h2>
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Rate your purchase
                        </h2>
                        <span class="card-hint">Delivered orders can be reviewed</span>
                    </div>

                    @foreach($order->items as $item)
                        @php $rv = $reviews->get($item->product_id); @endphp
                        <div class="rv-block">
                            <div class="rv-prod">{{ $item->product_name }}</div>
                            <form class="rv-form" method="POST" action="{{ $rv ? route('reviews.update', $rv->id) : route('reviews.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if($rv) @method('PUT') @endif
                                @if(!$rv)
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                @endif
                                <div class="field">
                                    <label for="rating_{{ $item->product_id }}">Rating <span style="color:#EF4444;">*</span></label>
                                    <select name="rating" id="rating_{{ $item->product_id }}" required>
                                        <option value="">Select</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $rv && $rv->rating == $i ? 'selected' : '' }}>{{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'][$i - 1] }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="body_{{ $item->product_id }}">Review <span style="color:#9BAF9F;font-weight:400;">(optional)</span></label>
                                    <textarea name="body" id="body_{{ $item->product_id }}" placeholder="Share your experience with this product...">{{ $rv->body ?? '' }}</textarea>
                                </div>
                                <div class="field">
                                    <label for="image_{{ $item->product_id }}">
                                        Image <span style="color:#9BAF9F;font-weight:400;">(optional)</span>
                                        @if($rv && $rv->image) <span style="color:#617067;font-weight:400;">— leave empty to keep current</span> @endif
                                    </label>
                                    <input type="file" name="image" id="image_{{ $item->product_id }}" accept="image/*" class="file-input">
                                    @if($rv && $rv->image_url)
                                        <div class="cur-img">
                                            <img src="{{ $rv->image_url }}" alt="Current review image">
                                            <button type="button" class="btn-soft" onclick="confirmDeleteImage({{ $rv->id }})">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H9a2 2 0 01-2-2V6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                Delete image
                                            </button>
                                            <form id="deleteImageForm-{{ $rv->id }}" method="POST" action="{{ route('reviews.deleteImage', $rv->id) }}" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" class="btn-solid">{{ $rv ? 'Update review' : 'Submit review' }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div id="proofModal" style="display:none; position:fixed; z-index:2147483647; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.98); align-items:center; justify-content:center;" onclick="closeProofModal()">
        <span style="position:absolute; top:10px; right:20px; color:white; font-size:40px; cursor:pointer; line-height:1; z-index:2147483647;">&times;</span>
        <img id="proofModalImg" src="" alt="Payment proof" style="max-width:95vw; max-height:95vh; margin:0 auto; display:block; border-radius:4px;" onclick="event.stopPropagation();">
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openProofModal(src) {
        document.getElementById('proofModalImg').src = src;
        document.getElementById('proofModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeProofModal() {
        document.getElementById('proofModal').style.display = 'none';
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeProofModal();
    });
    function copyOrder(btn) {
        const text = '{{ $order->order_number }}';
        const label = document.getElementById('copyLabel');

        function done() {
            if (!label) return;
            const original = label.textContent;
            label.textContent = 'Copied!';
            if (btn) btn.classList.add('is-copied');
            setTimeout(function () {
                label.textContent = original;
                if (btn) btn.classList.remove('is-copied');
            }, 1800);
        }

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(done).catch(function () { fallbackCopy(); });
        } else {
            fallbackCopy();
        }

        function fallbackCopy() {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); } catch (e) {}
            document.body.removeChild(ta);
            done();
        }
    }

    function confirmDeleteImage(reviewId) {
        Swal.fire({
            title: 'Delete review image?',
            text: 'Are you sure you want to delete this review image? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteImageForm-' + reviewId).submit();
            }
        });
    }
</script>
@endpush
