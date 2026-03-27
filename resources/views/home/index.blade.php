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
    <fieldset class="group-filters">
        <input type="radio" name="bike-type" id="all" checked>
        <label for="all" class="filter">Todas</label>

        <input type="radio" name="bike-type" id="mountain">
        <label for="mountain" class="filter">Montaña</label>

        <input type="radio" name="bike-type" id="road">
        <label for="road" class="filter">Carretera</label>
    </fieldset>

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
@endsection
