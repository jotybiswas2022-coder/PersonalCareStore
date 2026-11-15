<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'guest_email',
        'user_id',
        'status',
        'subtotal',
        'shipping_cost',
        'tax',
        'total',
        'payment_status',
        'payment_method',
        'stripe_payment_id',
        'transaction_id',
        'proof_image',
        'cancelled_by',
        'stock_reserved_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
            'stock_reserved_at' => 'datetime',
        ];
    }

    /**
     * Restore product stock for a cancelled order exactly once.
     *
     * The order row is locked and re-checked so two concurrent cancellations
     * (user and admin) cannot return the same units twice.
     */
    public function releaseStock(): void
    {
        if (! $this->stock_reserved_at) {
            return;
        }

        DB::transaction(function () {
            $order = self::whereKey($this->getKey())->lockForUpdate()->first();

            if (! $order || ! $order->stock_reserved_at) {
                return;
            }

            $order->loadMissing('items');

            foreach ($order->items as $item) {
                if (! $item->product_id) {
                    continue;
                }

                Product::whereKey($item->product_id)->increment('stock_quantity', $item->quantity);
            }

            $order->forceFill(['stock_reserved_at' => null])->save();

            $this->stock_reserved_at = null;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(ShippingAddress::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getEmailAttribute()
    {
        return $this->guest_email ?? $this->user?->email;
    }

    public function getPhoneAttribute()
    {
        return $this->shippingAddress?->phone;
    }

    public function getProofImageUrlAttribute(): ?string
    {
        if (!$this->proof_image) return null;
        return url('media/' . ltrim(preg_replace('#^storage/#', '', $this->proof_image), '/'));
    }
}
