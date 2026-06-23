<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BasaFinder - @yield('title', 'Find Your Perfect Rental Home')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --primary-light: #DBEAFE;
            --secondary: #0F172A;
            --accent: #F59E0B;
            --accent-light: #FEF3C7;
            --bg: #F8FAFC;
            --white: #FFFFFF;
            --success: #10B981;
            --text: #1E293B;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --radius: 14px;
            --radius-sm: 10px;
            --shadow: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
            --shadow-md: 0 4px 6px rgba(15,23,42,0.06), 0 10px 15px rgba(15,23,42,0.04);
            --shadow-lg: 0 10px 25px rgba(15,23,42,0.08), 0 20px 48px rgba(15,23,42,0.04);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }
        main { flex: 1; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
        @media (max-width: 640px) { .container { padding: 0 1rem; } }
        .section { padding: 5rem 0; }
        .section-header { text-align: center; margin-bottom: 3.5rem; }
        .section-header h2 { font-size: 2rem; font-weight: 800; color: var(--secondary); letter-spacing: -0.03em; margin-bottom: 0.75rem; }
        .section-header p { color: var(--text-muted); max-width: 32rem; margin: 0 auto; font-size: 1rem; line-height: 1.7; }
        .section-header .badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--primary-light); color: var(--primary); font-size: 0.8125rem; font-weight: 600; padding: 0.375rem 1rem; border-radius: 9999px; margin-bottom: 1rem; }
        @media (max-width: 768px) { .section { padding: 3rem 0; } .section-header h2 { font-size: 1.5rem; } .section-header p { font-size: 0.875rem; } }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.9375rem; transition: all 0.25s ease; cursor: pointer; border: none; text-decoration: none; }
        .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,0.3); }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
        .btn-accent { background: var(--accent); color: var(--secondary); box-shadow: 0 4px 14px rgba(245,158,11,0.3); }
        .btn-accent:hover { background: #D97706; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,158,11,0.4); }
        .btn-outline { background: transparent; color: var(--primary); border: 2px solid var(--primary); }
        .btn-outline:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }
        .btn-white { background: #fff; color: var(--primary); box-shadow: 0 4px 14px rgba(0,0,0,0.1); }
        .btn-white:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .btn-sm { padding: 0.5rem 1rem; font-size: 0.8125rem; }
        .btn-lg { padding: 1rem 2.25rem; font-size: 1.0625rem; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        @media (max-width: 1024px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; gap: 1rem; } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-up { animation: fadeUp 0.7s ease-out both; }
        .animate-fade-in { animation: fadeIn 0.5s ease-out both; }
        .card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); transition: all 0.3s ease; }
        .card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
    </style>
    @stack('styles')
</head>
<body>
    @include('frontend.partials.nav')
    <main>
        @yield('content')
    </main>
    @include('frontend.partials.footer')
    @stack('scripts')
</body>
</html>
