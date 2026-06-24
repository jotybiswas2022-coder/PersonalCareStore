@extends('frontend.layouts.app')

@section('title', 'Find Your Perfect Rental Home')

@push('styles')
<style>
/* ═══════════════════════════════════════════
   SCROLL PROGRESS
   ═══════════════════════════════════════════ */
#scrollProgress {
    position: fixed; top: 0; left: 0;
    height: 2.5px; z-index: 9999;
    background: linear-gradient(90deg, var(--primary), #7C3AED, var(--gold));
    background-size: 200% 100%;
    width: 0%;
    transition: width 0.1s linear;
    animation: progressGlow 3s ease-in-out infinite;
}
@keyframes progressGlow { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

/* ═══════════════════════════════════════════
   HERO
   ═══════════════════════════════════════════ */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: var(--navy);
}
.hero-mesh {
    position: absolute;
    inset: -50%;
    background:
        radial-gradient(ellipse 700px 450px at 15% 25%, rgba(37,99,235,0.22) 0%, transparent 60%),
        radial-gradient(ellipse 550px 400px at 85% 75%, rgba(124,58,237,0.15) 0%, transparent 60%),
        radial-gradient(ellipse 600px 500px at 50% 10%, rgba(37,99,235,0.10) 0%, transparent 60%),
        radial-gradient(ellipse 400px 350px at 70% 30%, rgba(245,158,11,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 450px 350px at 40% 80%, rgba(16,185,129,0.05) 0%, transparent 60%);
    animation: meshMove 20s ease-in-out infinite alternate;
    pointer-events: none;
    will-change: transform;
}
@keyframes meshMove {
    0%   { transform: translate(0,0) rotate(0deg) scale(1); }
    25%  { transform: translate(2%,-1%) rotate(0.5deg) scale(1.02); }
    50%  { transform: translate(-1%,1.5%) rotate(-0.5deg) scale(1.04); }
    75%  { transform: translate(1%,-1.5%) rotate(0.5deg) scale(1.02); }
    100% { transform: translate(-0.5%,0.5%) rotate(-0.5deg) scale(1.01); }
}
.hero-orbs { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
.hero-orbs .orb {
    position: absolute; border-radius: 50%;
    filter: blur(80px); opacity: 0.35;
    will-change: transform;
}
.hero-orbs .orb:nth-child(1) { width: 380px; height: 380px; background: rgba(37,99,235,0.18); top: 5%; left: 5%; }
.hero-orbs .orb:nth-child(2) { width: 300px; height: 300px; background: rgba(124,58,237,0.12); bottom: 10%; right: 10%; }
.hero-orbs .orb:nth-child(3) { width: 240px; height: 240px; background: rgba(245,158,11,0.08); top: 55%; left: 55%; }
.hero-orbs .orb:nth-child(4) { width: 200px; height: 200px; background: rgba(16,185,129,0.06); bottom: 25%; left: 20%; }
.hero-particles { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
.hero-particles span {
    position: absolute; display: block; border-radius: 50%;
    animation: floatParticle 22s infinite linear;
}
.hero-particles .p-dot { width: 3px; height: 3px; background: rgba(147,197,253,0.2); }
.hero-particles .p-glow { width: 5px; height: 5px; background: rgba(37,99,235,0.2); box-shadow: 0 0 10px 2px rgba(37,99,235,0.1); }
.hero-particles .p-gold { width: 4px; height: 4px; background: rgba(245,158,11,0.15); }
.hero-particles .p-trail {
    width: 3px; height: 3px; background: rgba(147,197,253,0.12);
    box-shadow: 0 0 6px 2px rgba(147,197,253,0.08);
    animation: floatParticleTrail 28s infinite linear;
}
@keyframes floatParticleTrail {
    0%   { transform: translateY(100vh) translateX(0) rotate(0deg); opacity: 0; }
    10%  { opacity: 0.5; }
    50%  { transform: translateY(-20vh) translateX(80px) rotate(360deg); opacity: 0.2; }
    90%  { opacity: 0.5; }
    100% { transform: translateY(-110vh) translateX(150px) rotate(720deg); opacity: 0; }
}
@keyframes floatParticle {
    0%   { transform: translateY(0) translateX(0) rotate(0deg); opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 1; }
    100% { transform: translateY(-100vh) translateX(50px) rotate(720deg); opacity: 0; }
}
.hero-particles span:nth-child(1)  { left: 8%;  top: 15%; animation-duration:28s; animation-delay:-2s; }
.hero-particles span:nth-child(2)  { left: 20%; top: 55%; animation-duration:22s; animation-delay:-5s; }
.hero-particles span:nth-child(3)  { left: 40%; top: 25%; animation-duration:26s; animation-delay:-8s; }
.hero-particles span:nth-child(4)  { left: 55%; top: 65%; animation-duration:24s; animation-delay:-3s; }
.hero-particles span:nth-child(5)  { left: 70%; top: 10%; animation-duration:30s; animation-delay:-10s; }
.hero-particles span:nth-child(6)  { left: 82%; top: 45%; animation-duration:19s; animation-delay:-6s; }
.hero-particles span:nth-child(7)  { left: 30%; top: 75%; animation-duration:28s; animation-delay:-12s; }
.hero-particles span:nth-child(8)  { left: 92%; top: 20%; animation-duration:23s; animation-delay:-7s; }
.hero-particles span:nth-child(9)  { left: 15%; top: 85%; animation-duration:25s; animation-delay:-4s; }
.hero-particles span:nth-child(10) { left: 65%; top: 80%; animation-duration:21s; animation-delay:-9s; }
.hero-particles span:nth-child(11) { left: 48%; top: 5%;  animation-duration:29s; animation-delay:-1s; }
.hero-particles span:nth-child(12) { left: 5%;  top: 45%; animation-duration:18s; animation-delay:-11s; }
.hero-particles span:nth-child(13) { left: 75%; top: 30%; animation-duration:24s; animation-delay:-3s; }
.hero-particles span:nth-child(14) { left: 50%; top: 50%; animation-duration:20s; animation-delay:-7s; }
.hero-particles span:nth-child(15) { left: 10%; top: 70%; animation-duration:28s; animation-delay:-5s; }
.hero-glow-rings { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
.hero-glow-rings .ring {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(37,99,235,0.06);
    animation: ringExpand 10s ease-out infinite;
}
.hero-glow-rings .ring:nth-child(1) { width: 250px; height: 250px; top: 15%; left: 28%; animation-delay: 0s; }
.hero-glow-rings .ring:nth-child(2) { width: 350px; height: 350px; bottom: 15%; right: 20%; animation-delay: 3.5s; }
.hero-glow-rings .ring:nth-child(3) { width: 180px; height: 180px; top: 65%; left: 8%; animation-delay: 7s; }
@keyframes ringExpand { 0% { transform: scale(0.4); opacity: 1; } 100% { transform: scale(3); opacity: 0; } }
.hero-grid-overlay {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
    animation: gridPulse 8s ease-in-out infinite;
}
@keyframes gridPulse { 0%,100% { opacity: 0.3; } 50% { opacity: 0.8; } }
.hero-glare {
    position: absolute; inset: 0; pointer-events: none; z-index: 1;
    opacity: 0; transition: opacity 0.5s ease;
    background: radial-gradient(700px circle at var(--mouse-x,50%) var(--mouse-y,50%), rgba(37,99,235,0.06) 0%, transparent 60%);
}
.hero-glare.active { opacity: 1; }

.hero .hero-grid {
    max-width: 1280px;
    margin: 0 auto;
    padding: 6rem 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
    width: 100%;
}

/* ── Hero Badge ── */
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(37,99,235,0.10);
    backdrop-filter: blur(16px) saturate(1.5);
    border: 1px solid rgba(37,99,235,0.15);
    color: #93C5FD;
    font-size: 0.8125rem;
    font-weight: 600;
    padding: 0.5rem 1.125rem;
    border-radius: 9999px;
    margin-bottom: 1.5rem;
    animation: fadeUp 0.7s ease-out both;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
}
.hero-badge:hover { background: rgba(37,99,235,0.15); border-color: rgba(37,99,235,0.3); transform: scale(1.02); }
.hero-badge::after {
    content: '';
    position: absolute; inset: -3px; border-radius: 9999px;
    background: conic-gradient(from 0deg, transparent, rgba(37,99,235,0.12), rgba(124,58,237,0.12), transparent);
    animation: badgeGlow 4s linear infinite;
    -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #fff calc(100% - 1px));
    mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #fff calc(100% - 1px));
    pointer-events: none;
}
@keyframes badgeGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.hero-badge .dot {
    width: 0.5rem; height: 0.5rem; background: #93C5FD; border-radius: 50%;
    animation: pulseDot 2s ease-in-out infinite; position: relative; z-index: 1;
    box-shadow: 0 0 8px rgba(147,197,253,0.4);
}
@keyframes pulseDot { 0%,100% { opacity:1; transform:scale(1); box-shadow:0 0 8px rgba(147,197,253,0.4); } 50% { opacity:0.6; transform:scale(0.8); box-shadow:0 0 16px rgba(147,197,253,0.6); } }

.hero h1 {
    font-family: var(--font-serif);
    font-size: 3.8rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.08;
    letter-spacing: -0.03em;
    margin-bottom: 1.25rem;
    animation: fadeUp 0.7s ease-out 0.1s both;
    text-shadow: 0 2px 40px rgba(0,0,0,0.3);
}
.hero h1 .highlight {
    background: linear-gradient(135deg, #60A5FA, #A78BFA, #FCD34D, #60A5FA);
    background-size: 300% 300%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 6s ease-in-out infinite;
}
@keyframes gradientShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
.hero h1 .typewriter-text {
    display: inline-block; position: relative;
    color: #FCD34D;
    text-shadow: 0 0 30px rgba(252,211,77,0.2);
}
.hero h1 .typewriter-text::after {
    content: '';
    position: absolute; right: -6px; top: 50%; transform: translateY(-50%);
    width: 2.5px; height: 70%;
    background: #FCD34D;
    animation: blink 0.8s step-end infinite;
}
@keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0; } }
.hero p {
    font-size: 1.0625rem;
    color: rgba(255,255,255,0.5);
    max-width: 30rem;
    line-height: 1.75;
    margin-bottom: 2rem;
    animation: fadeUp 0.7s ease-out 0.2s both;
}

/* ── Glass Search Card ── */
.hero-search {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(28px) saturate(1.5);
    -webkit-backdrop-filter: blur(28px) saturate(1.5);
    border-radius: 20px;
    padding: 1.25rem;
    animation: fadeUp 0.7s ease-out 0.3s both;
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.06);
    position: relative;
    overflow: hidden;
}
.hero-search::before {
    content: '';
    position: absolute; inset: 0; border-radius: 20px; padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(37,99,235,0.2), rgba(124,58,237,0.2), rgba(245,158,11,0.12), rgba(255,255,255,0.08));
    background-size: 400% 400%;
    animation: glassBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes glassBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
.hero-search::after {
    content: '';
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(96,165,250,0.03) 0%, transparent 50%);
    animation: glassShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes glassShine {
    0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; }
    25%  { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; }
    50%  { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; }
    75%  { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; }
}
.hero-search:hover {
    box-shadow: 0 16px 56px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.08);
    transform: translateY(-3px);
}
.hero-search-row { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.hero-search .search-field { flex: 1; min-width: 140px; position: relative; }
.hero-search .search-field .icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); pointer-events: none; transition: color 0.3s; }
.hero-search .search-field:focus-within .icon { color: #60A5FA; }
.hero-search select, .hero-search input {
    width: 100%;
    padding: 0.8125rem 0.875rem 0.8125rem 2.25rem;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px;
    color: #fff;
    font-size: 0.875rem;
    font-family: var(--font);
    outline: none;
    transition: all 0.3s;
    -webkit-appearance: none;
    appearance: none;
    cursor: pointer;
    backdrop-filter: blur(4px);
}
.hero-search select option { background: #1E293B; color: #fff; }
.hero-search select:focus, .hero-search input:focus {
    border-color: rgba(37,99,235,0.4);
    background: rgba(37,99,235,0.08);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.06);
}
.hero-search select:hover, .hero-search input:hover { background: rgba(255,255,255,0.08); }
.hero-search .btn-search {
    padding: 0.8125rem 2rem;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    font-family: var(--font);
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
    position: absolute; inset: 0;
    background: linear-gradient(135deg, transparent 20%, rgba(255,255,255,0.1) 50%, transparent 80%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}
.hero-search .btn-search:hover::before { transform: translateX(100%); }
.hero-search .btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(37,99,235,0.5);
}

/* ── Glass Stats ── */
.hero-stats {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
    animation: fadeUp 0.7s ease-out 0.4s both;
}
.hero-stat {
    position: relative;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(8px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.04);
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    overflow: hidden;
}
.hero-stat:hover {
    background: rgba(255,255,255,0.05);
    border-color: rgba(37,99,235,0.12);
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.hero-stat .num { font-size: 1.5rem; font-weight: 800; color: #FCD34D; line-height: 1; }
.hero-stat .label { font-size: 0.8125rem; color: rgba(255,255,255,0.4); margin-top: 0.25rem; }
.hero-stat .stat-shine {
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 30% 40%, rgba(96,165,250,0.03) 0%, transparent 50%);
    animation: statShine 5s ease-in-out infinite;
    pointer-events: none;
}
@keyframes statShine { 0%,100% { transform: translate(0,0); opacity: 0.2; } 50% { transform: translate(-5%,5%); opacity: 0.6; } }

/* ── Hero Visual ── */
.hero-visual { display: flex; align-items: center; justify-content: center; animation: fadeUp 0.7s ease-out 0.5s both; }
.hero-image-card { position: relative; width: 100%; max-width: 520px; transform-style: preserve-3d; perspective: 1000px; }
.hero-image-card .main-img {
    width: 100%; border-radius: 24px;
    box-shadow: 0 24px 80px rgba(0,0,0,0.5);
    background: linear-gradient(135deg, #0F172A, #1E3A5F);
    aspect-ratio: 4/3;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; position: relative;
    transition: transform 0.5s cubic-bezier(0.16,1,0.3,1);
    border: 1px solid rgba(255,255,255,0.06);
}
.hero-image-card .main-img::after {
    content: '';
    position: absolute; inset: 0; border-radius: 24px;
    background: linear-gradient(135deg, rgba(37,99,235,0.06), transparent 40%, transparent 60%, rgba(124,58,237,0.04));
    animation: imgGlassPulse 4s ease-in-out infinite;
    pointer-events: none;
}
@keyframes imgGlassPulse { 0%,100% { opacity: 0.3; } 50% { opacity: 0.8; } }
.hero-image-card:hover .main-img { transform: scale(1.02); }
.hero-image-card .main-img .placeholder-icon { width: 60%; height: 60%; opacity: 0.1; color: rgba(96,165,250,0.3); }
.hero-image-card .floating-card {
    position: absolute;
    background: rgba(15,23,42,0.5);
    backdrop-filter: blur(28px) saturate(1.5);
    -webkit-backdrop-filter: blur(28px) saturate(1.5);
    border: 1.5px solid rgba(96,165,250,0.08);
    border-radius: 16px;
    padding: 1rem 1.25rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.25), inset 0 1px 0 rgba(255,255,255,0.06);
    display: flex; align-items: center; gap: 0.75rem;
    animation: float 6s ease-in-out infinite;
    transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
    overflow: hidden;
}
.hero-image-card .floating-card::before {
    content: '';
    position: absolute; inset: -2px; border-radius: 16px;
    background: conic-gradient(from calc(var(--float-angle,0)*1deg), transparent, rgba(37,99,235,0.15), rgba(124,58,237,0.15), transparent);
    animation: floatBorderGlow 6s linear infinite;
    -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #fff calc(100% - 1.5px));
    mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #fff calc(100% - 1.5px));
    pointer-events: none;
}
@keyframes floatBorderGlow { 0% { --float-angle: 0; } 100% { --float-angle: 360; } }
@property --float-angle { syntax: '<number>'; initial-value: 0; inherits: false; }
.hero-image-card .floating-card:hover { transform: scale(1.12) translateY(-4px) !important; background: rgba(15,23,42,0.6); box-shadow: 0 12px 40px rgba(0,0,0,0.35); }
.hero-image-card .floating-card:nth-child(2) { top: 5%; right: -10%; animation-delay: 0s; }
.hero-image-card .floating-card:nth-child(3) { bottom: 8%; left: -8%; animation-delay: 2s; animation-duration: 7s; }
.floating-card .fc-icon { width: 2.5rem; height: 2.5rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.floating-card .fc-icon.blue { background: rgba(37,99,235,0.15); color: #60A5FA; }
.floating-card .fc-icon.gold { background: rgba(245,158,11,0.12); color: #FCD34D; }
.floating-card .fc-text .fc-num { font-weight: 700; font-size: 0.9375rem; color: #fff; }
.floating-card .fc-text .fc-label { font-size: 0.75rem; color: rgba(255,255,255,0.45); }
@keyframes float { 0%,100% { transform: translateY(0) rotate(0deg); } 33% { transform: translateY(-14px) rotate(0.5deg); } 66% { transform: translateY(-6px) rotate(-0.3deg); } }

@media (max-width: 1024px) {
    .hero .hero-grid { grid-template-columns: 1fr; gap: 2rem; padding: 5rem 1.5rem 3rem; text-align: center; }
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
    .hero .hero-grid { padding: 3rem 1rem 2.5rem; }
    .hero h1 { font-size: 2rem; }
    .hero p { font-size: 0.9375rem; }
    .hero-stats { gap: 1.25rem; flex-wrap: wrap; }
    .hero-stat .num { font-size: 1.25rem; }
}

/* ═══════════════════════════════════════════
   FEATURED PROPERTIES
   ═══════════════════════════════════════════ */
.featured-section {
    padding: 6rem 0;
    background: var(--bg);
    position: relative;
}
.featured-section::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 20%, rgba(37,99,235,0.03) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 80%, rgba(245,158,11,0.02) 0%, transparent 60%);
    pointer-events: none;
}
.prop-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}
@media (max-width: 1100px) { .prop-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px)  { .prop-grid { grid-template-columns: 1fr; padding: 0 1rem; } }

.prop-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.16,1,0.3,1);
    position: relative;
    box-shadow: var(--shadow-sm);
}
.prop-card::after {
    content: '';
    position: absolute; inset: 0;
    border-radius: var(--r-lg);
    border: 1px solid rgba(37,99,235,0.2);
    opacity: 0;
    transition: opacity 0.5s;
    pointer-events: none;
}
.prop-card:hover::after { opacity: 1; }
.prop-card:hover {
    box-shadow: var(--shadow-xl);
    transform: translateY(-8px);
}
.prop-card .prop-img {
    position: relative;
    height: 220px;
    background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
    overflow: hidden;
}
.prop-card .prop-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s cubic-bezier(0.16,1,0.3,1); }
.prop-card:hover .prop-img img { transform: scale(1.1); }
.prop-card .prop-img .img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(15,23,42,0.4));
    opacity: 0;
    transition: opacity 0.5s;
}
.prop-card:hover .prop-img .img-overlay { opacity: 1; }
.prop-card .prop-img .prop-badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 0.5rem; flex-wrap: wrap; z-index: 2; }
.prop-card .prop-img .badge {
    padding: 0.3rem 0.75rem; border-radius: 4px;
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;
}
.badge-featured { background: var(--primary); color: #fff; }
.badge-verified { background: var(--success); color: #fff; }
.badge-new { background: var(--navy); color: var(--white); }
.prop-card .prop-img .fav-btn {
    position: absolute; top: 12px; right: 12px;
    width: 2.25rem; height: 2.25rem;
    background: rgba(255,255,255,0.9);
    border: 1px solid var(--border);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
    color: var(--text-muted);
    z-index: 2;
}
.prop-card .prop-img .fav-btn:hover { background: rgba(37,99,235,0.08); color: var(--primary); transform: scale(1.15); border-color: var(--primary); }
.prop-card .prop-img .fav-btn.active { background: rgba(37,99,235,0.1); color: var(--primary); border-color: var(--primary); }
.prop-card .prop-img .fav-btn.active svg { fill: var(--primary); }
.prop-card .prop-img .fav-btn.liked { animation: heartPop 0.4s cubic-bezier(0.34,1.56,0.64,1); }
@keyframes heartPop { 0% { transform: scale(1); } 50% { transform: scale(1.3); } 100% { transform: scale(1); } }
.prop-card .prop-img .price-tag {
    position: absolute; bottom: 12px; left: 12px;
    background: rgba(15,23,42,0.85);
    color: #FCD34D;
    padding: 0.4rem 1rem; border-radius: 6px;
    font-size: 1rem; font-weight: 700; z-index: 2;
    font-family: var(--font-serif);
}
.prop-card .prop-img .price-tag small { font-size: 0.6875rem; font-weight: 400; opacity: 0.6; }
.prop-card .prop-body { padding: 1.25rem; position: relative; z-index: 1; }
.prop-card .prop-body .prop-title {
    font-family: var(--font);
    font-size: 1.125rem; font-weight: 700;
    color: var(--text);
    margin-bottom: 0.375rem;
    transition: color 0.3s;
}
.prop-card:hover .prop-body .prop-title { color: var(--primary); }
.prop-card .prop-body .prop-location { display: flex; align-items: center; gap: 0.375rem; color: var(--text-muted); font-size: 0.8125rem; margin-bottom: 0.75rem; }
.prop-card .prop-body .prop-meta { display: flex; gap: 1rem; padding-top: 0.75rem; border-top: 1px solid var(--border); }
.prop-card .prop-body .prop-meta span { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: var(--text-muted); }
.prop-card .prop-body .prop-meta span svg { color: var(--primary); }
.prop-card .prop-body .prop-actions { display: flex; gap: 0.75rem; margin-top: 1rem; }
.prop-card .prop-body .prop-actions a {
    flex: 1; text-align: center; padding: 0.625rem; border-radius: var(--r-sm);
    font-size: 0.8125rem; font-weight: 600; transition: all 0.3s; text-decoration: none;
}
.prop-card .prop-body .prop-actions a:first-child { background: var(--primary); color: #fff; }
.prop-card .prop-body .prop-actions a:first-child:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
.prop-card .prop-body .prop-actions a:last-child { background: var(--bg); color: var(--text); border: 1px solid var(--border); }
.prop-card .prop-body .prop-actions a:last-child:hover { background: var(--primary-light); color: var(--primary-dark); border-color: var(--primary); }
@media (max-width: 640px) { .prop-card .prop-img { height: 200px; } }
.browse-more { text-align: center; margin-top: 2.5rem; }

/* ═══════════════════════════════════════════
   HOW IT WORKS
   ═══════════════════════════════════════════ */
.how-section {
    padding: 6rem 0;
    background: var(--navy);
    position: relative;
    overflow: hidden;
}
.how-section::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 700px 450px at 20% 20%, rgba(37,99,235,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 500px 400px at 80% 80%, rgba(245,158,11,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.how-section .section-heading { color: var(--white); }
.how-section .section-heading .highlight { color: var(--gold); }
.how-section .section-sub { color: rgba(255,255,255,0.5); }
.how-section .section-eyebrow { color: #93C5FD; }
.how-section .section-eyebrow::before { background: #93C5FD; }

.steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
.step-card {
    text-align: center;
    padding: 2.75rem 2rem;
    position: relative;
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(24px) saturate(1.6);
    -webkit-backdrop-filter: blur(24px) saturate(1.6);
    border-radius: var(--r-lg);
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.06);
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    overflow: hidden;
}
.step-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: var(--r-lg); padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(37,99,235,0.15), rgba(124,58,237,0.15), rgba(245,158,11,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: stepBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes stepBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
.step-card::after {
    content: '';
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(96,165,250,0.04) 0%, transparent 50%);
    animation: stepShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes stepShine {
    0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; }
    25%  { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; }
    50%  { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; }
    75%  { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; }
}
.step-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 56px rgba(0,0,0,0.3), 0 0 40px rgba(37,99,235,0.06), inset 0 1px 0 rgba(255,255,255,0.1);
    border-color: rgba(37,99,235,0.25);
    background: rgba(255,255,255,0.06);
}
.step-connector {
    position: absolute; top: 3rem; right: -1rem;
    width: 2rem; height: 1px;
    background: linear-gradient(90deg, rgba(37,99,235,0.4), transparent);
}
.step-num {
    width: 3.5rem; height: 3.5rem;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    color: #fff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 800;
    margin: 0 auto 1.25rem;
    transition: all 0.5s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}
.step-card:hover .step-num { transform: scale(1.15) rotate(360deg); box-shadow: 0 8px 24px rgba(37,99,235,0.5); }
.step-card h3 { font-size: 1.125rem; font-weight: 700; color: var(--white); margin-bottom: 0.5rem; font-family: var(--font-serif); }
.step-card p { font-size: 0.875rem; color: rgba(255,255,255,0.5); line-height: 1.7; }
@media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; gap: 1rem; } .step-card::after { display: none; } }

/* ═══════════════════════════════════════════
   WHY CHOOSE US
   ═══════════════════════════════════════════ */
.why-section {
    padding: 6rem 0;
    background: var(--bg);
    position: relative;
}
.why-section::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 700px 400px at 80% 20%, rgba(37,99,235,0.03) 0%, transparent 60%);
    pointer-events: none;
}
.why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}
.why-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    position: relative;
    overflow: hidden;
}
.why-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--primary), #7C3AED);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.why-card:hover::before { transform: scaleX(1); }
.why-card:hover { box-shadow: var(--shadow-xl); transform: translateY(-6px); border-color: var(--border-light); }
.why-card .w-icon {
    width: 3rem; height: 3rem; border-radius: 12px;
    background: var(--primary-light);
    color: var(--primary);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.25rem; font-size: 1.25rem;
    transition: all 0.4s;
}
.why-card:hover .w-icon { background: var(--primary); color: #fff; transform: scale(1.1) rotate(-6deg); }
.why-card h3 { font-family: var(--font-serif); font-size: 1.125rem; font-weight: 700; color: var(--text); margin-bottom: 0.5rem; }
.why-card p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.7; }

/* ═══════════════════════════════════════════
   POPULAR CITIES
   ═══════════════════════════════════════════ */
.cities-section {
    padding: 6rem 0;
    background: var(--navy);
    position: relative;
}
.cities-section::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 800px 500px at 50% 50%, rgba(37,99,235,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.cities-section .section-heading { color: var(--white); }
.cities-section .section-heading .highlight { color: var(--gold); }
.cities-section .section-sub { color: rgba(255,255,255,0.5); }
.cities-section .section-eyebrow { color: #93C5FD; }
.cities-section .section-eyebrow::before { background: #93C5FD; }

.cities-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 0.875rem;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}
@media (max-width: 1100px) { .cities-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 640px)  { .cities-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; padding: 0 1rem; } }
.city-card {
    position: relative;
    border-radius: var(--r-lg);
    overflow: hidden;
    height: 200px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(20px) saturate(1.5);
    -webkit-backdrop-filter: blur(20px) saturate(1.5);
    display: flex;
    align-items: flex-end;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.06);
}
.city-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: var(--r-lg); padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(37,99,235,0.15), rgba(124,58,237,0.15), rgba(245,158,11,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: cityBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes cityBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
.city-card::after {
    content: '';
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(96,165,250,0.04) 0%, transparent 50%);
    animation: cityShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes cityShine {
    0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; }
    25%  { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; }
    50%  { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; }
    75%  { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; }
}
.city-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 20px 56px rgba(0,0,0,0.35), 0 0 40px rgba(37,99,235,0.08), inset 0 1px 0 rgba(255,255,255,0.1);
    border-color: rgba(37,99,235,0.25);
}
.city-card .city-bg-icon { position: absolute; top: 1rem; right: 1rem; width: 3.5rem; height: 3.5rem; opacity: 0.10; z-index: 1; color: #fff; }
.city-card .city-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, transparent 20%, rgba(15,23,42,0.85)); }
.city-card .city-info { position: relative; z-index: 1; padding: 1.25rem 1.25rem 1.5rem; width: 100%; transform: translateY(0); transition: transform 0.4s; }
.city-card:hover .city-info { transform: translateY(-4px); }
.city-card .city-info h3 { color: #fff; font-size: 1.125rem; font-weight: 700; font-family: var(--font-serif); text-shadow: 0 2px 12px rgba(0,0,0,0.3); }
.city-card .city-info p { color: rgba(147,197,253,0.6); font-size: 0.75rem; margin-top: 0.125rem; }
.city-card:nth-child(1) { background: rgba(30,58,95,0.5); }
.city-card:nth-child(2) { background: rgba(6,95,70,0.45); }
.city-card:nth-child(3) { background: rgba(76,29,149,0.5); }
.city-card:nth-child(4) { background: rgba(180,83,9,0.45); }
.city-card:nth-child(5) { background: rgba(15,23,42,0.6); }
.city-card:nth-child(6) { background: rgba(30,64,175,0.5); }
.city-card:nth-child(7) { background: rgba(6,95,70,0.45); }
.city-card:nth-child(8) { background: rgba(131,24,67,0.5); }

/* ═══════════════════════════════════════════
   TESTIMONIALS
   ═══════════════════════════════════════════ */
.testimonials-section {
    padding: 6rem 0 4rem;
    background: linear-gradient(180deg, var(--navy) 0%, #0D1325 30%, var(--secondary) 70%, #0B1121 100%);
    position: relative;
    overflow: hidden;
}
.testimonials-section::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 700px 450px at 20% 20%, rgba(37,99,235,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 500px 400px at 80% 80%, rgba(245,158,11,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.testimonials-section .section-heading { color: var(--white); }
.testimonials-section .section-heading .highlight { color: var(--gold); }
.testimonials-section .section-sub { color: rgba(255,255,255,0.5); }
.testimonials-section .section-eyebrow { color: #93C5FD; }
.testimonials-section .section-eyebrow::before { background: #93C5FD; }

.test-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}
.test-card {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(20px) saturate(1.5);
    -webkit-backdrop-filter: blur(20px) saturate(1.5);
    border-radius: var(--r-lg);
    border: 1px solid rgba(255,255,255,0.08);
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.06);
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    position: relative;
    overflow: hidden;
}
.test-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: var(--r-lg); padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(37,99,235,0.15), rgba(124,58,237,0.15), rgba(245,158,11,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: testBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes testBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
.test-card .test-glow {
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(96,165,250,0.04) 0%, transparent 50%);
    animation: testShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes testShine {
    0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; }
    25%  { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; }
    50%  { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; }
    75%  { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; }
}
.test-card:hover {
    box-shadow: 0 20px 56px rgba(0,0,0,0.3), 0 0 40px rgba(37,99,235,0.06), inset 0 1px 0 rgba(255,255,255,0.1);
    transform: translateY(-8px);
    border-color: rgba(37,99,235,0.25);
    background: rgba(255,255,255,0.06);
}
.test-card .test-quote {
    position: absolute; top: 0.25rem; right: 1.5rem;
    font-family: var(--font-serif);
    font-size: 5rem; color: #60A5FA; opacity: 0.08;
    line-height: 1; pointer-events: none;
}
.test-card .test-stars { color: var(--gold); margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: 2px; position: relative; z-index: 1; }
.test-card .test-text { font-size: 0.9375rem; color: rgba(255,255,255,0.6); line-height: 1.7; margin-bottom: 1.25rem; font-style: italic; position: relative; z-index: 1; }
.test-card .test-author { display: flex; align-items: center; gap: 0.75rem; position: relative; z-index: 1; }
.test-card .test-avatar {
    width: 2.5rem; height: 2.5rem; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.875rem;
    transition: transform 0.3s;
    box-shadow: 0 0 20px rgba(37,99,235,0.2);
}
.test-card:hover .test-avatar { transform: scale(1.1); }
.test-card .test-name { font-size: 0.875rem; font-weight: 600; color: #fff; }
.test-card .test-role { font-size: 0.75rem; color: rgba(255,255,255,0.4); }

/* ═══════════════════════════════════════════
   FAQ
   ═══════════════════════════════════════════ */
.faq-section {
    padding: 6rem 0 4rem;
    background: linear-gradient(180deg, var(--navy) 0%, #0D1325 50%, var(--secondary) 100%);
    position: relative;
    overflow: hidden;
}
.faq-section .section-heading { color: var(--white); }
.faq-section .section-heading .highlight { color: var(--gold); }
.faq-section .section-sub { color: rgba(255,255,255,0.5); }
.faq-section .section-eyebrow { color: #93C5FD; }
.faq-section .section-eyebrow::before { background: #93C5FD; }
.faq-list { max-width: 720px; margin: 0 auto; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; position: relative; z-index: 1; }
.faq-item {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(16px) saturate(1.4);
    -webkit-backdrop-filter: blur(16px) saturate(1.4);
    border-radius: var(--r-md);
    border: 1px solid rgba(255,255,255,0.08);
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.04);
}
.faq-item:hover { border-color: rgba(37,99,235,0.25); background: rgba(255,255,255,0.06); }
.faq-item.open { border-color: rgba(37,99,235,0.3); box-shadow: 0 4px 24px rgba(0,0,0,0.2); }
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
    color: rgba(255,255,255,0.85);
    font-family: var(--font);
    text-align: left;
    transition: color 0.3s;
}
.faq-item.open .faq-question { color: #60A5FA; }
.faq-question svg { transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1); flex-shrink: 0; color: #60A5FA; }
.faq-item.open .faq-question svg { transform: rotate(45deg); color: #60A5FA; }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.4s ease; }
.faq-item.open .faq-answer { max-height: 300px; padding: 0 1.25rem 1.125rem; }
.faq-answer p { font-size: 0.875rem; color: rgba(255,255,255,0.5); line-height: 1.7; }

/* ═══════════════════════════════════════════
   BACK TO TOP
   ═══════════════════════════════════════════ */
#backToTop {
    position: fixed; bottom: 2rem; right: 2rem;
    width: 3rem; height: 3rem;
    background: var(--primary);
    color: #fff; border: none; border-radius: 50%;
    cursor: pointer; font-size: 1.25rem;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
    z-index: 999;
    display: flex; align-items: center; justify-content: center;
    opacity: 0;
    transform: translateY(20px) scale(0.8);
    transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
    pointer-events: none;
}
#backToTop.visible { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
#backToTop:hover { transform: translateY(-4px) scale(1.05); box-shadow: 0 8px 24px rgba(37,99,235,0.4); }
</style>
@endpush

@section('content')
<!-- ════════ SCROLL PROGRESS ════════ -->
<div id="scrollProgress"></div>

<!-- ════════ HERO ════════ -->
<section class="hero" id="hero">
    <div class="hero-mesh"></div>
    <div class="hero-grid-overlay"></div>
    <div class="hero-glow-rings">
        <div class="ring"></div><div class="ring"></div><div class="ring"></div>
    </div>
    <div class="hero-glare" id="heroGlare"></div>
    <div class="hero-orbs">
        <div class="orb"></div><div class="orb"></div><div class="orb"></div><div class="orb"></div>
    </div>
    <div class="hero-particles">
        <span class="p-dot"></span><span class="p-glow"></span><span class="p-dot"></span><span class="p-gold"></span>
        <span class="p-dot"></span><span class="p-glow"></span><span class="p-trail"></span><span class="p-dot"></span>
        <span class="p-gold"></span><span class="p-dot"></span><span class="p-glow"></span><span class="p-dot"></span>
        <span class="p-dot"></span><span class="p-trail"></span><span class="p-gold"></span>
    </div>

    <div class="hero-grid">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Trusted by 10,000+ Renters &amp; Landlords
            </div>
            <h1>Find Your <span class="highlight">Perfect Rental</span><br><span class="typewriter-text" id="heroWord">Home</span></h1>
            <p>Discover thousands of verified rental properties across Bangladesh. From city flats to suburban houses, find your ideal space with confidence.</p>

            <div class="hero-search">
                <form action="{{ route('search') }}" class="hero-search-row" id="heroSearchForm">
                    <div class="search-field">
                        <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                        <select name="division">
                            <option value="">All Locations</option>
                            <option value="Dhaka">Dhaka</option><option value="Chattogram">Chattogram</option><option value="Khulna">Khulna</option>
                            <option value="Rajshahi">Rajshahi</option><option value="Sylhet">Sylhet</option><option value="Barisal">Barisal</option>
                            <option value="Rangpur">Rangpur</option><option value="Mymensingh">Mymensingh</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                        <select name="property_type">
                            <option value="">All Types</option>
                            <option value="Flat">Flat</option><option value="House">House</option><option value="Sublet">Sublet</option>
                            <option value="Bachelor Mess">Bachelor Mess</option><option value="Office">Office</option><option value="Shop">Shop</option><option value="Hostel">Hostel</option><option value="Room">Room</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                        <select name="rent" id="heroRent">
                            <option value="">Any Rent</option>
                            <option value="0-5000">Under 5,000</option><option value="5000-10000">5,000 - 10,000</option>
                            <option value="10000-20000">10,000 - 20,000</option><option value="20000-50000">20,000 - 50,000</option><option value="50000-99999999">50,000+</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-search">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                        Search
                    </button>
                </form>
                <script>
                document.getElementById('heroSearchForm')?.addEventListener('submit', function(e) {
                    var rent = document.getElementById('heroRent');
                    if (rent && rent.value) {
                        var parts = rent.value.split('-');
                        var min = document.createElement('input');
                        min.type = 'hidden'; min.name = 'min_rent'; min.value = parts[0];
                        this.appendChild(min);
                        var max = document.createElement('input');
                        max.type = 'hidden'; max.name = 'max_rent'; max.value = parts[1];
                        this.appendChild(max);
                        rent.removeAttribute('name');
                    }
                });
                </script>
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
                    <svg class="placeholder-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9.78V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v.24L12 3 2 12h3v7a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-7h3l-3-3.22z"/></svg>
                </div>
                <div class="floating-card">
                    <div class="fc-icon blue"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="fc-text"><div class="fc-num">Verified</div><div class="fc-label">Properties Only</div></div>
                </div>
                <div class="floating-card">
                    <div class="fc-icon gold"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="fc-text"><div class="fc-num">Quick</div><div class="fc-label">Response Time</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════ FEATURED PROPERTIES ════════ -->
<section id="properties" class="featured-section">
    <div class="section-header centered reveal">
        <span class="section-eyebrow">Handpicked for You</span>
        <h2 class="section-heading">Featured <span class="highlight">Properties</span></h2>
        <p class="section-sub">Explore our premium selection of verified rental properties across Bangladesh.</p>
    </div>
    <div class="prop-grid">
        @forelse($featuredProperties as $property)
            <div class="prop-card reveal">
                <div class="prop-img">
                    <div class="img-overlay"></div>
                    @if($property->first_image)
                        <img src="{{ $property->first_image }}" alt="{{ $property->title }}">
                    @else
                        <div style="padding:2.5rem; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:rgba(37,99,235,0.2);">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                    @endif
                    <div class="prop-badges">
                        <span class="badge badge-featured">Featured</span>
                        <span class="badge badge-verified">Verified</span>
                    </div>
                    <button class="fav-btn" aria-label="Add to favorites">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    </button>
                    <div class="price-tag">BDT {{ number_format($property->monthly_rent) }} <small>/mo</small></div>
                </div>
                <div class="prop-body">
                    <h3 class="prop-title">{{ $property->title }}</h3>
                    <div class="prop-location">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $property->area_location }}, {{ $property->district }}
                    </div>
                    <div class="prop-meta">
                        <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> {{ $property->bedrooms }} {{ Str::plural('Bed', $property->bedrooms) }}</span>
                        <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 21h16"/><path d="M6 21v-7"/><path d="M18 21v-7"/><rect x="2" y="3" width="20" height="11" rx="2"/></svg> {{ $property->bathrooms }} {{ Str::plural('Bath', $property->bathrooms) }}</span>
                        @if($property->property_size)
                            <span><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg> {{ number_format($property->property_size) }} sqft</span>
                        @endif
                    </div>
                    <div class="prop-actions">
                        <a href="{{ route('property-detail', $property->id) }}">View Details</a>
                        <a href="tel:{{ $property->contact_phone }}">Contact Owner</a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:3rem 1rem;">
                <div style="font-size:2.5rem; margin-bottom:1rem;">🏠</div>
                <h3 style="font-size:1.25rem; font-weight:700; color:var(--text); margin-bottom:0.5rem;">No Properties Yet</h3>
                <p style="color:var(--text-muted); font-size:0.9375rem;">Check back soon for featured rental properties.</p>
            </div>
        @endforelse
    </div>
    <div class="browse-more reveal">
        <a href="{{ route('search') }}" class="btn btn-dark">
            Browse All Properties
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7"/></svg>
        </a>
    </div>
</section>

<!-- ════════ HOW IT WORKS ════════ -->
<section class="how-section">
    <div class="section-header centered reveal">
        <span class="section-eyebrow">Simple Process</span>
        <h2 class="section-heading">How It <span class="highlight">Works</span></h2>
        <p class="section-sub">Finding your perfect rental home is just three simple steps away.</p>
    </div>
    <div class="steps-grid">
        <div class="step-card reveal" style="position:relative;">
            <div class="step-connector"></div>
            <div class="step-num">1</div>
            <h3>Search Properties</h3>
            <p>Browse thousands of verified rental properties across Bangladesh using our smart search and filters.</p>
        </div>
        <div class="step-card reveal" style="position:relative;">
            <div class="step-connector"></div>
            <div class="step-num">2</div>
            <h3>Compare &amp; Connect</h3>
            <p>Compare properties side-by-side and connect directly with verified owners or agents.</p>
        </div>
        <div class="step-card reveal">
            <div class="step-num">3</div>
            <h3>Move In Confidently</h3>
            <p>Finalize your rental with full confidence. We're with you every step of the way.</p>
        </div>
    </div>
</section>

<!-- ════════ WHY CHOOSE US ════════ -->
<section class="why-section">
    <div class="section-header centered reveal">
        <span class="section-eyebrow">Why BasaFinder</span>
        <h2 class="section-heading">Why Choose <span class="highlight">Us</span></h2>
        <p class="section-sub">We make renting simple, safe, and stress-free for everyone.</p>
    </div>
    <div class="why-grid">
        <div class="why-card reveal">
            <div class="w-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
            <h3>Verified Properties</h3>
            <p>Every listing is verified to ensure you get authentic, high-quality rental options with genuine owners.</p>
        </div>
        <div class="why-card reveal">
            <div class="w-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
            <h3>Lightning Fast</h3>
            <p>Get instant matches and quick responses from property owners. No more waiting days for replies.</p>
        </div>
        <div class="why-card reveal">
            <div class="w-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
            <h3>Secure Platform</h3>
            <p>Your privacy and security are our top priorities. Rent with confidence on our trusted platform.</p>
        </div>
        <div class="why-card reveal">
            <div class="w-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <h3>24/7 Support</h3>
            <p>Our dedicated team is always available to help you with any questions or concerns, anytime.</p>
        </div>
    </div>
</section>

<!-- ════════ POPULAR CITIES ════════ -->
<section class="cities-section">
    <div class="section-header centered reveal">
        <span class="section-eyebrow">Find Properties Across</span>
        <h2 class="section-heading">Popular <span class="highlight">Cities</span></h2>
        <p class="section-sub">Browse rental properties in major cities all across Bangladesh.</p>
    </div>
    <div class="cities-grid">
        @php $cities = ['Dhaka','Chattogram','Khulna','Rajshahi','Sylhet','Barishal','Rangpur','Mymensingh']; @endphp
        @foreach($cities as $i => $city)
            @php $count = $divisionCounts[$city] ?? 0; @endphp
            <a href="{{ route('search', ['division' => $city]) }}" class="city-card reveal">
                <svg class="city-bg-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9.78V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v.24L12 3 2 12h3v7a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-7h3l-3-3.22z"/></svg>
                <div class="city-overlay"></div>
                <div class="city-info"><h3>{{ $city }}</h3><p>{{ $count > 0 ? number_format($count) . '+ Properties' : 'Browse Properties' }}</p></div>
            </a>
        @endforeach
    </div>
</section>

<!-- ════════ FAQ ════════ -->
<section class="faq-section">
    <div class="section-header centered reveal">
        <span class="section-eyebrow">Got Questions?</span>
        <h2 class="section-heading">Frequently Asked <span class="highlight">Questions</span></h2>
        <p class="section-sub">Find answers to the most common questions about renting with BasaFinder.</p>
    </div>
    <div class="faq-list">
        @forelse($faqs as $i => $f)
            <div class="faq-item {{ $i === 0 ? 'open' : '' }}">
                <button class="faq-question" onclick="toggleFaq(this)">
                    {{ $f->question }}
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <div class="faq-answer"><p>{{ $f->answer }}</p></div>
            </div>
        @empty
            <div style="text-align:center; padding:2rem 1rem;">
                <h3 style="font-size:1rem; font-weight:600; color:var(--text);">No FAQs Available</h3>
                <p style="color:var(--text-muted); font-size:0.875rem;">Check back soon for answers.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- ════════ TESTIMONIALS ════════ -->
<section class="testimonials-section">
    <div class="section-header centered reveal">
        <span class="section-eyebrow">What They Say</span>
        <h2 class="section-heading">Loved by Renters <span class="highlight">and Owners</span></h2>
        <p class="section-sub">Hear from thousands of satisfied users who found their perfect home through BasaFinder.</p>
    </div>
    <div class="test-grid">
        @forelse($testimonials as $t)
            <div class="test-card reveal">
                <div class="test-glow"></div>
                <div class="test-quote">"</div>
                <div class="test-stars">{{ $t->stars }}</div>
                <p class="test-text">"{{ $t->content }}"</p>
                <div class="test-author">
                    <div class="test-avatar">{{ $t->initial }}</div>
                    <div><div class="test-name">{{ $t->author_name }}</div><div class="test-role">{{ $t->author_role }}</div></div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:3rem 1rem;">
                <h3 style="font-size:1.125rem; font-weight:600; color:rgba(255,255,255,0.8);">No Testimonials Yet</h3>
                <p style="color:rgba(255,255,255,0.4); font-size:0.875rem;">Check back soon for customer stories.</p>
            </div>
        @endforelse
    </div>
</section>

<button id="backToTop" aria-label="Back to top">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
</button>
@endsection

@push('scripts')
<script>
var scrollProgressEl = document.getElementById('scrollProgress');
var backToTopBtn = document.getElementById('backToTop');

// ── Hero Mouse Parallax ──
(function() {
    var hero = document.getElementById('hero');
    if (!hero) return;
    var glare = document.getElementById('heroGlare');
    var mesh = hero.querySelector('.hero-mesh');
    var targetX = 0, targetY = 0, currentX = 0, currentY = 0, time = 0;

    var orbConfigs = [
        { ax: 8, ay: 6, speed: 0.4, delay: 0 },
        { ax: 6, ay: 10, speed: 0.3, delay: 1.5 },
        { ax: 5, ay: 4, speed: 0.5, delay: 0.8 },
        { ax: 7, ay: 5, speed: 0.35, delay: 2.2 }
    ];
    var orbs = hero.querySelectorAll('.hero-orbs .orb');

    hero.addEventListener('mousemove', function(e) {
        var rect = this.getBoundingClientRect();
        targetX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        targetY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        if (glare) {
            glare.style.setProperty('--mouse-x', ((e.clientX - rect.left) / rect.width * 100) + '%');
            glare.style.setProperty('--mouse-y', ((e.clientY - rect.top) / rect.height * 100) + '%');
            glare.classList.add('active');
        }
    });
    hero.addEventListener('mouseleave', function() { targetX = 0; targetY = 0; if (glare) glare.classList.remove('active'); });

    function animateHero() {
        time += 0.016;
        currentX += (targetX - currentX) * 0.03;
        currentY += (targetY - currentY) * 0.03;
        if (mesh) mesh.style.transform = 'translate(' + (currentX * 0.5) + 'px, ' + (currentY * 0.5) + 'px) scale(' + (1 + Math.abs(currentX) * 0.005) + ')';
        if (orbs.length) {
            for (var i = 0; i < orbs.length; i++) {
                var cfg = orbConfigs[i] || { ax: 5, ay: 5, speed: 0.3, delay: 0 };
                var floatX = Math.sin(time * cfg.speed + cfg.delay) * cfg.ax;
                var floatY = Math.cos(time * cfg.speed * 0.7 + cfg.delay + 1) * cfg.ay;
                var paraX = currentX * (8 - i * 1.5);
                var paraY = currentY * (6 - i * 1);
                var scale = 1 + Math.sin(time * 0.3 + i) * 0.05;
                orbs[i].style.transform = 'translate(' + (floatX + paraX) + 'px, ' + (floatY + paraY) + 'px) scale(' + scale + ')';
            }
        }
        if (glare && !glare.classList.contains('active')) {
            glare.style.setProperty('--mouse-x', (50 + Math.sin(time * 0.15) * 30) + '%');
            glare.style.setProperty('--mouse-y', (50 + Math.cos(time * 0.1) * 25) + '%');
        }
        requestAnimationFrame(animateHero);
    }
    animateHero();
})();

// ── Scroll ──
window.addEventListener('scroll', function() {
    var scrollTop = window.scrollY;
    scrollProgressEl.style.width = (scrollTop / (document.documentElement.scrollHeight - window.innerHeight) * 100) + '%';
    backToTopBtn.classList.toggle('visible', scrollTop > 600);
});

backToTopBtn.addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });

// ── Reveal ──
var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) { entry.target.classList.add('revealed'); revealObserver.unobserve(entry.target); }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
document.querySelectorAll('.reveal').forEach(function(el) { revealObserver.observe(el); });

// ── Counters ──
var counterObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            var el = entry.target;
            var target = parseInt(el.dataset.target);
            if (isNaN(target)) return;
            var current = 0;
            var increment = Math.ceil(target / 60);
            var timer = setInterval(function() {
                current += increment;
                if (current >= target) { el.textContent = target; clearInterval(timer); }
                else { el.textContent = current; }
            }, 20);
            counterObserver.unobserve(el);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.counter').forEach(function(el) { counterObserver.observe(el); });

// ── FAQ ──
function toggleFaq(btn) {
    var item = btn.parentElement;
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(function(el) { el.classList.remove('open'); });
    if (!isOpen) item.classList.add('open');
}

// ── Favorites ──
document.querySelectorAll('.fav-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        this.classList.toggle('active');
        this.classList.add('liked');
        setTimeout(function() { this.classList.remove('liked'); }.bind(this), 400);
    });
});

// ── Typewriter ──
(function() {
    var words = ['Home', 'Apartment', 'Flat', 'House', 'Room', 'Villa'];
    var wordIndex = 0;
    var el = document.getElementById('heroWord');
    if (!el) return;
    function typeWord(word, cb) {
        var i = 0; el.textContent = '';
        var t = setInterval(function() { el.textContent += word[i]; i++; if (i >= word.length) { clearInterval(t); setTimeout(cb, 2000); } }, 80);
    }
    function deleteWord(cb) {
        var w = el.textContent, i = w.length;
        var d = setInterval(function() { el.textContent = w.substring(0, i - 1); i--; if (i <= 0) { clearInterval(d); cb(); } }, 40);
    }
    function cycle() { wordIndex = (wordIndex + 1) % words.length; deleteWord(function() { typeWord(words[wordIndex], cycle); }); }
    setTimeout(cycle, 3000);
})();

// ── 3D Tilt ──
(function() {
    var card = document.getElementById('tiltCard');
    if (!card || window.innerWidth < 1024) return;
    card.addEventListener('mousemove', function(e) {
        var r = this.getBoundingClientRect();
        this.style.transform = 'perspective(1000px) rotateX(' + (((e.clientY - r.top) / r.height - 0.5) * -16) + 'deg) rotateY(' + (((e.clientX - r.left) / r.width - 0.5) * 16) + 'deg)';
    });
    card.addEventListener('mouseleave', function() { this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)'; });
})();
</script>
@endpush
