<div class="prof-card">
    <div class="card-hdr">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        <h2>Update Password</h2>
    </div>
    <p class="card-sub">Ensure your account is using a long, random password to stay secure.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="field">
            <label for="update_password_current_password">Current Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </span>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Enter current password">
            </div>
            @error('current_password', 'updatePassword')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label for="update_password_password">New Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </span>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password" placeholder="Enter new password">
            </div>
            @error('password', 'updatePassword')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label for="update_password_password_confirmation">Confirm Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </span>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Confirm new password">
            </div>
            @error('password_confirmation', 'updatePassword')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="btn-row">
            <button type="submit" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save
            </button>
            @if (session('status') === 'password-updated')
                <span class="success-msg">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Saved.
                </span>
            @endif
        </div>
    </form>
</div>
