<nav class="nav" aria-label="Navegación principal">
	<header class="mobile-header">
		<button class="menu-toggle" aria-label="Abrir menú">
			<i class="fa-solid fa-bars"></i>
		</button>
		<div class="logo">
			<a href="{{ route('home') }}"><img src="/uploads/logo/logo-dark.webp" class="logo-dark"></a>
			<a href="{{ route('home') }}"><img src="/uploads/logo/logo-light.webp" class="logo-light"></a>
		</div>
	</header>
	<nav class="mobile-menu" aria-label="Menú móvil">
        <div class="mobile-user">
            @if(session()->has('userId'))
                <div class="user-info">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <p class="user-name">Hola, {{ session('name') }}</p>
                    </div>
                </div>
                <a href="#" name="logout"><i class="fa-solid fa-sign-out"></i></a>
            @else
                <div class="user-info">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <p class="user-name">Iniciar sesión</p>
                    </div>
                </div>
                <a href="{{ route('login') }}"><i class="fa-solid fa-sign-in"></i></a>
            @endif
        </div>

        <ul class="mobile-links">
            <li><a href="{{ route('home') }}"><i class="fa-solid fa-bicycle"></i> Bicicletas</a></li>
            <li><a href="{{ route('reservation.index') }}"><i class="fa-solid fa-calendar-check"></i> Reservas</a></li>
            @if (session()->has('userId') && (session('role') == 1 || session('role') == 3))
                <li><a href="{{ route('billing.index') }}"><i class="fa-solid fa-file-invoice"></i> Facturación</a></li>
            @endif
            @if (session()->has('userId') && (session('role') == 1 || session('role') == 2))
                <li><a href="{{ route('maintenance.index') }}"><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento</a></li>
            @endif
            @if (session()->has('userId') && session('role') == 1)
                <li><a href="{{ route('user.index') }}"><i class="fa-solid fa-users"></i> Usuarios</a></li>
                <li><a href="{{ route('bike.index') }}"><i class="fa-solid fa-bicycle"></i> Flota</a></li>
            @else
                <li><a href="{{ route('user.index') }}"><i class="fa-solid fa-circle-user"></i> Perfil</a></li>
            @endif
            <li><a href="#" onclick="toggleTheme()"><i class="fa-solid fa-circle-half-stroke"></i> Tema</a></li>
        </ul>
	</nav>
    <ul>
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-bicycle"></i> Bicicletas</a></li>
        <li><a href="{{ route('reservation.index') }}"><i class="fa-solid fa-calendar-check"></i> Mis reservas</a></li>
        @if (session()->has('userId') && (session('role') == 1 || session('role') == 3))
            <li><a href="{{ route('billing.index') }}"><i class="fa-solid fa-file-invoice"></i> Facturación</a></li>
        @endif
        @if (session()->has('userId') && (session('role') == 1 || session('role') == 2))
            <li><a href="{{ route('maintenance.index') }}"><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento</a></li>
        @endif
        <li><a href="#" onclick="toggleTheme()"><i class="fa-solid fa-circle-half-stroke"></i> Tema</a></li>

        @if(session()->has('userId'))
            <li class="user-menu">
                <i class="fa-solid fa-user"></i> {{ session('name') }}
                <ul class="dropdown">
                    @if (session()->has('userId') && session('role') == 1)
                        <li><a href="{{ route('user.index') }}"> Usuarios</a></li>
                        <li><a href="{{ route('bike.index') }}"> Flota</a></li>
                    @else
                        <li><a href="{{ route('user.index') }}"> Perfil</a></li>
                    @endif
                    <li><a href="#" name="logout"> Cerrar sesión</a></li>
                </ul>
            </li>
        @else
            <li><a href="{{ route('login') }}"><i class="fa-solid fa-user"></i> Iniciar sesión</a></li>
        @endif
    </ul>
    <form id="form-logout" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
</nav>

