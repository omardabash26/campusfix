<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'priority',
        'status',
        'location_id',
        'device_id',
        'category_id',
        'reported_by',
        'assigned_to',
        'solution',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at'   => 'datetime',
    ];

    // Auto-generate ticket_number on creation: TKT-2024-0001
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $year  = now()->year;
            $count = Ticket::whereYear('created_at', $year)->count() + 1;
            $ticket->ticket_number = 'TKT-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }

    // ─── Relationships ───────────────────────────────────────

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // The user who reported this ticket
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // The technician assigned to this ticket
    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class);
    }

    // ─── Status Label Helpers ─────────────────────────────────

    public function statusLabel(): string
    {
        return match($this->status) {
            'open'        => 'פתוח',
            'assigned'    => 'הוקצה',
            'in_progress' => 'בטיפול',
            'resolved'    => 'טופל',
            'closed'      => 'סגור',
            default       => $this->status,
        };
    }

    public function priorityLabel(): string
    {
        return match($this->priority) {
            'low'      => 'נמוכה',
            'medium'   => 'בינונית',
            'high'     => 'גבוהה',
            'critical' => 'קריטית',
            default    => $this->priority,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'open'        => 'secondary',
            'assigned'    => 'primary',
            'in_progress' => 'warning',
            'resolved'    => 'success',
            'closed'      => 'dark',
            default       => 'secondary',
        };
    }

    public function priorityColor(): string
    {
        return match($this->priority) {
            'low'      => 'success',
            'medium'   => 'warning',
            'high'     => 'danger',
            'critical' => 'dark',
            default    => 'secondary',
        };
    }
}