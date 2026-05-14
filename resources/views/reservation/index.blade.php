@extends('_layouts.app')

@section('title', 'Reservas - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section class="reservation-container">
    <header class="titulo">
        <h2>Reservas</h2>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <div class="control-bar">
        <div class="group-filters">
            <select id="reservationStatus" class="grb-input">
                <option value="all">Todas</option>
                <option value="pending">Pendientes</option>
                <option value="cancelled">Canceladas</option>
                <option value="finished">Finalizadas</option>
            </select>
        </div>

        <div class="actions">
            <form action="{{ route('export.pdf') }}" method="POST" data-export-pdf="true">
            @csrf
                <input type="hidden" name="html">
                <input type="hidden" name="title">
                <button type="submit" class="order-btn">Exportar <i class="fa-regular fa-file-pdf"></i></button>
            </form>
        </div>

        <div class="order">
            <span class="order-label">Ordenar por fecha de inicio:</span>

            <button class="order-btn" data-sort="asc" title="Más antiguo primero">
                <i class="fa-solid fa-arrow-up-short-wide"></i>
            </button>

            <button class="order-btn" data-sort="desc" title="Más reciente primero">
                <i class="fa-solid fa-arrow-down-wide-short"></i>
            </button>
        </div>
    </div>

    <div id="group-reservations">
        @include('reservation.tableReservation')
    </div>

    @include('_partials.pagination', [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ])
</section>

<script src="/assets/js/reservation.js"></script>
<script src="/assets/js/pdf.js"></script>
@endsection
