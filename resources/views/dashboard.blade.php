@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold">Welcome, {{ auth()->user()->name }} 🌿</h2>
        <p class="text-muted">Track climate events, join activities, and create new initiatives.</p>
    </div>

    <div class="row mb-4">

        <!-- Total Events -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Events</h6>
                    <h2 class="fw-bold text-success">{{ $totalEvents ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Categories</h6>
                    <h2 class="fw-bold text-success">{{ $totalCategories ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Nearest Event -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Nearest Event</h6>

                    @if($nextEvent && \Carbon\Carbon::parse($nextEvent->date)->gt(\Carbon\Carbon::today()))
                        <h5 class="fw-bold">{{ $nextEvent->title }}</h5>
                        <p class="text-muted mb-1">
                            {{ $nextEvent->date }}
                            @if(isset($nextEvent->category))
                                — {{ $nextEvent->category->name }}
                            @endif
                        </p>
                        <span class="badge bg-info text-dark">Coming Soon</span>
                    @else
                        <h5 class="fw-bold">No upcoming events</h5>
                    @endif

                </div>
            </div>
        </div>

    </div>

    <!-- RECENT EVENTS -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <span>Recent Events</span>

            {{-- Hanya admin yang melihat tombol create --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('events.create') }}" class="btn btn-light btn-sm">+ Create Event</a>
            @endif
        </div>

        <div class="card-body">

            @if(isset($recentEvents) && $recentEvents->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($recentEvents as $event)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $event->title }}</strong><br>
                                <small class="text-muted">{{ $event->date }}</small>
                            </div>

                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-success btn-sm">
                                View
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">No events created yet.</p>
            @endif

        </div>
    </div>

@endsection
