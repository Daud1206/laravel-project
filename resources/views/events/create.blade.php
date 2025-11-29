@extends('layouts.main')

@section('title', 'Create Event')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <h4 class="mb-4">Create New Event</h4>

        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Event Title</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Location</label>
                <input
                    type="text"
                    name="location"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Date</label>
                <input
                    type="date"
                    name="date"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Description (optional)</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button class="btn btn-success px-4">Create Event</button>
        </form>

    </div>
</div>
@endsection
