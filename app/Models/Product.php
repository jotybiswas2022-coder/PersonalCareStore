<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'stock_quantity',
        'sku',
        'category_id',
        'brand',
        'discount_name',
        'discount_percent',
        'images',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'weight' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function getFinalPriceAttribute()
    {
        $base = $this->sale_price ?? $this->price;
        if ($this->discount_percent && $this->sale_price) {
            return round($base - ($base * $this->discount_percent / 100), 2);
        }
        return $base;
    }

    public function getImageUrlsAttribute(): array
    {
        if (!$this->images) return [];
        $baseUrl = config('app.storage_url');
        return array_map(function ($img) use ($baseUrl) {
            $path = preg_replace('#^storage/#', '', $img);
            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }, $this->images);
    }
}
