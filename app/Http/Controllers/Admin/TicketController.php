<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\TicketStatusLog;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['location', 'category', 'reporter', 'technician']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $tickets = $query->latest()->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function clearAll()
    {
        TicketStatusLog::query()->delete();
        TicketComment::query()->delete();
        Ticket::query()->delete();

        return back()->with('success', 'כל הקריאות נמחקו מהמערכת.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['location', 'category', 'reporter', 'technician', 'comments.user', 'statusLogs.changer']);
        $technicians = User::where('role', 'technician')->where('is_active', true)->orderBy('name')->get();

        return view('admin.tickets.show', compact('ticket', 'technicians'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $oldStatus = $ticket->status;

        $ticket->update([
            'assigned_to' => $request->assigned_to,
            'status'      => $ticket->status === 'open' ? 'assigned' : $ticket->status,
        ]);

        $this->logStatus($ticket, $oldStatus, $ticket->status, 'הקריאה הוקצתה לטכנאי');

        return back()->with('success', 'הקריאה הוקצתה בהצלחה.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,assigned,in_progress,resolved,closed',
        ]);

        $oldStatus = $ticket->status;
        $newStatus = $request->status;

        $ticket->status = $newStatus;

        if ($newStatus === 'resolved' && !$ticket->resolved_at) {
            $ticket->resolved_at = now();
        }

        if ($newStatus === 'closed' && !$ticket->closed_at) {
            $ticket->closed_at = now();
        }

        $ticket->save();

        $this->logStatus($ticket, $oldStatus, $newStatus, $request->note);

        return back()->with('success', 'הסטטוס עודכן.');
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'התגובה נוספה.');
    }

    private function logStatus(Ticket $ticket, $old, $new, $note = null)
    {
        if ($old === $new) {
            return;
        }

        $ticket->statusLogs()->create([
            'changed_by' => auth()->id(),
            'old_status' => $old,
            'new_status' => $new,
            'note'       => $note,
            'created_at' => now(),
        ]);
    }
}
