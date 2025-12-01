@extends('layouts.main')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">All Events</h1>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('events.create') }}" class="btn btn-success">
                Create New Event
            </a>
        @endif
    </div>

    <!-- SEARCH & STATUS PILLS -->
    <form id="filterForm" method="GET" action="{{ route('events.index') }}" class="mb-4">

        {{-- SEARCH BAR --}}
        <div class="mb-3">
            <input type="text" name="search" id="searchInput" class="form-control"
                placeholder="Search events..."
                value="{{ request()->search }}">
        </div>

        {{-- STATUS PILLS --}}
        <div class="d-flex gap-2 flex-wrap">

            @php $current = request()->status; @endphp

            <a href="{{ route('events.index', array_merge(request()->all(), ['status' => 'coming'])) }}"
                class="btn btn-sm {{ $current === 'coming' ? 'btn-primary' : 'btn-outline-primary' }}">
                Coming Soon
            </a>

            <a href="{{ route('events.index', array_merge(request()->all(), ['status' => 'ongoing'])) }}"
                class="btn btn-sm {{ $current === 'ongoing' ? 'btn-success' : 'btn-outline-success' }}">
                Ongoing
            </a>

            <a href="{{ route('events.index', array_merge(request()->all(), ['status' => 'expired'])) }}"
                class="btn btn-sm {{ $current === 'expired' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                Expired
            </a>

            {{-- CLEAR STATUS --}}
            @if(request()->status)
                <a href="{{ route('events.index', array_merge(request()->all(), ['status' => null])) }}"
                    class="btn btn-sm btn-outline-dark ms-2">
                    Clear Status
                </a>
            @endif

        </div>

    </form>

    {{-- AUTO SEARCH SCRIPT --}}
    <script>
        let timeout = null;
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 400);
        });
    </script>

    @if($events->isEmpty())
        <div class="text-center text-muted py-5">
            <h4>No events found.</h4>
        </div>
    @else
        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">

                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $event->title }}</h5>

                            <p class="mb-1"><strong>Date:</strong> {{ $event->date }}</p>
                            <p class="mb-1"><strong>Category:</strong> {{ $event->category->name }}</p>
                            <p class="mb-1"><strong>Location:</strong> {{ $event->location ?? 'No location' }}</p>

                            <p class="text-muted mt-2" style="max-height: 60px; overflow: hidden;">
                                {{ $event->description ?? 'No description available' }}
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center bg-light">

                            <div>
                                <a href="{{ route('events.show', $event->id) }}"
                                    class="text-primary text-decoration-none">View</a>

                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('events.edit', $event->id) }}"
                                        class="ms-2 text-secondary text-decoration-none">Edit</a>
                                @endif
                            </div>

                            <div class="d-flex align-items-center">
                                @php $ts = $event->temporal_status; @endphp

                                @if($ts === 'expired')
                                    <span class="badge bg-secondary me-2">Expired</span>
                                @elseif($ts === 'ongoing')
                                    <span class="badge bg-success me-2">Ongoing</span>
                                @else
                                    <span class="badge bg-info text-dark me-2">Coming Soon</span>
                                @endif

                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('events.destroy', $event->id) }}"
                                          method="POST"
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
