@extends('_layouts.auth')
@section('title', 'Registro - Go Rent Bike')

@section('content')
    <section class="card-login">
        <header class="card-login-header">
            <a href="{{ route('home') }}"><img src="uploads/logo/logo-dark.webp" alt="Go Rent Bike" class="grb-logo logo-dark"></a>
		    <a href="{{ route('home') }}"><img src="uploads/logo/logo-light.webp"  alt="Go Rent Bike" class="grb-logo logo-light"></a>
            <h2>Registrar una cuenta</h2>
        </header>

        <section class="card-login-body">
            @if(session('error'))
                <p class="error">{{ session('error') }}</p>
            @endif
            <form action="{{ route('register.post') }}" method="post">
                @csrf
                <input name="firstName" type="text" class="grb-input" placeholder="Nombre" maxlength="50" required />
                <input name="lastName" type="text" class="grb-input" placeholder="Apellidos" maxlength="50" required />
                <input name="email" type="text" class="grb-input" placeholder="Email" maxlength="100" required />
                <input name="password" type="password" class="grb-input" placeholder="Contraseña" maxlength="30" required />
                <input name="confirmPassword" type="password" class="grb-input" placeholder="Confirme contraseña" maxlength="30" required />
                <button type="submit" class="grb-btn grb-btn-primary grb-btn-block grb-btn-large">Registro</button>
                <p id="errorFirstName" class="validation">El nombre solo puede contener letras</p>
                <p id="errorLastName" class="validation">Los apellidos solo pueden contener letras</p>
                <p id="errorEmail" class="validation">Introduce un email válido (ej: prueba@prueba.es)</p>
                <p id="errorPassword" class="validation">La contraseña debe contener al menos una mayúscula, una minúscula, un número y un caracter especial.</p>
                <p id="errorConfirmPassword" class="validation">Las contraseñas no coinciden</p>
            </form>
        </section>
        <footer class="card-login-footer">
            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión.</a></p>
        </footer>
    </section>
    <p class="login-footer"><script>document.write(new Date().getFullYear())</script> © Go Rent Bike</p>

    <script src="/assets/js/auth.js"></script>
@endsection