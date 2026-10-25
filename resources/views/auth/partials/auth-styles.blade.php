<style>
    /* ═══════════════ PAGE SHELL (home hero palette) ═══════════════ */
    .auth-page {
        --brand: #2E8B57;
        --brand-deep: #17603C;
        --accent: #FFD166;
        --accent-deep: #F5C14E;
        --mint: #9DF3BE;
        --mint-bright: #7BF1A8;
        --ink: #12261B;
        --text: #F2FBF5;
        --muted: rgba(226,245,232,0.64);
        --line: rgba(255,255,255,0.12);
        --ease: cubic-bezier(0.22, 1, 0.36, 1);
        --nav-h: 65px;

        position: relative;
        isolation: isolate;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - var(--nav-h));
        min-height: calc(100dvh - var(--nav-h));
        background:
            radial-gradient(1100px 620px at 84% 4%, rgba(46,139,87,0.40), transparent 62%),
            radial-gradient(760px 480px at 0% 100%, rgba(255,209,102,0.10), transparent 68%),
            linear-gradient(158deg, #07301E 0%, #062718 46%, #03190F 100%);
        color: var(--text);
    }
    /* Faint blueprint grid, masked the same way as the hero */
    .auth-page::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.032) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.032) 1px, transparent 1px);
        background-size: 76px 76px;
        -webkit-mask-image: radial-gradient(circle at 50% 38%, #000 0%, transparent 76%);
        mask-image: radial-gradient(circle at 50% 38%, #000 0%, transparent 76%);
        pointer-events: none;
    }

    /* ═══════════════ BRAND PANEL ═══════════════ */
    .auth-aside {
        position: relative;
        z-index: 1;
        isolation: isolate;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 2rem;
        padding: 2.75rem clamp(1.75rem, 3.5vw, 3.5rem);
        border-right: 1px solid rgba(255,255,255,0.06);
    }
    .auth-aside::before,
    .auth-aside::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(72px);
        pointer-events: none;
        z-index: -1;
    }
    .auth-aside::before {
        width: 420px; height: 420px;
        top: -170px; right: -130px;
        background: radial-gradient(circle, rgba(72,199,132,0.42), transparent 66%);
        animation: authOrb 22s ease-in-out infinite;
    }
    .auth-aside::after {
        width: 340px; height: 340px;
        bottom: -150px; left: -110px;
        background: radial-gradient(circle, rgba(255,209,102,0.22), transparent 68%);
        animation: authOrb 28s ease-in-out infinite reverse;
    }

    /* Brand lockup */
    .auth-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.6875rem;
        width: fit-content;
        color: #FFFFFF;
        text-decoration: none;
        font-size: 1.125rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        animation: authIn 0.7s var(--ease) both;
    }
    .auth-brand .mark {
        width: 2.25rem; height: 2.25rem;
        border-radius: 0.625rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: var(--ink);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem;
        box-shadow: 0 10px 22px -10px rgba(255,209,102,0.85), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.4s var(--ease);
    }
    .auth-brand:hover .mark { transform: rotate(-8deg) scale(1.07); }

    .auth-pitch { margin: auto 0; }
    .auth-pitch h2 {
        font-size: clamp(1.75rem, 2.6vw, 2.375rem);
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -0.045em;
        margin-bottom: 0.875rem;
        max-width: 22ch;
        color: #FFFFFF;
        animation: authIn 0.8s var(--ease) 0.08s both;
    }
    .auth-pitch h2 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.025em;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 45%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        padding-right: 0.06em;
    }
    .auth-pitch p {
        font-size: 0.9375rem;
        line-height: 1.75;
        color: var(--muted);
        max-width: 34ch;
        animation: authIn 0.8s var(--ease) 0.16s both;
    }

    /* Feature list */
    .auth-features {
        list-style: none;
        margin: 1.75rem 0 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 0.875rem;
        animation: authIn 0.8s var(--ease) 0.24s both;
    }
    .auth-features li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: rgba(233,247,238,0.82);
    }
    .auth-features .fi {
        flex-shrink: 0;
        width: 2rem; height: 2rem;
        border-radius: 0.625rem;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: var(--mint);
    }

    /* Trust line at the bottom of the panel */
    .auth-trust {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: rgba(226,245,232,0.5);
    }
    .auth-trust svg { flex-shrink: 0; color: var(--mint); }

    /* Quote / support card */
    .auth-quote {
        max-width: 27rem;
        padding: 1.125rem 1.25rem;
        border-radius: 1rem;
        background: rgba(255,255,255,0.055);
        border: 1px solid rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(14px);
        backdrop-filter: blur(14px);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
        animation: authIn 0.8s var(--ease) 0.32s both;
    }
    .auth-quote .stars,
    .auth-quote .quote-icon {
        display: flex;
        gap: 0.1875rem;
        color: var(--accent);
        margin-bottom: 0.5rem;
    }
    .auth-quote .quote-icon { margin-bottom: 0.625rem; }
    .auth-quote p {
        font-size: 0.875rem;
        line-height: 1.65;
        color: rgba(233,247,238,0.88);
    }
    .auth-quote p strong { color: #FFFFFF; }
    .auth-quote .who {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        margin-top: 0.875rem;
        font-size: 0.75rem;
        color: rgba(226,245,232,0.55);
    }
    .auth-quote .who span.avatar {
        width: 1.75rem; height: 1.75rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #BFF3D2, #7BD9A1);
        color: #0A2C1C;
        font-weight: 800;
        font-size: 0.6875rem;
        display: flex; align-items: center; justify-content: center;
    }

    /* ═══════════════ FORM PANEL ═══════════════ */
    .auth-main {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 3rem 1.5rem;
    }
    .auth-card {
        width: 100%;
        max-width: 26rem;
        padding: 2.125rem 1.875rem;
        border-radius: 1.5rem;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(18px);
        backdrop-filter: blur(18px);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,0.08),
            0 40px 80px -44px rgba(0,0,0,0.9);
        animation: authCard 0.7s var(--ease) 0.1s both;
    }
    .auth-card .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #FFE6A8;
        background: rgba(255,209,102,0.10);
        border: 1px solid rgba(255,209,102,0.22);
        padding: 0.3125rem 0.625rem;
        border-radius: 9999px;
        margin-bottom: 1.125rem;
    }
    .auth-card h1 {
        font-size: clamp(1.625rem, 2.2vw, 1.875rem);
        font-weight: 800;
        letter-spacing: -0.04em;
        line-height: 1.1;
        color: #FFFFFF;
    }
    .auth-card .sub {
        margin-top: 0.4375rem;
        font-size: 0.875rem;
        line-height: 1.65;
        color: var(--muted);
    }
    .auth-card .sub strong {
        color: #FFFFFF;
        font-weight: 600;
        word-break: break-word;
    }

    /* Alerts */
    .alert-box {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.8125rem 0.9375rem;
        border-radius: 0.75rem;
        font-size: 0.8125rem;
        line-height: 1.55;
        margin-top: 1.25rem;
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
    }
    .alert-box svg { flex-shrink: 0; margin-top: 0.0625rem; }
    .alert-success {
        background: rgba(123,241,168,0.10);
        border: 1px solid rgba(123,241,168,0.24);
        color: #C8F7DB;
    }
    .alert-error {
        background: rgba(248,113,113,0.10);
        border: 1px solid rgba(248,113,113,0.26);
        color: #FECACA;
    }
    .alert-error ul { list-style: none; margin: 0; padding: 0; }
    .alert-error ul li + li { margin-top: 0.125rem; }

    /* Fields */
    .auth-form { margin-top: 1.75rem; }
    .field { margin-bottom: 1.0625rem; }
    .field .label-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.4375rem;
    }
    .field label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: rgba(233,247,238,0.86);
    }
    .field .input-wrap { position: relative; }
    .field .input-wrap .input-icon {
        position: absolute;
        left: 0.9375rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(226,245,232,0.42);
        pointer-events: none;
        display: flex;
        align-items: center;
        transition: color 0.28s var(--ease);
    }
    .field input {
        width: 100%;
        height: 3rem;
        padding: 0 1rem 0 2.75rem;
        border: 1px solid var(--line);
        border-radius: 0.75rem;
        background: rgba(255,255,255,0.05);
        font-family: inherit;
        font-size: 0.9375rem;
        color: var(--text);
        caret-color: var(--accent);
        outline: none;
        transition: border-color 0.28s var(--ease), box-shadow 0.28s var(--ease), background 0.28s var(--ease);
    }
    .field input::placeholder { color: rgba(226,245,232,0.34); }
    .field input:hover { border-color: rgba(255,255,255,0.20); }
    .field input:focus {
        border-color: rgba(157,243,190,0.6);
        background: rgba(255,255,255,0.08);
        box-shadow: 0 0 0 4px rgba(123,241,168,0.12);
    }
    /* Keep browser autofill on-palette */
    .field input:-webkit-autofill,
    .field input:-webkit-autofill:hover,
    .field input:-webkit-autofill:focus {
        -webkit-text-fill-color: var(--text);
        -webkit-box-shadow: 0 0 0 1000px #0B3A25 inset;
        caret-color: var(--accent);
    }
    .field .input-wrap:focus-within .input-icon { color: var(--mint); }
    .field input.has-error {
        border-color: rgba(248,113,113,0.5);
        background: rgba(248,113,113,0.06);
    }
    .field input.has-error:focus {
        border-color: rgba(248,113,113,0.75);
        box-shadow: 0 0 0 4px rgba(248,113,113,0.12);
    }
    .field input.has-toggle { padding-right: 3rem; }

    /* Password reveal */
    .pw-toggle {
        position: absolute;
        right: 0.4375rem;
        top: 50%;
        transform: translateY(-50%);
        width: 2rem; height: 2rem;
        display: flex; align-items: center; justify-content: center;
        background: none;
        border: none;
        border-radius: 0.5rem;
        color: rgba(226,245,232,0.45);
        cursor: pointer;
        transition: color 0.28s var(--ease), background 0.28s var(--ease);
    }
    .pw-toggle:hover { color: var(--mint); background: rgba(255,255,255,0.08); }
    .pw-toggle:focus-visible { outline: 2px solid var(--accent); outline-offset: 1px; }

    /* Field hint */
    .pass-hint {
        display: flex;
        align-items: center;
        gap: 0.3125rem;
        margin-top: 0.375rem;
        font-size: 0.75rem;
        color: rgba(226,245,232,0.45);
    }
    .pass-hint svg { flex-shrink: 0; }

    /* Remember + forgot */
    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin: 0.25rem 0 1.375rem;
    }
    .remember-row .check {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        user-select: none;
    }
    .remember-row input[type="checkbox"] {
        width: 1.0625rem;
        height: 1.0625rem;
        border: 1px solid var(--line);
        border-radius: 0.3125rem;
        accent-color: var(--mint-bright);
        cursor: pointer;
        margin: 0;
    }
    .remember-row .check span {
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .remember-row a {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--mint);
        text-decoration: none;
        transition: color 0.28s var(--ease);
    }
    .remember-row a:hover { color: #FFFFFF; text-decoration: underline; }

    /* Submit — gold gradient with the hero's shine sweep */
    .btn-auth {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: var(--ink);
        border: none;
        border-radius: 0.75rem;
        font-family: inherit;
        font-size: 0.9375rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        cursor: pointer;
        box-shadow: 0 14px 34px -14px rgba(255,209,102,0.9), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    }
    .btn-auth::after {
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
    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -16px rgba(255,209,102,1), inset 0 1px 0 rgba(255,255,255,0.65);
    }
    .btn-auth:hover::after { transform: translateX(420%) rotate(12deg); }
    .btn-auth:active { transform: translateY(0); }
    .btn-auth svg { transition: transform 0.3s var(--ease); }
    .btn-auth:hover svg { transform: translateX(3px); }
    .btn-auth:focus-visible { outline: 2px solid var(--accent); outline-offset: 3px; }

    /* Secondary action */
    .btn-auth-ghost {
        width: 100%;
        height: 2.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 0.625rem;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.22);
        border-radius: 0.75rem;
        color: #EAF8EF;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        transition: background 0.28s var(--ease), border-color 0.28s var(--ease), transform 0.28s var(--ease);
    }
    .btn-auth-ghost:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.34);
        transform: translateY(-2px);
    }
    .btn-auth-ghost.is-danger {
        color: #FCA5A5;
        border-color: rgba(248,113,113,0.26);
    }
    .btn-auth-ghost.is-danger:hover {
        background: rgba(248,113,113,0.12);
        border-color: rgba(248,113,113,0.45);
    }
    .btn-auth-ghost:focus-visible { outline: 2px solid var(--accent); outline-offset: 3px; }

    /* Security note */
    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        margin-top: 0.875rem;
        font-size: 0.75rem;
        color: rgba(226,245,232,0.42);
    }
    .secure-note svg { color: var(--mint); flex-shrink: 0; }

    /* Page footer link */
    .auth-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1.75rem;
        color: rgba(226,245,232,0.4);
        font-size: 0.75rem;
    }
    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.10);
    }
    .signup-row {
        margin-top: 1.125rem;
        text-align: center;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .signup-row a {
        font-weight: 600;
        color: var(--mint);
        text-decoration: none;
    }
    .signup-row a:hover { color: #FFFFFF; text-decoration: underline; }

    /* ═══════════════ WIDE SCREENS: COMPACT BRAND PANEL ═══════════════ */
    @media (min-width: 961px) {
        .auth-page {
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(0, 1fr);
            align-items: stretch;
        }
    }

    /* ═══════════════ RESPONSIVE ═══════════════ */
    @media (max-width: 960px) {
        .auth-page {
            align-items: flex-start;
            min-height: calc(100vh - var(--nav-h));
            min-height: calc(100dvh - var(--nav-h));
        }
        .auth-aside { display: none; }
        .auth-main { padding: 2rem 1.25rem 3rem; align-items: flex-start; }
    }
    @media (max-width: 480px) {
        .auth-card { padding: 1.5rem 1.25rem; border-radius: 1.25rem; }
        .auth-aside { padding: 1.5rem 1.25rem 1.75rem; }
        .auth-pitch h2 { font-size: 1.3125rem; }
    }

    /* ═══════════════ ANIMATION ═══════════════ */
    @keyframes authOrb {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(26px, -22px, 0) scale(1.08); }
    }
    @keyframes authIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes authCard {
        from { opacity: 0; transform: translateY(22px) scale(0.985); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @media (prefers-reduced-motion: reduce) {
        .auth-aside::before,
        .auth-aside::after,
        .auth-brand,
        .auth-pitch h2,
        .auth-pitch p,
        .auth-features,
        .auth-quote,
        .auth-card {
            animation: none !important;
        }
        .btn-auth,
        .btn-auth::after,
        .btn-auth svg,
        .btn-auth-ghost,
        .field input,
        .pw-toggle,
        .auth-brand .mark {
            transition: none !important;
        }
    }
</style>
