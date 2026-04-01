@extends('_layouts.app')

@section('title', 'Estado de la reserva - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
<link rel="stylesheet" href="/assets/css/reservation.css">
@endpush

@section('content')
<section class="reservation-result">
    @if(session('success'))
        <h1 class="success"><i class="fa-solid fa-circle-check"></i> Reserva completada</h1>
        <p>Tu reserva se ha procesado correctamente.</p>
    @else
        <h1 class="error"><i class="fa-solid fa-circle-xmark"></i> Ocurrió un error</h1>
        <p>No se pudo completar la reserva. Inténtalo de nuevo más tarde.</p>
    @endif

    {{-- <a href="{{ route('reservation.index') }}" class="btn">Ir a Mis Reservas</a> --}}
    <a class="grb-btn grb-btn-success">
        <i class="fa-solid fa-calendar-check"></i> Ir a Mis Reservas
    </a>
</section>
@endsection
