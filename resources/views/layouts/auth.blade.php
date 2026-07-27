<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bloopsie')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/Logo.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tempat untuk Vite CSS -->
    @stack('styles')
</head>
<body>

    <!-- Konten Utama (Login/Register) akan masuk ke sini -->
    @yield('content')

    <!-- Tempat untuk Vite JS -->
    @stack('scripts')

</body>
</html>