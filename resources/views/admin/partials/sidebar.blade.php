{{-- Mobile Toggle Button --}}
<button class="sb-toggle" id="sbToggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
</button>

{{-- Mobile Overlay --}}
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

<aside class="sb-wrap" id="sbWrap">
    {{-- Logo / Brand --}}
    <div class="sb-brand">
        <span class="sb-logo">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </span>
        <span class="sb-title">Admin Panel</span>
        <button class="sb-close-btn" id="sbCloseBtn" onclick="closeSidebar()" aria-label="Close sidebar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Main Navigation --}}
    <nav class="sb-nav">
        <div class="sb-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.dashboard') ? 'rgba(99,102,241,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.dashboard') ? '#818cf8' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </span>
            <span class="sb-item-text">Dashboard</span>
        </a>

        <div class="sb-label">Shop</div>
        <a href="{{ route('admin.orders.index') }}" class="sb-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.orders.*') ? 'rgba(59,130,246,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.orders.*') ? '#60a5fa' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </span>
            <span class="sb-item-text">Orders</span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="sb-item {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.products.*') ? 'rgba(139,92,246,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.products.*') ? '#a78bfa' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <span class="sb-item-text">Products</span>
        </a>

        <a href="{{ route('admin.products.create') }}" class="sb-item sb-sub {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.products.create') ? 'rgba(139,92,246,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.products.create') ? '#a78bfa' : '#6b7280' }};">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </span>
            <span class="sb-item-text">Add Product</span>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="sb-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.categories.*') ? 'rgba(245,158,11,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.categories.*') ? '#fbbf24' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </span>
            <span class="sb-item-text">Categories</span>
        </a>

        <div class="sb-label">Engage</div>
        <a href="{{ route('admin.reviews.index') }}" class="sb-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.reviews.*') ? 'rgba(236,72,153,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.reviews.*') ? '#f472b6' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </span>
            <span class="sb-item-text">Reviews</span>
        </a>

        <a href="{{ route('admin.messages.index') }}" class="sb-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.messages.*') ? 'rgba(16,185,129,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.messages.*') ? '#34d399' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </span>
            <span class="sb-item-text">Messages</span>
        </a>

        <div class="sb-label">Finance</div>
        <a href="{{ route('admin.profit-loss.index') }}" class="sb-item {{ request()->routeIs('admin.profit-loss.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.profit-loss.*') ? 'rgba(16,185,129,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.profit-loss.*') ? '#34d399' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </span>
            <span class="sb-item-text">Profit / Loss</span>
        </a>

        <a href="{{ route('admin.payment-details.index') }}" class="sb-item {{ request()->routeIs('admin.payment-details.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.payment-details.*') ? 'rgba(59,130,246,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.payment-details.*') ? '#60a5fa' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </span>
            <span class="sb-item-text">Payment Details</span>
        </a>

        <div class="sb-label">Config</div>
        <a href="{{ route('admin.contact-setting.index') }}" class="sb-item {{ request()->routeIs('admin.contact-setting.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.contact-setting.*') ? 'rgba(245,158,11,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.contact-setting.*') ? '#fbbf24' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </span>
            <span class="sb-item-text">Contact Us</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="sb-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="sb-item-icon" style="background:{{ request()->routeIs('admin.settings.*') ? 'rgba(99,102,241,0.2)' : 'transparent' }};color:{{ request()->routeIs('admin.settings.*') ? '#818cf8' : '#9ca3af' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            </span>
            <span class="sb-item-text">Settings</span>
        </a>
    </nav>

    {{-- Bottom Section --}}
    <div class="sb-footer">
        <a href="{{ route('home') }}" class="sb-item sb-store-link">
            <span class="sb-item-icon" style="color:#34d399;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </span>
            <span class="sb-item-text">Visit Store</span>
        </a>
    </div>
</aside>

<style>
/* ── Mobile Toggle Button ── */
.sb-toggle {
    display: none;
    position: fixed;
    top: 0.75rem;
    right: 0.75rem;
    z-index: 50;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    border: none;
    background: #1e293b;
    color: #e2e8f0;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: all 0.2s;
}
.sb-toggle:hover { background: #334155; }
.sb-toggle:active { transform: scale(0.95); }

/* ── Mobile Overlay ── */
.sb-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 38;
    backdrop-filter: blur(2px);
}
.sb-overlay.open { display: block; }

/* ── Sidebar Wrapper ── */
.sb-wrap {
    width: 250px;
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
    color: #fff;
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    z-index: 40;
    scrollbar-width: thin;
    scrollbar-color: #334155 transparent;
    transition: transform 0.25s ease;
}
.sb-wrap::-webkit-scrollbar { width: 4px; }
.sb-wrap::-webkit-scrollbar-track { background: transparent; }
.sb-wrap::-webkit-scrollbar-thumb { background: #334155; border-radius: 2px; }

/* ── Brand ── */
.sb-brand {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 1.25rem 1.125rem 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    flex-shrink: 0;
}
.sb-logo {
    width: 2rem;
    height: 2rem;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.875rem;
    flex-shrink: 0;
}
.sb-title {
    font-size: 1rem;
    font-weight: 700;
    letter-spacing: -0.01em;
}
.sb-close-btn {
    display: none;
    margin-left: auto;
    width: 1.75rem;
    height: 1.75rem;
    border-radius: 0.375rem;
    border: none;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.6);
    cursor: pointer;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.sb-close-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }

/* ── Navigation ── */
.sb-nav {
    padding: 0.5rem 0.75rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1px;
}

.sb-label {
    font-size: 0.6rem;
    font-weight: 700;
    color: rgba(255,255,255,0.25);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.75rem 0.625rem 0.375rem;
    margin-top: 0.25rem;
}
.sb-label:first-child { margin-top: 0; }

/* ── Menu Item ── */
.sb-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 0.625rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-size: 0.825rem;
    font-weight: 500;
    color: #94a3b8;
    transition: all 0.2s ease;
    position: relative;
}
.sb-item:hover {
    background: rgba(255,255,255,0.06);
    color: #e2e8f0;
}
.sb-item.active {
    background: rgba(99,102,241,0.1);
    color: #e0e7ff;
}
.sb-item.active::before {
    content: '';
    position: absolute;
    left: -0.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 1.25rem;
    background: #818cf8;
    border-radius: 0 2px 2px 0;
}

/* Sub-item (Add Product) */
.sb-item.sb-sub {
    padding-left: 2.375rem;
    font-size: 0.8rem;
}
.sb-item.sb-sub .sb-item-icon { width: 1.25rem; height: 1.25rem; font-size: 0.7rem; }
.sb-item.sb-sub.active { color: #c4b5fd; }
.sb-item.sb-sub.active::before { height: 0.875rem; }

/* Icon */
.sb-item-icon {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
}
.sb-item:hover .sb-item-icon {
    background: rgba(255,255,255,0.08) !important;
}

/* Badge */
.sb-badge {
    margin-left: auto;
    font-size: 0.6rem;
    font-weight: 700;
    padding: 0.125rem 0.425rem;
    border-radius: 9999px;
    background: rgba(59,130,246,0.2);
    color: #60a5fa;
    line-height: 1.3;
}
.sb-badge-msg {
    background: rgba(16,185,129,0.2);
    color: #34d399;
}

/* ── Store Link ── */
.sb-footer {
    padding: 0.75rem;
    border-top: 1px solid rgba(255,255,255,0.06);
    flex-shrink: 0;
}
.sb-store-link {
    color: #6ee7b7 !important;
    font-weight: 600;
}
.sb-store-link:hover {
    background: rgba(16,185,129,0.1) !important;
    color: #34d399 !important;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .sb-toggle { display: flex; }
    .sb-close-btn { display: flex; }
    .sb-overlay.open { display: block; }
    .sb-wrap {
        width: 280px;
        position: fixed;
        min-height: 100vh;
        transform: translateX(-100%);
        z-index: 39;
    }
    .sb-wrap.open { transform: translateX(0); }
    .sb-nav { padding-bottom: 1rem; }
    .sb-item.active::before { display: none; }
}
</style>

<script>
function toggleSidebar() {
    document.getElementById('sbWrap').classList.toggle('open');
    document.getElementById('sbOverlay').classList.toggle('open');
}
function closeSidebar() {
    document.getElementById('sbWrap').classList.remove('open');
    document.getElementById('sbOverlay').classList.remove('open');
}

// Close sidebar when a nav link is clicked (mobile only)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sb-nav .sb-item, .sb-footer .sb-item').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });

    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });
});
</script>
