@extends('_layouts.app')

@section('title', 'Finalizar mantenimiento - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section>
    <header class="titulo">
        <h1>Finalizar mantenimiento de {{ $maintenance->getBikeName() }}</h1>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <form action="{{ route('maintenance.update.post') }}" method="POST" class="grb-form">
        @csrf
        <fieldset>
            <legend>Ficha de mantenimiento</legend>
            <input type="hidden" name="idMaintenance" value="{{ $maintenance->getIdMaintenance() }}">

            <label for="startDate">Fecha y hora de inicio <i class="fa-solid fa-circle-info" title="Indica cuándo comienza el mantenimiento."></i></label>
            <input type="datetime-local" name="startDate" id="startDate" class="grb-input" value="{{ $maintenance->getStartDate() }}" disabled>

            <label for="endDate">Fecha y hora de fin <i class="fa-solid fa-circle-info" title="Indica cuándo finaliza el mantenimiento."></i></label>
            <input type="datetime-local" name="endDate" id="endDate" class="grb-input" value="{{ $currentDateTime }}" required>

            <label for="description">Descripción <i class="fa-solid fa-circle-info" title="Indique el mantenimiento que ha realizado."></i></label>
            <textarea name="description" id="description" class="grb-input" rows="4" placeholder="Escribe aquí cualquier reparación o manenimiento efectuado."></textarea>

            <label for="cost">Coste (€) <i class="fa-solid fa-circle-info" title="Introduzca el total del coste del mantenimiento."></i></label>
            <input type="number" name="cost" id="cost" class="grb-input" step="0.01" placeholder="0.00">

        </fieldset>

        <button type="submit" class="grb-btn grb-btn-success grb-btn-large grb-btn-block">Finalizar</button>
        <a href="{{ route('maintenance.index') }}" class="grb-btn grb-btn-danger grb-btn-large grb-btn-block">Volver</a>
        
        <p id="errorCost" class="validation">Introduce un coste válido.</p>

    </form>
</section>
@endsection
