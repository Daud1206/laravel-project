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
        $user = auth()->user();

    
        $totalEvents = Event::count();
        $totalCategories = Category::count();

        $today = Carbon::today()->toDateString();

        $nextEvent = Event::whereDate('date', '>', $today)
                          ->orderBy('date', 'asc')
                          ->with('category')
                          ->first();

        $recentEvents = Event::orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();

        $joinedEvents = collect();
        $joinedEventsCount = 0;
        if ($user) {
            $joinedEvents = $user->events()
                                 ->with('category')
                                 ->orderBy('date', 'asc')
                                 ->get(); 
            $joinedEventsCount = $user->events()->count();
        }

        return view('dashboard', compact(
            'totalEvents',
            'totalCategories',
            'nextEvent',
            'recentEvents',
            'joinedEvents',
            'joinedEventsCount'
        ));
    }
}
