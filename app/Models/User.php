<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'identity_number',
        'email',
        'password',
        'role',
        'phone',
        'department',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Role Helpers ───────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTechnician(): bool
    {
        return $this->role === 'technician';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isLecturer(): bool
    {
        return $this->role === 'lecturer';
    }

    // ─── Relationships ───────────────────────────────────────

    // Tickets this user reported
    public function reportedTickets()
    {
        return $this->hasMany(Ticket::class, 'reported_by');
    }

    // Tickets assigned to this user (technician)
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class, 'changed_by');
    }
}