<?php

// app/Http/Controllers/Admin/EventController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('admin.events.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $events = Event::select('id', 'title', 'start_time', 'end_time', 'location', 'total_seats', 'available_seats')->get();
            return response()->json(['data' => $events]);
        }

        return abort(403);
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'location' => 'required',
            'total_seats' => 'required|integer',
            'available_seats' => 'required|integer|lte:total_seats',
        ]);

        // Check if same event already exists
        $existingEvent = Event::where('title', $request->title)
            ->where('start_time', $request->start_time)
            ->where('location', $request->location)
            ->first();

        if ($existingEvent) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'An event with the same title, start time, and location already exists.']);
        }

        Event::create($request->only([
            'title',
            'description',
            'start_time',
            'end_time',
            'location',
            'total_seats',
            'available_seats',
        ]));

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

