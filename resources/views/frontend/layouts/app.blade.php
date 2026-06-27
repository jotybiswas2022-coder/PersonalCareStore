<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BasaFinder — @yield('title', 'Find Your Perfect Rental Home in Bangladesh')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    :root {
        /* ── Core Palette ── */
        --navy:       #0A0F1E;
        --navy-soft:  #111827;
        --navy-mute:  #1E293B;
        --primary:    #2563EB;
        --primary-dark: #1D4ED8;
        --primary-light: #DBEAFE;
        --primary-glow: rgba(37,99,235,0.15);
        --primary-pale: rgba(37,99,235,0.06);
        --secondary:  #0F172A;
        --accent:     #60A5FA;
        --gold:       #F59E0B;
        --gold-light: #FEF3C7;
        --gold-dark:  #D97706;
        --gold-glow:  rgba(245,158,11,0.18);
        --bg:         #F8FAFC;
        --bg-soft:    #F1F5F9;
        --white:      #FFFFFF;
        --success:    #10B981;
        --text:       #1E293B;
        --text-muted: #64748B;
        --text-light: #94A3B8;
        --border:     #E2E8F0;
        --border-light: rgba(37,99,235,0.12);

        /* ── Typography ── */
        --font:      'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        --font-serif: 'Playfair Display', Georgia, serif;

        /* ── Radius ── */
        --r-sm: 8px;
        --r-md: 12px;
        --r-lg: 16px;
        --r-xl: 24px;

        /* ── Shadows ── */
        --shadow-xs: 0 1px 2px rgba(15,23,42,0.04);
        --shadow-sm: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
        --shadow-md: 0 4px 6px rgba(15,23,42,0.06), 0 10px 15px rgba(15,23,42,0.04);
        --shadow-lg: 0 10px 25px rgba(15,23,42,0.08), 0 20px 48px rgba(15,23,42,0.04);
        --shadow-xl: 0 20px 56px rgba(15,23,42,0.12);
        --shadow-primary: 0 4px 16px rgba(37,99,235,0.3);
        --shadow-gold: 0 4px 16px rgba(245,158,11,0.3);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 16px; }

    body {
        font-family: var(--font);
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    main { flex: 1; }
    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }

    /* ── Layout ── */
    .container { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
    @media (max-width: 640px) { .container { padding: 0 1rem; } }

    /* ── Section ── */
    .section { padding: 6rem 0; }
    @media (max-width: 768px) { .section { padding: 4rem 0; } }

    .section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 1rem;
    }
    .section-eyebrow::before {
        content: '';
        display: block;
        width: 24px;
        height: 2px;
        background: var(--primary);
        border-radius: 2px;
    }
    .section-heading {
        font-family: var(--font-serif);
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        color: var(--text);
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 1rem;
    }
    .section-heading .highlight { color: var(--primary); }
    .section-sub {
        font-size: 1rem;
        color: var(--text-muted);
        max-width: 36rem;
        line-height: 1.75;
    }
    .section-header { margin-bottom: 3.5rem; }
    .section-header.centered { text-align: center; }
    .section-header.centered .section-sub { margin: 0 auto; }
    .section-header.centered .section-eyebrow { justify-content: center; }
    .section-header.centered .section-eyebrow::before { display: none; }
    .section-header.centered .section-eyebrow::after {
        content: '';
        display: block;
        width: 24px;
        height: 2px;
        background: var(--primary);
        border-radius: 2px;
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.75rem;
        border-radius: var(--r-md);
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s ease;
        cursor: pointer;
        border: none;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-primary {
        background: var(--primary);
        color: #fff;
        box-shadow: var(--shadow-primary);
    }
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37,99,235,0.45);
    }
    .btn-gold {
        background: var(--gold);
        color: #fff;
        box-shadow: var(--shadow-gold);
    }
    .btn-gold:hover {
        background: var(--gold-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(245,158,11,0.5);
    }
    .btn-outline {
        background: transparent;
        color: var(--primary);
        border: 1.5px solid var(--primary);
    }
    .btn-outline:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-2px);
    }
    .btn-dark {
        background: var(--navy);
        color: #fff;
    }
    .btn-dark:hover {
        background: var(--navy-soft);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    .btn-sm { padding: 0.5rem 1.125rem; font-size: 0.8125rem; border-radius: var(--r-sm); }
    .btn-lg { padding: 1rem 2.25rem; font-size: 1rem; border-radius: var(--r-lg); }

    /* ── Cards ── */
    .card {
        background: var(--white);
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-xs);
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    /* ── Grids ── */
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
    @media (max-width: 1024px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; gap: 1rem; } }

    /* ── Animations ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    .reveal {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 0.75s cubic-bezier(0.16,1,0.3,1), transform 0.75s cubic-bezier(0.16,1,0.3,1);
    }
    .reveal.revealed { opacity: 1; transform: translateY(0); }

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
    @stack('styles')
</head>
<body>
    @include('frontend.partials.nav')

    @if(session('success'))
        <div style="position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:9999; background:#10B981; color:#fff; padding:0.875rem 1.5rem; border-radius:12px; font-size:0.875rem; font-weight:500; box-shadow:0 8px 32px rgba(16,185,129,0.3); max-width:90vw; text-align:center; animation:fadeUp 0.3s ease;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:9999; background:#EF4444; color:#fff; padding:0.875rem 1.5rem; border-radius:12px; font-size:0.875rem; font-weight:500; box-shadow:0 8px 32px rgba(239,68,68,0.3); max-width:90vw; text-align:center; animation:fadeUp 0.3s ease;">
            @foreach($errors->all() as $error) {{ $error }} @if(!$loop->last) · @endif @endforeach
        </div>
    @endif

    <main>@yield('content')</main>
    @include('frontend.partials.footer')

    <!-- ════════ SCROLL PROGRESS ════════ -->
    <div id="scrollProgress"></div>

    <!-- ════════ BACK TO TOP ════════ -->
    <button id="backToTop" aria-label="Back to top">
        <span class="ring-pulse"></span>
        <span class="ring-pulse"></span>
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="20" x2="12" y2="4"/>
            <polyline points="5 11 12 4 19 11"/>
        </svg>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    var scrollProgressEl = document.getElementById('scrollProgress');
    var backToTopBtn = document.getElementById('backToTop');

    window.addEventListener('scroll', function() {
        var scrollTop = window.scrollY;
        scrollProgressEl.style.width = (scrollTop / (document.documentElement.scrollHeight - window.innerHeight) * 100) + '%';
        backToTopBtn.classList.toggle('visible', scrollTop > 200);
    });

    backToTopBtn.addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    </script>

    @stack('scripts')
</body>
</html>
