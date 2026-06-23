@extends('frontend.layouts.app')

@section('title', 'My Profile')

@push('styles')
<style>
    /* ── Hero ── */
    .prof-hero {
        background: linear-gradient(135deg, #1a5c3a 0%, #2E8B57 50%, #3CB371 100%);
        padding: 2.5rem 1.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .prof-hero::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -10%;
        width: 20rem;
        height: 20rem;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .prof-hero .prof-avatar {
        width: 4.5rem;
        height: 4.5rem;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: 3px solid rgba(255,255,255,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .prof-hero h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.15rem;
        position: relative;
        z-index: 1;
    }
    .prof-hero .prof-email {
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }

    /* ── Wrap ── */
    .prof-wrap {
        max-width: 48rem;
        margin: 0 auto;
        padding: 1.5rem 1rem 4rem;
    }
    .prof-grid { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Card ── */
    .prof-card {
        background: #fff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .prof-card .card-hdr {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.125rem;
    }
    .prof-card .card-hdr svg { color: #2E8B57; flex-shrink: 0; }
    .prof-card .card-hdr h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
    }
    .prof-card .card-sub {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 1.25rem;
        margin-left: 1.625rem;
    }

    /* ── Form Fields ── */
    .prof-card .field { margin-bottom: 1rem; }
    .prof-card .field .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .prof-card .field .input-wrap .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        display: flex;
        align-items: center;
        pointer-events: none;
    }
    .prof-card .field .input-wrap input {
        width: 100%;
        padding: 0.625rem 0.75rem 0.625rem 2.5rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .prof-card .field .input-wrap input:focus,
    .prof-card .field .input-wrap select:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46,139,87,0.1);
    }
    .prof-card .field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.3rem;
    }
    .prof-card .field .error {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* ── Verification Notice ── */
    .verify-box {
        margin-top: 0.75rem;
        padding: 0.75rem 1rem;
        background: #fefce8;
        border: 1px solid #fde68a;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        color: #854d0e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .verify-box button {
        background: none;
        border: none;
        color: #2E8B57;
        font-weight: 600;
        text-decoration: underline;
        cursor: pointer;
        font-size: 0.8125rem;
    }
    .verify-box .sent {
        margin-top: 0.375rem;
        font-weight: 500;
        color: #16a34a;
        width: 100%;
    }

    /* ── Buttons ── */
    .btn-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1.25rem;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: linear-gradient(135deg, #2E8B57, #3CB371);
        color: #fff;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(46,139,87,0.3);
    }
    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: #dc2626;
        color: #fff;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
    }
    .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220,38,38,0.3);
    }
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: #fff;
        color: #374151;
        border: 1.5px solid #d1d5db;
        padding: 0.6rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    .success-msg {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        color: #16a34a;
        font-weight: 500;
    }

    /* ── Delete Account Card ── */
    .prof-card.danger {
        border-color: #fecaca;
        background: linear-gradient(135deg, #fef2f2 0%, #fff 100%);
    }
    .prof-card.danger .card-hdr svg { color: #dc2626; }
    .prof-card.danger .card-sub { color: #dc2626; }

    /* ── Modal ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        z-index: 50;
        backdrop-filter: blur(2px);
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 0.75rem;
        padding: 1.5rem;
        max-width: 28rem;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalIn 0.2s ease-out;
    }
    .modal-box h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #991b1b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modal-box > p {
        font-size: 0.8125rem;
        color: #6b7280;
        margin-bottom: 1.25rem;
        line-height: 1.6;
    }
    .modal-box .field { margin-bottom: 1.25rem; }
    .modal-box .field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.3rem;
    }
    .modal-box .field input {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .modal-box .field input:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
    }
    .modal-box .field .error { color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; }
    .modal-box .modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .prof-hero { padding: 2rem 1rem 1.5rem; }
        .prof-hero h1 { font-size: 1.25rem; }
        .prof-hero .prof-avatar { width: 3.5rem; height: 3.5rem; }
        .prof-wrap { padding: 1rem 0.75rem 3rem; }
        .prof-card { padding: 1.25rem; }
    }
    @media (max-width: 480px) {
        .prof-hero { padding: 1.5rem 0.75rem 1.25rem; }
        .prof-hero h1 { font-size: 1.1rem; }
        .prof-hero .prof-avatar { width: 3rem; height: 3rem; }
    }
</style>
@endpush

@section('content')
<div class="prof-hero">
    <div class="prof-avatar">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </div>
    <h1>{{ $user->name }}</h1>
    <p class="prof-email">{{ $user->email }}</p>
</div>

<div class="prof-wrap">
    <div class="prof-grid">
        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
