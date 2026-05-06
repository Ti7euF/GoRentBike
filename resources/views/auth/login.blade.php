@extends('_layouts.auth')
@section('title', 'Login - Go Rent Bike')

@section('content')
    <section class="card-login">
        <header class="card-login-header">
            <a href="{{ route('home') }}"><img src="uploads/logo/logo-dark.webp" alt="Go Rent Bike" class="grb-logo logo-dark"></a>
		    <a href="{{ route('home') }}"><img src="uploads/logo/logo-light.webp"  alt="Go Rent Bike" class="grb-logo logo-light"></a>
            <h2>Iniciar sesión</h2>
        </header>

        <section class="card-login-body">
            @if(session('error'))
                <p class="error">{{ session('error') }}</p>
            @endif
            <form action="{{ route('login.post') }}" method="post">
                @csrf
                <input name="email" type="text" class="grb-input" placeholder="Email" maxlength="100" minlength="1" required />
                <input name="password" type="password" class="grb-input" placeholder="Contraseña" maxlength="30" required />
                <button type="submit" class="grb-btn grb-btn-primary grb-btn-block grb-btn-large">Acceder</button>
                
            </form>
        </section>
        <footer class="card-login-footer">
            <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate.</a></p>
        </footer>
    </section>
    <p class="login-footer"><script>document.write(new Date().getFullYear())</script> © Go Rent Bike</p>
@endsection