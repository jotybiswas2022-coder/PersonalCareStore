<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cart rows belonging to the signed-in customer, or to the guest session.
     */
    public static function forCurrentOwner(): Builder
    {
        return auth()->check()
            ? static::query()->where('user_id', auth()->id())
            : static::query()->whereNull('user_id')->where('session_id', session()->getId());
    }

    /**
     * Owner columns for a brand new cart row.
     */
    public static function currentOwnerAttributes(): array
    {
        return auth()->check()
            ? ['user_id' => auth()->id(), 'session_id' => null]
            : ['user_id' => null, 'session_id' => session()->getId()];
    }
}
