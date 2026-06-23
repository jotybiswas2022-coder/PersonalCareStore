@extends('frontend.layouts.app')

@section('title', 'My Messages')

@push('styles')
<style>
    .msg-page { max-width: 48rem; margin: 0 auto; padding: 3rem 1.5rem; }
    .msg-page h1 { font-size: 1.75rem; font-weight: 700; color: #212529; margin-bottom: 0.5rem; }
    .msg-page .sub { color: #6b7280; font-size: 0.875rem; margin-bottom: 2rem; }
    .msg-page .sub strong { color: #2E8B57; }
    .success-msg { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; margin-bottom: 1.5rem; }
    .msg-card { background: #ffffff; border-radius: 0.75rem; border: 1px solid #e9ecef; padding: 1.5rem; margin-bottom: 1rem; transition: box-shadow 0.2s; }
    .msg-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .msg-card .meta { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem; }
    .msg-card .date { font-size: 0.8125rem; color: #6b7280; }
    .msg-card .status { font-size: 0.75rem; font-weight: 500; padding: 0.125rem 0.625rem; border-radius: 9999px; }
    .msg-card .status.replied { background: #f0fdf4; color: #166534; }
    .msg-card .status.pending { background: #fef9c3; color: #854d0e; }
    .msg-card .body { font-size: 0.9375rem; color: #374151; line-height: 1.6; white-space: pre-wrap; }
    .msg-card .reply { margin-top: 1rem; padding: 1rem; background: #E8F5E9; border-radius: 0.5rem; border-left: 3px solid #2E8B57; }
    .msg-card .reply .label { font-size: 0.75rem; font-weight: 600; color: #1B5E20; text-transform: uppercase; }
    .msg-card .reply .text { margin-top: 0.375rem; font-size: 0.875rem; color: #212529; line-height: 1.5; white-space: pre-wrap; }
    .msg-card .reply .date { margin-top: 0.375rem; font-size: 0.75rem; color: #6b7280; }
    .empty-state { text-align: center; padding: 3rem 1.5rem; color: #6b7280; }
    .back-link { display: inline-block; margin-top: 1.5rem; color: #2E8B57; text-decoration: none; font-weight: 500; font-size: 0.875rem; }
    .back-link:hover { text-decoration: underline; }
    .email-form { background: #ffffff; border-radius: 0.75rem; border: 1px solid #e9ecef; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .email-form label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
    .email-form .input-group { display: flex; gap: 0.75rem; }
    .email-form input { flex: 1; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9375rem; outline: none; transition: border-color 0.2s; }
    .email-form input:focus { border-color: #2E8B57; }
    .email-form button { background: linear-gradient(135deg, #2E8B57, #3CB371); color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-size: 0.9375rem; font-weight: 600; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
    .email-form button:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(46,139,87,0.3); }
    @media (max-width: 480px) {
        .email-form .input-group { flex-direction: column; }
        .email-form button { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="msg-page">
    <h1>My Messages</h1>

    @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
    @endif

    @if($email)
        <p class="sub">Showing messages sent from <strong>{{ $email }}</strong></p>

        @forelse($messages as $msg)
            <div class="msg-card">
                <div class="meta">
                    <span class="date">{{ $msg->created_at->format('M d, Y \\a\\t h:i A') }}</span>
                    @if($msg->admin_reply)
                        <span class="status replied">Replied</span>
                    @else
                        <span class="status pending">Pending</span>
                    @endif
                </div>
                <div class="body">{{ $msg->message }}</div>
                @if($msg->admin_reply)
                    <div class="reply">
                        <div class="label">Store Response</div>
                        <div class="text">{{ $msg->admin_reply }}</div>
                        <div class="date">Replied on {{ $msg->replied_at->format('M d, Y \\a\\t h:i A') }}</div>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <p style="font-size: 1.125rem; font-weight: 500; margin-bottom: 0.5rem; color: #212529;">No messages found</p>
                <p>You haven't sent any messages from this email address yet.</p>
            </div>
        @endforelse
    @else
        {{-- Email lookup form --}}
        <p class="sub">Enter your email address to view your messages and our responses.</p>
        <div class="email-form">
            <form method="GET" action="{{ route('contact.my-messages') }}">
                <label for="lookup_email">Your Email Address</label>
                <div class="input-group">
                    <input type="email" id="lookup_email" name="email" placeholder="you@example.com" required>
                    <button type="submit">View Messages</button>
                </div>
            </form>
        </div>
    @endif

    <a href="{{ route('home') }}" class="back-link">&larr; Back to Home</a>
</div>
@endsection
