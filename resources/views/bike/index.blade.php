@extends('_layouts.app')

@section('title', 'Gestión de bicicletas - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
<link rel="stylesheet" href="/assets/css/bikes.css">
@endpush

@section('content')

<section>
    <header class="titulo">
        <h2>Gestión de bicicletas</h2>
    </header>

    <div class="control-bar">
        <div class="group-filters">
            <input type="text" id="search" name="search" class="grb-input" placeholder="Buscar por nombre, email o ID..." style="width:auto; margin-bottom:0">
            <button class="grb-btn" id="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        
        <div class="actions">
            <a href="{{ route('bike.viewAddBike') }}" class="grb-btn grb-btn-success">
                <i class="fa-solid fa-plus"></i> Nueva bicicleta
            </a>
        </div>

        <div class="order">
            <span class="order-label">Ordenar por ID:</span>

            <button class="order-btn" data-sort="asc" title="Menor a mayor ID">
                <i class="fa-solid fa-arrow-up-short-wide"></i>
            </button>

            <button class="order-btn" data-sort="desc" title="Mayor a menor ID">
                <i class="fa-solid fa-arrow-down-wide-short"></i>
            </button>
        </div>
    </div>

    <div id="group-bikes">
        @include('bike.tableBike')
    </div>

    @include('_partials.pagination', [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ])
</section>

<script src="/assets/js/bike.js"></script>
@endsection
