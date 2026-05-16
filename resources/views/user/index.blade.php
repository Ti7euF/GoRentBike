@extends('_layouts.app')

@section('title', 'Usuario - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section class="reservation-container">
    <header class="titulo">
        <h2>Gestión de usuarios</h2>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    @if (session('role') == 1)
        <div class="control-bar">
            <div class="group-filters search-box">
                <input type="text" id="search" name="search" class="grb-input" placeholder="Buscar por nombre, email o ID..." style="width:auto; margin-bottom:0">
                <button class="grb-btn" id="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="order">
                <span class="order-label">Ordenar por ID:</span>

                <button class="order-btn" data-sort="asc" title="Menor a mayor">
                    <i class="fa-solid fa-arrow-up-short-wide"></i>
                </button>

                <button class="order-btn" data-sort="desc" title="Mayor a menos">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                </button>
            </div>
        </div>
    @endif
    <div id="group-users">
        @include('user.tableUser')
    </div>

    @if (session('role') == 1)
        @include('_partials.pagination', [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ])
    @endif
</section>

<script src="/assets/js/user.js"></script>
@endsection
