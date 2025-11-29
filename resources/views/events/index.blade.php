@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">All Events</h1>

            {{-- Hanya admin yang boleh create --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('events.create') }}" class="btn btn-success">
                    Create New Event
                </a>
            @endif
        </div>

        @if($events->isEmpty())
            <div class="text-center text-muted py-5">
                <h4>No events available yet.</h4>
                <p>Events will appear once created by an admin.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">

                            <!-- CARD BODY -->
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">{{ $event->title }}</h5>

                                <p class="card-text mb-1">
                                    <strong>Date:</strong> {{ $event->date }}
                                </p>

                                <p class="card-text mb-1">
                                    <strong>Category:</strong> {{ $event->category->name }}
                                </p>

                                <p class="card-text mb-1">
                                    <strong>Location:</strong> {{ $event->location ?? 'No location' }}
                                </p>

                                <p class="card-text text-muted mt-2" style="max-height: 60px; overflow: hidden;">
                                    {{ $event->description ?? 'No description available' }}
                                </p>
                            </div>

                            <!-- CARD FOOTER -->
                            <div class="card-footer d-flex justify-content-between align-items-center bg-light">

                                <!-- LEFT BUTTONS (VIEW ONLY FOR USER, EDIT FOR ADMIN) -->
                                <div>
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="text-primary text-decoration-none">View</a>

                                    {{-- Admin only: Edit --}}
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('events.edit', $event->id) }}"
                                            class="ms-2 text-secondary text-decoration-none">Edit</a>
                                    @endif
                                </div>

                                <!-- RIGHT STATUS + DELETE -->
                                <div class="d-flex align-items-center">

                                    {{-- TEMPORAL STATUS --}}
                                    @php $ts = $event->temporal_status; @endphp

                                    @if($ts === 'expired')
                                        <span class="badge bg-secondary me-2">Expired</span>
                                    @elseif($ts === 'ongoing')
                                        <span class="badge bg-success me-2">Ongoing</span>
                                    @else
                                        <span class="badge bg-info text-dark me-2">Coming Soon</span>
                                    @endif

                                    {{-- Admin only: Delete --}}
                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this event?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endif

                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection