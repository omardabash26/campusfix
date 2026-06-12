<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatusLog extends Model
{
    public $timestamps = false; // only has created_at

    protected $fillable = [
        'ticket_id',
        'changed_by',
        'old_status',
        'new_status',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}