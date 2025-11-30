@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Category List</h1>

            {{-- Admin only --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                    + Add Category
                </a>
            @endif
        </div>

        <!-- SEARCH BAR (Admin and User can search) -->
        <form method="GET" action="{{ route('categories.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search categories..."
                    value="{{ $search ?? '' }}">
                <button class="btn btn-primary">Search</button>

                @if(!empty($search))
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($categories->isEmpty())
            <div class="text-center text-muted py-5">
                <h4>No categories yet.</h4>
                <p>Admin can create categories to classify events.</p>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Name</th>

                                {{-- Show Actions only for Admin --}}
                                @if(auth()->user()->role === 'admin')
                                    <th style="width: 180px;">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>

                                    {{-- Show Actions only for Admin --}}
                                    @if(auth()->user()->role === 'admin')
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="ms-2 text-secondary text-decoration-none">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger ms-2">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
