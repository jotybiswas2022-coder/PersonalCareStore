<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'view_token',
        'admin_reply',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }

    public function scopeUnreplied($query)
    {
        return $query->whereNull('admin_reply');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
