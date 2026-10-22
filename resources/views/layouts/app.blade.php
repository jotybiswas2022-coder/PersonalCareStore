<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                -webkit-font-smoothing: antialiased;
                background: #f3f4f6;
                color: #111827;
                min-height: 100vh;
            }
            .app-layout { min-height: 100vh; background: #f3f4f6; }
            .page-header {
                background: #ffffff;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                padding: 1.5rem 1rem;
            }
            .page-header .inner {
                max-width: 1280px;
                margin: 0 auto;
            }
            @media (min-width: 640px) { .page-header { padding-left: 1.5rem; padding-right: 1.5rem; } }
            @media (min-width: 1024px) { .page-header { padding-left: 2rem; padding-right: 2rem; } }
            .page-content {
                padding: 3rem 1rem;
            }
            @media (min-width: 640px) { .page-content { padding-left: 1.5rem; padding-right: 1.5rem; } }
            @media (min-width: 1024px) { .page-content { padding-left: 2rem; padding-right: 2rem; } }
            .content-card {
                max-width: 1280px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 0.5rem;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                padding: 1.5rem;
            }
            .content-card p { color: #374151; }
        </style>
        @stack('styles')
    </head>
    <body>
        <div class="app-layout">
            @include('layouts.navigation')
            @isset($header)
                <header class="page-header">
                    <div class="inner">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <main class="page-content">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
