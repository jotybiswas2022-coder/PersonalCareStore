@extends('admin.layouts.app')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
* { box-sizing:border-box; }

/* ── Keyframes ── */
@keyframes dRise  { from { opacity:0; transform:translateY(30px) scale(0.96); } to { opacity:1; transform:translateY(0) scale(1); } }
@keyframes dPop   { from { opacity:0; transform:scale(0.85); } to { opacity:1; transform:scale(1); } }
@keyframes dPulse { 0%,100% { opacity:0.3; transform:scale(1); } 50% { opacity:0.8; transform:scale(1.15); } }
@keyframes dDrift { 0%,100% { transform:translate(0,0) rotate(0deg); } 25% { transform:translate(12px,-18px) rotate(3deg); } 50% { transform:translate(-8px,12px) rotate(-2deg); } 75% { transform:translate(20px,8px) rotate(4deg); } }
@keyframes dBreathe { 0%,100% { transform:scale(1); opacity:0.06; } 50% { transform:scale(1.08); opacity:0.12; } }
@keyframes dShine  { 0% { background-position:-200% 0; } 100% { background-position:200% 0; } }
@keyframes dCount  { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
@keyframes dSlideL { from { width:0; } to { width:var(--w); } }
@keyframes dFloat  { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-12px); } }
@keyframes dGlowP  { 0%,100% { box-shadow:0 0 20px var(--gc); } 50% { box-shadow:0 0 40px var(--gc),0 0 60px var(--gc); } }
.d-a { animation:dRise 0.7s cubic-bezier(0.16,1,0.3,1) both; }
.d-b { animation:dPop 0.5s cubic-bezier(0.16,1,0.3,1) both; }

/* ── Hero ── */
.d-hero {
    position:relative; isolation:isolate;
    margin:-2rem -2rem 2rem; padding:2.75rem 2.75rem 3.25rem;
    background:linear-gradient(145deg,#050812 0%,#0d1630 25%,#151240 50%,#0a1125 75%,#02040a 100%);
    overflow:hidden;
    border-bottom:1px solid rgba(255,255,255,0.04);
}
.d-hero .h-grid {
    position:absolute; inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,0.02) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,0.02) 1px,transparent 1px);
    background-size:40px 40px; z-index:0;
}
.d-hero .h-orb {
    position:absolute; border-radius:50%; filter:blur(100px);
    animation:dDrift 20s ease-in-out infinite; pointer-events:none;
}
.d-hero .h-orb:nth-child(2) { width:28rem;height:28rem;top:-35%;right:-8%;background:radial-gradient(circle,rgba(99,102,241,0.18),transparent); animation-delay:0s; }
.d-hero .h-orb:nth-child(3) { width:20rem;height:20rem;bottom:-25%;left:-5%;background:radial-gradient(circle,rgba(16,185,129,0.12),transparent); animation-delay:-7s; }
.d-hero .h-orb:nth-child(4) { width:14rem;height:14rem;top:5%;left:45%;background:radial-gradient(circle,rgba(139,92,246,0.1),transparent); animation-delay:-14s; }
.d-hero .h-geo {
    position:absolute; border:1px solid rgba(255,255,255,0.04); border-radius:50%;
    pointer-events:none; animation:dFloat 8s ease-in-out infinite;
}
.d-hero .h-geo:nth-child(5) { width:6rem;height:6rem;top:15%;right:12%;border-color:rgba(99,102,241,0.08); animation-delay:-2s; }
.d-hero .h-geo:nth-child(6) { width:4rem;height:4rem;bottom:20%;right:25%;border-color:rgba(16,185,129,0.06); animation-delay:-5s; }
.d-hero .h-geo:nth-child(7) { width:3rem;height:3rem;top:40%;left:8%;border-color:rgba(139,92,246,0.08); animation-delay:-8s; }
.d-hero .h-geo::after { content:''; position:absolute; inset:3px; border-radius:50%; background:rgba(255,255,255,0.02); }

.d-hero .h-inner { position:relative; z-index:2; }
.d-hero .h-top { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }
.d-hero .h-left { display:flex; align-items:center; gap:1rem; }
.d-hero .h-av {
    width:3rem; height:3rem; border-radius:0.875rem;
    background:linear-gradient(135deg,#6366f1,#8b5cf6,#a78bfa);
    display:flex; align-items:center; justify-content:center;
    font-size:1rem; font-weight:800; color:#fff; flex-shrink:0;
    box-shadow:0 4px 16px rgba(99,102,241,0.3);
    position:relative;
}
.d-hero .h-av::after {
    content:''; position:absolute; inset:-2px; border-radius:1rem;
    background:linear-gradient(135deg,rgba(99,102,241,0.3),rgba(139,92,246,0.1));
    z-index:-1; filter:blur(8px);
    animation:dPulse 3s ease-in-out infinite;
}
.d-hero h1 {
    font-size:1.5rem; font-weight:800; color:#fff; letter-spacing:-0.03em;
    display:flex; align-items:center; gap:0.5rem;
}
.d-hero h1 .hi-greeting { font-weight:400; color:rgba(255,255,255,0.35); font-size:1.125rem; }
.d-hero h1 .hi-name {
    background:linear-gradient(135deg,#fff 30%,#a5b4fc);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.d-hero .h-meta { display:flex; align-items:center; gap:0.75rem; margin-top:0.25rem; }
.d-hero .h-meta .hm-dot {
    display:inline-flex; align-items:center; gap:0.375rem;
    color:rgba(255,255,255,0.3); font-size:0.75rem;
}
.d-hero .h-meta .hm-dot::before { content:''; width:0.375rem; height:0.375rem; border-radius:50%; background:#34d399; animation:dPulse 2s ease-in-out infinite; }
.d-hero .h-date {
    display:inline-flex; align-items:center; gap:0.5rem;
    padding:0.5rem 1.125rem;
    background:rgba(255,255,255,0.03); backdrop-filter:blur(16px);
    border:1px solid rgba(255,255,255,0.06);
    border-radius:9999px; font-size:0.75rem; color:rgba(255,255,255,0.45);
    transition:all 0.4s; font-weight:500;
}
.d-hero .h-date:hover { background:rgba(255,255,255,0.06); border-color:rgba(255,255,255,0.12); transform:translateY(-1px); }

.d-hero .h-bot {
    margin-top:1.75rem; padding-top:1.5rem;
    border-top:1px solid rgba(255,255,255,0.04);
    display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;
}
.d-hero .h-stat {
    display:flex; align-items:center; gap:0.75rem;
    padding:0.75rem 1rem;
    background:rgba(255,255,255,0.02);
    border:1px solid rgba(255,255,255,0.04);
    border-radius:0.625rem; transition:all 0.3s;
}
.d-hero .h-stat:hover { background:rgba(255,255,255,0.04); border-color:rgba(255,255,255,0.08); transform:translateY(-2px); }
.d-hero .h-stat .hs-icon {
    width:2.25rem; height:2.25rem; border-radius:0.5rem;
    display:flex; align-items:center; justify-content:center;
    background:rgba(255,255,255,0.04); flex-shrink:0;
}
.d-hero .h-stat .hs-b { display:flex; flex-direction:column; }
.d-hero .h-stat .hs-b .hs-v { font-size:1.125rem; font-weight:800; color:#fff; line-height:1.2; letter-spacing:-0.02em; }
.d-hero .h-stat .hs-b .hs-l { font-size:0.65rem; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.06em; font-weight:600; }

/* ── Body ── */
.d-body { padding:0 0.125rem; }

/* ── Stat Cards ── */
.d-stats {
    display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;
}
.d-card {
    position:relative; overflow:hidden;
    background:#fff; border-radius:1rem; padding:1.25rem 1.375rem;
    border:1px solid #e5e7eb;
    transition:all 0.4s cubic-bezier(0.16,1,0.3,1);
    cursor:default;
}
.d-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    border-radius:1rem 1rem 0 0; opacity:0;
    transition:opacity 0.4s, height 0.3s;
}
.d-card:hover {
    transform:translateY(-6px) scale(1.015);
    box-shadow:0 20px 60px -12px rgba(0,0,0,0.15);
    border-color:transparent;
}
.d-card:hover::before { opacity:1; height:4px; }
.d-card .dc-glow {
    position:absolute; top:-60%; right:-60%; width:120%; height:120%;
    border-radius:50%; opacity:0; transition:all 0.6s ease;
    filter:blur(70px); pointer-events:none;
}
.d-card:hover .dc-glow { opacity:0.1; transform:scale(1.5) translate(-10%,-10%); }
.d-card .dc-bg-shine {
    position:absolute; inset:0;
    background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,0.4) 48%,rgba(255,255,255,0.6) 50%,rgba(255,255,255,0.4) 52%,transparent 60%);
    background-size:300% 100%;
    opacity:0; transition:opacity 0.4s;
    pointer-events:none;
}
.d-card:hover .dc-bg-shine { opacity:1; animation:dShine 0.8s ease-in-out; }
.d-card .dc-deco {
    position:absolute; bottom:0.5rem; right:0.75rem;
    font-size:3rem; font-weight:900; line-height:1;
    color:rgba(0,0,0,0.02); letter-spacing:-0.06em;
    pointer-events:none;
}
.d-card .dc-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem; position:relative; }
.d-card .dc-icon {
    width:2.75rem; height:2.75rem; border-radius:0.75rem;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; position:relative; transition:all 0.4s;
}
.d-card:hover .dc-icon { transform:scale(1.1) rotate(-5deg); border-radius:0.875rem; }
.d-card .dc-badge {
    font-size:0.6rem; font-weight:700; padding:0.15rem 0.5rem;
    border-radius:9999px; letter-spacing:0.02em;
    display:flex; align-items:center; gap:0.25rem;
}
.d-card .dc-badge .dc-bd { width:0.375rem; height:0.375rem; border-radius:50%; display:inline-block; }
.d-card .dc-label { font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; position:relative; }
.d-card .dc-value {
    font-size:2.125rem; font-weight:900; line-height:1.1; position:relative;
    letter-spacing:-0.03em;
}
.d-card .dc-value .dc-currency { font-size:1.125rem; font-weight:600; opacity:0.4; vertical-align:super; }
.d-card .dc-sub { font-size:0.72rem; color:#9ca3af; margin-top:0.25rem; display:flex; align-items:center; gap:0.5rem; position:relative; }
.d-card .dc-sub .dc-tag {
    display:inline-flex; align-items:center; gap:0.25rem;
    padding:0.0625rem 0.375rem; border-radius:4px;
    font-size:0.6rem; font-weight:700;
}

/* ── Quick Actions ── */
.d-quick {
    display:grid; grid-template-columns:repeat(4,1fr); gap:0.875rem; margin-bottom:1.75rem;
}
.d-q {
    position:relative; overflow:hidden;
    display:flex; align-items:center; gap:0.75rem;
    background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem;
    padding:0.875rem 1rem; text-decoration:none;
    transition:all 0.4s cubic-bezier(0.16,1,0.3,1);
}
.d-q::before {
    content:''; position:absolute; inset:0; border-radius:0.75rem;
    padding:1px; background:linear-gradient(135deg,transparent 40%,rgba(99,102,241,0.15) 50%,transparent 60%);
    background-size:300% 300%; opacity:0;
    -webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);
    -webkit-mask-composite:xor; mask-composite:exclude;
    transition:opacity 0.4s;
    pointer-events:none;
}
.d-q:hover::before { opacity:1; animation:dShine 1.5s ease-in-out infinite; }
.d-q:hover { transform:translateY(-4px) scale(1.02); box-shadow:0 16px 40px -10px rgba(0,0,0,0.1); }
.d-q .dq-glow {
    position:absolute; top:-50%; right:-30%; width:10rem; height:10rem;
    border-radius:50%; opacity:0; transition:all 0.5s;
    filter:blur(50px); pointer-events:none;
}
.d-q:hover .dq-glow { opacity:0.08; transform:scale(1.4); }
.d-q .dq-icon {
    width:2.5rem; height:2.5rem; border-radius:0.625rem;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
    transition:all 0.4s;
}
.d-q:hover .dq-icon { transform:scale(1.1) rotate(-6deg); border-radius:0.75rem; }
.d-q .dq-body { flex:1; position:relative; }
.d-q .dq-body .dq-l { font-size:0.8rem; font-weight:600; color:#111827; }
.d-q .dq-body .dq-s { font-size:0.68rem; color:#6b7280; margin-top:0.0625rem; }
.d-q .dq-arrow { color:#9ca3af; flex-shrink:0; transition:all 0.4s; }
.d-q:hover .dq-arrow { transform:translateX(6px); color:#6366f1; }

/* ── Section ── */
.d-section { margin-bottom:1.75rem; }
.d-section .ds-h {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:0.875rem;
}
.d-section .ds-h h2 {
    font-size:0.9375rem; font-weight:700; color:#0f172a;
    display:flex; align-items:center; gap:0.5rem;
}
.d-section .ds-h h2 .ds-hi {
    width:1.5rem; height:1.5rem; border-radius:0.375rem;
    display:flex; align-items:center; justify-content:center;
}
.d-section .ds-h .ds-link { font-size:0.75rem; color:#6366f1; text-decoration:none; font-weight:500; }
.d-section .ds-h .ds-link:hover { text-decoration:underline; }

/* ── Overview ── */
.d-ov {
    display:grid; grid-template-columns:repeat(4,1fr); gap:0.875rem;
}
.d-ov .ov-card {
    position:relative; overflow:hidden;
    background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem;
    padding:1rem 1.125rem;
    transition:all 0.35s cubic-bezier(0.16,1,0.3,1);
}
.d-ov .ov-card:hover { transform:translateY(-4px); box-shadow:0 16px 40px -10px rgba(0,0,0,0.08); }
.d-ov .ov-card .ov-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem; }
.d-ov .ov-card .ov-l {
    font-size:0.65rem; font-weight:600; color:#6b7280;
    text-transform:uppercase; letter-spacing:0.05em;
    display:flex; align-items:center; gap:0.375rem;
}
.d-ov .ov-card .ov-l .ov-d { width:0.5rem; height:0.5rem; border-radius:50%; display:inline-block; flex-shrink:0; }
.d-ov .ov-card .ov-i {
    width:1.625rem; height:1.625rem; border-radius:0.375rem;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
    font-size:0.75rem;
}
.d-ov .ov-card .ov-v { font-size:1.25rem; font-weight:800; color:#0f172a; margin-top:0.125rem; letter-spacing:-0.02em; }
.d-ov .ov-card .ov-bar {
    width:100%; height:0.25rem; background:#f1f5f9; border-radius:9999px;
    margin-top:0.625rem; overflow:hidden; position:relative;
}
.d-ov .ov-card .ov-bar .ov-f {
    height:100%; border-radius:9999px;
    animation:dSlideL 1.5s cubic-bezier(0.16,1,0.3,1) forwards;
}

/* ── Tables ── */
.d-tbls { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
.d-tbl {
    background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem;
    overflow:hidden; transition:all 0.35s;
}
.d-tbl:hover { box-shadow:0 12px 32px -12px rgba(0,0,0,0.08); border-color:#cbd5e1; }
.d-tbl .dt-h {
    display:flex; align-items:center; justify-content:space-between;
    padding:1rem 1.25rem;
    background:linear-gradient(135deg,#f8faff,#eef2ff);
    border-bottom:1px solid #e5e7eb;
}
.d-tbl .dt-h h3 {
    font-size:0.875rem; font-weight:700; color:#1e293b; margin:0;
    display:flex; align-items:center; gap:0.5rem;
}
.d-tbl .dt-h h3 .dt-hg {
    width:1.75rem; height:1.75rem; border-radius:0.5rem;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg,#eef2ff,#e0e7ff);
    color:#4f46e5;
}
.d-tbl .dt-h .dt-c {
    font-size:0.625rem; font-weight:700; color:#64748b;
    background:#fff; border:1px solid #e2e8f0;
    padding:0.125rem 0.5rem; border-radius:9999px;
}
.d-tbl table { width:100%; border-collapse:collapse; }
.d-tbl th {
    text-align:left;
    padding:0.625rem 1.25rem; font-size:0.625rem; font-weight:700;
    color:#64748b; text-transform:uppercase; letter-spacing:0.05em;
    background:#fafbfc; border-bottom:1px solid #e2e8f0;
}
.d-tbl td {
    padding:0.75rem 1.25rem; font-size:0.8125rem;
    border-bottom:1px solid #f1f5f9; color:#334155;
    transition:all 0.15s;
}
.d-tbl tr:last-child td { border-bottom:none; }
.d-tbl tbody tr { transition:all 0.15s; cursor:default; }
.d-tbl tbody tr:hover td { background:linear-gradient(135deg,#f8faff,#f0f4ff); }
.d-tbl tbody tr:active td { background:#eef2ff; }
.d-tbl .badge {
    display:inline-flex; align-items:center; gap:0.375rem;
    padding:0.125rem 0.625rem;
    border-radius:9999px; font-size:0.625rem; font-weight:700;
}
.d-tbl .badge::before { content:''; width:0.375rem; height:0.375rem; border-radius:50%; display:inline-block; animation:dPulse 2.5s ease-in-out infinite; }
.d-tbl .badge-pending { background:#fffbeb; color:#92400e; }
.d-tbl .badge-pending::before { background:#f59e0b; }
.d-tbl .badge-approved { background:#ecfdf5; color:#065f46; }
.d-tbl .badge-approved::before { background:#10b981; }
.d-tbl .badge-rejected { background:#fef2f2; color:#991b1b; }
.d-tbl .badge-rejected::before { background:#ef4444; }
.d-tbl .badge-unread { background:#eff6ff; color:#1e40af; }
.d-tbl .badge-unread::before { background:#3b82f6; }
.d-tbl .badge-read { background:#f1f5f9; color:#64748b; }
.d-tbl .badge-read::before { background:#94a3b8; animation:none; }
.d-swipe-hint { display:none; }
.d-tbl .empty { text-align:center; color:#94a3b8; padding:2rem 1.25rem; font-size:0.8125rem; }
.d-tbl .msg-sub { max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.d-tbl .td-b { font-weight:600; color:#0f172a; }
.d-tbl .td-cap { text-transform:capitalize; }

/* ── Responsive ── */
@media (hover:none) and (pointer:coarse) {
    .d-card:hover { transform:none; box-shadow:none; border-color:#e5e7eb; }
    .d-card:hover::before { opacity:0; height:3px; }
    .d-card:hover .dc-glow { opacity:0; transform:none; }
    .d-card:hover .dc-bg-shine { opacity:0; animation:none; }
    .d-card:hover .dc-icon { transform:none; border-radius:0.75rem; }
    .d-card:active { transform:scale(0.97); transition:0.1s; }
    .d-q:hover { transform:none; box-shadow:none; }
    .d-q:hover::before { opacity:0; animation:none; }
    .d-q:hover .dq-glow { opacity:0; transform:none; }
    .d-q:hover .dq-icon { transform:none; border-radius:0.625rem; }
    .d-q:hover .dq-arrow { transform:none; color:#9ca3af; }
    .d-q:active { transform:scale(0.97); transition:0.1s; }
    .d-ov .ov-card:hover { transform:none; box-shadow:none; }
    .d-ov .ov-card:active { transform:scale(0.97); transition:0.1s; }
    .d-tbl:hover { box-shadow:none; border-color:#e5e7eb; }
    .d-tbl tbody tr:hover td { background:transparent; }
    .d-tbl tbody tr:active td { background:#f8faff; }
    .d-hero .h-stat:hover { transform:none; background:rgba(255,255,255,0.02); border-color:rgba(255,255,255,0.04); }
    .d-hero .h-stat:active { background:rgba(255,255,255,0.06); }
    .d-hero .h-date:hover { transform:none; }
    .d-card .dc-deco { display:none; }
}
@media (max-width:1280px) {
    .d-stats { grid-template-columns:repeat(2,1fr); }
    .d-quick { grid-template-columns:repeat(2,1fr); }
    .d-ov { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:1024px) {
    .d-tbls { grid-template-columns:1fr; }
    .d-tbl .dt-h h3 { font-size:0.8125rem; }
    .d-tbl th { padding:0.5rem 1rem; font-size:0.6rem; }
    .d-tbl td { padding:0.625rem 1rem; font-size:0.78125rem; }
}
@media (max-width:900px) {
    .d-hero .h-bot { grid-template-columns:repeat(2,1fr); gap:0.5rem; }
    .d-hero .h-stat { padding:0.625rem 0.875rem; gap:0.625rem; }
    .d-hero .h-stat .hs-icon { width:2rem; height:2rem; }
    .d-hero .h-stat .hs-icon svg { width:14px; height:14px; }
    .d-hero .h-stat .hs-b .hs-v { font-size:1rem; }
    .d-hero .h-stat .hs-b .hs-l { font-size:0.6rem; }
}
@media (max-width:768px) {
    .d-hero { margin:-1rem -1rem 1.25rem; padding:1.25rem 1rem 1.5rem; border-radius:0 0 1.5rem 1.5rem; }
    .d-hero .h-top { flex-direction:column; align-items:flex-start; }
    .d-hero h1 { font-size:1.2rem; flex-wrap:wrap; }
    .d-hero h1 .hi-greeting { font-size:1rem; }
    .d-hero .h-left { gap:0.75rem; }
    .d-hero .h-av { width:2.5rem; height:2.5rem; font-size:0.875rem; }
    .d-hero .h-av::after { display:none; }
    .d-hero .h-meta .hm-dot { font-size:0.7rem; }
    .d-hero .h-date { font-size:0.7rem; padding:0.375rem 0.75rem; }
    .d-hero .h-bot { gap:0.5rem; }
    .d-hero .h-geo { display:none; }
    .d-stats { gap:0.75rem; }
    .d-card { padding:1rem; border-radius:0.875rem; }
    .d-card .dc-value { font-size:1.625rem; }
    .d-card .dc-icon { width:2.25rem; height:2.25rem; border-radius:0.625rem; }
    .d-card .dc-icon svg { width:18px; height:18px; }
    .d-card .dc-badge { font-size:0.55rem; padding:0.125rem 0.375rem; }
    .d-card .dc-deco { font-size:2.25rem; bottom:0.375rem; right:0.5rem; }
    .d-card .dc-sub { flex-wrap:wrap; gap:0.375rem; }
    .d-quick { gap:0.625rem; }
    .d-q { padding:0.75rem 0.875rem; border-radius:0.625rem; }
    .d-q .dq-icon { width:2.25rem; height:2.25rem; }
    .d-q .dq-icon svg { width:16px; height:16px; }
    .d-q .dq-body .dq-l { font-size:0.75rem; }
    .d-q .dq-body .dq-s { font-size:0.65rem; }
    .d-ov { gap:0.625rem; }
    .d-ov .ov-card { padding:0.875rem 1rem; border-radius:0.625rem; }
    .d-ov .ov-card .ov-v { font-size:1.125rem; }
    .d-section { margin-bottom:1.25rem; }
    .d-section .ds-h { margin-bottom:0.625rem; }
    .d-section .ds-h h2 { font-size:0.875rem; }
    .d-section .ds-h .ds-link { font-size:0.7rem; }
}
@media (max-width:640px) {
    body { padding-bottom:env(safe-area-inset-bottom,0); }
    .d-hero { margin:-1rem -0.75rem 1rem; padding:1rem 0.875rem 1.25rem; border-radius:0 0 1.25rem 1.25rem; }
    .d-hero .h-top { gap:0.625rem; }
    .d-hero h1 { font-size:1.05rem; }
    .d-hero h1 .hi-greeting { font-size:0.875rem; }
    .d-hero .h-left { gap:0.625rem; }
    .d-hero .h-av { width:2.25rem; height:2.25rem; font-size:0.75rem; border-radius:0.625rem; }
    .d-hero .h-av::after { border-radius:0.75rem; }
    .d-hero .h-bot { grid-template-columns:1fr; gap:0.375rem; }
    .d-hero .h-stat { padding:0.5rem 0.75rem; }
    .d-stats { grid-template-columns:1fr; gap:0.625rem; }
    .d-card { padding:0.875rem; border-radius:0.75rem; }
    .d-card .dc-top { margin-bottom:0.5rem; }
    .d-card .dc-value { font-size:1.5rem; }
    .d-card .dc-icon { width:2rem; height:2rem; }
    .d-card .dc-icon svg { width:16px; height:16px; }
    .d-card .dc-label { font-size:0.65rem; }
    .d-card .dc-badge { font-size:0.5rem; }
    .d-quick { grid-template-columns:1fr; gap:0.5rem; }
    .d-q { padding:0.6875rem 0.75rem; }
    .d-ov { grid-template-columns:1fr; gap:0.5rem; }
    .d-ov .ov-card { padding:0.75rem 0.875rem; }
    .d-ov .ov-card .ov-l { font-size:0.6rem; }
    .d-ov .ov-card .ov-v { font-size:1rem; }
    .d-tbl { border-radius:0.625rem; }
    .d-tbl-wrap { overflow-x:auto; -webkit-overflow-scrolling:touch; }
    .d-swipe-hint { display:block; text-align:center; font-size:0.6rem; color:#94a3b8; padding:0.375rem; background:#f8fafc; border-bottom:1px solid #f1f5f9; letter-spacing:0.05em; }
    .d-tbl table { min-width:380px; }
    .d-tbl .dt-h { padding:0.75rem 0.875rem; }
    .d-tbl .dt-h h3 { font-size:0.75rem; }
    .d-tbl .dt-h h3 .dt-hg { width:1.5rem; height:1.5rem; }
    .d-tbl .dt-h h3 .dt-hg svg { width:12px; height:12px; }
    .d-tbl .dt-h .dt-c { font-size:0.55rem; }
    .d-tbl th { padding:0.4375rem 0.875rem; font-size:0.55rem; }
    .d-tbl td { padding:0.5rem 0.875rem; font-size:0.71875rem; }
    .d-tbl .msg-sub { max-width:150px; }
    .d-tbl .badge { font-size:0.5625rem; padding:0.0625rem 0.5rem; }
}
@media (max-width:480px) {
    .d-hero { margin:-0.75rem -0.5rem 0.875rem; padding:0.875rem 0.75rem 1.125rem; border-radius:0 0 1rem 1rem; }
    .d-hero h1 { font-size:0.9375rem; }
    .d-hero h1 .hi-greeting { font-size:0.8125rem; }
    .d-hero .h-left { gap:0.5rem; }
    .d-hero .h-av { width:2rem; height:2rem; font-size:0.6875rem; }
    .d-hero .h-meta .hm-dot { font-size:0.625rem; }
    .d-hero .h-meta .hm-dot::before { width:0.3125rem; height:0.3125rem; }
    .d-hero .h-date { font-size:0.625rem; padding:0.3125rem 0.625rem; }
    .d-stats { gap:0.5rem; }
    .d-card { padding:0.75rem; border-radius:0.625rem; }
    .d-card .dc-value { font-size:1.375rem; }
    .d-card .dc-icon { width:1.75rem; height:1.75rem; }
    .d-card .dc-icon svg { width:14px; height:14px; }
    .d-card .dc-deco { font-size:1.75rem; }
    .d-card .dc-sub .dc-tag { font-size:0.55rem; }
    .d-quick { gap:0.375rem; }
    .d-q { padding:0.625rem 0.75rem; border-radius:0.5rem; gap:0.5rem; }
    .d-q .dq-icon { width:2rem; height:2rem; }
    .d-q .dq-icon svg { width:14px; height:14px; }
    .d-q .dq-body .dq-l { font-size:0.71875rem; }
    .d-q .dq-body .dq-s { font-size:0.6rem; }
    .d-q .dq-arrow { width:12px; height:12px; }
    .d-ov .ov-card { padding:0.625rem 0.75rem; border-radius:0.5rem; }
    .d-ov .ov-card .ov-v { font-size:0.9375rem; }
    .d-ov .ov-card .ov-i { width:1.375rem; height:1.375rem; }
    .d-ov .ov-card .ov-i svg { width:10px; height:10px; }
    .d-ov .ov-card .ov-bar { height:0.1875rem; margin-top:0.4375rem; }
    .d-section { margin-bottom:1rem; }
    .d-tbl { border-radius:0.5rem; }
    .d-tbl .dt-h { padding:0.625rem 0.75rem; flex-wrap:wrap; gap:0.375rem; }
    .d-tbl .dt-h h3 { font-size:0.6875rem; }
    .d-tbl .dt-h .dt-c { font-size:0.5rem; }
    .d-tbl th { padding:0.375rem 0.75rem; font-size:0.5rem; }
    .d-tbl td { padding:0.4375rem 0.75rem; font-size:0.6875rem; }
    .d-tbl .msg-sub { max-width:120px; }
    .d-tbl .badge { font-size:0.5rem; padding:0.0625rem 0.375rem; gap:0.25rem; }
    .d-tbl .badge::before { width:0.3125rem; height:0.3125rem; }
    .d-tbl td.td-b { font-size:0.6875rem; }
    .d-swipe-hint { font-size:0.55rem; padding:0.25rem; }
    .d-hero .h-bot { gap:0.3125rem; }
    .d-hero .h-stat { padding:0.4375rem 0.625rem; gap:0.5rem; }
    .d-hero .h-stat .hs-icon { width:1.75rem; height:1.75rem; }
    .d-hero .h-stat .hs-icon svg { width:12px; height:12px; }
    .d-hero .h-stat .hs-b .hs-v { font-size:0.875rem; }
    .d-hero .h-stat .hs-b .hs-l { font-size:0.55rem; }
}
}
</style>
@endpush

@section('content')
{{-- ═══ HERO ═══ --}}
<div class="d-hero d-a">
    <div class="h-grid"></div>
    <div class="h-orb"></div>
    <div class="h-orb"></div>
    <div class="h-orb"></div>
    <div class="h-geo"></div>
    <div class="h-geo"></div>
    <div class="h-geo"></div>
    <div class="h-inner">
        <div class="h-top">
            <div class="h-left">
                <div class="h-av">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <h1><span class="hi-greeting">Welcome back</span><span class="hi-name">{{ auth()->user()->name }}</span></h1>
                    <div class="h-meta">
                        <span class="hm-dot">System is live</span>
                        <span style="color:rgba(255,255,255,0.2);font-size:0.7rem;">{{ now()->timezone('Asia/Dhaka')->format('l, F j, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="h-date">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ now()->timezone('Asia/Dhaka')->format('M d, Y') }}
            </div>
        </div>
        <div class="h-bot">
            <div class="h-stat">
                <div class="hs-icon" style="color:#818cf8;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                <div class="hs-b"><span class="hs-v">{{ $totalUsers }}</span><span class="hs-l">Total Users</span></div>
            </div>
            <div class="h-stat">
                <div class="hs-icon" style="color:#fbbf24;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                <div class="hs-b"><span class="hs-v">{{ $totalProperties }}</span><span class="hs-l">Properties</span></div>
            </div>
            <div class="h-stat">
                <div class="hs-icon" style="color:#34d399;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                <div class="hs-b"><span class="hs-v">{{ $totalMessages }}</span><span class="hs-l">Messages</span></div>
            </div>
            <div class="h-stat">
                <div class="hs-icon" style="color:#a78bfa;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                <div class="hs-b"><span class="hs-v">{{ $totalFaqs }}</span><span class="hs-l">FAQs</span></div>
            </div>
        </div>
    </div>
</div>

<div class="d-body">
    {{-- ═══ STAT CARDS ═══ --}}
    <div class="d-stats">
        <div class="d-card d-b" style="--gc:rgba(99,102,241,0.4);animation-delay:0.04s;">
            <div class="dc-glow" style="background:#6366f1;"></div>
            <div class="dc-bg-shine"></div>
            <div class="dc-deco">U</div>
            <div class="dc-top">
                <div class="dc-icon" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4f46e5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="dc-badge" style="background:#eef2ff;color:#4f46e5;"><span class="dc-bd" style="background:#4f46e5;"></span>All time</span>
            </div>
            <div class="dc-label">Registered Users</div>
            <div class="dc-value" style="color:#1e293b;">{{ $totalUsers }}</div>
        </div>
        <div class="d-card d-b" style="--gc:rgba(245,158,11,0.4);animation-delay:0.08s;">
            <div class="dc-glow" style="background:#f59e0b;"></div>
            <div class="dc-bg-shine"></div>
            <div class="dc-deco">P</div>
            <div class="dc-top">
                <div class="dc-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="dc-badge" style="background:#fffbeb;color:#92400e;"><span class="dc-bd" style="background:#f59e0b;"></span>{{ $pendingProperties }} pending</span>
            </div>
            <div class="dc-label">Properties</div>
            <div class="dc-value" style="color:#1e293b;">{{ $totalProperties }}</div>
            <div class="dc-sub">
                <span class="dc-tag" style="background:#ecfdf5;color:#065f46;"><span style="width:0.3125rem;height:0.3125rem;border-radius:50%;background:#10b981;display:inline-block;"></span>{{ $approvedProperties }} approved</span>
                <span class="dc-tag" style="background:#fef2f2;color:#991b1b;"><span style="width:0.3125rem;height:0.3125rem;border-radius:50%;background:#ef4444;display:inline-block;"></span>{{ $rejectedProperties }} rejected</span>
            </div>
        </div>
        <div class="d-card d-b" style="--gc:rgba(16,185,129,0.4);animation-delay:0.12s;">
            <div class="dc-glow" style="background:#10b981;"></div>
            <div class="dc-bg-shine"></div>
            <div class="dc-deco">T</div>
            <div class="dc-top">
                <div class="dc-icon" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span class="dc-badge" style="background:#ecfdf5;color:#065f46;"><span class="dc-bd" style="background:#10b981;"></span>{{ $activeTestimonials }} active</span>
            </div>
            <div class="dc-label">Testimonials</div>
            <div class="dc-value" style="color:#1e293b;">{{ $totalTestimonials }}</div>
            <div class="dc-sub">From your valued clients</div>
        </div>
        <div class="d-card d-b" style="--gc:rgba(139,92,246,0.4);animation-delay:0.16s;">
            <div class="dc-glow" style="background:#8b5cf6;"></div>
            <div class="dc-bg-shine"></div>
            <div class="dc-deco">M</div>
            <div class="dc-top">
                <div class="dc-icon" style="background:linear-gradient(135deg,#f3e8ff,#ede9fe);color:#7c3aed;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="9" y1="10" x2="15" y2="10"/></svg>
                </div>
                <span class="dc-badge" style="background:#eff6ff;color:#1e40af;"><span class="dc-bd" style="background:#3b82f6;"></span>{{ $unreadMessages }} unread</span>
            </div>
            <div class="dc-label">Messages</div>
            <div class="dc-value" style="color:#1e293b;">{{ $totalMessages }}</div>
            <div class="dc-sub">Awaiting your reply</div>
        </div>
    </div>

    {{-- ═══ QUICK ACTIONS ═══ --}}
    <div class="d-quick">
        <a href="{{ route('admin.to-let.index') }}" class="d-q d-b" style="animation-delay:0.06s;">
            <div class="dq-glow" style="background:#f59e0b;"></div>
            <div class="dq-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="dq-body">
                <div class="dq-l">Advertisements</div>
                <div class="dq-s">{{ $pendingProperties }} pending review</div>
            </div>
            <svg class="dq-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="d-q d-b" style="animation-delay:0.1s;">
            <div class="dq-glow" style="background:#3b82f6;"></div>
            <div class="dq-icon" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#2563eb;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="dq-body">
                <div class="dq-l">Messages</div>
                <div class="dq-s">{{ $unreadMessages }} unread</div>
            </div>
            <svg class="dq-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="d-q d-b" style="animation-delay:0.14s;">
            <div class="dq-glow" style="background:#10b981;"></div>
            <div class="dq-icon" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="dq-body">
                <div class="dq-l">Testimonials</div>
                <div class="dq-s">{{ $activeTestimonials }} active</div>
            </div>
            <svg class="dq-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.policies.index') }}" class="d-q d-b" style="animation-delay:0.18s;">
            <div class="dq-glow" style="background:#8b5cf6;"></div>
            <div class="dq-icon" style="background:linear-gradient(135deg,#f3e8ff,#ede9fe);color:#7c3aed;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="dq-body">
                <div class="dq-l">Policies</div>
                <div class="dq-s">{{ $activePolicies }} active</div>
            </div>
            <svg class="dq-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    {{-- ═══ OVERVIEW ═══ --}}
    @php
        $pPct = $totalProperties ? round($approvedProperties/$totalProperties*100) : 0;
        $fPct = $totalFaqs ? round($activeFaqs/$totalFaqs*100) : 0;
        $poPct = $totalPolicies ? round($activePolicies/$totalPolicies*100) : 0;
        $mPct = $totalMessages ? round(($totalMessages-$unreadMessages)/$totalMessages*100) : 0;
    @endphp
    <div class="d-section d-b" style="animation-delay:0.12s;">
        <div class="ds-h">
            <h2>
                <span class="ds-hi" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4f46e5;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </span>
                Overview
            </h2>
        </div>
        <div class="d-ov">
            <div class="ov-card d-b" style="animation-delay:0.14s;">
                <div class="ov-top">
                    <div class="ov-l"><span class="ov-d" style="background:#f59e0b;"></span>Pending Properties</div>
                    <div class="ov-i" style="background:#fffbeb;color:#d97706;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-v">{{ $pendingProperties }}</div>
                <div class="ov-bar"><div class="ov-f" style="--w:{{ $pPct }}%;background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div></div>
            </div>
            <div class="ov-card d-b" style="animation-delay:0.18s;">
                <div class="ov-top">
                    <div class="ov-l"><span class="ov-d" style="background:#10b981;"></span>Approved Properties</div>
                    <div class="ov-i" style="background:#ecfdf5;color:#059669;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-v">{{ $approvedProperties }}</div>
                <div class="ov-bar"><div class="ov-f" style="--w:{{ $pPct }}%;background:linear-gradient(90deg,#10b981,#34d399);"></div></div>
            </div>
            <div class="ov-card d-b" style="animation-delay:0.22s;">
                <div class="ov-top">
                    <div class="ov-l"><span class="ov-d" style="background:#8b5cf6;"></span>Active FAQs</div>
                    <div class="ov-i" style="background:#f3e8ff;color:#7c3aed;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-v">{{ $activeFaqs }} <span style="font-size:0.75rem;font-weight:600;color:#94a3b8;">/ {{ $totalFaqs }}</span></div>
                <div class="ov-bar"><div class="ov-f" style="--w:{{ $fPct }}%;background:linear-gradient(90deg,#8b5cf6,#a78bfa);"></div></div>
            </div>
            <div class="ov-card d-b" style="animation-delay:0.26s;">
                <div class="ov-top">
                    <div class="ov-l"><span class="ov-d" style="background:#3b82f6;"></span>Replied Messages</div>
                    <div class="ov-i" style="background:#eff6ff;color:#2563eb;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="ov-v">{{ $totalMessages - $unreadMessages }} <span style="font-size:0.75rem;font-weight:600;color:#94a3b8;">/ {{ $totalMessages }}</span></div>
                <div class="ov-bar"><div class="ov-f" style="--w:{{ $mPct }}%;background:linear-gradient(90deg,#3b82f6,#60a5fa);"></div></div>
            </div>
        </div>
    </div>

    {{-- ═══ TABLES ═══ --}}
    <div class="d-tbls d-b" style="animation-delay:0.16s;">
        <div class="d-tbl">
            <div class="dt-h">
                <h3><span class="dt-hg"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>Recent Messages</h3>
                <span class="dt-c">{{ $recentMessages->count() }}</span>
            </div>
            <div class="d-swipe-hint">&larr; Swipe &rarr;</div>
            <div class="d-tbl-wrap">
            <table>
                <thead><tr><th>Name</th><th>Message</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentMessages as $m)
                        <tr>
                            <td class="td-b">{{ $m->name }}</td>
                            <td><div class="msg-sub">{{ \Illuminate\Support\Str::limit($m->message, 45) }}</div></td>
                            <td><span class="badge {{ $m->admin_reply ? 'badge-read' : 'badge-unread' }}">{{ $m->admin_reply ? 'Replied' : 'Unread' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty">No messages yet</td></tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        <div class="d-tbl">
            <div class="dt-h">
                <h3><span class="dt-hg"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>Recent Properties</h3>
                <span class="dt-c">{{ $recentProperties->count() }}</span>
            </div>
            <div class="d-swipe-hint">&larr; Swipe &rarr;</div>
            <div class="d-tbl-wrap">
            <table>
                <thead><tr><th>Title</th><th>Type</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentProperties as $p)
                        <tr>
                            <td class="td-b">{{ \Illuminate\Support\Str::limit($p->title, 30) }}</td>
                            <td class="td-cap">{{ str_replace('_', ' ', $p->property_type) }}</td>
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
</div>
@endsection
