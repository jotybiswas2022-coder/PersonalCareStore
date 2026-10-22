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
.pe-animate { animation: fadeUp 0.5s ease-out both; }
.pe-animate-d1 { animation-delay: 0.05s; }
.pe-animate-d2 { animation-delay: 0.1s; }
.pe-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.pe-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.pe-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(59,130,246,0.15) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(96,165,250,0.1) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(37,99,235,0.08) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.pe-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.pe-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.pe-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.pe-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(59,130,246,0.18);
    border-radius: 0.75rem;
    color: #60a5fa;
    flex-shrink: 0;
}
.pe-hero .hero-icon svg { width: 24px; height: 24px; }
.pe-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.pe-hero .hero-text .hero-bank-name {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.pe-hero .hero-text .hero-bank-name svg {
    width: 12px;
    height: 12px;
    color: rgba(255,255,255,0.3);
}
.pe-hero .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.125rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.75);
    border-radius: 0.625rem;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s ease;
    backdrop-filter: blur(4px);
}
.pe-hero .btn-back:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* ── Form Card ── */
.pe-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.pe-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.pe-card-body {
    padding: 2rem;
}

/* ── Section ── */
.pe-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #edf2f7;
}
.pe-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.pe-section-heading {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}
.pe-section-heading svg {
    width: 18px;
    height: 18px;
    color: #3b82f6;
    flex-shrink: 0;
}
.pe-section-heading .sh-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}
.pe-section-heading .sh-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 0.25rem;
}

/* ── Form Grid ── */
.pe-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}
.pe-grid .full { grid-column: 1 / -1; }
@media (max-width: 1024px) {
    .pe-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .pe-grid { grid-template-columns: 1fr; }
}

/* ── Form Group ── */
.pe-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}
.pe-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.pe-group label .required {
    color: #ef4444;
    font-weight: 700;
}
.pe-group input[type="text"],
.pe-group textarea {
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
.pe-group input::placeholder,
.pe-group textarea::placeholder {
    color: #9ca3af;
}
.pe-group input:focus,
.pe-group textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
.pe-group textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.5;
}
.pe-group .hint {
    font-size: 0.7rem;
    color: #9ca3af;
    line-height: 1.4;
}
.pe-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.pe-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

/* ── Checkbox ── */
.pe-checkbox {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding-top: 1.75rem;
}
.pe-checkbox input[type="checkbox"] {
    width: 1.1rem;
    height: 1.1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    accent-color: #3b82f6;
    cursor: pointer;
    flex-shrink: 0;
}
.pe-checkbox label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
}

/* ── Validation Errors Summary ── */
.pe-errors {
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
.pe-errors svg {
    width: 18px;
    height: 18px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 1px;
}
.pe-errors .err-content { flex: 1; }
.pe-errors .err-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 0.25rem;
}
.pe-errors .err-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.pe-errors .err-list li {
    font-size: 0.8rem;
    color: #b91c1c;
    padding: 0.125rem 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.pe-errors .err-list li::before {
    content: '';
    width: 0.3rem;
    height: 0.3rem;
    background: #ef4444;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Form Actions ── */
.pe-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.pe-btn {
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
.pe-btn:hover { transform: translateY(-1px); }
.pe-btn:active { transform: translateY(0); }
.pe-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    box-shadow: 0 2px 8px rgba(59,130,246,0.2);
}
.pe-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(59,130,246,0.3);
}
.pe-btn-secondary {
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
}
.pe-btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .pe-hero { padding: 1.75rem 1.5rem; }
    .pe-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .pe-card-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .pe-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .pe-hero .hero-text h1 { font-size: 1.15rem; }
    .pe-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .pe-hero .hero-icon svg { width: 20px; height: 20px; }
    .pe-hero .hero-left { gap: 0.75rem; }
    .pe-hero .hero-text .hero-bank-name { font-size: 0.75rem; }
    .pe-hero .btn-back { width: 100%; justify-content: center; }
    .pe-card-body { padding: 1.25rem; }
    .pe-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    .pe-section-heading { margin-bottom: 1rem; }
    .pe-section-heading .sh-text { font-size: 0.85rem; }
    .pe-grid { gap: 1rem; }
    .pe-group label { font-size: 0.78rem; }
    .pe-group input[type="text"],
    .pe-group textarea { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .pe-checkbox { padding-top: 1.25rem; }
    .pe-actions { flex-direction: column; align-items: stretch; }
    .pe-btn { justify-content: center; }
}
@media (max-width: 480px) {
    .pe-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .pe-hero .hero-text h1 { font-size: 1rem; }
    .pe-hero .hero-text .hero-bank-name { font-size: 0.7rem; }
    .pe-card-body { padding: 1rem; }
    .pe-section { margin-bottom: 1.25rem; padding-bottom: 1.25rem; }
    .pe-grid { gap: 0.75rem; }
    .pe-group label { font-size: 0.75rem; }
    .pe-group input[type="text"],
    .pe-group textarea { padding: 0.45rem 0.625rem; font-size: 0.78rem; border-radius: 0.5rem; }
    .pe-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
    .pe-errors { padding: 0.75rem 1rem; }
    .pe-errors .err-title { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="pe-hero pe-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Edit Payment Details</h1>
                <div class="hero-bank-name">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    {{ $paymentDetail->bank_name }} — {{ $paymentDetail->account_holder }}
                </div>
            </div>
        </div>
        <a href="{{ route('admin.payment-details.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Payment Details
        </a>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="pe-errors pe-animate pe-animate-d1">
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

{{-- Form Card --}}
<div class="pe-card pe-animate pe-animate-d1">
    <div class="pe-card-body">
        <form action="{{ route('admin.payment-details.update', $paymentDetail) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Bank Details --}}
            <div class="pe-section" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <div class="pe-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <span class="sh-text">Bank Account Details</span>
                    <span class="sh-sub">— Bank name, account info &amp; instructions</span>
                </div>
                <div class="pe-grid">
                    <div class="pe-group">
                        <label for="bank_name">Bank Name <span class="required">*</span></label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $paymentDetail->bank_name) }}" required placeholder="e.g. Bkash, Nagad, Rocket">
                        @error('bank_name')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="pe-group">
                        <label for="account_number">Account Number <span class="required">*</span></label>
                        <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $paymentDetail->account_number) }}" required placeholder="e.g. 01XX-XXXXXXX">
                        @error('account_number')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="pe-group">
                        <label for="account_holder">Account Holder <span class="required">*</span></label>
                        <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder', $paymentDetail->account_holder) }}" required placeholder="Full name as on account">
                        @error('account_holder')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="pe-checkbox" style="padding-top:0;">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $paymentDetail->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Active — account is available for customer payments</label>
                    </div>

                    <div class="pe-group full">
                        <label for="instructions">Payment Instructions</label>
                        <textarea name="instructions" id="instructions" rows="4" placeholder="Optional instructions for customers">{{ old('instructions', $paymentDetail->instructions) }}</textarea>
                        <span class="hint">These instructions will be shown to customers during checkout.</span>
                        @error('instructions')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="pe-actions" style="margin-top:2rem;">
                <button type="submit" class="pe-btn pe-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Update
                </button>
                <a href="{{ route('admin.payment-details.index') }}" class="pe-btn pe-btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
