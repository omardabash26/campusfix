<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['location', 'category', 'reporter'])
            ->where('assigned_to', auth()->id())
            ->latest()
            ->get();

        $stats = [
            'assigned'    => $tickets->whereIn('status', ['assigned'])->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'resolved'    => $tickets->whereIn('status', ['resolved', 'closed'])->count(),
        ];

        return view('technician.dashboard', compact('tickets', 'stats'));
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id()) {
            abort(403, 'הקריאה אינה מוקצית אליך.');
        }

        $ticket->load(['location', 'category', 'reporter', 'comments.user', 'statusLogs.changer']);

        return view('technician.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status'   => 'required|in:assigned,in_progress,resolved',
            'solution' => 'nullable|string',
        ]);

        $oldStatus = $ticket->status;
        $newStatus = $request->status;

        if ($newStatus === 'resolved') {
            $request->validate([
                'solution' => 'required|string',
            ], [
                'solution.required' => 'נא לתאר את הפתרון לפני סגירת הקריאה.',
            ]);

            $ticket->solution = $request->solution;
            $ticket->resolved_at = now();
        }

        $ticket->status = $newStatus;
        $ticket->save();

        if ($oldStatus !== $newStatus) {
            $ticket->statusLogs()->create([
                'changed_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'note'       => null,
                'created_at' => now(),
            ]);
        }

        return back()->with('success', 'הסטטוס עודכן.');
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'comment' => 'required|string',
        ]);

        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'התגובה נוספה.');
    }
}
