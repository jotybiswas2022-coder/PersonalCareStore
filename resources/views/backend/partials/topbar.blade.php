@php
use Illuminate\Support\Str;
@endphp

<style>
.topbar-link:hover { color:#fff !important; background:rgba(255,255,255,0.08) !important; }
.topbar-link.active-link { color:#fff !important; background:rgba(99,102,241,0.2) !important; }

/* Mobile nav dropdown */
.mobile-nav { background:rgba(15,23,42,0.98); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,0.06); border-radius:12px; margin-top:0.5rem; padding:0.5rem; }
.mobile-nav .nav-item { width:100%; }
.mobile-nav .nav-link { display:flex; align-items:center; gap:0.75rem; padding:0.6rem 0.85rem; border-radius:8px; color:rgba(255,255,255,0.7); font-weight:500; font-size:0.85rem; transition:all 0.2s; }
.mobile-nav .nav-link:hover { color:#fff !important; background:rgba(99,102,241,0.12) !important; }
.mobile-nav .nav-link i { width:20px; text-align:center; color:rgba(255,255,255,0.4); }
.mobile-nav .nav-link:hover i { color:#818cf8; }
.mobile-nav .nav-link.active-link { color:#fff !important; background:rgba(99,102,241,0.18) !important; }
.mobile-nav .nav-link.active-link i { color:#818cf8; }
.mobile-nav .nav-divider { height:1px; background:rgba(255,255,255,0.06); margin:0.4rem 0; }
.mobile-nav .logout-btn { display:flex; align-items:center; gap:0.75rem; padding:0.6rem 0.85rem; border-radius:8px; color:rgba(248,113,113,0.8); font-weight:500; font-size:0.85rem; background:none; border:none; width:100%; text-align:left; font-family:inherit; cursor:pointer; transition:all 0.2s; }
.mobile-nav .logout-btn:hover { color:#f87171 !important; background:rgba(248,113,113,0.1) !important; }
.mobile-nav .logout-btn i { width:20px; text-align:center; color:rgba(248,113,113,0.5); }
</style>

<nav class="navbar navbar-expand-md py-0" style="height:auto; min-height:57px; background:linear-gradient(180deg,#0f172a,#1e293b); border-bottom:1px solid rgba(255,255,255,0.06); box-shadow:0 2px 12px rgba(0,0,0,0.15); color:#fff; position:sticky; top:0; z-index:1050;">
    <div class="container-fluid px-3">
        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center fw-bold fs-5 py-0" href="/admin" style="color:#fff;">
            <i class="bi bi-speedometer2 me-2 fs-3" style="background:linear-gradient(135deg,#818cf8,#a78bfa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;"></i>
            <span class="d-none d-sm-inline">{{ config('app.name', 'Admin') }}</span>
            <span class="d-sm-none">Admin</span>
        </a>

        {{-- Mobile 3-dot Toggler --}}
        <button class="navbar-toggler border-0 py-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopNav" aria-label="Toggle navigation" style="color:rgba(255,255,255,0.7);">
            <span class="navbar-toggler-icon" style="filter:brightness(0) invert(1);"></span>
        </button>

        {{-- Desktop quick links (always visible) + Mobile nav (collapsible) --}}
        <div class="collapse navbar-collapse" id="navbarTopNav">
            <ul class="navbar-nav ms-auto gap-1 align-items-center d-none d-md-flex">
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('/') ? 'active-link' : '' }}" href="/" style="color:rgba(255,255,255,0.7); font-size:0.85rem; font-weight:500; padding:0.4rem 0.85rem; border-radius:8px; transition:all 0.2s;">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ Str::startsWith(request()->path(), 'admin') ? 'active-link' : '' }}" href="/admin" style="color:rgba(255,255,255,0.7); font-size:0.85rem; font-weight:500; padding:0.4rem 0.85rem; border-radius:8px; transition:all 0.2s;">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link fw-semibold topbar-link" style="color:rgba(255,255,255,0.7); font-size:0.85rem; text-decoration:none; font-weight:500; padding:0.4rem 0.85rem; border-radius:8px; transition:all 0.2s; border:none; background:transparent;">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>

            {{-- Mobile nav: sidebar links in dropdown --}}
            <ul class="navbar-nav d-md-none w-100 mobile-nav">
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin') ? 'active-link' : '' }}" href="{{ url('/admin') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/account') ? 'active-link' : '' }}" href="{{ url('/admin/account') }}">
                        <i class="bi bi-person-circle"></i> Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/projects*') ? 'active-link' : '' }}" href="{{ url('/admin/projects') }}">
                        <i class="bi bi-folder2-open"></i> Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/services*') ? 'active-link' : '' }}" href="{{ url('/admin/services') }}">
                        <i class="bi bi-gear"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/experiences*') ? 'active-link' : '' }}" href="{{ url('/admin/experiences') }}">
                        <i class="bi bi-briefcase"></i> Experiences
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/skills*') ? 'active-link' : '' }}" href="{{ url('/admin/skills') }}">
                        <i class="bi bi-lightning-charge"></i> Skills
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/testimonials*') ? 'active-link' : '' }}" href="{{ url('/admin/testimonials') }}">
                        <i class="bi bi-chat-quote"></i> Testimonials
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/faqs*') ? 'active-link' : '' }}" href="{{ url('/admin/faqs') }}">
                        <i class="bi bi-question-circle"></i> FAQs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link topbar-link {{ request()->is('admin/contact') ? 'active-link' : '' }}" href="{{ url('/admin/contact') }}">
                        <i class="bi bi-envelope-paper"></i> Messages
                    </a>
                </li>

                <li class="nav-divider"></li>

                <li class="nav-item">
                    <a class="nav-link topbar-link" href="/">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>