@extends('frontend.layouts.app')

@section('title', 'Find Your Perfect Rental Home')

@push('styles')
<style>
/* ───────────── SCROLL PROGRESS BAR ───────────── */
#scrollProgress {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, #2563EB, #7C3AED, #2563EB);
    background-size: 200% 100%;
    z-index: 9999;
    width: 0%;
    transition: width 0.1s linear;
    animation: progressGlow 2s ease-in-out infinite;
}
@keyframes progressGlow { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

/* ───────────── SCROLL ANIMATIONS ───────────── */
.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal.revealed { opacity: 1; transform: translateY(0); }
.reveal-left { opacity: 0; transform: translateX(-50px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
.reveal-left.revealed { opacity: 1; transform: translateX(0); }
.reveal-right { opacity: 0; transform: translateX(50px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
.reveal-right.revealed { opacity: 1; transform: translateX(0); }
.reveal-scale { opacity: 0; transform: scale(0.9); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
.reveal-scale.revealed { opacity: 1; transform: scale(1); }

/* ───────────── HERO ───────────── */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 50%, #0F172A 100%);
}
.hero-bg {
    position: absolute;
    inset: 0;
    background:
        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 900"><rect fill="none"/><g opacity="0.04"><path fill="%23fff" d="M0 600c120-60 280-80 420-40s320 60 480 20 300-80 420-40v360H0Z"/><path fill="%23fff" d="M0 500c160-40 340-20 500 40s300 60 460 20 280-60 420-20v400H0Z"/></g></svg>') center/cover no-repeat;
    pointer-events: none;
}
.hero-gradient {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 40%, rgba(37,99,235,0.15) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 60%, rgba(245,158,11,0.08) 0%, transparent 60%);
    pointer-events: none;
}
/* Particle-like floating dots */
.hero-particles {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}
.hero-particles span {
    position: absolute;
    display: block;
    width: 4px;
    height: 4px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    animation: floatParticle 20s infinite linear;
}
.hero-particles span:nth-child(1) { left: 10%; top: 20%; animation-duration: 25s; animation-delay: -2s; width: 6px; height: 6px; }
.hero-particles span:nth-child(2) { left: 25%; top: 60%; animation-duration: 18s; animation-delay: -5s; }
.hero-particles span:nth-child(3) { left: 45%; top: 30%; animation-duration: 22s; animation-delay: -8s; width: 5px; height: 5px; }
.hero-particles span:nth-child(4) { left: 60%; top: 70%; animation-duration: 20s; animation-delay: -3s; }
.hero-particles span:nth-child(5) { left: 75%; top: 15%; animation-duration: 28s; animation-delay: -10s; width: 3px; height: 3px; }
.hero-particles span:nth-child(6) { left: 85%; top: 50%; animation-duration: 15s; animation-delay: -6s; width: 7px; height: 7px; background: rgba(245,158,11,0.1); }
.hero-particles span:nth-child(7) { left: 35%; top: 80%; animation-duration: 24s; animation-delay: -12s; }
.hero-particles span:nth-child(8) { left: 90%; top: 25%; animation-duration: 19s; animation-delay: -7s; width: 5px; height: 5px; }
@keyframes floatParticle {
    0% { transform: translateY(0) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
}

.hero-grid {
    max-width: 1280px;
    margin: 0 auto;
    padding: 6rem 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 1;
    width: 100%;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(37,99,235,0.15);
    color: #93C5FD;
    font-size: 0.8125rem;
    font-weight: 600;
    padding: 0.375rem 1rem;
    border-radius: 9999px;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(37,99,235,0.2);
    animation: fadeUp 0.7s ease-out both;
    backdrop-filter: blur(8px);
}
.hero-badge .dot { width: 0.5rem; height: 0.5rem; background: #93C5FD; border-radius: 50%; animation: pulse-dot 2s ease-in-out infinite; }
@keyframes pulse-dot { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.8); } }
.hero h1 {
    font-size: 3.5rem;
    font-weight: 900;
    color: #fff;
    line-height: 1.08;
    letter-spacing: -0.04em;
    margin-bottom: 1.25rem;
    animation: fadeUp 0.7s ease-out 0.1s both;
}
.hero h1 .highlight {
    background: linear-gradient(135deg, #60A5FA, #A78BFA, #60A5FA);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 4s ease-in-out infinite;
}
@keyframes gradientShift { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
.hero h1 .typewriter-text {
    display: inline-block;
    position: relative;
    color: #FCD34D;
}
.hero h1 .typewriter-text::after {
    content: '';
    position: absolute;
    right: -6px;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 70%;
    background: #FCD34D;
    animation: blink 0.8s step-end infinite;
}
@keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0; } }
.hero p {
    font-size: 1.125rem;
    color: rgba(255,255,255,0.6);
    max-width: 32rem;
    line-height: 1.75;
    margin-bottom: 2rem;
    animation: fadeUp 0.7s ease-out 0.2s both;
}
.hero-search {
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 1.25rem;
    animation: fadeUp 0.7s ease-out 0.3s both;
    transition: border-color 0.3s;
}
.hero-search:hover { border-color: rgba(37,99,235,0.3); }
.hero-search-row {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.hero-search .search-field {
    flex: 1;
    min-width: 140px;
    position: relative;
}
.hero-search .search-field .icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.4);
    pointer-events: none;
    transition: color 0.3s;
}
.hero-search .search-field:focus-within .icon { color: #60A5FA; }
.hero-search select, .hero-search input {
    width: 100%;
    padding: 0.8125rem 0.875rem 0.8125rem 2.25rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px;
    color: #fff;
    font-size: 0.875rem;
    font-family: var(--font);
    outline: none;
    transition: all 0.3s;
    -webkit-appearance: none;
    appearance: none;
    cursor: pointer;
}
.hero-search select option { background: #1E293B; color: #fff; }
.hero-search select:focus, .hero-search input:focus { border-color: #2563EB; background: rgba(37,99,235,0.1); box-shadow: 0 0 0 4px rgba(37,99,235,0.15); }
.hero-search .btn-search {
    padding: 0.8125rem 2rem;
    background: linear-gradient(135deg, #2563EB, #7C3AED);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 20px rgba(37,99,235,0.35);
    position: relative;
    overflow: hidden;
}
.hero-search .btn-search::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 20%, rgba(255,255,255,0.15) 50%, transparent 80%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}
.hero-search .btn-search:hover::before { transform: translateX(100%); }
.hero-search .btn-search:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(37,99,235,0.45); }
.hero-search .btn-search:active { transform: translateY(0); }
.hero-stats {
    display: flex;
    gap: 2.5rem;
    margin-top: 2rem;
    animation: fadeUp 0.7s ease-out 0.4s both;
}
.hero-stat .num { font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1; }
.hero-stat .label { font-size: 0.8125rem; color: rgba(255,255,255,0.5); margin-top: 0.25rem; }
.hero-visual {
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeUp 0.7s ease-out 0.5s both;
}
.hero-image-card {
    position: relative;
    width: 100%;
    max-width: 480px;
    transform-style: preserve-3d;
    perspective: 1000px;
}
.hero-image-card .main-img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    background: linear-gradient(135deg, #1E3A5F, #2D4A7A);
    aspect-ratio: 4/3;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    transition: transform 0.3s ease;
}
.hero-image-card:hover .main-img { transform: scale(1.02); }
.hero-image-card .main-img svg { width: 60%; height: 60%; opacity: 0.3; }
.hero-image-card .floating-card {
    position: absolute;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: float 6s ease-in-out infinite;
    transition: transform 0.3s;
}
.hero-image-card .floating-card:hover { transform: scale(1.05) !important; }
.hero-image-card .floating-card:nth-child(2) { top: 8%; right: -10%; animation-delay: 0s; }
.hero-image-card .floating-card:nth-child(3) { bottom: 12%; left: -8%; animation-delay: 2s; }
.floating-card .fc-icon { width: 2.5rem; height: 2.5rem; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.floating-card .fc-icon.blue { background: #DBEAFE; color: #2563EB; }
.floating-card .fc-icon.green { background: #D1FAE5; color: #10B981; }
.floating-card .fc-text .fc-num { font-weight: 700; font-size: 0.9375rem; color: #0F172A; }
.floating-card .fc-text .fc-label { font-size: 0.75rem; color: #64748B; }
@keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }

/* ── Hero 3D Tilt (applied via JS) ── */
.tilt-card { transition: transform 0.1s ease; }

@media (max-width: 1024px) {
    .hero-grid { grid-template-columns: 1fr; gap: 2rem; padding: 5rem 1.5rem 3rem; text-align: center; }
    .hero h1 { font-size: 2.75rem; }
    .hero p { margin-left: auto; margin-right: auto; }
    .hero-stats { justify-content: center; }
    .hero-visual { display: none; }
    .hero-search-row { flex-direction: column; }
    .hero-search .search-field { min-width: 100%; }
    .hero-search .btn-search { width: 100%; justify-content: center; }
}
@media (max-width: 768px) {
    .hero { min-height: auto; }
    .hero-grid { padding: 3rem 1rem 2.5rem; }
    .hero h1 { font-size: 2rem; }
    .hero p { font-size: 0.9375rem; }
    .hero-stats { gap: 1.5rem; flex-wrap: wrap; }
    .hero-stat .num { font-size: 1.25rem; }
}
@media (max-width: 480px) {
    .hero h1 { font-size: 1.75rem; }
}

/* ───────────── SECTION SEPARATORS ───────────── */
.section-divider-top {
    position: relative;
    margin-top: -2px;
}
.section-divider-top svg {
    display: block;
    width: 100%;
    height: 50px;
}

/* ───────────── CATEGORIES ───────────── */
.categories-section { padding: 5rem 0; background: var(--white); position: relative; }
.cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.cat-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 1.75rem 1rem;
    background: var(--bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.cat-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary-light), rgba(167,139,250,0.15));
    opacity: 0;
    transition: opacity 0.4s ease;
}
.cat-card:hover::before { opacity: 1; }
.cat-card:hover { transform: translateY(-6px) scale(1.02); border-color: var(--primary); box-shadow: 0 12px 30px rgba(37,99,235,0.12); }
.cat-card .cat-icon {
    width: 3rem;
    height: 3rem;
    background: var(--white);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    position: relative;
    z-index: 1;
}
.cat-card:hover .cat-icon { transform: scale(1.15) rotate(-6deg); color: #fff; background: var(--primary); box-shadow: 0 4px 16px rgba(37,99,235,0.3); }
.cat-card .cat-name { font-size: 0.875rem; font-weight: 600; color: var(--text); position: relative; z-index: 1; transition: color 0.3s; }
.cat-card:hover .cat-name { color: var(--primary); }
.cat-card .cat-count { font-size: 0.75rem; color: var(--text-muted); position: relative; z-index: 1; }
@media (max-width: 640px) { .cat-grid { grid-template-columns: repeat(3, 1fr); gap: 0.75rem; padding: 0 1rem; } .cat-card { padding: 1.25rem 0.75rem; } .cat-card .cat-icon { width: 2.5rem; height: 2.5rem; font-size: 1rem; } .cat-card .cat-name { font-size: 0.8125rem; } }

/* ───────────── FEATURED PROPERTIES ───────────── */
.featured-section { padding: 5rem 0; background: var(--bg); position: relative; }
.prop-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.prop-card {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}
.prop-card::after {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, transparent 40%, rgba(37,99,235,0.06), transparent 60%);
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}
.prop-card:hover::after { opacity: 1; }
.prop-card:hover { box-shadow: 0 20px 50px rgba(15,23,42,0.08); transform: translateY(-6px); border-color: rgba(37,99,235,0.2); }
.prop-card .prop-img {
    position: relative;
    height: 220px;
    background: linear-gradient(135deg, #E2E8F0, #CBD5E1);
    overflow: hidden;
}
.prop-card .prop-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
.prop-card:hover .prop-img img { transform: scale(1.08); }
.prop-card .prop-img .img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(15,23,42,0.4));
    opacity: 0;
    transition: opacity 0.4s;
}
.prop-card:hover .prop-img .img-overlay { opacity: 1; }
.prop-card .prop-img .prop-badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 0.5rem; flex-wrap: wrap; z-index: 2; }
.prop-card .prop-img .badge {
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    backdrop-filter: blur(4px);
}
.badge-featured { background: rgba(245,158,11,0.9); color: #fff; }
.badge-verified { background: rgba(16,185,129,0.9); color: #fff; }
.badge-new { background: rgba(37,99,235,0.9); color: #fff; }
.prop-card .prop-img .fav-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 2.25rem;
    height: 2.25rem;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    color: var(--text-muted);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 2;
    backdrop-filter: blur(4px);
}
.prop-card .prop-img .fav-btn:hover { background: #FEE2E2; color: #EF4444; transform: scale(1.15); }
.prop-card .prop-img .fav-btn.active { background: #FEE2E2; color: #EF4444; }
.prop-card .prop-img .fav-btn.active svg { fill: #EF4444; }
.prop-card .prop-img .fav-btn.liked { animation: heartPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
@keyframes heartPop { 0% { transform: scale(1); } 50% { transform: scale(1.3); } 100% { transform: scale(1); } }
.prop-card .prop-img .price-tag {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: rgba(15,23,42,0.85);
    backdrop-filter: blur(8px);
    color: #fff;
    padding: 0.375rem 0.875rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 700;
    z-index: 2;
    border: 1px solid rgba(255,255,255,0.1);
}
.prop-card .prop-img .price-tag small { font-size: 0.6875rem; font-weight: 400; opacity: 0.7; }
.prop-card .prop-body { padding: 1.25rem; position: relative; z-index: 1; }
.prop-card .prop-body .prop-title { font-size: 1.0625rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.375rem; transition: color 0.3s; }
.prop-card:hover .prop-body .prop-title { color: var(--primary); }
.prop-card .prop-body .prop-location { display: flex; align-items: center; gap: 0.375rem; color: var(--text-muted); font-size: 0.8125rem; margin-bottom: 0.75rem; }
.prop-card .prop-body .prop-meta { display: flex; gap: 1rem; padding-top: 0.75rem; border-top: 1px solid var(--border); }
.prop-card .prop-body .prop-meta span { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: var(--text-muted); }
.prop-card .prop-body .prop-meta span svg { color: var(--primary); }
.prop-card .prop-body .prop-actions { display: flex; gap: 0.75rem; margin-top: 1rem; }
.prop-card .prop-body .prop-actions a { flex: 1; text-align: center; padding: 0.625rem; border-radius: var(--radius-sm); font-size: 0.8125rem; font-weight: 600; transition: all 0.3s; }
.prop-card .prop-body .prop-actions a:first-child { background: var(--primary); color: #fff; }
.prop-card .prop-body .prop-actions a:first-child:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
.prop-card .prop-body .prop-actions a:last-child { background: var(--bg); color: var(--text); border: 1px solid var(--border); }
.prop-card .prop-body .prop-actions a:last-child:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary); }
@media (max-width: 640px) { .prop-grid { grid-template-columns: 1fr; padding: 0 1rem; } .prop-card .prop-img { height: 200px; } }

/* ───────────── HOW IT WORKS ───────────── */
.how-section { padding: 5rem 0; background: var(--white); position: relative; }
.steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.step-card {
    text-align: center;
    padding: 2.5rem 1.5rem;
    position: relative;
    background: var(--bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.step-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(15,23,42,0.06); border-color: var(--primary); }
.step-card:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 3rem;
    left: 65%;
    width: 70%;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), transparent);
}
.step-num {
    width: 3.5rem;
    height: 3.5rem;
    background: linear-gradient(135deg, var(--primary-light), rgba(167,139,250,0.2));
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 800;
    margin: 0 auto 1.25rem;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.step-card:hover .step-num { background: linear-gradient(135deg, var(--primary), #7C3AED); color: #fff; transform: scale(1.15) rotate(360deg); box-shadow: 0 8px 24px rgba(37,99,235,0.25); }
.step-card h3 { font-size: 1.125rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.5rem; }
.step-card p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; }
@media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; gap: 1rem; } .step-card::after { display: none; } }

/* ───────────── WHY CHOOSE US ───────────── */
.why-section { padding: 5rem 0; background: var(--bg); position: relative; }
.why-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.why-card {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    padding: 2rem;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
}
.why-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), #7C3AED);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.why-card:hover::before { transform: scaleX(1); }
.why-card:hover { box-shadow: 0 16px 40px rgba(15,23,42,0.06); transform: translateY(-4px); border-color: transparent; }
.why-card .w-icon { width: 3rem; height: 3rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; font-size: 1.25rem; transition: all 0.4s; }
.why-card:hover .w-icon { transform: scale(1.1) rotate(-6deg); }
.why-card h3 { font-size: 1.0625rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.5rem; }
.why-card p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; }

/* ───────────── CITIES ───────────── */
.cities-section { padding: 5rem 0; background: var(--white); position: relative; }
.cities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.city-card {
    position: relative;
    border-radius: var(--radius);
    overflow: hidden;
    height: 200px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    background: linear-gradient(135deg, #E2E8F0, #CBD5E1);
    display: flex;
    align-items: flex-end;
}
.city-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 20px 50px rgba(15,23,42,0.12); }
.city-card .city-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 30%, rgba(15,23,42,0.9));
    transition: opacity 0.4s;
}
.city-card .city-info { position: relative; z-index: 1; padding: 1.5rem; width: 100%; transform: translateY(0); transition: transform 0.4s; }
.city-card:hover .city-info { transform: translateY(-4px); }
.city-card .city-info h3 { color: #fff; font-size: 1.125rem; font-weight: 700; }
.city-card .city-info p { color: rgba(255,255,255,0.6); font-size: 0.8125rem; margin-top: 0.125rem; }
.city-card:nth-child(1) { background: linear-gradient(135deg, #1E3A5F, #2D4A7A); }
.city-card:nth-child(2) { background: linear-gradient(135deg, #1B5E20, #2E7D32); }
.city-card:nth-child(3) { background: linear-gradient(135deg, #4A148C, #6A1B9A); }
.city-card:nth-child(4) { background: linear-gradient(135deg, #E65100, #EF6C00); }
.city-card:nth-child(5) { background: linear-gradient(135deg, #0F172A, #1E293B); }
.city-card:nth-child(6) { background: linear-gradient(135deg, #0D47A1, #1565C0); }
@media (max-width: 640px) { .cities-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; padding: 0 1rem; } .city-card { height: 150px; } }

/* ───────────── TESTIMONIALS ───────────── */
.testimonials-section { padding: 5rem 0; background: var(--bg); position: relative; }
.test-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.test-card {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    padding: 2rem;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}
.test-card::before {
    content: '';
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    width: 2.5rem;
    height: 2.5rem;
    background: var(--primary-light);
    border-radius: 50%;
    opacity: 0.3;
}
.test-card:hover { box-shadow: 0 16px 40px rgba(15,23,42,0.06); transform: translateY(-4px); border-color: transparent; }
.test-card .test-stars { color: #F59E0B; margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: 2px; }
.test-card .test-text { font-size: 0.9375rem; color: var(--text); line-height: 1.7; margin-bottom: 1.25rem; font-style: italic; }
.test-card .test-author { display: flex; align-items: center; gap: 0.75rem; }
.test-card .test-avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), rgba(167,139,250,0.2));
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    transition: transform 0.3s;
}
.test-card:hover .test-avatar { transform: scale(1.1); }
.test-card .test-name { font-size: 0.875rem; font-weight: 600; color: var(--secondary); }
.test-card .test-role { font-size: 0.75rem; color: var(--text-muted); }

/* ───────────── FAQ ───────────── */
.faq-section { padding: 5rem 0; background: var(--white); position: relative; }
.faq-list { max-width: 720px; margin: 0 auto; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; }
.faq-item {
    background: var(--bg);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.3s;
}
.faq-item.open { border-color: var(--primary); box-shadow: 0 4px 16px rgba(37,99,235,0.06); }
.faq-question {
    width: 100%;
    padding: 1.125rem 1.25rem;
    background: none;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--text);
    font-family: var(--font);
    text-align: left;
    transition: color 0.3s;
}
.faq-item.open .faq-question { color: var(--primary); }
.faq-question svg { transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); flex-shrink: 0; color: var(--text-muted); }
.faq-item.open .faq-question svg { transform: rotate(45deg); color: var(--primary); }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.4s ease; }
.faq-item.open .faq-answer { max-height: 300px; padding: 0 1.25rem 1.125rem; }
.faq-answer p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.7; }

/* ───────────── APP CTA ───────────── */
.app-cta-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #2563EB, #7C3AED, #1D4ED8);
    background-size: 200% 200%;
    animation: ctaBgShift 8s ease-in-out infinite;
    position: relative;
    overflow: hidden;
}
@keyframes ctaBgShift { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
.app-cta-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle 500px at 80% 50%, rgba(255,255,255,0.06) 0%, transparent 70%),
        radial-gradient(circle 300px at 20% 30%, rgba(245,158,11,0.1) 0%, transparent 70%);
    pointer-events: none;
}
.app-cta-section::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 60%);
    border-radius: 50%;
    animation: ctaGlow 6s ease-in-out infinite alternate;
}
@keyframes ctaGlow { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(-30px, 30px) scale(1.2); } }
.app-cta-inner { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; text-align: center; position: relative; z-index: 1; }
.app-cta-inner h2 { font-size: 2.25rem; font-weight: 800; color: #fff; margin-bottom: 0.75rem; letter-spacing: -0.03em; }
.app-cta-inner p { color: rgba(255,255,255,0.75); max-width: 32rem; margin: 0 auto 2rem; font-size: 1rem; line-height: 1.7; }
.app-cta-buttons { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }
.app-cta-buttons a {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.app-cta-buttons a:hover { background: rgba(255,255,255,0.2); transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
.app-cta-buttons a:active { transform: translateY(0); }
@media (max-width: 768px) { .app-cta-inner h2 { font-size: 1.625rem; } .app-cta-buttons a { width: 100%; justify-content: center; } }

/* ───────────── BACK TO TOP ───────────── */
#backToTop {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    color: #fff;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.25rem;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
    z-index: 999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateY(20px) scale(0.8);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    pointer-events: none;
}
#backToTop.visible { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
#backToTop:hover { transform: translateY(-4px) scale(1.05); box-shadow: 0 8px 24px rgba(37,99,235,0.4); }
#backToTop:active { transform: translateY(0) scale(0.95); }

/* ───────────── NEWSLETTER ───────────── */
.newsletter-section { padding: 4rem 0; background: var(--bg); border-top: 1px solid var(--border); }
.newsletter-inner { max-width: 640px; margin: 0 auto; padding: 0 1.5rem; text-align: center; }
.newsletter-inner h3 { font-size: 1.5rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.5rem; }
.newsletter-inner p { color: var(--text-muted); font-size: 0.9375rem; margin-bottom: 1.5rem; }
.newsletter-form { display: flex; gap: 0.75rem; max-width: 480px; margin: 0 auto; }
.newsletter-form input {
    flex: 1;
    padding: 0.8125rem 1.125rem;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    outline: none;
    font-family: var(--font);
    transition: all 0.3s;
}
.newsletter-form input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }
.newsletter-form button {
    padding: 0.8125rem 1.5rem;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}
.newsletter-form button:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(37,99,235,0.3); }
@media (max-width: 640px) { .newsletter-form { flex-direction: column; } }
</style>
@endpush

@section('content')
<!-- ════════ SCROLL PROGRESS ════════ -->
<div id="scrollProgress"></div>

<!-- ════════ HERO ════════ -->
<section class="hero" id="hero">
    <div class="hero-bg"></div>
    <div class="hero-gradient"></div>
    <div class="hero-particles">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
    </div>
    <div class="hero-grid">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Trusted by 10,000+ Renters & Landlords
            </div>
            <h1>Find Your <span class="highlight">Perfect Rental</span><br><span class="typewriter-text" id="heroWord">Home</span></h1>
            <p>Discover thousands of verified rental properties across Bangladesh. From flats to sublets, find your ideal space with confidence.</p>
            <div class="hero-search">
                <form action="{{ route('search') }}" class="hero-search-row">
                    <div class="search-field">
                        <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                        <select name="location">
                            <option value="">All Locations</option>
                            <option>Dhaka</option>
                            <option>Chattogram</option>
                            <option>Khulna</option>
                            <option>Rajshahi</option>
                            <option>Sylhet</option>
                            <option>Barishal</option>
                            <option>Rangpur</option>
                            <option>Mymensingh</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                        <select name="type">
                            <option value="">All Types</option>
                            <option>Flat</option>
                            <option>House</option>
                            <option>Sublet</option>
                            <option>Bachelor Mess</option>
                            <option>Office</option>
                            <option>Shop</option>
                            <option>Hostel</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                        <select name="rent">
                            <option value="">Any Rent</option>
                            <option>Under 5,000</option>
                            <option>5,000 - 10,000</option>
                            <option>10,000 - 20,000</option>
                            <option>20,000 - 50,000</option>
                            <option>50,000+</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-search">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                        Search
                    </button>
                </form>
            </div>
            <div class="hero-stats">
                <div class="hero-stat"><div class="num"><span class="counter" data-target="10000">0</span>+</div><div class="label">Properties Listed</div></div>
                <div class="hero-stat"><div class="num"><span class="counter" data-target="8500">0</span>+</div><div class="label">Happy Renters</div></div>
                <div class="hero-stat"><div class="num"><span class="counter" data-target="95">0</span>%</div><div class="label">Satisfaction Rate</div></div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-image-card" id="tiltCard">
                <div class="main-img">
                    <svg fill="rgba(255,255,255,0.15)" viewBox="0 0 24 24"><path d="M19 9.78V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v.24L12 3 2 12h3v7a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-7h3l-3-3.22z"/></svg>
                </div>
                <div class="floating-card">
                    <div class="fc-icon blue"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="fc-text"><div class="fc-num">Verified</div><div class="fc-label">Properties Only</div></div>
                </div>
                <div class="floating-card">
                    <div class="fc-icon green"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="fc-text"><div class="fc-num">Quick</div><div class="fc-label">Response Time</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════ CATEGORIES ════════ -->
<section id="categories" class="categories-section">
    <div class="section-header reveal">
        <span class="badge">Browse by Category</span>
        <h2>Explore Property Types</h2>
        <p>Find exactly what you need from our wide range of rental property categories.</p>
    </div>
    <div class="cat-grid">
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.05s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
            <span class="cat-name">Flats</span>
            <span class="cat-count">2,450 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.1s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11m16-11v11M8 14v3m4-3v3m4-3v3"/></svg></div>
            <span class="cat-name">Houses</span>
            <span class="cat-count">1,820 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.15s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg></div>
            <span class="cat-name">Sublets</span>
            <span class="cat-count">980 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.2s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"/></svg></div>
            <span class="cat-name">Bachelor Mess</span>
            <span class="cat-count">650 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.25s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg></div>
            <span class="cat-name">Offices</span>
            <span class="cat-count">420 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.3s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></div>
            <span class="cat-name">Shops</span>
            <span class="cat-count">310 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.35s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg></div>
            <span class="cat-name">Hostels</span>
            <span class="cat-count">530 Properties</span>
        </a>
        <a href="{{ route('search') }}" class="cat-card reveal" style="animation-delay:0.4s">
            <div class="cat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
            <span class="cat-name">All Rentals</span>
            <span class="cat-count">8,160+ Total</span>
        </a>
    </div>
</section>

<!-- ════════ FEATURED PROPERTIES ════════ -->
<section id="properties" class="featured-section">
    <div class="section-header reveal">
        <span class="badge">Handpicked for You</span>
        <h2>Featured Properties</h2>
        <p>Explore our premium selection of verified rental properties across Bangladesh.</p>
    </div>
    <div class="prop-grid">
        <div class="prop-card reveal" style="animation-delay:0.05s">
            <div class="prop-img">
                <div class="img-overlay"></div>
                <div style="padding:2.5rem; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div class="prop-badges"><span class="badge badge-featured">Featured</span><span class="badge badge-verified">Verified</span></div>
                <button class="fav-btn" aria-label="Add to favorites"><svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg></button>
                <div class="price-tag">BDT 15,000 <small>/mo</small></div>
            </div>
            <div class="prop-body">
                <h3 class="prop-title">Modern 2BHK Apartment</h3>
                <div class="prop-location"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Gulshan-1, Dhaka</div>
                <div class="prop-meta">
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 2 Bed</span>
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> 2 Bath</span>
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> 1,200 sqft</span>
                </div>
                <div class="prop-actions">
                    <a href="{{ route('property-detail') }}">View Details</a>
                    <a href="#">Contact Owner</a>
                </div>
            </div>
        </div>
        <div class="prop-card reveal" style="animation-delay:0.1s">
            <div class="prop-img">
                <div class="img-overlay"></div>
                <div style="padding:2.5rem; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11m16-11v11M8 14v3m4-3v3m4-3v3"/></svg>
                </div>
                <div class="prop-badges"><span class="badge badge-verified">Verified</span><span class="badge badge-new">New</span></div>
                <button class="fav-btn" aria-label="Add to favorites"><svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg></button>
                <div class="price-tag">BDT 25,000 <small>/mo</small></div>
            </div>
            <div class="prop-body">
                <h3 class="prop-title">Spacious Family House</h3>
                <div class="prop-location"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Dhanmondi, Dhaka</div>
                <div class="prop-meta">
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 4 Bed</span>
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> 3 Bath</span>
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> 2,500 sqft</span>
                </div>
                <div class="prop-actions">
                    <a href="{{ route('property-detail') }}">View Details</a>
                    <a href="#">Contact Owner</a>
                </div>
            </div>
        </div>
        <div class="prop-card reveal" style="animation-delay:0.15s">
            <div class="prop-img">
                <div class="img-overlay"></div>
                <div style="padding:2.5rem; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.3);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                </div>
                <div class="prop-badges"><span class="badge badge-featured">Featured</span><span class="badge badge-new">New</span></div>
                <button class="fav-btn" aria-label="Add to favorites"><svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg></button>
                <div class="price-tag">BDT 8,000 <small>/mo</small></div>
            </div>
            <div class="prop-body">
                <h3 class="prop-title">Cozy Sublet Room</h3>
                <div class="prop-location"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Banani, Dhaka</div>
                <div class="prop-meta">
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 1 Bed</span>
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> 1 Bath</span>
                    <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> 450 sqft</span>
                </div>
                <div class="prop-actions">
                    <a href="{{ route('property-detail') }}">View Details</a>
                    <a href="#">Contact Owner</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════ HOW IT WORKS ════════ -->
<section class="how-section">
    <div class="section-header reveal">
        <span class="badge">Simple Process</span>
        <h2>How It Works</h2>
        <p>Finding your perfect rental home is just three simple steps away.</p>
    </div>
    <div class="steps-grid">
        <div class="step-card reveal" style="animation-delay:0.05s">
            <div class="step-num">1</div>
            <h3>Search Properties</h3>
            <p>Browse thousands of verified rental properties across Bangladesh using our smart search and filters.</p>
        </div>
        <div class="step-card reveal" style="animation-delay:0.1s">
            <div class="step-num">2</div>
            <h3>Compare & Connect</h3>
            <p>Compare properties side-by-side and connect directly with verified owners or agents.</p>
        </div>
        <div class="step-card reveal" style="animation-delay:0.15s">
            <div class="step-num">3</div>
            <h3>Move In Confidently</h3>
            <p>Finalize your rental with full confidence. We're with you every step of the way.</p>
        </div>
    </div>
</section>

<!-- ════════ WHY CHOOSE US ════════ -->
<section class="why-section">
    <div class="section-header reveal">
        <span class="badge">Why BasaFinder</span>
        <h2>Why Choose Us</h2>
        <p>We make renting simple, safe, and stress-free for everyone.</p>
    </div>
    <div class="why-grid">
        <div class="why-card reveal" style="animation-delay:0.05s">
            <div class="w-icon" style="background:#DBEAFE;color:#2563EB;"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
            <h3>Verified Properties</h3>
            <p>Every listing is verified to ensure you get authentic, high-quality rental options with genuine owners.</p>
        </div>
        <div class="why-card reveal" style="animation-delay:0.1s">
            <div class="w-icon" style="background:#D1FAE5;color:#10B981;"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
            <h3>Lightning Fast</h3>
            <p>Get instant matches and quick responses from property owners. No more waiting days for replies.</p>
        </div>
        <div class="why-card reveal" style="animation-delay:0.15s">
            <div class="w-icon" style="background:#FEF3C7;color:#F59E0B;"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
            <h3>Secure Platform</h3>
            <p>Your privacy and security are our top priorities. Rent with confidence on our trusted platform.</p>
        </div>
        <div class="why-card reveal" style="animation-delay:0.2s">
            <div class="w-icon" style="background:#FEE2E2;color:#EF4444;"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <h3>24/7 Support</h3>
            <p>Our dedicated team is always available to help you with any questions or concerns, anytime.</p>
        </div>
    </div>
</section>

<!-- ════════ POPULAR CITIES ════════ -->
<section class="cities-section">
    <div class="section-header reveal">
        <span class="badge">Find Properties Across</span>
        <h2>Popular Cities</h2>
        <p>Browse rental properties in major cities all across Bangladesh.</p>
    </div>
    <div class="cities-grid">
        <a href="{{ route('search') }}" class="city-card reveal" style="animation-delay:0.05s">
            <div class="city-overlay"></div>
            <div class="city-info"><h3>Dhaka</h3><p>2,450+ Properties</p></div>
        </a>
        <a href="{{ route('search') }}" class="city-card reveal" style="animation-delay:0.1s">
            <div class="city-overlay"></div>
            <div class="city-info"><h3>Chattogram</h3><p>1,200+ Properties</p></div>
        </a>
        <a href="{{ route('search') }}" class="city-card reveal" style="animation-delay:0.15s">
            <div class="city-overlay"></div>
            <div class="city-info"><h3>Khulna</h3><p>850+ Properties</p></div>
        </a>
        <a href="{{ route('search') }}" class="city-card reveal" style="animation-delay:0.2s">
            <div class="city-overlay"></div>
            <div class="city-info"><h3>Rajshahi</h3><p>620+ Properties</p></div>
        </a>
        <a href="{{ route('search') }}" class="city-card reveal" style="animation-delay:0.25s">
            <div class="city-overlay"></div>
            <div class="city-info"><h3>Sylhet</h3><p>540+ Properties</p></div>
        </a>
        <a href="{{ route('search') }}" class="city-card reveal" style="animation-delay:0.3s">
            <div class="city-overlay"></div>
            <div class="city-info"><h3>Barishal</h3><p>380+ Properties</p></div>
        </a>
    </div>
</section>

<!-- ════════ TESTIMONIALS ════════ -->
<section class="testimonials-section">
    <div class="section-header reveal">
        <span class="badge">What They Say</span>
        <h2>Loved by Renters & Owners</h2>
        <p>Hear from thousands of satisfied users who found their perfect home through BasaFinder.</p>
    </div>
    <div class="test-grid">
        <div class="test-card reveal" style="animation-delay:0.05s">
            <div class="test-stars">★★★★★</div>
            <p class="test-text">"BasaFinder made finding a flat in Dhaka incredibly easy. The filters helped me narrow down exactly what I needed, and I found my dream apartment in just 3 days!"</p>
            <div class="test-author">
                <div class="test-avatar">FN</div>
                <div><div class="test-name">Farzana N.</div><div class="test-role">Renter, Dhaka</div></div>
            </div>
        </div>
        <div class="test-card reveal" style="animation-delay:0.1s">
            <div class="test-stars">★★★★★</div>
            <p class="test-text">"As a landlord, posting my property was incredibly easy. I got genuine leads within hours. The verification system gives both parties peace of mind."</p>
            <div class="test-author">
                <div class="test-avatar">RH</div>
                <div><div class="test-name">Rafiq H.</div><div class="test-role">Property Owner, Chattogram</div></div>
            </div>
        </div>
        <div class="test-card reveal" style="animation-delay:0.15s">
            <div class="test-stars">★★★★★</div>
            <p class="test-text">"I was skeptical about finding a bachelor mess online, but BasaFinder changed my mind. Found a great place with awesome roommates. Highly recommended!"</p>
            <div class="test-author">
                <div class="test-avatar">SK</div>
                <div><div class="test-name">Shahid K.</div><div class="test-role">Renter, Khulna</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ════════ FAQ ════════ -->
<section class="faq-section">
    <div class="section-header reveal">
        <span class="badge">Got Questions?</span>
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to the most common questions about renting with BasaFinder.</p>
    </div>
    <div class="faq-list">
        <div class="faq-item open">
            <button class="faq-question" onclick="toggleFaq(this)">
                How do I search for properties on BasaFinder?
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <div class="faq-answer"><p>Simply use the search bar on our homepage or browse through categories. You can filter by location, property type, rent range, bedrooms, and more to find exactly what you're looking for.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                Is BasaFinder free to use?
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <div class="faq-answer"><p>Yes! Browsing and searching for properties is completely free. Posting a property is also free for basic listings. We offer premium features for enhanced visibility at affordable rates.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                How are properties verified?
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <div class="faq-answer"><p>We verify each property through a multi-step process including owner identity verification, property documentation checks, and periodic quality reviews to ensure authenticity.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                Can I post a property for rent?
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <div class="faq-answer"><p>Absolutely! Click on "Post Property" in the navigation menu, fill in the details about your property, add photos, and submit. Your listing will go live after our verification process.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                How do I contact a property owner?
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <div class="faq-answer"><p>On each property detail page, you'll find a "Contact Owner" button. You can send a direct message, call, or WhatsApp the owner through the provided contact information.</p></div>
        </div>
    </div>
</section>

<!-- ════════ NEWSLETTER ════════ -->
<section class="newsletter-section reveal">
    <div class="newsletter-inner">
        <h3>Stay Updated</h3>
        <p>Get notified about new properties and exclusive deals straight to your inbox.</p>            <form class="newsletter-form" id="newsletterForm">
            <input type="email" placeholder="Enter your email address" required>
            <button type="submit">Subscribe</button>
        </form>
    </div>
</section>

<!-- ════════ APP CTA ════════ -->
<section class="app-cta-section">
    <div class="app-cta-inner">
        <h2>Find Properties on the Go</h2>
        <p>Download the BasaFinder mobile app and search for rental properties anytime, anywhere. Get instant notifications when new properties match your preferences.</p>
        <div class="app-cta-buttons">
            <a href="#">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                Download for iOS
            </a>
            <a href="#">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M3.609 1.814L13.792 12 3.61 22.186a.996.996 0 01-.61-.92V2.734a1 1 0 01.609-.92zm10.89 10.893l2.302 2.302-10.937 6.333 8.635-8.635zm3.199-3.199l2.807 1.626a1 1 0 010 1.732l-2.807 1.626L15.206 12l2.492-2.492zM5.864 2.658L16.8 8.99l-2.302 2.302-8.634-8.634z"/></svg>
                Download for Android
            </a>
        </div>
    </div>
</section>

<!-- ════════ BACK TO TOP ════════ -->
<button id="backToTop" aria-label="Back to top">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
</button>
@endsection

@push('scripts')
<script>
// Cache DOM elements
const scrollProgressEl = document.getElementById('scrollProgress');
const backToTopBtn = document.getElementById('backToTop');

// ─── Scroll Progress Bar ───
window.addEventListener('scroll', function() {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    scrollProgressEl.style.width = ((scrollTop / docHeight) * 100) + '%';

    if (scrollTop > 600) {
        backToTopBtn.classList.add('visible');
    } else {
        backToTopBtn.classList.remove('visible');
    }
});

// ─── Back to Top ───
backToTopBtn.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ─── Reveal Animations (Intersection Observer) ───
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
    revealObserver.observe(el);
});

// ─── Animated Counters ───
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseInt(el.dataset.target);
            if (isNaN(target)) return;
            let current = 0;
            const increment = Math.ceil(target / 60);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                } else {
                    el.textContent = current;
                }
            }, 20);
            counterObserver.unobserve(el);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));

// ─── FAQ Toggle ───
function toggleFaq(btn) {
    const item = btn.parentElement;
    const isOpen = item.classList.contains('open');
    // Close all
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}    // ─── Newsletter Form ───
    document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const input = this.querySelector('input');
        if (input.value) {
            alert('Thank you for subscribing! We\'ll keep you updated.');
            input.value = '';
        }
    });

    // ─── Favorite Buttons ───
    document.querySelectorAll('.fav-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            this.classList.add('liked');
            setTimeout(() => this.classList.remove('liked'), 400);
        });
    });

// ─── Hero Word Typewriter Carousel ───
(function() {
    const words = ['Home', 'Apartment', 'Flat', 'House', 'Room', 'Villa'];
    let wordIndex = 0;
    const el = document.getElementById('heroWord');
    if (!el) return;

    function typeWord(word, callback) {
        let i = 0;
        el.textContent = '';
        const type = setInterval(() => {
            el.textContent += word[i];
            i++;
            if (i >= word.length) {
                clearInterval(type);
                setTimeout(callback, 2000);
            }
        }, 80);
    }

    function deleteWord(callback) {
        const word = el.textContent;
        let i = word.length;
        const del = setInterval(() => {
            el.textContent = word.substring(0, i - 1);
            i--;
            if (i <= 0) {
                clearInterval(del);
                callback();
            }
        }, 40);
    }

    function cycle() {
        wordIndex = (wordIndex + 1) % words.length;
        deleteWord(() => typeWord(words[wordIndex], cycle));
    }

    // Start cycle after initial display
    setTimeout(cycle, 3000);
})();

// ─── Hero Image 3D Tilt Effect ───
(function() {
    const card = document.getElementById('tiltCard');
    if (!card || window.innerWidth < 1024) return;

    card.addEventListener('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -8;
        const rotateY = ((x - centerX) / centerX) * 8;
        this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });

    card.addEventListener('mouseleave', function() {
        this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
    });
})();
</script>
@endpush
