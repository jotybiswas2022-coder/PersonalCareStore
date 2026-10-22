<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - PersonalCareStore</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f1f5f9;
            color: #111827;
            min-height: 100vh;
        }
        #app {
            display: flex;
            min-height: 100vh;
        }
        main {
            flex: 1;
            padding: 2rem;
            margin-left: 250px;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        @media (max-width: 768px) {
            #app { flex-direction: column; }
            main { margin-left: 0; padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        @include('admin.partials.sidebar')
        <main>
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
