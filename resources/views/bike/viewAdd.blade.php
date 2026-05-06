@extends('_layouts.app')

@section('title', 'Agregar bicicleta - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section>
    <header class="titulo">
        <h1>Agregar bicicleta</h1>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <form action="{{ route('bike.add.post') }}" method="POST" class="grb-form">
        @csrf
        <fieldset>
            <legend>Ficha de bicicleta</legend>

            <label for="brand">Marca <i class="fa-solid fa-circle-info" title="Introduce la marca de la bicicleta."></i></label>
            <input type="text" name="brand" id="brand" class="grb-input" required>

            <label for="model">Modelo <i class="fa-solid fa-circle-info" title="Introduce el modelo de la bicicleta."></i></label>
            <input type="text" name="model" id="model" class="grb-input" required>

            <label for="type">Tipo <i class="fa-solid fa-circle-info" title="Selecciona el tipo de bicicleta."></i></label>
            <select name="type" id="type" class="grb-input">
                <option value="Montaña">Montaña</option>
                <option value="Carretera">Carretera</option>
            </select>

            <label for="amortizationPrice">Amortización <i class="fa-solid fa-circle-info" title="Introduce el precio de amortización."></i></label>
            <input type="number" name="amortizationPrice" id="amortizationPrice" class="grb-input" step="0.01" required>

            <label for="dailyPrice">Precio diario <i class="fa-solid fa-circle-info" title="Introduce el precio de alquiler por día."></i></label>
            <input type="number" name="dailyPrice" id="dailyPrice" class="grb-input" step="0.01" required>

            <label for="totalKm">Km recorridos <i class="fa-solid fa-circle-info" title="Introduce los km recorridos."></i></label>
            <input type="number" name="totalKm" id="totalKm" class="grb-input" step="0.01" value="0" required>

            <label for="active">Activa <i class="fa-solid fa-circle-info" title="Indica si la bicicleta está disponible para alquilar."></i></label>
            <input type="checkbox" name="active" id="active" value="1" checked>

            <label for="frame">Cuadro <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo del cuadro."></i></label>
            <input type="text" name="frame" id="frame" class="grb-input" required>

            <label for="gear">Transmisión <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de la transmisión."></i></label>
            <input type="text" name="gear" id="gear" class="grb-input" required>

            <label for="brakes">Frenos <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de los frenos."></i></label>
            <input type="text" name="brakes" id="brakes" class="grb-input" required>

            <label for="suspension">Suspensión <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de la suspensión."></i></label>
            <input type="text" name="suspension" id="suspension" class="grb-input" required>

            <label for="tires">Ruedas <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de las ruedas."></i></label>
            <input type="text" name="tires" id="tires" class="grb-input" required>

            <label for="seatpost">Sillín <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo del sillín."></i></label>
            <input type="text" name="seatpost" id="seatpost" class="grb-input" required>
        </fieldset>

        <button type="submit" class="grb-btn grb-btn-success grb-btn-large grb-btn-block">Agregar</button>
        <a href="{{ route('bike.index') }}" class="grb-btn grb-btn-danger grb-btn-large grb-btn-block">Volver</a>
        
        <p id="errorBrand" class="validation">Máximo 50 caracteres (marca).</p>
        <p id="errorModel" class="validation">Máximo 50 caracteres (modelo).</p>
        <p id="errorDailyPrice" class="validation">Introduce un precio diario válido.</p>
        <p id="errorFrame" class="validation">Máximo 50 caracteres (cuadro).</p>
        <p id="errorGear" class="validation">Máximo 50 caracteres (transmisión).</p>
        <p id="errorBrakes" class="validation">Máximo 50 caracteres (frenos).</p>
        <p id="errorSuspension" class="validation">Máximo 50 caracteres (suspension).</p>
        <p id="errorTires" class="validation">Máximo 50 caracteres (ruedas).</p>
        <p id="errorSeatpost" class="validation">Máximo 50 caracteres (sillín).</p>

    </form>
</section>

<script src="/assets/js/bikeForm.js"></script>
@endsection
