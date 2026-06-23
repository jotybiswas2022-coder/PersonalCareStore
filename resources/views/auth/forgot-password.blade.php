@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 3rem 1rem;">
    <div style="width: 100%; max-width: 28rem;">
        <div style="background: #ffffff; border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 2rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; text-align: center; margin-bottom: 0.5rem;">Forgot Password</h1>
            <p style="font-size: 0.875rem; color: #6b7280; text-align: center; margin-bottom: 2rem;">Enter your email and we'll send you a reset link</p>

            @if(session('status'))
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem; color: #166534; font-size: 0.875rem;">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem; color: #991b1b; font-size: 0.875rem;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div style="margin-bottom: 1.25rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; color: #111827; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                           onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                           onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                </div>

                <button type="submit" style="width: 100%; background: #4f46e5; color: #ffffff; border: none; padding: 0.625rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-bottom: 1rem;"
                        onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">Email Password Reset Link</button>

                <div style="text-align: center;">
                    <a href="{{ route('login') }}" style="font-size: 0.875rem; color: #4f46e5; text-decoration: none; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='#4338ca'" onmouseout="this.style.color='#4f46e5'">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
