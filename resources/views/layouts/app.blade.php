<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Custom CSS jika ada -->
</head>
<body>

    <header>
        @include('partials.navbar')
    </header>

    <main class="container my-4">
        @yield('content')
    </main>

    <footer class="footer bg-light text-center">
        <div class="container">
            <span class="text-muted">&copy; {{ date('Y') }} My App. All rights reserved.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>