@extends('layouts.main')

@section('title', 'Edit Category')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <h4 class="mb-4">Edit Category</h4>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Category Name</label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}"
                       required>

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button class="btn btn-warning px-4">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary ms-2">Back</a>
        </form>

    </div>
</div>
@endsection
