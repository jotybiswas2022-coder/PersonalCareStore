<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ToLetAdvertisement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'property_type',
        'listing_type',
        'division',
        'district',
        'area_location',
        'full_address',
        'monthly_rent',
        'security_deposit',
        'bedrooms',
        'bathrooms',
        'floor_number',
        'total_floors',
        'property_size',
        'furnishing',
        'tenant_preference',
        'available_from',
        'description',
        'contact_name',
        'contact_phone',
        'contact_email',
        'preferred_contact_method',
        'images',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'available_from' => 'date',
            'monthly_rent' => 'decimal:2',
            'property_size' => 'decimal:2',
            'images' => 'array',
        ];
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function getFirstImageAttribute(): ?string
    {
        $images = $this->images;
        if (!empty($images) && isset($images[0])) {
            return Storage::disk('public')->url($images[0]);
        }
        return null;
    }

    public function getAllImagesAttribute(): array
    {
        $images = $this->images ?? [];
        return array_map(fn($path) => Storage::disk('public')->url($path), $images);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
