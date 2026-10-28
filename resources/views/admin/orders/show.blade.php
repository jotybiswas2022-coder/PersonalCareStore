@extends('admin.layouts.app')

@push('styles')
<style>
/* ── Animations ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes pulseGlow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50%      { opacity: 0.6; transform: scale(1.05); }
}

.os-animate { animation: fadeUp 0.5s ease-out both; }
.os-animate-d1 { animation-delay: 0.05s; }
.os-animate-d2 { animation-delay: 0.1s; }
.os-animate-d3 { animation-delay: 0.15s; }
.os-animate-d4 { animation-delay: 0.2s; }
.os-animate-d5 { animation-delay: 0.25s; }

/* ── Hero ── */
.os-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.5rem 2.5rem 3rem;
    background: linear-gradient(135deg, #0b1120 0%, #162044 40%, #1a1f4e 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.os-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(99,102,241,0.15) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(139,92,246,0.1) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(59,130,246,0.08) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.os-hero::after {
    content: '';
    position: absolute;
    top: -30%;
    right: -5%;
    width: 30rem;
    height: 30rem;
    background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.os-hero .hero-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 1.5rem;
}
.os-hero .hero-left h1 {
    font-size: 1.65rem;
    font-weight: 800;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.os-hero .hero-left h1 .hero-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background: rgba(99,102,241,0.2);
    border-radius: 0.5rem;
    color: #818cf8;
    flex-shrink: 0;
}
.os-hero .hero-left h1 .ord-hash {
    color: rgba(255,255,255,0.35);
    font-weight: 500;
    font-size: 1.15rem;
}
.os-hero .hero-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem 0.875rem;
    margin-top: 0.5rem;
}
.os-hero .hero-meta .meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8rem;
    color: rgba(255,255,255,0.55);
}
.os-hero .hero-meta .meta-item svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
}
.os-hero .hero-meta .meta-sep {
    width: 3px;
    height: 3px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
}
.os-hero .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: capitalize;
    letter-spacing: 0.02em;
}
.os-hero .hero-badge.bg-unpaid { background: rgba(107,114,128,0.2); color: rgba(255,255,255,0.6); }
.os-hero .hero-badge.bg-pending { background: rgba(245,158,11,0.2); color: #fbbf24; }
.os-hero .hero-badge.bg-paid { background: rgba(59,130,246,0.2); color: #93c5fd; }
.os-hero .hero-badge.bg-approved { background: rgba(34,197,94,0.2); color: #86efac; }
.os-hero .hero-badge.bg-rejected { background: rgba(239,68,68,0.2); color: #fca5a5; }
.os-hero .hero-badge .badge-dot {
    width: 0.4rem;
    height: 0.4rem;
    border-radius: 50%;
    animation: pulseGlow 2s ease-in-out infinite;
}

.os-hero .hero-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.os-hero .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.125rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.75);
    border-radius: 0.625rem;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s ease;
    backdrop-filter: blur(4px);
}
.os-hero .btn-back:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* ── Flash Messages ── */
.os-msg {
    margin-bottom: 1.25rem;
    padding: 0.875rem 1.125rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-weight: 500;
    animation: fadeUp 0.35s ease-out;
}
.os-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}
.os-msg.error {
    background: linear-gradient(135deg, #fef2f2, #fce4e4);
    border: 1px solid #fecaca;
    color: #991b1b;
    box-shadow: 0 2px 8px rgba(239,68,68,0.1);
}

/* ── Card ── */
.os-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    padding: 1.75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    margin-bottom: 1.25rem;
    transition: box-shadow 0.3s ease;
}
.os-card:last-child { margin-bottom: 0; }
.os-card:hover { box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04); }

/* ── Section ── */
.os-section { margin-bottom: 1.75rem; }
.os-section:last-child { margin-bottom: 0; }
.os-section h2 {
    font-size: 0.85rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    letter-spacing: 0.01em;
    text-transform: uppercase;
}
.os-section h2 svg {
    width: 16px;
    height: 16px;
    color: #6366f1;
    flex-shrink: 0;
}
.os-section h2 .section-count {
    margin-left: auto;
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    background: #f3f4f6;
    padding: 0.15rem 0.5rem;
    border-radius: 9999px;
}

/* ── Info Grid ── */
.os-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 0.75rem;
}
.os-info-item {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 0.75rem;
    padding: 1rem 1.125rem;
    transition: all 0.25s ease;
}
.os-info-item:hover {
    background: #f1f5f9;
    border-color: #e2e8f0;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}
.os-info-item .ii-top {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.375rem;
}
.os-info-item .ii-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 0.375rem;
    background: #eef2ff;
    color: #6366f1;
    flex-shrink: 0;
}
.os-info-item .ii-icon svg { width: 13px; height: 13px; }
.os-info-item .ii-lbl {
    font-size: 0.6rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.os-info-item .ii-val {
    font-size: 0.9rem;
    font-weight: 600;
    color: #111827;
    margin-left: 2rem;
    word-break: break-word;
}
.os-info-item .ii-val .status-dot-indicator {
    display: inline-block;
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    margin-right: 0.375rem;
    vertical-align: middle;
    box-shadow: 0 0 0 2px rgba(255,255,255,0.8);
}

/* ── Items Table ── */
.os-table-container {
    border: 1px solid #edf2f7;
    border-radius: 0.75rem;
    overflow: hidden;
}
.os-table-wrap { overflow-x: auto; }
.os-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 420px;
}
.os-table thead th {
    text-align: left;
    padding: 0.75rem 1rem;
    font-size: 0.6rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: #f8fafc;
    border-bottom: 2px solid #e9edf4;
    white-space: nowrap;
}
.os-table tbody td {
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    transition: background 0.15s ease;
}
.os-table tbody tr:last-child td { border-bottom: none; }
.os-table tbody tr {
    transition: background 0.15s ease;
}
.os-table tbody tr:hover td {
    background: #f8faff;
}
.os-table tbody tr:active td {
    background: #f1f4fd;
}
.os-table tfoot td {
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbfc;
}
.os-table tfoot tr:last-child td { border-bottom: none; }
.os-table .right { text-align: right; }
.os-table .center { text-align: center; }
.os-table .bold { font-weight: 600; }
.os-table .product-name { font-weight: 600; color: #111827; }
.os-table .total-label {
    font-size: 0.7rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 600;
}
.os-table .total-val {
    font-size: 1rem;
    font-weight: 700;
    color: #111827;
}
.os-table .grand-total td {
    border-top: 2px solid #e9edf4;
    background: #f1f5f9;
}
.os-table .grand-total .total-val {
    font-size: 1.1rem;
    color: #6366f1;
}

/* ── Address Card ── */
.os-addr-card {
    display: flex;
    gap: 1.25rem;
    align-items: flex-start;
}
.os-addr-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    background: #eef2ff;
    border-radius: 0.75rem;
    color: #6366f1;
    flex-shrink: 0;
}
.os-addr-icon svg { width: 18px; height: 18px; }
.os-addr-body {
    flex: 1;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 0.75rem;
    padding: 1.125rem 1.25rem;
    line-height: 1.7;
    color: #374151;
    font-size: 0.85rem;
}
.os-addr-body .addr-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.125rem;
}
.os-addr-body .addr-line { color: #4b5563; }

/* ── Payment Proof ── */
.os-proof-card {
    border: 1px solid #d1fae5 !important;
    background: linear-gradient(135deg, #f0fdf4, #ecfdf5) !important;
}
.os-proof-card .os-section h2 { color: #065f46; }
.os-proof-card .os-section h2 svg { color: #10b981; }

.os-proof-detail {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.os-proof-row {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
}
.os-proof-row .pr-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background: rgba(16,185,129,0.12);
    border-radius: 0.5rem;
    color: #10b981;
    flex-shrink: 0;
}
.os-proof-row .pr-icon svg { width: 16px; height: 16px; }
.os-proof-row .pr-content {
    flex: 1;
    min-width: 0;
}
.os-proof-row .pr-lbl {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.125rem;
}
.os-proof-row .pr-val {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    word-break: break-all;
}
.os-proof-img {
    margin-top: 0.5rem;
}
.os-proof-img p {
    font-size: 0.75rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}
.os-proof-img img {
    max-width: 100%;
    height: auto;
    border-radius: 0.625rem;
    border: 1px solid #d1d5db;
    max-height: 24rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: box-shadow 0.3s ease;
}
.os-proof-img img:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.os-proof-actions {
    margin-top: 1rem;
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

/* ── Status Badge ── */
.os-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.45rem 1.125rem;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.25s ease;
}
.os-status-badge.approved {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 6px rgba(16,185,129,0.12);
}
.os-status-badge.rejected {
    background: linear-gradient(135deg, #fef2f2, #fce4e4);
    border: 1px solid #fecaca;
    color: #991b1b;
    box-shadow: 0 2px 6px rgba(239,68,68,0.12);
}

/* ── Status Update ── */
.os-status-wrap {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 0.75rem;
    padding: 1.25rem;
    display: flex;
    gap: 0.875rem;
    align-items: center;
    flex-wrap: wrap;
}
.os-status-wrap select {
    flex: 1;
    min-width: 180px;
    padding: 0.65rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.625rem;
    font-size: 0.85rem;
    font-weight: 500;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    color: #111827;
    outline: none;
    transition: all 0.2s ease;
    cursor: pointer;
}
.os-status-wrap select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.os-status-wrap select:hover {
    border-color: #9ca3af;
}
.os-status-wrap .os-btn { flex-shrink: 0; }

/* ── Locked Banner ── */
.os-locked {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem 2rem;
    text-align: center;
    font-size: 0.85rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}
.os-locked svg { width: 20px; height: 20px; color: #9ca3af; flex-shrink: 0; }
.os-locked strong { font-weight: 700; color: #374151; }
.os-warning {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1px solid #fde68a;
    border-radius: 0.75rem;
    padding: 1.25rem 1.5rem;
    text-align: center;
    font-size: 0.85rem;
    color: #92400e;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}
.os-warning svg { width: 20px; height: 20px; color: #d97706; flex-shrink: 0; }
.os-warning strong { font-weight: 700; }

/* ── Buttons ── */
.os-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.25rem;
    border: none;
    border-radius: 0.625rem;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.os-btn:hover { transform: translateY(-1px); }
.os-btn:active { transform: translateY(0); }
.os-btn-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.2);
}
.os-btn-primary:hover {
    box-shadow: 0 4px 16px rgba(99,102,241,0.3);
}
.os-btn-green {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #fff;
    box-shadow: 0 2px 8px rgba(22,163,74,0.2);
}
.os-btn-green:hover {
    box-shadow: 0 4px 16px rgba(22,163,74,0.3);
}
.os-btn-red {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #fff;
    box-shadow: 0 2px 8px rgba(220,38,38,0.2);
}
.os-btn-red:hover {
    box-shadow: 0 4px 16px rgba(220,38,38,0.3);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .os-hero { padding: 2rem 1.5rem 2.5rem; }
    .os-hero .hero-grid { grid-template-columns: 1fr; }
    .os-hero .hero-actions { justify-content: flex-start; }
    .os-info-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .os-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem 2rem; }
    .os-hero .hero-left h1 { font-size: 1.25rem; }
    .os-hero .hero-left h1 .hero-icon { width: 1.6rem; height: 1.6rem; }
    .os-hero .hero-left h1 .ord-hash { font-size: 1rem; }
    .os-hero .hero-meta { gap: 0.375rem 0.625rem; }
    .os-hero .hero-meta .meta-item { font-size: 0.75rem; }
    .os-hero .btn-back { width: 100%; justify-content: center; }
    .os-hero .hero-actions { width: 100%; }
    .os-card { padding: 1.125rem; border-radius: 0.75rem; }
    .os-info-grid { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .os-info-item { padding: 0.75rem 0.875rem; }
    .os-info-item .ii-val { font-size: 0.8rem; margin-left: 1.75rem; }
    .os-section h2 { font-size: 0.78rem; }
    .os-section { margin-bottom: 1.25rem; }
    .os-table-container { border-radius: 0.5rem; }
    .os-table { min-width: 340px; }
    .os-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .os-table tbody td { padding: 0.5rem 0.625rem; font-size: 0.78rem; }
    .os-table tfoot td { padding: 0.375rem 0.625rem; font-size: 0.78rem; }
    .os-table .total-val { font-size: 0.9rem; }
    .os-table .grand-total .total-val { font-size: 1rem; }
    .os-addr-card { flex-direction: column; gap: 0.75rem; }
    .os-addr-body { padding: 0.875rem 1rem; font-size: 0.8rem; }
    .os-proof-detail { gap: 0.5rem; }
    .os-proof-row .pr-content { min-width: 0; }
    .os-proof-row .pr-val { font-size: 0.78rem; }
    .os-status-wrap { flex-direction: column; align-items: stretch; padding: 1rem; }
    .os-status-wrap select { width: 100%; min-width: 0; }
    .os-status-wrap .os-btn { width: 100%; justify-content: center; }
    .os-locked { flex-direction: column; padding: 1.25rem; text-align: center; }
    .os-warning { flex-direction: column; padding: 1rem; text-align: center; }
}
@media (max-width: 480px) {
    .os-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem 1.5rem; }
    .os-hero .hero-left h1 { font-size: 1.1rem; flex-wrap: wrap; }
    .os-card { padding: 0.875rem; border-radius: 0.625rem; }
    .os-info-grid { grid-template-columns: 1fr; }
    .os-info-item { padding: 0.625rem 0.75rem; }
    .os-info-item .ii-val { font-size: 0.78rem; margin-left: 0; }
    .os-info-item .ii-top { margin-bottom: 0.25rem; }
    .os-table { min-width: 260px; }
    .os-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .os-table tbody td { padding: 0.375rem 0.5rem; font-size: 0.72rem; }
    .os-table tfoot td { padding: 0.3rem 0.5rem; font-size: 0.72rem; }
    .os-table .total-val { font-size: 0.85rem; }
    .os-table .grand-total .total-val { font-size: 0.9rem; }
    .os-section { margin-bottom: 1rem; }
    .os-section h2 { font-size: 0.72rem; }
    .os-section h2 svg { width: 13px; height: 13px; }
    .os-addr-body { padding: 0.75rem; font-size: 0.78rem; }
    .os-addr-icon { width: 2rem; height: 2rem; }
    .os-addr-icon svg { width: 15px; height: 15px; }
    .os-proof-row .pr-icon { width: 1.6rem; height: 1.6rem; }
    .os-proof-row .pr-icon svg { width: 13px; height: 13px; }
    .os-status-wrap { padding: 0.75rem; }
    .os-btn { font-size: 0.75rem; padding: 0.45rem 1rem; }
    .os-locked { padding: 1rem; font-size: 0.78rem; }
    .os-warning { padding: 0.875rem; font-size: 0.78rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="os-hero os-animate">
    <div class="hero-grid">
        <div class="hero-left">
            <h1>
                <span class="hero-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </span>
                Order <span class="ord-hash">#{{ $order->order_number }}</span>
            </h1>
            <div class="hero-meta">
                <span class="meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $order->created_at->format('F d, Y') }}
                </span>
                <span class="meta-sep"></span>
                <span class="meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $order->created_at->format('h:i A') }}
                </span>
                <span class="meta-sep"></span>
                <span class="hero-badge bg-{{ $order->payment_status }}">
                    <span class="badge-dot" style="background:{{ $order->payment_status === 'unpaid' ? '#9ca3af' : ($order->payment_status === 'pending' ? '#fbbf24' : ($order->payment_status === 'paid' ? '#93c5fd' : ($order->payment_status === 'approved' ? '#86efac' : '#fca5a5'))) }};"></span>
                    {{ $order->payment_status }}
                </span>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.orders.index') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Orders
            </a>
        </div>
    </div>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="os-msg success os-animate os-animate-d1">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="os-msg error os-animate os-animate-d1">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- Order Information Card --}}
<div class="os-card os-animate os-animate-d1">
    <div class="os-section">
        <h2>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            Order Information
        </h2>
        <div class="os-info-grid">
            <div class="os-info-item">
                <div class="ii-top">
                    <span class="ii-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </span>
                    <span class="ii-lbl">Payment Status</span>
                </div>
                <div class="ii-val" style="text-transform:capitalize;">
                    @php
                        $statusColors = ['unpaid' => '#6b7280', 'pending' => '#d97706', 'paid' => '#2563eb', 'approved' => '#059669', 'rejected' => '#dc2626'];
                        $dotColor = $statusColors[$order->payment_status] ?? '#6b7280';
                    @endphp
                    <span class="status-dot-indicator" style="background:{{ $dotColor }};"></span>
                    {{ $order->payment_status }}
                </div>
            </div>
            <div class="os-info-item">
                <div class="ii-top">
                    <span class="ii-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </span>
                    <span class="ii-lbl">Order Status</span>
                </div>
                <div class="ii-val" style="text-transform:capitalize;">{{ $order->status }}</div>
            </div>
            <div class="os-info-item">
                <div class="ii-top">
                    <span class="ii-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <span class="ii-lbl">Email</span>
                </div>
                <div class="ii-val" style="font-weight:500;font-size:0.85rem;">{{ $order->email }}</div>
            </div>
            <div class="os-info-item">
                <div class="ii-top">
                    <span class="ii-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </span>
                    <span class="ii-lbl">Phone</span>
                </div>
                <div class="ii-val" style="font-weight:500;">{{ $order->phone ?? 'N/A' }}</div>
            </div>
            @if($order->status === 'cancelled' && $order->cancelled_by)
                <div class="os-info-item">
                    <div class="ii-top">
                        <span class="ii-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        </span>
                        <span class="ii-lbl">Cancelled By</span>
                    </div>
                    <div class="ii-val" style="text-transform:capitalize;">{{ $order->cancelled_by === 'user' ? 'Customer' : 'Admin' }}</div>
                </div>
            @endif
        </div>
    </div>

    {{-- Order Items --}}
    <div class="os-section">
        <h2>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
            Order Items
            <span class="section-count">{{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}</span>
        </h2>
        <div class="os-table-container">
            <div class="os-table-wrap">
                <table class="os-table">
                    <thead>
                        <tr>
                            <th style="width:50%;">Product</th>
                            <th class="center" style="width:15%;">Qty</th>
                            <th class="right" style="width:17.5%;">Price</th>
                            <th class="right" style="width:17.5%;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td><span class="product-name">{{ $item->product_name }}</span></td>
                                <td class="center">{{ $item->quantity }}</td>
                                <td class="right">{{ currencyFormat($item->product_price) }}</td>
                                <td class="right bold">{{ currencyFormat($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" class="right total-label">Subtotal</td><td class="right">{{ currencyFormat($order->subtotal) }}</td></tr>
                        <tr><td colspan="3" class="right total-label">Shipping</td><td class="right">{{ currencyFormat($order->shipping_cost) }}</td></tr>
                        <tr><td colspan="3" class="right total-label">VAT</td><td class="right">{{ currencyFormat($order->tax) }}</td></tr>
                        <tr class="grand-total">
                            <td colspan="3" class="right total-label" style="font-size:0.72rem;">Total</td>
                            <td class="right total-val">{{ currencyFormat($order->total) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Shipping Address --}}
    @if($order->shippingAddress)
        <div class="os-section" style="margin-bottom:0;">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Shipping Address
            </h2>
            <div class="os-addr-card">
                <div class="os-addr-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div class="os-addr-body">
                    <div class="addr-name">{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</div>
                    <div class="addr-line">{{ $order->shippingAddress->address_line1 }}</div>
                    @if($order->shippingAddress->address_line2)
                        <div class="addr-line">{{ $order->shippingAddress->address_line2 }}</div>
                    @endif
                    <div class="addr-line">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</div>
                    <div class="addr-line">{{ $order->shippingAddress->country }}</div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Payment Proof --}}
@if($order->transaction_id || $order->proof_image || $order->payment_method)
    <div class="os-card os-proof-card os-animate os-animate-d3">
        <div class="os-section" style="margin-bottom:0;">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Payment Proof
            </h2>
            <div class="os-proof-detail">
                @if($order->payment_method)
                    <div class="os-proof-row">
                        <div class="pr-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        </div>
                        <div class="pr-content">
                            <div class="pr-lbl">Payment Method</div>
                            <div class="pr-val" style="text-transform: uppercase;">{{ $order->payment_method }}</div>
                        </div>
                    </div>
                @endif
                @if($order->transaction_id)
                    <div class="os-proof-row">
                        <div class="pr-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        </div>
                        <div class="pr-content">
                            <div class="pr-lbl">Transaction ID</div>
                            <div class="pr-val">{{ $order->transaction_id }}</div>
                        </div>
                    </div>
                @endif
                @if($order->proof_image)
                    <div class="os-proof-row">
                        <div class="pr-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <div class="pr-content">
                            <div class="pr-lbl">Proof Screenshot</div>
                            <div class="os-proof-img">
                                <img src="{{ $order->proof_image_url }}" alt="Payment Proof">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @if($order->payment_status !== 'approved' && $order->payment_status !== 'rejected' && !in_array($order->status, ['delivered', 'cancelled']))
                <div class="os-proof-actions">
                    <form action="{{ route('admin.orders.approvePayment', $order->id) }}" method="POST" style="display:inline;" id="approveForm">@csrf @method('PATCH')</form>
                    <form action="{{ route('admin.orders.rejectPayment', $order->id) }}" method="POST" style="display:inline;" id="rejectForm">@csrf @method('PATCH')</form>
                    <button type="button" onclick="confirmApprove()" class="os-btn os-btn-green">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Approve Payment
                    </button>
                    <button type="button" onclick="confirmReject()" class="os-btn os-btn-red">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reject Payment
                    </button>
                </div>
            @elseif($order->payment_status === 'approved')
                <div class="os-status-badge approved" style="margin-top:1rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Payment Approved
                </div>
            @elseif($order->payment_status === 'rejected')
                <div class="os-status-badge rejected" style="margin-top:1rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Payment Rejected
                </div>
            @endif
        </div>
    </div>
@endif

{{-- Status Update or Locked --}}
<div class="os-card os-animate os-animate-d4">
    @if(in_array($order->status, ['delivered', 'cancelled']))
        <div class="os-locked">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <div>
                <strong>Status Locked</strong> &mdash; This order is <strong>{{ $order->status }}</strong> and cannot be changed.
            </div>
        </div>
    @elseif($order->transaction_id && !in_array($order->payment_status, ['approved', 'rejected']))
        <div class="os-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                Please <strong>Approve</strong> or <strong>Reject</strong> the payment first before updating status.
            </div>
        </div>
    @else
        <div class="os-section" style="margin-bottom:0;">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Update Status
            </h2>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" id="statusForm">
                @csrf @method('PATCH')
                <div class="os-status-wrap">
                    <select name="status" id="statusSelect">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="button" onclick="confirmStatus()" class="os-btn os-btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function confirmApprove() {
        Swal.fire({
            title: 'Approve Payment?',
            text: 'This will mark the payment as approved and set order status to processing.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('approveForm').submit();
        });
    }
    function confirmReject() {
        Swal.fire({
            title: 'Reject Payment?',
            text: 'This will reject the payment and cancel the order.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('rejectForm').submit();
        });
    }
    function confirmStatus() {
        var sel = document.getElementById('statusSelect');
        Swal.fire({
            title: 'Update Status?',
            text: 'Change order status to ' + sel.options[sel.selectedIndex].text + '?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Update',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('statusForm').submit();
        });
    }
</script>
@endpush
