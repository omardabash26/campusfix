<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name')->get();

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function qr(Location $location)
    {
        $url = route('scan.show', $location->qr_token);

        return view('admin.locations.qr', compact('location', 'url'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'building'    => 'required|string|max:255',
            'floor'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Location::create($data);

        return redirect()->route('admin.locations.index')->with('success', 'המיקום נוצר בהצלחה.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'building'    => 'required|string|max:255',
            'floor'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $location->update($data);

        return redirect()->route('admin.locations.index')->with('success', 'המיקום עודכן בהצלחה.');
    }

    public function destroy(Location $location)
    {
        if ($location->tickets()->exists()) {
            return back()->with('error', 'לא ניתן למחוק מיקום עם קריאות קיימות.');
        }

        $location->delete();

        return back()->with('success', 'המיקום נמחק.');
    }
}
