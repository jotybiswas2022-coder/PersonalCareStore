@extends('frontend.layouts.app')

@section('title', isset($order) ? 'Order ' . $order->order_number : (isset($orders) ? 'Your Orders' : 'Track Order'))

@php
    $lookupEmail = $email ?? old('email');

    if (isset($order)) {
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
    }
@endphp

@push('styles')
<style>
    .trk-page {
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
    .trk-hero {
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
    .trk-hero::before {
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
    .trk-hero .orb {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }
    .trk-hero .orb-1 {
        width: 420px;
        height: 420px;
        top: -200px;
        right: 2%;
        background: radial-gradient(circle, rgba(72,199,132,0.42), transparent 66%);
        animation: trkOrb 22s ease-in-out infinite;
    }
    .trk-hero .orb-2 {
        width: 320px;
        height: 320px;
        bottom: -180px;
        left: -60px;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        animation: trkOrb 28s ease-in-out infinite reverse;
    }
    .trk-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1120px;
        margin: 0 auto;
    }
    .trk-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.75rem;
        animation: trkFadeUp 0.6s var(--ease) 0.02s both;
    }
    .trk-back-link {
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
    .trk-back-link:hover {
        gap: 0.625rem;
        color: #FFFFFF;
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.26);
    }
    .trk-copy {
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
    .trk-copy:hover {
        background: rgba(255,209,102,0.22);
        border-color: rgba(255,209,102,0.55);
        color: #FFF4D2;
    }
    .trk-copy.is-copied {
        background: rgba(157,243,190,0.16);
        border-color: rgba(157,243,190,0.5);
        color: #D8FBE6;
    }
    .trk-eyebrow {
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
        animation: trkFadeUp 0.6s var(--ease) 0.06s both;
    }
    .trk-eyebrow .pulse {
        position: relative;
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #9DF3BE;
        flex-shrink: 0;
    }
    .trk-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(157,243,190,0.55);
        animation: trkPulse 2.4s ease-out infinite;
    }
    .trk-hero h1 {
        font-size: clamp(1.875rem, 4vw, 2.75rem);
        font-weight: 800;
        line-height: 1.06;
        letter-spacing: -0.045em;
        color: #FFFFFF;
        animation: trkFadeUp 0.6s var(--ease) 0.14s both;
    }
    .trk-hero h1 em {
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
    .trk-hero .trk-sub {
        max-width: 34rem;
        margin-top: 0.625rem;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.68);
        animation: trkFadeUp 0.6s var(--ease) 0.22s both;
    }
    .trk-hero .trk-sub strong {
        font-weight: 700;
        color: #FFE6A8;
        overflow-wrap: anywhere;
    }
    .trk-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1.25rem;
        animation: trkFadeUp 0.6s var(--ease) 0.3s both;
    }

    /* ─────────────── PILLS ─────────────── */
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

    /* ─────────────── WRAP ─────────────── */
    .trk-wrap {
        position: relative;
        z-index: 1;
        max-width: 1120px;
        margin: -2.75rem auto 0;
        padding: 0 1.5rem 4.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .trk-wrap.is-narrow {
        max-width: 720px;
    }
    .trk-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(0, 0.9fr);
        gap: 1.25rem;
        align-items: start;
    }
    .trk-main,
    .trk-side {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        min-width: 0;
    }
    .trk-side { position: sticky; top: 5.5rem; }

    /* ─────────────── CARDS ─────────────── */
    .trk-card {
        position: relative;
        overflow: hidden;
        padding: 1.5rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: trkCardIn 0.55s var(--ease) backwards;
    }
    .trk-main > .trk-card:nth-child(1) { animation-delay: 0.04s; }
    .trk-main > .trk-card:nth-child(2) { animation-delay: 0.1s; }
    .trk-side > .trk-card:nth-child(1) { animation-delay: 0.08s; }
    .trk-side > .trk-card:nth-child(2) { animation-delay: 0.14s; }
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

    /* ─────────────── SEARCH FORM ─────────────── */
    .search-card { padding: 2rem; }
    .search-ico {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        border-radius: 0.875rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: var(--green);
        transition: transform 0.35s var(--ease), background 0.3s var(--ease), color 0.3s var(--ease);
    }
    .search-card:hover .search-ico {
        transform: rotate(-6deg) scale(1.06);
        background: var(--green);
        color: #FFFFFF;
    }
    .search-card h2 {
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--ink);
    }
    .search-card .search-sub {
        margin-top: 0.3125rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        line-height: 1.65;
        color: var(--muted);
    }
    .trk-field { margin-bottom: 1rem; }
    .trk-field label {
        display: block;
        margin-bottom: 0.375rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.01em;
        color: #3A4A41;
    }
    .trk-field label .opt {
        color: #9BAF9F;
        font-weight: 500;
    }
    .trk-field input {
        width: 100%;
        padding: 0.75rem 0.9375rem;
        border: 1px solid var(--line);
        border-radius: 0.875rem;
        background: #FBFEFC;
        font-family: inherit;
        font-size: 0.875rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease);
    }
    .trk-field input::placeholder { color: #A3B3A9; }
    .trk-field input:focus {
        background: #FFFFFF;
        border-color: #8FD3AA;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.1);
    }
    .trk-field .err {
        margin-top: 0.3125rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #DC2626;
    }
    .trk-note {
        display: flex;
        align-items: flex-start;
        gap: 0.4375rem;
        margin-top: 1.125rem;
        padding-top: 1.125rem;
        border-top: 1px solid #F1F7F3;
        font-size: 0.75rem;
        line-height: 1.6;
        color: var(--muted);
    }
    .trk-note svg { flex-shrink: 0; margin-top: 0.125rem; color: #9BAF9F; }

    /* ─────────────── BUTTONS ─────────────── */
    .btn-gold {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        height: 3rem;
        padding: 0 1.375rem;
        border: none;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 14px 34px -16px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .btn-gold::after {
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
    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .btn-gold:hover::after { transform: translateX(420%) rotate(12deg); }
    .btn-gold svg { flex-shrink: 0; }

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
        color: #3A4A41;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease), gap 0.25s var(--ease);
    }
    .btn-ghost:hover {
        gap: 0.625rem;
        background: #F3FBF6;
        border-color: #B9E2C9;
        color: var(--green-deep);
    }

    .trk-actions { display: flex; justify-content: center; padding-top: 0.25rem; }

    /* ─────────────── ALERT ─────────────── */
    .alert-box {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.875rem 1rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        line-height: 1.55;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        animation: trkCardIn 0.5s var(--ease) backwards;
    }
    .alert-box svg { flex-shrink: 0; margin-top: 0.125rem; }
    .alert-box.alert-error {
        background: #FEF2F2;
        border: 1px solid #FBD5D5;
        color: #991B1B;
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
        animation: trkDot 1.9s ease-in-out infinite;
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
        max-width: 9rem;
        font-size: 0.6875rem;
        line-height: 1.45;
        color: #8A9A91;
    }
    .tl-step.cancelled .tl-desc { color: #DC2626; }

    /* ─────────────── ITEMS ─────────────── */
    .item-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }
    .item-row {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.75rem 0.875rem;
        border: 1px solid #F1F7F3;
        border-radius: 1rem;
        background: #FBFEFC;
        transition: border-color 0.3s var(--ease), background 0.3s var(--ease);
    }
    .item-row:hover {
        border-color: #D6F0E0;
        background: #F7FDF9;
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
    .empty-note {
        padding: 1.25rem;
        border: 1px dashed var(--line);
        border-radius: 1rem;
        text-align: center;
        font-size: 0.8125rem;
        color: var(--muted);
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
    .sum-total .lbl { font-size: 0.8125rem; font-weight: 700; color: var(--ink); }
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
    .sum-line .val { font-weight: 700; color: #3A4A41; }

    /* ─────────────── ADDRESS ─────────────── */
    .addr-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.875rem 1rem;
    }
    .addr-item.addr-full { grid-column: 1 / -1; }
    .addr-item .lbl {
        margin-bottom: 0.1875rem;
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8A9A91;
    }
    .addr-item .val {
        font-size: 0.8125rem;
        line-height: 1.6;
        color: #3A4A41;
        overflow-wrap: anywhere;
    }

    /* ─────────────── ORDER LIST ─────────────── */
    .trk-orders {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .trk-order {
        position: relative;
        overflow: hidden;
        padding: 1.125rem 1.25rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.25rem;
        box-shadow: 0 30px 60px -52px rgba(10,60,38,0.5);
        transition: transform 0.35s var(--ease), box-shadow 0.35s var(--ease), border-color 0.35s var(--ease);
        animation: trkCardIn 0.5s var(--ease) backwards;
    }
    .trk-order::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #7BCB9B 0%, #2E8B57 100%);
    }
    .trk-order:hover {
        transform: translateY(-3px);
        border-color: #B9E2C9;
        box-shadow: 0 36px 70px -48px rgba(10,60,38,0.6);
    }
    .trk-order .order-hit {
        position: absolute;
        inset: 0;
        z-index: 1;
        border-radius: inherit;
        text-decoration: none;
    }
    .trk-order .order-hit:focus-visible {
        outline: 2px solid #2E8B57;
        outline-offset: -3px;
    }
    .order-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .order-num {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        font-size: 0.9375rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--ink);
    }
    .order-num .dot {
        width: 0.4375rem;
        height: 0.4375rem;
        border-radius: 50%;
        background: #7BCB9B;
        box-shadow: 0 0 0 5px rgba(123,203,155,0.14);
    }
    .order-copy {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        padding: 0.1875rem 0.5rem;
        border-radius: 9999px;
        border: 1px solid var(--line);
        background: #FFFFFF;
        color: var(--green-deep);
        font-family: inherit;
        font-size: 0.6875rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.25s var(--ease), border-color 0.25s var(--ease), color 0.25s var(--ease);
    }
    .order-copy:hover {
        background: #F3FBF6;
        border-color: #B9E2C9;
    }
    .order-copy.is-copied {
        background: #F0FDF4;
        border-color: #BBF7D0;
        color: #166534;
    }
    .order-date {
        margin-top: 0.3125rem;
        font-size: 0.75rem;
        color: var(--muted);
    }
    .order-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-left: auto;
    }
    .order-amount {
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--green-deep);
        white-space: nowrap;
    }
    .order-go {
        display: inline-flex;
        color: #A3B3A9;
        transition: transform 0.3s var(--ease), color 0.3s var(--ease);
    }
    .trk-order:hover .order-go {
        transform: translateX(3px);
        color: var(--green);
    }

    /* Inline lookup */
    .inline-form { display: flex; gap: 0.625rem; align-items: flex-end; }
    .inline-form .trk-field { flex: 1; margin-bottom: 0; }
    .inline-form .btn-gold { width: auto; height: 2.75rem; white-space: nowrap; }
    .inline-hint {
        margin-top: 0.875rem;
        font-size: 0.75rem;
        color: var(--muted);
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1024px) {
        .trk-layout { grid-template-columns: 1fr; }
        .trk-side { position: static; }
    }
    @media (max-width: 640px) {
        .trk-hero { padding: 2rem 1rem 4rem; }
        .trk-wrap { padding: 0 1rem 3.5rem; margin-top: -2.25rem; gap: 1rem; }
        .trk-layout,
        .trk-main,
        .trk-side { gap: 1rem; }
        .trk-card { padding: 1.25rem; border-radius: 1.25rem; }
        .search-card { padding: 1.5rem 1.25rem; }
        .tl { gap: 0.25rem; }
        .tl::before { left: 1.25rem; right: 1.25rem; }
        .tl-icon { width: 2.125rem; height: 2.125rem; font-size: 0.6875rem; }
        .tl-lbl { font-size: 0.6875rem; }
        .tl-desc { display: none; }
        .addr-grid { grid-template-columns: 1fr; }
        .trk-order { padding: 1rem; }
        .order-top { flex-direction: column; }
        .order-right { margin-left: 0; width: 100%; justify-content: space-between; }
        .inline-form { flex-direction: column; align-items: stretch; }
        .inline-form .btn-gold { width: 100%; }
    }

    /* ─────────────── ANIMATIONS ─────────────── */
    @keyframes trkFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes trkCardIn {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes trkOrb {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(24px, -20px, 0) scale(1.08); }
    }
    @keyframes trkPulse {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @keyframes trkDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.25); opacity: 0.75; }
    }

    @media (prefers-reduced-motion: reduce) {
        .trk-hero .orb,
        .trk-eyebrow,
        .trk-eyebrow .pulse::after,
        .trk-hero h1,
        .trk-hero .trk-sub,
        .trk-chips,
        .trk-top,
        .trk-card,
        .trk-order,
        .alert-box,
        .tl-step.active .tl-icon .dot {
            animation: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="trk-page">
    <section class="trk-hero">
        <span class="orb orb-1" aria-hidden="true"></span>
        <span class="orb orb-2" aria-hidden="true"></span>
        <div class="trk-hero-inner">
            <div class="trk-top">
                <a href="{{ route('home') }}" class="trk-back-link">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
                    Continue shopping
                </a>
                @if(isset($order))
                    <button type="button" class="trk-copy" onclick="copyText('{{ $order->order_number }}', this)">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        <span class="copy-label">Copy order #</span>
                    </button>
                @endif
            </div>

            <span class="trk-eyebrow">
                <span class="pulse" aria-hidden="true"></span>
                Order tracking
            </span>

            @if(isset($order))
                <h1>Order <em>{{ $order->order_number }}</em></h1>
                <p class="trk-sub">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                <div class="trk-chips">
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
            @elseif(isset($orders))
                <h1>Your <em>orders</em></h1>
                <p class="trk-sub">Orders found for <strong>{{ $lookupEmail }}</strong></p>
            @else
                <h1>Track your <em>order</em></h1>
                <p class="trk-sub">Enter your email to see every order on it, or add an order number for a single order.</p>
            @endif
        </div>
    </section>

    <div class="trk-wrap {{ isset($order) || isset($orders) ? '' : 'is-narrow' }}">
        @if(session('error'))
            <div class="alert-box alert-error">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(isset($order))
            {{-- ─── Single order ─── --}}
            <div class="trk-layout">
                <div class="trk-main">
                    <div class="trk-card">
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

                    <div class="trk-card">
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
                                        <div class="item-info">
                                            <div class="item-name">{{ $item->product_name }}</div>
                                            <div class="item-meta">{{ currencyFormat($item->product_price) }} &times; {{ $item->quantity }}</div>
                                        </div>
                                        <div class="item-amount">{{ currencyFormat($item->subtotal) }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="empty-note">No items recorded for this order.</div>
                        @endif
                    </div>
                </div>

                <aside class="trk-side">
                    <div class="trk-card">
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

                    @if($order->shippingAddress)
                        <div class="trk-card">
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
                            </div>
                        </div>
                    @endif
                </aside>
            </div>

            <div class="trk-actions">
                <a href="{{ route('track-order.index') }}" class="btn-ghost">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
                    Track another order
                </a>
            </div>

        @elseif(isset($orders))
            {{-- ─── Order list ─── --}}
            <ul class="trk-orders">
                @foreach($orders as $o)
                    @php
                        $oPill = match($o->status) {
                            'pending' => 'pill-pending',
                            'processing' => 'pill-processing',
                            'shipped' => 'pill-shipped',
                            'delivered' => 'pill-delivered',
                            'cancelled' => 'pill-cancelled',
                            default => 'pill-neutral',
                        };
                    @endphp
                    <li class="trk-order">
                        <a class="order-hit" href="{{ route('track-order.show', ['id' => $o->id, 'email' => $lookupEmail]) }}"
                           aria-label="Track order {{ $o->order_number }}"></a>
                        <div class="order-top">
                            <div>
                                <div class="order-num">
                                    <span class="dot" aria-hidden="true"></span>
                                    {{ $o->order_number }}
                                    <button type="button" class="order-copy" onclick="copyText('{{ $o->order_number }}', this, true)">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                        Copy
                                    </button>
                                </div>
                                <div class="order-date">{{ $o->created_at->format('M d, Y \a\t h:i A') }}</div>
                            </div>
                            <div class="order-right">
                                <span class="pill {{ $oPill }}">{{ ucfirst($o->status) }}</span>
                                <span class="order-amount">{{ currencyFormat($o->total) }}</span>
                                <span class="order-go" aria-hidden="true">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="trk-card">
                <div class="card-head">
                    <h2>
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Have your order number?
                    </h2>
                    <span class="card-hint">Look up one order directly</span>
                </div>
                <form action="{{ route('track-order.lookup') }}" method="POST" class="inline-form">
                    @csrf
                    <input type="hidden" name="email" value="{{ $lookupEmail }}">
                    <div class="trk-field">
                        <label for="inline_order_number">Order number</label>
                        <input type="text" name="order_number" id="inline_order_number" value="{{ old('order_number') }}" placeholder="e.g. ORD-ABC123DEFG" required>
                    </div>
                    <button type="submit" class="btn-gold">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Search
                    </button>
                </form>
                <p class="inline-hint">Order numbers are on the confirmation we sent to your email.</p>
            </div>

            <div class="trk-actions">
                <a href="{{ route('track-order.index') }}" class="btn-ghost">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
                    Track with a different email
                </a>
            </div>

        @else
            {{-- ─── Search ─── --}}
            <div class="trk-card search-card">
                <div class="search-ico">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
                <h2>Find your order</h2>
                <p class="search-sub">Enter the email you used at checkout to see all of your orders, or add your order number to jump straight to one.</p>

                <form action="{{ route('track-order.lookup') }}" method="POST">
                    @csrf
                    <div class="trk-field">
                        <label for="order_number">Order number <span class="opt">(optional)</span></label>
                        <input type="text" name="order_number" id="order_number" value="{{ old('order_number') }}" placeholder="e.g. ORD-ABC123DEFG">
                        @error('order_number')<p class="err">{{ $message }}</p>@enderror
                    </div>
                    <div class="trk-field">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                        @error('email')<p class="err">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-gold">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Track order
                    </button>
                </form>

                <p class="trk-note">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <span>Order tracking covers guest checkouts placed with that email address.</span>
                </p>
            </div>

            <div class="trk-actions">
                <a href="{{ route('orders.index') }}" class="btn-ghost">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                    Signed in? View my orders
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyText(text, el, asButton) {
        function done() {
            if (!el) return;
            const originalHtml = el.innerHTML;
            const originalHtmlCopy = originalHtml;
            if (asButton) {
                el.classList.add('is-copied');
                el.innerHTML = '<svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied';
                setTimeout(function () {
                    el.innerHTML = originalHtmlCopy;
                    el.classList.remove('is-copied');
                }, 1600);
                return;
            }
            const label = el.querySelector('.copy-label') || el;
            const original = label.textContent;
            label.textContent = 'Copied!';
            el.classList.add('is-copied');
            setTimeout(function () {
                label.textContent = original;
                el.classList.remove('is-copied');
            }, 1800);
        }

        function fallback() {
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

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(done).catch(fallback);
        } else {
            fallback();
        }
    }
</script>
@endpush
