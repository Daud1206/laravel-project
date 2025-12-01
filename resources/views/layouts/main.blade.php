<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Climate Action</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="/">Climate Action</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- EVENTS LINK -->
                    <li class="nav-item">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link" href="/admin/events">Events</a>
                            @else
                                <a class="nav-link" href="/events">Events</a>
                            @endif
                        @else
                            <a class="nav-link" href="/events">Events</a>
                        @endauth
                    </li>

                    <!-- CATEGORIES LINK -->
                    <li class="nav-item">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link" href="/admin/categories">Categories</a>
                            @else
                                <a class="nav-link" href="/categories">Categories</a>
                            @endif
                        @else
                            <a class="nav-link" href="/categories">Categories</a>
                        @endauth
                    </li>

                    <!-- DASHBOARD (AUTH ONLY) -->
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>

                        <!-- LOGOUT BUTTON -->
                        <form method="POST" action="/logout" class="d-flex align-items-center">
                            @csrf
                            <button class="btn btn-sm btn-light ms-3">Logout</button>
                        </form>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
