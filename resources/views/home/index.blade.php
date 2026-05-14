@extends('_layouts.app')

@section('title', 'Alquiler de bicicletas - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
<link rel="stylesheet" href="/assets/css/bikes.css">
@endpush

@section('content')

<section>
    <header class="titulo">
        <h2>Alquiler de bicicletas</h2>
    </header>

    <div class="control-bar">
        <div class="group-filters">
            <select id="bikeType" class="grb-input">
                <option value="all">Todas</option>
                <option value="mountain">Montaña</option>
                <option value="road">Carretera</option>
            </select>
        </div>

        <div class="date-filter">
            <input type="date" name="startDate" id="startDate" class="grb-input" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
            <span>→</span>
            <input type="date" name="endDate" id="endDate" class="grb-input" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
        </div>

        <div class="order">
            <span class="order-label">Ordenar por precio:</span>

            <button class="order-btn" data-sort="asc" title="Más barato primero">
                <i class="fa-solid fa-arrow-up-short-wide"></i>
            </button>

            <button class="order-btn" data-sort="desc" title="Más caro primero">
                <i class="fa-solid fa-arrow-down-wide-short"></i>
            </button>
        </div>
    </div>

    <div id="group-bikes">
        @include('home.bikes')
    </div>

    @include('_partials.pagination', [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ])
</section>

<script src="/assets/js/index.js"></script>
<script src="/assets/js/cart.js"></script>
@endsection
