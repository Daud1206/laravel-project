@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold">Edit Event</h2>
        <p class="text-muted">Edit the details of your event below.</p>

        <!-- Formulir Edit Event -->
        <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title Field -->
            <div class="mb-3">
                <label for="title" class="form-label">Event Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
                    value="{{ old('title', $event->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category Field -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror"
                    required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date Field -->
            <div class="mb-3">
                <label for="date" class="form-label">Event Date</label>
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date"
                    value="{{ old('date', $event->date) }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Location Field -->
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                    id="location" value="{{ old('location', $event->location) }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    id="description" rows="4">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Number Field -->
            <div class="mb-3">
                <label for="contact_phone" class="form-label">Contact Number</label>
                <input type="text" name="contact_phone" class="form-control" id="contact_phone"
                    value="{{ old('contact_phone', $event->contact_phone) }}">
            </div>


            <!-- Submit Butt -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Event</button>
            </div>
        </form>
    </div>
@endsection