<header class="site-header" id="siteHeader">
    <div class="header-inner container">
        <a href="{{ route('home') }}" class="header-logo">
            <div class="logo-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <span class="logo-text">Basa<span>Finder</span></span>
        </a>

        <nav class="header-nav" id="headerNav">
            <a href="{{ route('home') }}" class="nav-item">Home</a>
            <a href="{{ route('search') }}" class="nav-item">Browse</a>
            <a href="{{ route('home') }}#properties" class="nav-item">Properties</a>
            <a href="{{ route('post-property') }}" class="nav-item nav-item--cta">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Post Property
            </a>
            <div class="nav-divider"></div>
            @auth
                <a href="{{ route('my-properties') }}" class="nav-item">My Properties</a>
                <a href="{{ route('profile.edit') }}" class="nav-item">Profile</a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="nav-item nav-item--admin">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="nav-item nav-item--logout">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-item">Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get Started</a>
            @endauth
        </nav>

        <button class="header-toggle" id="headerToggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<style>
@keyframes navBorderFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.site-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,255,255,0.82);
    backdrop-filter: blur(40px) saturate(1.5);
    -webkit-backdrop-filter: blur(40px) saturate(1.5);
    transition: background 0.4s ease, box-shadow 0.4s ease;
}
.site-header::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(37,99,235,0.08) 25%, rgba(124,58,237,0.08) 50%, rgba(37,99,235,0.08) 75%, transparent 100%);
    background-size: 200% 100%;
    animation: navBorderFlow 6s ease-in-out infinite;
    pointer-events: none;
}
.site-header.scrolled {
    background: rgba(255,255,255,0.95);
    box-shadow: 0 4px 32px rgba(15,23,42,0.08);
}

.header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    gap: 1rem;
}
.header-logo {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    text-decoration: none;
    flex-shrink: 0;
}
.logo-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.25);
    transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
    position: relative;
}
.logo-icon::after {
    content: '';
    position: absolute; inset: -2px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(96,165,250,0.2), rgba(167,139,250,0.1));
    z-index: -1;
    opacity: 0;
    transition: opacity 0.4s;
}
.header-logo:hover .logo-icon {
    transform: rotate(-6deg) scale(1.1);
    box-shadow: 0 8px 28px rgba(37,99,235,0.4);
}
.header-logo:hover .logo-icon::after { opacity: 1; }
.logo-text {
    font-family: var(--font);
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.04em;
}
.logo-text span { color: var(--primary); }
.header-nav {
    display: flex;
    align-items: center;
    gap: 0.125rem;
}
.nav-item {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-muted);
    padding: 0.5rem 0.875rem;
    border-radius: var(--r-sm);
    transition: all 0.25s ease;
    text-decoration: none;
    white-space: nowrap;
    background: none;
    border: none;
    cursor: pointer;
    font-family: var(--font);
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    position: relative;
}
.nav-item:hover {
    background: var(--primary-pale);
    color: var(--primary);
}
.nav-item--cta {
    color: var(--primary);
    background: var(--primary-light);
    font-weight: 600;
    border: 1px solid transparent;
}
.nav-item--cta:hover {
    background: #BFDBFE;
    color: var(--primary-dark);
}
.nav-item--admin {
    color: #92400E;
    background: rgba(251,191,36,0.1);
}
.nav-item--admin:hover {
    background: rgba(251,191,36,0.18);
    color: #92400E;
}
.nav-item--logout {
    color: #EF4444;
}
.nav-item--logout:hover {
    background: #FEF2F2;
    color: #DC2626;
}
.nav-divider {
    width: 1px;
    height: 20px;
    background: var(--border);
    margin: 0 0.25rem;
}
.header-nav .btn {
    margin-left: 0.375rem;
    font-size: 0.84rem;
    padding: 0.5rem 1.125rem;
    background: linear-gradient(135deg, var(--primary), #4F46E5);
    border: none;
}
.header-nav .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.3);
}
.header-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    border-radius: var(--r-sm);
    transition: background 0.2s;
}
.header-toggle:hover { background: var(--bg); }
.header-toggle span {
    display: block;
    width: 20px;
    height: 2px;
    background: var(--text);
    border-radius: 2px;
    transition: all 0.3s ease;
    transform-origin: center;
}
.header-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.header-toggle.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.header-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

@media (max-width: 820px) {
    .header-toggle { display: flex; }
    .header-nav {
        display: none;
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(40px) saturate(1.5);
        -webkit-backdrop-filter: blur(40px) saturate(1.5);
        border-bottom: 1px solid var(--border);
        flex-direction: column;
        align-items: stretch;
        padding: 0.75rem 1rem;
        gap: 0.25rem;
        box-shadow: 0 20px 60px rgba(15,23,42,0.1);
    }
    .header-nav.open { display: flex; }
    .header-nav.open { animation: fadeUp 0.25s ease-out; }
    .nav-item { width: 100%; padding: 0.75rem 1rem; border-radius: var(--r-sm); justify-content: flex-start; }
    .nav-divider { width: 100%; height: 1px; margin: 0.25rem 0; }
    .header-nav .btn { width: 100%; justify-content: center; margin-left: 0; }
}
</style>

<script>
(function() {
    var header = document.getElementById('siteHeader');
    var toggle = document.getElementById('headerToggle');
    var nav    = document.getElementById('headerNav');
    if (!header || !toggle || !nav) return;

    window.addEventListener('scroll', function() {
        header.classList.toggle('scrolled', window.scrollY > 30);
    }, { passive: true });

    toggle.addEventListener('click', function() {
        var open = nav.classList.toggle('open');
        toggle.classList.toggle('open', open);
    });

    document.addEventListener('click', function(e) {
        if (!header.contains(e.target)) {
            nav.classList.remove('open');
            toggle.classList.remove('open');
        }
    });
})();
</script>
