<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Management - AnoDomino Company')</title>

    <!-- Google Fonts: Lato -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand text-orange fw-bold" href="{{ route('requests.index') }}">
                AnoDomino Company
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('requests.index') }}">Requests</a></li>

                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('items.index') }}">Items</a></li>

                        @if(auth()->user()->role === 'supervisor' || auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('approvals.pending') }}">Approvals</a></li>
                        @endif

                        @if(auth()->user()->role === 'authoriser' || auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('authorizations.pending') }}">Authorizations</a></li>
                        @endif

                        @if(Auth::user()->role === 'storekeeper' || auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('storekeeper.pending') }}">Storekeeper</a></li>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @endif

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-orange ms-2">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @include('partials.flash')
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
