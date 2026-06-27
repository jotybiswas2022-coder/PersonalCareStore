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
   AURORA WAVE OVERLAY
   ═══════════════════════════════════════════ */
.hero-aurora {
    position: absolute; inset: 0; pointer-events: none; z-index: 0;
    overflow: hidden; opacity: 0.5;
}
.hero-aurora .aurora-band {
    position: absolute; width: 200%; height: 120%;
    top: -10%; left: -50%;
    background: linear-gradient(
        180deg,
        transparent 0%,
        rgba(37,99,235,0.02) 15%,
        rgba(124,58,237,0.04) 25%,
        rgba(16,185,129,0.01) 35%,
        transparent 50%
    );
    animation: auroraDrift 12s ease-in-out infinite alternate;
    filter: blur(60px);
    transform-origin: center center;
}
.hero-aurora .aurora-band:nth-child(2) {
    background: linear-gradient(
        180deg,
        transparent 0%,
        rgba(245,158,11,0.01) 20%,
        rgba(37,99,235,0.03) 35%,
        rgba(124,58,237,0.02) 45%,
        transparent 60%
    );
    animation-duration: 16s;
    animation-delay: -4s;
    animation-direction: alternate-reverse;
    filter: blur(80px);
}
.hero-aurora .aurora-band:nth-child(3) {
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(96,165,250,0.02) 25%,
        rgba(16,185,129,0.01) 50%,
        transparent 75%
    );
    animation-duration: 14s;
    animation-delay: -2s;
    filter: blur(70px);
}
@keyframes auroraDrift {
    0% { transform: translateX(-20%) translateY(0) rotate(-2deg) scale(1); opacity: 0.3; }
    25% { transform: translateX(10%) translateY(-5%) rotate(1deg) scale(1.05); opacity: 0.5; }
    50% { transform: translateX(-5%) translateY(8%) rotate(-1deg) scale(0.95); opacity: 0.35; }
    75% { transform: translateX(15%) translateY(-3%) rotate(2deg) scale(1.02); opacity: 0.45; }
    100% { transform: translateX(-10%) translateY(5%) rotate(-1.5deg) scale(1.03); opacity: 0.4; }
}

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
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    transform: translateZ(0);
    -webkit-transform: translateZ(0);
    position: absolute; border-radius: 50%;
    filter: blur(80px); opacity: 0.35;
    will-change: transform;
}
.hero-orbs .orb:nth-child(1) { width: 380px; height: 380px; background: rgba(37,99,235,0.18); top: 5%; left: 5%; }
.hero-orbs .orb:nth-child(2) { width: 300px; height: 300px; background: rgba(124,58,237,0.12); bottom: 10%; right: 10%; }
.hero-orbs .orb:nth-child(3) { width: 240px; height: 240px; background: rgba(245,158,11,0.08); top: 55%; left: 55%; }
.hero-orbs .orb:nth-child(4) { width: 200px; height: 200px; background: rgba(16,185,129,0.06); bottom: 25%; left: 20%; }
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
.hero-search .search-field:focus-within select, .hero-search .search-field:focus-within input { border-color: rgba(59,130,246,0.5); background: rgba(0,0,0,0.35); box-shadow: 0 0 0 4px rgba(59,130,246,0.1), 0 4px 16px rgba(59,130,246,0.08); }
.hero-search select, .hero-search input {
    width: 100%;
    padding: 0.8125rem 2rem 0.8125rem 2.25rem;
    background: rgba(0,0,0,0.25) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='3 6 6 3 9 6'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    color: #f1f5f9;
    font-size: 0.875rem;
    font-family: var(--font);
    outline: none;
    transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    -webkit-appearance: none;
    appearance: none;
    cursor: pointer;
    backdrop-filter: blur(4px);
}
.hero-search select option {
    background: #0f172a;
    color: #f1f5f9;
    padding: 0.5rem 0.75rem;
}
.hero-search select option:checked { background: #1e3a5f; }
.hero-search select::-webkit-scrollbar { width: 6px; }
.hero-search select::-webkit-scrollbar-track { background: #0f172a; border-radius: 3px; }
.hero-search select::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
.hero-search select::-webkit-scrollbar-thumb:hover { background: #475569; }
.hero-search select option:disabled { color: #475569; }
.hero-search select:hover, .hero-search input:hover { background-color: rgba(0,0,0,0.35); }
.hero-search select:active { transform: scale(0.98); }
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
.hero-image-card .main-img .placeholder-icon { display: none; }
.hero-scene { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
.hero-scene svg { width: 85%; height: 85%; }

/* ═══════════════════════════════════════════
   SCENE ANIMATIONS (single-pass, JS-looped)
   ═══════════════════════════════════════════ */

/* ── Character walk in + body bob ── */
.hero-scene .scene-loop .person-group { animation: walkIn 1s ease-out forwards, bodyBob 0.4s ease-in-out 1s 3; will-change: transform; backface-visibility: hidden; }
@keyframes walkIn { 0% { transform: translateX(-120px); opacity: 0; } 60% { transform: translateX(5px); } 100% { transform: translateX(0); opacity: 1; } }
@keyframes bodyBob { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-3px); } }

/* ── Head look around ── */
.hero-scene .scene-loop .person-head { animation: headLook 3s ease-in-out 0.3s infinite; transform-origin: 120px 110px; }
@keyframes headLook {
    0%,100% { transform: rotate(0deg); }
    10% { transform: rotate(12deg); }
    25% { transform: rotate(-10deg); }
    40% { transform: rotate(8deg); }
    55% { transform: rotate(-6deg); }
    70% { transform: rotate(4deg); }
}

/* ── Arm wave ── */
.hero-scene .scene-loop .person-arm { animation: armWave 2s ease-in-out 0.2s infinite; transform-origin: 132px 136px; }
@keyframes armWave {
    0%,100% { transform: rotate(0deg); }
    20% { transform: rotate(20deg); }
    40% { transform: rotate(-10deg); }
    60% { transform: rotate(15deg); }
    80% { transform: rotate(-5deg); }
}

/* ── Face transitions ── */
.hero-scene .scene-loop .face-sad { animation: fadeOut 1.8s ease-in-out forwards; }
@keyframes fadeOut { 0%,60% { opacity: 1; } 80% { opacity: 0.5; } 100% { opacity: 0; } }
.hero-scene .scene-loop .face-happy { animation: fadeIn 0.5s ease-in-out 1.6s forwards; opacity: 0; }
@keyframes fadeIn { 0% { opacity: 0; transform: scale(0.5); } 60% { transform: scale(1.1); } 100% { opacity: 1; transform: scale(1); } }

/* ── Magnifying glass sweep ── */
.hero-scene .scene-loop .search-glass { animation: glassSweep 2s ease-in-out 0.6s 2; transform-origin: 160px 114px; opacity: 0; animation-fill-mode: forwards; }
@keyframes glassSweep {
    0% { opacity: 0; transform: rotate(0deg); }
    10% { opacity: 1; }
    20% { transform: rotate(18deg); }
    40% { transform: rotate(-18deg); }
    60% { transform: rotate(14deg); }
    80% { transform: rotate(-10deg); }
    100% { opacity: 1; transform: rotate(0deg); }
}
.hero-scene .scene-loop .glass-hide { animation: glassFadeOut 0.4s ease-in 1.7s forwards; }
@keyframes glassFadeOut { 0% { opacity: 1; transform: scale(1) rotate(0deg); } 50% { transform: scale(0.5) rotate(30deg); } 100% { opacity: 0; transform: scale(0) rotate(60deg); } }

/* ── House pop + glow ── */
.hero-scene .scene-loop .house-found { animation: housePop 0.6s cubic-bezier(0.34,1.56,0.64,1) 1.4s forwards, houseGlow 1.2s ease-in-out 2s infinite; opacity: 0; transform-origin: 215px 169px; }
@keyframes housePop { 0% { opacity: 0; transform: scale(0) rotate(-25deg); } 40% { transform: scale(1.35) rotate(8deg); } 70% { transform: scale(0.9) rotate(-3deg); } 100% { opacity: 1; transform: scale(1) rotate(0deg); } }
@keyframes houseGlow { 0%,100% { filter: drop-shadow(0 0 4px rgba(16,185,129,0.3)) brightness(1); } 50% { filter: drop-shadow(0 0 16px rgba(16,185,129,0.6)) brightness(1.08); } }

/* ── Happy jump ── */
.hero-scene .scene-loop .happy-jump { animation: jumpHappy 0.7s ease-in-out 1.7s infinite; }
@keyframes jumpHappy {
    0%,100% { transform: translateY(0); }
    40% { transform: translateY(-20px); }
    60% { transform: translateY(-4px); }
}

/* ── Sparkle pop ── */
.hero-scene .scene-loop .sparkle { animation: sparklePop 1.4s ease-out 1.9s infinite; opacity: 0; }
@keyframes sparklePop {
    0% { opacity: 0; transform: scale(0) rotate(0deg); }
    15% { opacity: 1; transform: scale(1.8) rotate(180deg); }
    40% { opacity: 0.5; transform: scale(0.7) rotate(360deg); }
    70% { opacity: 0.2; transform: scale(1.2) rotate(540deg); }
    100% { opacity: 0; transform: scale(0) rotate(720deg); }
}

/* ── Checkmark pop + heartbeat ── */
.hero-scene .scene-loop .checkmark { animation: checkPop 0.5s cubic-bezier(0.34,1.56,0.64,1) 2s forwards, heartBeat 0.8s ease-in-out 2.8s infinite; opacity: 0; transform-origin: 215px 140px; }
@keyframes checkPop { 0% { opacity: 0; transform: scale(0) rotate(-40deg); } 40% { transform: scale(1.5) rotate(8deg); } 70% { transform: scale(0.9) rotate(-4deg); } 100% { opacity: 1; transform: scale(1) rotate(0deg); } }
@keyframes heartBeat {
    0%,100% { transform: scale(1); }
    15% { transform: scale(1.2); }
    30% { transform: scale(1); }
    45% { transform: scale(1.1); }
    60% { transform: scale(1); }
}

/* ── FOUND badge tada ── */
.hero-scene .scene-loop .found-text { animation: badgeBounce 0.5s cubic-bezier(0.34,1.56,0.64,1) 2.3s forwards, tada 1s ease-in-out 3.2s infinite; opacity: 0; }
@keyframes badgeBounce { 0% { opacity: 0; transform: scale(0) translateY(20px); } 40% { transform: scale(1.35); } 70% { transform: scale(0.9); } 100% { opacity: 1; transform: scale(1) translateY(0); } }
@keyframes tada {
    0%,100% { transform: scale(1) rotate(0deg); }
    10%,20% { transform: scale(0.9) rotate(-4deg); }
    30%,50%,70%,90% { transform: scale(1.15) rotate(4deg); }
    40%,60%,80% { transform: scale(1.15) rotate(-4deg); }
}

/* ── Travel dots ── */
.hero-scene .scene-loop .travel-dot { animation: dotTravel 1.2s ease-in-out 1.5s infinite; }
@keyframes dotTravel {
    0% { opacity: 0; transform: translateX(0) scale(0); }
    15% { opacity: 0.7; transform: translateX(12px) scale(1.2); }
    40% { opacity: 0.5; transform: translateX(30px) scale(0.9); }
    70% { opacity: 0.3; transform: translateX(48px) scale(0.6); }
    100% { opacity: 0; transform: translateX(60px) scale(0); }
}

/* ── Pointing arm ── */
.hero-scene .scene-loop .point-arm { animation: pointAppear 0.4s ease-out 1.6s forwards; opacity: 0; transform-origin: 132px 136px; }
@keyframes pointAppear { 0% { opacity: 0; transform: scale(0.3) rotate(-30deg); } 50% { transform: scale(1.2) rotate(5deg); } 100% { opacity: 1; transform: scale(1) rotate(0deg); } }

/* ── Rain ── */
.hero-scene .scene-loop .raindrop { animation: rainFall 0.8s linear infinite; }
@keyframes rainFall { 0% { opacity: 0; transform: translateY(-25px); } 30% { opacity: 0.5; } 50% { opacity: 0.3; transform: translateY(15px); } 100% { opacity: 0; transform: translateY(40px); } }

/* ── Sunshine ── */
.hero-scene .scene-loop .sunshine { animation: sunGlow 1.2s ease-in-out 1.8s infinite; opacity: 0; }
@keyframes sunGlow { 0%,100% { opacity: 0; transform: scale(1); } 50% { opacity: 0.25; transform: scale(1.12); } }

/* ── Float soft ── */
.hero-scene .scene-loop .float-element { animation: floatSoft 2.5s ease-in-out infinite; }
@keyframes floatSoft { 0%,100% { transform: translateY(0); } 25% { transform: translateY(-6px); } 50% { transform: translateY(-2px); } 75% { transform: translateY(-4px); } }

/* ── Pulse glow ── */
.hero-scene .scene-loop .pulse-glow { animation: pulseGlow 1.5s ease-in-out infinite; }
@keyframes pulseGlow { 0%,100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.08); } }

/* ── Slide up ── */
.hero-scene .scene-loop .slide-up { animation: slideUp 0.6s ease-out 1.3s forwards; opacity: 0; }
@keyframes slideUp { 0% { opacity: 0; transform: translateY(25px); } 60% { opacity: 1; transform: translateY(-3px); } 100% { opacity: 1; transform: translateY(0); } }

/* ── Card flip ── */
.hero-scene .scene-loop .card-flip { animation: cardFlip 0.6s ease-out 1.5s forwards; opacity: 0; }
@keyframes cardFlip { 0% { opacity: 0; transform: scale(0); } 60% { opacity: 1; transform: scale(1.15); } 80% { transform: scale(0.92); } 100% { opacity: 1; transform: scale(1); } }

/* ── Bounce in down ── */
.hero-scene .scene-loop .bounce-in-down { animation: bounceInDown 0.8s ease-out 0.5s forwards; opacity: 0; transform-origin: top center; }
@keyframes bounceInDown {
    0% { opacity: 0; transform: scaleY(0); }
    40% { opacity: 1; transform: scaleY(1.08); }
    60% { transform: scaleY(0.94); }
    80% { transform: scaleY(1.02); }
    100% { opacity: 1; transform: scaleY(1); }
}

/* ── Slide in left ── */
.hero-scene .scene-loop .slide-in-left { animation: slideInLeft 0.7s ease-out 1s forwards; opacity: 0; }
@keyframes slideInLeft { 0% { opacity: 0; transform: translateX(-50px); } 60% { transform: translateX(6px); } 100% { opacity: 1; transform: translateX(0); } }

/* ── Slide in right ── */
.hero-scene .scene-loop .slide-in-right { animation: slideInRight 0.7s ease-out 1.1s forwards; opacity: 0; }
@keyframes slideInRight { 0% { opacity: 0; transform: translateX(50px); } 60% { transform: translateX(-6px); } 100% { opacity: 1; transform: translateX(0); } }

/* ── Zoom in ── */
.hero-scene .scene-loop .zoom-in { animation: zoomIn 0.5s ease-out 2.5s forwards; opacity: 0; }
@keyframes zoomIn { 0% { opacity: 0; transform: scale(0); } 50% { transform: scale(1.15); } 100% { opacity: 1; transform: scale(1); } }

/* ── Bird fly ── */
.hero-scene .scene-loop .bird-fly { animation: birdFly 4s ease-in-out 0.8s infinite; }
@keyframes birdFly {
    0% { transform: translateX(-30px) translateY(0); opacity: 0; }
    10% { opacity: 0.4; }
    50% { transform: translateX(160px) translateY(-8px); opacity: 0.6; }
    90% { transform: translateX(330px) translateY(-3px); opacity: 0.2; }
    100% { transform: translateX(350px) translateY(0); opacity: 0; }
}

/* ── Bird wing flap ── */
.hero-scene .scene-loop .bird-wing { animation: birdWing 0.3s ease-in-out infinite; transform-origin: 4px 0; }
@keyframes birdWing { 0%,100% { transform: rotate(0deg) scaleX(1); } 50% { transform: rotate(20deg) scaleX(0.8); } }

/* ── Run in (second character) ── */
.hero-scene .scene-loop .run-in { animation: runIn 1.2s ease-out 2.5s forwards; opacity: 0; }
@keyframes runIn { 0% { opacity: 0; transform: translateX(-80px); } 40% { transform: translateX(8px); } 70% { transform: translateX(-3px); } 100% { opacity: 1; transform: translateX(0); } }

/* ── Wobble ── */
.hero-scene .scene-loop .wobble { animation: wobble 1s ease-in-out 3s infinite; }
@keyframes wobble {
    0%,100% { transform: translateX(0) rotate(0deg); }
    15% { transform: translateX(-4px) rotate(-4deg); }
    30% { transform: translateX(4px) rotate(4deg); }
    45% { transform: translateX(-3px) rotate(-3deg); }
    60% { transform: translateX(3px) rotate(2deg); }
    75% { transform: translateX(-2px) rotate(-1deg); }
}

/* ── Shake ── */
.hero-scene .scene-loop .shake { animation: shake 0.6s ease-in-out 1.8s infinite; }
@keyframes shake {
    0%,100% { transform: translateX(0); }
    10%,50%,90% { transform: translateX(-3px); }
    30%,70% { transform: translateX(3px); }
}

/* ── Flash ── */
.hero-scene .scene-loop .flash { animation: flash 0.8s ease-in-out 2.8s infinite; }
@keyframes flash { 0%,50%,100% { opacity: 1; } 25%,75% { opacity: 0.2; } }

/* ── Ripple ── */
.hero-scene .scene-loop .ripple { animation: ripple 2s ease-out 1.5s infinite; }
@keyframes ripple {
    0% { opacity: 0.3; transform: scale(0); }
    50% { opacity: 0.15; transform: scale(2); }
    100% { opacity: 0; transform: scale(3); }
}

/* ── Confetti fall ── */
.hero-scene .scene-loop .confetti-fall { animation: confettiFall 2.5s linear 3s infinite; }
@keyframes confettiFall {
    0% { opacity: 0; transform: translateY(-30px) rotate(0deg) scale(0); }
    20% { opacity: 0.7; transform: translateY(10px) rotate(72deg) scale(1); }
    50% { opacity: 0.5; transform: translateY(40px) rotate(180deg) scale(0.8); }
    80% { opacity: 0.2; transform: translateY(70px) rotate(288deg) scale(0.4); }
    100% { opacity: 0; transform: translateY(100px) rotate(360deg) scale(0); }
}

/* ── Shooting star ── */
.hero-scene .scene-loop .shooting-star { animation: shootingStar 1.5s ease-out 1s infinite; }
@keyframes shootingStar {
    0% { opacity: 0; transform: translateX(0) translateY(0); }
    5% { opacity: 0.6; }
    15% { opacity: 0; transform: translateX(80px) translateY(80px); }
    100% { opacity: 0; }
}

/* ── Flower bloom ── */
.hero-scene .scene-loop .flower-bloom { animation: flowerBloom 0.7s ease-out 2.2s forwards; opacity: 0; }
@keyframes flowerBloom { 0% { opacity: 0; transform: scale(0) rotate(-10deg); } 60% { opacity: 1; transform: scale(1.2) rotate(3deg); } 100% { opacity: 1; transform: scale(1) rotate(0deg); } }

/* ── Pulsing ring ── */
.hero-scene .scene-loop .pulse-ring { animation: pulseRing 2s ease-out 2s infinite; transform-origin: 226px 155px; }
@keyframes pulseRing {
    0% { opacity: 0.5; transform: scale(1); stroke-width: 1.5; }
    50% { opacity: 0.2; transform: scale(3); stroke-width: 0.8; }
    100% { opacity: 0; transform: scale(5); stroke-width: 0; }
}

/* ── Gentle swing ── */
.hero-scene .scene-loop .gentle-swing { animation: gentleSwing 3s ease-in-out 1s infinite; }
@keyframes gentleSwing {
    0%,100% { transform: rotate(0deg); }
    25% { transform: rotate(2deg); }
    75% { transform: rotate(-2deg); }
}

/* ── Color pulse ── */
.hero-scene .scene-loop .color-pulse { animation: colorPulse 2s ease-in-out 2.5s infinite; }
@keyframes colorPulse { 0%,100% { fill: rgba(16,185,129,0.2); } 50% { fill: rgba(245,158,11,0.2); } }

/* ── Spin pulse ── */
.hero-scene .scene-loop .spin-pulse { animation: spinPulse 3s linear 2s infinite; transform-origin: center; }
@keyframes spinPulse { 0% { transform: rotate(0deg) scale(1); } 50% { transform: rotate(180deg) scale(1.2); } 100% { transform: rotate(360deg) scale(1); } }

/* ── Bounce ── */
.hero-scene .scene-loop .bounce-simple { animation: bounceSimple 1s ease-in-out 2.5s infinite; }
@keyframes bounceSimple { 0%,100% { transform: translateY(0); } 30% { transform: translateY(-8px); } 50% { transform: translateY(0); } 70% { transform: translateY(-4px); } }

/* ── Roll in ── */
.hero-scene .scene-loop .roll-in { animation: rollIn 0.7s ease-out 2s forwards; opacity: 0; }
@keyframes rollIn { 0% { opacity: 0; transform: translateX(-40px) rotate(-120deg); } 60% { transform: translateX(5px) rotate(10deg); } 100% { opacity: 1; transform: translateX(0) rotate(0deg); } }

/* ── Light speed in ── */
.hero-scene .scene-loop .light-speed-in { animation: lightSpeedIn 0.8s ease-out 2.5s forwards; opacity: 0; }
@keyframes lightSpeedIn {
    0% { opacity: 0; transform: translateX(60px) skewX(-20deg); }
    60% { opacity: 1; transform: translateX(-5px) skewX(5deg); }
    80% { transform: translateX(2px) skewX(-2deg); }
    100% { opacity: 1; transform: translateX(0) skewX(0deg); }
}

/* ── Flip in X ── */
.hero-scene .scene-loop .flip-in-x { animation: flipInX 0.7s ease-out 2.8s forwards; opacity: 0; }
@keyframes flipInX {
    0% { opacity: 0; transform: perspective(200px) rotateX(80deg); }
    50% { opacity: 1; transform: perspective(200px) rotateX(-15deg); }
    70% { transform: perspective(200px) rotateX(5deg); }
    100% { opacity: 1; transform: perspective(200px) rotateX(0deg); }
}

/* ── Flip in Y ── */
.hero-scene .scene-loop .flip-in-y { animation: flipInY 0.7s ease-out 2.6s forwards; opacity: 0; }
@keyframes flipInY {
    0% { opacity: 0; transform: perspective(200px) rotateY(80deg); }
    50% { opacity: 1; transform: perspective(200px) rotateY(-15deg); }
    70% { transform: perspective(200px) rotateY(5deg); }
    100% { opacity: 1; transform: perspective(200px) rotateY(0deg); }
}

/* ── Typing dot (sequential) ── */
.hero-scene .scene-loop .typing-dot { animation: typingDot 0.4s ease-out forwards; opacity: 0; }
@keyframes typingDot { 0% { opacity: 0; transform: scale(0); } 60% { transform: scale(1.3); } 100% { opacity: 1; transform: scale(1); } }

/* ── Progress fill ── */
.hero-scene .scene-loop .progress-fill { animation: progressFill 1.2s ease-out 0.7s forwards; }
@keyframes progressFill { 0% { width: 0; opacity: 0; } 30% { opacity: 0.4; } 100% { width: 160px; opacity: 0.12; } }

/* ── Heart float ── */
.hero-scene .scene-loop .heart-float { animation: heartFloat 2s ease-out 3s infinite; opacity: 0; }
@keyframes heartFloat {
    0% { opacity: 0; transform: translateY(0) scale(0) rotate(0deg); }
    20% { opacity: 0.5; transform: translateY(-10px) scale(1) rotate(10deg); }
    50% { opacity: 0.3; transform: translateY(-25px) scale(0.8) rotate(-5deg); }
    80% { opacity: 0.1; transform: translateY(-40px) scale(0.4) rotate(10deg); }
    100% { opacity: 0; transform: translateY(-55px) scale(0) rotate(0deg); }
}

/* ── Door swing ── */
.hero-scene .scene-loop .door-swing { animation: doorSwing 0.6s ease-out 2.2s forwards; transform-origin: left center; }
@keyframes doorSwing { 0% { transform: scaleX(1); } 30% { transform: scaleX(0.1); } 70% { transform: scaleX(1.05); } 100% { transform: scaleX(1); } }

/* ── Key fly ── */
.hero-scene .scene-loop .key-fly { animation: keyFly 1s ease-in-out 2.6s forwards; opacity: 0; }
@keyframes keyFly {
    0% { opacity: 0; transform: translateX(-60px) translateY(0) rotate(-30deg); }
    30% { opacity: 0.4; transform: translateX(-30px) translateY(-15px) rotate(-15deg); }
    60% { opacity: 0.6; transform: translateX(-10px) translateY(-5px) rotate(5deg); }
    100% { opacity: 1; transform: translateX(0) translateY(0) rotate(0deg); }
}

/* ── Rainbow glow ── */
.hero-scene .scene-loop .rainbow-glow { animation: rainbowGlow 2s ease-out 2.8s forwards; opacity: 0; }
@keyframes rainbowGlow { 0% { opacity: 0; } 40% { opacity: 0.04; } 100% { opacity: 0.02; } }

/* ═══════════════════════════════════════════
   FREE-RUNNING BACKGROUND PARTICLES
   ═══════════════════════════════════════════ */
.hero-scene .dot-pulse { animation: dotPulse 2s ease-in-out infinite; }
@keyframes dotPulse { 0%,100% { opacity: 0.08; transform: scale(0.6); } 50% { opacity: 0.6; transform: scale(1.4); } }
.hero-scene .search-ray { animation: rayPulse 3s ease-in-out infinite; transform-origin: 150px 105px; }
@keyframes rayPulse { 0%,100% { opacity: 0.06; transform: scale(0.95); } 50% { opacity: 0.2; transform: scale(1.06); } }
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
n/* ── Smooth floating card entrance ── */
.floating-card {
    opacity: 0;
    transform: translateY(30px) scale(0.85);
    transition: opacity 0.7s cubic-bezier(0.34,1.56,0.64,1), transform 0.7s cubic-bezier(0.34,1.56,0.64,1);
}
.floating-card.floating-card-enter {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.hero-image-card .floating-card:hover { transform: scale(1.12) translateY(-4px) !important; background: rgba(15,23,42,0.6); box-shadow: 0 12px 40px rgba(0,0,0,0.35); }
.hero-image-card .floating-card:nth-child(2) { bottom: 2%; right: -10%; animation-delay: 0s; animation-duration: 7s; }
.hero-image-card .floating-card:nth-child(3) { top: 5%; left: -8%; animation-delay: 0s; }
.hero-image-card .floating-card:nth-child(4) { bottom: 35%; left: -6%; animation-delay: 1s; animation-duration: 8s; }
.floating-card .fc-icon { width: 2.5rem; height: 2.5rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.floating-card .fc-icon.blue { background: rgba(37,99,235,0.15); color: #60A5FA; }
.floating-card .fc-icon.gold { background: rgba(245,158,11,0.12); color: #FCD34D; }
.floating-card .fc-text .fc-num { font-weight: 700; font-size: 0.9375rem; color: #fff; }
.floating-card .fc-text .fc-label { font-size: 0.75rem; color: rgba(255,255,255,0.45); }
@keyframes float { 0%,100% { transform: translateY(0) rotate(0deg); } 33% { transform: translateY(-14px) rotate(0.5deg); } 66% { transform: translateY(-6px) rotate(-0.3deg); } }

@media (max-width: 1024px) {
    .hero .hero-grid { grid-template-columns: 1fr; gap: 1.5rem; padding: 1rem 1.5rem 3rem; text-align: center; }
    .hero .hero-grid .hero-visual { order: -1; max-width: 380px; margin: 0 auto; }
    .hero-image-card { max-width: 380px; }
    .hero-scene svg { width: 90%; height: 90%; }
    .hero h1 { font-size: 2.5rem; }
    .hero p { margin-left: auto; margin-right: auto; }
    .hero-badge { margin-top: 0.5rem; }
    .hero-stats { justify-content: center; }
    .hero-search-row { flex-direction: column; }
    .hero-search .search-field { min-width: 100%; }
    .hero-search .btn-search { width: 100%; justify-content: center; }
}
@media (max-width: 768px) {
    .hero { min-height: auto; }
    .hero .hero-grid { padding: 0.5rem 1rem 2.5rem; gap: 1rem; }
    .hero .hero-grid .hero-visual { order: -1; max-width: 280px; }
    .hero-image-card { max-width: 280px; }
    .hero-image-card .floating-card { display: none; }
    .hero h1 { font-size: 1.75rem; }
    .hero p { font-size: 0.875rem; }
    .hero-badge { font-size: 0.75rem; padding: 0.35rem 0.85rem; }
    .hero-stats { gap: 1rem; flex-wrap: wrap; }
    .hero-stat .num { font-size: 1.125rem; }
    .hero-stat .label { font-size: 0.7rem; }
    .hero-image-card .main-img { border-radius: 16px; }
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
    padding: 6rem 0;
    background: var(--bg);
    position: relative;
}
.faq-list { max-width: 720px; margin: 0 auto; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; }
.faq-item {
    background: var(--white);
    border-radius: var(--r-md);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.3s;
}
.faq-item:hover { border-color: rgba(37,99,235,0.2); }
.faq-item.open { border-color: rgba(37,99,235,0.25); box-shadow: 0 4px 16px rgba(37,99,235,0.06); }
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
.faq-question svg { transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1); flex-shrink: 0; color: var(--primary); }
.faq-item.open .faq-question svg { transform: rotate(45deg); color: var(--primary-dark); }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.4s ease; }
.faq-item.open .faq-answer { max-height: 300px; padding: 0 1.25rem 1.125rem; }
.faq-answer p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.7; }

/* ═══════════════════════════════════════════
n/* ── Smooth scene restart transition ── */
.hero-scene .scene-loop {
    transition: opacity 0.35s ease-in-out;
}

   BACK TO TOP
   ═══════════════════════════════════════════ */
#backToTop {
    position: fixed; bottom: 2rem; right: 2rem;
    width: 3.25rem; height: 3.25rem;
    background: linear-gradient(135deg, var(--primary), #6366f1);
    color: #fff; border: none; border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(37,99,235,0.35);
    z-index: 999;
    display: flex; align-items: center; justify-content: center;
    opacity: 0;
    transform: translateY(20px) scale(0.8);
    transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
    pointer-events: none;
}
#backToTop.visible { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
#backToTop:hover { transform: translateY(-4px) scale(1.1); box-shadow: 0 12px 32px rgba(37,99,235,0.5); }
#backToTop:active { transform: translateY(-1px) scale(0.95); }
#backToTop svg {
    animation: bounce-arrow 2s ease-in-out infinite;
}
#backToTop:hover svg {
    animation: none;
    transform: translateY(-3px);
}
#backToTop.visible svg {
    animation: bounce-arrow 2s ease-in-out infinite;
}
#backToTop.visible:hover svg {
    animation: none;
    transform: translateY(-3px);
}
@keyframes bounce-arrow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}
#backToTop .ring-pulse {
    position: absolute; inset: 0; border-radius: 50%;
    border: 2px solid rgba(37,99,235,0.3);
    animation: pulse-ring 2s cubic-bezier(0.215,0.61,0.355,1) infinite;
    pointer-events: none;
}
#backToTop .ring-pulse:nth-child(2) { animation-delay: 0.6s; }
@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.6); opacity: 0; }
}
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
    <div class="hero-aurora">
        <div class="aurora-band"></div>
        <div class="aurora-band"></div>
        <div class="aurora-band"></div>
    </div>
    <div class="hero-orbs">
        <div class="orb"></div><div class="orb"></div><div class="orb"></div><div class="orb"></div>
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
                    <div class="hero-scene">
                        <svg viewBox="0 0 300 210" overflow="visible" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g class="scene-loop">
                            <defs>
                                <radialGradient id="heroGlowGrad"><stop offset="0%" stop-color="#60A5FA"/><stop offset="100%" stop-color="transparent"/></radialGradient>
                                <linearGradient id="houseGrad" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="rgba(16,185,129,0.2)"/><stop offset="100%" stop-color="rgba(16,185,129,0.08)"/></linearGradient>
                                <radialGradient id="starGlow"><stop offset="0%" stop-color="#60A5FA"/><stop offset="100%" stop-color="transparent"/></radialGradient>
                                <linearGradient id="searchBarGrad" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="rgba(15,23,42,0.7)"/><stop offset="100%" stop-color="rgba(15,23,42,0.5)"/></linearGradient>
                                <radialGradient id="sunGlowGrad"><stop offset="0%" stop-color="rgba(245,158,11,0.15)"/><stop offset="100%" stop-color="transparent"/></radialGradient>
                            </defs>

                            <!-- Dark sky bg -->
                            <rect x="0" y="0" width="300" height="210" fill="rgba(15,23,42,0.08)" rx="12"/>

                            <!-- Stars twinkling -->
                            <circle cx="20" cy="25" r="1" fill="#60A5FA" class="dot-pulse" style="animation-delay:0.1s"/>
                            <circle cx="55" cy="40" r="1.2" fill="#93C5FD" class="dot-pulse" style="animation-delay:0.4s"/>
                            <circle cx="90" cy="15" r="0.8" fill="#60A5FA" class="dot-pulse" style="animation-delay:0.7s"/>
                            <circle cx="130" cy="30" r="1" fill="#93C5FD" class="dot-pulse" style="animation-delay:0.2s"/>
                            <circle cx="170" cy="18" r="1.2" fill="#60A5FA" class="dot-pulse" style="animation-delay:0.5s"/>
                            <circle cx="210" cy="42" r="0.8" fill="#93C5FD" class="dot-pulse" style="animation-delay:0.8s"/>
                            <circle cx="250" cy="22" r="1" fill="#60A5FA" class="dot-pulse" style="animation-delay:0.3s"/>
                            <circle cx="280" cy="50" r="1.1" fill="#93C5FD" class="dot-pulse" style="animation-delay:0.6s"/>

                            <!-- Shooting star -->
                            <g class="shooting-star">
                                <line x1="0" y1="0" x2="15" y2="15" stroke="rgba(255,255,255,0.2)" stroke-width="1" stroke-linecap="round"/>
                                <circle cx="0" cy="0" r="0.8" fill="rgba(255,255,255,0.3)"/>
                            </g>

                            <!-- City skyline silhouette -->
                            <g class="city-skyline" opacity="0.06">
                                <rect x="10" y="140" width="20" height="52" fill="#60A5FA" rx="2"/>
                                <rect x="35" y="125" width="15" height="67" fill="#60A5FA" rx="2"/>
                                <rect x="55" y="148" width="12" height="44" fill="#60A5FA" rx="2"/>
                                <rect x="72" y="130" width="18" height="62" fill="#60A5FA" rx="2"/>
                                <rect x="95" y="145" width="10" height="47" fill="#60A5FA" rx="2"/>
                                <rect x="230" y="135" width="16" height="57" fill="#60A5FA" rx="2"/>
                                <rect x="250" y="150" width="12" height="42" fill="#60A5FA" rx="2"/>
                                <rect x="267" y="128" width="20" height="64" fill="#60A5FA" rx="2"/>
                            </g>

                            <!-- Search ray (pulsing) -->
                            <circle cx="150" cy="105" r="95" class="search-ray" fill="url(#heroGlowGrad)"/>

                            <!-- Sunshine overlay (appears after found) -->
                            <circle cx="150" cy="80" r="110" class="sunshine" fill="url(#heroGlowGrad)"/>
                            <circle cx="150" cy="50" r="40" fill="url(#sunGlowGrad)" class="zoom-in" style="animation-delay:2.5s"/>

                            <!-- Flying bird -->
                            <g class="bird-fly">
                                <path d="M0 0 Q6 -5 12 0" stroke="rgba(147,197,253,0.15)" stroke-width="1.2" fill="none" stroke-linecap="round" class="bird-wing"/>
                                <path d="M12 0 Q18 -5 24 0" stroke="rgba(147,197,253,0.15)" stroke-width="1.2" fill="none" stroke-linecap="round" class="bird-wing" style="animation-delay:-0.1s"/>
                            </g>

                            <!-- Clouds (appear after found) -->
                            <g class="slide-up" style="animation-delay:2.8s">
                                <ellipse cx="60" cy="55" rx="28" ry="7" fill="rgba(255,255,255,0.03)"/>
                                <ellipse cx="76" cy="52" rx="18" ry="5" fill="rgba(255,255,255,0.02)"/>
                                <ellipse cx="48" cy="53" rx="12" ry="4" fill="rgba(255,255,255,0.02)"/>
                                <ellipse cx="238" cy="65" rx="25" ry="6" fill="rgba(255,255,255,0.03)"/>
                                <ellipse cx="254" cy="62" rx="15" ry="4" fill="rgba(255,255,255,0.02)"/>
                                <ellipse cx="140" cy="48" rx="20" ry="5" fill="rgba(255,255,255,0.02)" class="float-element" style="animation-delay:1s"/>
                            </g>

                            <!-- Search bar UI at top -->
                            <g class="bounce-in-down" style="animation-delay:0.5s">
                                <rect x="38" y="8" width="224" height="22" rx="11" fill="url(#searchBarGrad)" stroke="rgba(96,165,250,0.08)" stroke-width="1"/>
                                <circle cx="53" cy="19" r="3.5" stroke="rgba(147,197,253,0.2)" stroke-width="1.5" fill="none"/>
                                <line x1="56" y1="22" x2="61" y2="27" stroke="rgba(147,197,253,0.2)" stroke-width="1.5" stroke-linecap="round"/>
                                <!-- Typing dots -->
                                <circle cx="72" cy="19" r="1.5" fill="rgba(147,197,253,0.15)" class="typing-dot" style="animation-delay:0.7s"/>
                                <circle cx="80" cy="19" r="1.5" fill="rgba(147,197,253,0.15)" class="typing-dot" style="animation-delay:0.9s"/>
                                <circle cx="88" cy="19" r="1.5" fill="rgba(147,197,253,0.15)" class="typing-dot" style="animation-delay:1.1s"/>
                                <circle cx="96" cy="19" r="1.5" fill="rgba(147,197,253,0.15)" class="typing-dot" style="animation-delay:1.3s"/>
                                <line x1="108" y1="14" x2="108" y2="22" stroke="rgba(147,197,253,0.12)" stroke-width="1" class="flash" style="animation-delay:1.5s"/>
                                <rect x="68" y="14" width="130" height="10" rx="5" fill="rgba(147,197,253,0.03)"/>
                            </g>

                            <!-- Progress bar under search -->
                            <rect x="38" y="32" width="224" height="2" rx="1" fill="rgba(147,197,253,0.03)"/>
                            <rect x="38" y="32" width="0" height="2" rx="1" fill="rgba(16,185,129,0.08)" class="progress-fill"/>

                            <!-- Search results card -->
                            <g class="card-flip" style="animation-delay:1.2s">
                                <rect x="158" y="32" width="126" height="42" rx="7" fill="rgba(15,23,42,0.25)" stroke="rgba(96,165,250,0.06)" stroke-width="1"/>
                                <rect x="164" y="36" width="34" height="26" rx="4" fill="rgba(147,197,253,0.05)"/>
                                <rect x="168" y="42" width="14" height="14" rx="3" fill="rgba(16,185,129,0.18)"/>
                                <!-- Price highlight pulse -->
                                <rect x="168" y="42" width="14" height="14" rx="3" fill="rgba(16,185,129,0.25)" class="color-pulse"/>
                                <rect x="202" y="38" width="72" height="5" rx="2.5" fill="rgba(147,197,253,0.08)"/>
                                <rect x="202" y="46" width="58" height="4" rx="2" fill="rgba(147,197,253,0.05)"/>
                                <rect x="202" y="54" width="42" height="4" rx="2" fill="rgba(16,185,129,0.1)"/>
                                <rect x="204" y="62" width="32" height="7" rx="3.5" fill="rgba(16,185,129,0.13)"/>
                                <!-- Verified badge on result -->
                                <rect x="252" y="36" width="18" height="7" rx="3.5" fill="rgba(16,185,129,0.1)"/>
                                <text x="261" y="41" text-anchor="middle" font-size="4" font-weight="700" fill="rgba(16,185,129,0.4)">✓</text>
                            </g>

                            <!-- Second search result (staggered) -->
                            <g class="card-flip" style="animation-delay:1.5s">
                                <rect x="160" y="76" width="100" height="28" rx="6" fill="rgba(15,23,42,0.18)" stroke="rgba(96,165,250,0.04)" stroke-width="1"/>
                                <rect x="165" y="80" width="22" height="16" rx="3" fill="rgba(96,165,250,0.04)"/>
                                <rect x="191" y="81" width="55" height="4" rx="2" fill="rgba(147,197,253,0.06)"/>
                                <rect x="191" y="88" width="42" height="3" rx="1.5" fill="rgba(147,197,253,0.04)"/>
                                <rect x="191" y="94" width="28" height="5" rx="2.5" fill="rgba(16,185,129,0.08)"/>
                            </g>

                            <!-- Location pin on map -->
                            <g class="pulse-glow" style="animation-delay:2s">
                                <path d="M226 148 C226 148 220 158 226 165 C232 158 226 148 226 148Z" fill="rgba(16,185,129,0.2)" stroke="rgba(16,185,129,0.35)" stroke-width="1"/>
                                <circle cx="226" cy="155" r="3" fill="rgba(16,185,129,0.3)"/>
                            </g>
                            <!-- Pulse ring around pin -->
                            <circle cx="226" cy="155" r="3" fill="none" stroke="rgba(16,185,129,0.15)" stroke-width="1" class="pulse-ring" style="animation-delay:2.2s"/>

                            <!-- Ground with grass -->
                            <ellipse cx="150" cy="192" rx="140" ry="8" fill="rgba(96,165,250,0.05)"/>
                            <!-- Grass blades -->
                            <g class="slide-in-left" style="animation-delay:2s">
                                <path d="M30 190 L32 182 L34 190" stroke="rgba(16,185,129,0.04)" stroke-width="1" fill="none" stroke-linecap="round"/>
                                <path d="M80 188 L82 180 L84 188" stroke="rgba(16,185,129,0.04)" stroke-width="1" fill="none" stroke-linecap="round"/>
                                <path d="M160 189 L162 181 L164 189" stroke="rgba(16,185,129,0.04)" stroke-width="1" fill="none" stroke-linecap="round"/>
                                <path d="M250 190 L252 183 L254 190" stroke="rgba(16,185,129,0.04)" stroke-width="1" fill="none" stroke-linecap="round"/>
                                <path d="M120 188 L122 180 L124 188" stroke="rgba(16,185,129,0.04)" stroke-width="1" fill="none" stroke-linecap="round"/>
                                <path d="M200 189 L202 181 L204 189" stroke="rgba(16,185,129,0.04)" stroke-width="1" fill="none" stroke-linecap="round"/>
                            </g>

                            <!-- Flowers -->
                            <g class="flower-bloom" style="animation-delay:2.2s">
                                <line x1="42" y1="188" x2="42" y2="178" stroke="rgba(16,185,129,0.06)" stroke-width="1"/>
                                <circle cx="42" cy="177" r="3" fill="rgba(245,158,11,0.06)"/>
                                <circle cx="42" cy="177" r="1.5" fill="rgba(245,158,11,0.1)"/>
                            </g>
                            <g class="flower-bloom" style="animation-delay:2.3s">
                                <line x1="258" y1="188" x2="258" y2="176" stroke="rgba(16,185,129,0.06)" stroke-width="1"/>
                                <circle cx="258" cy="175" r="3.5" fill="rgba(147,197,253,0.06)"/>
                                <circle cx="258" cy="175" r="1.5" fill="rgba(147,197,253,0.1)"/>
                            </g>
                            <g class="flower-bloom" style="animation-delay:2.4s">
                                <line x1="145" y1="190" x2="145" y2="180" stroke="rgba(16,185,129,0.06)" stroke-width="1"/>
                                <circle cx="145" cy="179" r="2.5" fill="rgba(239,68,68,0.05)"/>
                                <circle cx="145" cy="179" r="1.2" fill="rgba(239,68,68,0.08)"/>
                            </g>

                            <!-- Fence near house -->
                            <g class="slide-in-left" style="animation-delay:2.4s" opacity="0.06">
                                <rect x="182" y="175" width="2" height="17" fill="#10B981"/>
                                <rect x="192" y="175" width="2" height="17" fill="#10B981"/>
                                <rect x="202" y="175" width="2" height="17" fill="#10B981"/>
                                <rect x="212" y="175" width="2" height="17" fill="#10B981"/>
                                <rect x="222" y="175" width="2" height="17" fill="#10B981"/>
                                <rect x="180" y="177" width="46" height="1.5" fill="#10B981"/>
                                <rect x="180" y="185" width="46" height="1.5" fill="#10B981"/>
                            </g>

                            <!-- Tree (left) -->
                            <g class="gentle-swing" style="animation-delay:0s">
                                <rect x="23" y="155" width="6" height="35" rx="2" fill="rgba(16,185,129,0.06)" stroke="rgba(16,185,129,0.1)" stroke-width="1"/>
                                <ellipse cx="26" cy="140" rx="14" ry="18" fill="rgba(16,185,129,0.03)" stroke="rgba(16,185,129,0.06)" stroke-width="1"/>
                                <ellipse cx="26" cy="130" rx="10" ry="12" fill="rgba(16,185,129,0.04)" stroke="rgba(16,185,129,0.08)" stroke-width="1"/>
                                <ellipse cx="26" cy="122" rx="7" ry="8" fill="rgba(16,185,129,0.05)"/>
                            </g>

                            <!-- Tree (right) -->
                            <g class="gentle-swing" style="animation-delay:0.3s">
                                <rect x="268" y="158" width="6" height="32" rx="2" fill="rgba(16,185,129,0.06)" stroke="rgba(16,185,129,0.1)" stroke-width="1"/>
                                <ellipse cx="271" cy="145" rx="12" ry="15" fill="rgba(16,185,129,0.03)" stroke="rgba(16,185,129,0.06)" stroke-width="1"/>
                                <ellipse cx="271" cy="136" rx="8" ry="10" fill="rgba(16,185,129,0.04)" stroke="rgba(16,185,129,0.08)" stroke-width="1"/>
                                <ellipse cx="271" cy="129" rx="6" ry="7" fill="rgba(16,185,129,0.05)"/>
                            </g>

                            <!-- Rain drops -->
                            <g class="raindrop"><line x1="60" y1="40" x2="58" y2="50" stroke="rgba(147,197,253,0.08)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.2s"/></g>
                            <g class="raindrop"><line x1="90" y1="30" x2="88" y2="40" stroke="rgba(147,197,253,0.06)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.6s"/></g>
                            <g class="raindrop"><line x1="260" y1="50" x2="258" y2="60" stroke="rgba(147,197,253,0.07)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.4s"/></g>
                            <g class="raindrop"><line x1="50" y1="80" x2="48" y2="90" stroke="rgba(147,197,253,0.05)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.9s"/></g>
                            <g class="raindrop"><line x1="270" y1="140" x2="268" y2="150" stroke="rgba(147,197,253,0.06)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.3s"/></g>
                            <g class="raindrop"><line x1="140" y1="60" x2="138" y2="70" stroke="rgba(147,197,253,0.05)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.7s"/></g>
                            <g class="raindrop"><line x1="220" y1="90" x2="218" y2="100" stroke="rgba(147,197,253,0.04)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.1s"/></g>
                            <g class="raindrop"><line x1="180" y1="55" x2="178" y2="65" stroke="rgba(147,197,253,0.04)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.5s"/></g>
                            <g class="raindrop"><line x1="110" y1="70" x2="108" y2="80" stroke="rgba(147,197,253,0.03)" stroke-width="1.5" stroke-linecap="round" style="animation-delay:0.15s"/></g>

                            <!-- Puddles on ground -->
                            <ellipse cx="100" cy="191" rx="8" ry="3" fill="rgba(96,165,250,0.02)"/>
                            <ellipse cx="200" cy="193" rx="6" ry="2" fill="rgba(96,165,250,0.02)"/>
                            <ellipse cx="150" cy="194" rx="4" ry="1.5" fill="rgba(96,165,250,0.02)"/>

                            <!-- Person Group -->
                            <g class="person-group person-body">
                                <g class="happy-jump" style="animation-delay:3.2s">
                                    <!-- Shoes -->
                                    <ellipse cx="111" cy="190" rx="6" ry="3" fill="rgba(96,165,250,0.18)"/>
                                    <ellipse cx="129" cy="190" rx="6" ry="3" fill="rgba(96,165,250,0.18)"/>
                                    <!-- Legs walking -->
                                    <line x1="114" y1="166" x2="111" y2="188" stroke="rgba(96,165,250,0.35)" stroke-width="2.8" stroke-linecap="round">
                                        <animate attributeName="x2" values="111;117;111" dur="0.6s" repeatCount="indefinite"/>
                                    </line>
                                    <line x1="126" y1="166" x2="129" y2="188" stroke="rgba(96,165,250,0.35)" stroke-width="2.8" stroke-linecap="round">
                                        <animate attributeName="x2" values="129;123;129" dur="0.6s" repeatCount="indefinite"/>
                                    </line>
                                    <!-- Body / Torso -->
                                    <rect x="108" y="126" width="24" height="40" rx="8" fill="rgba(96,165,250,0.18)" stroke="rgba(96,165,250,0.35)" stroke-width="1.5"/>
                                    <!-- Collar detail -->
                                    <path d="M116 126 L120 132 L124 126" fill="rgba(96,165,250,0.06)" stroke="rgba(96,165,250,0.12)" stroke-width="0.8"/>
                                    <!-- Head -->
                                    <g class="person-head">
                                        <circle cx="120" cy="110" r="15" fill="rgba(96,165,250,0.12)" stroke="rgba(96,165,250,0.35)" stroke-width="1.5"/>

                                        <!-- SAD FACE (searching) -->
                                        <g class="face-sad">
                                            <circle cx="115" cy="109" r="1.8" fill="rgba(96,165,250,0.45)"/>
                                            <circle cx="125" cy="109" r="1.8" fill="rgba(96,165,250,0.45)"/>
                                            <line x1="112" y1="104" x2="117" y2="106" stroke="rgba(96,165,250,0.35)" stroke-width="1.2" stroke-linecap="round"/>
                                            <line x1="124" y1="106" x2="129" y2="104" stroke="rgba(96,165,250,0.35)" stroke-width="1.2" stroke-linecap="round"/>
                                            <path d="M113 117 Q120 113 127 117" stroke="rgba(96,165,250,0.4)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                                            <ellipse cx="113" cy="113" rx="1" ry="1.8" fill="rgba(147,197,253,0.2)">
                                                <animate attributeName="opacity" values="0.3;0;0.3" dur="2s" repeatCount="indefinite"/>
                                            </ellipse>
                                        </g>

                                        <!-- HAPPY FACE (found) -->
                                        <g class="face-happy">
                                            <circle cx="115" cy="108" r="2.2" fill="rgba(96,165,250,0.55)"/>
                                            <circle cx="125" cy="108" r="2.2" fill="rgba(96,165,250,0.55)"/>
                                            <circle cx="114" cy="107" r="0.8" fill="rgba(255,255,255,0.3)"/>
                                            <circle cx="124" cy="107" r="0.8" fill="rgba(255,255,255,0.3)"/>
                                            <line x1="112" y1="103" x2="117" y2="101" stroke="rgba(96,165,250,0.5)" stroke-width="1.2" stroke-linecap="round"/>
                                            <line x1="123" y1="101" x2="128" y2="103" stroke="rgba(96,165,250,0.5)" stroke-width="1.2" stroke-linecap="round"/>
                                            <path d="M112 115 Q120 124 128 115" stroke="rgba(96,165,250,0.55)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                                            <ellipse cx="111" cy="114" rx="3.5" ry="1.8" fill="rgba(245,158,11,0.08)"/>
                                            <ellipse cx="129" cy="114" rx="3.5" ry="1.8" fill="rgba(245,158,11,0.08)"/>
                                        </g>

                                        <!-- Hair -->
                                        <path d="M103 110 Q103 93 120 91 Q137 93 137 110" fill="rgba(96,165,250,0.1)" stroke="rgba(96,165,250,0.2)" stroke-width="1"/>
                                        <path d="M108 95 Q110 88 114 93" fill="rgba(96,165,250,0.06)" stroke="rgba(96,165,250,0.12)" stroke-width="0.6"/>
                                        <path d="M126 93 Q128 87 132 94" fill="rgba(96,165,250,0.06)" stroke="rgba(96,165,250,0.12)" stroke-width="0.6"/>
                                    </g>

                                    <!-- Left arm (hangs at side) -->
                                    <path d="M108 136 Q94 148 90 160" stroke="rgba(96,165,250,0.3)" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                                    <circle cx="90" cy="160" r="2.5" fill="rgba(96,165,250,0.12)"/>
                                    <!-- Right arm holding magnifying glass -->
                                    <g class="person-arm">
                                        <path d="M132 136 Q148 126 160 114" stroke="rgba(96,165,250,0.35)" stroke-width="3" fill="none" stroke-linecap="round" class="glass-hide" style="animation-delay:3.2s"/>
                                    </g>
                                    <circle cx="160" cy="114" r="2.8" fill="rgba(96,165,250,0.15)" class="glass-hide" style="animation-delay:3.2s"/>
                                    <!-- Right arm pointing at house -->
                                    <path d="M132 136 Q145 124 152 112" stroke="rgba(96,165,250,0.3)" stroke-width="2.5" fill="none" stroke-linecap="round" class="point-arm"/>
                                </g>
                            </g>

                            <!-- Hearts floating from happy person -->
                            <g class="heart-float" style="animation-delay:3.2s">
                                <path d="M116 108 Q116 104 119 104 Q122 104 122 108 Q122 112 116 116 Q110 112 110 108 Q110 104 113 104 Q116 104 116 108Z" fill="rgba(245,158,11,0.15)" transform="scale(0.5)"/>
                            </g>
                            <g class="heart-float" style="animation-delay:3.7s">
                                <path d="M116 108 Q116 104 119 104 Q122 104 122 108 Q122 112 116 116 Q110 112 110 108 Q110 104 113 104 Q116 104 116 108Z" fill="rgba(245,158,11,0.12)" transform="scale(0.4)"/>
                            </g>
                            <g class="heart-float" style="animation-delay:4.2s">
                                <path d="M116 108 Q116 104 119 104 Q122 104 122 108 Q122 112 116 116 Q110 112 110 108 Q110 104 113 104 Q116 104 116 108Z" fill="rgba(239,68,68,0.1)" transform="scale(0.35)"/>
                            </g>

                            <!-- Magnifying Glass -->
                            <g class="search-glass glass-hide" style="animation-delay:3.2s">
                                <circle cx="160" cy="114" r="14" stroke="rgba(96,165,250,0.5)" stroke-width="2.5" fill="rgba(96,165,250,0.04)"/>
                                <path d="M150 106 Q155 102 161 105" stroke="rgba(147,197,253,0.35)" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                                <line x1="170" y1="124" x2="183" y2="137" stroke="rgba(96,165,250,0.4)" stroke-width="2.8" stroke-linecap="round"/>
                                <ellipse cx="155" cy="110" rx="4" ry="2" fill="rgba(147,197,253,0.1)" transform="rotate(-20 155 110)"/>
                            </g>

                            <!-- Search result connection line -->
                            <path d="M136 118 Q165 108 190 138" stroke="rgba(96,165,250,0.08)" stroke-width="1.5" stroke-dasharray="5 4" fill="none" style="opacity:0; animation: fadeIn 0.5s ease-in 2.8s forwards"/>

                            <!-- Traveling dots from person to house -->
                            <circle cx="140" cy="118" r="2" fill="rgba(96,165,250,0.2)" class="travel-dot" style="animation-delay:3s"/>
                            <circle cx="155" cy="113" r="2" fill="rgba(96,165,250,0.16)" class="travel-dot" style="animation-delay:3.3s"/>
                            <circle cx="170" cy="116" r="2" fill="rgba(96,165,250,0.12)" class="travel-dot" style="animation-delay:3.6s"/>

                            <!-- Found! House (detailed) -->
                            <g class="house-found">
                                <rect x="192" y="150" width="46" height="38" rx="4" fill="url(#houseGrad)" stroke="rgba(16,185,129,0.5)" stroke-width="2"/>
                                <path d="M185 154 L215 129 L247 154" stroke="rgba(16,185,129,0.5)" stroke-width="2.5" fill="rgba(16,185,129,0.08)" stroke-linejoin="round"/>
                                <!-- Roof tiles -->
                                <line x1="196" y1="148" x2="234" y2="148" stroke="rgba(16,185,129,0.05)" stroke-width="0.5"/>
                                <line x1="200" y1="143" x2="230" y2="143" stroke="rgba(16,185,129,0.05)" stroke-width="0.5"/>
                                <line x1="204" y1="138" x2="226" y2="138" stroke="rgba(16,185,129,0.05)" stroke-width="0.5"/>
                                <!-- Chimney -->
                                <rect x="226" y="133" width="8" height="14" rx="2" fill="rgba(16,185,129,0.1)" stroke="rgba(16,185,129,0.3)" stroke-width="1.2"/>
                                <!-- Smoke -->
                                <circle cx="230" cy="128" r="3" fill="rgba(147,197,253,0.08)" class="dot-pulse" style="animation-delay:0.1s"/>
                                <circle cx="233" cy="121" r="2.5" fill="rgba(147,197,253,0.06)" class="dot-pulse" style="animation-delay:0.4s"/>
                                <circle cx="229" cy="115" r="2" fill="rgba(147,197,253,0.04)" class="dot-pulse" style="animation-delay:0.7s"/>
                                <!-- Door -->
                                <rect x="209" y="166" width="14" height="14" rx="2" fill="rgba(16,185,129,0.15)" stroke="rgba(16,185,129,0.3)" stroke-width="1.2"/>
                                <circle cx="220" cy="174" r="1.2" fill="rgba(16,185,129,0.5)"/>
                                <path d="M209 168 Q216 164 223 168" stroke="rgba(16,185,129,0.2)" stroke-width="0.8" fill="none"/>
                                <!-- Left window -->
                                <rect x="196" y="156" width="10" height="10" rx="1.5" fill="rgba(147,197,253,0.12)" stroke="rgba(16,185,129,0.3)" stroke-width="1"/>
                                <line x1="201" y1="156" x2="201" y2="166" stroke="rgba(16,185,129,0.15)" stroke-width="0.6"/>
                                <line x1="196" y1="161" x2="206" y2="161" stroke="rgba(16,185,129,0.15)" stroke-width="0.6"/>
                                <rect x="197" y="157" width="4" height="4" rx="0.5" fill="rgba(245,158,11,0.08)"/>
                                <rect x="202" y="157" width="3" height="4" rx="0.5" fill="rgba(245,158,11,0.05)"/>
                                <!-- Right window -->
                                <rect x="224" y="156" width="10" height="10" rx="1.5" fill="rgba(147,197,253,0.12)" stroke="rgba(16,185,129,0.3)" stroke-width="1"/>
                                <line x1="229" y1="156" x2="229" y2="166" stroke="rgba(16,185,129,0.15)" stroke-width="0.6"/>
                                <line x1="224" y1="161" x2="234" y2="161" stroke="rgba(16,185,129,0.15)" stroke-width="0.6"/>
                                <rect x="225" y="157" width="4" height="4" rx="0.5" fill="rgba(245,158,11,0.08)"/>
                                <rect x="230" y="157" width="3" height="4" rx="0.5" fill="rgba(245,158,11,0.05)"/>
                            </g>

                            <!-- Checkmark -->
                            <g class="checkmark">
                                <circle cx="215" cy="140" r="16" fill="rgba(16,185,129,0.08)" stroke="rgba(16,185,129,0.3)" stroke-width="1.8"/>
                                <circle cx="215" cy="140" r="10" fill="rgba(16,185,129,0.04)"/>
                                <path d="M207 140 L212 146 L223 134" stroke="rgba(16,185,129,0.65)" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>

                            <!-- FOUND! Badge -->
                            <g class="found-text">
                                <rect x="184" y="114" width="62" height="22" rx="11" fill="rgba(16,185,129,0.08)" stroke="rgba(16,185,129,0.25)" stroke-width="1.2"/>
                                <rect x="186" y="116" width="58" height="18" rx="9" fill="rgba(16,185,129,0.04)"/>
                                <text x="215" y="129" text-anchor="middle" font-size="10" font-weight="800" fill="rgba(16,185,129,0.7)" font-family="sans-serif" letter-spacing="0.5">FOUND!</text>
                            </g>

                            <!-- Sparkles -->
                            <text class="sparkle" x="175" y="95" font-size="14" fill="rgba(245,158,11,0.5)" style="animation-delay:3.4s">✦</text>
                            <text class="sparkle" x="248" y="120" font-size="10" fill="rgba(245,158,11,0.4)" style="animation-delay:3.7s">✦</text>
                            <text class="sparkle" x="255" y="175" font-size="11" fill="rgba(96,165,250,0.4)" style="animation-delay:4s">✦</text>
                            <text class="sparkle" x="265" y="92" font-size="8" fill="rgba(147,197,253,0.35)" style="animation-delay:4.3s">✦</text>
                            <text class="sparkle" x="185" y="80" font-size="9" fill="rgba(245,158,11,0.3)" style="animation-delay:3.5s">✦</text>
                            <text class="sparkle" x="160" y="178" font-size="8" fill="rgba(96,165,250,0.3)" style="animation-delay:4.1s">✦</text>
                            <text class="sparkle" x="240" y="80" font-size="7" fill="rgba(255,255,255,0.25)" style="animation-delay:3.9s">✦</text>

                            <!-- Confetti pieces -->
                            <rect x="170" y="80" width="3" height="5" rx="1" fill="rgba(245,158,11,0.2)" transform="rotate(30 171 82)" class="float-element" style="animation-delay:3.5s"/>
                            <rect x="240" y="100" width="3" height="5" rx="1" fill="rgba(16,185,129,0.2)" transform="rotate(-20 241 102)" class="float-element" style="animation-delay:3.8s"/>
                            <rect x="190" y="160" width="3" height="5" rx="1" fill="rgba(96,165,250,0.2)" transform="rotate(45 191 162)" class="float-element" style="animation-delay:4.1s"/>
                            <rect x="260" y="145" width="3" height="5" rx="1" fill="rgba(245,158,11,0.18)" transform="rotate(60 261 147)" class="float-element" style="animation-delay:3.6s"/>
                            <rect x="155" y="170" width="3" height="5" rx="1" fill="rgba(147,197,253,0.2)" transform="rotate(-40 156 172)" class="float-element" style="animation-delay:4.4s"/>
                            <rect x="200" y="75" width="3" height="5" rx="1" fill="rgba(16,185,129,0.18)" transform="rotate(15 201 77)" class="float-element" style="animation-delay:3.2s"/>
                            <rect x="230" y="170" width="3" height="5" rx="1" fill="rgba(245,158,11,0.15)" transform="rotate(-60 231 172)" class="float-element" style="animation-delay:4.7s"/>
                            <rect x="250" y="130" width="3" height="5" rx="1" fill="rgba(239,68,68,0.15)" transform="rotate(70 251 132)" class="float-element" style="animation-delay:3.3s"/>

                            <!-- Property detail popup card -->

                            <!-- Road/path -->
                            <g class="slide-in-left" style="animation-delay:2.2s" opacity="0.06">
                                <path d="M0 192 Q75 186 150 192 Q225 186 300 192" stroke="rgba(96,165,250,0.08)" stroke-width="1.5" fill="none"/>
                                <path d="M0 196 Q75 190 150 196 Q225 190 300 196" stroke="rgba(96,165,250,0.06)" stroke-width="1" fill="none"/>
                                <line x1="0" y1="194" x2="15" y2="194" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="30" y1="194" x2="45" y2="194" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="60" y1="194" x2="75" y2="194" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="90" y1="192" x2="105" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="120" y1="192" x2="135" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="150" y1="192" x2="165" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="180" y1="192" x2="195" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="210" y1="192" x2="225" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="240" y1="192" x2="255" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                                <line x1="270" y1="192" x2="285" y2="192" stroke="rgba(96,165,250,0.04)" stroke-width="0.8"/>
                            </g>

                            <!-- Lamp post (left) -->
                            <g class="slide-up" style="animation-delay:2.6s" opacity="0.06">
                                <rect x="56" y="145" width="2" height="47" fill="rgba(245,158,11,0.2)"/>
                                <path d="M48 145 Q57 140 66 145" stroke="rgba(245,158,11,0.2)" stroke-width="1.2" fill="none"/>
                                <circle cx="57" cy="143" r="3" fill="rgba(245,158,11,0.08)"/>
                                <ellipse cx="57" cy="148" rx="8" ry="4" fill="rgba(245,158,11,0.03)"/>
                            </g>

                            <!-- Lamp post (right) -->
                            <g class="slide-up" style="animation-delay:2.8s" opacity="0.06">
                                <rect x="246" y="148" width="2" height="44" fill="rgba(245,158,11,0.2)"/>
                                <path d="M238 148 Q247 143 256 148" stroke="rgba(245,158,11,0.2)" stroke-width="1.2" fill="none"/>
                                <circle cx="247" cy="146" r="3" fill="rgba(245,158,11,0.08)"/>
                                <ellipse cx="247" cy="151" rx="8" ry="4" fill="rgba(245,158,11,0.03)"/>
                            </g>

                            <!-- Small car on road -->
                            <g class="roll-in" style="animation-delay:3.5s" opacity="0.06">
                                <rect x="100" y="185" width="16" height="8" rx="2" fill="rgba(96,165,250,0.15)"/>
                                <rect x="104" y="182" width="10" height="5" rx="1.5" fill="rgba(96,165,250,0.1)"/>
                                <circle cx="104" cy="193" r="2" fill="rgba(96,165,250,0.12)"/>
                                <circle cx="113" cy="193" r="2" fill="rgba(96,165,250,0.12)"/>
                                <circle cx="116" cy="188" r="1" fill="rgba(245,158,11,0.08)"/>
                            </g>

                            <!-- Second bird (smaller, different path) -->
                            <g class="bird-fly" style="animation-delay:1.5s;">
                                <path d="M0 0 Q5 -4 10 0" stroke="rgba(147,197,253,0.1)" stroke-width="0.8" fill="none" stroke-linecap="round" class="bird-wing"/>
                                <path d="M10 0 Q15 -4 20 0" stroke="rgba(147,197,253,0.1)" stroke-width="0.8" fill="none" stroke-linecap="round" class="bird-wing" style="animation-delay:-0.1s"/>
                            </g>

                            <!-- Third bird (far away, tiny) -->
                            <g class="bird-fly" style="animation-delay:2.5s; animation-duration:6s;">
                                <path d="M0 0 Q4 -3 8 0" stroke="rgba(147,197,253,0.06)" stroke-width="0.6" fill="none" stroke-linecap="round" class="bird-wing"/>
                                <path d="M8 0 Q12 -3 16 0" stroke="rgba(147,197,253,0.06)" stroke-width="0.6" fill="none" stroke-linecap="round" class="bird-wing" style="animation-delay:-0.1s"/>
                            </g>

                            <!-- Floating leaves -->
                            <ellipse cx="38" cy="100" rx="2" ry="1" fill="rgba(16,185,129,0.05)" class="float-element" style="animation-delay:0.5s; animation-duration:4s" transform="rotate(30 38 100)"/>
                            <ellipse cx="262" cy="90" rx="2" ry="1" fill="rgba(245,158,11,0.04)" class="float-element" style="animation-delay:1.2s; animation-duration:5s" transform="rotate(-20 262 90)"/>
                            <ellipse cx="148" cy="70" rx="1.5" ry="0.8" fill="rgba(147,197,253,0.03)" class="float-element" style="animation-delay:2s; animation-duration:3.5s" transform="rotate(45 148 70)"/>

                            <g class="card-flip" style="animation-delay:2s">
                                <rect x="18" y="143" width="62" height="44" rx="7" fill="rgba(15,23,42,0.3)" stroke="rgba(96,165,250,0.06)" stroke-width="1"/>
                                <rect x="22" y="147" width="54" height="15" rx="4" fill="rgba(147,197,253,0.04)"/>
                                <text x="49" y="158" text-anchor="middle" font-size="5.5" font-weight="700" fill="rgba(16,185,129,0.5)" font-family="sans-serif">Dream House</text>
                                <rect x="22" y="165" width="54" height="4" rx="2" fill="rgba(147,197,253,0.05)"/>
                                <rect x="22" y="173" width="32" height="4" rx="2" fill="rgba(147,197,253,0.03)"/>
                                <text x="49" y="182" text-anchor="middle" font-size="5.5" font-weight="700" fill="rgba(245,158,11,0.5)" font-family="sans-serif">BDT 15,000/mo</text>
                            </g>

                            <!-- Floating dots (ambient) -->
                            <circle cx="70" cy="55" r="2.5" fill="rgba(96,165,250,0.06)" class="dot-pulse" style="animation-delay:0.3s"/>
                            <circle cx="240" cy="65" r="2" fill="rgba(147,197,253,0.05)" class="dot-pulse" style="animation-delay:0.7s"/>
                            <circle cx="55" cy="145" r="2" fill="rgba(147,197,253,0.04)" class="dot-pulse" style="animation-delay:1.1s"/>
                            <circle cx="270" cy="85" r="2.5" fill="rgba(96,165,250,0.05)" class="dot-pulse" style="animation-delay:1.5s"/>
                            <circle cx="85" cy="105" r="1.5" fill="rgba(96,165,250,0.04)" class="dot-pulse" style="animation-delay:1.9s"/>
                            <circle cx="140" cy="45" r="1.5" fill="rgba(147,197,253,0.03)" class="dot-pulse" style="animation-delay:0.5s"/>
                            <circle cx="230" cy="180" r="1.5" fill="rgba(96,165,250,0.03)" class="dot-pulse" style="animation-delay:2.1s"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="floating-card">
                    <div class="fc-icon gold"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="fc-text"><div class="fc-num">Quick</div><div class="fc-label">Response Time</div></div>
                </div>
                <div class="floating-card">
                    <div class="fc-icon blue"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="fc-text"><div class="fc-num">Verified</div><div class="fc-label">Properties Only</div></div>
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
    <span class="ring-pulse"></span>
    <span class="ring-pulse"></span>
    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="20" x2="12" y2="4"/>
        <polyline points="5 11 12 4 19 11"/>
    </svg>
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

// ── Hero Scene Looper (smooth fade) ──
(function() {
    var svg = document.querySelector('.hero-scene svg');
    if (!svg) return;
    var loopWrap = svg.querySelector('.scene-loop');
    if (!loopWrap) return;
    function restartScene() {
        // Fade out, replace, fade in
        loopWrap.style.transition = 'opacity 0.35s ease-in-out';
        loopWrap.style.opacity = '0';
        setTimeout(function() {
            var clone = loopWrap.cloneNode(true);
            clone.style.opacity = '0';
            clone.style.transition = 'opacity 0.35s ease-in-out';
            svg.replaceChild(clone, loopWrap);
            loopWrap = clone;
            requestAnimationFrame(function() {
                loopWrap.style.opacity = '1';
            });
        }, 400);
    }
    setInterval(restartScene, 5800);
})();

// ── Enhanced floating cards entrance ──
(function() {
    document.querySelectorAll('.floating-card').forEach(function(card, i) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px) scale(0.85)';
        setTimeout(function() {
            card.style.transition = 'all 0.7s cubic-bezier(0.34,1.56,0.64,1)';
            card.style.opacity = '1';
            card.style.transform = '';
        }, 600 + i * 400);
    });
})();
</script>
@endpush
