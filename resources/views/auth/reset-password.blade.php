@extends('frontend.layouts.app')

@section('title', 'Reset Password')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 3rem 1rem;">
    <div style="width: 100%; max-width: 28rem;">
        <div style="background: #ffffff; border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 2rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; text-align: center; margin-bottom: 0.5rem;">Reset Password</h1>
            <p style="font-size: 0.875rem; color: #6b7280; text-align: center; margin-bottom: 2rem;">Enter your new password</p>

            @if($errors->any())
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem; color: #991b1b; font-size: 0.875rem;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div style="margin-bottom: 1.25rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                           style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; color: #111827; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                           onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                           onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; color: #111827; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                           onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                           onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; color: #111827; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                           onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                           onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                </div>

                <button type="submit" style="width: 100%; background: #4f46e5; color: #ffffff; border: none; padding: 0.625rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                        onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
