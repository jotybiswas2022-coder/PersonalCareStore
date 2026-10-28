@extends('frontend.layouts.app')

@section('title', 'Page Not Found')
@section('meta_description', 'The page you are looking for could not be found.')

@section('content')
<div style="min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
    <div style="text-align: center; max-width: 28rem;">
        <h1 style="font-size: 4rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem;">404</h1>
        <p style="font-size: 1.25rem; color: #4b5563; margin-bottom: 2rem;">Oops! Page not found.</p>
        <p style="color: #6b7280; margin-bottom: 2rem;">The page you are looking for might have been removed or is temporarily unavailable.</p>
        <a href="{{ route('home') }}" style="display: inline-block; background: #16a34a; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600;">Back to Home</a>
    </div>
</div>
@endsection
