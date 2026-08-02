<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bloopsie.id — Handmade Happiness, Delivered')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/Logo.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Untuk sekarang CSS kita taruh sini biar gampang, nanti di Phase 4 kita pindah ke file external public/css/style.css -->
@vite(['resources/css/style.css', 'resources/js/app.js'])
@stack('styles')
</head>
<body>

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    @stack('scripts')
</body>
</html>