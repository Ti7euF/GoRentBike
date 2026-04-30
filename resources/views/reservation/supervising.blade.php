@extends('_layouts.app')

@section('title', 'Supervisión - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section>
    <header class="titulo">
        <h1>Ficha de revisión</h1>
    </header>
    <form action="{{ route('reservation.supervising.post') }}" method="POST" class="grb-form">
        @csrf
        <fieldset>
            <legend>Reserva {{ $idReservation }}</legend>

            <input type="hidden" name="idReservation" value="{{ $idReservation }}">
            
            <label for="km">Km actuales <i class="fa-solid fa-circle-info" title="Introduce aquí la lectura del cuenta kilometros."></i></label>
            <input type="number" name="km" id="km" class="grb-input" min="{{ number_format($kmBike, 2) }}" step="0.01" placeholder="{{ number_format($kmBike, 2) }}" required>

            <label for="incident">Incidencias <i class="fa-solid fa-circle-info" title="Indique las incidencias observadas y detalle entre paréntesis el coste de cada una de ellas."></i></label>
            <textarea name="incident" id="incident" class="grb-input" rows="4" placeholder="Escribe aquí cualquier incidencia, daño o comentario..."></textarea>

            <label for="penalty">Penalización (€) <i class="fa-solid fa-circle-info" title="Introduzca el total del coste de las incidencias señaladas anteriormente. Automáticamente se sumará una penalización si la bicicleta fue devuelta fuera de plazo."></i></label>
            <input type="number" name="penalty" id="penalty" class="grb-input" step="0.01" placeholder="0.00">
        <fieldset>
        <button type="submit" class="grb-btn grb-btn-success grb-btn-large grb-btn-block">Guardar revisión</button>
        <a href="{{ route('reservation.index') }}" class="grb-btn grb-btn-danger grb-btn-large grb-btn-block">Volver</a>
    </form>
</section>
<script src=""></script>
@endsection
