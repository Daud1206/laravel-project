@extends('layouts.main')

@section('title', 'Add Category')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <h4 class="mb-4">Add New Category</h4>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Category Name</label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       required>

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button class="btn btn-success px-4">Save</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary ms-2">Back</a>
        </form>

    </div>
</div>
@endsection
