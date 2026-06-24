@extends('frontend.layouts.app')

@section('title', 'Message')

@push('styles')
<style>
body { background: var(--navy); }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}
.mm-animate { animation: fadeUp 0.5s ease-out both; }
.mm-d1 { animation-delay: 0.1s; }
.mm-d2 { animation-delay: 0.2s; }
.mm-d3 { animation-delay: 0.3s; }
.mm-d4 { animation-delay: 0.4s; }

.mm-wrap { max-width: 680px; margin: 0 auto; }

/* ── Header ── */
.mm-header { text-align: center; margin-bottom: 2.5rem; padding-top: 1rem; }
.mm-header-icon {
    width: 3.5rem; height: 3.5rem; margin: 0 auto 1rem;
    background: linear-gradient(135deg, rgba(96,165,250,0.1), rgba(167,139,250,0.06));
    border: 1px solid rgba(96,165,250,0.08);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    color: var(--primary);
    animation: float 3s ease-in-out infinite;
}
.mm-header h1 { font-size: 1.75rem; font-weight: 800; color: #fff; margin-bottom: 0.25rem; }
.mm-header .mm-sub { font-size: 0.8125rem; color: rgba(255,255,255,0.25); }

/* ── Glass Card ── */
.mm-card {
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(15,23,42,0.55), rgba(15,23,42,0.7));
    backdrop-filter: blur(40px) saturate(1.4);
    -webkit-backdrop-filter: blur(40px) saturate(1.4);
    border-radius: var(--r-lg);
    border: 1px solid rgba(96,165,250,0.06);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.06);
    position: relative;
    overflow: hidden;
}
.mm-card::before {
    content: '';
    position: absolute; inset: 0;
    border-radius: var(--r-lg);
    padding: 1px;
    background: linear-gradient(135deg, rgba(96,165,250,0.15), transparent 40%, transparent 60%, rgba(167,139,250,0.08));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite: exclude;
    pointer-events: none;
}

/* ── Sender ── */
.mm-sender {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}
.mm-sender .mm-avatar {
    width: 2.75rem; height: 2.75rem;
    border-radius: 12px;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1rem;
    color: #fff;
    border: 1px solid rgba(255,255,255,0.06);
}
.mm-sender .mm-sender-info { flex: 1; min-width: 0; }
.mm-sender .mm-sender-name {
    font-size: 0.9375rem; font-weight: 600; color: #fff; display: block;
}
.mm-sender .mm-sender-email {
    font-size: 0.75rem; color: rgba(255,255,255,0.3); display: block;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.mm-sender .mm-sender-date {
    font-size: 0.6875rem; color: rgba(255,255,255,0.2); display: block; margin-top: 0.125rem;
}
.mm-sender .mm-badge {
    font-size: 0.625rem;
    padding: 0.25rem 0.625rem;
    border-radius: 999px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    flex-shrink: 0;
}
.mm-sender .mm-badge.replied {
    background: rgba(16,185,129,0.1);
    color: #34D399;
    border: 1px solid rgba(16,185,129,0.12);
}
.mm-sender .mm-badge.pending {
    background: rgba(245,158,11,0.1);
    color: #FBBF24;
    border: 1px solid rgba(245,158,11,0.12);
}

/* ── Section ── */
.mm-section { margin-bottom: 1.5rem; }
.mm-section:last-child { margin-bottom: 0; }
.mm-section-label {
    font-size: 0.6875rem; font-weight: 700;
    color: rgba(255,255,255,0.25);
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 0.75rem;
    display: flex; align-items: center; gap: 0.375rem;
}
.mm-section-label svg { color: var(--primary); }

.mm-message-box {
    background: rgba(0,0,0,0.15);
    border: 1px solid rgba(255,255,255,0.03);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    position: relative;
}
.mm-message-box::before {
    content: '';
    position: absolute; top: -1px; left: 1.5rem; right: 1.5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(96,165,250,0.08), transparent);
}
.mm-message-box .mm-text {
    font-size: 0.9375rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.75;
}

/* ── Reply ── */
.mm-reply {
    background: rgba(37,99,235,0.04);
    border: 1px solid rgba(37,99,235,0.06);
    border-radius: 12px;
    padding: 1.125rem 1.25rem;
    border-left: 3px solid var(--primary);
    position: relative;
    overflow: hidden;
}
.mm-reply::after {
    content: '';
    position: absolute; top: 0; bottom: 0; left: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--primary), #4F46E5);
}
.mm-reply .mm-reply-label {
    font-size: 0.6875rem; font-weight: 700;
    color: var(--accent);
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 0.5rem;
    display: flex; align-items: center; gap: 0.375rem;
}
.mm-reply .mm-reply-label svg { color: var(--accent); }
.mm-reply .mm-reply-text {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.75;
}
.mm-reply .mm-reply-date {
    font-size: 0.6875rem;
    color: rgba(255,255,255,0.2);
    margin-top: 0.75rem;
    display: flex; align-items: center; gap: 0.25rem;
}

/* ── Waiting ── */
.mm-waiting {
    background: rgba(255,255,255,0.015);
    border: 1px dashed rgba(255,255,255,0.06);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
}
.mm-waiting .mm-waiting-icon {
    width: 2.5rem; height: 2.5rem; margin: 0 auto 0.75rem;
    background: rgba(245,158,11,0.06);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #FBBF24;
    animation: pulse 2s ease-in-out infinite;
}
.mm-waiting p {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.3);
    line-height: 1.6;
}

/* ── Save Link ── */
.mm-save-link {
    background: rgba(245,158,11,0.04);
    border: 1px solid rgba(245,158,11,0.1);
    border-radius: 14px;
    padding: 1.25rem;
    margin-top: 1.5rem;
    text-align: center;
}
.mm-save-link .mm-save-label {
    font-size: 0.8125rem;
    color: #FBBF24;
    font-weight: 600;
    display: flex; align-items: center; justify-content: center; gap: 0.375rem;
}
.mm-save-link .mm-url-wrap {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    background: rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.04);
    border-radius: 10px;
    padding: 0.5rem 0.75rem;
}
.mm-save-link .mm-url {
    flex: 1;
    font-size: 0.6875rem;
    color: var(--accent);
    word-break: break-all;
    user-select: all;
    text-align: left;
    font-family: var(--font);
    line-height: 1.5;
}
.mm-save-link .mm-copy-btn {
    flex-shrink: 0;
    padding: 0.375rem 0.75rem;
    background: rgba(96,165,250,0.08);
    border: 1px solid rgba(96,165,250,0.1);
    border-radius: 8px;
    color: var(--accent);
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: var(--font);
    white-space: nowrap;
}
.mm-save-link .mm-copy-btn:hover {
    background: rgba(96,165,250,0.15);
    border-color: rgba(96,165,250,0.2);
}

/* ── Buttons ── */
.mm-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, var(--primary), #4F46E5);
    color: #fff;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    font-family: var(--font);
}
.mm-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.35);
}

.mm-back-home {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    color: rgba(255,255,255,0.25);
    font-size: 0.8125rem;
    text-decoration: none;
    transition: color 0.2s;
}
.mm-back-home:hover {
    color: var(--accent);
}
.mm-back-home svg { transition: transform 0.2s; }
.mm-back-home:hover svg { transform: translateX(-2px); }
</style>
@endpush

@section('content')
@php
    $colors = ['#3B82F6','#8B5CF6','#EC4899','#F59E0B','#10B981','#06B6D4'];
    $color = $colors[crc32($message->email ?? $message->name) % count($colors)];
    $initials = implode('', array_map(function($s) { return strtoupper(substr($s, 0, 1)); }, array_filter(explode(' ', $message->name))));
    if (strlen($initials) > 2) $initials = substr($initials, 0, 2);
    if (!$initials) $initials = '?';
@endphp
<div class="section" style="padding:2rem 0;">
    <div class="container">
        <div class="mm-wrap">
            <div class="mm-header mm-animate mm-d1">
                <div class="mm-header-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <h1>Message Details</h1>
                <span class="mm-sub">View your inquiry and any replies</span>
            </div>

            <div class="mm-card mm-animate mm-d2">
                <div class="mm-sender">
                    <div class="mm-avatar" style="background:{{ $color }}1a; color:{{ $color }};">{{ $initials }}</div>
                    <div class="mm-sender-info">
                        <span class="mm-sender-name">{{ $message->name }}</span>
                        @if($message->email)
                            <span class="mm-sender-email">{{ $message->email }}</span>
                        @endif
                        <span class="mm-sender-date">{{ $message->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <span class="mm-badge {{ $message->admin_reply ? 'replied' : 'pending' }}">{{ $message->admin_reply ? 'Replied' : 'Pending' }}</span>
                </div>

                <div class="mm-section">
                    <div class="mm-section-label">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Your Message
                    </div>
                    <div class="mm-message-box">
                        <div class="mm-text">{{ $message->message }}</div>
                    </div>
                </div>

                @if($message->admin_reply)
                    <div class="mm-section" style="margin-bottom:0;">
                        <div class="mm-section-label">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                            Admin Reply
                        </div>
                        <div class="mm-reply">
                            <div class="mm-reply-text">{{ $message->admin_reply }}</div>
                            @if($message->replied_at)
                                <div class="mm-reply-date">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $message->replied_at->format('d M Y, h:i A') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="mm-section" style="margin-bottom:0;">
                        <div class="mm-section-label">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Status
                        </div>
                        <div class="mm-waiting">
                            <div class="mm-waiting-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <p>Waiting for admin reply.<br>Bookmark this page to check back later.</p>
                        </div>
                    </div>
                @endif
            </div>

            @if(!$message->admin_reply)
                <div class="mm-save-link mm-animate mm-d3">
                    <div class="mm-save-label">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                        Save this link to check your reply later
                    </div>
                    <div class="mm-url-wrap">
                        <span class="mm-url" id="mmUrl">{{ url()->current() }}</span>
                        <button class="mm-copy-btn" onclick="copyUrl()">Copy</button>
                    </div>
                </div>
                <script>
                function copyUrl() {
                    var el = document.getElementById('mmUrl');
                    var range = document.createRange();
                    range.selectNode(el);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    document.execCommand('copy');
                    window.getSelection().removeAllRanges();
                    var btn = document.querySelector('.mm-copy-btn');
                    btn.textContent = 'Copied!';
                    setTimeout(function() { btn.textContent = 'Copy'; }, 2000);
                }
                </script>
            @endif

            <div class="mm-animate mm-d4" style="text-align:center; margin-top:1.5rem; display:flex; flex-direction:column; align-items:center; gap:0.75rem;">
                <a href="{{ route('contact.find') }}" class="mm-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                    My Messages
                </a>
                <a href="{{ route('home') }}" class="mm-back-home">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection