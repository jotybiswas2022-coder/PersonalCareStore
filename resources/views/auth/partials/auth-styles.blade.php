<style>
    /* ═══════════════ PAGE SHELL ═══════════════ */
    .auth-page {
        --brand: #2E8B57;
        --brand-dark: #1B5E20;
        --brand-light: #3CB371;
        --accent: #FFD166;
        --ink: #16221B;
        --muted: #6b7280;
        --line: #e5e9ec;

        display: grid;
        grid-template-columns: minmax(0, 1.02fr) minmax(0, 1fr);
        min-height: calc(100vh - 64px);
        background: #F4F7F5;
    }

    /* ═══════════════ BRAND PANEL ═══════════════ */
    .auth-aside {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 2.5rem;
        padding: 3.25rem clamp(2rem, 4vw, 4rem);
        background: linear-gradient(150deg, #2E8B57 0%, #1B5E20 55%, #0D3B1E 100%);
        color: #ffffff;
    }
    .auth-aside::before,
    .auth-aside::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: -1;
    }
    .auth-aside::before {
        width: 380px; height: 380px;
        top: -140px; right: -120px;
        background: radial-gradient(circle, rgba(255,209,102,0.22) 0%, transparent 68%);
    }
    .auth-aside::after {
        width: 520px; height: 520px;
        bottom: -240px; left: -160px;
        background: radial-gradient(circle, rgba(60,179,113,0.35) 0%, transparent 70%);
    }

    /* Brand lockup */
    .auth-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.6875rem;
        color: #ffffff;
        text-decoration: none;
        font-size: 1.125rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }
    .auth-brand .mark {
        width: 2.25rem; height: 2.25rem;
        border-radius: 0.625rem;
        background: var(--accent);
        color: #16221B;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem;
        box-shadow: 0 4px 14px rgba(0,0,0,0.18);
    }

    .auth-pitch h2 {
        font-size: clamp(1.75rem, 2.6vw, 2.375rem);
        font-weight: 800;
        line-height: 1.18;
        letter-spacing: -0.035em;
        margin-bottom: 0.875rem;
        max-width: 22ch;
    }
    .auth-pitch h2 em {
        font-style: normal;
        color: var(--accent);
    }
    .auth-pitch p {
        font-size: 0.9375rem;
        line-height: 1.7;
        color: rgba(255,255,255,0.76);
        max-width: 34ch;
    }

    /* Feature list */
    .auth-features {
        list-style: none;
        margin: 1.75rem 0 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 0.875rem;
    }
    .auth-features li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: rgba(255,255,255,0.88);
    }
    .auth-features .fi {
        flex-shrink: 0;
        width: 2rem; height: 2rem;
        border-radius: 0.5rem;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.16);
        color: var(--accent);
    }

    /* Quote / trust card */
    .auth-quote {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 0.875rem;
        padding: 1.125rem 1.25rem;
        backdrop-filter: blur(6px);
        max-width: 27rem;
    }
    .auth-quote .stars {
        display: flex;
        gap: 0.1875rem;
        color: var(--accent);
        margin-bottom: 0.5rem;
    }
    .auth-quote .quote-icon {
        display: flex;
        margin-bottom: 0.625rem;
        color: var(--accent);
    }
    .auth-quote p {
        font-size: 0.875rem;
        line-height: 1.65;
        color: rgba(255,255,255,0.9);
    }
    .auth-quote .who {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        margin-top: 0.875rem;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.62);
    }
    .auth-quote .who span.avatar {
        width: 1.75rem; height: 1.75rem;
        border-radius: 50%;
        background: var(--accent);
        color: #16221B;
        font-weight: 700;
        font-size: 0.6875rem;
        display: flex; align-items: center; justify-content: center;
    }

    /* ═══════════════ FORM PANEL ═══════════════ */
    .auth-main {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
        background:
            radial-gradient(circle at 100% 0%, rgba(46,139,87,0.06) 0%, transparent 45%),
            #F4F7F5;
    }
    .auth-card {
        width: 100%;
        max-width: 25.5rem;
        animation: authRise 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .auth-card .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--brand);
        background: rgba(46,139,87,0.09);
        border: 1px solid rgba(46,139,87,0.16);
        padding: 0.3125rem 0.625rem;
        border-radius: 9999px;
        margin-bottom: 1rem;
    }
    .auth-card h1 {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.035em;
        color: var(--ink);
        line-height: 1.2;
    }
    .auth-card .sub {
        margin-top: 0.4375rem;
        font-size: 0.875rem;
        line-height: 1.6;
        color: var(--muted);
    }

    /* Alerts */
    .alert-box {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.8125rem 0.9375rem;
        border-radius: 0.625rem;
        font-size: 0.8125rem;
        line-height: 1.5;
        margin-top: 1.25rem;
    }
    .alert-box svg { flex-shrink: 0; margin-top: 0.0625rem; }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
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
        color: #374151;
    }
    .field .input-wrap { position: relative; }
    .field .input-wrap .input-icon {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa5ad;
        pointer-events: none;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }
    .field input {
        width: 100%;
        height: 2.9375rem;
        padding: 0 0.9375rem 0 2.625rem;
        border: 1.5px solid var(--line);
        border-radius: 0.6875rem;
        background: #ffffff;
        font-family: inherit;
        font-size: 0.9375rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }
    .field input::placeholder { color: #b6c0c7; }
    .field input:hover { border-color: #cfd8dd; }
    .field input:focus {
        border-color: var(--brand);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(46,139,87,0.12);
    }
    .field .input-wrap:focus-within .input-icon { color: var(--brand); }
    .field input.has-error {
        border-color: #f3b4b4;
        background: #fffafa;
    }
    .field input.has-error:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 4px rgba(220,38,38,0.10);
    }
    .field input.has-toggle { padding-right: 2.875rem; }

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
        color: #9aa5ad;
        cursor: pointer;
        transition: color 0.18s, background 0.18s;
    }
    .pw-toggle:hover { color: var(--brand); background: rgba(46,139,87,0.08); }
    .pw-toggle:focus-visible { outline: 2px solid var(--brand); outline-offset: 1px; }

    /* Field hint */
    .pass-hint {
        display: flex;
        align-items: center;
        gap: 0.3125rem;
        margin-top: 0.375rem;
        font-size: 0.75rem;
        color: #93a0a8;
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
        border: 1.5px solid #cfd8dd;
        border-radius: 0.3125rem;
        accent-color: var(--brand);
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
        color: var(--brand);
        text-decoration: none;
        transition: color 0.18s;
    }
    .remember-row a:hover { color: var(--brand-dark); text-decoration: underline; }

    /* Submit */
    .btn-auth {
        width: 100%;
        height: 2.9375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%);
        color: #ffffff;
        border: none;
        border-radius: 0.6875rem;
        font-family: inherit;
        font-size: 0.9375rem;
        font-weight: 600;
        letter-spacing: -0.01em;
        cursor: pointer;
        box-shadow: 0 8px 20px -8px rgba(46,139,87,0.75);
        transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
    }
    .btn-auth:hover {
        transform: translateY(-1px);
        filter: brightness(1.04);
        box-shadow: 0 12px 26px -10px rgba(46,139,87,0.85);
    }
    .btn-auth:active { transform: translateY(0); box-shadow: 0 5px 14px -8px rgba(46,139,87,0.8); }
    .btn-auth:focus-visible { outline: 2px solid var(--brand-dark); outline-offset: 2px; }

    /* Security note */
    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        margin-top: 0.875rem;
        font-size: 0.75rem;
        color: #93a0a8;
    }

    /* Signup footer */
    .auth-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1.75rem;
        color: #a7b2ba;
        font-size: 0.75rem;
    }
    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--line);
    }
    .signup-row {
        margin-top: 1.125rem;
        text-align: center;
        font-size: 0.8125rem;
        color: var(--muted);
    }
    .signup-row a {
        font-weight: 600;
        color: var(--brand);
        text-decoration: none;
    }
    .signup-row a:hover { color: var(--brand-dark); text-decoration: underline; }

    /* ═══════════════ RESPONSIVE ═══════════════ */
    @media (max-width: 960px) {
        .auth-page { grid-template-columns: 1fr; min-height: 0; }
        .auth-aside {
            gap: 1.25rem;
            padding: 2rem 1.5rem 2.25rem;
            border-radius: 0 0 1.5rem 1.5rem;
        }
        .auth-pitch h2 { font-size: 1.5rem; max-width: none; }
        .auth-pitch p { font-size: 0.875rem; }
        .auth-features,
        .auth-quote { display: none; }
        .auth-main { padding: 2rem 1.25rem 3rem; align-items: flex-start; }
    }
    @media (max-width: 480px) {
        .auth-card h1 { font-size: 1.5rem; }
        .auth-aside { padding: 1.5rem 1.25rem 1.75rem; }
        .auth-pitch h2 { font-size: 1.3125rem; }
    }

    /* ═══════════════ ANIMATION ═══════════════ */
    @keyframes authRise {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (prefers-reduced-motion: reduce) {
        .auth-card { animation: none; }
        .btn-auth { transition: none; }
    }
</style>
