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
.st-animate { animation: fadeUp 0.5s ease-out both; }
.st-animate-d1 { animation-delay: 0.05s; }
.st-animate-d2 { animation-delay: 0.1s; }
.st-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.st-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.st-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(99,102,241,0.15) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(129,140,248,0.1) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(79,70,229,0.08) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.st-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.st-hero .hero-inner {
    position: relative;
    z-index: 1;
}
.st-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.st-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(99,102,241,0.18);
    border-radius: 0.75rem;
    color: #818cf8;
    flex-shrink: 0;
}
.st-hero .hero-icon svg { width: 24px; height: 24px; }
.st-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.st-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}

/* ── Success Message ── */
.st-msg {
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
.st-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}

/* ── Validation Errors Summary ── */
.st-errors {
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
.st-errors svg {
    width: 18px;
    height: 18px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 1px;
}
.st-errors .err-content { flex: 1; }
.st-errors .err-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 0.25rem;
}
.st-errors .err-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.st-errors .err-list li {
    font-size: 0.8rem;
    color: #b91c1c;
    padding: 0.125rem 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.st-errors .err-list li::before {
    content: '';
    width: 0.3rem;
    height: 0.3rem;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Form Card ── */
.st-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.st-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.st-card-body {
    padding: 2rem;
}

/* ── Section ── */
.st-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #edf2f7;
}
.st-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.st-section-heading {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}
.st-section-heading svg {
    width: 18px;
    height: 18px;
    color: #6366f1;
    flex-shrink: 0;
}
.st-section-heading .sh-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}
.st-section-heading .sh-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 0.25rem;
}

/* ── Form Grid ── */
.st-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}
.st-grid .full { grid-column: 1 / -1; }
@media (max-width: 640px) {
    .st-grid { grid-template-columns: 1fr; }
}

/* ── Form Group ── */
.st-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}
.st-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.st-group label .required {
    color: #ef4444;
    font-weight: 700;
}
.st-group input[type="text"],
.st-group input[type="number"],
.st-group input[type="email"],
.st-group select {
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
.st-group input::placeholder {
    color: #9ca3af;
}
.st-group input:focus,
.st-group select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.st-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    padding-right: 2rem;
    cursor: pointer;
}
.st-group .hint {
    font-size: 0.7rem;
    color: #9ca3af;
    line-height: 1.4;
}
.st-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.st-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

/* ── Form Actions ── */
.st-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.st-btn {
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
.st-btn:hover { transform: translateY(-1px); }
.st-btn:active { transform: translateY(0); }
.st-btn-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.2);
}
.st-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(99,102,241,0.3);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .st-hero { padding: 1.75rem 1.5rem; }
    .st-card-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .st-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .st-hero .hero-text h1 { font-size: 1.15rem; }
    .st-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .st-hero .hero-icon svg { width: 20px; height: 20px; }
    .st-hero .hero-left { gap: 0.75rem; }
    .st-card-body { padding: 1.25rem; }
    .st-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    .st-section-heading { margin-bottom: 1rem; }
    .st-section-heading .sh-text { font-size: 0.85rem; }
    .st-grid { gap: 1rem; }
    .st-group label { font-size: 0.78rem; }
    .st-group input[type="text"],
    .st-group input[type="number"],
    .st-group select { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .st-actions { flex-direction: column; align-items: stretch; }
    .st-btn { justify-content: center; }
}
@media (max-width: 480px) {
    .st-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .st-hero .hero-text h1 { font-size: 1rem; }
    .st-hero .hero-text p { font-size: 0.75rem; }
    .st-card-body { padding: 1rem; }
    .st-section { margin-bottom: 1.25rem; padding-bottom: 1.25rem; }
    .st-grid { gap: 0.75rem; }
    .st-group label { font-size: 0.75rem; }
    .st-group input[type="text"],
    .st-group input[type="number"],
    .st-group select { padding: 0.45rem 0.625rem; font-size: 0.78rem; border-radius: 0.5rem; }
    .st-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
    .st-errors { padding: 0.75rem 1rem; }
    .st-errors .err-title { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="st-hero st-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Settings</h1>
                <p>Configure your store preferences</p>
            </div>
        </div>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="st-errors st-animate st-animate-d1">
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
    <div class="st-msg success st-animate st-animate-d1">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Form Card --}}
<div class="st-card st-animate st-animate-d1">
    <div class="st-card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Contact Information --}}
            <div class="st-section">
                <div class="st-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <span class="sh-text">Contact Information</span>
                    <span class="sh-sub">— Displayed on the frontend contact section</span>
                </div>
                <div class="st-grid">
                    <div class="st-group">
                        <label for="contact_phone">Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}" placeholder="+880 1XXX-XXXXXX">
                        @error('contact_phone')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group">
                        <label for="contact_email">Email</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $setting->contact_email) }}" placeholder="info@example.com">
                        @error('contact_email')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group full">
                        <label for="contact_address">Address</label>
                        <input type="text" name="contact_address" id="contact_address" value="{{ old('contact_address', $setting->contact_address) }}" placeholder="Street, city, zip code">
                        @error('contact_address')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group full">
                        <label for="contact_hours">Working Hours</label>
                        <input type="text" name="contact_hours" id="contact_hours" value="{{ old('contact_hours', $setting->contact_hours) }}" placeholder="Sat–Thu: 9:00 AM – 6:00 PM">
                        <span class="hint">Business hours displayed on the contact page</span>
                        @error('contact_hours')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Newsletter --}}
            <div class="st-section" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <div class="st-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span class="sh-text">Newsletter</span>
                    <span class="sh-sub">— Subscription section on the frontend</span>
                </div>
                <div class="st-grid">
                    <div class="st-group">
                        <label for="newsletter_heading">Heading</label>
                        <input type="text" name="newsletter_heading" id="newsletter_heading" value="{{ old('newsletter_heading', $setting->newsletter_heading) }}" placeholder="Stay in the Loop">
                        @error('newsletter_heading')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group">
                        <label for="newsletter_button_text">Button Text</label>
                        <input type="text" name="newsletter_button_text" id="newsletter_button_text" value="{{ old('newsletter_button_text', $setting->newsletter_button_text) }}" placeholder="Subscribe">
                        @error('newsletter_button_text')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group full">
                        <label for="newsletter_text">Description Text</label>
                        <input type="text" name="newsletter_text" id="newsletter_text" value="{{ old('newsletter_text', $setting->newsletter_text) }}" placeholder="Subscribe to get notified about new listings and offers.">
                        @error('newsletter_text')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group full">
                        <label for="newsletter_placeholder">Input Placeholder</label>
                        <input type="text" name="newsletter_placeholder" id="newsletter_placeholder" value="{{ old('newsletter_placeholder', $setting->newsletter_placeholder) }}" placeholder="Enter your email address">
                        @error('newsletter_placeholder')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                    <div class="st-group">
                        <label style="flex-direction:row; gap:0.625rem; cursor:pointer;">
                            <input type="checkbox" name="newsletter_enabled" value="1" {{ old('newsletter_enabled', $setting->newsletter_enabled) ? 'checked' : '' }} style="width:1.125rem;height:1.125rem;accent-color:#6366f1;">
                            Enable Newsletter Section
                        </label>
                        <span class="hint">Show or hide the newsletter subscription form on the frontend</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="st-actions" style="margin-top:2rem;">
                <button type="submit" class="st-btn st-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
