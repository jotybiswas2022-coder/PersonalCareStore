@extends('frontend.layouts.app')

@section('title', 'Verify Email')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 3rem 1rem;">
    <div style="width: 100%; max-width: 28rem;">
        <div style="background: #ffffff; border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 2rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; text-align: center; margin-bottom: 0.5rem;">Verify Email</h1>
            <p style="font-size: 0.875rem; color: #6b7280; text-align: center; margin-bottom: 2rem;">Thanks for signing up! Please verify your email address.</p>

            @if (session('status') == 'verification-link-sent')
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem; color: #166534; font-size: 0.875rem;">A new verification link has been sent to your email.</div>
            @endif

            <div style="display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" style="background: #4f46e5; color: #ffffff; border: none; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: #ffffff; color: #dc2626; border: 1px solid #fecaca; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#ffffff'">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
