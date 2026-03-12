@extends('_layouts.auth')
@section('title', 'Login - Go Rent Bike')

@section('content')
    <section class="card-login">
        <header class="card-login-header">
            	<img src="assets/img/logo/logo-dark.png" alt="Go Rent Bike" class="grb-logo logo-dark">
		        <img src="assets/img/logo/logo-light.png"  alt="Go Rent Bike" class="grb-logo logo-light">
            <h2>Iniciar sesión</h2>
        </header>

        <section class="card-login-body">
            <form action="/login" method="post">
                <input name="email" class="grb-input p-2" placeholder="Email" required />
                <input name="password" type="password" class="grb-input p-2" placeholder="Contraseña" required />
                <button type="submit" class="grb-btn grb-btn-primary grb-btn-block grb-btn-large">Acceder</button>
            </form>
        </section>
        <footer class="card-login-footer">
            <p>¿No tienes cuenta? <a href="#">Regístrate.</a></p>
        </footer>
    </section>
    <p class="login-footer"><script>document.write(new Date().getFullYear())</script> © Go Rent Bike</p>
@endsection