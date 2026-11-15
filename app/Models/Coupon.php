<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_subtotal',
        'usage_limit',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_subtotal' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'is_active' => 'boolean',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public static function normalizeCode(?string $code): string
    {
        return strtoupper(trim((string) $code));
    }

    public static function findByCode(?string $code): ?self
    {
        $normalized = self::normalizeCode($code);

        if ($normalized === '') {
            return null;
        }

        return self::whereRaw('UPPER(code) = ?', [$normalized])->first();
    }

    /**
     * Human readable reason the coupon cannot be used for this subtotal.
     */
    public function validationError(float $subtotal): ?string
    {
        if (! $this->is_active) {
            return 'This coupon is no longer available.';
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return 'This coupon is not active yet.';
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'This coupon has expired.';
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return 'This coupon has reached its usage limit.';
        }

        if ($subtotal < (float) $this->min_subtotal) {
            return 'This coupon needs a minimum order of ' . currencyFormat($this->min_subtotal) . '.';
        }

        return null;
    }

    /**
     * Discount amount for the given subtotal, never above the subtotal.
     */
    public function discountFor(float $subtotal): float
    {
        $discount = $this->type === 'fixed'
            ? (float) $this->value
            : $subtotal * ((float) $this->value / 100);

        return round(min($discount, $subtotal), 2);
    }

    /**
     * Resolve a coupon code that is stored in the session for this subtotal.
     *
     * @return array{coupon: ?self, discount: float, error: ?string}
     */
    public static function resolveSessionCoupon(?string $code, float $subtotal): array
    {
        $coupon = self::findByCode($code);

        if (! $coupon) {
            return ['coupon' => null, 'discount' => 0.0, 'error' => null];
        }

        $error = $coupon->validationError($subtotal);

        if ($error) {
            return ['coupon' => null, 'discount' => 0.0, 'error' => $error];
        }

        return ['coupon' => $coupon, 'discount' => $coupon->discountFor($subtotal), 'error' => null];
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'fixed'
            ? currencyFormat($this->value) . ' off'
            : rtrim(rtrim((string) $this->value, '0'), '.') . '% off';
    }
}
