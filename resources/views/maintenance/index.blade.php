@extends('_layouts.app')

@section('title', 'Mantenimientos - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section class="maintenance-container">
    <header class="titulo">
        <h2>Mantenimientos</h2>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <div class="control-bar">
        <div class="group-filters">
            <input type="text" id="search" name="search" class="grb-input" placeholder="Buscar por técnico o bicicleta." style="width:auto; margin-bottom:0">
            <button class="grb-btn" id="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        
        <div class="actions">
            <a href="{{ route('maintenance.viewAddMaintenance') }}" class="grb-btn grb-btn-success">
                <i class="fa-solid fa-plus"></i> Iniciar mantenimento
            </a>
            <form action="{{ route('export.pdf') }}" method="POST" data-export-pdf="true">
            @csrf
                <input type="hidden" name="html">
                <input type="hidden" name="title">
                <button type="submit" class="grb-btn">Exportar <i class="fa-regular fa-file-pdf"></i></button>
            </form>
        </div>

        <div class="order">
            <span class="order-label">Ordenar por fecha:</span>

            <button class="order-btn" data-sort="asc" title="Más antiguos primero">
                <i class="fa-solid fa-arrow-up-short-wide"></i>
            </button>

            <button class="order-btn" data-sort="desc" title="Más recientes primero">
                <i class="fa-solid fa-arrow-down-wide-short"></i>
            </button>
        </div>
    </div>

    <div id="group-maintenances">
        @include('maintenance.tableMaintenance')
    </div>

    @include('_partials.pagination', [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ])
</section>

<script src="/assets/js/maintenance.js"></script>
<script src="/assets/js/pdf.js"></script>
@endsection
