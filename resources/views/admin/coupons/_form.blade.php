@csrf
@if($coupon ?? null)
    @method('PUT')
@endif

<div class="cp-grid">
    <div class="cp-field">
        <label for="code">Coupon code</label>
        <input type="text" id="code" name="code" value="{{ old('code', $coupon->code ?? '') }}" placeholder="EID20" required>
        <div class="hint">Saved in uppercase, customers can type it in any case.</div>
        @error('code') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="cp-field">
        <label for="type">Discount type</label>
        <select id="type" name="type" required>
            <option value="percent" @selected(old('type', $coupon->type ?? 'percent') === 'percent')>Percentage</option>
            <option value="fixed" @selected(old('type', $coupon->type ?? 'percent') === 'fixed')>Fixed amount</option>
        </select>
        @error('type') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="cp-field">
        <label for="value">Discount value</label>
        <input type="number" id="value" name="value" step="0.01" min="0.01" value="{{ old('value', $coupon->value ?? '') }}" required>
        <div class="hint">Percentage (1-100) or a fixed amount in store currency.</div>
        @error('value') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="cp-field">
        <label for="min_subtotal">Minimum order subtotal</label>
        <input type="number" id="min_subtotal" name="min_subtotal" step="0.01" min="0" value="{{ old('min_subtotal', $coupon->min_subtotal ?? 0) }}">
        <div class="hint">Leave 0 for no minimum.</div>
        @error('min_subtotal') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="cp-field">
        <label for="usage_limit">Usage limit</label>
        <input type="number" id="usage_limit" name="usage_limit" min="1" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" placeholder="Unlimited">
        <div class="hint">Total number of orders that may use this coupon.</div>
        @error('usage_limit') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="cp-field">
        <label for="expires_at">Expires at</label>
        <input type="datetime-local" id="expires_at" name="expires_at"
               value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
        <div class="hint">Leave empty for no expiry date.</div>
        @error('expires_at') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="cp-field">
    <label class="cp-check">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active ?? true))>
        Active and usable at checkout
    </label>
</div>

<div class="cp-form-actions">
    <button type="submit" class="cp-btn cp-btn-primary">{{ isset($coupon) ? 'Save changes' : 'Create coupon' }}</button>
    <a href="{{ route('admin.coupons.index') }}" class="cp-btn">Cancel</a>
</div>
