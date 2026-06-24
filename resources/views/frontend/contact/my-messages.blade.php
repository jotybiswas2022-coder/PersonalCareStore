@extends('frontend.layouts.app')

@section('title', 'My Messages')

@section('content')
<div class="section">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <h1 style="font-size:2rem; font-weight:700; color:var(--secondary); margin-bottom:0.5rem;">My Messages</h1>
            <p style="color:var(--text-muted);">Messages sent from <strong>{{ $email }}</strong></p>
        </div>

        @if($messages->count())
            <div style="max-width:700px; margin:0 auto; display:flex; flex-direction:column; gap:1rem;">
                @foreach($messages as $msg)
                    <div style="background:#fff; border:1px solid var(--border); border-radius:var(--r-md); padding:1.25rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                            <span style="font-size:0.75rem; color:var(--text-light);">{{ $msg->created_at->format('d M Y, h:i A') }}</span>
                            <span style="font-size:0.75rem; padding:0.25rem 0.625rem; border-radius:999px; font-weight:600; {{ $msg->admin_reply ? 'background:#D1FAE5;color:#065F46;' : 'background:#FEF3C7;color:#92400E;' }}">{{ $msg->admin_reply ? 'Replied' : 'Pending' }}</span>
                        </div>
                        <p style="font-size:0.9375rem; color:var(--text); line-height:1.6; margin-bottom:0.75rem;">{{ $msg->message }}</p>
                        @if($msg->admin_reply)
                            <div style="background:var(--primary-pale); border-radius:var(--r-sm); padding:0.75rem 1rem; border-left:3px solid var(--primary);">
                                <p style="font-size:0.75rem; font-weight:600; color:var(--primary); margin-bottom:0.25rem;">Admin Reply:</p>
                                <p style="font-size:0.875rem; color:var(--text);">{{ $msg->admin_reply }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center; padding:4rem 0;">
                <p style="font-size:1.125rem; color:var(--text-muted);">No messages found.</p>
                <a href="{{ route('home') }}" style="display:inline-block; margin-top:1rem; padding:0.75rem 2rem; background:var(--primary); color:#fff; border-radius:var(--r-md); font-weight:600; text-decoration:none;">Back to Home</a>
            </div>
        @endif
    </div>
</div>
@endsection
