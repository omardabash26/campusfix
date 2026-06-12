<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{
    protected $fillable = [
        'name',
        'type',
        'serial_number',
        'location_id',
        'description',
        'qr_token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto-generate qr_token if the device gets its own QR
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($device) {
            if (empty($device->qr_token)) {
                $device->qr_token = Str::uuid();
            }
        });
    }

    // ─── Relationships ───────────────────────────────────────

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}