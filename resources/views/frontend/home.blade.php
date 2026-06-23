@extends('frontend.layouts.app')

@section('title', 'Home')

@push('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .hero-wrap {
        position: relative;
        overflow: hidden;
        background: linear-gradient(165deg, #F0FDF4 0%, #FFFFFF 40%, #F8F9FA 100%);
    }
    .hero-wrap::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 600px 400px at 10% 20%, rgba(46,139,87,0.10) 0%, transparent 70%),
            radial-gradient(ellipse 500px 500px at 90% 80%, rgba(255,209,102,0.12) 0%, transparent 70%),
            radial-gradient(circle 300px at 50% 50%, rgba(46,139,87,0.04) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero {
        position: relative;
        max-width: 1280px;
        margin: 0 auto;
        padding: 5rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 4rem;
    }
    .hero-content { flex: 1; }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(46,139,87,0.10);
        color: #2E8B57;
        font-size: 0.8125rem;
        font-weight: 600;
        padding: 0.375rem 1rem;
        border-radius: 9999px;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(46,139,87,0.15);
        animation: fadeSlideUp 0.8s ease-out both;
    }
    .hero-badge .dot {
        width: 0.5rem;
        height: 0.5rem;
        background: #2E8B57;
        border-radius: 50%;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }
    .hero h1 {
        font-size: 3.25rem;
        font-weight: 800;
        color: #212529;
        line-height: 1.15;
        letter-spacing: -0.03em;
        margin-bottom: 1.25rem;
        animation: fadeSlideUp 0.8s ease-out 0.1s both;
    }
    .hero h1 .highlight {
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero p {
        font-size: 1.125rem;
        color: #6b7280;
        max-width: 32rem;
        line-height: 1.75;
        margin-bottom: 2rem;
        animation: fadeSlideUp 0.8s ease-out 0.2s both;
    }
    .hero-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        animation: fadeSlideUp 0.8s ease-out 0.3s both;
    }
    .hero .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #FFD166;
        color: #212529;
        padding: 0.875rem 2.25rem;
        border-radius: 0.625rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(255,209,102,0.35);
    }
    .hero .btn-primary:hover {
        background: #F0C14B;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255,209,102,0.45);
    }
    .hero .btn-primary svg { transition: transform 0.25s ease; }
    .hero .btn-primary:hover svg { transform: translateX(4px); }
    .hero .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #2E8B57;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        padding: 0.875rem 1.5rem;
        border-radius: 0.625rem;
        transition: all 0.25s ease;
        border: 2px solid #2E8B57;
    }
    .hero .btn-secondary:hover {
        background: #2E8B57;
        color: #ffffff;
        transform: translateY(-2px);
    }
    .hero-visual {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeSlideUp 0.8s ease-out 0.4s both;
    }
    .hero-card-decor {
        position: relative;
        width: 100%;
        max-width: 360px;
        aspect-ratio: 1;
    }
    .hero-card-decor .circle-1 {
        position: absolute;
        top: 10%;
        right: 10%;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(46,139,87,0.12), rgba(46,139,87,0.04));
        animation: float 6s ease-in-out infinite;
    }
    .hero-card-decor .circle-2 {
        position: absolute;
        bottom: 15%;
        left: 5%;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,209,102,0.10), rgba(255,209,102,0.03));
        animation: float 8s ease-in-out infinite reverse;
    }
    .hero-card-decor .card-float {
        position: absolute;
        background: #ffffff;
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: float 5s ease-in-out infinite;
    }
    .hero-card-decor .card-float:nth-child(3) {
        top: 5%;
        right: 0;
        animation-delay: 0s;
    }
    .hero-card-decor .card-float:nth-child(4) {
        bottom: 20%;
        left: 0;
        animation-delay: 1.5s;
    }
    .hero-card-decor .card-float .ic {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .hero-card-decor .card-float .ic.green { background: #E8F5E9; color: #2E8B57; }
    .hero-card-decor .card-float .ic.yellow { background: #FFF8E1; color: #FFD166; }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ─────────────── STATS ─────────────── */
    .stats-bar {
        background: #ffffff;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        padding: 2.5rem 1.5rem;
    }
    .stats-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
        text-align: center;
    }
    .stat-item .stat-num {
        font-size: 2rem;
        font-weight: 800;
        color: #2E8B57;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-item .stat-label {
        font-size: 0.8125rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* ─────────────── FEATURES ─────────────── */
    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }
    .section-title h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }
    .section-title p {
        color: #6b7280;
        max-width: 32rem;
        margin: 0 auto;
        font-size: 0.9375rem;
        line-height: 1.6;
    }
    .features-section {
        padding: 4.5rem 1.5rem;
        background: #FFFFFF;
    }
    .features-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .feature-card-mod {
        background: #F8F9FA;
        border: 1px solid #e9ecef;
        border-radius: 1rem;
        padding: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .feature-card-mod::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(46,139,87,0.04);
        transform: translate(30%, 30%);
        transition: all 0.3s ease;
    }
    .feature-card-mod:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06);
        border-color: #2E8B57;
    }
    .feature-card-mod:hover::after {
        width: 120px;
        height: 120px;
        background: rgba(46,139,87,0.08);
    }
    .feature-card-mod .ficon {
        width: 3rem;
        height: 3rem;
        background: #E8F5E9;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2E8B57;
        margin-bottom: 1.25rem;
        transition: transform 0.3s ease;
    }
    .feature-card-mod:hover .ficon { transform: scale(1.1) rotate(-5deg); }
    .feature-card-mod h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    .feature-card-mod p {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.6;
    }

    /* ─────────────── CTA ─────────────── */
    .cta-section {
        padding: 5rem 1.5rem;
        background: linear-gradient(135deg, #2E8B57 0%, #1B5E20 100%);
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle 400px at 20% 50%, rgba(255,255,255,0.06) 0%, transparent 70%),
            radial-gradient(circle 300px at 80% 30%, rgba(255,209,102,0.10) 0%, transparent 70%);
    }
    .cta-inner {
        max-width: 1280px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .cta-inner h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    .cta-inner p {
        color: rgba(255,255,255,0.85);
        max-width: 32rem;
        margin: 0 auto 2rem;
        font-size: 1rem;
        line-height: 1.6;
    }
    .cta-inner .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #FFD166;
        color: #212529;
        padding: 0.875rem 2.5rem;
        border-radius: 0.625rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }
    .cta-inner .btn-cta:hover {
        background: #F0C14B;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .cta-inner .btn-cta svg { transition: transform 0.25s ease; }
    .cta-inner .btn-cta:hover svg { transform: translateX(4px); }

    /* ─────────────── NEWSLETTER ─────────────── */
    .newsletter-section {
        padding: 4.5rem 1.5rem;
        background: #FFFFFF;
    }
    .newsletter-inner {
        max-width: 640px;
        margin: 0 auto;
        text-align: center;
    }
    .newsletter-inner h2 {
        font-size: 1.625rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.75rem;
    }
    .newsletter-inner p {
        color: #6b7280;
        font-size: 0.9375rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    .newsletter-form {
        display: flex;
        gap: 0.75rem;
        max-width: 480px;
        margin: 0 auto;
    }
    .newsletter-form input {
        flex: 1;
        padding: 0.8125rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 0.625rem;
        font-size: 0.9375rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #F8F9FA;
    }
    .newsletter-form input:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.10);
    }
    .newsletter-form button {
        background: #2E8B57;
        color: #ffffff;
        border: none;
        padding: 0.8125rem 1.5rem;
        border-radius: 0.625rem;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
    }
    .newsletter-form button:hover {
        background: #217645;
        transform: translateY(-1px);
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 1024px) {
        .hero { gap: 3rem; padding: 4rem 1.5rem; }
        .hero h1 { font-size: 2.75rem; }
    }
    @media (max-width: 768px) {
        .hero {
            flex-direction: column;
            text-align: center;
            padding: 2.5rem 1.25rem;
            gap: 2rem;
        }
        .hero h1 {
            font-size: 2.25rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1rem;
            margin-left: auto;
            margin-right: auto;
            max-width: 28rem;
        }
        .hero-actions {
            justify-content: center;
            flex-direction: column;
            align-items: stretch;
            max-width: 20rem;
            margin: 0 auto;
        }
        .hero .btn-primary,
        .hero .btn-secondary {
            justify-content: center;
            text-align: center;
        }
        .hero-card-decor { max-width: 220px; }
        .hero-card-decor .circle-1 { width: 180px; height: 180px; }
        .hero-card-decor .circle-2 { width: 110px; height: 110px; }
        .hero-card-decor .card-float { display: none; }
        .hero-visual { margin-top: 0.5rem; }

        .section-title { margin-bottom: 2rem; }
        .section-title h2 { font-size: 1.5rem; }
        .section-title p { font-size: 0.875rem; }

        .features-section { padding: 3rem 1.25rem; }
        .features-grid { gap: 1rem; }
        .feature-card-mod { padding: 1.5rem; }
        .feature-card-mod h3 { font-size: 1rem; }
        .feature-card-mod p { font-size: 0.8125rem; }

        .stats-bar { padding: 2rem 1.25rem; }
        .stats-inner {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .stat-item .stat-num { font-size: 1.75rem; }
        .stat-item .stat-label { font-size: 0.75rem; }

        .cta-section { padding: 3rem 1.25rem; }
        .cta-inner h2 { font-size: 1.5rem; }
        .cta-inner p { font-size: 0.875rem; }
        .cta-inner .btn-cta { width: 100%; justify-content: center; max-width: 20rem; }

        .newsletter-section { padding: 3rem 1.25rem; }
        .newsletter-inner h2 { font-size: 1.375rem; }
        .newsletter-inner p { font-size: 0.875rem; }
        .newsletter-form { flex-direction: column; max-width: 100%; }
        .newsletter-form input { text-align: center; }
        .newsletter-form button { width: 100%; }
    }
    @media (max-width: 480px) {
        .hero { padding: 2rem 1rem; gap: 1.5rem; }
        .hero h1 { font-size: 1.625rem; }
        .hero p { font-size: 0.875rem; }
        .hero .btn-primary,
        .hero .btn-secondary {
            width: 100%;
            justify-content: center;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
        }
        .hero-card-decor { max-width: 180px; }
        .hero-card-decor .circle-1 { width: 140px; height: 140px; }
        .hero-card-decor .circle-2 { width: 90px; height: 90px; }

        .stats-inner {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .stat-item .stat-num { font-size: 1.375rem; }
        .stat-item .stat-label { font-size: 0.6875rem; }

        .features-section { padding: 2.5rem 1rem; }
        .features-grid { grid-template-columns: 1fr; gap: 0.875rem; }

        .section-title h2 { font-size: 1.25rem; }
        .section-title p { font-size: 0.8125rem; }

        .cta-section { padding: 2.5rem 1rem; }
        .cta-inner h2 { font-size: 1.25rem; }
        .cta-inner p { font-size: 0.8125rem; }
        .cta-inner .btn-cta { font-size: 0.875rem; padding: 0.75rem 1.5rem; }

        .newsletter-section { padding: 2.5rem 1rem; }
        .newsletter-inner h2 { font-size: 1.125rem; }
    }
</style>
@endpush

@section('content')
    <!-- ════════ HERO ════════ -->
    <div class="hero-wrap">
        <div class="hero">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Premium Quality Since 2024
                </div>
                <h1>
                    Your <span class="highlight">Personal Care</span><br>
                    Destination Awaits
                </h1>
                <p>
                    Discover premium personal care and home care products curated
                    just for you. Quality you can trust, delivered to your doorstep.
                </p>
                <div class="hero-actions">
                    <a href="#" class="btn-primary">
                        Shop Now
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#" class="btn-secondary">
                        Track Order
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card-decor">
                    <div class="circle-1"></div>
                    <div class="circle-2"></div>
                    <div class="card-float" style="top: 5%; right: 0;">
                        <div class="ic green">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight:700; font-size:0.875rem; color:#212529;">100%</div>
                            <div style="font-size:0.75rem; color:#6b7280;">Satisfaction</div>
                        </div>
                    </div>
                    <div class="card-float" style="bottom: 20%; left: 0;">
                        <div class="ic yellow">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight:700; font-size:0.875rem; color:#212529;">Free</div>
                            <div style="font-size:0.75rem; color:#6b7280;">Delivery</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ════════ STATS ════════ -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="stat-num">1000+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">500+</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">50+</div>
                <div class="stat-label">Brands</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">99%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </div>



    <!-- ════════ FEATURES ════════ -->
    <div class="features-section">
        <div class="section-title">
            <h2>Why Choose Us</h2>
            <p>We go the extra mile to ensure you get the best shopping experience</p>
        </div>
        <div class="features-grid">
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <h3>Premium Quality</h3>
                <p>Handpicked products from trusted brands, ensuring only the best for your personal and home care needs.</p>
            </div>
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3>Lightning Fast Delivery</h3>
                <p>Quick and reliable shipping right to your doorstep. We ensure your order reaches you in perfect condition.</p>
            </div>
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3>Secure Payments</h3>
                <p>Your privacy and security are our top priorities. Shop with confidence knowing your data is protected.</p>
            </div>
            <div class="feature-card-mod">
                <div class="ficon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3>24/7 Support</h3>
                <p>Our dedicated support team is always here to help. Reach out anytime — we're just a message away.</p>
            </div>
        </div>
    </div>

    <!-- ════════ CTA ════════ -->
    <div class="cta-section">
        <div class="cta-inner">
            <h2>Ready to Elevate Your Self-Care?</h2>
            <p>Browse our collection and discover products that will transform your daily routine. Start shopping today!</p>
            <a href="#" class="btn-cta">
                Start Shopping
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- ════════ NEWSLETTER ════════ -->
    @php $s = settings(); @endphp
    @if($s && $s->newsletter_enabled)
    <div class="newsletter-section">
        <div class="newsletter-inner">
            <h2>{{ $s->newsletter_heading ?? 'Stay in the Loop' }}</h2>
            <p>{{ $s->newsletter_text ?? 'Subscribe to get notified about new products, exclusive offers, and care tips delivered to your inbox.' }}</p>
            <form class="newsletter-form" id="newsletterForm">
                <input type="email" id="newsletterEmail" placeholder="{{ $s->newsletter_placeholder ?? 'Enter your email address' }}" required>
                <button type="submit">{{ $s->newsletter_button_text ?? 'Subscribe' }}</button>
            </form>
        </div>
    </div>
    @endif
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('newsletterEmail').value.trim();
        if (!email) return;

        Swal.fire({
            title: 'Subscribed! 🎉',
            text: 'Thanks for subscribing! We\'ll keep you posted with the latest updates and offers.',
            icon: 'success',
            confirmButtonColor: '#2E8B57',
            confirmButtonText: 'Awesome!',
            background: '#ffffff',
            backdrop: 'rgba(46,139,87,0.15)',
            timer: 4000,
            timerProgressBar: true,
        });

        this.reset();
    });
</script>
@endpush
@endsection
