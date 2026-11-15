@extends('emails.layout')

@section('title', 'We received your message')
@section('heading', 'Thanks for reaching out')

@section('content')
    <p style="margin:0 0 14px;">Hi {{ $contactMessage->name }},</p>

    <p style="margin:0 0 18px;">
        We received your message and our team will reply as soon as possible,
        usually within one business day.
    </p>

    <div style="border-left:3px solid #2E8B57;background:#EDF9F2;border-radius:0 10px 10px 0;padding:12px 16px;color:#374151;font-size:14px;line-height:1.65;white-space:pre-line;">
        {{ $contactMessage->message }}
    </div>

    <p style="margin:18px 0 0;color:#617067;font-size:14px;">
        You can also follow the conversation on our site under
        <a href="{{ route('contact.my-messages', ['email' => $contactMessage->email]) }}" style="color:#17603C;">My messages</a>.
    </p>
@endsection
