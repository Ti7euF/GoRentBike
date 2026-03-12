<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Go Rent Bike')</title>
        
        <link rel="icon" type="image/png" href="/assets/img/logo/logo-dark.png">
        
        <link rel="stylesheet" href="/assets/css/base.css">
        <link rel="stylesheet" href="/assets/css/auth.css">
        <link rel="stylesheet" href="/assets/css/components.css">

        @stack('styles')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <main class="grb-wrapper">
            @yield('content')
        </main>
    </body>
</html>
