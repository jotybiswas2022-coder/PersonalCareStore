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
md-animate { animation: fadeUp 0.5s ease-out both; }
.md-animate-d1 { animation-delay: 0.05s; }
.md-animate-d2 { animation-delay: 0.1s; }
.md-animate-d3 { animation-delay: 0.15s; }

/* ── Hero ── */
.md-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #0f2a1e 40%, #13452a 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.md-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(16,185,129,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(52,211,153,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(5,150,105,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.md-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.md-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.md-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.md-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(16,185,129,0.18);
    border-radius: 0.75rem;
    color: #34d399;
    flex-shrink: 0;
}
.md-hero .hero-icon svg { width: 24px; height: 24px; }
.md-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.md-hero .hero-text .hero-msg-name {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}
.md-hero .hero-text .hero-msg-name svg {
    width: 12px;
    height: 12px;
    color: rgba(255,255,255,0.3);
}
.md-hero .btn-back {
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
.md-hero .btn-back:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* ── Message Detail Card ── */
.md-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
    margin-bottom: 1.5rem;
}
.md-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.md-card-body {
    padding: 2rem;
}

/* ── Info Grid ── */
.md-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}
@media (max-width: 640px) {
    .md-info-grid { grid-template-columns: 1fr; }
}
.md-info-item { }
.md-info-item .md-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.25rem;
}
.md-info-item .md-value {
    font-size: 0.9rem;
    color: #111827;
    font-weight: 500;
}

/* ── Message Body ── */
.md-message-body {
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    border: 1px solid #edf2f7;
    line-height: 1.7;
    color: #374151;
    white-space: pre-wrap;
    font-size: 0.9rem;
}

/* ── Status Badge ── */
.md-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.md-status.replied {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.md-status.replied .sdot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #10b981;
}
.md-status.unreplied {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}
.md-status.unreplied .sdot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #f59e0b;
}

/* ── Existing Reply Card ── */
.md-reply-card {
    background: linear-gradient(135deg, #f0fdf4, #d1fae5);
    border: 1px solid #a7f3d0;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    animation: fadeUp 0.35s ease-out;
}
.md-reply-card .reply-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #065f46;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}
.md-reply-card .reply-label svg {
    width: 16px;
    height: 16px;
}
.md-reply-card .reply-text {
    color: #065f46;
    line-height: 1.7;
    white-space: pre-wrap;
    font-size: 0.9rem;
}
.md-reply-card .reply-date {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

/* ── Reply Form Card ── */
.md-form-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.md-form-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}
.md-form-body {
    padding: 2rem;
}
.md-form-body h2 {
    font-size: 1rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.md-form-body h2 svg {
    width: 18px;
    height: 18px;
    color: #10b981;
    flex-shrink: 0;
}
.md-form-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    margin-bottom: 1rem;
}
.md-form-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
}
.md-form-group textarea {
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
    resize: vertical;
    min-height: 120px;
    line-height: 1.5;
}
.md-form-group textarea:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
}
.md-form-group .error {
    font-size: 0.72rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.md-form-group .error svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}
.md-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.5rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border: none;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(16,185,129,0.2);
}
.md-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(16,185,129,0.3);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .md-hero { padding: 1.75rem 1.5rem; }
    .md-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .md-card-body { padding: 1.5rem; }
    .md-form-body { padding: 1.5rem; }
}
@media (max-width: 768px) {
    .md-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .md-hero .hero-text h1 { font-size: 1.15rem; }
    .md-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .md-hero .hero-icon svg { width: 20px; height: 20px; }
    .md-hero .hero-left { gap: 0.75rem; }
    .md-hero .btn-back { width: 100%; justify-content: center; }
    .md-card-body { padding: 1.25rem; }
    .md-form-body { padding: 1.25rem; }
    .md-info-item .md-label { font-size: 0.65rem; }
    .md-info-item .md-value { font-size: 0.85rem; }
    .md-message-body { font-size: 0.85rem; padding: 1rem; }
    .md-reply-card { padding: 1.25rem; }
    .md-reply-card .reply-text { font-size: 0.85rem; }
    .md-form-body h2 { font-size: 0.9rem; }
    .md-form-group textarea { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .md-btn { width: 100%; justify-content: center; }
}
@media (max-width: 480px) {
    .md-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .md-hero .hero-text h1 { font-size: 1rem; }
    .md-hero .hero-text .hero-msg-name { font-size: 0.72rem; }
    .md-card-body { padding: 1rem; }
    .md-form-body { padding: 1rem; }
    .md-info-item .md-label { font-size: 0.6rem; }
    .md-info-item .md-value { font-size: 0.8rem; }
    .md-message-body { font-size: 0.8rem; padding: 0.875rem; }
    .md-reply-card { padding: 1rem; }
    .md-reply-card .reply-text { font-size: 0.8rem; }
    .md-reply-card .reply-date { font-size: 0.7rem; }
    .md-form-body h2 { font-size: 0.85rem; }
    .md-form-group textarea { padding: 0.45rem 0.625rem; font-size: 0.78rem; min-height: 100px; }
    .md-btn { font-size: 0.8rem; padding: 0.5rem 1.25rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="md-hero md-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Message Details</h1>
                <div class="hero-msg-name">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    From: {{ $message->name }}
                </div>
            </div>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Messages
        </a>
    </div>
</div>

{{-- Message Detail Card --}}
<div class="md-card md-animate md-animate-d1">
    <div class="md-card-body">
        <div class="md-info-grid">
            <div class="md-info-item">
                <div class="md-label">Name</div>
                <div class="md-value">{{ $message->name }}</div>
            </div>
            <div class="md-info-item">
                <div class="md-label">Email</div>
                <div class="md-value">
                    <a href="mailto:{{ $message->email }}" style="color:#4f46e5;text-decoration:none;">{{ $message->email }}</a>
                </div>
            </div>
            <div class="md-info-item">
                <div class="md-label">Date</div>
                <div class="md-value">{{ $message->created_at->format('F d, Y \\a\\t h:i A') }}</div>
            </div>
            <div class="md-info-item">
                <div class="md-label">Status</div>
                <div class="md-value">
                    <span class="md-status {{ $message->admin_reply ? 'replied' : 'unreplied' }}">
                        <span class="sdot"></span>
                        {{ $message->admin_reply ? 'Replied' : 'New' }}
                    </span>
                </div>
            </div>
        </div>

        <div style="margin-top: 0.5rem;">
            <div class="md-label" style="font-size:0.68rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.5rem;">Message</div>
            <div class="md-message-body">{{ $message->message }}</div>
        </div>
    </div>
</div>

{{-- Existing Reply --}}
@if($message->admin_reply)
    <div class="md-reply-card md-animate md-animate-d2">
        <div class="reply-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Your Reply
        </div>
        <div class="reply-text">{{ $message->admin_reply }}</div>
        <div class="reply-date">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Replied on {{ $message->replied_at->format('F d, Y \\a\\t h:i A') }}
        </div>
    </div>
@else
    {{-- Reply Form --}}
    <div class="md-form-card md-animate md-animate-d2">
        <div class="md-form-body">
            <form method="POST" action="{{ route('admin.messages.reply', $message->id) }}">
                @csrf
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Send Reply
                </h2>
                <div class="md-form-group">
                    <label for="admin_reply">Your Reply</label>
                    <textarea name="admin_reply" id="admin_reply" placeholder="Type your reply here..." required>{{ old('admin_reply') }}</textarea>
                    @error('admin_reply')<span class="error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="md-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Send Reply
                </button>
            </form>
        </div>
    </div>
@endif
@endsection
