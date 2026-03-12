<!DOCTYPE html>
<html lang="es" class="">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Go Rent Bike')</title>
        
        <link rel="icon" type="image/png" href="/assets/img/logo/logo-dark.png">
        
        <link rel="stylesheet" href="/assets/css/base.css">
        <link rel="stylesheet" href="/assets/css/nav.css">
        <link rel="stylesheet" href="/assets/css/footer.css">

        @stack('styles')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="grid">
        <header>
            @include('_partials.nav')
        </header>
            
        <main class="main">
            @yield('content')
        </main>

        <footer class="footer">
            @include('_partials.footer')
        </footer>

        <script src="/assets/js/nav.js"></script>
    </body>
</html>
