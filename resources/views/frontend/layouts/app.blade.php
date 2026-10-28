<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="description" content="@yield('meta_description', 'PersonalCareStore - Premium personal care and home care products. Quality you can trust, delivered to your door.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('title', 'PersonalCareStore')">
    <meta property="og:description" content="@yield('meta_description', 'Premium personal care and home care products.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('logo.svg'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'PersonalCareStore')">
    <meta name="twitter:description" content="@yield('meta_description', 'Premium personal care and home care products.')">
    <meta name="twitter:image" content="@yield('og_image', asset('logo.svg'))">
    <title>@yield('title', 'PersonalCareStore') - PersonalCareStore</title>
    @if(config('services.google.analytics_id'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.google.analytics_id') }}');
    </script>
    @endif
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #F8F9FA;
            color: #212529;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        @media (min-width: 640px) {
            .container {
                padding: 0 1.5rem;
            }
        }
        @media (min-width: 1024px) {
            .container {
                padding: 0 2rem;
            }
        }
        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .mb-8 {
            margin-bottom: 2rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('frontend.partials.nav')
    <main>
        @yield('content')
    </main>
    {{-- Auth screens opt out of the storefront contact + footer blocks --}}
    @hasSection('hide-footer')
    @else
        @include('frontend.partials.contact')
        @include('frontend.partials.footer')
    @endif
    @stack('scripts')
</body>
</html>
