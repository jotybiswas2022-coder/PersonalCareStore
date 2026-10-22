<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'currency',
        'delivery_charge_inside',
        'delivery_charge_outside',
        'vat_percentage',
        'contact_phone',
        'contact_email',
        'contact_address',
        'contact_hours',
        'newsletter_heading',
        'newsletter_text',
        'newsletter_placeholder',
        'newsletter_button_text',
        'newsletter_enabled',
    ];

    protected function casts(): array
    {
        return [
            'delivery_charge_inside' => 'decimal:2',
            'delivery_charge_outside' => 'decimal:2',
            'vat_percentage' => 'decimal:2',
            'newsletter_enabled' => 'boolean',
        ];
    }
}
