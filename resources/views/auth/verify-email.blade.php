@extends('frontend.layouts.app')

@section('title', 'Verify Email')

@push('styles')
<style>
.verify-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0B1121 0%, #0F172A 40%, #0A2E1A 100%);
    position: relative;
    overflow: hidden;
    padding: 2rem 1rem;
}
.verify-page::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 500px at 20% 30%, rgba(16,185,129,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 600px 400px at 80% 70%, rgba(52,211,153,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.verify-grid {
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
    .verify-grid { grid-template-columns: 1fr; max-width: 460px; gap: 1.5rem; }
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
    background: linear-gradient(135deg, rgba(52,211,153,0.2), rgba(16,185,129,0.25), rgba(5,150,105,0.2), rgba(110,231,183,0.15), rgba(52,211,153,0.2));
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

.cartoon-char { position: relative; width: 160px; height: 190px; }
@media (max-width: 900px) { .cartoon-char { width: 130px; height: 154px; } }

.cartoon-char.idle { animation: charFloat 2.8s ease-in-out infinite; }
@keyframes charFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }

.char-head-group {
    position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    transform-origin: center 40px; transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1); z-index: 2;
}
.char-head-group.tilt-idle { animation: idleTilt 3s ease-in-out infinite; }
@keyframes idleTilt { 0%,100% { transform: translateX(-50%) rotate(0deg); } 25% { transform: translateX(-50%) rotate(3deg); } 75% { transform: translateX(-50%) rotate(-2deg); } }

.char-head { width: 68px; height: 68px; background: linear-gradient(135deg, #6EE7B7, #10B981); border-radius: 50%; position: relative; border: 2px solid rgba(52,211,153,0.25); box-shadow: 0 4px 20px rgba(16,185,129,0.15); }
@media (max-width: 900px) { .char-head { width: 55px; height: 55px; } }

.char-ear { position: absolute; top: 18px; width: 16px; height: 16px; background: rgba(52,211,153,0.15); border-radius: 50%; border: 1.5px solid rgba(52,211,153,0.15); }
.char-ear.left { left: -9px; } .char-ear.right { right: -9px; }
.char-ear::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 7px; height: 7px; background: rgba(110,231,183,0.1); border-radius: 50%; }
@media (max-width: 900px) { .char-ear { width: 13px; height: 13px; top: 14px; } .char-ear.left { left: -7px; } .char-ear.right { right: -7px; } .char-ear::after { width: 5px; height: 5px; } }

.char-eyes-wrap { position: absolute; top: 22px; left: 50%; transform: translateX(-50%); display: flex; gap: 14px; transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1); }
@media (max-width: 900px) { .char-eyes-wrap { top: 18px; gap: 11px; } }

.char-eye { width: 18px; height: 20px; background: rgba(255,255,255,0.15); border-radius: 50%; position: relative; border: 1.5px solid rgba(52,211,153,0.12); overflow: hidden; }
@media (max-width: 900px) { .char-eye { width: 14px; height: 16px; } }

.char-pupil { position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: rgba(4,120,87,0.5); border-radius: 50%; transition: all 0.3s ease; }
@media (max-width: 900px) { .char-pupil { width: 6px; height: 6px; bottom: 3px; } }

.char-eye-shine { position: absolute; top: 3px; right: 3px; width: 5px; height: 5px; background: rgba(255,255,255,0.35); border-radius: 50%; animation: sparklePulse 2s ease-in-out infinite; }
@media (max-width: 900px) { .char-eye-shine { width: 4px; height: 4px; } }

.char-blink { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.9); border-radius: 50%; clip-path: inset(0 0 50% 0); animation: blink 3.5s ease-in-out infinite; pointer-events: none; }
@keyframes blink { 0%,96%,100% { opacity: 0; } 97% { opacity: 1; } }

.char-blush { position: absolute; top: 38px; width: 16px; height: 8px; background: rgba(110,231,183,0.15); border-radius: 50%; animation: blushPulse 2.5s ease-in-out infinite; }
.char-blush.left { left: 6px; } .char-blush.right { right: 6px; }
@keyframes blushPulse { 0%,100% { opacity: 0.3; } 50% { opacity: 0.6; } }
@media (max-width: 900px) { .char-blush { width: 13px; height: 6px; top: 30px; } .char-blush.left { left: 5px; } .char-blush.right { right: 5px; } }

.char-brow { position: absolute; top: 16px; width: 16px; height: 2px; background: rgba(4,120,87,0.15); border-radius: 2px; }
.char-brow.left { left: 12px; transform: rotate(-8deg); } .char-brow.right { right: 12px; transform: rotate(8deg); }
@media (max-width: 900px) { .char-brow { width: 13px; top: 13px; } .char-brow.left { left: 10px; } .char-brow.right { right: 10px; } }

.char-mouth { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); width: 12px; height: 2px; background: rgba(4,120,87,0.2); border-radius: 2px; transition: all 0.3s ease; }
.char-mouth.big-smile { width: 20px; height: 8px; background: transparent; border-bottom: 2.5px solid rgba(4,120,87,0.3); border-radius: 0 0 50% 50%; bottom: 9px; }
@media (max-width: 900px) { .char-mouth { width: 10px; bottom: 9px; } .char-mouth.big-smile { width: 16px; height: 6px; bottom: 7px; } }

.char-body { position: absolute; top: 74px; left: 50%; transform: translateX(-50%); width: 56px; height: 52px; background: linear-gradient(180deg, #10B981, #059669); border-radius: 20px 20px 14px 14px; border: 2px solid rgba(52,211,153,0.25); z-index: 1; }
@media (max-width: 900px) { .char-body { width: 44px; height: 42px; top: 60px; border-radius: 16px 16px 10px 10px; } }

.char-belly { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); width: 20px; height: 14px; background: radial-gradient(ellipse, rgba(52,211,153,0.3), rgba(16,185,129,0.08)); border-radius: 50%; border: 1px solid rgba(52,211,153,0.08); }
@media (max-width: 900px) { .char-belly { width: 16px; height: 11px; bottom: 7px; } }

.char-collar { position: absolute; top: -1px; left: 50%; transform: translateX(-50%); width: 22px; height: 8px; border-bottom: 2px solid rgba(52,211,153,0.15); border-radius: 0 0 50% 50%; }

.char-mail-cap {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 44px;
    height: 18px;
    background: linear-gradient(180deg, #059669, #047857);
    border-radius: 4px 4px 2px 2px;
    border: 1.5px solid rgba(52,211,153,0.2);
    z-index: 3;
}
.char-mail-cap::after {
    content: '';
    position: absolute;
    top: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 10px;
    height: 6px;
    background: rgba(16,185,129,0.2);
    border-radius: 50%;
    animation: antennaPulse 1.5s ease-in-out infinite;
}
@keyframes antennaPulse { 0%,100% { transform: translateX(-50%) scale(1); opacity: 0.5; } 50% { transform: translateX(-50%) scale(1.3); opacity: 1; } }
@media (max-width: 900px) { .char-mail-cap { width: 36px; height: 14px; top: -10px; } .char-mail-cap::after { width: 8px; height: 5px; top: -3px; } }

.char-feet { position: absolute; top: 132px; left: 50%; transform: translateX(-50%); display: flex; gap: 16px; z-index: 0; }
.char-foot { width: 16px; height: 7px; background: rgba(4,120,87,0.2); border-radius: 50%; }
@media (max-width: 900px) { .char-feet { top: 107px; gap: 12px; } .char-foot { width: 13px; height: 6px; } }

.char-arm { position: absolute; top: 76px; width: 10px; height: 30px; background: rgba(16,185,129,0.25); border-radius: 6px; transform-origin: top center; transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1); z-index: 1; }
.char-arm::after { content: ''; position: absolute; bottom: -3px; left: 50%; transform: translateX(-50%); width: 7px; height: 7px; background: rgba(16,185,129,0.2); border-radius: 50%; border: 1px solid rgba(52,211,153,0.12); }
.char-arm.left { left: 38px; transform: rotate(8deg); } .char-arm.right { right: 38px; transform: rotate(-8deg); }
.cartoon-char.idle .char-arm.right { animation: armWave 2.5s ease-in-out infinite; }
@keyframes armWave { 0%,100% { transform: rotate(-8deg); } 25% { transform: rotate(-18deg); } 75% { transform: rotate(2deg); } }
@media (max-width: 900px) { .char-arm { width: 8px; height: 24px; top: 62px; } .char-arm.left { left: 30px; } .char-arm.right { right: 30px; } .char-arm::after { width: 6px; height: 6px; bottom: -2px; } }

.char-shadow { position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%); width: 75px; height: 8px; background: rgba(0,0,0,0.15); border-radius: 50%; animation: shadowPulse 2.8s ease-in-out infinite; z-index: 0; }
@keyframes shadowPulse { 0%,100% { transform: translateX(-50%) scale(1); opacity: 0.5; } 50% { transform: translateX(-50%) scale(0.85); opacity: 0.3; } }
@media (max-width: 900px) { .char-shadow { width: 60px; height: 7px; } }

.char-mail-hold {
    position: absolute;
    top: 82px;
    right: -14px;
    width: 20px;
    height: 16px;
    background: rgba(255,255,255,0.08);
    border: 1.5px solid rgba(255,255,255,0.1);
    border-radius: 3px;
    z-index: 2;
    animation: mailBounce 2s ease-in-out infinite;
    transform-origin: center bottom;
}
.char-mail-hold::before {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    right: 3px;
    height: 1px;
    background: rgba(255,255,255,0.08);
    box-shadow: 0 4px 0 rgba(255,255,255,0.08);
}
@keyframes mailBounce {
    0%,100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-4px) rotate(-5deg); }
    75% { transform: translateY(0) rotate(3deg); }
}
@media (max-width: 900px) { .char-mail-hold { width: 16px; height: 13px; right: -10px; top: 66px; } }

.char-status { margin-top: 1rem; text-align: center; transition: all 0.4s ease; }
.char-status .greeting { font-size: 1.25rem; font-weight: 800; color: #fff; display: block; transition: all 0.3s ease; text-shadow: 0 0 20px rgba(16,185,129,0.15); }
.char-status .sub-text { font-size: 0.875rem; color: rgba(255,255,255,0.45); display: block; margin-top: 0.25rem; transition: all 0.3s ease; }
.char-ambient-dots { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.char-ambient-dots .dot { position: absolute; border-radius: 50%; animation: charDotFloat 3s ease-in-out infinite; }
.char-ambient-dots .dot:nth-child(1) { width: 8px; height: 8px; background: rgba(52,211,153,0.25); top: 15%; left: 10%; animation-delay: 0s; }
.char-ambient-dots .dot:nth-child(2) { width: 5px; height: 5px; background: rgba(110,231,183,0.2); top: 60%; left: 85%; animation-delay: 0.8s; }
.char-ambient-dots .dot:nth-child(3) { width: 6px; height: 6px; background: rgba(16,185,129,0.18); top: 80%; left: 20%; animation-delay: 1.6s; }
.char-ambient-dots .dot:nth-child(4) { width: 4px; height: 4px; background: rgba(5,150,105,0.18); top: 25%; left: 75%; animation-delay: 2.4s; }
@keyframes charDotFloat { 0%,100% { transform: translateY(0) scale(1); opacity: 0.4; } 50% { transform: translateY(-12px) scale(1.3); opacity: 0.8; } }

.verify-card {
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
    text-align: center;
}
.verify-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: 24px; padding: 1.5px;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(16,185,129,0.15), rgba(5,150,105,0.15), rgba(110,231,183,0.1), rgba(255,255,255,0.06));
    background-size: 400% 400%;
    animation: cardBorderShift 6s ease-in-out infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}
@keyframes cardBorderShift { 0%,100% { background-position: 0% 50%; } 25% { background-position: 100% 0%; } 50% { background-position: 100% 100%; } 75% { background-position: 0% 100%; } }
@keyframes cardFadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
.verify-card::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 50% 0%, rgba(16,185,129,0.03) 0%, transparent 50%); animation: cardShine 8s ease-in-out infinite; pointer-events: none; }
@keyframes cardShine { 0%,100% { transform: translate(0,0) rotate(0deg); opacity: 0.2; } 25% { transform: translate(10%,-10%) rotate(5deg); opacity: 0.5; } 50% { transform: translate(-5%,5%) rotate(-3deg); opacity: 0.3; } 75% { transform: translate(8%,-8%) rotate(4deg); opacity: 0.6; } }
@media (max-width: 640px) {
    .verify-page { padding: 1rem 0.75rem; }
    .verify-grid { gap: 0; }
    .verify-card {
        padding: 1.25rem;
        border-radius: 20px;
    }
    .verify-card .vc-header { margin-bottom: 1rem; }
    .verify-card .vc-header .vc-icon { width: 2.5rem; height: 2.5rem; }
    .verify-card .vc-header h2 { font-size: 1.125rem; }
    .verify-card .vc-header p { font-size: 0.75rem; }
    .btn-auth { padding: 0.6875rem; font-size: 0.875rem; }
    .btn-outline-auth { padding: 0.6875rem; font-size: 0.875rem; }
    .btn-group { flex-direction: column; }
    .btn-auth, .btn-outline-auth { width: 100%; }
}

.verify-card .vc-header { text-align: center; margin-bottom: 1.5rem; position: relative; }
.verify-card .vc-header .vc-icon { width: 3.5rem; height: 3.5rem; margin: 0 auto 0.75rem; background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(5,150,105,0.06)); border: 1px solid rgba(52,211,153,0.08); border-radius: 18px; display: flex; align-items: center; justify-content: center; color: #10B981; }
.verify-card .vc-header h2 { font-size: 1.375rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
.verify-card .vc-header p { font-size: 0.875rem; color: rgba(255,255,255,0.45); line-height: 1.6; }

.alert-box { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.875rem 1rem; border-radius: 12px; font-size: 0.8125rem; margin-bottom: 1.5rem; text-align: left; }
.alert-success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.15); color: #34D399; }

.btn-group { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }

.btn-auth { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #10B981, #059669); color: #fff; border: none; padding: 0.8125rem 1.5rem; border-radius: 12px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 16px rgba(16,185,129,0.3); position: relative; overflow: hidden; font-family: var(--font); }
.btn-auth::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 20%, rgba(255,255,255,0.1) 50%, transparent 80%); transform: translateX(-100%); transition: transform 0.6s; }
.btn-auth:hover::before { transform: translateX(100%); }
.btn-auth:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,185,129,0.4); }
.btn-auth:active { transform: translateY(0); }

.btn-outline-auth { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background: transparent; color: rgba(255,255,255,0.5); border: 1.5px solid rgba(255,255,255,0.08); padding: 0.8125rem 1.5rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all 0.3s; font-family: var(--font); }
.btn-outline-auth:hover { background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.15); color: #F87171; transform: translateY(-2px); }

.btn-auth .spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; }
.btn-auth.loading .spinner { display: inline-block; }
.btn-auth.loading .btn-text { opacity: 0.6; }
@keyframes spin { to { transform: rotate(360deg); } }

</style>
@endpush

@section('content')
<div class="verify-page" id="verifyPage">
    <div class="verify-grid">
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
                        <div class="char-mail-cap"></div>
                    </div>
                    <div class="char-mail-hold"></div>
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
                            <div class="char-mouth big-smile" id="charMouth"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="char-status" id="charStatus">
                <span class="greeting" id="charGreeting">Check your inbox! ✉️</span>
                <span class="sub-text" id="charSubtext">I sent you a little something</span>
            </div>
        </div>

        {{-- ═══ VERIFY EMAIL CARD ═══ --}}
        <div class="verify-card" id="verifyCard">
            <div class="vc-header">
                <div class="vc-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <h2>Verify Your Email</h2>
                <p>Thanks for signing up!<br>Please verify your email address to get started.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert-box alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    A new verification link has been sent to your email.
                </div>
            @endif

            <div class="btn-group">
                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <button type="submit" class="btn-auth" id="resendBtn">
                        <span class="spinner"></span>
                        <span class="btn-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="vertical-align:middle;margin-right:4px;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                            Resend Verification
                        </span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="btn-outline-auth">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="vertical-align:middle;margin-right:4px;"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    const resendBtn = document.getElementById('resendBtn');
    const resendForm = document.getElementById('resendForm');
    const charGreeting = document.getElementById('charGreeting');
    const charSubtext = document.getElementById('charSubtext');

    if (resendForm) {
        resendForm.addEventListener('submit', function() {
            resendBtn.classList.add('loading');
            resendBtn.disabled = true;
            if (charGreeting) charGreeting.textContent = 'Sending another one... 📬';
            if (charSubtext) charSubtext.textContent = 'Check your inbox soon!';
        });
    }
})();
</script>
@endsection
