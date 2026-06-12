<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    protected $fillable = [
        'name',
        'building',
        'floor',
        'description',
        'qr_token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto-generate qr_token when creating a new location
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (empty($location->qr_token)) {
                $location->qr_token = Str::uuid();
            }
        });
    }

    // ─── Relationships ───────────────────────────────────────

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}