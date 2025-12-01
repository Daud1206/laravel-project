@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Welcome, {{ auth()->user()->name }} 🌿</h2>
    <p class="text-muted">Track climate events, join activities, and create new initiatives.</p>
</div>

<div class="row mb-4">
    <!-- Total Events -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-calendar-event fs-2 me-3 text-success"></i>
                <div>
                    <h6 class="text-muted mb-1">Total Events</h6>
                    <h2 class="fw-bold text-success">{{ $totalEvents ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-tags fs-2 me-3 text-success"></i>
                <div>
                    <h6 class="text-muted mb-1">Categories</h6>
                    <h2 class="fw-bold text-success">{{ $totalCategories ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Nearest Event -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="text-muted mb-1">Nearest Event</h6>
                @if($nextEvent)
                    <h5 class="fw-bold">{{ $nextEvent->title }}</h5>
                    <p class="text-muted mb-1">
                        {{ $nextEvent->date }}
                        @if($nextEvent->category)
                            — {{ $nextEvent->category->name }}
                        @endif
                    </p>
                    <span class="badge bg-success text-white">Coming Soon</span>
                @else
                    <h5 class="fw-bold">No upcoming events</h5>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- RECENT EVENTS -->
<div class="card shadow-sm border-0 mb-4 border-left-success">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <span class="fw-bold">Recent Events</span>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('events.create') }}" class="btn btn-outline-success btn-sm">+ Create Event</a>
        @endif
    </div>
    <div class="card-body">
        @if($recentEvents->count() > 0)
            <div class="row g-3">
                @foreach($recentEvents as $event)
                    <div class="col-md-6">
                        <div class="card border border-light shadow-sm hover-card border-start-success">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $event->title }}</h6>

                                    <!-- Status -->
                                    <small class="d-block mb-1">
                                        @if($event->isComingSoon())
                                            <span class="badge bg-info text-dark">Coming Soon</span>
                                        @elseif($event->isOngoing())
                                            <span class="badge bg-success">Ongoing</span>
                                        @else
                                            <span class="badge bg-secondary">Expired</span>
                                        @endif
                                    </small>

                                    <small class="text-muted">
                                        {{ $event->date }} 
                                        @if($event->category) — {{ $event->category->name }} @endif
                                    </small>
                                </div>

                                <a href="{{ route('events.show', ['event' => $event->id, 'from' => 'dashboard']) }}" 
                                   class="btn btn-outline-success btn-sm">
                                   View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">No events created yet.</p>
        @endif
    </div>
</div>


{{--JOINED EVENTS — HANYA UNTUK USER, BUKAN ADMIN--}}
@if(auth()->user()->role !== 'admin')
    <!-- JOINED EVENTS -->
    <div class="card shadow-sm border-0 mb-4 border-left-success">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-bold">Joined Events ({{ $joinedEventsCount }})</span>
        </div>

        <div class="card-body">
            @if($joinedEvents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($joinedEvents as $event)
                                <tr class="hover-row">
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->date }}</td>

                                    <td>
                                        @if($event->category)
                                            <span class="badge bg-success">{{ $event->category->name }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if($event->isComingSoon())
                                            <span class="badge bg-info text-dark">Coming Soon</span>
                                        @elseif($event->isOngoing())
                                            <span class="badge bg-success">Ongoing</span>
                                        @else
                                            <span class="badge bg-secondary">Expired</span>
                                        @endif
                                    </td>

                                    <td class="d-flex gap-2">
                                        <!-- VIEW -->
                                        <a href="{{ route('events.show', ['event' => $event->id, 'from' => 'dashboard']) }}" 
                                           class="btn btn-outline-success btn-sm">View</a>

                                        <!-- LEAVE -->
                                        <form action="{{ route('events.leave', $event->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to leave this event?')">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Leave</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <p class="text-muted mb-0 text-center">No joined events yet.</p>
            @endif
        </div>
    </div>
@endif


<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.75rem 1rem rgba(0,0,0,0.1) !important;
}
.hover-row:hover {
    background-color: rgba(40,167,69,0.1);
}
.border-left-success {
    border-left: 4px solid #28a745 !important;
}
.border-start-success {
    border-left: 4px solid #28a745 !important;
}
</style>

@endsection
