@extends('frontend.layouts.app')

@section('title', 'Register')

@push('styles')
<style>
/* ═══════════════════════════════════════════
   REGISTER PAGE — Animated Character Edition
   ═══════════════════════════════════════════ */

/* ── Layout ── */
.register-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0B1121 0%, #0F172A 40%, #1E3A5F 100%);
    position: relative;
    overflow: hidden;
    padding: 2rem 1rem;
}
.register-page::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 30%, rgba(245,158,11,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 70%, rgba(239,68,68,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.register-grid {
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 2.5rem;
    max-width: 950px;
    width: 100%;
    align-items: center;
    position: relative;
    z-index: 1;
}
@media (max-width: 900px) {
    .register-grid { grid-template-columns: 1fr; max-width: 460px; gap: 1.5rem; }
    .char-panel { display: none; }
}

/* ═══════════════════════════════════════════
   CHARACTER PANEL
   ═══════════════════════════════════════════ */
.char-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 2rem;
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(24px) saturate(1.5);
    -webkit-backdrop-filter: blur(24px) saturate(1.5);
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.08);
    position: relative;
    min-height: 450px;
}
.char-panel::before {
    content: '';
    position: absolute; inset: 0; border-radius: 28px; padding: 1.5px;
    background: linear-gradient(135deg, rgba(251,191,36,0.2), rgba(245,158,11,0.25), rgba(239,68,68,0.2), rgba(16,185,129,0.15), rgba(251,191,36,0.2));
    background-size: 400% 400%;
    animation: charBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes charBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }

@media (max-width: 900px) {
    .char-panel { min-height: 260px; padding: 1.5rem; }
}

/* ── Pure CSS Cartoon Character ── */
.char-container {
    width: 220px;
    height: 220px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
@media (max-width: 900px) {
    .char-container { width: 180px; height: 180px; }
}
@media (max-width: 480px) {
    .char-container { width: 160px; height: 160px; }
}

/* ── Character Base ── */
.cartoon-char {
    position: relative;
    width: 160px;
    height: 168px;
}
@media (max-width: 900px) {
    .cartoon-char { width: 130px; height: 136px; }
}

/* ── Idle Float ── */
.cartoon-char.idle {
    animation: charFloat 2.8s ease-in-out infinite;
}
@keyframes charFloat {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

/* ── Head group ── */
.char-head-group {
    position: absolute;
    top: 0; left: 50%;
    transform: translateX(-50%);
    transform-origin: center 40px;
    transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1);
    z-index: 2;
}
.char-head-group.look-name {
    transform: translateX(-50%) rotate(16deg) translateX(5px);
}
.char-head-group.look-email {
    transform: translateX(-50%) rotate(8deg) translateX(3px);
}
.char-head-group.look-password {
    transform: translateX(-50%) rotate(-12deg) translateX(-3px);
}
.char-head-group.shake {
    animation: headShakeCSS 0.6s ease-in-out;
}
@keyframes headShakeCSS {
    0%,100% { transform: translateX(-50%) rotate(0deg); }
    10%,50%,90% { transform: translateX(-50%) rotate(-18deg); }
    30%,70% { transform: translateX(-50%) rotate(18deg); }
}

/* ── Head ── */
.char-head {
    width: 68px;
    height: 68px;
    background: linear-gradient(135deg, #FDE68A, #F59E0B);
    border-radius: 50%;
    position: relative;
    border: 2px solid rgba(251,191,36,0.25);
    box-shadow: 0 4px 20px rgba(245,158,11,0.15);
}
@media (max-width: 900px) {
    .char-head { width: 55px; height: 55px; }
}

/* ── Ears ── */
.char-ear {
    position: absolute;
    top: 18px;
    width: 16px; height: 16px;
    background: rgba(251,191,36,0.15);
    border-radius: 50%;
    border: 1.5px solid rgba(251,191,36,0.15);
}
.char-ear.left { left: -9px; }
.char-ear.right { right: -9px; }
.char-ear::after {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 7px; height: 7px;
    background: rgba(239,68,68,0.1);
    border-radius: 50%;
}
@media (max-width: 900px) {
    .char-ear { width: 13px; height: 13px; top: 14px; }
    .char-ear.left { left: -7px; }
    .char-ear.right { right: -7px; }
    .char-ear::after { width: 5px; height: 5px; }
}

/* ── Eyes ── */
.char-eyes-wrap {
    position: absolute;
    top: 22px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 14px;
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.char-eyes-wrap.look-name {
    transform: translateX(-40%) translateX(3px);
}
.char-eyes-wrap.look-email {
    transform: translateX(-30%) translateX(2px);
}
.char-eyes-wrap.look-password {
    transform: translateX(-60%) translateX(-2px) translateY(2px);
}
@media (max-width: 900px) {
    .char-eyes-wrap { top: 18px; gap: 11px; }
}

.char-eye {
    width: 18px;
    height: 20px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    position: relative;
    border: 1.5px solid rgba(251,191,36,0.12);
    overflow: hidden;
}
@media (max-width: 900px) {
    .char-eye { width: 14px; height: 16px; }
}

.char-pupil {
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px; height: 8px;
    background: rgba(217,119,6,0.5);
    border-radius: 50%;
    transition: all 0.3s ease;
}
.char-eyes-wrap.look-name .char-pupil {
    transform: translateX(-30%) translateX(2px);
}
.char-eyes-wrap.look-email .char-pupil {
    transform: translateX(-30%) translateX(3px);
}
.char-eyes-wrap.look-password .char-pupil {
    transform: translateX(-70%) translateX(-1px) translateY(1px);
}
@media (max-width: 900px) {
    .char-pupil { width: 6px; height: 6px; bottom: 3px; }
}

.char-eye-shine {
    position: absolute;
    top: 3px; right: 3px;
    width: 5px; height: 5px;
    background: rgba(255,255,255,0.35);
    border-radius: 50%;
    animation: sparklePulse 2s ease-in-out infinite;
}
@media (max-width: 900px) {
    .char-eye-shine { width: 4px; height: 4px; }
}

/* ── Blink overlay ── */
.char-blink {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(15,23,42,0.9);
    border-radius: 50%;
    clip-path: inset(0 0 50% 0);
    animation: blink 3.5s ease-in-out infinite;
    pointer-events: none;
}
@keyframes blink {
    0%,96%,100% { opacity: 0; }
    97% { opacity: 1; }
}

/* ── Blush ── */
.char-blush {
    position: absolute;
    top: 38px;
    width: 14px; height: 7px;
    background: rgba(239,68,68,0.1);
    border-radius: 50%;
    animation: blushPulse 2.5s ease-in-out infinite;
}
.char-blush.left { left: 6px; }
.char-blush.right { right: 6px; }
@keyframes blushPulse { 0%,100% { opacity: 0.2; } 50% { opacity: 0.4; } }
@media (max-width: 900px) {
    .char-blush { width: 11px; height: 6px; top: 30px; }
    .char-blush.left { left: 5px; }
    .char-blush.right { right: 5px; }
}

/* ── Eyebrows ── */
.char-brow {
    position: absolute;
    top: 16px;
    width: 16px; height: 2px;
    background: rgba(217,119,6,0.15);
    border-radius: 2px;
}
.char-brow.left { left: 12px; transform: rotate(-8deg); }
.char-brow.right { right: 12px; transform: rotate(8deg); }
@media (max-width: 900px) {
    .char-brow { width: 13px; top: 13px; }
    .char-brow.left { left: 10px; }
    .char-brow.right { right: 10px; }
}

/* ── Mouth ── */
.char-mouth {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    width: 12px; height: 2px;
    background: rgba(217,119,6,0.2);
    border-radius: 2px;
    transition: all 0.3s ease;
}
.char-mouth.happy {
    width: 16px;
    height: 7px;
    background: transparent;
    border-bottom: 2px solid rgba(217,119,6,0.2);
    border-radius: 0 0 50% 50%;
    bottom: 10px;
}
.char-mouth.sad {
    width: 14px;
    background: transparent;
    border-top: 2px solid rgba(217,119,6,0.2);
    border-radius: 50% 50% 0 0;
    bottom: 14px;
}
@media (max-width: 900px) {
    .char-mouth { width: 10px; bottom: 9px; }
    .char-mouth.happy { width: 13px; height: 5px; bottom: 7px; }
    .char-mouth.sad { width: 11px; bottom: 11px; }
}

/* ── Body ── */
.char-body {
    position: absolute;
    top: 74px;
    left: 50%;
    transform: translateX(-50%);
    width: 56px; height: 52px;
    background: linear-gradient(180deg, #F59E0B, #D97706);
    border-radius: 20px 20px 14px 14px;
    border: 2px solid rgba(251,191,36,0.25);
    z-index: 1;
}
@media (max-width: 900px) {
    .char-body { width: 44px; height: 42px; top: 60px; border-radius: 16px 16px 10px 10px; }
}

/* ── Belly ── */
.char-belly {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px; height: 14px;
    background: radial-gradient(ellipse, rgba(251,191,36,0.3), rgba(245,158,11,0.08));
    border-radius: 50%;
    border: 1px solid rgba(251,191,36,0.08);
}
@media (max-width: 900px) {
    .char-belly { width: 16px; height: 11px; bottom: 7px; }
}

/* ── Collar ── */
.char-collar {
    position: absolute;
    top: -1px;
    left: 50%;
    transform: translateX(-50%);
    width: 22px;
    height: 8px;
    border-bottom: 2px solid rgba(251,191,36,0.15);
    border-radius: 0 0 50% 50%;
}

/* ── Hoodie ── */
.char-hood {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    width: 52px;
    height: 22px;
    background: linear-gradient(180deg, #D97706, #B45309);
    border-radius: 10px 10px 4px 4px;
    border: 1.5px solid rgba(251,191,36,0.2);
}
.char-hood-string {
    position: absolute;
    bottom: -2px;
    left: 8px;
    width: 2px; height: 14px;
    background: rgba(251,191,36,0.2);
    border-radius: 1px;
    transform: rotate(-8deg);
    transform-origin: top center;
    animation: stringSwing 2s ease-in-out infinite;
}
.char-hood-string.right {
    left: auto; right: 8px;
    transform: rotate(8deg);
    animation-delay: 0.3s;
}
@keyframes stringSwing {
    0%,100% { transform: rotate(-8deg); }
    50% { transform: rotate(-18deg); }
}
.char-hood-string.right {
    animation-name: stringSwingRight;
}
@keyframes stringSwingRight {
    0%,100% { transform: rotate(8deg); }
    50% { transform: rotate(18deg); }
}
@media (max-width: 900px) {
    .char-hood { width: 42px; height: 18px; top: -11px; }
    .char-hood-string { height: 11px; }
    .char-hood-string { left: 6px; }
    .char-hood-string.right { left: auto; right: 6px; }
}

/* ── Feet ── */
.char-feet {
    position: absolute;
    top: 132px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 16px;
    z-index: 0;
}
.char-foot {
    width: 16px; height: 7px;
    background: rgba(217,119,6,0.2);
    border-radius: 50%;
}
@media (max-width: 900px) {
    .char-feet { top: 107px; gap: 12px; }
    .char-foot { width: 13px; height: 6px; }
}

/* ── Arms ── */
.char-arm {
    position: absolute;
    top: 76px;
    width: 10px; height: 30px;
    background: rgba(245,158,11,0.25);
    border-radius: 6px;
    transform-origin: top center;
    transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1);
    z-index: 1;
}
.char-arm::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 50%;
    transform: translateX(-50%);
    width: 7px; height: 7px;
    background: rgba(245,158,11,0.2);
    border-radius: 50%;
    border: 1px solid rgba(251,191,36,0.12);
}
.char-arm.left {
    left: 38px;
    transform: rotate(8deg);
}
.char-arm.right {
    right: 38px;
    transform: rotate(-8deg);
}

/* Arm idle wave */
.cartoon-char.idle .char-arm.right {
    animation: armWave 2.5s ease-in-out infinite;
}
@keyframes armWave {
    0%,100% { transform: rotate(-8deg); }
    25% { transform: rotate(-18deg); }
    75% { transform: rotate(2deg); }
}

/* Arm pointing name */
.char-arm.right.point-name {
    transform: rotate(40deg) translateX(5px);
}
.char-arm.left.point-name {
    transform: rotate(-25deg) translateX(-3px);
}

/* Arm pointing email */
.char-arm.right.point-email {
    transform: rotate(30deg) translateX(3px);
}
.char-arm.left.point-email {
    transform: rotate(-20deg) translateX(-2px);
}

/* Arm pointing password */
.char-arm.right.point-password {
    transform: rotate(-40deg) translateX(-4px);
}
.char-arm.left.point-password {
    transform: rotate(25deg) translateX(4px);
}

@media (max-width: 900px) {
    .char-arm { width: 8px; height: 24px; top: 62px; }
    .char-arm.left { left: 30px; }
    .char-arm.right { right: 30px; }
    .char-arm::after { width: 6px; height: 6px; bottom: -2px; }
}

/* ── Shadow ── */
.char-shadow {
    position: absolute;
    bottom: -6px;
    left: 50%;
    transform: translateX(-50%);
    width: 75px; height: 8px;
    background: rgba(0,0,0,0.15);
    border-radius: 50%;
    animation: shadowPulse 2.8s ease-in-out infinite;
    z-index: 0;
}
@keyframes shadowPulse {
    0%,100% { transform: translateX(-50%) scale(1); opacity: 0.5; }
    50% { transform: translateX(-50%) scale(0.85); opacity: 0.3; }
}
@media (max-width: 900px) {
    .char-shadow { width: 60px; height: 7px; }
}

/* ═══════════════════════════════════════════
   CHARACTER EMOTIONS
   ═══════════════════════════════════════════ */

/* ── Sweat Drop ── */
.char-sweat {
    position: absolute;
    top: 3px;
    right: -6px;
    width: 10px; height: 14px;
    background: linear-gradient(180deg, rgba(147,197,253,0.35), rgba(147,197,253,0.1));
    border-radius: 50% 50% 50% 0;
    transform: rotate(-15deg);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
    z-index: 10;
}
.char-sweat.show {
    opacity: 1;
    animation: sweatDrip 1.2s ease-in-out infinite;
}
@keyframes sweatDrip {
    0%,100% { transform: rotate(-15deg) translateY(0); opacity: 0.8; }
    30% { transform: rotate(-15deg) translateY(3px); opacity: 0.6; }
    60% { transform: rotate(-15deg) translateY(6px); opacity: 0.3; }
    100% { transform: rotate(-15deg) translateY(0); opacity: 0.8; }
}

/* ── EYEBROW EMOTIONS ── */
.char-brow.raised.left {
    transform: rotate(-16deg) translateY(-4px);
    transition: all 0.3s ease;
}
.char-brow.raised.right {
    transform: rotate(16deg) translateY(-4px);
    transition: all 0.3s ease;
}
.char-brow.lowered.left {
    transform: rotate(10deg) translateY(2px);
    transition: all 0.3s ease;
}
.char-brow.lowered.right {
    transform: rotate(-10deg) translateY(2px);
    transition: all 0.3s ease;
}
.char-brow.confused.left {
    transform: rotate(-16deg) translateY(-4px);
    transition: all 0.3s ease;
}
.char-brow.confused.right {
    transform: rotate(6deg) translateY(1px);
    transition: all 0.3s ease;
}

/* ── EYE EMOTIONS ── */
.char-eyes-wrap.excited .char-eye {
    transform: scaleY(1.2);
    animation: eyeSpark 1.5s ease-in-out infinite;
}
.char-eyes-wrap.excited .char-eye-shine {
    width: 7px; height: 7px;
    background: rgba(255,255,255,0.6);
    animation: sparklePulse 0.8s ease-in-out infinite;
}
@keyframes eyeSpark {
    0%,100% { transform: scaleY(1.2); }
    50% { transform: scaleY(1.25) scaleX(1.05); }
}
@keyframes sparklePulse {
    0%,100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.3); opacity: 1; }
}

.char-eyes-wrap.squint .char-eye {
    transform: scaleY(0.65);
}
.char-eyes-wrap.squint .char-pupil {
    width: 6px; height: 6px;
}

.char-eyes-wrap.thinking .char-pupil {
    transform: translateX(-50%) translateY(-4px);
}

/* ── MOUTH EMOTIONS ── */
.char-mouth.open {
    width: 18px;
    height: 12px;
    background: rgba(30,58,95,0.3);
    border: none;
    border-radius: 50%;
    bottom: 8px;
}
.char-mouth.open::after {
    content: '';
    position: absolute;
    top: 3px; left: 5px;
    width: 8px; height: 4px;
    background: rgba(239,68,68,0.15);
    border-radius: 50%;
}

.char-mouth.big-smile {
    width: 20px;
    height: 8px;
    background: transparent;
    border-bottom: 2.5px solid rgba(217,119,6,0.3);
    border-radius: 0 0 50% 50%;
    bottom: 9px;
}

.char-mouth.woah {
    width: 10px;
    height: 10px;
    background: rgba(30,58,95,0.25);
    border: none;
    border-radius: 50%;
    bottom: 10px;
}

.char-mouth.nervous {
    width: 14px;
    height: 5px;
    background: transparent;
    border-bottom: 2px solid rgba(217,119,6,0.15);
    border-radius: 0 0 50% 50%;
    bottom: 10px;
    animation: nervousTwitch 2s ease-in-out infinite;
}
@keyframes nervousTwitch {
    0%,100% { transform: translateX(-50%) scaleX(1); }
    30% { transform: translateX(-50%) scaleX(0.85); }
    60% { transform: translateX(-50%) scaleX(1.1); }
}

@media (max-width: 900px) {
    .char-mouth.open { width: 14px; height: 9px; bottom: 6px; }
    .char-mouth.open::after { width: 6px; height: 3px; top: 2px; left: 4px; }
    .char-mouth.big-smile { width: 16px; height: 6px; bottom: 7px; }
    .char-mouth.woah { width: 8px; height: 8px; bottom: 8px; }
    .char-mouth.nervous { width: 11px; height: 4px; bottom: 8px; }
}

/* ── HEAD ANIMATIONS ── */
.char-head-group.excited-bounce {
    animation: headBounce 0.6s ease-in-out;
}
@keyframes headBounce {
    0% { transform: translateX(-50%) rotate(0deg); }
    15% { transform: translateX(-50%) rotate(18deg) translateY(-6px); }
    30% { transform: translateX(-50%) rotate(14deg) translateY(0); }
    45% { transform: translateX(-50%) rotate(20deg) translateY(-3px); }
    60% { transform: translateX(-50%) rotate(12deg) translateY(0); }
    100% { transform: translateX(-50%) rotate(16deg) translateX(5px); }
}

.char-head-group.tilt-thinking {
    animation: headTilt 1.2s ease-in-out infinite;
}
@keyframes headTilt {
    0%,100% { transform: translateX(-50%) rotate(5deg); }
    50% { transform: translateX(-50%) rotate(10deg); }
}

.char-head-group.tilt-idle {
    animation: idleTilt 3s ease-in-out infinite;
}
@keyframes idleTilt {
    0%,100% { transform: translateX(-50%) rotate(0deg); }
    25% { transform: translateX(-50%) rotate(3deg); }
    75% { transform: translateX(-50%) rotate(-2deg); }
}

/* ── BLUSH VARIATIONS ── */
.char-blush.excited {
    background: rgba(239,68,68,0.2);
    width: 16px; height: 8px;
    animation: blushExcited 1.2s ease-in-out infinite;
}
@keyframes blushExcited {
    0%,100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.15); }
}
@media (max-width: 900px) {
    .char-blush.excited { width: 13px; height: 7px; }
}

.char-blush.nervous {
    background: rgba(239,68,68,0.06);
    animation: blushNervous 2s ease-in-out infinite;
}
@keyframes blushNervous {
    0%,100% { opacity: 0.1; }
    50% { opacity: 0.25; }
}

/* ── EXCITED BODY BOUNCE ── */
.cartoon-char.excited-bounce {
    animation: charBounce 0.5s ease-in-out 3;
}
@keyframes charBounce {
    0%,100% { transform: translateY(0); }
    25% { transform: translateY(-10px); }
    50% { transform: translateY(-4px); }
    75% { transform: translateY(-8px); }
}

/* ── Character Status Text ── */
.char-status {
    margin-top: 1rem;
    text-align: center;
    transition: all 0.4s ease;
}
.char-status .greeting {
    font-size: 1.25rem;
    font-weight: 800;
    color: #fff;
    display: block;
    transition: all 0.3s ease;
    text-shadow: 0 0 20px rgba(245,158,11,0.15);
}
.char-status .sub-text {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.45);
    display: block;
    margin-top: 0.25rem;
    transition: all 0.3s ease;
}
.char-ambient-dots {
    position: absolute; inset: 0; pointer-events: none; overflow: hidden;
}
.char-ambient-dots .dot {
    position: absolute; border-radius: 50%;
    animation: charDotFloat 3s ease-in-out infinite;
}
.char-ambient-dots .dot:nth-child(1) { width: 8px; height: 8px; background: rgba(251,191,36,0.25); top: 15%; left: 10%; animation-delay: 0s; }
.char-ambient-dots .dot:nth-child(2) { width: 5px; height: 5px; background: rgba(16,185,129,0.2); top: 60%; left: 85%; animation-delay: 0.8s; }
.char-ambient-dots .dot:nth-child(3) { width: 6px; height: 6px; background: rgba(239,68,68,0.18); top: 80%; left: 20%; animation-delay: 1.6s; }
.char-ambient-dots .dot:nth-child(4) { width: 4px; height: 4px; background: rgba(96,165,250,0.18); top: 25%; left: 75%; animation-delay: 2.4s; }
@keyframes charDotFloat { 0%,100% { transform: translateY(0) scale(1); opacity: 0.4; } 50% { transform: translateY(-12px) scale(1.3); opacity: 0.8; } }


/* ═══════════════════════════════════════════
   FORM CARD
   ═══════════════════════════════════════════ */
.register-card {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(40px) saturate(1.5);
    -webkit-backdrop-filter: blur(40px) saturate(1.5);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.06);
    padding: 2.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.06);
    position: relative;
    overflow: hidden;
    animation: cardFadeUp 0.6s ease-out;
}
.register-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: 24px; padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(245,158,11,0.15), rgba(239,68,68,0.15), rgba(16,185,129,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: cardBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes cardBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
@keyframes cardFadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }

.register-card::after {
    content: '';
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(251,191,36,0.03) 0%, transparent 50%);
    animation: cardShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes cardShine {
    0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; }
    25%  { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; }
    50%  { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; }
    75%  { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; }
}
@media (max-width: 640px) {
    .register-page { padding: 1rem 0.75rem; }
    .register-grid { gap: 0; }
    .register-card {
        padding: 1.25rem;
        border-radius: 20px;
    }
    .register-card .rc-header { margin-bottom: 1.25rem; }
    .register-card .rc-header .rc-icon { width: 2.5rem; height: 2.5rem; }
    .register-card .rc-header h2 { font-size: 1.125rem; }
    .register-card .rc-header p { font-size: 0.75rem; }
    .field { margin-bottom: 0.875rem; }
    .field input { padding: 0.625rem 0.75rem 0.625rem 2.25rem; font-size: 0.8125rem; }
    .btn-auth { padding: 0.6875rem; font-size: 0.875rem; }
    .pass-hint { font-size: 0.6875rem; }
    .auth-divider { margin-top: 1.125rem; padding-top: 1.125rem; }
    .auth-divider p { font-size: 0.75rem; }
}

/* ── Card Header ── */
.register-card .rc-header {
    text-align: center;
    margin-bottom: 1.75rem;
    position: relative;
}
.register-card .rc-header .rc-icon {
    width: 3rem; height: 3rem;
    margin: 0 auto 0.75rem;
    background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(239,68,68,0.06));
    border: 1px solid rgba(251,191,36,0.08);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    color: #F59E0B;
}
.register-card .rc-header h2 { font-size: 1.375rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.register-card .rc-header p { font-size: 0.8125rem; color: rgba(255,255,255,0.35); }

/* ── Alerts ── */
.alert-box {
    display: flex; align-items: flex-start; gap: 0.5rem;
    padding: 0.75rem 1rem; border-radius: 12px;
    font-size: 0.8125rem; margin-bottom: 1rem;
}
.alert-error {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.15);
    color: #F87171;
    animation: alertShake 0.5s ease-in-out;
}
@keyframes alertShake {
    0%,100% { transform: translateX(0); }
    10%,50%,90% { transform: translateX(-6px); }
    30%,70% { transform: translateX(6px); }
}
.alert-error ul { list-style: none; margin: 0; padding: 0; }
.alert-error ul li + li { margin-top: 0.125rem; }

/* ── Fields ── */
.field { margin-bottom: 1.25rem; }
.field label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 500;
    color: rgba(255,255,255,0.6);
    margin-bottom: 0.375rem;
    transition: color 0.3s;
}
.field.focused label { color: #F59E0B; }
.field .input-wrap {
    position: relative;
}
.field .input-wrap .input-icon {
    position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%);
    color: rgba(255,255,255,0.15);
    pointer-events: none;
    display: flex; align-items: center;
    transition: color 0.3s;
}
.field.focused .input-wrap .input-icon { color: #F59E0B; }
.field input {
    width: 100%;
    padding: 0.75rem 0.875rem 0.75rem 2.5rem;
    background: rgba(0,0,0,0.2);
    border: 1.5px solid rgba(255,255,255,0.06);
    border-radius: 12px;
    font-size: 0.875rem;
    outline: none;
    transition: all 0.3s;
    color: #fff;
    font-family: var(--font);
    box-sizing: border-box;
}
.field input::placeholder { color: rgba(255,255,255,0.15); }
.field input:focus {
    border-color: rgba(245,158,11,0.4);
    background: rgba(245,158,11,0.06);
    box-shadow: 0 0 0 3px rgba(245,158,11,0.08);
}
.field input.error {
    border-color: rgba(239,68,68,0.4);
    background: rgba(239,68,68,0.04);
    box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
}

/* ── Password Hint ── */
.pass-hint { font-size: 0.75rem; color: rgba(255,255,255,0.25); margin-top: 0.375rem; }

/* ── Button ── */
.btn-auth {
    width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    background: linear-gradient(135deg, #F59E0B, #EF4444);
    color: #fff; border: none;
    padding: 0.8125rem; border-radius: 12px;
    font-size: 0.9375rem; font-weight: 600;
    cursor: pointer; transition: all 0.3s;
    box-shadow: 0 4px 16px rgba(245,158,11,0.3);
    position: relative;
    overflow: hidden;
    font-family: var(--font);
}
.btn-auth::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, transparent 20%, rgba(255,255,255,0.1) 50%, transparent 80%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}
.btn-auth:hover::before { transform: translateX(100%); }
.btn-auth:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(245,158,11,0.4); }
.btn-auth:active { transform: translateY(0); }
.btn-auth:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

/* ── Divider ── */
.auth-divider {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
    text-align: center;
}
.auth-divider p { font-size: 0.8125rem; color: rgba(255,255,255,0.3); }
.auth-divider p a {
    color: rgba(251,191,36,0.7);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.auth-divider p a:hover { color: #F59E0B; }

/* ── Loading spinner ── */
.btn-auth .spinner {
    display: none;
    width: 18px; height: 18px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}
.btn-auth.loading .spinner { display: inline-block; }
.btn-auth.loading .btn-text { opacity: 0.6; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Responsive ── */
</style>
@endpush

@section('content')
<div class="register-page" id="registerPage">
    <div class="register-grid">
        {{-- ═══ CHARACTER PANEL ═══ --}}
        <div class="char-panel" id="charPanel">
            <div class="char-ambient-dots">
                <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
            </div>
            <div class="char-container">
                {{-- Pure CSS Cartoon Character (Amber/Orange Theme) --}}
                <div class="cartoon-char idle" id="cartoonChar">
                    {{-- Shadow --}}
                    <div class="char-shadow"></div>

                    {{-- Feet --}}
                    <div class="char-feet">
                        <div class="char-foot"></div>
                        <div class="char-foot"></div>
                    </div>

                    {{-- Body --}}
                    <div class="char-body" id="charBody">
                        <div class="char-belly"></div>
                        <div class="char-collar"></div>
                        <div class="char-hood">
                            <div class="char-hood-string"></div>
                            <div class="char-hood-string right"></div>
                        </div>
                    </div>

                    {{-- Arms --}}
                    <div class="char-arm left" id="charArmLeft"></div>
                    <div class="char-arm right" id="charArmRight"></div>

                    {{-- Head --}}
                    <div class="char-head-group" id="charHeadGroup">
                        <div class="char-head">
                            <div class="char-ear left"></div>
                            <div class="char-ear right"></div>

                            <div class="char-brow left" id="charBrowLeft"></div>
                            <div class="char-brow right" id="charBrowRight"></div>

                            <div class="char-blush left"></div>
                            <div class="char-blush right"></div>

                            <div class="char-eyes-wrap" id="charEyesWrap">
                                <div class="char-eye">
                                    <div class="char-pupil"></div>
                                    <div class="char-eye-shine"></div>
                                    <div class="char-blink"></div>
                                </div>
                                <div class="char-eye">
                                    <div class="char-pupil"></div>
                                    <div class="char-eye-shine"></div>
                                    <div class="char-blink"></div>
                                </div>
                            </div>

                            <div class="char-mouth happy" id="charMouth"></div>
                            <div class="char-sweat" id="charSweat"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status text below character --}}
            <div class="char-status" id="charStatus">
                <span class="greeting" id="charGreeting">Hey there! 👋</span>
                <span class="sub-text" id="charSubtext">Let's get you started</span>
            </div>
        </div>

        {{-- ═══ REGISTER FORM ═══ --}}
        <div class="register-card" id="registerCard">
            <div class="rc-header">
                <div class="rc-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <polyline points="17 11 19 13 23 9"/>
                    </svg>
                </div>
                <h2>Create Account</h2>
                <p>Fill in the details to join us</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="alert-box alert-error" id="errorAlert">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="field" id="nameField">
                    <label for="name">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
                    </div>
                </div>

                <div class="field" id="emailField">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
                    </div>
                </div>

                <div class="field" id="passwordField">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                    </div>
                    <p class="pass-hint">Must be at least 8 characters</p>
                </div>

                <div class="field" id="passwordConfirmField">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/><polyline points="9 14 11 16 15 12"/></svg>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-auth" id="registerBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="vertical-align:middle;margin-right:4px;"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                        Create Account
                    </span>
                </button>
            </form>

            <div class="auth-divider">
                <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>
    </div>
</div>

{{-- ═══ JAVASCRIPT ═══ --}}
<script>
(function() {
    'use strict';

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const nameField = document.getElementById('nameField');
    const emailField = document.getElementById('emailField');
    const passwordField = document.getElementById('passwordField');
    const passwordConfirmField = document.getElementById('passwordConfirmField');
    const headGroup = document.getElementById('charHeadGroup');
    const eyesWrap = document.getElementById('charEyesWrap');
    const mouth = document.getElementById('charMouth');
    const armRight = document.getElementById('charArmRight');
    const armLeft = document.getElementById('charArmLeft');
    const cartoonChar = document.getElementById('cartoonChar');
    const charGreeting = document.getElementById('charGreeting');
    const charSubtext = document.getElementById('charSubtext');
    const registerBtn = document.getElementById('registerBtn');
    const registerForm = document.getElementById('registerForm');
    const errorAlert = document.getElementById('errorAlert');
    const pupils = document.querySelectorAll('.char-pupil');
    const browLeft = document.getElementById('charBrowLeft');
    const browRight = document.getElementById('charBrowRight');
    const sweat = document.getElementById('charSweat');
    const blushL = document.querySelector('.char-blush.left');
    const blushR = document.querySelector('.char-blush.right');

    const BROW_CLASSES = ['raised', 'lowered', 'confused'];

    // ── Helper: reset all expression classes ──
    function resetChar() {
        headGroup.classList.remove('look-name', 'look-email', 'look-password', 'shake', 'excited-bounce', 'tilt-thinking', 'tilt-idle');
        eyesWrap.classList.remove('look-name', 'look-email', 'look-password', 'excited', 'squint', 'thinking');
        armRight.classList.remove('point-name', 'point-email', 'point-password', 'excited');
        armLeft.classList.remove('point-name', 'point-email', 'point-password');
        cartoonChar.classList.remove('excited-bounce');
        cartoonChar.classList.add('idle');
        mouth.className = 'char-mouth';
        browLeft?.classList.remove(...BROW_CLASSES);
        browRight?.classList.remove(...BROW_CLASSES);
        blushL?.classList.remove('excited', 'nervous');
        blushR?.classList.remove('excited', 'nervous');
        sweat?.classList.remove('show');
        pupils.forEach(p => { p.style.transform = 'translateX(-50%)'; });
    }

    // ── Apply a full emotional state ──
    function setEmotion(state) {
        resetChar();
        switch (state) {
            case 'excited-name':
                headGroup.classList.add('look-name', 'excited-bounce');
                eyesWrap.classList.add('look-name', 'excited');
                armRight.classList.add('point-name', 'excited');
                armLeft.classList.add('point-name');
                browLeft?.classList.add('raised');
                browRight?.classList.add('raised');
                blushL?.classList.add('excited');
                blushR?.classList.add('excited');
                mouth.className = 'char-mouth open';
                pupils.forEach(p => { p.style.transform = 'translateX(-30%) translateX(2px)'; });
                charGreeting.textContent = 'Nice name! ✨';
                charSubtext.textContent = 'Who should I welcome?';
                break;

            case 'excited-email':
                headGroup.classList.add('look-email', 'excited-bounce');
                eyesWrap.classList.add('look-email', 'excited');
                armRight.classList.add('point-email', 'excited');
                armLeft.classList.add('point-email');
                browLeft?.classList.add('raised');
                browRight?.classList.add('raised');
                blushL?.classList.add('excited');
                blushR?.classList.add('excited');
                mouth.className = 'char-mouth open';
                pupils.forEach(p => { p.style.transform = 'translateX(-30%) translateX(3px)'; });
                charGreeting.textContent = 'Ooh, an email! 📧';
                charSubtext.textContent = 'I love making new friends!';
                break;

            case 'nervous':
                headGroup.classList.add('look-password');
                eyesWrap.classList.add('look-password', 'squint');
                armRight.classList.add('point-password');
                armLeft.classList.add('point-password');
                blushL?.classList.add('nervous');
                blushR?.classList.add('nervous');
                sweat?.classList.add('show');
                mouth.className = 'char-mouth nervous';
                pupils.forEach(p => { p.style.transform = 'translateX(-70%) translateX(-1px) translateY(1px)'; });
                charGreeting.textContent = 'Password time 🙈';
                charSubtext.textContent = 'I promise not to peek!';
                break;

            case 'thinking':
                headGroup.classList.add('tilt-thinking');
                eyesWrap.classList.add('thinking');
                browLeft?.classList.add('confused');
                browRight?.classList.add('confused');
                mouth.className = 'char-mouth woah';
                pupils.forEach(p => { p.style.transform = 'translateX(-50%) translateY(-4px)'; });
                charGreeting.textContent = 'Hmm, let me check... 🤔';
                charSubtext.textContent = 'Setting things up for you';
                break;

            case 'upset':
                headGroup.classList.add('shake');
                eyesWrap.classList.add('squint');
                browLeft?.classList.add('lowered');
                browRight?.classList.add('lowered');
                mouth.className = 'char-mouth sad';
                charGreeting.textContent = 'Oops, something\'s off! 😰';
                charSubtext.textContent = 'Double-check your details';
                break;

            case 'idle':
            default:
                headGroup.classList.add('tilt-idle');
                mouth.className = 'char-mouth big-smile';
                charGreeting.textContent = 'Hey there! 👋';
                charSubtext.textContent = 'Let\'s get you started';
                break;
        }
    }

    function lookAt(field) {
        if (field === 'name') {
            setEmotion('excited-name');
        } else if (field === 'email') {
            setEmotion('excited-email');
        } else if (field === 'password' || field === 'password_confirm') {
            setEmotion('nervous');
        }
    }

    function lookIdle() {
        setEmotion('idle');
    }

    function shakeHead() {
        setEmotion('upset');
        setTimeout(function() {
            headGroup.classList.remove('shake');
        }, 600);
    }

    function setLoading(loading) {
        registerBtn.classList.toggle('loading', loading);
        registerBtn.disabled = loading;
    }

    // ── Focus Events ──
    if (nameInput) {
        nameInput.addEventListener('focus', function() {
            nameField.classList.add('focused');
            emailField.classList.remove('focused');
            passwordField.classList.remove('focused');
            passwordConfirmField.classList.remove('focused');
            lookAt('name');
        });
        nameInput.addEventListener('blur', function() {
            nameField.classList.remove('focused');
            if (!nameInput.value && !emailInput?.value && !passwordInput?.value) lookIdle();
        });
    }
    if (emailInput) {
        emailInput.addEventListener('focus', function() {
            emailField.classList.add('focused');
            nameField.classList.remove('focused');
            passwordField.classList.remove('focused');
            passwordConfirmField.classList.remove('focused');
            lookAt('email');
        });
        emailInput.addEventListener('blur', function() {
            emailField.classList.remove('focused');
            if (!nameInput?.value && !emailInput.value && !passwordInput?.value) lookIdle();
        });
    }
    if (passwordInput) {
        passwordInput.addEventListener('focus', function() {
            passwordField.classList.add('focused');
            nameField.classList.remove('focused');
            emailField.classList.remove('focused');
            passwordConfirmField.classList.remove('focused');
            lookAt('password');
        });
        passwordInput.addEventListener('blur', function() {
            passwordField.classList.remove('focused');
            if (!nameInput?.value && !emailInput?.value && !passwordInput.value && !passwordConfirmInput?.value) lookIdle();
        });
    }
    if (passwordConfirmInput) {
        passwordConfirmInput.addEventListener('focus', function() {
            passwordConfirmField.classList.add('focused');
            nameField.classList.remove('focused');
            emailField.classList.remove('focused');
            passwordField.classList.remove('focused');
            lookAt('password_confirm');
        });
        passwordConfirmInput.addEventListener('blur', function() {
            passwordConfirmField.classList.remove('focused');
            if (!nameInput?.value && !emailInput?.value && !passwordInput?.value && !passwordConfirmInput.value) lookIdle();
        });
    }

    // ── Input Events ──
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            if (document.activeElement === nameInput) lookAt('name');
        });
    }
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            if (document.activeElement === emailInput) lookAt('email');
        });
    }
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            if (document.activeElement === passwordInput) lookAt('password');
        });
    }
    if (passwordConfirmInput) {
        passwordConfirmInput.addEventListener('input', function() {
            if (document.activeElement === passwordConfirmInput) lookAt('password_confirm');
        });
    }

    // ── Form Submit ──
    if (registerForm) {
        registerForm.addEventListener('submit', function() {
            setLoading(true);
            setEmotion('thinking');
        });
    }

    // ── Validation Errors ──
    if (errorAlert) {
        setEmotion('thinking');
        setTimeout(shakeHead, 400);
        @if($errors->has('name'))
            if (nameField) nameField.querySelector('input')?.classList.add('error');
        @endif
        @if($errors->has('email'))
            if (emailField) emailField.querySelector('input')?.classList.add('error');
        @endif
        @if($errors->has('password'))
            if (passwordField) passwordField.querySelector('input')?.classList.add('error');
        @endif
    }

    setLoading(false);
    setTimeout(lookIdle, 100);
})();
</script>
@endsection
