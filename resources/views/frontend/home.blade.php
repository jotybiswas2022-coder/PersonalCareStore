@extends('frontend.layouts.app')

@section('title', 'Home')

@push('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        color: #F2FBF5;
        padding: 4.25rem 0 0;
        background:
            radial-gradient(1100px 620px at 84% 6%, rgba(46,139,87,0.42), transparent 62%),
            radial-gradient(760px 480px at 0% 100%, rgba(255,209,102,0.10), transparent 68%),
            linear-gradient(158deg, #07301E 0%, #062718 46%, #03190F 100%);
    }
    .hero-bg {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }
    .hero-bg .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(72px);
    }
    .hero-bg .orb-1 {
        width: 480px;
        height: 480px;
        top: -160px;
        right: 2%;
        background: radial-gradient(circle, rgba(72,199,132,0.55), transparent 66%);
        animation: orbFloat 22s ease-in-out infinite;
    }
    .hero-bg .orb-2 {
        width: 340px;
        height: 340px;
        bottom: -130px;
        left: -70px;
        background: radial-gradient(circle, rgba(255,209,102,0.30), transparent 68%);
        animation: orbFloat 28s ease-in-out infinite reverse;
    }
    .hero-bg .orb-3 {
        width: 280px;
        height: 280px;
        top: 38%;
        left: 44%;
        background: radial-gradient(circle, rgba(46,139,87,0.38), transparent 70%);
        animation: orbFloat 18s ease-in-out infinite;
    }
    .hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 76px 76px;
        -webkit-mask-image: radial-gradient(circle at 50% 42%, #000 0%, transparent 74%);
        mask-image: radial-gradient(circle at 50% 42%, #000 0%, transparent 74%);
    }
    .hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.02fr) minmax(0, 0.98fr);
        align-items: center;
        gap: 3.5rem;
        padding: 0 1.5rem 3.25rem;
    }
    .hero-copy { position: relative; }

    /* Eyebrow */
    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        border-radius: 9999px;
        padding: 0.375rem 0.9375rem 0.375rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 500;
        letter-spacing: 0.01em;
        color: rgba(233,247,238,0.88);
        margin-bottom: 1.75rem;
        opacity: 0;
        animation: heroFadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) 0.05s forwards;
    }
    .hero-eyebrow .pulse {
        position: relative;
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: #7BF1A8;
        flex-shrink: 0;
    }
    .hero-eyebrow .pulse::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1px solid rgba(123,241,168,0.55);
        animation: pulseRing 2.2s ease-out infinite;
    }
    .hero-eyebrow .tag {
        background: #FFD166;
        color: #08251A;
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        padding: 0.1875rem 0.4375rem;
        border-radius: 9999px;
    }

    /* Headline */
    .hero-title {
        font-size: clamp(2.5rem, 4.9vw, 4rem);
        font-weight: 800;
        line-height: 1.02;
        letter-spacing: -0.045em;
        margin-bottom: 1.35rem;
        color: #FFFFFF;
    }
    .hero-title .line {
        display: block;
        overflow: hidden;
        padding-bottom: 0.06em;
    }
    .hero-title .line > span {
        display: block;
        transform: translateY(115%);
        animation: lineUp 1.05s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .hero-title .line:nth-child(1) > span { animation-delay: 0.18s; }
    .hero-title .line:nth-child(2) > span { animation-delay: 0.3s; }
    .hero-title .line:nth-child(3) > span { animation-delay: 0.42s; }
    .hero-title em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.025em;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 42%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.06em;
    }
    .hero-sub {
        font-size: 1.0625rem;
        line-height: 1.75;
        color: rgba(226,245,232,0.72);
        max-width: 30rem;
        margin-bottom: 2rem;
        opacity: 0;
        animation: heroFadeUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.55s forwards;
    }

    /* Actions */
    .hero-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        opacity: 0;
        animation: heroFadeUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.68s forwards;
    }
    .hero-actions .btn-primary {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        padding: 1rem 1.875rem;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.9375rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        text-decoration: none;
        overflow: hidden;
        box-shadow: 0 14px 34px -12px rgba(255,209,102,0.65), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease;
    }
    .hero-actions .btn-primary::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.75) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.75s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .hero-actions .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px -14px rgba(255,209,102,0.8), inset 0 1px 0 rgba(255,255,255,0.6);
    }
    .hero-actions .btn-primary:hover::after { transform: translateX(420%) rotate(12deg); }
    .hero-actions .btn-primary svg { transition: transform 0.3s ease; }
    .hero-actions .btn-primary:hover svg { transform: translateX(4px); }
    .hero-actions .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 0.5625rem;
        padding: 1rem 1.5rem;
        border-radius: 0.875rem;
        border: 1px solid rgba(255,255,255,0.22);
        background: rgba(255,255,255,0.05);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: #EAF8EF;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
    }
    .hero-actions .btn-ghost:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.34);
        transform: translateY(-3px);
    }
    .hero-actions .btn-ghost .dot-ic {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(123,241,168,0.16);
        color: #9DF3BE;
    }

    /* Trust row */
    .hero-trust {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.09);
        opacity: 0;
        animation: heroFadeUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.8s forwards;
    }
    .avatar-stack { display: flex; }
    .avatar-stack .av {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        border: 2px solid #072E1D;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6875rem;
        font-weight: 700;
        color: #0A2C1C;
        margin-left: -0.625rem;
    }
    .avatar-stack .av:first-child { margin-left: 0; }
    .avatar-stack .av-1 { background: linear-gradient(135deg, #BFF3D2, #7BD9A1); }
    .avatar-stack .av-2 { background: linear-gradient(135deg, #FFE6A8, #FFD166); }
    .avatar-stack .av-3 { background: linear-gradient(135deg, #D5F5DF, #9DE8B8); }
    .avatar-stack .av-more {
        background: rgba(255,255,255,0.12);
        color: #EAF8EF;
        font-size: 0.625rem;
    }
    .trust-text .stars {
        display: flex;
        gap: 0.125rem;
        color: #FFD166;
        margin-bottom: 0.1875rem;
    }
    .trust-text p {
        font-size: 0.75rem;
        color: rgba(226,245,232,0.66);
    }
    .trust-text p strong { color: #FFFFFF; font-weight: 700; }

    /* Visual stage */
    .hero-stage {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin-left: auto;
        aspect-ratio: 1 / 1.04;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        animation: stageIn 1.1s cubic-bezier(0.22, 1, 0.36, 1) 0.35s forwards;
    }
    .stage-halo {
        position: absolute;
        width: 88%;
        aspect-ratio: 1;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(123,227,168,0.26) 0%, rgba(46,139,87,0.10) 42%, transparent 68%);
        filter: blur(6px);
        animation: haloPulse 7s ease-in-out infinite;
    }
    .stage-ring {
        position: absolute;
        width: 82%;
        aspect-ratio: 1;
        border-radius: 50%;
        border: 1px dashed rgba(255,255,255,0.16);
        animation: spin 48s linear infinite;
    }
    .stage-ring.inner {
        width: 64%;
        border-style: solid;
        border-color: rgba(255,209,102,0.18);
        animation: spin 34s linear infinite reverse;
    }
    .stage-glow {
        position: absolute;
        width: 46%;
        aspect-ratio: 1;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        filter: blur(18px);
        top: 4%;
        right: 8%;
        animation: haloPulse 9s ease-in-out infinite reverse;
    }

    /* Product card */
    .product-card {
        position: relative;
        z-index: 3;
        width: min(62%, 268px);
        padding: 0.875rem;
        border-radius: 1.5rem;
        background: linear-gradient(165deg, rgba(255,255,255,0.99) 0%, rgba(240,253,244,0.96) 100%);
        box-shadow:
            0 34px 60px -24px rgba(0,0,0,0.65),
            0 0 0 1px rgba(255,255,255,0.55) inset;
        rotate: -2.5deg;
        animation: floatCard 8s ease-in-out infinite;
    }
    .product-card .pc-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.625rem;
        padding: 0 0.125rem;
    }
    .product-card .pc-tag {
        font-size: 0.5625rem;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: #17603C;
        background: #E4F7EC;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }
    .product-card .pc-rate {
        display: inline-flex;
        align-items: center;
        gap: 0.1875rem;
        font-size: 0.6875rem;
        font-weight: 700;
        color: #2C3A32;
    }
    .product-card .pc-rate svg { color: #F5B93C; }
    .product-card .pc-shot {
        position: relative;
        aspect-ratio: 1 / 1.04;
        border-radius: 1.125rem;
        overflow: hidden;
        background:
            radial-gradient(circle at 50% 26%, #FFFFFF 0%, #EAF9EF 46%, #D3F1DE 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-card .pc-shot::before {
        content: '';
        position: absolute;
        width: 74%;
        aspect-ratio: 1;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.95), rgba(255,255,255,0) 70%);
        top: 6%;
    }
    .product-card .pc-shot::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(115deg, transparent 38%, rgba(255,255,255,0.55) 50%, transparent 62%);
        transform: translateX(-120%);
        animation: shotShine 7s ease-in-out 1.2s infinite;
    }
    .product-card .bottle {
        position: relative;
        z-index: 1;
        height: 84%;
        width: auto;
        filter: drop-shadow(0 14px 18px rgba(20,80,50,0.22));
        animation: bottleBob 8s ease-in-out infinite;
    }
    .product-card .pc-meta {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 0.5rem;
        padding: 0.75rem 0.25rem 0.625rem;
    }
    .product-card .pc-cat {
        font-size: 0.5625rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #2E8B57;
        margin-bottom: 0.125rem;
    }
    .product-card .pc-name {
        font-size: 0.875rem;
        font-weight: 700;
        color: #10261A;
        letter-spacing: -0.015em;
        line-height: 1.25;
    }
    .product-card .pc-price {
        font-size: 0.8125rem;
        font-weight: 800;
        color: #10261A;
        white-space: nowrap;
    }
    .product-card .pc-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        padding: 0.625rem;
        border-radius: 0.75rem;
        background: #0E3D27;
        color: #F1FBF5;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.25s ease;
    }
    .product-card .pc-cta:hover { background: #15603C; }

    /* Floating cards */
    .float-card {
        position: absolute;
        z-index: 4;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.6875rem 0.8125rem;
        border-radius: 1rem;
        background: rgba(9,42,28,0.72);
        border: 1px solid rgba(255,255,255,0.14);
        -webkit-backdrop-filter: blur(14px);
        backdrop-filter: blur(14px);
        box-shadow: 0 18px 34px -18px rgba(0,0,0,0.7);
        color: #F2FBF5;
    }
    .float-card .fc-ic {
        width: 2.125rem;
        height: 2.125rem;
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .float-card .fc-ic.green { background: rgba(123,241,168,0.16); color: #9DF3BE; }
    .float-card .fc-ic.gold { background: rgba(255,209,102,0.18); color: #FFD166; }
    .float-card .fc-title {
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1.25;
        white-space: nowrap;
    }
    .float-card .fc-sub {
        font-size: 0.625rem;
        color: rgba(226,245,232,0.62);
        line-height: 1.3;
        white-space: nowrap;
    }
    .float-card .fc-stars { display: flex; gap: 0.0625rem; color: #FFD166; margin-bottom: 0.125rem; }
    .float-rating {
        top: 3%;
        right: -2%;
        animation: floatSoft 7s ease-in-out infinite;
    }
    .float-delivery {
        bottom: 1%;
        left: -7%;
        animation: floatSoft 8.5s ease-in-out 1.2s infinite;
    }
    .float-chip {
        bottom: -2%;
        right: -1%;
        padding: 0.5rem 0.8125rem;
        gap: 0.375rem;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #EAF8EF;
        animation: floatSoft 6.5s ease-in-out 0.6s infinite;
    }
    .float-chip svg { color: #9DF3BE; }
    .hero-stage [data-depth] { transition: translate 0.35s cubic-bezier(0.22, 1, 0.36, 1); }

    /* Rotating seal */
    .hero-seal {
        position: absolute;
        top: 9%;
        left: -5%;
        width: 6.25rem;
        height: 6.25rem;
        z-index: 4;
        animation: floatSoft 9s ease-in-out infinite;
    }
    .hero-seal .seal-ring {
        width: 100%;
        height: 100%;
        animation: spin 26s linear infinite;
    }
    .hero-seal .seal-core {
        position: absolute;
        inset: 33%;
        border-radius: 50%;
        background: linear-gradient(135deg, #FFD166, #F0C14B);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0A2C1C;
        box-shadow: 0 8px 20px -6px rgba(255,209,102,0.7);
    }

    /* Sparkles */
    .spark {
        position: absolute;
        width: 0.375rem;
        height: 0.375rem;
        border-radius: 50%;
        background: #FFD166;
        opacity: 0;
        animation: twinkle 4s ease-in-out infinite;
    }
    .spark.s1 { top: 18%; right: 26%; animation-delay: 0.4s; }
    .spark.s2 { top: 46%; left: 2%; background: #9DF3BE; animation-delay: 1.6s; }
    .spark.s3 { bottom: 22%; right: 3%; animation-delay: 2.4s; }
    .spark.s4 { bottom: 34%; left: 26%; width: 0.25rem; height: 0.25rem; animation-delay: 3.1s; }

    /* Marquee */
    .hero-marquee {
        position: relative;
        z-index: 1;
        border-top: 1px solid rgba(255,255,255,0.08);
        background: rgba(255,255,255,0.03);
        overflow: hidden;
        padding: 0.9375rem 0;
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
        mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
    }
    .hero-marquee .track {
        display: flex;
        align-items: center;
        width: max-content;
        animation: marquee 32s linear infinite;
    }
    .hero-marquee .m-set {
        display: flex;
        align-items: center;
        gap: 2.5rem;
        padding-right: 2.5rem;
    }
    .hero-marquee .track span {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(233,247,238,0.62);
        white-space: nowrap;
    }
    .hero-marquee .track svg { color: #FFD166; flex-shrink: 0; }

    /* Keyframes */
    @keyframes lineUp {
        to { transform: translateY(0); }
    }
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes stageIn {
        from { opacity: 0; transform: translateY(28px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes orbFloat {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(26px, -22px, 0) scale(1.08); }
    }
    @keyframes pulseRing {
        0% { opacity: 0.7; transform: scale(0.8); }
        70%, 100% { opacity: 0; transform: scale(1.9); }
    }
    @keyframes haloPulse {
        0%, 100% { opacity: 0.75; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.06); }
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    @keyframes floatCard {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
    @keyframes bottleBob {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-6px) rotate(-1deg); }
    }
    @keyframes floatSoft {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-9px); }
    }
    @keyframes twinkle {
        0%, 100% { opacity: 0; transform: scale(0.4); }
        50% { opacity: 0.9; transform: scale(1); }
    }
    @keyframes shotShine {
        0%, 62% { transform: translateX(-120%); }
        88%, 100% { transform: translateX(120%); }
    }
    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1100px) {
        .hero { padding-top: 3.5rem; }
        .hero-inner { gap: 2.25rem; }
        .hero-stage { max-width: 430px; }
        .hero-seal { width: 5.25rem; height: 5.25rem; }
    }
    @media (max-width: 900px) {
        .hero { padding: 3rem 0 0; }
        .hero-inner {
            grid-template-columns: 1fr;
            gap: 2.75rem;
            text-align: center;
            padding: 0 1.25rem 2.5rem;
        }
        .hero-copy { display: flex; flex-direction: column; align-items: center; }
        .hero-sub { margin-left: auto; margin-right: auto; }
        .hero-actions { justify-content: center; }
        .hero-trust { justify-content: center; text-align: left; }
        .hero-stage { margin: 0 auto; max-width: 420px; }
        .product-card { width: min(60%, 258px); }
        .product-card .pc-rate { display: none; }
        .float-rating { top: -1%; right: -3%; scale: 0.9; }
        .float-delivery { display: none; }
    }
    @media (max-width: 560px) {
        .hero { padding: 2.25rem 0 0; }
        .hero-inner { padding: 0 1rem 2rem; }
        .hero-title { font-size: clamp(2.1rem, 9vw, 2.75rem); }
        .hero-sub { font-size: 0.9375rem; }
        .hero-eyebrow { font-size: 0.75rem; margin-bottom: 1.25rem; }
        .hero-actions { width: 100%; flex-direction: column; align-items: stretch; max-width: 20rem; }
        .hero-actions .btn-primary,
        .hero-actions .btn-ghost { width: 100%; justify-content: center; }
        .hero-trust { flex-direction: column; gap: 0.75rem; align-items: center; text-align: center; }
        .hero-stage { max-width: 330px; }
        .product-card { width: 60%; padding: 0.6875rem; border-radius: 1.15rem; }
        .product-card .pc-meta { padding: 0.5rem 0.125rem; }
        .product-card .pc-name { font-size: 0.75rem; }
        .product-card .pc-price { font-size: 0.6875rem; }
        .product-card .pc-cta { font-size: 0.6875rem; padding: 0.5rem; }
        .float-rating { top: 1%; right: -2%; scale: 0.84; }
        .float-delivery { display: none; }
        .float-chip { display: none; }
        .hero-seal { width: 4.5rem; height: 4.5rem; top: 0; left: 0; }
        .hero-marquee .m-set { gap: 1.75rem; padding-right: 1.75rem; }
        .hero-marquee .track span { font-size: 0.625rem; letter-spacing: 0.1em; }
    }
    @media (prefers-reduced-motion: reduce) {
        .hero-eyebrow,
        .hero-title .line > span,
        .hero-sub,
        .hero-actions,
        .hero-trust,
        .hero-stage {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
        }
        .hero-bg .orb,
        .stage-halo,
        .stage-ring,
        .stage-glow,
        .product-card,
        .product-card .bottle,
        .product-card .pc-shot::after,
        .float-card,
        .hero-seal,
        .hero-seal .seal-ring,
        .spark,
        .hero-marquee .track {
            animation: none !important;
        }
    }

    /* ─────────────── STATS ─────────────── */
    .stats-bar {
        background: #ffffff;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        padding: 2.5rem 1.5rem;
    }
    .stats-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
        text-align: center;
    }
    .stat-item .stat-num {
        font-size: 2rem;
        font-weight: 800;
        color: #2E8B57;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-item .stat-label {
        font-size: 0.8125rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* ─────────────── FEATURES ─────────────── */
    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }
    .section-title h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }
    .section-title p {
        color: #6b7280;
        max-width: 32rem;
        margin: 0 auto;
        font-size: 0.9375rem;
        line-height: 1.6;
    }
    .features-section {
        padding: 4.5rem 1.5rem;
        background: #FFFFFF;
    }
    .features-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .feature-card-mod {
        background: #F8F9FA;
        border: 1px solid #e9ecef;
        border-radius: 1rem;
        padding: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .feature-card-mod::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(46,139,87,0.04);
        transform: translate(30%, 30%);
        transition: all 0.3s ease;
    }
    .feature-card-mod:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06);
        border-color: #2E8B57;
    }
    .feature-card-mod:hover::after {
        width: 120px;
        height: 120px;
        background: rgba(46,139,87,0.08);
    }
    .feature-card-mod .ficon {
        width: 3rem;
        height: 3rem;
        background: #E8F5E9;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2E8B57;
        margin-bottom: 1.25rem;
        transition: transform 0.3s ease;
    }
    .feature-card-mod:hover .ficon { transform: scale(1.1) rotate(-5deg); }
    .feature-card-mod h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    .feature-card-mod p {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.6;
    }

    /* ─────────────── CTA ─────────────── */
    .cta-section {
        padding: 5rem 1.5rem;
        background: linear-gradient(135deg, #2E8B57 0%, #1B5E20 100%);
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle 400px at 20% 50%, rgba(255,255,255,0.06) 0%, transparent 70%),
            radial-gradient(circle 300px at 80% 30%, rgba(255,209,102,0.10) 0%, transparent 70%);
    }
    .cta-inner {
        max-width: 1280px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .cta-inner h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    .cta-inner p {
        color: rgba(255,255,255,0.85);
        max-width: 32rem;
        margin: 0 auto 2rem;
        font-size: 1rem;
        line-height: 1.6;
    }
    .cta-inner .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #FFD166;
        color: #212529;
        padding: 0.875rem 2.5rem;
        border-radius: 0.625rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }
    .cta-inner .btn-cta:hover {
        background: #F0C14B;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .cta-inner .btn-cta svg { transition: transform 0.25s ease; }
    .cta-inner .btn-cta:hover svg { transform: translateX(4px); }

    /* ─────────────── NEWSLETTER ─────────────── */
    .newsletter-section {
        padding: 4.5rem 1.5rem;
        background: #FFFFFF;
    }
    .newsletter-inner {
        max-width: 640px;
        margin: 0 auto;
        text-align: center;
    }
    .newsletter-inner h2 {
        font-size: 1.625rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.75rem;
    }
    .newsletter-inner p {
        color: #6b7280;
        font-size: 0.9375rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    .newsletter-form {
        display: flex;
        gap: 0.75rem;
        max-width: 480px;
        margin: 0 auto;
    }
    .newsletter-form input {
        flex: 1;
        padding: 0.8125rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 0.625rem;
        font-size: 0.9375rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #F8F9FA;
    }
    .newsletter-form input:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.10);
    }
    .newsletter-form button {
        background: #2E8B57;
        color: #ffffff;
        border: none;
        padding: 0.8125rem 1.5rem;
        border-radius: 0.625rem;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
    }
    .newsletter-form button:hover {
        background: #217645;
        transform: translateY(-1px);
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 768px) {
        .section-title { margin-bottom: 2rem; }
        .section-title h2 { font-size: 1.5rem; }
        .section-title p { font-size: 0.875rem; }

        .features-section { padding: 3rem 1.25rem; }
        .features-grid { gap: 1rem; }
        .feature-card-mod { padding: 1.5rem; }
        .feature-card-mod h3 { font-size: 1rem; }
        .feature-card-mod p { font-size: 0.8125rem; }

        .stats-bar { padding: 2rem 1.25rem; }
        .stats-inner {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .stat-item .stat-num { font-size: 1.75rem; }
        .stat-item .stat-label { font-size: 0.75rem; }

        .cta-section { padding: 3rem 1.25rem; }
        .cta-inner h2 { font-size: 1.5rem; }
        .cta-inner p { font-size: 0.875rem; }
        .cta-inner .btn-cta { width: 100%; justify-content: center; max-width: 20rem; }

        .newsletter-section { padding: 3rem 1.25rem; }
        .newsletter-inner h2 { font-size: 1.375rem; }
        .newsletter-inner p { font-size: 0.875rem; }
        .newsletter-form { flex-direction: column; max-width: 100%; }
        .newsletter-form input { text-align: center; }
        .newsletter-form button { width: 100%; }
    }
    @media (max-width: 480px) {
        .stats-inner {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .stat-item .stat-num { font-size: 1.375rem; }
        .stat-item .stat-label { font-size: 0.6875rem; }

        .features-section { padding: 2.5rem 1rem; }
        .features-grid { grid-template-columns: 1fr; gap: 0.875rem; }

        .section-title h2 { font-size: 1.25rem; }
        .section-title p { font-size: 0.8125rem; }

        .cta-section { padding: 2.5rem 1rem; }
        .cta-inner h2 { font-size: 1.25rem; }
        .cta-inner p { font-size: 0.8125rem; }
        .cta-inner .btn-cta { font-size: 0.875rem; padding: 0.75rem 1.5rem; }

        .newsletter-section { padding: 2.5rem 1rem; }
        .newsletter-inner h2 { font-size: 1.125rem; }
    }
</style>
@endpush

@section('content')
    <!-- ════════ HERO ════════ -->
    <section class="hero">
        <div class="hero-bg" aria-hidden="true">
            <span class="orb orb-1"></span>
            <span class="orb orb-2"></span>
            <span class="orb orb-3"></span>
            <div class="hero-grid"></div>
        </div>

        <div class="hero-inner">
            <div class="hero-copy">
                <div class="hero-eyebrow">
                    <span class="pulse"></span>
                    <span class="tag">New</span>
                    The self-care edit is live
                </div>

                <h1 class="hero-title">
                    <span class="line"><span>Personal care,</span></span>
                    <span class="line"><span>beautifully <em>elevated</em>.</span></span>
                </h1>

                <p class="hero-sub">
                    Clean, effective formulas for skin, hair and home — handpicked with
                    care and delivered to your doorstep. Turn the everyday into a ritual
                    worth looking forward to.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('products.index') }}" class="btn-primary">
                        Shop the collection
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m0 0l-6-6m6 6l-6 6"/>
                        </svg>
                    </a>
                    <a href="{{ route('track-order.index') }}" class="btn-ghost">
                        <span class="dot-ic">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </span>
                        Track your order
                    </a>
                </div>

                <div class="hero-trust">
                    <div class="avatar-stack" aria-hidden="true">
                        <span class="av av-1">AR</span>
                        <span class="av av-2">SN</span>
                        <span class="av av-3">MH</span>
                        <span class="av av-more">1k+</span>
                    </div>
                    <div class="trust-text">
                        <div class="stars" aria-hidden="true">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                        </div>
                        <p><strong>4.9/5</strong> from 1,200+ happy customers</p>
                    </div>
                </div>
            </div>

            <div class="hero-stage" id="heroStage" aria-hidden="true">
                <div class="stage-halo"></div>
                <div class="stage-ring"></div>
                <div class="stage-ring inner"></div>
                <div class="stage-glow"></div>

                <div class="hero-seal">
                    <svg class="seal-ring" viewBox="0 0 100 100">
                        <defs>
                            <path id="heroSealPath" d="M50,50 m-37,0 a37,37 0 1,1 74,0 a37,37 0 1,1 -74,0"/>
                        </defs>
                        <text fill="rgba(255,209,102,0.85)" font-size="8" font-weight="700" letter-spacing="2.1" font-family="Helvetica, Arial, sans-serif">
                            <textPath href="#heroSealPath" startOffset="0">PREMIUM QUALITY · SINCE 2024 · </textPath>
                        </text>
                    </svg>
                    <span class="seal-core">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4.5-2-8-5.5-8-10a5 5 0 019-3 5 5 0 019 3c0 4.5-3.5 8-8 10z"/>
                        </svg>
                    </span>
                </div>

                <div class="product-card" data-depth="16">
                    <div class="pc-top">
                        <span class="pc-tag">Bestseller</span>
                        <span class="pc-rate">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            4.9
                        </span>
                    </div>
                    <div class="pc-shot">
                        <svg class="bottle" viewBox="0 0 160 220" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="heroGlass" x1="18" y1="10" x2="140" y2="210" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#F5FFF9"/>
                                    <stop offset="0.38" stop-color="#CDF3DE"/>
                                    <stop offset="0.72" stop-color="#93DFB6"/>
                                    <stop offset="1" stop-color="#4DB984"/>
                                </linearGradient>
                                <linearGradient id="heroPump" x1="64" y1="24" x2="110" y2="56" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#21714A"/>
                                    <stop offset="1" stop-color="#0B3A24"/>
                                </linearGradient>
                            </defs>
                            <ellipse cx="80" cy="207" rx="44" ry="8" fill="#1C6B45" opacity="0.14"/>
                            <rect x="70" y="24" width="20" height="14" rx="4" fill="#12472C"/>
                            <rect x="94" y="41" width="16" height="6" rx="3" fill="#12472C"/>
                            <rect x="66" y="36" width="28" height="16" rx="4" fill="url(#heroPump)"/>
                            <rect x="58" y="50" width="44" height="8" rx="4" fill="#0F4530" opacity=".35"/>
                            <path d="M44 84c0-14 10-18 10-28h52c0 10 10 14 10 28v96c0 15-11 26-26 26H70c-15 0-26-11-26-26z" fill="url(#heroGlass)"/>
                            <path d="M55 92c0-10 3-15 7-21v96c0 6-2 10-7 12z" fill="#FFFFFF" opacity=".42"/>
                            <path d="M44 148h92v32c0 15-11 26-26 26H70c-15 0-26-11-26-26z" fill="#3FA872" opacity=".26"/>
                            <rect x="56" y="112" width="48" height="66" rx="9" fill="#FFFFFF" opacity=".94"/>
                            <text x="80" y="135" text-anchor="middle" font-family="Helvetica, Arial, sans-serif" font-size="9" font-weight="700" letter-spacing="2.2" fill="#2E8B57">PCS</text>
                            <text x="80" y="153" text-anchor="middle" font-family="Georgia, 'Times New Roman', serif" font-style="italic" font-size="12" fill="#12261B">Hydra</text>
                            <text x="80" y="168" text-anchor="middle" font-family="Helvetica, Arial, sans-serif" font-size="6.5" letter-spacing="1.4" fill="#7A8B82">SERUM · 30 ML</text>
                        </svg>
                    </div>
                    <div class="pc-meta">
                        <div>
                            <div class="pc-cat">Skin ritual</div>
                            <div class="pc-name">Hydra Glow Serum</div>
                        </div>
                        <div class="pc-price">BDT 1,450</div>
                    </div>
                    <span class="pc-cta">
                        View product
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </div>

                <div class="float-card float-rating" data-depth="30">
                    <div class="fc-ic green">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fc-stars">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                        </div>
                        <div class="fc-title">4.9 average rating</div>
                        <div class="fc-sub">2,300+ verified reviews</div>
                    </div>
                </div>

                <div class="float-card float-delivery" data-depth="22">
                    <div class="fc-ic gold">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11v9H3zM14 10h4l3 3v3h-7z"/>
                            <circle cx="7" cy="18" r="1.6"/><circle cx="17.5" cy="18" r="1.6"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fc-title">Express delivery</div>
                        <div class="fc-sub">Inside Khulna · 24 hours</div>
                    </div>
                </div>

                <div class="float-card float-chip" data-depth="38">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                    </svg>
                    100% authentic
                </div>

                <span class="spark s1"></span>
                <span class="spark s2"></span>
                <span class="spark s3"></span>
                <span class="spark s4"></span>
            </div>
        </div>

        <div class="hero-marquee" aria-hidden="true">
            <div class="track">
                <div class="m-set">
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> Free delivery over BDT 2,000</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> 100% authentic products</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> Cruelty-free &amp; vegan</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> 7-day easy returns</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> Trusted by 1,200+ customers</span>
                </div>
                <div class="m-set">
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> Free delivery over BDT 2,000</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> 100% authentic products</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> Cruelty-free &amp; vegan</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> 7-day easy returns</span>
                    <span><svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg> Trusted by 1,200+ customers</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════ STATS ════════ -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="stat-num">1000+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">500+</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">50+</div>
                <div class="stat-label">Brands</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">99%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </div>



    <!-- ════════ FEATURES ════════ -->
    <div class="features-section">
        <div class="section-title">
            <h2>Why Choose Us</h2>
            <p>We go the extra mile to ensure you get the best shopping experience</p>
        </div>
        <div class="features-grid">
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <h3>Premium Quality</h3>
                <p>Handpicked products from trusted brands, ensuring only the best for your personal and home care needs.</p>
            </div>
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3>Lightning Fast Delivery</h3>
                <p>Quick and reliable shipping right to your doorstep. We ensure your order reaches you in perfect condition.</p>
            </div>
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3>Secure Payments</h3>
                <p>Your privacy and security are our top priorities. Shop with confidence knowing your data is protected.</p>
            </div>
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3>24/7 Support</h3>
                <p>Our dedicated support team is always here to help. Reach out anytime — we're just a message away.</p>
            </div>
        </div>
    </div>

    <!-- ════════ CTA ════════ -->
    <div class="cta-section">
        <div class="cta-inner">
            <h2>Ready to Elevate Your Self-Care?</h2>
            <p>Browse our collection and discover products that will transform your daily routine. Start shopping today!</p>
            <a href="{{ route('products.index') }}" class="btn-cta">
                Start Shopping
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- ════════ NEWSLETTER ════════ -->
    @php $s = settings(); @endphp
    @if($s && $s->newsletter_enabled)
    <div class="newsletter-section">
        <div class="newsletter-inner">
            <h2>{{ $s->newsletter_heading ?? 'Stay in the Loop' }}</h2>
            <p>{{ $s->newsletter_text ?? 'Subscribe to get notified about new products, exclusive offers, and care tips delivered to your inbox.' }}</p>
            <form class="newsletter-form" id="newsletterForm">
                <input type="email" id="newsletterEmail" placeholder="{{ $s->newsletter_placeholder ?? 'Enter your email address' }}" required>
                <button type="submit">{{ $s->newsletter_button_text ?? 'Subscribe' }}</button>
            </form>
        </div>
    </div>
    @endif
@push('scripts')
<script>
    (function () {
        const hero = document.querySelector('.hero');
        const stage = document.getElementById('heroStage');
        if (!hero || !stage) return;

        const layers = stage.querySelectorAll('[data-depth]');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        const finePointer = window.matchMedia('(pointer: fine)');
        if (reduceMotion.matches || !finePointer.matches) return;

        let frame = null;
        hero.addEventListener('mousemove', function (e) {
            const rect = hero.getBoundingClientRect();
            const nx = (e.clientX - rect.left) / rect.width - 0.5;
            const ny = (e.clientY - rect.top) / rect.height - 0.5;
            if (frame) cancelAnimationFrame(frame);
            frame = requestAnimationFrame(function () {
                layers.forEach(function (el) {
                    const depth = parseFloat(el.dataset.depth) || 12;
                    el.style.translate = (nx * depth) + 'px ' + (ny * depth) + 'px';
                });
            });
        });
        hero.addEventListener('mouseleave', function () {
            layers.forEach(function (el) { el.style.translate = '0px 0px'; });
        });
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('newsletterEmail').value.trim();
        if (!email) return;

        Swal.fire({
            title: 'Subscribed! 🎉',
            text: 'Thanks for subscribing! We\'ll keep you posted with the latest updates and offers.',
            icon: 'success',
            confirmButtonColor: '#2E8B57',
            confirmButtonText: 'Awesome!',
            background: '#ffffff',
            backdrop: 'rgba(46,139,87,0.15)',
            timer: 4000,
            timerProgressBar: true,
        });

        this.reset();
    });
</script>
@endpush
@endsection
