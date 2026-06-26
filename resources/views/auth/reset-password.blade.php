@extends('frontend.layouts.app')

@section('title', 'Reset Password')

@push('styles')
<style>
.reset-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0B1121 0%, #0F172A 40%, #0F2D2A 100%);
    position: relative;
    overflow: hidden;
    padding: 2rem 1rem;
}
.reset-page::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 30%, rgba(45,212,191,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 70%, rgba(20,184,166,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.reset-grid {
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
    .reset-grid { grid-template-columns: 1fr; max-width: 460px; gap: 1.5rem; }
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
    background: linear-gradient(135deg, rgba(45,212,191,0.2), rgba(20,184,166,0.25), rgba(13,148,136,0.2), rgba(94,234,212,0.15), rgba(45,212,191,0.2));
    background-size: 400% 400%;
    animation: charBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes charBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
@media (max-width: 900px) { .char-panel { min-height: 260px; padding: 1.5rem; } }

.char-container { width: 220px; height: 220px; position: relative; display: flex; align-items: center; justify-content: center; }
@media (max-width: 900px) { .char-container { width: 180px; height: 180px; } }
@media (max-width: 480px) { .char-container { width: 160px; height: 160px; } }

.cartoon-char { position: relative; width: 160px; height: 168px; }
@media (max-width: 900px) { .cartoon-char { width: 130px; height: 136px; } }

.cartoon-char.idle { animation: charFloat 2.8s ease-in-out infinite; }
@keyframes charFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }

.char-head-group {
    position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    transform-origin: center 40px; transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1); z-index: 2;
}
.char-head-group.look-email { transform: translateX(-50%) rotate(12deg) translateX(4px); }
.char-head-group.look-password { transform: translateX(-50%) rotate(-14deg) translateX(-3px); }
.char-head-group.shake { animation: headShakeCSS 0.6s ease-in-out; }
@keyframes headShakeCSS { 0%,100% { transform: translateX(-50%) rotate(0deg); } 10%,50%,90% { transform: translateX(-50%) rotate(-18deg); } 30%,70% { transform: translateX(-50%) rotate(18deg); } }

.char-head { width: 68px; height: 68px; background: linear-gradient(135deg, #5EEAD4, #14B8A6); border-radius: 50%; position: relative; border: 2px solid rgba(45,212,191,0.25); box-shadow: 0 4px 20px rgba(20,184,166,0.15); }
@media (max-width: 900px) { .char-head { width: 55px; height: 55px; } }

.char-ear { position: absolute; top: 18px; width: 16px; height: 16px; background: rgba(45,212,191,0.15); border-radius: 50%; border: 1.5px solid rgba(45,212,191,0.15); }
.char-ear.left { left: -9px; } .char-ear.right { right: -9px; }
.char-ear::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 7px; height: 7px; background: rgba(94,234,212,0.1); border-radius: 50%; }
@media (max-width: 900px) { .char-ear { width: 13px; height: 13px; top: 14px; } .char-ear.left { left: -7px; } .char-ear.right { right: -7px; } .char-ear::after { width: 5px; height: 5px; } }

.char-eyes-wrap { position: absolute; top: 22px; left: 50%; transform: translateX(-50%); display: flex; gap: 14px; transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1); }
.char-eyes-wrap.look-email { transform: translateX(-40%) translateX(3px); }
.char-eyes-wrap.look-password { transform: translateX(-60%) translateX(-2px) translateY(2px); }
@media (max-width: 900px) { .char-eyes-wrap { top: 18px; gap: 11px; } }

.char-eye { width: 18px; height: 20px; background: rgba(255,255,255,0.15); border-radius: 50%; position: relative; border: 1.5px solid rgba(45,212,191,0.12); overflow: hidden; }
@media (max-width: 900px) { .char-eye { width: 14px; height: 16px; } }

.char-pupil { position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: rgba(15,118,110,0.5); border-radius: 50%; transition: all 0.3s ease; }
.char-eyes-wrap.look-email .char-pupil { transform: translateX(-30%) translateX(2px); }
.char-eyes-wrap.look-password .char-pupil { transform: translateX(-70%) translateX(-1px) translateY(1px); }
@media (max-width: 900px) { .char-pupil { width: 6px; height: 6px; bottom: 3px; } }

.char-eye-shine { position: absolute; top: 3px; right: 3px; width: 5px; height: 5px; background: rgba(255,255,255,0.35); border-radius: 50%; animation: sparklePulse 2s ease-in-out infinite; }
@media (max-width: 900px) { .char-eye-shine { width: 4px; height: 4px; } }

.char-blink { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.9); border-radius: 50%; clip-path: inset(0 0 50% 0); animation: blink 3.5s ease-in-out infinite; pointer-events: none; }
@keyframes blink { 0%,96%,100% { opacity: 0; } 97% { opacity: 1; } }

.char-blush { position: absolute; top: 38px; width: 14px; height: 7px; background: rgba(94,234,212,0.1); border-radius: 50%; animation: blushPulse 2.5s ease-in-out infinite; }
.char-blush.left { left: 6px; } .char-blush.right { right: 6px; }
@keyframes blushPulse { 0%,100% { opacity: 0.2; } 50% { opacity: 0.4; } }
@media (max-width: 900px) { .char-blush { width: 11px; height: 6px; top: 30px; } .char-blush.left { left: 5px; } .char-blush.right { right: 5px; } }

.char-brow { position: absolute; top: 16px; width: 16px; height: 2px; background: rgba(15,118,110,0.15); border-radius: 2px; }
.char-brow.left { left: 12px; transform: rotate(-8deg); } .char-brow.right { right: 12px; transform: rotate(8deg); }
@media (max-width: 900px) { .char-brow { width: 13px; top: 13px; } .char-brow.left { left: 10px; } .char-brow.right { right: 10px; } }

.char-mouth { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); width: 12px; height: 2px; background: rgba(15,118,110,0.2); border-radius: 2px; transition: all 0.3s ease; }
.char-mouth.happy { width: 16px; height: 7px; background: transparent; border-bottom: 2px solid rgba(15,118,110,0.2); border-radius: 0 0 50% 50%; bottom: 10px; }
.char-mouth.sad { width: 14px; background: transparent; border-top: 2px solid rgba(15,118,110,0.2); border-radius: 50% 50% 0 0; bottom: 14px; }
.char-mouth.open { width: 18px; height: 12px; background: rgba(30,58,95,0.3); border: none; border-radius: 50%; bottom: 8px; }
.char-mouth.big-smile { width: 20px; height: 8px; background: transparent; border-bottom: 2.5px solid rgba(15,118,110,0.3); border-radius: 0 0 50% 50%; bottom: 9px; }
.char-mouth.woah { width: 10px; height: 10px; background: rgba(30,58,95,0.25); border: none; border-radius: 50%; bottom: 10px; }
@media (max-width: 900px) { .char-mouth { width: 10px; bottom: 9px; } .char-mouth.happy { width: 13px; height: 5px; bottom: 7px; } .char-mouth.sad { width: 11px; bottom: 11px; } .char-mouth.open { width: 14px; height: 9px; bottom: 6px; } .char-mouth.big-smile { width: 16px; height: 6px; bottom: 7px; } .char-mouth.woah { width: 8px; height: 8px; bottom: 8px; } }

.char-body { position: absolute; top: 74px; left: 50%; transform: translateX(-50%); width: 56px; height: 52px; background: linear-gradient(180deg, #14B8A6, #0D9488); border-radius: 20px 20px 14px 14px; border: 2px solid rgba(45,212,191,0.25); z-index: 1; }
@media (max-width: 900px) { .char-body { width: 44px; height: 42px; top: 60px; border-radius: 16px 16px 10px 10px; } }

.char-belly { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); width: 20px; height: 14px; background: radial-gradient(ellipse, rgba(45,212,191,0.3), rgba(20,184,166,0.08)); border-radius: 50%; border: 1px solid rgba(45,212,191,0.08); }
@media (max-width: 900px) { .char-belly { width: 16px; height: 11px; bottom: 7px; } }

.char-collar { position: absolute; top: -1px; left: 50%; transform: translateX(-50%); width: 22px; height: 8px; border-bottom: 2px solid rgba(45,212,191,0.15); border-radius: 0 0 50% 50%; }

.char-headband {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 14px;
    background: linear-gradient(180deg, #0D9488, #0F766E);
    border-radius: 7px;
    border: 1.5px solid rgba(45,212,191,0.2);
    z-index: 3;
}
.char-headband-knot {
    position: absolute;
    top: -5px;
    right: -6px;
    width: 8px; height: 8px;
    background: rgba(13,148,136,0.4);
    border-radius: 50%;
    animation: knotBounce 2s ease-in-out infinite;
}
@keyframes knotBounce { 0%,100% { transform: scale(1); } 50% { transform: scale(1.3); } }
@media (max-width: 900px) { .char-headband { width: 48px; height: 11px; top: -8px; } .char-headband-knot { width: 6px; height: 6px; right: -4px; } }

.char-feet { position: absolute; top: 132px; left: 50%; transform: translateX(-50%); display: flex; gap: 16px; z-index: 0; }
.char-foot { width: 16px; height: 7px; background: rgba(15,118,110,0.2); border-radius: 50%; }
@media (max-width: 900px) { .char-feet { top: 107px; gap: 12px; } .char-foot { width: 13px; height: 6px; } }

.char-arm { position: absolute; top: 76px; width: 10px; height: 30px; background: rgba(20,184,166,0.25); border-radius: 6px; transform-origin: top center; transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1); z-index: 1; }
.char-arm::after { content: ''; position: absolute; bottom: -3px; left: 50%; transform: translateX(-50%); width: 7px; height: 7px; background: rgba(20,184,166,0.2); border-radius: 50%; border: 1px solid rgba(45,212,191,0.12); }
.char-arm.left { left: 38px; transform: rotate(8deg); } .char-arm.right { right: 38px; transform: rotate(-8deg); }
.cartoon-char.idle .char-arm.right { animation: armWave 2.5s ease-in-out infinite; }
@keyframes armWave { 0%,100% { transform: rotate(-8deg); } 25% { transform: rotate(-18deg); } 75% { transform: rotate(2deg); } }
.char-arm.right.point-email { transform: rotate(35deg) translateX(4px); }
.char-arm.left.point-email { transform: rotate(-22deg) translateX(-2px); }
.char-arm.right.point-password { transform: rotate(-40deg) translateX(-4px); }
.char-arm.left.point-password { transform: rotate(25deg) translateX(4px); }
.char-arm.right.point-email.excited { animation: armWaveFast 0.5s ease-in-out infinite; }
@keyframes armWaveFast { 0%,100% { transform: rotate(35deg) translateX(4px); } 50% { transform: rotate(50deg) translateX(6px); } }
@media (max-width: 900px) { .char-arm { width: 8px; height: 24px; top: 62px; } .char-arm.left { left: 30px; } .char-arm.right { right: 30px; } .char-arm::after { width: 6px; height: 6px; bottom: -2px; } }

.char-shadow { position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%); width: 75px; height: 8px; background: rgba(0,0,0,0.15); border-radius: 50%; animation: shadowPulse 2.8s ease-in-out infinite; z-index: 0; }
@keyframes shadowPulse { 0%,100% { transform: translateX(-50%) scale(1); opacity: 0.5; } 50% { transform: translateX(-50%) scale(0.85); opacity: 0.3; } }
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
.char-eyes-wrap.thinking .char-pupil { transform: translateX(-50%) translateY(-4px); }

.char-head-group.tilt-thinking { animation: headTilt 1.2s ease-in-out infinite; }
@keyframes headTilt { 0%,100% { transform: translateX(-50%) rotate(5deg); } 50% { transform: translateX(-50%) rotate(10deg); } }
.char-head-group.tilt-idle { animation: idleTilt 3s ease-in-out infinite; }
@keyframes idleTilt { 0%,100% { transform: translateX(-50%) rotate(0deg); } 25% { transform: translateX(-50%) rotate(3deg); } 75% { transform: translateX(-50%) rotate(-2deg); } }
.char-head-group.excited-bounce { animation: headBounce 0.6s ease-in-out; }
@keyframes headBounce { 0% { transform: translateX(-50%) rotate(0deg); } 15% { transform: translateX(-50%) rotate(18deg) translateY(-6px); } 30% { transform: translateX(-50%) rotate(14deg) translateY(0); } 45% { transform: translateX(-50%) rotate(20deg) translateY(-3px); } 60% { transform: translateX(-50%) rotate(12deg) translateY(0); } 100% { transform: translateX(-50%) rotate(16deg) translateX(5px); } }

.char-blush.excited { background: rgba(94,234,212,0.2); width: 16px; height: 8px; animation: blushExcited 1.2s ease-in-out infinite; }
@keyframes blushExcited { 0%,100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.6; transform: scale(1.15); } }
@media (max-width: 900px) { .char-blush.excited { width: 13px; height: 7px; } }

.char-status { margin-top: 1rem; text-align: center; transition: all 0.4s ease; }
.char-status .greeting { font-size: 1.25rem; font-weight: 800; color: #fff; display: block; transition: all 0.3s ease; text-shadow: 0 0 20px rgba(20,184,166,0.15); }
.char-status .sub-text { font-size: 0.875rem; color: rgba(255,255,255,0.45); display: block; margin-top: 0.25rem; transition: all 0.3s ease; }
.char-ambient-dots { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.char-ambient-dots .dot { position: absolute; border-radius: 50%; animation: charDotFloat 3s ease-in-out infinite; }
.char-ambient-dots .dot:nth-child(1) { width: 8px; height: 8px; background: rgba(45,212,191,0.25); top: 15%; left: 10%; animation-delay: 0s; }
.char-ambient-dots .dot:nth-child(2) { width: 5px; height: 5px; background: rgba(94,234,212,0.2); top: 60%; left: 85%; animation-delay: 0.8s; }
.char-ambient-dots .dot:nth-child(3) { width: 6px; height: 6px; background: rgba(20,184,166,0.18); top: 80%; left: 20%; animation-delay: 1.6s; }
.char-ambient-dots .dot:nth-child(4) { width: 4px; height: 4px; background: rgba(16,185,129,0.18); top: 25%; left: 75%; animation-delay: 2.4s; }
@keyframes charDotFloat { 0%,100% { transform: translateY(0) scale(1); opacity: 0.4; } 50% { transform: translateY(-12px) scale(1.3); opacity: 0.8; } }

.reset-card {
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
.reset-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: 24px; padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(20,184,166,0.15), rgba(13,148,136,0.15), rgba(94,234,212,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: cardBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes cardBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
@keyframes cardFadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
.reset-card::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 50% 0%, rgba(20,184,166,0.03) 0%, transparent 50%); animation: cardShine 8s ease-in-out infinite; pointer-events: none; }
@keyframes cardShine { 0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; } 25% { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; } 50% { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; } 75% { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; } }
@media (max-width: 640px) { .reset-card { padding: 1.5rem; } }

.reset-card .rc-header { text-align: center; margin-bottom: 1.75rem; position: relative; }
.reset-card .rc-header .rc-icon { width: 3rem; height: 3rem; margin: 0 auto 0.75rem; background: linear-gradient(135deg, rgba(20,184,166,0.12), rgba(13,148,136,0.06)); border: 1px solid rgba(45,212,191,0.08); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #14B8A6; }
.reset-card .rc-header h2 { font-size: 1.375rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.reset-card .rc-header p { font-size: 0.8125rem; color: rgba(255,255,255,0.35); }

.alert-box { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.8125rem; margin-bottom: 1rem; }
.alert-success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.15); color: #34D399; }
.alert-error { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15); color: #F87171; animation: alertShake 0.5s ease-in-out; }
@keyframes alertShake { 0%,100% { transform: translateX(0); } 10%,50%,90% { transform: translateX(-6px); } 30%,70% { transform: translateX(6px); } }
.alert-error ul { list-style: none; margin: 0; padding: 0; }
.alert-error ul li + li { margin-top: 0.125rem; }

.field { margin-bottom: 1.25rem; }
.field label { display: block; font-size: 0.8125rem; font-weight: 500; color: rgba(255,255,255,0.6); margin-bottom: 0.375rem; transition: color 0.3s; }
.field.focused label { color: #14B8A6; }
.field .input-wrap { position: relative; }
.field .input-wrap .input-icon { position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.15); pointer-events: none; display: flex; align-items: center; transition: color 0.3s; }
.field.focused .input-wrap .input-icon { color: #14B8A6; }
.field input { width: 100%; padding: 0.75rem 0.875rem 0.75rem 2.5rem; background: rgba(0,0,0,0.2); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 12px; font-size: 0.875rem; outline: none; transition: all 0.3s; color: #fff; font-family: var(--font); box-sizing: border-box; }
.field input::placeholder { color: rgba(255,255,255,0.15); }
.field input:focus { border-color: rgba(20,184,166,0.4); background: rgba(20,184,166,0.06); box-shadow: 0 0 0 3px rgba(20,184,166,0.08); }
.field input.error { border-color: rgba(239,68,68,0.4); background: rgba(239,68,68,0.04); box-shadow: 0 0 0 3px rgba(239,68,68,0.08); }

.pass-hint { font-size: 0.75rem; color: rgba(255,255,255,0.25); margin-top: 0.375rem; }

.btn-auth { width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #14B8A6, #0D9488); color: #fff; border: none; padding: 0.8125rem; border-radius: 12px; font-size: 0.9375rem; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 16px rgba(20,184,166,0.3); position: relative; overflow: hidden; font-family: var(--font); }
.btn-auth::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 20%, rgba(255,255,255,0.1) 50%, transparent 80%); transform: translateX(-100%); transition: transform 0.6s; }
.btn-auth:hover::before { transform: translateX(100%); }
.btn-auth:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(20,184,166,0.4); }
.btn-auth:active { transform: translateY(0); }
.btn-auth:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

.btn-auth .spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; }
.btn-auth.loading .spinner { display: inline-block; }
.btn-auth.loading .btn-text { opacity: 0.6; }
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 640px) { .reset-page { padding: 1.5rem 1rem; } }
</style>
@endpush

@section('content')
<div class="reset-page" id="resetPage">
    <div class="reset-grid">
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
                        <div class="char-headband">
                            <div class="char-headband-knot"></div>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="char-status" id="charStatus">
                <span class="greeting" id="charGreeting">Almost there! 🦊</span>
                <span class="sub-text" id="charSubtext">Just set your new password</span>
            </div>
        </div>

        {{-- ═══ RESET PASSWORD FORM ═══ --}}
        <div class="reset-card" id="resetCard">
            <div class="rc-header">
                <div class="rc-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                        <polyline points="9 14 11 16 15 12"/>
                    </svg>
                </div>
                <h2>Reset Password</h2>
                <p>Enter your new password below</p>
            </div>

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

            <form method="POST" action="{{ route('password.store') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="field" id="emailField">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="you@example.com">
                    </div>
                </div>

                <div class="field" id="passwordField">
                    <label for="password">New Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                    </div>
                    <p class="pass-hint">Must be at least 8 characters</p>
                </div>

                <div class="field" id="passwordConfirmField">
                    <label for="password_confirmation">Confirm New Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/><polyline points="9 14 11 16 15 12"/></svg>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-auth" id="resetBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="vertical-align:middle;margin-right:4px;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                        Reset Password
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
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
    const resetBtn = document.getElementById('resetBtn');
    const resetForm = document.getElementById('resetForm');
    const errorAlert = document.getElementById('errorAlert');
    const pupils = document.querySelectorAll('.char-pupil');
    const browLeft = document.getElementById('charBrowLeft');
    const browRight = document.getElementById('charBrowRight');

    const BROW_CLASSES = ['raised', 'lowered', 'confused'];

    function resetChar() {
        headGroup.classList.remove('look-email', 'look-password', 'shake', 'excited-bounce', 'tilt-thinking', 'tilt-idle');
        eyesWrap.classList.remove('look-email', 'look-password', 'excited', 'squint', 'thinking');
        armRight.classList.remove('point-email', 'point-password', 'excited');
        armLeft.classList.remove('point-email', 'point-password');
        cartoonChar.classList.remove('excited-bounce');
        cartoonChar.classList.add('idle');
        mouth.className = 'char-mouth';
        browLeft?.classList.remove(...BROW_CLASSES);
        browRight?.classList.remove(...BROW_CLASSES);
        pupils.forEach(p => { p.style.transform = 'translateX(-50%)'; });
    }

    function setEmotion(state) {
        resetChar();
        switch (state) {
            case 'excited-email':
                headGroup.classList.add('look-email', 'excited-bounce');
                eyesWrap.classList.add('look-email', 'excited');
                armRight.classList.add('point-email', 'excited');
                armLeft.classList.add('point-email');
                browLeft?.classList.add('raised');
                browRight?.classList.add('raised');
                mouth.className = 'char-mouth open';
                pupils.forEach(p => { p.style.transform = 'translateX(-30%) translateX(2px)'; });
                charGreeting.textContent = 'Email looks good! 📧';
                charSubtext.textContent = 'Now for the fun part!';
                break;

            case 'nervous':
                headGroup.classList.add('look-password');
                eyesWrap.classList.add('look-password', 'squint');
                armRight.classList.add('point-password');
                armLeft.classList.add('point-password');
                browLeft?.classList.add('lowered');
                browRight?.classList.add('lowered');
                mouth.className = 'char-mouth sad';
                pupils.forEach(p => { p.style.transform = 'translateX(-70%) translateX(-1px) translateY(1px)'; });
                charGreeting.textContent = 'New password time 🔑';
                charSubtext.textContent = 'Make it a strong one!';
                break;

            case 'thinking':
                headGroup.classList.add('tilt-thinking');
                eyesWrap.classList.add('thinking');
                browLeft?.classList.add('confused');
                browRight?.classList.add('confused');
                mouth.className = 'char-mouth woah';
                pupils.forEach(p => { p.style.transform = 'translateX(-50%) translateY(-4px)'; });
                charGreeting.textContent = 'Let me save that... 🤔';
                charSubtext.textContent = 'Almost done!';
                break;

            case 'upset':
                headGroup.classList.add('shake');
                eyesWrap.classList.add('squint');
                browLeft?.classList.add('lowered');
                browRight?.classList.add('lowered');
                mouth.className = 'char-mouth sad';
                charGreeting.textContent = 'Oops, try again 😰';
                charSubtext.textContent = 'Check your inputs';
                break;

            case 'idle':
            default:
                headGroup.classList.add('tilt-idle');
                mouth.className = 'char-mouth big-smile';
                charGreeting.textContent = 'Almost there! 🦊';
                charSubtext.textContent = 'Just set your new password';
                break;
        }
    }

    function lookAt(field) {
        if (field === 'email') setEmotion('excited-email');
        else if (field === 'password' || field === 'password_confirm') setEmotion('nervous');
    }

    function lookIdle() { setEmotion('idle'); }
    function shakeHead() { setEmotion('upset'); setTimeout(function() { headGroup.classList.remove('shake'); }, 600); }
    function setLoading(loading) { resetBtn.classList.toggle('loading', loading); resetBtn.disabled = loading; }

    if (emailInput) {
        emailInput.addEventListener('focus', function() { emailField.classList.add('focused'); passwordField.classList.remove('focused'); passwordConfirmField.classList.remove('focused'); lookAt('email'); });
        emailInput.addEventListener('blur', function() { emailField.classList.remove('focused'); if (!emailInput.value && !passwordInput?.value) lookIdle(); });
        emailInput.addEventListener('input', function() { if (document.activeElement === emailInput) lookAt('email'); });
    }
    if (passwordInput) {
        passwordInput.addEventListener('focus', function() { passwordField.classList.add('focused'); emailField.classList.remove('focused'); passwordConfirmField.classList.remove('focused'); lookAt('password'); });
        passwordInput.addEventListener('blur', function() { passwordField.classList.remove('focused'); if (!emailInput?.value && !passwordInput.value && !passwordConfirmInput?.value) lookIdle(); });
        passwordInput.addEventListener('input', function() { if (document.activeElement === passwordInput) lookAt('password'); });
    }
    if (passwordConfirmInput) {
        passwordConfirmInput.addEventListener('focus', function() { passwordConfirmField.classList.add('focused'); emailField.classList.remove('focused'); passwordField.classList.remove('focused'); lookAt('password_confirm'); });
        passwordConfirmInput.addEventListener('blur', function() { passwordConfirmField.classList.remove('focused'); if (!emailInput?.value && !passwordInput?.value && !passwordConfirmInput.value) lookIdle(); });
        passwordConfirmInput.addEventListener('input', function() { if (document.activeElement === passwordConfirmInput) lookAt('password_confirm'); });
    }
    if (resetForm) {
        resetForm.addEventListener('submit', function() { setLoading(true); setEmotion('thinking'); });
    }
    if (errorAlert) {
        setEmotion('thinking');
        setTimeout(shakeHead, 400);
        @if($errors->has('email')) if (emailField) emailField.querySelector('input')?.classList.add('error'); @endif
        @if($errors->has('password')) if (passwordField) passwordField.querySelector('input')?.classList.add('error'); @endif
    }
    setLoading(false);
    setTimeout(lookIdle, 100);
})();
</script>
@endsection
