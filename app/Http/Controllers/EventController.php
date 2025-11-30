<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Apply search filter if there is a search term
        $events = Event::when($search, function ($query) use ($search) {
            $query->where('title', 'LIKE', "%$search%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                });
        })
            ->with('category')
            ->orderBy('date', 'asc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('events.index', compact('events', 'search'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only admins can create events
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('events.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admins can store events
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'location' => 'nullable|string',
            'date' => 'required|date',
            'contact_phone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        Event::create($validated);

        return redirect('/events')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);

        return view('events.show', [
            'event' => $event,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Only admins can edit events
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $event = Event::findOrFail($id);

        return view('events.edit', [
            'event' => $event,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Only admins can update events
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'location' => 'nullable|string',
            'date' => 'required|date',
            'contact_phone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $event->update($validated);

        return redirect('/events')->with('success', 'Event updated.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        // Only admins can delete events
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }
}
