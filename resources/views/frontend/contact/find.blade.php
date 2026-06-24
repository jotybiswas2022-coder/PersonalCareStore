@extends('frontend.layouts.app')

@section('title', 'My Messages')

@section('content')
<div class="section">
    <div class="container">
        <div style="max-width:700px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:2.5rem;">
                <h1 style="font-size:1.75rem; font-weight:700; color:var(--secondary); margin-bottom:0.5rem;">My Messages</h1>
            </div>

            @if($messages->count())
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach($messages as $msg)
                        <a href="{{ route('contact.message', $msg->view_token) }}" style="display:flex; justify-content:space-between; align-items:center; background:#fff; border:1px solid var(--border); border-radius:var(--r-md); padding:1rem 1.25rem; text-decoration:none; transition:all 0.2s; gap:1rem;" onmouseover="this.style.borderColor='var(--primary)';this.style.boxShadow='0 2px 12px rgba(37,99,235,0.1)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                            <div>
                                <span style="font-size:0.875rem; color:var(--text); font-weight:500;">{{ $msg->name }}</span>
                                <span style="font-size:0.75rem; color:var(--text-light); display:block; margin-top:0.125rem;">{{ $msg->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            <span style="font-size:0.75rem; padding:0.25rem 0.625rem; border-radius:999px; font-weight:600; flex-shrink:0; {{ $msg->admin_reply ? 'background:#D1FAE5;color:#065F46;' : 'background:#FEF3C7;color:#92400E;' }}">{{ $msg->admin_reply ? 'Replied' : 'Pending' }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding:4rem 0;">
                    <p style="font-size:1rem; color:var(--text-muted);">No messages yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
