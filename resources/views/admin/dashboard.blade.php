@extends('admin.layouts.app')

@push('styles')
<style>
    /* ── Hero ── */
    .db-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        margin: -2rem -2rem 1.5rem;
        padding: 2rem 2rem 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .db-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -5%;
        width: 25rem;
        height: 25rem;
        background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .db-hero::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: 10%;
        width: 15rem;
        height: 15rem;
        background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .db-hero .hero-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .db-hero .hero-left {}
    .db-hero .hero-left h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .db-hero .hero-left h1 .greet { font-weight: 400; color: rgba(255,255,255,0.6); }
    .db-hero .hero-left p {
        font-size: 0.8125rem;
        color: rgba(255,255,255,0.5);
        margin-top: 0.125rem;
    }
    .db-hero .hero-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .db-hero .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 9999px;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.7);
    }
    .db-hero .btn-pl {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s;
    }
    .db-hero .btn-pl:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(16,185,129,0.3);
    }

    /* ── Dashboard Body ── */
    .db-body {
        animation: dbFadeIn 0.4s ease-out;
    }
    .db-section {
        margin-bottom: 1.25rem;
    }
    .db-section .sec-hdr {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .db-section .sec-hdr h2 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .db-section .sec-hdr h2 svg { color: #6366f1; }
    .db-section .sec-hdr .sec-link {
        font-size: 0.75rem;
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
    }
    .db-section .sec-hdr .sec-link:hover { text-decoration: underline; }

    /* ── Stats Grid ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    .stat-card {
        background: #fff;
        border-radius: 0.75rem;
        padding: 1.25rem;
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        transition: all 0.25s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }
    .stat-card .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .stat-card .stat-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }
    .stat-card .stat-badge {
        font-size: 0.65rem;
        font-weight: 600;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
    }
    .stat-card .stat-badge.today { background: #dbeafe; color: #1e40af; }
    .stat-card .stat-badge.new { background: #d1fae5; color: #065f46; }
    .stat-card .stat-badge.alert { background: #fee2e2; color: #991b1b; }
    .stat-card .stat-lbl {
        font-size: 0.72rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .stat-card .stat-val {
        font-size: 1.625rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.2;
        margin-top: 0.125rem;
    }
    .stat-card .stat-sub {
        font-size: 0.72rem;
        color: #9ca3af;
        margin-top: 0.125rem;
    }

    /* ── Order Progress ── */
    .progress-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.875rem;
    }
    .prog-card {
        background: #fff;
        border-radius: 0.75rem;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.25s;
    }
    .prog-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }
    .prog-card .prog-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    .prog-card .prog-lbl {
        font-size: 0.68rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .prog-card .prog-val { font-size: 1.125rem; font-weight: 700; }
    .prog-card .bar-track {
        width: 100%;
        height: 0.375rem;
        background: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
    }
    .prog-card .bar-fill {
        height: 100%;
        border-radius: 9999px;
        transition: width 0.8s ease;
    }

    /* ── Finance Grid ── */
    .fin-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.875rem;
    }
    .fin-card {
        background: #fff;
        border-radius: 0.75rem;
        padding: 1rem 1.125rem;
        border: 1px solid #e5e7eb;
        transition: all 0.25s;
    }
    .fin-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }
    .fin-card .fin-lbl {
        font-size: 0.68rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    .fin-card .fin-val {
        font-size: 1.125rem;
        font-weight: 700;
    }
    .fin-card .fin-sub {
        font-size: 0.7rem;
        color: #9ca3af;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    .fin-card .fin-sub .dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ── Tables ── */
    .tbl-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }
    .tbl-wrap {
        background: #fff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: box-shadow 0.25s;
    }
    .tbl-wrap:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.04); }
    .tbl-wrap .tbl-hdr {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.875rem 1.125rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .tbl-wrap .tbl-hdr h3 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    .tbl-wrap .tbl-hdr h3 svg { color: #6366f1; }
    .tbl-wrap .tbl-hdr .cnt-badge {
        font-size: 0.65rem;
        font-weight: 600;
        color: #6b7280;
        background: #f3f4f6;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
    }
    .tbl-wrap table {
        width: 100%;
        border-collapse: collapse;
    }
    .tbl-wrap th {
        background: #f9fafb;
        text-align: left;
        padding: 0.5rem 1.125rem;
        font-size: 0.65rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid #e5e7eb;
    }
    .tbl-wrap td {
        padding: 0.625rem 1.125rem;
        font-size: 0.8rem;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }
    .tbl-wrap tr:last-child td { border-bottom: none; }
    .tbl-wrap tbody tr { transition: background 0.15s; }
    .tbl-wrap tbody tr:hover td { background: #f8faff; }
    .tbl-wrap .badge {
        display: inline-flex;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    .tbl-wrap .order-link {
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .tbl-wrap .order-link:hover { color: #4f46e5; text-decoration: underline; }
    .tbl-wrap .prod-img {
        width: 2rem;
        height: 2rem;
        object-fit: cover;
        border-radius: 0.375rem;
        background: #f3f4f6;
    }
    .tbl-wrap .empty-state {
        text-align: center;
        color: #9ca3af;
        padding: 1.5rem 1.125rem;
        font-size: 0.8rem;
    }

    /* ── Animation ── */
    @keyframes dbFadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ── Quick Action Cards ── */
    .quick-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.875rem;
        margin-bottom: 1.25rem;
    }
    .quick-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: #fff;
        border-radius: 0.75rem;
        padding: 1rem 1.125rem;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        transition: all 0.25s;
    }
    .quick-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        border-color: #6366f1;
    }
    .quick-card .q-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .quick-card .q-text { flex: 1; }
    .quick-card .q-text .q-lbl {
        font-size: 0.75rem;
        font-weight: 600;
        color: #111827;
    }
    .quick-card .q-text .q-sub {
        font-size: 0.68rem;
        color: #6b7280;
    }
    .quick-card .q-arrow { color: #9ca3af; }

    /* ── Responsive ── */
    @media (max-width: 1280px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .progress-row { grid-template-columns: repeat(3, 1fr); }
        .fin-row { grid-template-columns: repeat(2, 1fr); }
        .quick-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 1024px) {
        .tbl-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .db-hero { margin: -1rem -1rem 1rem; padding: 1.25rem 1rem 1.5rem; }
        .db-hero .hero-row { flex-direction: column; align-items: flex-start; }
        .db-hero .hero-left h1 { font-size: 1.2rem; flex-wrap: wrap; gap: 0.25rem; }
        .db-hero .hero-left p { font-size: 0.75rem; }
        .db-hero .hero-actions { width: 100%; flex-wrap: wrap; gap: 0.5rem; }
        .db-hero .date-badge { font-size: 0.7rem; padding: 0.3rem 0.65rem; }
        .db-hero .btn-pl { font-size: 0.75rem; padding: 0.4rem 0.75rem; }
        .stats-row { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
        .progress-row { grid-template-columns: repeat(2, 1fr); }
        .quick-row { grid-template-columns: 1fr; }
        .db-section .sec-hdr h2 { font-size: 0.85rem; }
        .stat-card { padding: 1rem; }
        .stat-card .stat-icon { width: 2rem; height: 2rem; }
        .stat-card .stat-icon svg { width: 16px; height: 16px; }
        .stat-card .stat-badge { font-size: 0.6rem; }
        .stat-card .stat-lbl { font-size: 0.65rem; }
        .stat-card .stat-val { font-size: 1.25rem; }
        .prog-card { padding: 0.75rem; }
        .prog-card .prog-val { font-size: 1rem; }
        .fin-card { padding: 0.75rem 0.875rem; }
        .fin-card .fin-val { font-size: 1rem; }
        .tbl-wrap { overflow-x: auto; }
        .tbl-wrap table { min-width: 360px; }
        .tbl-wrap th { padding: 0.4rem 0.75rem; font-size: 0.6rem; }
        .tbl-wrap td { padding: 0.5rem 0.75rem; font-size: 0.75rem; }
    }
    @media (max-width: 640px) {
        .stats-row { grid-template-columns: 1fr; }
        .progress-row { grid-template-columns: 1fr; }
        .fin-row { grid-template-columns: 1fr; }
        .db-hero .hero-actions { width: 100%; flex-wrap: wrap; }
        .db-hero .hero-left h1 { font-size: 1.05rem; }
        .stat-card .stat-val { font-size: 1.125rem; }
    }
    @media (max-width: 480px) {
        .db-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1rem 0.75rem 1.25rem; }
        .db-hero .hero-left h1 { font-size: 0.95rem; }
        .quick-row { gap: 0.625rem; }
        .quick-card { padding: 0.75rem 0.875rem; gap: 0.5rem; }
        .quick-card .q-icon { width: 2rem; height: 2rem; }
        .quick-card .q-icon svg { width: 16px; height: 16px; }
        .quick-card .q-text .q-lbl { font-size: 0.7rem; }
        .quick-card .q-text .q-sub { font-size: 0.6rem; }
        .stat-card { padding: 0.75rem; }
        .stat-card .stat-icon { width: 1.75rem; height: 1.75rem; }
        .stat-card .stat-icon svg { width: 14px; height: 14px; }
        .stat-card .stat-lbl { font-size: 0.6rem; }
        .stat-card .stat-val { font-size: 1rem; }
        .stat-card .stat-sub { font-size: 0.65rem; }
        .prog-card { padding: 0.625rem; }
        .prog-card .prog-lbl { font-size: 0.6rem; }
        .prog-card .prog-val { font-size: 0.875rem; }
        .prog-card .bar-track { height: 0.3rem; }
        .fin-row { gap: 0.625rem; }
        .fin-card { padding: 0.625rem 0.75rem; }
        .fin-card .fin-lbl { font-size: 0.6rem; }
        .fin-card .fin-val { font-size: 0.875rem; }
        .fin-card .fin-sub { font-size: 0.6rem; }
        .tbl-wrap .tbl-hdr { padding: 0.625rem 0.75rem; }
        .tbl-wrap .tbl-hdr h3 { font-size: 0.75rem; }
        .tbl-wrap th { padding: 0.3rem 0.625rem; font-size: 0.55rem; }
        .tbl-wrap td { padding: 0.4rem 0.625rem; font-size: 0.7rem; }
        .db-section { margin-bottom: 0.875rem; }
        .db-section .sec-hdr h2 { font-size: 0.8rem; }
        .stats-row { gap: 0.5rem; }
        .progress-row { gap: 0.5rem; }
    }
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="db-hero">
    <div class="hero-row">
        <div class="hero-left">
            <h1>
                <span class="greet">Welcome back,</span>
                {{ auth()->user()->name }}
            </h1>
            <p>{{ now()->timezone('Asia/Dhaka')->format('l, F j, Y') }}</p>
        </div>
        <div class="hero-actions">
            <span class="date-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ now()->timezone('Asia/Dhaka')->format('M d, Y') }}
            </span>
            <a href="{{ route('admin.profit-loss.index') }}" class="btn-pl">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Profit & Loss
            </a>
        </div>
    </div>
</div>

<div class="db-body">

    {{-- Quick Actions --}}
    <div class="quick-row">
        <a href="{{ route('admin.products.create') }}" class="quick-card">
            <div class="q-icon" style="background:#ede9fe;color:#7c3aed;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </div>
            <div class="q-text">
                <div class="q-lbl">Add Product</div>
                <div class="q-sub">Create a new product</div>
            </div>
            <svg class="q-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="quick-card">
            <div class="q-icon" style="background:#dbeafe;color:#2563eb;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="q-text">
                <div class="q-lbl">View Orders</div>
                <div class="q-sub">Manage all orders</div>
            </div>
            <svg class="q-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="quick-card">
            <div class="q-icon" style="background:#fef3c7;color:#d97706;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="q-text">
                <div class="q-lbl">Messages</div>
                <div class="q-sub">{{ $unreadMessages }} unread</div>
            </div>
            <svg class="q-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="quick-card">
            <div class="q-icon" style="background:#d1fae5;color:#059669;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            </div>
            <div class="q-text">
                <div class="q-lbl">Settings</div>
                <div class="q-sub">Store configuration</div>
            </div>
            <svg class="q-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    {{-- Main Stats --}}
    <div class="db-section">
        <div class="sec-hdr">
            <h2>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Overview
            </h2>
        </div>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </div>
                    <span class="stat-badge today">{{ $todayOrders }} today</span>
                </div>
                <div class="stat-lbl">Total Orders</div>
                <div class="stat-val">{{ $totalOrders }}</div>
                <div class="stat-sub">All time orders placed</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon" style="background:#d1fae5;color:#059669;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span class="stat-badge new">{{ currencyFormat($todayRevenue) }} today</span>
                </div>
                <div class="stat-lbl">Total Revenue</div>
                <div class="stat-val">{{ $plStats ? currencyFormat($plStats->total_revenue) : currencyFormat(0) }}</div>
                <div class="stat-sub">{{ $plStats ? $plStats->total_qty . ' items sold' : 'No sales yet' }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon" style="background:#dbeafe;color:#2563eb;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <span class="stat-badge" style="background:#f3f4f6;color:#6b7280;">{{ $totalCustomers }} total</span>
                </div>
                <div class="stat-lbl">Customers</div>
                <div class="stat-val">{{ $totalCustomers }}</div>
                <div class="stat-sub">Registered users</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <span class="stat-badge" style="background:#f3f4f6;color:#6b7280;">{{ $totalCategories }} groups</span>
                </div>
                <div class="stat-lbl">Products</div>
                <div class="stat-val">{{ $totalProducts }}</div>
                <div class="stat-sub">
                    @if($lowStockProducts > 0)
                        <span style="color:#dc2626;">{{ $lowStockProducts }} low in stock</span>
                    @else
                        All in stock
                    @endif
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon" style="background:#fce7f3;color:#db2777;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <span class="stat-badge" style="background:#f3f4f6;color:#6b7280;">Reviews</span>
                </div>
                <div class="stat-lbl">Customer Reviews</div>
                <div class="stat-val">{{ $totalReviews }}</div>
                <div class="stat-sub">From your customers</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon" style="background:#e0e7ff;color:#4338ca;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <span class="stat-badge" style="background:#f3f4f6;color:#6b7280;">Messages</span>
                </div>
                <div class="stat-lbl">Unread Messages</div>
                <div class="stat-val">{{ $unreadMessages }}</div>
                <div class="stat-sub">
                    @if($unreadMessages > 0)
                        <a href="{{ route('admin.messages.index') }}" style="color:#6366f1;text-decoration:none;">View messages &rarr;</a>
                    @else
                        All clear
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Order Progress --}}
    <div class="db-section">
        <div class="sec-hdr">
            <h2>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Order Fulfillment
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="sec-link">View all orders &rarr;</a>
        </div>
        @php
            $totalStatusOrders = $pendingOrders + $processingOrders + $shippedOrders + $deliveredOrders;
            $pct = fn($v) => $totalStatusOrders > 0 ? round(($v / $totalStatusOrders) * 100, 1) : 0;
        @endphp
        <div class="progress-row">
            <div class="prog-card">
                <div class="prog-top">
                    <span class="prog-lbl">Pending</span>
                    <span class="prog-val" style="color:#d97706;">{{ $pendingOrders }}</span>
                </div>
                <div class="bar-track"><div class="bar-fill" style="width:{{ $pct($pendingOrders) }}%;background:#f59e0b;"></div></div>
            </div>
            <div class="prog-card">
                <div class="prog-top">
                    <span class="prog-lbl">Processing</span>
                    <span class="prog-val" style="color:#2563eb;">{{ $processingOrders }}</span>
                </div>
                <div class="bar-track"><div class="bar-fill" style="width:{{ $pct($processingOrders) }}%;background:#3b82f6;"></div></div>
            </div>
            <div class="prog-card">
                <div class="prog-top">
                    <span class="prog-lbl">Shipped</span>
                    <span class="prog-val" style="color:#7c3aed;">{{ $shippedOrders }}</span>
                </div>
                <div class="bar-track"><div class="bar-fill" style="width:{{ $pct($shippedOrders) }}%;background:#8b5cf6;"></div></div>
            </div>
            <div class="prog-card">
                <div class="prog-top">
                    <span class="prog-lbl">Delivered</span>
                    <span class="prog-val" style="color:#059669;">{{ $deliveredOrders }}</span>
                </div>
                <div class="bar-track"><div class="bar-fill" style="width:{{ $pct($deliveredOrders) }}%;background:#10b981;"></div></div>
            </div>
            <div class="prog-card">
                <div class="prog-top">
                    <span class="prog-lbl">Cancelled</span>
                    <span class="prog-val" style="color:#dc2626;">{{ $cancelledOrders }}</span>
                </div>
                <div class="bar-track"><div class="bar-fill" style="width:{{ $pct($cancelledOrders) }}%;background:#ef4444;"></div></div>
            </div>
        </div>
    </div>

    {{-- Payments & Finance --}}
    <div class="db-section">
        <div class="sec-hdr">
            <h2>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Payments &amp; Finance
            </h2>
        </div>
        <div class="fin-row">
            <div class="fin-card">
                <div class="fin-lbl"><span class="dot" style="background:#f59e0b;"></span> Unpaid</div>
                <div class="fin-val" style="color:#d97706;">{{ $paymentUnpaid }}</div>
                <div class="fin-sub">Awaiting payment</div>
            </div>
            <div class="fin-card">
                <div class="fin-lbl"><span class="dot" style="background:#f59e0b;"></span> Pending</div>
                <div class="fin-val" style="color:#d97706;">{{ $paymentPending }}</div>
                <div class="fin-sub">Proof submitted</div>
            </div>
            <div class="fin-card">
                <div class="fin-lbl"><span class="dot" style="background:#2563eb;"></span> Paid</div>
                <div class="fin-val" style="color:#2563eb;">{{ $paymentPaid }}</div>
                <div class="fin-sub">Awaiting approval</div>
            </div>
            <div class="fin-card">
                <div class="fin-lbl"><span class="dot" style="background:#10b981;"></span> Approved</div>
                <div class="fin-val" style="color:#059669;">{{ $paymentApproved }}</div>
                <div class="fin-sub">Payment confirmed</div>
            </div>
            <div class="fin-card">
                <div class="fin-lbl"><span class="dot" style="background:#ef4444;"></span> Rejected</div>
                <div class="fin-val" style="color:#dc2626;">{{ $paymentRejected }}</div>
                <div class="fin-sub">Payment declined</div>
            </div>
            <div class="fin-card">
                <div class="fin-lbl"><span class="dot" style="background:#ef4444;"></span> Cancelled Orders</div>
                <div class="fin-val" style="color:#dc2626;">{{ $cancelledOrders }}</div>
                <div class="fin-sub">Orders cancelled</div>
            </div>
            @if($plStats)
                @php $netProfit = $plStats->total_revenue - $plStats->total_base_cost; @endphp
                <div class="fin-card">
                    <div class="fin-lbl"><span class="dot" style="background:#10b981;"></span> Net Profit</div>
                    <div class="fin-val" style="color:{{ $netProfit >= 0 ? '#059669' : '#dc2626' }};">
                        {{ $netProfit >= 0 ? '+' : '' }}{{ currencyFormat($netProfit) }}
                    </div>
                    <div class="fin-sub">Base cost: {{ currencyFormat($plStats->total_base_cost) }}</div>
                </div>
                <div class="fin-card">
                    @php $margin = $plStats->total_revenue > 0 ? round(($netProfit / $plStats->total_revenue) * 100, 1) : 0; @endphp
                    <div class="fin-lbl"><span class="dot" style="background:{{ $margin >= 0 ? '#10b981' : '#ef4444' }};"></span> Margin</div>
                    <div class="fin-val" style="color:{{ $margin >= 0 ? '#059669' : '#dc2626' }};">
                        {{ $margin >= 0 ? '+' : '' }}{{ $margin }}%
                    </div>
                    <div class="fin-sub">Profit margin</div>
                </div>
            @endif
        </div>
    </div>

    {{-- Tables --}}
    <div class="db-section" style="margin-bottom:0;">
        <div class="tbl-row">
            <div class="tbl-wrap">
                <div class="tbl-hdr">
                    <h3>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                        Recent Orders
                    </h3>
                    <span class="cnt-badge">{{ $recentOrders->count() }} latest</span>
                </div>
                <table>
                    <thead>
                        <tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $o)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $o->id) }}" class="order-link">{{ $o->order_number }}</a></td>
                                <td>{{ $o->email }}</td>
                                <td>{{ currencyFormat($o->total) }}</td>
                                <td>
                                    <span class="badge" style="background:{{ $o->status === 'pending' ? '#fef3c7' : ($o->status === 'processing' ? '#dbeafe' : ($o->status === 'shipped' ? '#e0e7ff' : ($o->status === 'delivered' ? '#d1fae5' : '#fee2e2'))) }};color:{{ $o->status === 'pending' ? '#92400e' : ($o->status === 'processing' ? '#1e40af' : ($o->status === 'shipped' ? '#3730a3' : ($o->status === 'delivered' ? '#065f46' : '#991b1b'))) }};">
                                        {{ ucfirst($o->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="tbl-wrap">
                <div class="tbl-hdr">
                    <h3>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Recently Added Products
                    </h3>
                    <span class="cnt-badge">{{ $recentProducts->count() }} latest</span>
                </div>
                <table>
                    <thead>
                        <tr><th>Image</th><th>Name</th><th>Price</th><th>Stock</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $p)
                            @php
                                $images = $p->images ?: [];
                                $imgUrl = count($images) > 0 ? config('app.storage_url') . '/' . $images[0] : null;
                            @endphp
                            <tr>
                                <td>
                                    @if($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="" class="prod-img">
                                    @else
                                        <div class="prod-img" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:0.5rem;">N/A</div>
                                    @endif
                                </td>
                                <td style="font-weight:500;">{{ $p->name }}</td>
                                <td>{{ currencyFormat($p->sale_price ?? $p->price) }}</td>
                                <td>
                                    <span style="display:inline-flex;align-items:center;gap:0.25rem;">
                                        <span style="width:0.5rem;height:0.5rem;border-radius:50%;background:{{ $p->stock_quantity > 10 ? '#16a34a' : ($p->stock_quantity > 0 ? '#f59e0b' : '#ef4444') }};"></span>
                                        {{ $p->stock_quantity }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">No products yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
