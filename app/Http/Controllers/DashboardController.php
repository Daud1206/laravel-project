<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // total counts
        $totalEvents = Event::count();
        $totalCategories = Category::count();

        // hari ini (format date string)
        $today = Carbon::today()->toDateString(); // e.g. '2025-11-28'

        // nearest upcoming event = first event with date > today
        // OPTIONAL: uncomment ->where('status','approved') if you only want approved events to appear
        $nextEvent = Event::whereDate('date', '>', $today)
                          // ->where('status', 'approved')
                          ->orderBy('date', 'asc')
                          ->with('category') // eager-load category for display
                          ->first();

        // recent events (last created) — tunable: change order / limit as needed
        $recentEvents = Event::orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();

        return view('dashboard', compact('totalEvents', 'totalCategories', 'nextEvent', 'recentEvents'));
    }
}
