@extends('admin.layouts.app')

@push('styles')
<style>
* { box-sizing:border-box; }

/* ── Entrance ── */
@keyframes dfUp   { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
@keyframes dfIn   { from { opacity:0; transform:scale(0.92); } to { opacity:1; transform:scale(1); } }
@keyframes dfGlow { 0%,100% { opacity:0.3; transform:scale(1); } 50% { opacity:0.6; transform:scale(1.1); } }
@keyframes dfFloat { 0%,100% { transform:translateY(0) rotate(0deg); } 33% { transform:translateY(-8px) rotate(1deg); } 66% { transform:translateY(4px) rotate(-1deg); } }
@keyframes dfShimmer { 0% { background-position:-200% 0; } 100% { background-position:200% 0; } }
.df-a1 { animation:dfUp 0.6s cubic-bezier(0.16,1,0.3,1) both; }
.df-a2 { animation:dfUp 0.5s cubic-bezier(0.16,1,0.3,1) both; }
.df-a3 { animation:dfIn 0.45s cubic-bezier(0.16,1,0.3,1) both; }

/* ── Hero ── */
.df-hero {
    position:relative; isolation:isolate;
    margin:-2rem -2rem 1.75rem; padding:2.5rem 2.5rem 3rem;
    background:linear-gradient(135deg,#070b17 0%,#0f1a30 30%,#1a1a3e 60%,#0b1120 100%);
    overflow:hidden;
}
.df-hero::after {
    content:''; position:absolute; inset:0;
    background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events:none; z-index:0;
}
.df-hero .hf-orbs { position:absolute; inset:0; z-index:0; overflow:hidden; pointer-events:none; }
.df-hero .hf-orbs span {
    position:absolute; border-radius:50%; filter:blur(80px);
    animation:dfGlow 6s ease-in-out infinite;
}
.df-hero .hf-orbs span:nth-child(1) { width:22rem;height:22rem;top:-30%;right:-5%;background:rgba(99,102,241,0.15); animation-delay:0s; }
.df-hero .hf-orbs span:nth-child(2) { width:16rem;height:16rem;bottom:-20%;left:5%;background:rgba(16,185,129,0.1); animation-delay:2s; }
.df-hero .hf-orbs span:nth-child(3) { width:12rem;height:12rem;top:10%;left:40%;background:rgba(139,92,246,0.08); animation-delay:4s; }
.df-hero .hr-inner { position:relative; z-index:2; }
.df-hero .hr-top { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }
.df-hero .hr-left h1 {
    font-size:1.5rem; font-weight:800; color:#fff; letter-spacing:-0.03em;
    display:flex; align-items:center; gap:0.625rem;
}
.df-hero .hr-left h1 .greet { font-weight:400; color:rgba(255,255,255,0.45); font-size:1.125rem; }
.df-hero .hr-left h1 .hl-avatar {
    width:2.5rem; height:2.5rem; border-radius:0.75rem;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    display:flex; align-items:center; justify-content:center;
    font-size:0.875rem; font-weight:700; color:#fff; flex-shrink:0;
}
.df-hero .hr-left p { color:rgba(255,255,255,0.35); font-size:0.8125rem; margin-top:0.25rem; display:flex; align-items:center; gap:0.5rem; }
.df-hero .hr-left p .hp-dot { width:0.375rem; height:0.375rem; border-radius:50%; background:#34d399; display:inline-block; animation:dfGlow 2s ease-in-out infinite; }
.df-hero .date-badge {
    display:inline-flex; align-items:center; gap:0.5rem;
    padding:0.5rem 1rem;
    background:rgba(255,255,255,0.05); backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:9999px; font-size:0.75rem; color:rgba(255,255,255,0.55);
    transition:all 0.3s;
}
.df-hero .date-badge:hover { background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.15); }
.df-hero .hr-bot {
    margin-top:1.5rem; padding-top:1.5rem;
    border-top:1px solid rgba(255,255,255,0.05);
    display:flex; gap:2rem; flex-wrap:wrap;
}
.df-hero .hr-stat { display:flex; align-items:center; gap:0.75rem; }
.df-hero .hr-stat .hs-icon {
    width:2.25rem; height:2.25rem; border-radius:0.5rem;
    display:flex; align-items:center; justify-content:center;
    background:rgba(255,255,255,0.05); flex-shrink:0;
}
.df-hero .hr-stat .hs-l { display:flex; flex-direction:column; }
.df-hero .hr-stat .hs-l .hs-v { font-size:1.125rem; font-weight:700; color:#fff; line-height:1.2; }
.df-hero .hr-stat .hs-l .hs-lb { font-size:0.68rem; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:0.04em; }

.df-body { padding:0 0.125rem; }

/* ── Stats Row ── */
.df-stats {
    display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;
}
.df-card {
    position:relative; overflow:hidden;
    background:#fff; border-radius:1rem; padding:1.25rem 1.375rem;
    border:1px solid #e5e7eb;
    transition:all 0.35s cubic-bezier(0.16,1,0.3,1);
}
.df-card:hover { transform:translateY(-4px) scale(1.01); box-shadow:0 16px 40px -8px rgba(0,0,0,0.12); border-color:transparent; }
.df-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    border-radius:1rem 1rem 0 0; opacity:0; transition:opacity 0.3s;
}
.df-card:hover::before { opacity:1; }
.df-card .df-glow {
    position:absolute; top:-50%; right:-50%; width:100%; height:100%;
    border-radius:50%; opacity:0; transition:all 0.5s;
    filter:blur(60px); pointer-events:none;
}
.df-card:hover .df-glow { opacity:0.08; transform:scale(1.4); }
.df-card .df-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem; position:relative; }
.df-card .df-icon {
    width:2.75rem; height:2.75rem; border-radius:0.75rem;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; position:relative; transition:all 0.3s;
}
.df-card:hover .df-icon { transform:scale(1.05) rotate(-3deg); }
.df-card .df-badge {
    font-size:0.6rem; font-weight:700; padding:0.15rem 0.5rem;
    border-radius:9999px; letter-spacing:0.02em;
}
.df-card .df-label { font-size:0.72rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.04em; position:relative; }
.df-card .df-value { font-size:2rem; font-weight:800; color:#111827; line-height:1.15; position:relative; letter-spacing:-0.02em; }
.df-card .df-sub { font-size:0.72rem; color:#9ca3af; margin-top:0.25rem; display:flex; align-items:center; gap:0.375rem; position:relative; }
.df-card .df-sub .df-dot { width:0.375rem; height:0.375rem; border-radius:50%; display:inline-block; }

/* ── Quick Actions ── */
.df-quick {
    display:grid; grid-template-columns:repeat(4,1fr); gap:0.875rem; margin-bottom:1.5rem;
}
.df-q {
    display:flex; align-items:center; gap:0.75rem;
    background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem;
    padding:0.875rem 1rem; text-decoration:none; position:relative; overflow:hidden;
    transition:all 0.35s cubic-bezier(0.16,1,0.3,1);
}
.df-q:hover { transform:translateY(-3px) scale(1.02); box-shadow:0 12px 32px -8px rgba(0,0,0,0.1); border-color:#6366f1; }
.df-q .df-qi {
    width:2.5rem; height:2.5rem; border-radius:0.625rem;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
    transition:all 0.3s;
}
.df-q:hover .df-qi { transform:scale(1.08) rotate(-4deg); }
.df-q .df-qt { flex:1; }
.df-q .df-qt .df-ql { font-size:0.8rem; font-weight:600; color:#111827; }
.df-q .df-qt .df-qs { font-size:0.68rem; color:#6b7280; margin-top:0.0625rem; }
.df-q .df-arrow { color:#9ca3af; flex-shrink:0; transition:all 0.3s; }
.df-q:hover .df-arrow { transform:translateX(4px); color:#6366f1; }
.df-q .df-qbg {
    position:absolute; top:-60%; right:-30%; width:8rem; height:8rem;
    border-radius:50%; opacity:0; transition:all 0.5s;
    filter:blur(50px); pointer-events:none;
}
.df-q:hover .df-qbg { opacity:0.07; transform:scale(1.3); }

/* ── Section ── */
.df-section { margin-bottom:1.75rem; }
.df-section .df-sh {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:0.875rem;
}
.df-section .df-sh h2 {
    font-size:0.9375rem; font-weight:700; color:#111827;
    display:flex; align-items:center; gap:0.5rem;
}
.df-section .df-sh h2 svg { color:#6366f1; }
.df-section .df-sh .df-sl { font-size:0.75rem; color:#6366f1; text-decoration:none; font-weight:500; }
.df-section .df-sh .df-sl:hover { text-decoration:underline; }

/* ── Overview Grid ── */
.df-ov {
    display:grid; grid-template-columns:repeat(4,1fr); gap:0.875rem;
}
.df-ov-card {
    position:relative; overflow:hidden;
    background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem;
    padding:1rem 1.125rem;
    transition:all 0.35s cubic-bezier(0.16,1,0.3,1);
}
.df-ov-card:hover { transform:translateY(-3px); box-shadow:0 12px 32px -8px rgba(0,0,0,0.08); }
.df-ov-card .ov-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem; }
.df-ov-card .ov-lbl {
    font-size:0.68rem; font-weight:600; color:#6b7280;
    text-transform:uppercase; letter-spacing:0.03em;
    display:flex; align-items:center; gap:0.375rem;
}
.df-ov-card .ov-lbl .ov-dot { width:0.5rem; height:0.5rem; border-radius:50%; display:inline-block; flex-shrink:0; }
.df-ov-card .ov-icon {
    width:1.75rem; height:1.75rem; border-radius:0.375rem;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.df-ov-card .ov-val { font-size:1.25rem; font-weight:700; color:#111827; margin-top:0.125rem; }
.df-ov-card .ov-bar {
    width:100%; height:0.3125rem; background:#f3f4f6; border-radius:9999px;
    margin-top:0.625rem; overflow:hidden;
}
.df-ov-card .ov-bar .ov-fill {
    height:100%; border-radius:9999px;
    transition:width 1s cubic-bezier(0.16,1,0.3,1);
}

/* ── Tables ── */
.df-tbls { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
.df-tbl {
    background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem;
    overflow:hidden; transition:all 0.35s;
}
.df-tbl:hover { box-shadow:0 8px 24px -8px rgba(0,0,0,0.06); border-color:#d1d5db; }
.df-tbl .df-th {
    display:flex; align-items:center; justify-content:space-between;
    padding:1rem 1.25rem;
    background:linear-gradient(135deg,#f8faff,#f0f4ff);
    border-bottom:1px solid #e5e7eb;
}
.df-tbl .df-th h3 {
    font-size:0.875rem; font-weight:700; color:#1e293b; margin:0;
    display:flex; align-items:center; gap:0.5rem;
}
.df-tbl .df-th h3 .th-glow {
    width:1.75rem; height:1.75rem; border-radius:0.375rem;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg,#eef2ff,#e0e7ff);
}
.df-tbl .df-th .df-cnt {
    font-size:0.65rem; font-weight:600; color:#6b7280;
    background:#fff; border:1px solid #e5e7eb;
    padding:0.125rem 0.5rem; border-radius:9999px;
}
.df-tbl table { width:100%; border-collapse:collapse; }
.df-tbl th {
    text-align:left;
    padding:0.625rem 1.25rem; font-size:0.65rem; font-weight:700;
    color:#64748b; text-transform:uppercase; letter-spacing:0.04em;
    background:#fafbfc; border-bottom:1px solid #e5e7eb;
}
.df-tbl td {
    padding:0.75rem 1.25rem; font-size:0.8125rem;
    border-bottom:1px solid #f3f4f6; color:#374151;
    transition:all 0.15s;
}
.df-tbl tr:last-child td { border-bottom:none; }
.df-tbl tbody tr { transition:all 0.15s; cursor:default; }
.df-tbl tbody tr:hover td { background:linear-gradient(135deg,#f8faff,#f0f4ff); }
.df-tbl tbody tr:active td { background:#eef2ff; }
.df-tbl .badge {
    display:inline-flex; align-items:center; gap:0.375rem;
    padding:0.125rem 0.625rem;
    border-radius:9999px; font-size:0.625rem; font-weight:700;
}
.df-tbl .badge::before { content:''; width:0.375rem; height:0.375rem; border-radius:50%; display:inline-block; }
.df-tbl .badge-pending { background:#fffbeb; color:#92400e; }
.df-tbl .badge-pending::before { background:#f59e0b; }
.df-tbl .badge-approved { background:#ecfdf5; color:#065f46; }
.df-tbl .badge-approved::before { background:#10b981; }
.df-tbl .badge-rejected { background:#fef2f2; color:#991b1b; }
.df-tbl .badge-rejected::before { background:#ef4444; }
.df-tbl .badge-unread { background:#eff6ff; color:#1e40af; }
.df-tbl .badge-unread::before { background:#3b82f6; }
.df-tbl .badge-read { background:#f3f4f6; color:#6b7280; }
.df-tbl .badge-read::before { background:#9ca3af; }
.df-tbl .empty { text-align:center; color:#9ca3af; padding:2rem 1.25rem; font-size:0.8125rem; }
.df-tbl .msg-subj { max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.df-tbl .td-bold { font-weight:600; color:#111827; }

/* ── Responsive ── */
@media (max-width:1280px) {
    .df-stats { grid-template-columns:repeat(2,1fr); }
    .df-quick { grid-template-columns:repeat(2,1fr); }
    .df-ov { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:1024px) {
    .df-tbls { grid-template-columns:1fr; }
}
@media (max-width:768px) {
    .df-hero { margin:-1rem -1rem 1.25rem; padding:1.25rem 1rem 1.5rem; }
    .df-hero .hr-top { flex-direction:column; align-items:flex-start; }
    .df-hero .hr-left h1 { font-size:1.2rem; flex-wrap:wrap; }
    .df-hero .hr-left h1 .greet { font-size:1rem; }
    .df-hero .hr-left p { font-size:0.75rem; }
    .df-hero .hr-bot { gap:1.25rem; }
    .df-stats { grid-template-columns:repeat(2,1fr); gap:0.75rem; }
    .df-card { padding:1rem; }
    .df-card .df-value { font-size:1.5rem; }
    .df-card .df-icon { width:2.25rem; height:2.25rem; }
    .df-card .df-icon svg { width:18px; height:18px; }
    .df-quick { grid-template-columns:repeat(2,1fr); gap:0.625rem; }
    .df-section .df-sh h2 { font-size:0.875rem; }
    .df-ov { grid-template-columns:repeat(2,1fr); gap:0.625rem; }
}
@media (max-width:480px) {
    .df-hero { margin:-0.75rem -0.75rem 1rem; padding:1rem 0.75rem 1.25rem; }
    .df-hero .hr-left h1 { font-size:1rem; }
    .df-hero .hr-left h1 .greet { font-size:0.875rem; }
    .df-stats { grid-template-columns:1fr; gap:0.625rem; }
    .df-card { padding:0.875rem; }
    .df-card .df-value { font-size:1.375rem; }
    .df-card .df-icon { width:2rem; height:2rem; }
    .df-quick { grid-template-columns:1fr; gap:0.5rem; }
    .df-ov { grid-template-columns:1fr; gap:0.5rem; }
    .df-tbl { overflow-x:auto; }
    .df-tbl table { min-width:360px; }
    .df-tbl th { padding:0.5rem 0.75rem; font-size:0.6rem; }
    .df-tbl td { padding:0.5rem 0.75rem; font-size:0.75rem; }
}
</style>
@endpush

@section('content')
<div class="df-hero df-a1">
    <div class="hf-orbs">
        <span></span><span></span><span></span>
    </div>
    <div class="hr-inner">
        <div class="hr-top">
            <div class="hr-left">
                <h1>
                    <span class="hl-avatar">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    <span><span class="greet">Welcome back,</span> {{ auth()->user()->name }}</span>
                </h1>
                <p>
                    <span class="hp-dot"></span>
                    {{ now()->timezone('Asia/Dhaka')->format('l, F j, Y') }}
                </p>
            </div>
            <div class="hr-right">
                <span class="date-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ now()->timezone('Asia/Dhaka')->format('M d, Y') }}
                </span>
            </div>
        </div>
        <div class="hr-bot">
            <div class="hr-stat">
                <div class="hs-icon" style="color:#818cf8;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                <div class="hs-l"><span class="hs-v">{{ $totalUsers }}</span><span class="hs-lb">Total Users</span></div>
            </div>
            <div class="hr-stat">
                <div class="hs-icon" style="color:#fbbf24;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                <div class="hs-l"><span class="hs-v">{{ $totalProperties }}</span><span class="hs-lb">Properties</span></div>
            </div>
            <div class="hr-stat">
                <div class="hs-icon" style="color:#34d399;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                <div class="hs-l"><span class="hs-v">{{ $totalMessages }}</span><span class="hs-lb">Messages</span></div>
            </div>
            <div class="hr-stat">
                <div class="hs-icon" style="color:#a78bfa;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                <div class="hs-l"><span class="hs-v">{{ $totalFaqs }}</span><span class="hs-lb">FAQs</span></div>
            </div>
        </div>
    </div>
</div>

<div class="df-body">
    {{-- Stat Cards --}}
    <div class="df-stats">
        <div class="df-card df-a3" style="animation-delay:0.05s">
            <div class="df-glow" style="background:#6366f1;"></div>
            <div class="df-top">
                <div class="df-icon" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4f46e5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="df-badge" style="background:#eef2ff;color:#4f46e5;">All time</span>
            </div>
            <div class="df-label">Registered Users</div>
            <div class="df-value">{{ $totalUsers }}</div>
        </div>
        <div class="df-card df-a3" style="animation-delay:0.1s">
            <div class="df-glow" style="background:#f59e0b;"></div>
            <div class="df-top">
                <div class="df-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="df-badge" style="background:#fffbeb;color:#92400e;">{{ $pendingProperties }} pending</span>
            </div>
            <div class="df-label">Properties Listed</div>
            <div class="df-value">{{ $totalProperties }}</div>
            <div class="df-sub">
                <span class="df-dot" style="background:#10b981;"></span> {{ $approvedProperties }} approved
                <span class="df-dot" style="background:#ef4444;margin-left:0.5rem;"></span> {{ $rejectedProperties }} rejected
            </div>
        </div>
        <div class="df-card df-a3" style="animation-delay:0.15s">
            <div class="df-glow" style="background:#10b981;"></div>
            <div class="df-top">
                <div class="df-icon" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span class="df-badge" style="background:#ecfdf5;color:#065f46;">{{ $activeTestimonials }} active</span>
            </div>
            <div class="df-label">Testimonials</div>
            <div class="df-value">{{ $totalTestimonials }}</div>
            <div class="df-sub">From your valued clients</div>
        </div>
        <div class="df-card df-a3" style="animation-delay:0.2s">
            <div class="df-glow" style="background:#8b5cf6;"></div>
            <div class="df-top">
                <div class="df-icon" style="background:linear-gradient(135deg,#f3e8ff,#ede9fe);color:#7c3aed;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="9" y1="10" x2="15" y2="10"/></svg>
                </div>
                <span class="df-badge" style="background:#eff6ff;color:#1e40af;">{{ $unreadMessages }} unread</span>
            </div>
            <div class="df-label">Messages</div>
            <div class="df-value">{{ $totalMessages }}</div>
            <div class="df-sub">
                <span class="df-dot" style="background:#3b82f6;"></span> Awaiting your reply
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="df-quick">
        <a href="{{ route('admin.to-let.index') }}" class="df-q df-a3" style="animation-delay:0.08s">
            <div class="df-qbg" style="background:#f59e0b;"></div>
            <div class="df-qi" style="background:#fef3c7;color:#d97706;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="df-qt">
                <div class="df-ql">Advertisements</div>
                <div class="df-qs">{{ $pendingProperties }} pending review</div>
            </div>
            <svg class="df-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="df-q df-a3" style="animation-delay:0.12s">
            <div class="df-qbg" style="background:#3b82f6;"></div>
            <div class="df-qi" style="background:#dbeafe;color:#2563eb;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="df-qt">
                <div class="df-ql">Messages</div>
                <div class="df-qs">{{ $unreadMessages }} unread</div>
            </div>
            <svg class="df-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="df-q df-a3" style="animation-delay:0.16s">
            <div class="df-qbg" style="background:#10b981;"></div>
            <div class="df-qi" style="background:#d1fae5;color:#059669;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="df-qt">
                <div class="df-ql">Testimonials</div>
                <div class="df-qs">{{ $activeTestimonials }} active</div>
            </div>
            <svg class="df-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.policies.index') }}" class="df-q df-a3" style="animation-delay:0.2s">
            <div class="df-qbg" style="background:#8b5cf6;"></div>
            <div class="df-qi" style="background:#f3e8ff;color:#7c3aed;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="df-qt">
                <div class="df-ql">Policies</div>
                <div class="df-qs">{{ $activePolicies }} active</div>
            </div>
            <svg class="df-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    {{-- Overview --}}
    <div class="df-section df-a2" style="animation-delay:0.15s">
        <div class="df-sh">
            <h2>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Overview
            </h2>
        </div>
        @php
            $propertyPct = $totalProperties > 0 ? round(($approvedProperties / $totalProperties) * 100) : 0;
            $faqPct = $totalFaqs > 0 ? round(($activeFaqs / $totalFaqs) * 100) : 0;
            $polPct = $totalPolicies > 0 ? round(($activePolicies / $totalPolicies) * 100) : 0;
            $msgPct = $totalMessages > 0 ? round((($totalMessages - $unreadMessages) / $totalMessages) * 100) : 0;
        @endphp
        <div class="df-ov">
            <div class="df-ov-card df-a3" style="animation-delay:0.18s">
                <div class="ov-top">
                    <div class="ov-lbl"><span class="ov-dot" style="background:#f59e0b;"></span>Pending Properties</div>
                    <div class="ov-icon" style="background:#fffbeb;color:#d97706;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-val">{{ $pendingProperties }}</div>
                <div class="ov-bar"><div class="ov-fill" style="width:{{ $propertyPct }}%;background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div></div>
            </div>
            <div class="df-ov-card df-a3" style="animation-delay:0.22s">
                <div class="ov-top">
                    <div class="ov-lbl"><span class="ov-dot" style="background:#10b981;"></span>Approved Properties</div>
                    <div class="ov-icon" style="background:#ecfdf5;color:#059669;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-val">{{ $approvedProperties }}</div>
                <div class="ov-bar"><div class="ov-fill" style="width:{{ $propertyPct }}%;background:linear-gradient(90deg,#10b981,#34d399);"></div></div>
            </div>
            <div class="df-ov-card df-a3" style="animation-delay:0.26s">
                <div class="ov-top">
                    <div class="ov-lbl"><span class="ov-dot" style="background:#8b5cf6;"></span>Active FAQs</div>
                    <div class="ov-icon" style="background:#f3e8ff;color:#7c3aed;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-val">{{ $activeFaqs }} / {{ $totalFaqs }}</div>
                <div class="ov-bar"><div class="ov-fill" style="width:{{ $faqPct }}%;background:linear-gradient(90deg,#8b5cf6,#a78bfa);"></div></div>
            </div>
            <div class="df-ov-card df-a3" style="animation-delay:0.3s">
                <div class="ov-top">
                    <div class="ov-lbl"><span class="ov-dot" style="background:#3b82f6;"></span>Replied Messages</div>
                    <div class="ov-icon" style="background:#eff6ff;color:#2563eb;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-val">{{ $totalMessages - $unreadMessages }} / {{ $totalMessages }}</div>
                <div class="ov-bar"><div class="ov-fill" style="width:{{ $msgPct }}%;background:linear-gradient(90deg,#3b82f6,#60a5fa);"></div></div>
            </div>
        </div>
    </div>

    {{-- Recent Data Tables --}}
    <div class="df-tbls df-a2" style="animation-delay:0.2s">
        <div class="df-tbl">
            <div class="df-th">
                <h3>
                    <span class="th-glow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </span>
                    Recent Messages
                </h3>
                <span class="df-cnt">{{ $recentMessages->count() }}</span>
            </div>
            <table>
                <thead><tr><th>Name</th><th>Message</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentMessages as $m)
                        <tr>
                            <td class="td-bold">{{ $m->name }}</td>
                            <td><div class="msg-subj">{{ \Illuminate\Support\Str::limit($m->message, 45) }}</div></td>
                            <td><span class="badge {{ $m->admin_reply ? 'badge-read' : 'badge-unread' }}">{{ $m->admin_reply ? 'Replied' : 'Unread' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty">No messages yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="df-tbl">
            <div class="df-th">
                <h3>
                    <span class="th-glow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    Recent Properties
                </h3>
                <span class="df-cnt">{{ $recentProperties->count() }}</span>
            </div>
            <table>
                <thead><tr><th>Title</th><th>Type</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentProperties as $p)
                        <tr>
                            <td class="td-bold">{{ \Illuminate\Support\Str::limit($p->title, 30) }}</td>
                            <td style="text-transform:capitalize;">{{ str_replace('_', ' ', $p->property_type) }}</td>
                            <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty">No properties yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
