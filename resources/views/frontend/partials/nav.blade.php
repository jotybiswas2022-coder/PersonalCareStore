<header class="site-nav" id="siteNav">
    <div class="nav-inner">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo" aria-label="PersonalCareStore — Home">
            <span class="nav-logo-mark">P</span>
            <span class="nav-logo-text">PersonalCareStore</span>
        </a>

        {{-- Primary navigation (collapses into a panel on mobile) --}}
        <nav class="nav-menu" id="navLinks" aria-label="Main navigation">
            <div class="nav-links">
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'is-active' : '' }}"
                   @if(request()->routeIs('products.*')) aria-current="page" @endif>Products</a>
                <a href="{{ route('track-order.index') }}" class="nav-link {{ request()->routeIs('track-order.*') ? 'is-active' : '' }}"
                   @if(request()->routeIs('track-order.*')) aria-current="page" @endif>Track Order</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'is-active' : '' }}"
                       @if(request()->routeIs('orders.*')) aria-current="page" @endif>My Orders</a>
                @endauth
            </div>

            <div class="nav-actions">
                <a href="{{ route('cart.index') }}" class="nav-cart {{ request()->routeIs('cart.*') ? 'is-active' : '' }}"
                   aria-label="Cart, {{ $cartCount }} {{ Str::plural('item', $cartCount) }}">
                    <span class="nav-cart-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                        </svg>
                        <span class="nav-cart-badge">{{ $cartCount }}</span>
                    </span>
                    <span class="nav-cart-text">Cart</span>
                </a>

                @auth
                    <details class="nav-user">
                        <summary class="nav-user-btn" aria-label="Account menu">
                            <span class="nav-avatar">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="nav-user-name">{{ Auth::user()->name }}</span>
                            <svg class="nav-chevron" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </summary>

                        <div class="nav-dropdown">
                            <div class="nav-dropdown-head">
                                <span class="nav-dropdown-name">{{ Auth::user()->name }}</span>
                                <span class="nav-dropdown-mail">{{ Auth::user()->email }}</span>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profile
                            </a>
                            <a href="{{ route('orders.index') }}" class="nav-dropdown-item">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M9 12h6M9 16h6"/></svg>
                                My Orders
                            </a>
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="nav-dropdown-item is-admin">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                                    Admin dashboard
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="nav-dropdown-form">
                                @csrf
                                <button type="submit" class="nav-dropdown-item is-danger">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </details>
                @else
                    <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Sign in</a>
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-accent">
                        Register
                        <svg class="nav-btn-arrow" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m0 0l-6-6m6 6l-6 6"/></svg>
                    </a>
                @endauth
            </div>
        </nav>

        {{-- Mobile-only cart shortcut --}}
        <a href="{{ route('cart.index') }}" class="nav-cart-mobile" aria-label="Cart, {{ $cartCount }} {{ Str::plural('item', $cartCount) }}">
            <svg width="21" height="21" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
            </svg>
            <span class="nav-cart-badge">{{ $cartCount }}</span>
        </a>

        {{-- Mobile menu toggle --}}
        <button type="button" class="nav-toggle" id="navToggle" aria-label="Open menu" aria-controls="navLinks" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<style>
    /* ═══════════════ SHELL (home hero palette) ═══════════════ */
    .site-nav {
        --nav-h: 64px;
        --accent: #FFD166;
        --accent-deep: #F5C14E;
        --mint: #9DF3BE;
        --ink: #12261B;
        --ease: cubic-bezier(0.22, 1, 0.36, 1);

        position: sticky;
        top: 0;
        z-index: 1000;
        background:
            radial-gradient(900px 220px at 86% -60%, rgba(46,139,87,0.42), transparent 68%),
            radial-gradient(520px 180px at 8% 160%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 12px 32px -22px rgba(3,25,15,0.95);
        transition: box-shadow 0.35s var(--ease);
    }
    .site-nav::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(3,25,15,0.42), rgba(3,25,15,0.06));
        opacity: 0;
        transition: opacity 0.35s ease;
        pointer-events: none;
    }
    .site-nav.is-scrolled {
        box-shadow: 0 18px 42px -20px rgba(0,0,0,0.85);
    }
    .site-nav.is-scrolled::after { opacity: 1; }

    .nav-inner {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        min-height: var(--nav-h);
        margin: 0 auto;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* ═══════════════ LOGO ═══════════════ */
    .nav-logo {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        color: #FFFFFF;
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.035em;
        white-space: nowrap;
        animation: navIn 0.6s var(--ease) both;
    }
    .nav-logo-mark {
        width: 2rem; height: 2rem;
        display: flex; align-items: center; justify-content: center;
        border-radius: 0.625rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: var(--ink);
        font-weight: 800;
        font-size: 1rem;
        box-shadow: 0 10px 22px -10px rgba(255,209,102,0.85), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.4s var(--ease), box-shadow 0.3s ease;
    }
    .nav-logo:hover .nav-logo-mark {
        transform: rotate(-8deg) scale(1.08);
        box-shadow: 0 14px 26px -10px rgba(255,209,102,0.95), inset 0 1px 0 rgba(255,255,255,0.7);
    }
    .nav-logo:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 4px;
        border-radius: 0.5rem;
    }

    /* ═══════════════ LINKS ═══════════════ */
    .nav-menu {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-left: auto;
    }
    .nav-links {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .nav-link {
        position: relative;
        color: rgba(233,247,238,0.72);
        text-decoration: none;
        padding: 0.5rem 0.875rem;
        border: 1px solid transparent;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        letter-spacing: -0.005em;
        white-space: nowrap;
        transition: color 0.28s var(--ease), background 0.28s var(--ease), border-color 0.28s var(--ease);
        animation: navIn 0.6s var(--ease) both;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        left: 0.875rem;
        right: 0.875rem;
        bottom: 0.1875rem;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, #FFEFC2 0%, #FFD166 48%, #9DF3BE 100%);
        transform: scaleX(0);
        transform-origin: left center;
        transition: transform 0.42s var(--ease);
    }
    .nav-link:nth-child(1) { animation-delay: 0.04s; }
    .nav-link:nth-child(2) { animation-delay: 0.09s; }
    .nav-link:nth-child(3) { animation-delay: 0.14s; }

    .nav-link:hover {
        color: #FFFFFF;
        background: rgba(255,255,255,0.07);
        border-color: rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
    }
    .nav-link:hover::after { transform: scaleX(1); }
    .nav-link.is-active {
        color: #FFFFFF;
        font-weight: 600;
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,255,255,0.16);
    }
    .nav-link.is-active::after { transform: scaleX(1); }
    .nav-link:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    /* ═══════════════ ACTIONS ═══════════════ */
    .nav-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: navIn 0.6s var(--ease) 0.16s both;
    }

    /* Cart — glass pill */
    .nav-cart {
        display: inline-flex;
        align-items: center;
        gap: 0.4375rem;
        color: rgba(233,247,238,0.82);
        text-decoration: none;
        padding: 0.4375rem 0.875rem 0.4375rem 0.75rem;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 9999px;
        background: rgba(255,255,255,0.05);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        font-size: 0.8125rem;
        font-weight: 600;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease), color 0.28s var(--ease);
    }
    .nav-cart:hover,
    .nav-cart.is-active {
        color: #FFFFFF;
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.24);
    }
    .nav-cart-icon {
        position: relative;
        display: inline-flex;
        transition: transform 0.4s var(--ease);
    }
    .nav-cart:hover .nav-cart-icon { transform: translateY(-1px) scale(1.08); }
    .nav-cart-badge {
        position: absolute;
        top: -0.4375rem;
        right: -0.5625rem;
        min-width: 1.125rem;
        height: 1.125rem;
        padding: 0 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: var(--ink);
        font-size: 0.625rem;
        font-weight: 800;
        line-height: 1;
        border-radius: 9999px;
        box-shadow: 0 4px 10px -4px rgba(255,209,102,0.9);
        animation: navBadgePop 0.5s var(--ease) both;
    }

    /* Buttons */
    .nav-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4375rem;
        padding: 0.5625rem 1.125rem;
        border-radius: 0.75rem;
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease),
                    color 0.28s var(--ease), transform 0.28s var(--ease), box-shadow 0.28s var(--ease);
    }
    .nav-btn-ghost {
        color: #EAF8EF;
        border: 1px solid rgba(255,255,255,0.22);
        background: rgba(255,255,255,0.05);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
    }
    .nav-btn-ghost:hover {
        color: #FFFFFF;
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.34);
        transform: translateY(-2px);
    }
    .nav-btn-accent {
        color: var(--ink);
        font-weight: 700;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        box-shadow: 0 14px 34px -16px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
    }
    .nav-btn-accent::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.75) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.75s var(--ease);
        pointer-events: none;
    }
    .nav-btn-accent:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 38px -18px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .nav-btn-accent:hover::after { transform: translateX(420%) rotate(12deg); }
    .nav-btn-accent:active { transform: translateY(0); }
    .nav-btn-arrow { transition: transform 0.3s var(--ease); }
    .nav-btn-accent:hover .nav-btn-arrow { transform: translateX(3px); }
    .nav-btn:focus-visible { outline: 2px solid var(--accent); outline-offset: 3px; }

    /* ═══════════════ ACCOUNT DROPDOWN ═══════════════ */
    .nav-user { position: relative; }
    .nav-user > summary {
        list-style: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3125rem 0.5rem 0.3125rem 0.3125rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: #F2FBF5;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease);
    }
    .nav-user > summary::-webkit-details-marker { display: none; }
    .nav-user > summary:hover,
    .nav-user[open] > summary {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.24);
    }
    .nav-user > summary:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }
    .nav-avatar {
        width: 1.75rem; height: 1.75rem;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #BFF3D2, #7BD9A1);
        color: #0A2C1C;
        font-size: 0.8125rem;
        font-weight: 800;
    }
    .nav-user-name {
        max-width: 8rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #EAF8EF;
    }
    .nav-chevron {
        color: rgba(233,247,238,0.7);
        transition: transform 0.3s var(--ease);
    }
    .nav-user[open] .nav-chevron { transform: rotate(180deg); }

    .nav-dropdown {
        position: absolute;
        top: calc(100% + 0.75rem);
        right: 0;
        min-width: 15.5rem;
        padding: 0.5rem;
        background: #FFFFFF;
        border: 1px solid #E4EEE8;
        border-radius: 1rem;
        box-shadow: 0 34px 60px -30px rgba(3,25,15,0.55), 0 3px 10px rgba(3,25,15,0.08);
        transform-origin: top right;
        animation: navDropIn 0.22s var(--ease) both;
        z-index: 20;
    }
    .nav-dropdown::before {
        content: '';
        position: absolute;
        top: -0.375rem;
        right: 1.5rem;
        width: 0.75rem; height: 0.75rem;
        background: #FFFFFF;
        border-left: 1px solid #E4EEE8;
        border-top: 1px solid #E4EEE8;
        transform: rotate(45deg);
        border-radius: 2px 0 0 0;
    }
    .nav-dropdown-head {
        padding: 0.5rem 0.625rem 0.625rem;
        margin-bottom: 0.375rem;
        border-bottom: 1px solid #EDF3EF;
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }
    .nav-dropdown-name {
        font-size: 0.8125rem;
        font-weight: 700;
        color: #10261A;
        letter-spacing: -0.01em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .nav-dropdown-mail {
        font-size: 0.75rem;
        color: #617067;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .nav-dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.5625rem 0.625rem;
        border: none;
        background: none;
        border-radius: 0.625rem;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #374151;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.22s var(--ease), color 0.22s var(--ease);
    }
    .nav-dropdown-item svg { flex-shrink: 0; opacity: 0.75; }
    .nav-dropdown-item:hover {
        background: #EDF9F2;
        color: #17603C;
    }
    .nav-dropdown-item.is-admin { color: #8A5B00; }
    .nav-dropdown-item.is-admin:hover { background: #FFF8E6; color: #6B4700; }
    .nav-dropdown-item.is-danger { color: #B91C1C; }
    .nav-dropdown-item.is-danger:hover { background: #FEF2F2; color: #991B1B; }
    .nav-dropdown-form { margin: 0; }

    /* ═══════════════ MOBILE CART + TOGGLE ═══════════════ */
    .nav-cart-mobile {
        display: none;
        position: relative;
        margin-left: auto;
        padding: 0.5rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.05);
        color: #F2FBF5;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease);
    }
    .nav-cart-mobile:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.24);
    }

    .nav-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        gap: 4px;
        width: 2.375rem;
        height: 2.375rem;
        padding: 0 0.375rem;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 0.75rem;
        cursor: pointer;
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease);
    }
    .nav-toggle:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.24);
    }
    .nav-toggle:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
    .nav-toggle span {
        display: block;
        height: 2px;
        width: 100%;
        border-radius: 2px;
        background: #FFFFFF;
        transition: transform 0.4s var(--ease), opacity 0.2s ease;
    }
    .nav-toggle.is-open span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
    .nav-toggle.is-open span:nth-child(2) { opacity: 0; transform: scaleX(0.4); }
    .nav-toggle.is-open span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

    /* ═══════════════ MOBILE PANEL ═══════════════ */
    @media (max-width: 900px) {
        .nav-inner { padding: 0 1.25rem; gap: 0.5rem; }
        .nav-logo { font-size: 1.0625rem; }
        .nav-cart-mobile { display: inline-flex; }
        .nav-toggle { display: flex; }

        .nav-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin: 0;
            display: none;
            flex-direction: column;
            align-items: stretch;
            gap: 0.25rem;
            padding: 0.875rem;
            background:
                radial-gradient(600px 200px at 88% -10%, rgba(46,139,87,0.4), transparent 70%),
                linear-gradient(180deg, #07301E 0%, #03190F 100%);
            border-top: 1px solid rgba(255,255,255,0.10);
            box-shadow: 0 30px 50px -20px rgba(0,0,0,0.85);
            max-height: calc(100vh - var(--nav-h));
            overflow-y: auto;
        }
        .nav-menu.is-open {
            display: flex;
            animation: navPanelDrop 0.32s var(--ease) both;
        }

        .nav-links,
        .nav-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 0.25rem;
            width: 100%;
        }
        .nav-link {
            padding: 0.6875rem 0.875rem;
            border-radius: 0.75rem;
        }
        .nav-link::after {
            left: 0.5rem;
            top: 50%;
            bottom: auto;
            width: 3px;
            height: 1.125rem;
            margin-top: -0.5625rem;
            border-radius: 2px;
            background: linear-gradient(180deg, #FFD166, #9DF3BE);
            transform: scaleY(0);
            transform-origin: center top;
        }
        .nav-link:hover::after,
        .nav-link.is-active::after { transform: scaleY(1); }

        .nav-actions {
            margin-top: 0.5rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.10);
        }
        .nav-actions .nav-cart { display: none; }
        .nav-btn { width: 100%; padding: 0.6875rem 1rem; border-radius: 0.75rem; }

        .nav-user { width: 100%; }
        .nav-user > summary { width: 100%; border-radius: 0.75rem; padding: 0.4375rem 0.625rem 0.4375rem 0.4375rem; }
        .nav-user-name { max-width: none; margin-right: auto; }
        .nav-dropdown {
            position: static;
            width: 100%;
            margin-top: 0.375rem;
            animation: none;
            box-shadow: none;
            border-color: rgba(255,255,255,0.10);
        }
        .nav-dropdown::before { display: none; }

        /* Staggered item entrance */
        .nav-menu.is-open .nav-link,
        .nav-menu.is-open .nav-btn,
        .nav-menu.is-open .nav-user {
            animation: navItemIn 0.36s var(--ease) both;
        }
        .nav-menu.is-open .nav-link:nth-child(1) { animation-delay: 0.04s; }
        .nav-menu.is-open .nav-link:nth-child(2) { animation-delay: 0.09s; }
        .nav-menu.is-open .nav-link:nth-child(3) { animation-delay: 0.14s; }
        .nav-menu.is-open .nav-btn:nth-child(1) { animation-delay: 0.19s; }
        .nav-menu.is-open .nav-btn:nth-child(2) { animation-delay: 0.24s; }
        .nav-menu.is-open .nav-user { animation-delay: 0.19s; }
    }
    @media (max-width: 420px) {
        .nav-logo-text { font-size: 0.9375rem; }
        .nav-inner { padding: 0 1rem; }
    }

    /* ═══════════════ KEYFRAMES ═══════════════ */
    @keyframes navIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes navBadgePop {
        0% { transform: scale(0.3); opacity: 0; }
        60% { transform: scale(1.15); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes navDropIn {
        from { opacity: 0; transform: translateY(-8px) scale(0.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes navPanelDrop {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes navItemIn {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        .site-nav,
        .site-nav::after,
        .nav-link,
        .nav-link::after,
        .nav-cart,
        .nav-cart-icon,
        .nav-btn,
        .nav-btn::after,
        .nav-btn-arrow,
        .nav-toggle span,
        .nav-chevron,
        .nav-logo-mark,
        .nav-dropdown-item {
            transition: none !important;
        }
        .nav-logo,
        .nav-link,
        .nav-actions,
        .nav-cart-badge,
        .nav-menu.is-open,
        .nav-menu.is-open .nav-link,
        .nav-menu.is-open .nav-btn,
        .nav-menu.is-open .nav-user,
        .nav-dropdown {
            animation: none !important;
        }
    }
</style>

<script>
    (function () {
        var nav = document.getElementById('siteNav');
        var toggle = document.getElementById('navToggle');
        var menu = document.getElementById('navLinks');
        if (!nav || !toggle || !menu) return;

        function setMenu(open) {
            menu.classList.toggle('is-open', open);
            toggle.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        }

        toggle.addEventListener('click', function () {
            setMenu(!menu.classList.contains('is-open'));
        });

        function closeAccountMenus(except) {
            document.querySelectorAll('.nav-user[open]').forEach(function (item) {
                if (item !== except) item.removeAttribute('open');
            });
        }

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.nav-user')) closeAccountMenus(null);
            if (menu.classList.contains('is-open') &&
                !event.target.closest('#navLinks') &&
                !event.target.closest('#navToggle')) {
                setMenu(false);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') return;
            if (menu.classList.contains('is-open')) {
                setMenu(false);
                toggle.focus();
            }
            closeAccountMenus(null);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 900) setMenu(false);
        });

        // Deepen the bar once the page scrolls away from the top.
        var ticking = false;
        function syncScrollState() {
            nav.classList.toggle('is-scrolled', window.scrollY > 8);
            ticking = false;
        }
        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(syncScrollState);
        }, { passive: true });
        syncScrollState();
    })();
</script>
