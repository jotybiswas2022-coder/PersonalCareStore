<style>
    .cp-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .cp-head h1 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a; }
    .cp-head p { margin-top: 0.25rem; font-size: 0.8125rem; color: #64748b; }
    .cp-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; box-shadow: 0 18px 40px -36px rgba(15,23,42,0.55); overflow: hidden; }
    .cp-card + .cp-card { margin-top: 1.25rem; }
    .cp-card-head { padding: 1rem 1.25rem; border-bottom: 1px solid #eef2f7; font-size: 0.9375rem; font-weight: 700; color: #0f172a; }
    .cp-body { padding: 1.25rem; }
    .cp-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
    .cp-table thead th { text-align: left; padding: 0.75rem 1.25rem; background: #f8fafc; color: #64748b; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; white-space: nowrap; }
    .cp-table tbody td { padding: 0.875rem 1.25rem; border-top: 1px solid #eef2f7; color: #334155; vertical-align: middle; }
    .cp-code { font-weight: 800; letter-spacing: 0.06em; color: #0f172a; }
    .cp-muted { color: #94a3b8; }
    .cp-badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.1875rem 0.5rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 700; }
    .cp-badge.on { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .cp-badge.off { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .cp-actions { display: flex; align-items: center; gap: 0.375rem; justify-content: flex-end; flex-wrap: wrap; }
    .cp-btn { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 0.875rem; border-radius: 0.625rem; border: 1px solid #e2e8f0; background: #fff; color: #334155; font-family: inherit; font-size: 0.75rem; font-weight: 700; text-decoration: none; cursor: pointer; transition: background 0.2s, border-color 0.2s, color 0.2s; }
    .cp-btn:hover { background: #f8fafc; border-color: #cbd5e1; }
    .cp-btn-primary { background: #0f766e; border-color: #0f766e; color: #fff; }
    .cp-btn-primary:hover { background: #115e59; border-color: #115e59; }
    .cp-btn-danger { color: #b91c1c; border-color: #fecaca; }
    .cp-btn-danger:hover { background: #fef2f2; }
    .cp-empty { padding: 3rem 1.5rem; text-align: center; color: #64748b; font-size: 0.875rem; }
    .cp-field { margin-bottom: 1rem; }
    .cp-field label { display: block; margin-bottom: 0.375rem; font-size: 0.75rem; font-weight: 700; color: #334155; }
    .cp-field input[type="text"], .cp-field input[type="number"], .cp-field input[type="datetime-local"], .cp-field select {
        width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.625rem; background: #fff;
        font-family: inherit; font-size: 0.8125rem; color: #0f172a; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .cp-field input:focus, .cp-field select:focus { border-color: #34d399; box-shadow: 0 0 0 4px rgba(16,185,129,0.12); }
    .cp-field .hint { margin-top: 0.25rem; font-size: 0.6875rem; color: #94a3b8; }
    .cp-field .error { margin-top: 0.25rem; font-size: 0.6875rem; color: #b91c1c; font-weight: 600; }
    .cp-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 1rem; }
    .cp-check { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 600; color: #334155; }
    .cp-check input { width: 1rem; height: 1rem; accent-color: #0f766e; }
    .cp-form-actions { display: flex; align-items: center; gap: 0.5rem; margin-top: 1.25rem; }
    .cp-flash { margin-bottom: 1rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-size: 0.8125rem; }
    .cp-flash.ok { background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; }
    .cp-flash.bad { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    @media (max-width: 720px) {
        .cp-grid { grid-template-columns: 1fr; }
        .cp-table thead { display: none; }
        .cp-table tbody td { display: block; padding: 0.375rem 1rem; border: none; }
        .cp-table tbody tr { display: block; padding: 0.75rem 0; border-top: 1px solid #eef2f7; }
        .cp-actions { justify-content: flex-start; }
    }
</style>
