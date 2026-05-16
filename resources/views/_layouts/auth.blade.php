<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Go Rent Bike')</title>
        
        <link rel="icon" type="image/webp" href="/uploads/logo/logo-dark.webp">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/base.css">
        <link rel="stylesheet" href="/assets/css/auth.css">
        <link rel="stylesheet" href="/assets/css/components.css">

        @stack('styles')

        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>

    <body>
        <main class="grb-wrapper">
            @yield('content')
        </main>
    </body>
</html>
