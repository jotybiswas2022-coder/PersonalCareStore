<div class="login-container">
    <div class="particles" id="particles"></div>
    <div class="login-wrapper">
        <div class="card login-card">
            <div class="card-header login-header">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                {{ __('Verify Your Email Address') }}
            </div>

            <div class="card-body login-body">
                @if (session('resent'))
                    <div class="alert-custom alert-success-custom">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="verify-icon-wrapper">
                    <div class="verify-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <path d="M8 21h8"/>
                            <path d="M12 17v4"/>
                            <path d="M17 9l-5 5-3-3"/>
                        </svg>
                    </div>
                </div>

                <p class="verify-text">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                </p>
                <p class="verify-text verify-text-small">
                    {{ __('If you did not receive the email') }},
                </p>

                <form class="w-100" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn login-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            <line x1="12" y1="8" x2="12" y2="14"/>
                            <line x1="9" y1="11" x2="15" y2="11"/>
                        </svg>
                        {{ __('Click here to request another') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
body {
    font-family: 'Inter', sans-serif;
    background: #0f172a;
    margin:0;
    padding:0;
    overflow-x: hidden;
}
.login-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    padding: 20px;
}
.login-container::before {
    content:'';
    position:absolute;
    top:-50%; left:-50%;
    width:200%; height:200%;
    background: radial-gradient(ellipse at 20% 50%, rgba(59,130,246,0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(59,130,246,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(59,130,246,0.06) 0%, transparent 50%);
    animation: bgPulse 8s ease-in-out infinite alternate;
    z-index:0;
}
@keyframes bgPulse {0%{transform:scale(1) rotate(0deg);}100%{transform:scale(1.1) rotate(3deg);}}
.particles {
    position:absolute; top:0; left:0;
    width:100%; height:100%;
    pointer-events:none; z-index:0;
}
.particle {
    position:absolute; border-radius:50%;
    background: rgba(59,130,246,0.4);
    animation: floatUp linear infinite;
}
@keyframes floatUp {0%{transform:translateY(100vh) scale(0);opacity:0;}10%{opacity:1;}90%{opacity:1;}100%{transform:translateY(-10vh) scale(1);opacity:0;}}
.login-wrapper {
    width: 100%; max-width: 440px;
    z-index:1; padding-bottom: 40px;
}
.login-card {
    background: rgba(20,28,45,0.95);
    border-radius:36px;
    box-shadow:0 25px 60px rgba(0,0,0,0.6),0 0 40px rgba(59,130,246,0.2);
    backdrop-filter: blur(28px);
    border:1px solid rgba(59,130,246,0.2);
    opacity:0; transform: translateY(20px);
    animation: cardEntry 0.8s forwards;
}
.login-header {
    background: linear-gradient(135deg,#0f172a,#1e293b);
    color:#fff;
    text-align:center;
    font-size:22px;
    font-weight:700;
    padding:28px 20px;
    border-radius:36px 36px 0 0;
    border-bottom:1px solid rgba(59,130,246,0.25);
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:16px;
}
.header-icon {
    width:50px; height:50px;
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 12px 35px rgba(59,130,246,0.4);
    transition: all 0.3s ease;
}
.header-icon:hover { transform:scale(1.1); }
.header-icon svg { width:24px; height:24px; }
.login-body {
    padding:32px 36px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:16px;
}
.verify-icon-wrapper {
    display:flex;
    justify-content:center;
}
.verify-icon {
    width:72px; height:72px;
    background: rgba(59,130,246,0.1);
    border:2px solid rgba(59,130,246,0.2);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#3b82f6;
    animation: verifyPulse 2s ease-in-out infinite;
    transition: transform 0.3s ease;
}
.verify-icon:hover { transform:scale(1.08); }
.verify-icon svg { width:32px; height:32px; }
@keyframes verifyPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.3); }
    50% { box-shadow: 0 0 0 12px rgba(59,130,246,0); }
}
.verify-text {
    color:#94a3b8;
    font-size:14.5px;
    line-height:1.6;
    text-align:center;
    margin:0;
}
.verify-text-small {
    font-size:13.5px;
    color:#64748b;
}
.alert-custom {
    padding:12px 16px;
    border-radius:14px;
    font-size:13.5px;
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
}
.alert-success-custom {
    background: rgba(16,185,129,0.12);
    border:1px solid rgba(16,185,129,0.25);
    color:#34d399;
}
.login-btn {
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    border:none; color:#fff;
    padding:14px 24px; font-size:15px; border-radius:32px;
    font-weight:600; width:100%;
    display:flex; align-items:center; justify-content:center; gap:8px;
    transition:all 0.3s ease;
}
.login-btn:hover {
    transform:scale(1.03);
    box-shadow:0 12px 28px rgba(59,130,246,0.45);
}
@keyframes cardEntry { to{opacity:1; transform:translateY(0);} }

/* ===== Mobile Responsive ===== */
@media(max-width:768px){
    .login-wrapper { max-width:92%; padding-bottom:30px; }
    .login-body { padding:28px 28px; gap:14px; }
    .login-header { font-size:20px; padding:22px 16px; }
    .verify-icon { width:64px; height:64px; }
    .verify-icon svg { width:28px; height:28px; }
}

@media(max-width:576px){
    .login-wrapper { max-width:95%; }
    .login-card { border-radius:28px; }
    .login-header {
        font-size:18px;
        padding:18px 14px;
        border-radius:28px 28px 0 0;
        gap:12px;
    }
    .header-icon { width:44px; height:44px; }
    .header-icon svg { width:20px; height:20px; }
    .login-body { padding:20px 16px; gap:12px; }
    .login-btn { padding:12px 20px; font-size:14px; border-radius:28px; }
    .verify-icon { width:56px; height:56px; }
    .verify-icon svg { width:24px; height:24px; }
    .verify-text { font-size:13.5px; }
    .verify-text-small { font-size:12.5px; }
    .alert-custom { padding:10px 12px; font-size:12.5px; flex-wrap:wrap; }
    .particle { display:none; }
}

@media(max-width:400px){
    .login-wrapper { max-width:98%; padding-bottom:20px; }
    .login-header { font-size:16px; padding:14px 10px; gap:10px; }
    .header-icon { width:38px; height:38px; border-radius:12px; }
    .header-icon svg { width:18px; height:18px; }
    .login-body { padding:16px 12px; }
    .verify-icon { width:48px; height:48px; }
    .verify-icon svg { width:20px; height:20px; }
    .login-btn { padding:10px 16px; font-size:13px; }
    .verify-text { font-size:12.5px; }
}
</style>

<script>
const particlesContainer=document.getElementById('particles');
const isMobile=window.innerWidth<=576;
const particleCount=isMobile?0:30;

for(let i=0;i<particleCount;i++){
    const p=document.createElement('div');
    p.classList.add('particle');
    const size=Math.random()*5+3;
    p.style.width=size+'px';
    p.style.height=size+'px';
    p.style.left=Math.random()*100+'%';
    p.style.animationDuration=(Math.random()*6+6)+'s';
    p.style.animationDelay=(Math.random()*10)+'s';
    p.style.opacity=Math.random()*0.5+0.1;
    particlesContainer.appendChild(p);
}
</script>
