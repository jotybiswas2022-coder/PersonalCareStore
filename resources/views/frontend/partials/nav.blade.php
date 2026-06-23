<nav style="background: linear-gradient(135deg, #2E8B57 0%, #1B5E20 100%); padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px rgba(0,0,0,0.15); position: sticky; top: 0; z-index: 1000; min-height: 64px;">
    {{-- Logo + Hamburger row --}}
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        {{-- Hamburger (mobile) --}}
        <button id="navToggle" style="display: none; background: none; border: none; color: #ffffff; cursor: pointer; padding: 0.25rem;" aria-label="Toggle menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path id="hamburgerIcon" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 0.625rem; color: #ffffff; text-decoration: none; font-size: 1.375rem; font-weight: 800; letter-spacing: -0.03em;">
            <span style="width: 2rem; height: 2rem; background: #FFD166; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #212529; font-weight: 800; font-size: 1rem;">P</span>
            <span>PersonalCareStore</span>
        </a>
    </div>

    {{-- Mobile cart icon (visible only on mobile, always accessible) --}}
    <a href="#" class="mobile-cart" aria-label="View cart">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
        </svg>
        <span class="mobile-cart-badge">{{ $cartCount ?? 0 }}</span>
    </a>

    {{-- Desktop nav links --}}
    <div id="navLinks" style="display: flex; align-items: center; gap: 0.5rem;">
        <a href="#" style="color: rgba(255,255,255,0.85); text-decoration: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff'" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.85)'">Products</a>
        <a href="#" style="color: rgba(255,255,255,0.85); text-decoration: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s; display: flex; align-items: center; gap: 0.375rem; position: relative;" onmouseover="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff'" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.85)'">
            Cart
            <span style="background: #FFD166; color: #212529; font-size: 0.6875rem; font-weight: 700; padding: 0.0625rem 0.4375rem; border-radius: 9999px; min-width: 1.25rem; text-align: center;">{{ $cartCount ?? 0 }}</span>
        </a>
        <a href="#" style="color: rgba(255,255,255,0.85); text-decoration: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff'" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.85)'">Track Order</a>

        @auth
            <div class="nav-divider" style="width: 1px; height: 1.5rem; background: rgba(255,255,255,0.2); margin: 0 0.25rem;"></div>
            <a href="#" style="color: rgba(255,255,255,0.85); text-decoration: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff'" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.85)'">My Orders</a>
            <a href="{{ route('profile.edit') }}" style="color: rgba(255,255,255,0.85); text-decoration: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff'" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.85)'">Profile</a>
            @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" style="background: #FFD166; color: #212529; text-decoration: none; font-size: 0.8125rem; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.2s; box-shadow: 0 2px 8px rgba(255,209,102,0.3);" onmouseover="this.style.background='#F0C14B'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(255,209,102,0.4)'" onmouseout="this.style.background='#FFD166'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(255,209,102,0.3)'">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="vertical-align: middle; margin-right: 0.25rem;">
                        <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    Admin
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 0.25rem;">
                @csrf
                <button type="submit" style="background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.85); padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 500; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.color='#ffffff'" onmouseout="this.style.background='rgba(255,255,255,0.10)'; this.style.color='rgba(255,255,255,0.85)'">Logout</button>
            </form>
        @else
            <div class="nav-divider" style="width: 1px; height: 1.5rem; background: rgba(255,255,255,0.2); margin: 0 0.25rem;"></div>
            <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.85); text-decoration: none; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff'" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.85)'">Login</a>
            <a href="{{ route('register') }}" style="background: #FFD166; color: #212529; text-decoration: none; font-size: 0.8125rem; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.2s; box-shadow: 0 2px 8px rgba(255,209,102,0.3);" onmouseover="this.style.background='#F0C14B'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(255,209,102,0.4)'" onmouseout="this.style.background='#FFD166'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(255,209,102,0.3)'">Register</a>
        @endauth
    </div>
</nav>

<style>
    #navLinks { flex-wrap: wrap; }
    @media (max-width: 1024px) and (min-width: 769px) {
        #navLinks { gap: 0.25rem; }
        #navLinks a { padding: 0.5rem 0.625rem; font-size: 0.8125rem; }
    }
    /* Mobile cart icon (visible only on ≤768px) */
    .mobile-cart {
        display: none;
        position: relative;
        color: #ffffff;
        text-decoration: none;
        padding: 0.375rem;
    }
    .mobile-cart-badge {
        position: absolute;
        top: -2px;
        right: -4px;
        background: #FFD166;
        color: #212529;
        font-size: 0.625rem;
        font-weight: 700;
        min-width: 1.125rem;
        height: 1.125rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
        padding: 0 0.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    @media (max-width: 768px) {
        #navToggle { display: block !important; }
        .mobile-cart { display: inline-flex !important; }
        #navLinks {
            display: none !important;
            position: absolute;
            top: 64px;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, #1B5E20 0%, #2E8B57 100%);
            flex-direction: column;
            padding: 0.75rem;
            gap: 0.25rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        #navLinks.open { display: flex !important; }
        #navLinks a,
        #navLinks form { width: 100%; }
        #navLinks form button { width: 100%; }
        #navLinks a[href*="cart"] {
            display: none !important;
        }
        .nav-divider { display: none; }
        #navLinks a[style*="border-radius"] { text-align: center; }
    }
</style>

<script>
    document.getElementById('navToggle')?.addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('open');
        const icon = document.getElementById('hamburgerIcon');
        if (document.getElementById('navLinks').classList.contains('open')) {
            icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
        } else {
            icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
        }
    });
</script>
