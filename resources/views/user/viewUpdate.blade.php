@extends('_layouts.app')

@section('title', 'Editar usuario - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section>
    <header class="titulo">
        <h1>Editar usuario #{{ $user->getIdUser() }}</h1>
    </header>
    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <form action="{{ route('user.update.post') }}" method="POST" class="grb-form">
        @csrf
        <fieldset>
            <legend>Ficha de usuario</legend>

            <input type="hidden" name="idUser" value="{{ $user->getIdUser() }}">
            
            <label for="firstName">Nombre <i class="fa-solid fa-circle-info" title="Introduzca su nombre."></i></label>
            <input type="text" name="firstName" id="firstName" class="grb-input" value="{{ $user->getFirstName() }}" required>

            <label for="lastName">Apellidos <i class="fa-solid fa-circle-info" title="Introduzca sus apellidos."></i></label>
            <input type="text" name="lastName" id="lastName" class="grb-input" value="{{ $user->getLastName() }}" required>

            <label for="email">Email <i class="fa-solid fa-circle-info" title="Introduzca su email."></i></label>
            <input type="email" name="email" id="email" class="grb-input" value="{{ $user->getEmail() }}" required>
            
            @if ($user->getIdUser() == session('userId'))
                <label for="password">Contraseña <i class="fa-solid fa-circle-info" title="Introduzca su contraseña."></i></label>
                <input name="password" type="password" id="password" class="grb-input" placeholder="Contraseña" maxlength="30" />

                <label for="confirmPassword">Confirmar contraseña <i class="fa-solid fa-circle-info" title="Introduzca su contraseña de nuevo."></i></label>
                <input name="confirmPassword" type="password" id="confirmPassword" class="grb-input" placeholder="Confirme contraseña" maxlength="30" />
            @endif

            @if (session('role') == 1)
                <label for="idRole">Rol <i class="fa-solid fa-circle-info" title="Seleccione el rol para dar permisos."></i></label>
                <select name="idRole" id="idRole" class="grb-input">
                    <option value="1" {{ $user->getIdRole() == 1 ? 'selected' : '' }}>Administrador</option>
                    <option value="2" {{ $user->getIdRole() == 2 ? 'selected' : '' }}>Técnico</option>
                    <option value="3" {{ $user->getIdRole() == 3 ? 'selected' : '' }}>Facturación</option>
                    <option value="4" {{ $user->getIdRole() == 4 ? 'selected' : '' }}>Cliente</option>
                </select>
            @endif
        </fieldset>
        <button type="submit" class="grb-btn grb-btn-success grb-btn-large grb-btn-block">Guardar datos</button>
        <a href="{{ route('user.index') }}" class="grb-btn grb-btn-danger grb-btn-large grb-btn-block">Volver</a>
        <p id="errorFirstName" class="validation">El nombre solo puede contener letras</p>
        <p id="errorLastName" class="validation">Los apellidos solo pueden contener letras</p>
        <p id="errorEmail" class="validation">Introduce un email válido (ej: prueba@prueba.es)</p>
        <p id="errorPassword" class="validation">La contraseña debe contener al menos una mayúscula, una minúscula, un número y un caracter especial.</p>
        <p id="errorConfirmPassword" class="validation">Las contraseñas no coinciden</p>
    </form>
</section>

<script src="/assets/js/userForm.js"></script>
@endsection
