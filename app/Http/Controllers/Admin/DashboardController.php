<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'       => Ticket::count(),
            'open'        => Ticket::whereIn('status', ['open', 'assigned'])->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved'    => Ticket::whereIn('status', ['resolved', 'closed'])->count(),
        ];

        $recentTickets = Ticket::with(['location', 'category', 'reporter'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTickets'));
    }
}