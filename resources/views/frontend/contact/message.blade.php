@extends('frontend.layouts.app')

@section('title', 'Message')

@section('content')
<div class="section">
    <div class="container">
        <div style="max-width:700px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:2.5rem;">
                <h1 style="font-size:1.75rem; font-weight:700; color:var(--secondary); margin-bottom:0.5rem;">Your Message</h1>
            </div>

            <div style="background:#fff; border:1px solid var(--border); border-radius:var(--r-md); padding:1.5rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem;">
                    <div>
                        <p style="font-size:0.8125rem; color:var(--text-light);">Sent on {{ $message->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <span style="font-size:0.75rem; padding:0.25rem 0.75rem; border-radius:999px; font-weight:600; {{ $message->admin_reply ? 'background:#D1FAE5;color:#065F46;' : 'background:#FEF3C7;color:#92400E;' }}">{{ $message->admin_reply ? 'Replied' : 'Pending' }}</span>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <p style="font-size:0.75rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.375rem;">Your Message</p>
                    <p style="font-size:0.9375rem; color:var(--text); line-height:1.7;">{{ $message->message }}</p>
                </div>

                @if($message->admin_reply)
                    <div style="background:var(--primary-pale); border-radius:var(--r-sm); padding:1rem 1.25rem; border-left:3px solid var(--primary);">
                        <p style="font-size:0.75rem; font-weight:600; color:var(--primary); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.375rem;">Admin Reply</p>
                        <p style="font-size:0.875rem; color:var(--text); line-height:1.7;">{{ $message->admin_reply }}</p>
                        @if($message->replied_at)
                            <p style="font-size:0.75rem; color:var(--text-light); margin-top:0.5rem;">Replied on {{ $message->replied_at->format('d M Y, h:i A') }}</p>
                        @endif
                    </div>
                @else
                    <div style="background:#F8FAFC; border-radius:var(--r-sm); padding:1rem 1.25rem; text-align:center;">
                        <p style="font-size:0.875rem; color:var(--text-muted);">Waiting for admin reply. Bookmark this page to check back later.</p>
                    </div>
                @endif
            </div>

            <div style="text-align:center; margin-top:2rem;">
                <a href="{{ route('home') }}" style="display:inline-block; padding:0.75rem 2rem; background:var(--primary); color:#fff; border-radius:var(--r-md); font-weight:600; text-decoration:none;">Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection
