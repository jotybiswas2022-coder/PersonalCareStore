@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

@push('styles')
<style>
.forgot-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0B1121 0%, #0F172A 40%, #1E1B3A 100%);
    position: relative;
    overflow: hidden;
    padding: 2rem 1rem;
}
.forgot-page::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 30%, rgba(139,92,246,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 70%, rgba(99,102,241,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.forgot-grid {
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
    .forgot-grid { grid-template-columns: 1fr; max-width: 460px; gap: 1.5rem; }
    .char-panel { display: none; }
}

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
    background: linear-gradient(135deg, rgba(167,139,250,0.2), rgba(139,92,246,0.25), rgba(99,102,241,0.2), rgba(129,140,248,0.15), rgba(167,139,250,0.2));
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

.char-container {
    width: 220px;
    height: 220px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
@media (max-width: 900px) { .char-container { width: 180px; height: 180px; } }
@media (max-width: 480px) { .char-container { width: 160px; height: 160px; } }

.cartoon-char {
    position: relative;
    width: 160px;
    height: 168px;
}
@media (max-width: 900px) { .cartoon-char { width: 130px; height: 136px; } }

.cartoon-char.idle {
    animation: charFloat 2.8s ease-in-out infinite;
}
@keyframes charFloat {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

.char-head-group {
    position: absolute;
    top: 0; left: 50%;
    transform: translateX(-50%);
    transform-origin: center 40px;
    transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1);
    z-index: 2;
}
.char-head-group.look-email {
    transform: translateX(-50%) rotate(16deg) translateX(5px);
}
.char-head-group.shake {
    animation: headShakeCSS 0.6s ease-in-out;
}
@keyframes headShakeCSS {
    0%,100% { transform: translateX(-50%) rotate(0deg); }
    10%,50%,90% { transform: translateX(-50%) rotate(-18deg); }
    30%,70% { transform: translateX(-50%) rotate(18deg); }
}

.char-head {
    width: 68px;
    height: 68px;
    background: linear-gradient(135deg, #C4B5FD, #8B5CF6);
    border-radius: 50%;
    position: relative;
    border: 2px solid rgba(167,139,250,0.25);
    box-shadow: 0 4px 20px rgba(139,92,246,0.15);
}
@media (max-width: 900px) { .char-head { width: 55px; height: 55px; } }

.char-ear {
    position: absolute;
    top: 18px;
    width: 16px; height: 16px;
    background: rgba(167,139,250,0.15);
    border-radius: 50%;
    border: 1.5px solid rgba(167,139,250,0.15);
}
.char-ear.left { left: -9px; }
.char-ear.right { right: -9px; }
.char-ear::after {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 7px; height: 7px;
    background: rgba(129,140,248,0.1);
    border-radius: 50%;
}
@media (max-width: 900px) {
    .char-ear { width: 13px; height: 13px; top: 14px; }
    .char-ear.left { left: -7px; }
    .char-ear.right { right: -7px; }
    .char-ear::after { width: 5px; height: 5px; }
}

.char-eyes-wrap {
    position: absolute;
    top: 22px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 14px;
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.char-eyes-wrap.look-email {
    transform: translateX(-40%) translateX(3px);
}
@media (max-width: 900px) { .char-eyes-wrap { top: 18px; gap: 11px; } }

.char-eye {
    width: 18px;
    height: 20px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    position: relative;
    border: 1.5px solid rgba(167,139,250,0.12);
    overflow: hidden;
}
@media (max-width: 900px) { .char-eye { width: 14px; height: 16px; } }

.char-pupil {
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px; height: 8px;
    background: rgba(91,33,182,0.5);
    border-radius: 50%;
    transition: all 0.3s ease;
}
.char-eyes-wrap.look-email .char-pupil {
    transform: translateX(-30%) translateX(2px);
}
@media (max-width: 900px) { .char-pupil { width: 6px; height: 6px; bottom: 3px; } }

.char-eye-shine {
    position: absolute;
    top: 3px; right: 3px;
    width: 5px; height: 5px;
    background: rgba(255,255,255,0.35);
    border-radius: 50%;
    animation: sparklePulse 2s ease-in-out infinite;
}
@media (max-width: 900px) { .char-eye-shine { width: 4px; height: 4px; } }

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

.char-blush {
    position: absolute;
    top: 38px;
    width: 14px; height: 7px;
    background: rgba(129,140,248,0.1);
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

.char-brow {
    position: absolute;
    top: 16px;
    width: 16px; height: 2px;
    background: rgba(91,33,182,0.15);
    border-radius: 2px;
}
.char-brow.left { left: 12px; transform: rotate(-8deg); }
.char-brow.right { right: 12px; transform: rotate(8deg); }
@media (max-width: 900px) { .char-brow { width: 13px; top: 13px; } .char-brow.left { left: 10px; } .char-brow.right { right: 10px; } }

.char-mouth {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    width: 12px; height: 2px;
    background: rgba(91,33,182,0.2);
    border-radius: 2px;
    transition: all 0.3s ease;
}
.char-mouth.happy {
    width: 16px;
    height: 7px;
    background: transparent;
    border-bottom: 2px solid rgba(91,33,182,0.2);
    border-radius: 0 0 50% 50%;
    bottom: 10px;
}
.char-mouth.sad {
    width: 14px;
    background: transparent;
    border-top: 2px solid rgba(91,33,182,0.2);
    border-radius: 50% 50% 0 0;
    bottom: 14px;
}
.char-mouth.open {
    width: 18px;
    height: 12px;
    background: rgba(30,58,95,0.3);
    border: none;
    border-radius: 50%;
    bottom: 8px;
}
.char-mouth.big-smile {
    width: 20px;
    height: 8px;
    background: transparent;
    border-bottom: 2.5px solid rgba(91,33,182,0.3);
    border-radius: 0 0 50% 50%;
    bottom: 9px;
}
.char-mouth.nervous {
    width: 14px;
    height: 5px;
    background: transparent;
    border-bottom: 2px solid rgba(91,33,182,0.15);
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
    .char-mouth { width: 10px; bottom: 9px; }
    .char-mouth.happy { width: 13px; height: 5px; bottom: 7px; }
    .char-mouth.sad { width: 11px; bottom: 11px; }
    .char-mouth.open { width: 14px; height: 9px; bottom: 6px; }
    .char-mouth.big-smile { width: 16px; height: 6px; bottom: 7px; }
    .char-mouth.nervous { width: 11px; height: 4px; bottom: 8px; }
}

.char-body {
    position: absolute;
    top: 74px;
    left: 50%;
    transform: translateX(-50%);
    width: 56px; height: 52px;
    background: linear-gradient(180deg, #8B5CF6, #6D28D9);
    border-radius: 20px 20px 14px 14px;
    border: 2px solid rgba(167,139,250,0.25);
    z-index: 1;
}
@media (max-width: 900px) { .char-body { width: 44px; height: 42px; top: 60px; border-radius: 16px 16px 10px 10px; } }

.char-belly {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px; height: 14px;
    background: radial-gradient(ellipse, rgba(167,139,250,0.3), rgba(139,92,246,0.08));
    border-radius: 50%;
    border: 1px solid rgba(167,139,250,0.08);
}
@media (max-width: 900px) { .char-belly { width: 16px; height: 11px; bottom: 7px; } }

.char-collar {
    position: absolute;
    top: -1px;
    left: 50%;
    transform: translateX(-50%);
    width: 22px;
    height: 8px;
    border-bottom: 2px solid rgba(167,139,250,0.15);
    border-radius: 0 0 50% 50%;
}

.char-scarf {
    position: absolute;
    top: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 58px;
    height: 16px;
    background: linear-gradient(180deg, #7C3AED, #6D28D9);
    border-radius: 8px 8px 4px 4px;
    border: 1.5px solid rgba(167,139,250,0.2);
    z-index: 3;
}
.char-scarf-tail {
    position: absolute;
    top: 14px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px; height: 18px;
    background: rgba(124,58,237,0.4);
    border-radius: 2px;
    animation: scarfTailSwing 2.5s ease-in-out infinite;
    transform-origin: top center;
}
.char-scarf-tail.left {
    left: 20px;
    transform: rotate(-10deg);
    animation-delay: 0s;
}
.char-scarf-tail.right {
    left: auto;
    right: 20px;
    transform: rotate(10deg);
    animation-delay: 0.5s;
}
@keyframes scarfTailSwing {
    0%,100% { transform: rotate(-10deg); }
    50% { transform: rotate(-25deg); }
}
.char-scarf-tail.right {
    animation-name: scarfTailSwingRight;
}
@keyframes scarfTailSwingRight {
    0%,100% { transform: rotate(10deg); }
    50% { transform: rotate(25deg); }
}
@media (max-width: 900px) {
    .char-scarf { width: 46px; height: 13px; top: -6px; }
    .char-scarf-tail { height: 14px; }
    .char-scarf-tail.left { left: 16px; }
    .char-scarf-tail.right { left: auto; right: 16px; }
}

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
    background: rgba(91,33,182,0.2);
    border-radius: 50%;
}
@media (max-width: 900px) { .char-feet { top: 107px; gap: 12px; } .char-foot { width: 13px; height: 6px; } }

.char-arm {
    position: absolute;
    top: 76px;
    width: 10px; height: 30px;
    background: rgba(139,92,246,0.25);
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
    background: rgba(139,92,246,0.2);
    border-radius: 50%;
    border: 1px solid rgba(167,139,250,0.12);
}
.char-arm.left { left: 38px; transform: rotate(8deg); }
.char-arm.right { right: 38px; transform: rotate(-8deg); }
.cartoon-char.idle .char-arm.right {
    animation: armWave 2.5s ease-in-out infinite;
}
@keyframes armWave {
    0%,100% { transform: rotate(-8deg); }
    25% { transform: rotate(-18deg); }
    75% { transform: rotate(2deg); }
}
.char-arm.right.point-email { transform: rotate(40deg) translateX(5px); }
.char-arm.left.point-email { transform: rotate(-25deg) translateX(-3px); }
@media (max-width: 900px) {
    .char-arm { width: 8px; height: 24px; top: 62px; }
    .char-arm.left { left: 30px; }
    .char-arm.right { right: 30px; }
    .char-arm::after { width: 6px; height: 6px; bottom: -2px; }
}

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
@media (max-width: 900px) { .char-shadow { width: 60px; height: 7px; } }

.char-brow.raised.left { transform: rotate(-16deg) translateY(-4px); transition: all 0.3s ease; }
.char-brow.raised.right { transform: rotate(16deg) translateY(-4px); transition: all 0.3s ease; }
.char-brow.lowered.left { transform: rotate(10deg) translateY(2px); transition: all 0.3s ease; }
.char-brow.lowered.right { transform: rotate(-10deg) translateY(2px); transition: all 0.3s ease; }
.char-brow.confused.left { transform: rotate(-16deg) translateY(-4px); transition: all 0.3s ease; }
.char-brow.confused.right { transform: rotate(6deg) translateY(1px); transition: all 0.3s ease; }

.char-eyes-wrap.excited .char-eye { transform: scaleY(1.2); animation: eyeSpark 1.5s ease-in-out infinite; }
.char-eyes-wrap.excited .char-eye-shine { width: 7px; height: 7px; background: rgba(255,255,255,0.6); animation: sparklePulse 0.8s ease-in-out infinite; }
@keyframes eyeSpark { 0%,100% { transform: scaleY(1.2); } 50% { transform: scaleY(1.25) scaleX(1.05); } }
@keyframes sparklePulse { 0%,100% { transform: scale(1); opacity: 0.6; } 50% { transform: scale(1.3); opacity: 1; } }
.char-eyes-wrap.squint .char-eye { transform: scaleY(0.65); }
.char-eyes-wrap.squint .char-pupil { width: 6px; height: 6px; }

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
    text-shadow: 0 0 20px rgba(139,92,246,0.15);
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
.char-ambient-dots .dot:nth-child(1) { width: 8px; height: 8px; background: rgba(167,139,250,0.25); top: 15%; left: 10%; animation-delay: 0s; }
.char-ambient-dots .dot:nth-child(2) { width: 5px; height: 5px; background: rgba(129,140,248,0.2); top: 60%; left: 85%; animation-delay: 0.8s; }
.char-ambient-dots .dot:nth-child(3) { width: 6px; height: 6px; background: rgba(99,102,241,0.18); top: 80%; left: 20%; animation-delay: 1.6s; }
.char-ambient-dots .dot:nth-child(4) { width: 4px; height: 4px; background: rgba(192,132,252,0.18); top: 25%; left: 75%; animation-delay: 2.4s; }
@keyframes charDotFloat { 0%,100% { transform: translateY(0) scale(1); opacity: 0.4; } 50% { transform: translateY(-12px) scale(1.3); opacity: 0.8; } }

.forgot-card {
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
.forgot-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: 24px; padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(139,92,246,0.15), rgba(99,102,241,0.15), rgba(129,140,248,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: cardBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes cardBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
@keyframes cardFadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
.forgot-card::after {
    content: '';
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(139,92,246,0.03) 0%, transparent 50%);
    animation: cardShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes cardShine {
    0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; }
    25%  { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; }
    50%  { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; }
    75%  { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; }
}
@media (max-width: 640px) { .forgot-card { padding: 1.5rem; } }

.forgot-card .fc-header { text-align: center; margin-bottom: 1.75rem; position: relative; }
.forgot-card .fc-header .fc-icon {
    width: 3rem; height: 3rem;
    margin: 0 auto 0.75rem;
    background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(99,102,241,0.06));
    border: 1px solid rgba(167,139,250,0.08);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    color: #8B5CF6;
}
.forgot-card .fc-header h2 { font-size: 1.375rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.forgot-card .fc-header p { font-size: 0.8125rem; color: rgba(255,255,255,0.35); }

.alert-box {
    display: flex; align-items: flex-start; gap: 0.5rem;
    padding: 0.75rem 1rem; border-radius: 12px;
    font-size: 0.8125rem; margin-bottom: 1rem;
}
.alert-success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.15); color: #34D399; }
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

.field { margin-bottom: 1.25rem; }
.field label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 500;
    color: rgba(255,255,255,0.6);
    margin-bottom: 0.375rem;
    transition: color 0.3s;
}
.field.focused label { color: #8B5CF6; }
.field .input-wrap { position: relative; }
.field .input-wrap .input-icon {
    position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%);
    color: rgba(255,255,255,0.15);
    pointer-events: none;
    display: flex; align-items: center;
    transition: color 0.3s;
}
.field.focused .input-wrap .input-icon { color: #8B5CF6; }
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
    border-color: rgba(139,92,246,0.4);
    background: rgba(139,92,246,0.06);
    box-shadow: 0 0 0 3px rgba(139,92,246,0.08);
}
.field input.error {
    border-color: rgba(239,68,68,0.4);
    background: rgba(239,68,68,0.04);
    box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
}

.btn-auth {
    width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
    color: #fff; border: none;
    padding: 0.8125rem; border-radius: 12px;
    font-size: 0.9375rem; font-weight: 600;
    cursor: pointer; transition: all 0.3s;
    box-shadow: 0 4px 16px rgba(139,92,246,0.3);
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
.btn-auth:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(139,92,246,0.4); }
.btn-auth:active { transform: translateY(0); }
.btn-auth:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

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

.auth-divider {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
    text-align: center;
}
.auth-divider p { font-size: 0.8125rem; color: rgba(255,255,255,0.3); }
.auth-divider p a {
    color: rgba(167,139,250,0.7);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.auth-divider p a:hover { color: #8B5CF6; }

@media (max-width: 640px) { .forgot-page { padding: 1.5rem 1rem; } }
</style>
@endpush

@section('content')
<div class="forgot-page" id="forgotPage">
    <div class="forgot-grid">
        {{-- ═══ CHARACTER PANEL ═══ --}}
        <div class="char-panel" id="charPanel">
            <div class="char-ambient-dots">
                <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
            </div>
            <div class="char-container">
                <div class="cartoon-char idle" id="cartoonChar">
                    <div class="char-shadow"></div>
                    <div class="char-feet">
                        <div class="char-foot"></div>
                        <div class="char-foot"></div>
                    </div>
                    <div class="char-body" id="charBody">
                        <div class="char-belly"></div>
                        <div class="char-collar"></div>
                        <div class="char-scarf">
                            <div class="char-scarf-tail left"></div>
                            <div class="char-scarf-tail right"></div>
                        </div>
                    </div>
                    <div class="char-arm left" id="charArmLeft"></div>
                    <div class="char-arm right" id="charArmRight"></div>
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
            <div class="char-status" id="charStatus">
                <span class="greeting" id="charGreeting">Don't worry! 💜</span>
                <span class="sub-text" id="charSubtext">I'll help you reset it</span>
            </div>
        </div>

        {{-- ═══ FORGOT PASSWORD FORM ═══ --}}
        <div class="forgot-card" id="forgotCard">
            <div class="fc-header">
                <div class="fc-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                        <circle cx="12" cy="16" r="1"/>
                        <line x1="12" y1="13" x2="12" y2="14"/>
                    </svg>
                </div>
                <h2>Forgot Password?</h2>
                <p>Enter your email and we'll send a reset link</p>
            </div>

            @if(session('status'))
                <div class="alert-box alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('status') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                @csrf

                <div class="field" id="emailField">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
                    </div>
                </div>

                <button type="submit" class="btn-auth" id="forgotBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="vertical-align:middle;margin-right:4px;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Send Reset Link
                    </span>
                </button>
            </form>

            <div class="auth-divider">
                <p><a href="{{ route('login') }}">Back to Login</a></p>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    const emailInput = document.getElementById('email');
    const emailField = document.getElementById('emailField');
    const headGroup = document.getElementById('charHeadGroup');
    const eyesWrap = document.getElementById('charEyesWrap');
    const mouth = document.getElementById('charMouth');
    const armRight = document.getElementById('charArmRight');
    const armLeft = document.getElementById('charArmLeft');
    const cartoonChar = document.getElementById('cartoonChar');
    const charGreeting = document.getElementById('charGreeting');
    const charSubtext = document.getElementById('charSubtext');
    const forgotBtn = document.getElementById('forgotBtn');
    const forgotForm = document.getElementById('forgotForm');
    const errorAlert = document.getElementById('errorAlert');
    const pupils = document.querySelectorAll('.char-pupil');
    const browLeft = document.getElementById('charBrowLeft');
    const browRight = document.getElementById('charBrowRight');
    const blushL = document.querySelector('.char-blush.left');
    const blushR = document.querySelector('.char-blush.right');

    const BROW_CLASSES = ['raised', 'lowered', 'confused'];

    function resetChar() {
        headGroup.classList.remove('look-email', 'shake', 'tilt-thinking', 'tilt-idle');
        eyesWrap.classList.remove('look-email', 'excited', 'squint', 'thinking');
        armRight.classList.remove('point-email', 'excited');
        armLeft.classList.remove('point-email');
        cartoonChar.classList.remove('excited-bounce');
        cartoonChar.classList.add('idle');
        mouth.className = 'char-mouth';
        browLeft?.classList.remove(...BROW_CLASSES);
        browRight?.classList.remove(...BROW_CLASSES);
        blushL?.classList.remove('excited', 'nervous');
        blushR?.classList.remove('excited', 'nervous');
        pupils.forEach(p => { p.style.transform = 'translateX(-50%)'; });
    }

    function setEmotion(state) {
        resetChar();
        switch (state) {
            case 'excited':
                headGroup.classList.add('look-email');
                eyesWrap.classList.add('look-email', 'excited');
                armRight.classList.add('point-email', 'excited');
                armLeft.classList.add('point-email');
                browLeft?.classList.add('raised');
                browRight?.classList.add('raised');
                blushL?.classList.add('excited');
                blushR?.classList.add('excited');
                mouth.className = 'char-mouth open';
                pupils.forEach(p => { p.style.transform = 'translateX(-30%) translateX(2px)'; });
                charGreeting.textContent = 'Just type your email! 📧';
                charSubtext.textContent = 'I\'ll take care of the rest';
                break;

            case 'thinking':
                headGroup.classList.add('tilt-thinking');
                eyesWrap.classList.add('thinking');
                browLeft?.classList.add('confused');
                browRight?.classList.add('confused');
                mouth.className = 'char-mouth woah';
                pupils.forEach(p => { p.style.transform = 'translateX(-50%) translateY(-4px)'; });
                charGreeting.textContent = 'Sending it now... 🤔';
                charSubtext.textContent = 'Almost there!';
                break;

            case 'upset':
                headGroup.classList.add('shake');
                eyesWrap.classList.add('squint');
                browLeft?.classList.add('lowered');
                browRight?.classList.add('lowered');
                mouth.className = 'char-mouth sad';
                charGreeting.textContent = 'Hmm, that didn\'t work 😰';
                charSubtext.textContent = 'Double-check your email address';
                break;

            case 'idle':
            default:
                headGroup.classList.add('tilt-idle');
                mouth.className = 'char-mouth big-smile';
                charGreeting.textContent = 'Don\'t worry! 💜';
                charSubtext.textContent = 'I\'ll help you reset it';
                break;
        }
    }

    function lookAt(field) {
        if (field === 'email') setEmotion('excited');
    }

    function lookIdle() { setEmotion('idle'); }
    function shakeHead() { setEmotion('upset'); setTimeout(function() { headGroup.classList.remove('shake'); }, 600); }
    function setLoading(loading) { forgotBtn.classList.toggle('loading', loading); forgotBtn.disabled = loading; }

    if (emailInput) {
        emailInput.addEventListener('focus', function() { emailField.classList.add('focused'); lookAt('email'); });
        emailInput.addEventListener('blur', function() { emailField.classList.remove('focused'); if (!emailInput.value) lookIdle(); });
        emailInput.addEventListener('input', function() { if (document.activeElement === emailInput) lookAt('email'); });
    }
    if (forgotForm) {
        forgotForm.addEventListener('submit', function() { setLoading(true); setEmotion('thinking'); });
    }
    if (errorAlert) {
        setEmotion('thinking');
        setTimeout(shakeHead, 400);
    }
    setLoading(false);
    setTimeout(lookIdle, 100);
})();
</script>
@endsection
