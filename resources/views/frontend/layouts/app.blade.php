<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PersonalCareStore - @yield('title', 'Home')</title>
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
    @include('frontend.partials.contact')
    @include('frontend.partials.footer')
    @stack('scripts')
</body>
</html>
