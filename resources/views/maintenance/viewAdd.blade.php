@extends('_layouts.app')

@section('title', 'Iniciar mantenimiento - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section>
    <header class="titulo">
        <h1>Iniciar mantenimiento</h1>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <form action="{{ route('maintenance.add.post') }}" method="POST" class="grb-form">
        @csrf
        <fieldset>
            <legend>Ficha de mantenimiento</legend>

            <label for="idBike">Bicicleta <i class="fa-solid fa-circle-info" title="Selecciona la bicicleta a la que se le hará mantenimiento."></i></label>
            <select name="idBike" id="idBike" class="grb-input" required>
                <option value="">Selecciona una bicicleta</option>
                @foreach ($bikes as $bike)
                    <option value="{{ $bike->getIdBike() }}">{{ $bike->getBrand() }} {{ $bike->getModel() }}</option>
                @endforeach
            </select>

            <label for="startDate">Fecha y hora de inicio <i class="fa-solid fa-circle-info" title="Indica cuándo comienza el mantenimiento."></i></label>
            <input type="datetime-local" name="startDate" id="startDate" class="grb-input" value="{{ $currentDateTime }}" required>

        </fieldset>

        <button type="submit" class="grb-btn grb-btn-success grb-btn-large grb-btn-block">Iniciar</button>
        <a href="{{ route('maintenance.index') }}" class="grb-btn grb-btn-danger grb-btn-large grb-btn-block">Volver</a>
        
        <p id="errorDate" class="validation">La fecha no puede ser posterior a la fecha y hora actual.</p>

    </form>
</section>

@endsection
