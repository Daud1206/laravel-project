@extends('layouts.main')

@section('title', 'Event Details')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Card untuk Event -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="fw-bold mb-0">{{ $event->title }}</h5>
                    <small>{{ \Carbon\Carbon::parse($event->date)->format('l, j F Y') }}</small>
                </div>
                <div class="card-body">
                    <p><strong>Location:</strong> {{ $event->location ?? 'No location provided' }}</p>
                    <p><strong>Category:</strong> {{ $event->category->name }}</p>
                    <p><strong>Description:</strong> {{ $event->description ?? 'No description available.' }}</p>
                    
                    <div class="mt-3">
                        <strong>Contact Phone:</strong>
                        <p class="mb-3">{{ $event->contact_phone ?? 'No contact number provided.' }}</p>
                    </div>

                    <!-- Badge untuk Status Event -->
                    <div>
                        @php $ts = $event->temporal_status; @endphp
                        @if($ts === 'expired')
                            <span class="badge bg-secondary">Expired</span>
                        @elseif($ts === 'ongoing')
                            <span class="badge bg-success">Ongoing</span>
                        @else
                            <span class="badge bg-info text-dark">Coming Soon</span>
                        @endif
                    </div>

                    <!-- Button untuk mengedit atau menghapus event (hanya admin) -->
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-4">
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Edit Event</a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger ms-2">Delete Event</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
