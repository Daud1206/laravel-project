<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = strtolower($request->input('search'));
        $status = $request->input('status');
        $today = now()->toDateString();

        $events = Event::query();

        if ($status === 'coming') {
            $events->whereDate('date', '>', $today);
        } elseif ($status === 'ongoing') {
            $events->whereDate('date', '=', $today);
        } elseif ($status === 'expired') {
            $events->whereDate('date', '<', $today);
        }

        if (!empty($search)) {

            $events->where(function ($query) use ($search, $today) {

                if ($search === 'coming' || $search === 'coming soon') {
                    $query->whereDate('date', '>', $today);
                } elseif ($search === 'ongoing') {
                    $query->whereDate('date', '=', $today);
                } elseif ($search === 'expired') {
                    $query->whereDate('date', '<', $today);
                }

                $query->orWhere('title', 'LIKE', "%$search%")
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'LIKE', "%$search%");
                    });
            });
        }

        $events = $events->with('category')
            ->orderBy('date', 'asc')
            ->paginate(10)
            ->appends([
                'search' => $request->search,
                'status' => $request->status
            ]);

        return view('events.index', compact('events', 'search', 'status'));
    }




    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('events.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
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

    public function show(Request $request, $id)
    {
        $event = Event::with('category')->findOrFail($id);

        $from = $request->query('from', 'events');

        return view('events.show', [
            'event' => $event,
            'from' => $from,
        ]);
    }


    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $event = Event::findOrFail($id);

        return view('events.edit', [
            'event' => $event,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, $id)
    {
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

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }

    public function join($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        if ($event->users()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'You already joined this event.');
        }

        $event->users()->attach($user->id);

        return back()->with('success', 'Successfully joined event!');
    }

    public function leave(Event $event)
    {
        $event->users()->detach(auth()->id());
        return back()->with('success', 'You left the event.');
    }

}
