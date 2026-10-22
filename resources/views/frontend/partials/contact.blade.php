@php $s = settings(); @endphp
<style>
    .contact-section {
        position: relative;
        overflow: hidden;
        padding: 5rem 1.5rem 5.5rem;
        background: #F6FAF7;
    }
    .contact-section::before {
        content: '';
        position: absolute;
        top: -18%;
        right: -8%;
        width: 560px;
        height: 560px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46,139,87,0.08), transparent 68%);
        pointer-events: none;
    }
    .contact-wrap {
        position: relative;
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.08fr);
        gap: 1.5rem;
        align-items: stretch;
    }
    .contact-reveal {
        opacity: 0;
        transform: translateY(26px);
        transition: opacity 0.75s cubic-bezier(0.22, 1, 0.36, 1), transform 0.75s cubic-bezier(0.22, 1, 0.36, 1);
        transition-delay: var(--d, 0s);
    }
    .contact-reveal.is-visible {
        opacity: 1;
        transform: none;
    }

    /* Info panel */
    .contact-panel {
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        padding: 2.75rem;
        border-radius: 1.75rem;
        color: #F2FBF5;
        background:
            radial-gradient(110% 80% at 100% 0%, rgba(72,199,132,0.3), transparent 55%),
            linear-gradient(155deg, #0C3D28 0%, #062718 100%);
        box-shadow: 0 35px 70px -50px rgba(5, 40, 26, 0.85);
    }
    .contact-panel::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 62px 62px;
        -webkit-mask-image: radial-gradient(circle at 80% 15%, #000, transparent 72%);
        mask-image: radial-gradient(circle at 80% 15%, #000, transparent 72%);
        pointer-events: none;
    }
    .contact-art {
        position: absolute;
        top: -16%;
        right: -18%;
        width: 68%;
        height: auto;
        opacity: 0.9;
        pointer-events: none;
        animation: contactSpin 80s linear infinite;
    }
    .contact-orb {
        position: absolute;
        bottom: -110px;
        left: -80px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        filter: blur(50px);
        pointer-events: none;
        animation: contactFloat 18s ease-in-out infinite;
    }
    .cp-head { position: relative; z-index: 1; }
    .contact-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #9DF3BE;
        margin-bottom: 1rem;
    }
    .contact-eyebrow::before {
        content: '';
        width: 1.5rem;
        height: 1px;
        background: currentColor;
        opacity: 0.5;
    }
    .contact-panel h2 {
        font-size: clamp(1.9rem, 3vw, 2.5rem);
        font-weight: 800;
        line-height: 1.06;
        letter-spacing: -0.04em;
        color: #FFFFFF;
        margin-bottom: 0.875rem;
    }
    .contact-panel h2 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.02em;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 50%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.04em;
    }
    .contact-panel > p {
        position: relative;
        z-index: 1;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(226,245,232,0.7);
        max-width: 26rem;
    }
    .contact-list {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        margin-top: 2rem;
    }
    .contact-row {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        padding: 1rem 0;
        border-top: 1px solid rgba(255,255,255,0.08);
    }
    .contact-panel.is-visible .contact-row {
        animation: contactRowIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .contact-panel.is-visible .contact-row:nth-child(1) { animation-delay: 0.12s; }
    .contact-panel.is-visible .contact-row:nth-child(2) { animation-delay: 0.2s; }
    .contact-panel.is-visible .contact-row:nth-child(3) { animation-delay: 0.28s; }
    .contact-panel.is-visible .contact-row:nth-child(4) { animation-delay: 0.36s; }
    .contact-row .c-icon {
        flex-shrink: 0;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        color: #9DF3BE;
        transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
    }
    .contact-row:hover .c-icon {
        background: #FFD166;
        color: #0B2E1D;
        transform: translateY(-2px) rotate(-4deg);
    }
    .c-label {
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(226,245,232,0.5);
        margin-bottom: 0.1875rem;
    }
    .c-value {
        display: inline-block;
        font-size: 0.9375rem;
        font-weight: 600;
        line-height: 1.5;
        color: #F2FBF5;
        text-decoration: none;
        word-break: break-word;
        transition: color 0.2s ease;
    }
    a.c-value:hover { color: #FFD166; }
    .c-value.c-address {
        font-weight: 500;
        color: rgba(226,245,232,0.85);
    }

    /* Form card */
    .contact-form-card {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 2.75rem;
        border-radius: 1.75rem;
        background: #FFFFFF;
        border: 1px solid #E4EEE8;
        box-shadow: 0 32px 64px -50px rgba(9, 50, 32, 0.45);
    }
    .cf-head h3 {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: #10261A;
        margin-bottom: 0.375rem;
    }
    .cf-head p {
        font-size: 0.875rem;
        line-height: 1.65;
        color: #617067;
        margin-bottom: 1.5rem;
    }
    .contact-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.75rem 0.875rem;
        border-radius: 0.75rem;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        font-size: 0.8125rem;
        line-height: 1.5;
        margin-bottom: 1.25rem;
    }
    .contact-alert svg { flex-shrink: 0; margin-top: 0.125rem; }
    .c-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .c-field {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        margin-bottom: 1rem;
    }
    .c-field label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #374151;
    }
    .c-field label .req { color: #EF4444; }
    .c-input {
        width: 100%;
        padding: 0.75rem 0.875rem;
        border: 1px solid #DDE8E1;
        border-radius: 0.75rem;
        background: #F7FBF8;
        color: #10261A;
        font-size: 0.875rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .c-input::placeholder { color: #9AA9A0; }
    .c-input:focus {
        border-color: #7BCB9B;
        background: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.10);
    }
    .c-input.is-invalid {
        border-color: #FCA5A5;
        background: #FEF2F2;
    }
    .c-input.is-invalid:focus {
        border-color: #EF4444;
        box-shadow: 0 0 0 4px rgba(239,68,68,0.10);
    }
    textarea.c-input {
        resize: vertical;
        min-height: 7.5rem;
        line-height: 1.6;
    }
    .c-error {
        font-size: 0.75rem;
        color: #DC2626;
        margin-top: 0.125rem;
    }
    .c-submit {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.9375rem 1.25rem;
        border: none;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.9375rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 14px 30px -14px rgba(255,209,102,0.8), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.28s ease;
    }
    .c-submit::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -30%;
        width: 40%;
        height: 220%;
        background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,0.7) 50%, transparent 100%);
        transform: translateX(-160%) rotate(12deg);
        transition: transform 0.75s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .c-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 36px -16px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
    }
    .c-submit:hover::after { transform: translateX(420%) rotate(12deg); }
    .c-submit svg { transition: transform 0.28s ease; }
    .c-submit:hover svg { transform: translateX(3px); }
    .c-submit:active { transform: translateY(0); }
    .c-form-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .c-form-note {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        color: #7A8B82;
    }
    .c-form-note svg { color: #2E8B57; flex-shrink: 0; }
    .c-history-link {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #17603C;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        padding-bottom: 0.0625rem;
        transition: gap 0.25s ease, border-color 0.25s ease;
    }
    .c-history-link:hover { gap: 0.625rem; border-color: rgba(23,96,60,0.4); }

    @keyframes contactRowIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes contactSpin {
        to { transform: rotate(360deg); }
    }
    @keyframes contactFloat {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(18px, -16px, 0) scale(1.08); }
    }

    @media (max-width: 960px) {
        .contact-wrap { grid-template-columns: 1fr; }
        .contact-panel { padding: 2.25rem; }
        .contact-form-card { padding: 2.25rem; }
        .contact-list { margin-top: 1.75rem; }
    }
    @media (max-width: 560px) {
        .contact-section { padding: 3.5rem 1rem 4rem; }
        .contact-wrap { gap: 1rem; }
        .contact-panel,
        .contact-form-card { padding: 1.75rem 1.25rem; border-radius: 1.25rem; }
        .contact-panel h2 { font-size: 1.75rem; }
        .cf-head h3 { font-size: 1.25rem; }
        .c-form-row { grid-template-columns: 1fr; gap: 0; }
        .contact-art { width: 90%; top: -10%; right: -30%; }
        .c-form-foot { flex-direction: column; align-items: flex-start; }
    }
    @media (prefers-reduced-motion: reduce) {
        .contact-reveal {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
        .contact-panel.is-visible .contact-row,
        .contact-art,
        .contact-orb {
            animation: none !important;
        }
    }
</style>

<section class="contact-section" id="contact">
    <div class="contact-wrap">
        {{-- Info panel --}}
        <div class="contact-panel contact-reveal">
            <svg class="contact-art" viewBox="0 0 420 420" fill="none" aria-hidden="true">
                <circle cx="210" cy="210" r="200" stroke="rgba(255,255,255,0.07)"/>
                <circle cx="210" cy="210" r="152" stroke="rgba(157,243,190,0.18)" stroke-dasharray="2 8"/>
                <circle cx="210" cy="210" r="104" stroke="rgba(255,209,102,0.2)"/>
                <path d="M210 140c-30 20-44 48-44 78 30 4 58-6 78-30 18-22 20-48 14-72-18 2-34 10-48 24z" stroke="rgba(157,243,190,0.45)" stroke-width="1.4"/>
                <path d="M196 236c8-30 22-52 44-70" stroke="rgba(255,209,102,0.35)" stroke-width="1.2" stroke-linecap="round"/>
                <circle cx="354" cy="118" r="4" fill="#FFD166" opacity=".8"/>
            </svg>
            <span class="contact-orb" aria-hidden="true"></span>

            <div class="cp-head">
                <span class="contact-eyebrow">Get in touch</span>
                <h2>We're here to <em>help</em>.</h2>
                <p>Questions about a product, an order, or just need a recommendation? Send a note — a real human will get back to you.</p>
            </div>

            <div class="contact-list">
                <div class="contact-row">
                    <span class="c-icon" aria-hidden="true">
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="c-label">Phone</div>
                        <a href="tel:{{ $s->contact_phone ?? '+8801700000000' }}" class="c-value">{{ $s->contact_phone ?? '+880 1700-000000' }}</a>
                    </div>
                </div>

                <div class="contact-row">
                    <span class="c-icon" aria-hidden="true">
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="c-label">Email</div>
                        <a href="mailto:{{ $s->contact_email ?? 'support@personalcarestore.com' }}" class="c-value">{{ $s->contact_email ?? 'support@personalcarestore.com' }}</a>
                    </div>
                </div>

                <div class="contact-row">
                    <span class="c-icon" aria-hidden="true">
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="c-label">Address</div>
                        <span class="c-value c-address">{{ $s->contact_address ?? '123 Personal Care Lane, Khulna, Bangladesh' }}</span>
                    </div>
                </div>

                <div class="contact-row">
                    <span class="c-icon" aria-hidden="true">
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </span>
                    <div>
                        <div class="c-label">Hours</div>
                        <span class="c-value c-address">{!! nl2br(e($s->contact_hours ?? 'Sat -- Thu: 9 AM - 8 PM')) !!}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form card --}}
        <div class="contact-form-card contact-reveal" style="--d: 0.12s;">
            <div class="cf-head">
                <h3>Send us a message</h3>
                <p>Fill in the form below and we'll get back to you as soon as we can.</p>
            </div>

            @if(session('success'))
                <div class="contact-alert" role="status">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <div class="c-form-row">
                    <div class="c-field">
                        <label for="contact_name">Your name <span class="req">*</span></label>
                        <input type="text" id="contact_name" name="name" value="{{ old('name') }}" required
                               placeholder="e.g. Ayesha Rahman"
                               class="c-input @error('name') is-invalid @enderror">
                        @error('name')<span class="c-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="c-field">
                        <label for="contact_email">Your email <span class="req">*</span></label>
                        <input type="email" id="contact_email" name="email" value="{{ old('email') }}" required
                               placeholder="you@example.com"
                               class="c-input @error('email') is-invalid @enderror">
                        @error('email')<span class="c-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="c-field">
                    <label for="contact_message">Your message <span class="req">*</span></label>
                    <textarea id="contact_message" name="message" rows="5" required
                              placeholder="How can we help?"
                              class="c-input @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                    @error('message')<span class="c-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="c-submit">
                    Send message
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m0 0l-6-6m6 6l-6 6"/>
                    </svg>
                </button>

                <div class="c-form-foot">
                    <span class="c-form-note">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Your details stay private.
                    </span>
                    <a href="{{ route('contact.my-messages') }}" class="c-history-link">
                        View my previous messages
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    (function () {
        const panels = document.querySelectorAll('.contact-reveal');
        if (!panels.length) return;

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduceMotion || !('IntersectionObserver' in window)) {
            panels.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

        panels.forEach(function (el) { observer.observe(el); });
    })();
</script>
