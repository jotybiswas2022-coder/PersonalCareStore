@extends('frontend.layouts.app')

@section('title', 'Message')

@push('styles')
<style>
body { background: var(--navy); }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.mm-animate { animation: fadeUp 0.5s ease-out both; }
.mm-d1 { animation-delay: 0.1s; }
.mm-d2 { animation-delay: 0.2s; }
.mm-d3 { animation-delay: 0.3s; }

.mm-wrap { max-width: 700px; margin: 0 auto; }

.mm-header { text-align: center; margin-bottom: 2rem; padding-top: 0.5rem; }
.mm-header h1 { font-size: 1.75rem; font-weight: 800; color: #fff; margin-bottom: 0.375rem; }

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

.mm-top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}
.mm-date { font-size: 0.8125rem; color: rgba(255,255,255,0.35); }
.mm-date svg { vertical-align: middle; margin-right: 4px; }
.mm-badge {
    font-size: 0.6875rem;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-weight: 700;
    letter-spacing: 0.02em;
}
.mm-badge.replied {
    background: rgba(16,185,129,0.12);
    color: #34D399;
    border: 1px solid rgba(16,185,129,0.15);
}
.mm-badge.pending {
    background: rgba(245,158,11,0.12);
    color: #FBBF24;
    border: 1px solid rgba(245,158,11,0.15);
}

.mm-section { margin-bottom: 1.5rem; }
.mm-section:last-child { margin-bottom: 0; }
.mm-section-label {
    font-size: 0.6875rem;
    font-weight: 700;
    color: rgba(255,255,255,0.3);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.5rem;
}
.mm-section-label svg { vertical-align: middle; margin-right: 4px; }
.mm-section .mm-text {
    font-size: 0.9375rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
}

.mm-reply {
    background: rgba(37,99,235,0.05);
    border: 1px solid rgba(37,99,235,0.08);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    border-left: 3px solid var(--primary);
}
.mm-reply .mm-reply-label {
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.5rem;
}
.mm-reply .mm-reply-text {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
}
.mm-reply .mm-reply-date {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.3);
    margin-top: 0.5rem;
}

.mm-waiting {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.04);
    border-radius: 12px;
    padding: 1.25rem;
    text-align: center;
}
.mm-waiting p {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.35);
}

.mm-save-link {
    background: rgba(245,158,11,0.06);
    border: 1px solid rgba(245,158,11,0.12);
    border-radius: 12px;
    padding: 1.25rem;
    margin-top: 1.5rem;
    text-align: center;
}
.mm-save-link p {
    font-size: 0.8125rem;
    color: #FBBF24;
    font-weight: 600;
}
.mm-save-link .mm-url {
    font-size: 0.75rem;
    color: var(--accent);
    word-break: break-all;
    margin-top: 0.5rem;
    user-select: all;
}

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
    display: inline-block;
    color: rgba(255,255,255,0.3);
    font-size: 0.8125rem;
    text-decoration: none;
    transition: color 0.2s;
}
.mm-back-home:hover { color: var(--accent); }
</style>
@endpush

@section('content')
<div class="section" style="padding:2rem 0;">
    <div class="container">
        <div class="mm-wrap">
            <div class="mm-header mm-animate mm-d1">
                <h1>Your Message</h1>
            </div>

            <div class="mm-card mm-animate mm-d2">
                <div class="mm-top-row">
                    <span class="mm-date"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $message->created_at->format('d M Y, h:i A') }}</span>
                    <span class="mm-badge {{ $message->admin_reply ? 'replied' : 'pending' }}">{{ $message->admin_reply ? 'Replied' : 'Pending' }}</span>
                </div>

                <div class="mm-section">
                    <div class="mm-section-label"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg> Your Message</div>
                    <div class="mm-text">{{ $message->message }}</div>
                </div>

                @if($message->admin_reply)
                    <div class="mm-reply">
                        <div class="mm-reply-label"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg> Admin Reply</div>
                        <div class="mm-reply-text">{{ $message->admin_reply }}</div>
                        @if($message->replied_at)
                            <div class="mm-reply-date">Replied on {{ $message->replied_at->format('d M Y, h:i A') }}</div>
                        @endif
                    </div>
                @else
                    <div class="mm-waiting">
                        <p>Waiting for admin reply. Bookmark this page to check back later.</p>
                    </div>
                @endif
            </div>

            @if(!$message->admin_reply)
                <div class="mm-save-link mm-animate mm-d3">
                    <p>Save this link to check your reply later:</p>
                    <div class="mm-url">{{ url()->current() }}</div>
                </div>
            @endif

            <div style="text-align:center; margin-top:1.5rem; display:flex; flex-direction:column; align-items:center; gap:0.75rem;">
                <a href="{{ route('contact.find') }}" class="mm-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                    My Messages
                </a>
                <a href="{{ route('home') }}" class="mm-back-home">Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection