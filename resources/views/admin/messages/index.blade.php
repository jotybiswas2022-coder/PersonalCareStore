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
.ms-animate { animation: fadeUp 0.5s ease-out both; }
.ms-animate-d1 { animation-delay: 0.05s; }
.ms-animate-d2 { animation-delay: 0.1s; }
.ms-animate-d3 { animation-delay: 0.15s; }
.ms-animate-d4 { animation-delay: 0.2s; }

/* ── Hero ── */
.ms-hero {
    position: relative;
    margin: -2rem -2rem 1.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, #0b1120 0%, #0f2a1e 40%, #13452a 70%, #0d1b2a 100%);
    overflow: hidden;
    isolation: isolate;
}
.ms-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 0% 50%, rgba(16,185,129,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(52,211,153,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 100%, rgba(5,150,105,0.06) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.ms-hero::after {
    content: '';
    position: absolute;
    top: -25%;
    right: -5%;
    width: 28rem;
    height: 28rem;
    background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulseGlow 4s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.ms-hero .hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
.ms-hero .hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ms-hero .hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    background: rgba(16,185,129,0.18);
    border-radius: 0.75rem;
    color: #34d399;
    flex-shrink: 0;
}
.ms-hero .hero-icon svg { width: 24px; height: 24px; }
.ms-hero .hero-text h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.ms-hero .hero-text p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.125rem;
}

/* ── Stats Grid ── */
.ms-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.ms-stat {
    background: #fff;
    border: 1px solid #e9edf4;
    border-radius: 0.75rem;
    padding: 1rem 1.125rem;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.25s ease;
}
.ms-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border-color: #d1d9e6;
}
.ms-stat .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    flex-shrink: 0;
}
.ms-stat .stat-icon svg { width: 18px; height: 18px; }
.ms-stat .stat-info { flex: 1; min-width: 0; }
.ms-stat .stat-info .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ms-stat .stat-info .stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-top: 0.125rem;
}
.ms-stat .stat-icon.total { background: #ecfdf5; color: #10b981; }
.ms-stat .stat-icon.unreplied { background: #fffbeb; color: #f59e0b; }
.ms-stat .stat-icon.replied { background: #eef2ff; color: #6366f1; }

/* ── Success Message ── */
.ms-msg {
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
.ms-msg.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16,185,129,0.1);
}
.ms-msg.danger {
    background: linear-gradient(135deg, #fef2f2, #fce4e4);
    border: 1px solid #fecaca;
    color: #991b1b;
    box-shadow: 0 2px 8px rgba(220,38,38,0.1);
}

/* ── Card ── */
.ms-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e9edf4;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}
.ms-card:hover {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
}

/* ── Table ── */
.ms-table-wrap {
    overflow-x: auto;
}
@media (max-width: 768px) {
    .ms-table-wrap {
        transform: rotateX(180deg);
    }
    .ms-table-wrap .ms-table {
        transform: rotateX(180deg);
    }
}
.ms-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 550px;
}
.ms-table thead th {
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
.ms-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.ms-table tbody tr:last-child td { border-bottom: none; }
.ms-table tbody tr { transition: background 0.15s ease; }
.ms-table tbody tr:hover td { background: #ecfdf5; }
.ms-table tbody tr:active td { background: #d1fae5; }

/* ── Sender Cell ── */
.ms-sender {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}
.ms-sender .ms-avatar {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 9999px;
    background: #ecfdf5;
    color: #059669;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    flex-shrink: 0;
}
.ms-sender .ms-info { min-width: 0; }
.ms-sender .ms-info .ms-name {
    font-weight: 600;
    color: #111827;
    display: block;
    font-size: 0.85rem;
}
.ms-sender .ms-info .ms-email {
    font-size: 0.75rem;
    color: #6b7280;
    display: block;
    margin-top: 0.05rem;
}

/* ── Preview Cell ── */
.ms-preview {
    color: #6b7280;
    font-size: 0.85rem;
    max-width: 280px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
}

/* ── Date Cell ── */
.ms-date {
    white-space: nowrap;
    font-size: 0.8rem;
    color: #6b7280;
}

/* ── Status Badge ── */
.ms-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.ms-status.replied {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.ms-status.replied .status-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #10b981;
}
.ms-status.unreplied {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}
.ms-status.unreplied .status-dot {
    width: 0.35rem;
    height: 0.35rem;
    border-radius: 50%;
    background: #f59e0b;
}

/* ── Actions ── */
.ms-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.375rem;
}
.ms-actions .btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.45rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}
.ms-actions .btn-action:hover { transform: translateY(-1px); }
.ms-actions .btn-view {
    background: #eef2ff;
    color: #4f46e5;
    border: 1px solid #c7d2fe;
}
.ms-actions .btn-view:hover {
    background: #e0e7ff;
    box-shadow: 0 2px 8px rgba(99,102,241,0.15);
}
.ms-actions .btn-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.ms-actions .btn-delete:hover {
    background: #fce4e4;
    box-shadow: 0 2px 8px rgba(220,38,38,0.15);
}

/* ── Empty State ── */
.ms-empty {
    padding: 3rem 2rem;
    text-align: center;
}
.ms-empty .empty-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3.5rem;
    height: 3.5rem;
    background: #f3f4f6;
    border-radius: 1rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}
.ms-empty .empty-icon svg { width: 28px; height: 28px; }
.ms-empty .empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
}
.ms-empty .empty-sub {
    font-size: 0.85rem;
    color: #9ca3af;
}

/* ── Pagination ── */
.ms-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #edf2f7;
}
.ms-pagination nav { display: flex; justify-content: center; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .ms-hero { padding: 1.75rem 1.5rem; }
    .ms-hero .hero-inner { flex-direction: column; align-items: flex-start; }
    .ms-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .ms-hero { margin: -1rem -1rem 1rem; padding: 1.5rem 1rem; }
    .ms-hero .hero-text h1 { font-size: 1.15rem; }
    .ms-hero .hero-icon { width: 2.25rem; height: 2.25rem; }
    .ms-hero .hero-icon svg { width: 20px; height: 20px; }
    .ms-hero .hero-left { gap: 0.75rem; }
    .ms-stats { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .ms-stat { padding: 0.75rem 0.875rem; }
    .ms-stat .stat-icon { width: 1.75rem; height: 1.75rem; }
    .ms-stat .stat-icon svg { width: 14px; height: 14px; }
    .ms-stat .stat-info .stat-value { font-size: 1rem; }
    .ms-table thead th { padding: 0.5rem 0.625rem; font-size: 0.55rem; }
    .ms-table tbody td { padding: 0.625rem; font-size: 0.78rem; }
    .ms-sender .ms-avatar { width: 1.75rem; height: 1.75rem; font-size: 0.6rem; }
    .ms-sender .ms-info .ms-name { font-size: 0.8rem; }
    .ms-sender .ms-info .ms-email { font-size: 0.68rem; }
    .ms-preview { max-width: 150px; font-size: 0.78rem; }
    .ms-actions .btn-action { padding: 0.35rem 0.5rem; font-size: 0.72rem; }
    .ms-pagination { padding: 0.75rem 1rem; }
}
@media (max-width: 480px) {
    .ms-hero { margin: -0.75rem -0.75rem 0.75rem; padding: 1.25rem 0.75rem; }
    .ms-hero .hero-text h1 { font-size: 1rem; }
    .ms-hero .hero-text p { font-size: 0.75rem; }
    .ms-stats { grid-template-columns: repeat(2, 1fr); }
    .ms-stat { padding: 0.625rem 0.75rem; gap: 0.625rem; }
    .ms-stat .stat-icon { width: 1.5rem; height: 1.5rem; }
    .ms-stat .stat-icon svg { width: 12px; height: 12px; }
    .ms-stat .stat-info .stat-label { font-size: 0.6rem; }
    .ms-stat .stat-info .stat-value { font-size: 0.9rem; }
    .ms-table { min-width: 450px; }
    .ms-table thead th { padding: 0.375rem 0.5rem; font-size: 0.5rem; }
    .ms-table tbody td { padding: 0.5rem; font-size: 0.72rem; }
    .ms-sender .ms-avatar { width: 1.5rem; height: 1.5rem; font-size: 0.55rem; }
    .ms-sender .ms-info .ms-name { font-size: 0.75rem; }
    .ms-sender .ms-info .ms-email { font-size: 0.65rem; }
    .ms-preview { max-width: 100px; font-size: 0.72rem; }
    .ms-actions { gap: 0.25rem; }
    .ms-actions .btn-action { padding: 0.3rem 0.4rem; font-size: 0.68rem; }
    .ms-empty { padding: 2rem 1rem; }
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="ms-hero ms-animate">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="hero-text">
                <h1>Messages</h1>
                <p>Manage contact messages from customers</p>
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="ms-stats ms-animate ms-animate-d1">
    <div class="ms-stat">
        <div class="stat-icon total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Messages</div>
            <div class="stat-value">{{ $totalMessages }}</div>
        </div>
    </div>
    <div class="ms-stat">
        <div class="stat-icon unreplied">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">New / Unreplied</div>
            <div class="stat-value">{{ $unrepliedMessages }}</div>
        </div>
    </div>
    <div class="ms-stat">
        <div class="stat-icon replied">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-label">Replied</div>
            <div class="stat-value">{{ $repliedMessages }}</div>
        </div>
    </div>
</div>

{{-- Success / Danger Message --}}
@if(session('success'))
    <div class="ms-msg success ms-animate ms-animate-d2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- Main Card --}}
<div class="ms-card ms-animate ms-animate-d2">
    {{-- Table --}}
    <div class="ms-table-wrap">
        <table class="ms-table">
            <thead>
                <tr>
                    <th style="width:28%;">From</th>
                    <th style="width:34%;">Message</th>
                    <th style="width:12%;">Date</th>
                    <th style="width:11%;">Status</th>
                    <th style="width:15%;" class="right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td>
                            <div class="ms-sender">
                                <div class="ms-avatar">{{ strtoupper(substr($msg->name, 0, 1)) }}</div>
                                <div class="ms-info">
                                    <span class="ms-name">{{ $msg->name }}</span>
                                    <span class="ms-email">{{ $msg->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="ms-preview">{{ Str::limit($msg->message, 80) }}</span>
                        </td>
                        <td>
                            <span class="ms-date">{{ $msg->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <span class="ms-status {{ $msg->admin_reply ? 'replied' : 'unreplied' }}">
                                <span class="status-dot"></span>
                                {{ $msg->admin_reply ? 'Replied' : 'New' }}
                            </span>
                        </td>
                        <td>
                            <div class="ms-actions">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="btn-action btn-view">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    View
                                </a>
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-action btn-delete delete-btn">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="ms-empty">
                                <div class="empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                </div>
                                <div class="empty-title">No messages yet</div>
                                <div class="empty-sub">Customer messages will appear here.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($messages->hasPages())
        <div class="ms-pagination">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Delete confirmation
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;
        const form = btn.closest('.delete-form');
        const name = form.closest('tr')?.querySelector('.ms-name')?.textContent?.trim() || 'this message';
        Swal.fire({
            title: 'Delete Message?',
            text: `Are you sure you want to delete the message from "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });
</script>
@endpush
