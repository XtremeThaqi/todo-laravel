<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Todo App</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    
    @yield('scripts')
    <script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>