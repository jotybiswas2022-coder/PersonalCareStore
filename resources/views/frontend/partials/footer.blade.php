@php $s = settings(); @endphp
<footer class="site-footer">
    {{-- Ambient glow + top rule --}}
    <div class="footer-rule" aria-hidden="true"></div>

    <div class="footer-inner">
        <div class="footer-grid">
            {{-- ══════ BRAND ══════ --}}
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo" aria-label="PersonalCareStore — Home">
                    <span class="footer-mark">P</span>
                    <span class="footer-name">PersonalCareStore</span>
                </a>

                <p class="footer-about">
                    Your trusted destination for premium personal care and home care products.
                    Quality you can trust, delivered with care.
                </p>

                <div class="footer-social">
                    <a href="#" aria-label="Facebook">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/></svg>
                    </a>
                </div>
            </div>

            {{-- ══════ QUICK LINKS ══════ --}}
            <nav class="footer-col" aria-label="Footer quick links">
                <h4 class="footer-title">Quick links</h4>
                <div class="footer-links">
                    <a href="{{ route('products.index') }}" class="footer-link">
                        Products
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="{{ route('cart.index') }}" class="footer-link">
                        Cart
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="{{ route('track-order.index') }}" class="footer-link">
                        Track order
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="footer-link">
                            My orders
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    @endauth
                </div>
            </nav>

            {{-- ══════ SUPPORT ══════ --}}
            <div class="footer-col">
                <h4 class="footer-title">Support</h4>
                <div class="footer-contact">
                    @if($s && $s->contact_phone)
                        <a href="tel:{{ $s->contact_phone }}" class="footer-contact-item">
                            <span class="f-ic">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0122 16.92z"/></svg>
                            </span>
                            <span>{{ $s->contact_phone }}</span>
                        </a>
                    @endif
                    @if($s && $s->contact_email)
                        <a href="mailto:{{ $s->contact_email }}" class="footer-contact-item">
                            <span class="f-ic">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <span>{{ $s->contact_email }}</span>
                        </a>
                    @endif
                    <a href="{{ route('contact.my-messages') }}" class="footer-contact-item">
                        <span class="f-ic">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </span>
                        <span>Contact / My Messages</span>
                    </a>
                    <a href="/privacy-policy" class="footer-contact-item">
                        <span class="f-ic">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </span>
                        <span>Privacy Policy</span>
                    </a>
                    @if($s && $s->contact_address)
                        <div class="footer-contact-item">
                            <span class="f-ic">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <span>{{ $s->contact_address }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ══════ HOURS ══════ --}}
            <div class="footer-col">
                <h4 class="footer-title">Business hours</h4>
                <div class="footer-hours">
                    <span class="f-ic">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    <div>
                        @if($s && $s->contact_hours)
                            {!! nl2br(e($s->contact_hours)) !!}
                        @else
                            Sat &ndash; Thu: 9 AM &ndash; 8 PM
                        @endif
                    </div>
                </div>
                <span class="footer-closed">
                    <span class="dot" aria-hidden="true"></span>
                    Friday: Closed
                </span>
            </div>
        </div>

        {{-- ══════ BOTTOM BAR ══════ --}}
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} PersonalCareStore. All rights reserved.</p>
            <div class="footer-legal">
                <a href="#">Privacy policy</a>
                <a href="#">Terms of service</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        --accent: #FFD166;
        --mint: #9DF3BE;
        --ease: cubic-bezier(0.22, 1, 0.36, 1);

        position: relative;
        isolation: isolate;
        overflow: hidden;
        margin-top: auto;
        color: rgba(226,245,232,0.6);
        background:
            radial-gradient(900px 420px at 88% -12%, rgba(46,139,87,0.30), transparent 70%),
            radial-gradient(620px 360px at 4% 112%, rgba(255,209,102,0.10), transparent 70%),
            linear-gradient(180deg, #07301E 0%, #062718 55%, #03190F 100%);
    }
    .site-footer::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.028) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.028) 1px, transparent 1px);
        background-size: 84px 84px;
        -webkit-mask-image: radial-gradient(circle at 50% 0%, #000 0%, transparent 82%);
        mask-image: radial-gradient(circle at 50% 0%, #000 0%, transparent 82%);
        pointer-events: none;
    }

    /* Shimmering accent rule */
    .footer-rule {
        height: 3px;
        background: linear-gradient(90deg, #FFD166 0%, #2E8B57 34%, #9DF3BE 62%, #FFD166 100%);
        background-size: 220% 100%;
        animation: footerShimmer 14s linear infinite;
    }

    .footer-inner {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        padding: 3.75rem 1.5rem 2rem;
    }

    /* ═══════ GRID ═══════ */
    .footer-grid {
        display: grid;
        grid-template-columns: 2.1fr 1fr 1.2fr 1.1fr;
        gap: 2.5rem;
    }

    /* ═══════ BRAND ═══════ */
    .footer-logo {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        margin-bottom: 1rem;
        color: #FFFFFF;
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.035em;
    }
    .footer-mark {
        width: 2.25rem;
        height: 2.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.625rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 1rem;
        font-weight: 800;
        box-shadow: 0 10px 22px -10px rgba(255,209,102,0.85), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.4s var(--ease);
    }
    .footer-logo:hover .footer-mark { transform: rotate(-8deg) scale(1.07); }
    .footer-logo:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 4px;
        border-radius: 0.5rem;
    }

    .footer-about {
        max-width: 24rem;
        margin-bottom: 1.375rem;
        font-size: 0.875rem;
        line-height: 1.75;
        color: rgba(226,245,232,0.58);
    }

    .footer-social {
        display: flex;
        gap: 0.5rem;
    }
    .footer-social a {
        width: 2.375rem;
        height: 2.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.05);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: rgba(233,247,238,0.7);
        text-decoration: none;
        transition: color 0.28s var(--ease), background 0.28s var(--ease),
                    border-color 0.28s var(--ease), transform 0.28s var(--ease), box-shadow 0.28s var(--ease);
    }
    .footer-social a:hover {
        color: #12261B;
        background: linear-gradient(135deg, #FFE08A, #FFD166 55%, #F5C14E);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px -12px rgba(255,209,102,0.95);
    }
    .footer-social a:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    /* ═══════ COLUMNS ═══════ */
    .footer-title {
        position: relative;
        margin-bottom: 1.25rem;
        padding-bottom: 0.625rem;
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #FFFFFF;
    }
    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 1.75rem;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, #FFD166, #9DF3BE);
        transition: width 0.4s var(--ease);
    }
    .footer-col:hover .footer-title::after { width: 2.75rem; }

    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 0.1875rem;
    }
    .footer-link {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        width: fit-content;
        padding: 0.3125rem 0;
        font-size: 0.875rem;
        color: rgba(226,245,232,0.6);
        text-decoration: none;
        transition: color 0.25s var(--ease), transform 0.25s var(--ease);
    }
    .footer-link svg {
        opacity: 0;
        transform: translateX(-6px);
        transition: opacity 0.25s var(--ease), transform 0.25s var(--ease);
    }
    .footer-link:hover {
        color: #FFFFFF;
        transform: translateX(3px);
    }
    .footer-link:hover svg {
        opacity: 1;
        transform: translateX(0);
        color: var(--accent);
    }
    .footer-link:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 3px;
        border-radius: 0.25rem;
    }

    /* ═══════ CONTACT ═══════ */
    .footer-contact {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        font-size: 0.875rem;
        line-height: 1.55;
        color: rgba(226,245,232,0.6);
        text-decoration: none;
        transition: color 0.25s var(--ease);
    }
    .footer-contact-item .f-ic {
        width: 1.75rem;
        height: 1.75rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.05);
        color: var(--mint);
        transition: border-color 0.25s var(--ease), background 0.25s var(--ease);
    }
    a.footer-contact-item:hover { color: #FFFFFF; }
    a.footer-contact-item:hover .f-ic {
        border-color: rgba(157,243,190,0.35);
        background: rgba(123,241,168,0.10);
    }

    /* ═══════ HOURS ═══════ */
    .footer-hours {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.75rem 0.875rem;
        border-radius: 0.875rem;
        border: 1px solid rgba(255,255,255,0.10);
        background: rgba(255,255,255,0.045);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        font-size: 0.8125rem;
        line-height: 1.65;
        color: rgba(233,247,238,0.75);
    }
    .footer-hours .f-ic {
        width: 1.75rem;
        height: 1.75rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: rgba(123,241,168,0.10);
        border: 1px solid rgba(123,241,168,0.18);
        color: var(--mint);
    }
    .footer-closed {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.75rem;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        background: rgba(255,209,102,0.10);
        border: 1px solid rgba(255,209,102,0.22);
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: #FFE6A8;
    }
    .footer-closed .dot {
        width: 0.375rem;
        height: 0.375rem;
        border-radius: 50%;
        background: var(--accent);
        box-shadow: 0 0 0 3px rgba(255,209,102,0.16);
    }

    /* ═══════ BOTTOM ═══════ */
    .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.08);
    }
    .footer-bottom p {
        font-size: 0.8125rem;
        color: rgba(226,245,232,0.38);
    }
    .footer-legal {
        display: flex;
        gap: 1.375rem;
    }
    .footer-legal a {
        font-size: 0.8125rem;
        color: rgba(226,245,232,0.42);
        text-decoration: none;
        transition: color 0.25s var(--ease);
    }
    .footer-legal a:hover {
        color: #FFFFFF;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .footer-legal a:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 3px;
        border-radius: 0.25rem;
    }

    /* ═══════ RESPONSIVE ═══════ */
    @media (max-width: 1024px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2.25rem;
        }
        .footer-brand { grid-column: 1 / -1; }
        .footer-about { max-width: 32rem; }
    }
    /* ═══════ MOBILE: compact footer ═══════ */
    @media (max-width: 640px) {
        .footer-inner { padding: 2.25rem 1.125rem 1.5rem; }
        .footer-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .footer-brand {
            grid-column: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .footer-logo { margin-bottom: 0; }
        .footer-about { display: none; }
        .footer-social { margin-top: 0; gap: 0.375rem; }
        .footer-social a {
            width: 2.125rem;
            height: 2.125rem;
            border-radius: 0.625rem;
        }

        .footer-title {
            margin-bottom: 0.75rem;
            padding-bottom: 0.4375rem;
            font-size: 0.625rem;
            letter-spacing: 0.14em;
        }
        .footer-title::after { width: 1.25rem; }

        /* Links become a single wrapping row of pills */
        .footer-links {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 0.4375rem;
        }
        .footer-link {
            padding: 0.4375rem 0.8125rem;
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 9999px;
            background: rgba(255,255,255,0.04);
            font-size: 0.8125rem;
        }
        .footer-link svg { display: none; }
        .footer-link:hover {
            transform: none;
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.26);
        }

        /* Contact lines stay readable but tighten up */
        .footer-contact { gap: 0.4375rem; }
        .footer-contact-item {
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }
        .footer-contact-item .f-ic {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 0.4375rem;
        }

        .footer-hours {
            align-items: center;
            padding: 0.5625rem 0.75rem;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }
        .footer-hours .f-ic { width: 1.5rem; height: 1.5rem; }
        .footer-closed { margin-top: 0.5rem; padding: 0.1875rem 0.5rem; font-size: 0.625rem; }

        .footer-bottom {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            margin-top: 1.5rem;
            padding-top: 1.125rem;
        }
        .footer-bottom p { font-size: 0.75rem; }
        .footer-legal { gap: 1rem; }
        .footer-legal a { font-size: 0.75rem; }
    }

    /* ═══════ ANIMATION ═══════ */
    @keyframes footerShimmer {
        0% { background-position: 0% 50%; }
        100% { background-position: 220% 50%; }
    }

    @media (prefers-reduced-motion: reduce) {
        .footer-rule { animation: none; }
        .footer-mark,
        .footer-social a,
        .footer-title::after,
        .footer-link,
        .footer-link svg,
        .footer-contact-item,
        .footer-contact-item .f-ic,
        .footer-legal a {
            transition: none !important;
        }
    }
</style>
