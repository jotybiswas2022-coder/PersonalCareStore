@extends('admin.layouts.app')

@push('styles')
<style>
/* ── Animations ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes pulseGlow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50%      { opacity: 0.6; transform: scale(1.05); }
}
.cs-animate { animation: fadeUp 0.5s ease-out both; }
.cs-animate-d1 { animation-delay: 0.05s; }
.cs-animate-d2 { animation-delay: 0.1s; }
.cs-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.cs-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #1c1a15 40%, #2a241a 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.cs-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(245,158,11,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(251,191,36,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(234,179,8,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.cs-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.cs-hero .hero-inner {
    position: relative;
    z-index: 1;
}
.cs-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.cs-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(245,158,11,0.18);
    border-radius: 0.75rem;
    color: #fbbf24;
    flex-shrink: 0;
}
.cs-hero .hero-icon svg { width: 24px; height: 24px; }
.cs-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.cs-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}

/* ── Success Message ── */
.cs-msg {
    margin-bottom: 1.25rem;
    padding: 0.875rem 1.125rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-weight: 500;
    animation: fadeUp 0.35s ease-out;
}
.cs-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Validation Errors Summary ── */
.cs-errors {
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #fef2f2, #fce4e4);
    border: 1px solid #fecaca;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    animation: fadeUp 0.35s ease-out;
}
.cs-errors svg {
    width: 18px;
    height: 18px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 1px;
}
.cs-errors .err-content { flex: 1; }
.cs-errors .err-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 0.25rem;
}
.cs-errors .err-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.cs-errors .err-list li {
    font-size: 0.8rem;
    color: #b91c1c;
    padding: 0.125rem 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.cs-errors .err-list li::before {
    content: '';
    width: 0.3rem;
    height: 0.3rem;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Form Card ── */
.cs-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.cs-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.cs-card-body {
    padding: 2rem;
}

/* ── Section ── */
.cs-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #edf2f7;
}
.cs-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.cs-section-heading {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}
.cs-section-heading svg {
    width: 18px;
    height: 18px;
    color: #f59e0b;
    flex-shrink: 0;
}
.cs-section-heading .sh-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}
.cs-section-heading .sh-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 0.25rem;
}

/* ── Form Grid ── */
.cs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}
.cs-grid .full { grid-column: 1 / -1; }
@media (max-width: 640px) {
    .cs-grid { grid-template-columns: 1fr; }
}

/* ── Form Group ── */
.cs-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}
.cs-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.cs-group input[type="text"],
.cs-group input[type="email"],
.cs-group textarea {
    width: 100%;
    padding: 0.6rem 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    color: #111827;
    background: #fff;
    outline: none;
    transition: all 0.2s ease;
    font-family: inherit;
}
.cs-group input::placeholder,
.cs-group textarea::placeholder {
    color: #9ca3af;
}
.cs-group input:focus,
.cs-group textarea:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,0.1);
}
.cs-group textarea {
    resize: vertical;
    min-height: 80px;
    line-height: 1.5;
}
.cs-group .hint {
    font-size: 0.7rem;
    color: #9ca3af;
    line-height: 1.4;
}
.cs-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.cs-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

/* ── Checkbox / Toggle ── */
.cs-toggle {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.cs-toggle input[type="checkbox"] {
    width: 1.1rem;
    height: 1.1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    accent-color: #f59e0b;
    cursor: pointer;
    flex-shrink: 0;
}
.cs-toggle label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    margin-bottom: 0;
}

/* ── Form Actions ── */
.cs-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.cs-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.5rem;
    border: none;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.cs-btn:hover { transform: translateY(-1px); }
.cs-btn:active { transform: translateY(0); }
.cs-btn-primary {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    box-shadow: 0 2px 8px rgba(245,158,11,0.2);
}
.cs-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(245,158,11,0.3);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .cs-hero { padding: 1.75rem 1.5rem; }
    .cs-card-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .cs-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .cs-hero .hero-text h1 { font-size: 1.15rem; }
    .cs-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .cs-hero .hero-icon svg { width: 20px; height: 20px; }
    .cs-hero .hero-left { gap: 0.75rem; }
    .cs-card-body { padding: 1.25rem; }
    .cs-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    .cs-section-heading { margin-bottom: 1rem; }
    .cs-section-heading .sh-text { font-size: 0.85rem; }
    .cs-grid { gap: 1rem; }
    .cs-group label { font-size: 0.78rem; }
    .cs-group input[type="text"],
    .cs-group input[type="email"],
    .cs-group textarea { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .cs-actions { flex-direction: column; align-items: stretch; }
    .cs-btn { justify-content: center; }
}
@media (max-width: 480px) {
    .cs-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .cs-hero .hero-text h1 { font-size: 1rem; }
    .cs-hero .hero-text p { font-size: 0.75rem; }
    .cs-card-body { padding: 1rem; }
    .cs-section { margin-bottom: 1.25rem; padding-bottom: 1.25rem; }
    .cs-grid { gap: 0.75rem; }
    .cs-group label { font-size: 0.75rem; }
    .cs-group input[type="text"],
    .cs-group input[type="email"],
    .cs-group textarea { padding: 0.45rem 0.625rem; font-size: 0.78rem; border-radius: 0.5rem; }
    .cs-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
    .cs-errors { padding: 0.75rem 1rem; }
    .cs-errors .err-title { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="cs-hero cs-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div class="hero-text">
                <h1>Contact &amp; Newsletter</h1>
                <p>Manage contact information and homepage newsletter settings</p>
            </div>
        </div>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="cs-errors cs-animate cs-animate-d1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div class="err-content">
            <div class="err-title">{{ $errors->count() }} validation error{{ $errors->count() !== 1 ? 's' : '' }}</div>
            <ul class="err-list">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- Success Message --}}
@if(session('success'))
    <div class="cs-msg success cs-animate cs-animate-d1">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Form Card --}}
<div class="cs-card cs-animate cs-animate-d1">
    <div class="cs-card-body">
        <form method="POST" action="{{ route('admin.contact-setting.update') }}">
            @csrf

            {{-- Contact Information --}}
            <div class="cs-section">
                <div class="cs-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span class="sh-text">Contact Information</span>
                    <span class="sh-sub">— Phone, email, address &amp; hours</span>
                </div>
                <div class="cs-grid">
                    <div class="cs-group">
                        <label for="contact_phone">Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" placeholder="+880 1700-000000">
                        @error('contact_phone')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cs-group">
                        <label for="contact_email">Email</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" placeholder="support@personalcarestore.com">
                        @error('contact_email')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cs-group full">
                        <label for="contact_address">Address</label>
                        <textarea name="contact_address" id="contact_address" rows="3" placeholder="123 Personal Care Lane, Khulna, Bangladesh">{{ old('contact_address', $settings->contact_address) }}</textarea>
                        @error('contact_address')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cs-group full">
                        <label for="contact_hours">Working Hours</label>
                        <input type="text" name="contact_hours" id="contact_hours" value="{{ old('contact_hours', $settings->contact_hours) }}" placeholder="Sat -- Thu: 9 AM - 8 PM">
                        <span class="hint">Displayed on the contact section of your storefront</span>
                        @error('contact_hours')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Newsletter Section --}}
            <div class="cs-section" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <div class="cs-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span class="sh-text">Newsletter Section</span>
                    <span class="sh-sub">— Homepage email subscription settings</span>
                </div>
                <div class="cs-grid">
                    <div class="cs-group full">
                        <div class="cs-toggle">
                            <input type="checkbox" name="newsletter_enabled" id="newsletter_enabled" value="1" {{ $settings->newsletter_enabled ? 'checked' : '' }}>
                            <label for="newsletter_enabled">Enable Newsletter Section on Homepage</label>
                        </div>
                    </div>

                    <div class="cs-group">
                        <label for="newsletter_heading">Heading</label>
                        <input type="text" name="newsletter_heading" id="newsletter_heading" value="{{ old('newsletter_heading', $settings->newsletter_heading) }}" placeholder="Stay in the Loop">
                        @error('newsletter_heading')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cs-group">
                        <label for="newsletter_button_text">Button Text</label>
                        <input type="text" name="newsletter_button_text" id="newsletter_button_text" value="{{ old('newsletter_button_text', $settings->newsletter_button_text) }}" placeholder="Subscribe">
                        @error('newsletter_button_text')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cs-group full">
                        <label for="newsletter_text">Description Text</label>
                        <textarea name="newsletter_text" id="newsletter_text" rows="3" placeholder="Subscribe to get notified about new products...">{{ old('newsletter_text', $settings->newsletter_text) }}</textarea>
                        @error('newsletter_text')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="cs-group">
                        <label for="newsletter_placeholder">Email Input Placeholder</label>
                        <input type="text" name="newsletter_placeholder" id="newsletter_placeholder" value="{{ old('newsletter_placeholder', $settings->newsletter_placeholder) }}" placeholder="Enter your email address">
                        @error('newsletter_placeholder')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="cs-actions" style="margin-top:2rem;">
                <button type="submit" class="cs-btn cs-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save All Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
