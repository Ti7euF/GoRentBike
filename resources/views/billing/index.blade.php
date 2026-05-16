@extends('_layouts.app')

@section('title', 'Facturación - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section class="billing-container">
    <header class="titulo">
        <h2>Facturación</h2>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <div class="control-bar">
        <div class="group-filters">
            <select name="range" id="range" class="grb-input" required>
                <option value="">Año en curso</option>
                <option value="1">Mes actual</option>
                <option value="3">Últimos 3 meses</option>
                <option value="6">Últimos 6 meses</option>
                <option value="12">Últimos 12 meses</option>
            </select>
        </div>

        <div class="actions">
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

    <div id="group-billing">
        @include('billing.partialBilling')
    </div>
</section>

<script id="initialChartData" type="application/json">{!! json_encode($chartData) !!}</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/billing.js"></script>
<script src="/assets/js/pdf.js"></script>

@endsection
