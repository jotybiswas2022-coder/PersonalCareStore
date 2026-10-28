@extends('frontend.layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'Privacy Policy for PersonalCareStore')

@section('content')
<div class="container" style="max-width: 800px; padding: 2rem 1rem; margin: 0 auto;">
    <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 1.5rem;">Privacy Policy</h1>
    <div style="line-height: 1.8; color: #374151;">
        <p style="margin-bottom: 1rem;">Last updated: {{ date('Y-m-d') }}</p>
        <p style="margin-bottom: 1rem;">PersonalCareStore respects your privacy and is committed to protecting your personal data.</p>
        <h2 style="font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.75rem;">Information We Collect</h2>
        <p style="margin-bottom: 1rem;">We collect information you provide directly, including name, email, phone number, and shipping address when placing orders or contacting us.</p>
        <h2 style="font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.75rem;">How We Use Your Information</h2>
        <p style="margin-bottom: 1rem;">We use your information to process orders, provide customer support, and improve our services.</p>
        <h2 style="font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.75rem;">Contact Us</h2>
        <p>If you have questions about this Privacy Policy, please contact us.</p>
    </div>
</div>
@endsection
