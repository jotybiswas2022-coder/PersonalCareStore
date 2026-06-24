<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BasaFinder - @yield('title', 'Find Your Perfect Rental Home')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
:root {
    --primary: #1A56DB;
    --primary-dark: #1048C8;
    --primary-light: #EBF2FF;
    --secondary: #0D1117;
    --accent: #C8A45C;
    --accent-light: #F5ECD7;
    --accent-dark: #A8893D;
    --gold: #C8A45C;
    --gold-light: #F5ECD7;
    --gold-dark: #A8893D;
    --bg: #F4F6FB;
    --white: #FFFFFF;
    --success: #10B981;
    --text: #1A1A2E;
    --text-muted: #64748B;
    --border: #E8EAF0;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 1px 4px rgba(15,23,42,0.06), 0 2px 6px rgba(15,23,42,0.04);
    --shadow-md: 0 4px 12px rgba(15,23,42,0.08), 0 8px 24px rgba(15,23,42,0.05);
    --shadow-lg: 0 12px 32px rgba(15,23,42,0.10), 0 24px 56px rgba(15,23,42,0.06);
    --font: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    --font-serif: 'Playfair Display', Georgia, serif;
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
    line-height: 1.65;
}
main { flex: 1; }
a { color: inherit; text-decoration: none; }
img { max-width: 100%; display: block; }
.container { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
@media (max-width: 640px) { .container { padding: 0 1rem; } }

.section { padding: 5rem 0; }
.section-header { text-align: center; margin-bottom: 3.5rem; }
.section-header h2 {
    font-family: var(--font-serif);
    font-size: 2.6rem;
    font-weight: 700;
    color: #1A1A2E;
    letter-spacing: -0.03em;
    margin-bottom: 0.75rem;
    line-height: 1.2;
}
.section-header p { color: #7B8499; max-width: 34rem; margin: 0 auto; font-size: 1rem; line-height: 1.75; }
.section-header .badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #F5ECD7, #FDF8F0);
    color: #A8893D;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0.4rem 1.1rem;
    border-radius: 9999px;
    margin-bottom: 1rem;
    border: 1px solid rgba(200,164,92,0.2);
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
@media (max-width: 768px) {
    .section { padding: 3.5rem 0; }
    .section-header h2 { font-size: 1.9rem; }
    .section-header p { font-size: 0.9rem; }
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.75rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9375rem;
    transition: all 0.28s cubic-bezier(0.16,1,0.3,1);
    cursor: pointer;
    border: none;
    text-decoration: none;
    letter-spacing: -0.01em;
}
.btn-primary {
    background: linear-gradient(135deg, #C8A45C, #A8893D);
    color: #fff;
    box-shadow: 0 4px 16px rgba(200,164,92,0.35);
}
.btn-primary:hover {
    background: linear-gradient(135deg, #D4B06A, #C8A45C);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(200,164,92,0.5);
}
.btn-accent {
    background: linear-gradient(135deg, #1A56DB, #7C3AED);
    color: #fff;
    box-shadow: 0 4px 16px rgba(26,86,219,0.3);
}
.btn-accent:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(26,86,219,0.45);
}
.btn-outline {
    background: transparent;
    color: var(--gold);
    border: 1.5px solid rgba(200,164,92,0.4);
}
.btn-outline:hover {
    background: var(--gold-light);
    border-color: var(--gold);
    transform: translateY(-2px);
}
.btn-white {
    background: #fff;
    color: var(--gold-dark);
    box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    border: 1px solid rgba(200,164,92,0.2);
}
.btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
.btn-sm { padding: 0.5rem 1.1rem; font-size: 0.84rem; border-radius: 10px; }
.btn-lg { padding: 1rem 2.25rem; font-size: 1.05rem; border-radius: 14px; }

.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
.grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
@media (max-width: 1024px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; gap: 1rem; } }

@keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.animate-fade-up { animation: fadeUp 0.7s ease-out both; }
.animate-fade-in { animation: fadeIn 0.5s ease-out both; }

.card {
    background: var(--white);
    border: 1px solid rgba(200,164,92,0.1);
    border-radius: 20px;
    transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
    box-shadow: 0 2px 8px rgba(26,26,46,0.05);
}
.card:hover {
    box-shadow: 0 16px 48px rgba(200,164,92,0.12), 0 24px 56px rgba(26,26,46,0.08);
    transform: translateY(-6px);
    border-color: rgba(200,164,92,0.25);
}
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
