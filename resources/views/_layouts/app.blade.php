<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Go Rent Bike')</title>
        
        <script>
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.add('light');
            }
        </script>

        <link rel="icon" type="image/webp" href="/assets/img/logo/logo-dark.webp">
        
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

        <button class="btn-cart">
            <i class="fa-solid fa-cart-shopping"></i>
        </button>

        <script src="/assets/js/nav.js"></script>
    </body>
</html>
