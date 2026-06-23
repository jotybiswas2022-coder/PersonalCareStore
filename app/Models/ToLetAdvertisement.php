<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ToLetAdvertisement extends Model
{
    protected $fillable = [
        'title',
        'property_type',
        'division',
        'district',
        'area_location',
        'full_address',
        'monthly_rent',
        'bedrooms',
        'bathrooms',
        'property_size',
        'tenant_preference',
        'available_from',
        'description',
        'contact_name',
        'contact_phone',
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
}
