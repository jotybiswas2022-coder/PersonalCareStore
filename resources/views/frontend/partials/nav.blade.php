<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <span class="logo-icon">B</span>
            <span class="logo-text">BasaFinder</span>
        </a>
        <button id="navToggle" class="nav-toggle" aria-label="Toggle menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path id="hamburgerIcon" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div id="navLinks" class="nav-links">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="{{ route('search') }}" class="nav-link">Browse</a>
            <a href="{{ route('home') }}#properties" class="nav-link">Properties</a>
            <a href="{{ route('post-property') }}" class="nav-link nav-link-highlight">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Post Property
            </a>
            @auth
                <div class="nav-divider"></div>
                <a href="{{ route('profile.edit') }}" class="nav-link">Profile</a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="nav-link nav-link-admin">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                    @csrf
                    <button type="submit" class="nav-link nav-logout-btn">Logout</button>
                </form>
            @else
                <div class="nav-divider"></div>
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            @endauth
        </div>
    </div>
</nav>

<style>
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
}
.nav-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 68px;
}
.nav-logo {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    text-decoration: none;
}
.logo-icon {
    width: 2.25rem;
    height: 2.25rem;
    background: linear-gradient(135deg, var(--primary), #1D4ED8);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 800;
    font-size: 1.125rem;
    box-shadow: 0 2px 8px rgba(37,99,235,0.25);
}
.logo-text {
    font-size: 1.375rem;
    font-weight: 800;
    color: var(--secondary);
    letter-spacing: -0.03em;
}
.nav-toggle {
    display: none;
    background: none;
    border: none;
    color: var(--secondary);
    cursor: pointer;
    padding: 0.25rem;
}
.nav-links {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.nav-link {
    color: var(--text-muted);
    text-decoration: none;
    padding: 0.5rem 0.875rem;
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
    white-space: nowrap;
}
.nav-link:hover { background: var(--bg); color: var(--primary); }
.nav-link-highlight {
    background: var(--primary-light);
    color: var(--primary) !important;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.nav-link-highlight:hover { background: #BFDBFE; }
.nav-link-admin {
    background: var(--accent-light);
    color: #92400E !important;
}
.nav-link-admin:hover { background: #FDE68A; }
.nav-divider { width: 1px; height: 1.5rem; background: var(--border); margin: 0 0.25rem; }
.nav-logout-form { display: inline; }
.nav-logout-btn { background: none; border: none; cursor: pointer; font-family: var(--font); font-size: 0.875rem; font-weight: 500; color: #EF4444; padding: 0.5rem 0.875rem; border-radius: var(--radius-sm); transition: all 0.2s; }
.nav-logout-btn:hover { background: #FEF2F2; }
@media (max-width: 768px) {
    .nav-toggle { display: block; }
    .nav-links {
        display: none;
        position: absolute;
        top: 68px;
        left: 0;
        right: 0;
        background: var(--white);
        border-bottom: 1px solid var(--border);
        flex-direction: column;
        padding: 0.75rem;
        gap: 0.25rem;
        box-shadow: var(--shadow-lg);
    }
    .nav-links.open { display: flex; }
    .nav-link, .nav-logout-btn { width: 100%; padding: 0.75rem 1rem; }
    .nav-divider { width: 100%; height: 1px; margin: 0.375rem 0; }
    .nav-logout-form { width: 100%; }
}
</style>

<script>
document.getElementById('navToggle')?.addEventListener('click', function() {
    const links = document.getElementById('navLinks');
    links.classList.toggle('open');
    const icon = document.getElementById('hamburgerIcon');
    if (links.classList.contains('open')) {
        icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
    } else {
        icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
    }
});
</script>
