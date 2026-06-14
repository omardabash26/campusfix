<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::where('is_active', true)->orderBy('name')->get();

        $scanLocation = session('scan_location_id') ? Location::find(session('scan_location_id')) : null;

        return view('tickets.create', compact('categories', 'locations', 'scanLocation'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'priority'    => 'required|in:low,medium,high,critical',
        ], [
            'title.required'       => 'נא להזין כותרת.',
            'description.required' => 'נא לתאר את התקלה.',
            'category_id.required' => 'נא לבחור קטגוריה.',
            'location_id.required' => 'נא לבחור מיקום.',
            'priority.required'    => 'נא לבחור עדיפות.',
        ]);

        $data['reported_by'] = auth()->id();
        $data['status'] = 'open';

        $ticket = Ticket::create($data);

        session()->forget('scan_location_id');

        return redirect()
            ->route('tickets.thanks')
            ->with('ticket_number', $ticket->ticket_number);
    }

    public function thanks()
    {
        $ticketNumber = session('ticket_number');

        if (!$ticketNumber) {
            return redirect()->route('tickets.create');
        }

        return view('tickets.thanks', compact('ticketNumber'));
    }
}
