<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'default_priority',
    ];

    // ─── Relationships ───────────────────────────────────────

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}