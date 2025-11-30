@extends('layouts.main')

@section('title', 'Event Details')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <!-- Back Button -->
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mb-3">
                ← Back to Events
            </a>

            <div class="card shadow-sm">

                <!-- Header -->
                <div class="card-header bg-primary text-white">
                    <h4 class="fw-bold mb-1">{{ $event->title }}</h4>
                    <small class="opacity-75">
                        {{ \Carbon\Carbon::parse($event->date)->format('l, j F Y') }}
                    </small>
                </div>

                <div class="card-body">

                    <!-- Event Info Section -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-2">Event Information</h6>
                        
                        <div class="mb-2">
                            <strong class="text-dark">Location:</strong>
                            <span>{{ $event->location ?? 'No location provided' }}</span>
                        </div>

                        <div class="mb-2">
                            <strong class="text-dark">Category:</strong>
                            <span>{{ $event->category->name }}</span>
                        </div>

                        <div class="mb-2">
                            <strong class="text-dark">Contact Phone:</strong>
                            <span>{{ $event->contact_phone ?? 'No contact number provided.' }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-2">Description</h6>
                        <p class="mb-0">
                            {{ $event->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-3">
                        @php $ts = $event->temporal_status; @endphp

                        @if($ts === 'expired')
                            <span class="badge bg-secondary px-3 py-2">Expired</span>
                        @elseif($ts === 'ongoing')
                            <span class="badge bg-success px-3 py-2">Ongoing</span>
                        @else
                            <span class="badge bg-info text-dark px-3 py-2">Coming Soon</span>
                        @endif
                    </div>

                    <!-- Admin Controls -->
                    @if(auth()->user()->role === 'admin')
                        <hr>

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('events.edit', $event->id) }}"
                               class="btn btn-warning px-4">
                                Edit Event
                            </a>

                            <form action="{{ route('events.destroy', $event->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger px-4">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
