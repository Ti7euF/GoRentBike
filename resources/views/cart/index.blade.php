@extends('_layouts.app')

@section('title', 'Carrito - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
<link rel="stylesheet" href="/assets/css/cart.css">
@endpush

@section('content')
<section class="cart-container" aria-labelledby="cart-title">
    <header class="cart-header">
        <h1 id="cart-title" class="cart-title">
            <i class="fa-solid fa-cart-shopping"></i> Tu carrito
        </h1>
    </header>

    @if (empty($bikes))
        <section class="cart-empty" aria-live="polite">
            <i class="fa-solid fa-bicycle"></i>
            <p>El carrito está vacío.</p>
        </section>
    @else
        <section class="grb-cards">
            @foreach ($bikes as $bike)
                <article class="grb-card">
                    <img class="grb-card-img" src="/uploads/bikes/{{ $bike->getPath() }}" alt="Imagen de {{ $bike->getBrand() }} {{ $bike->getModel() }}">
                    <div class="grb-card-info">
                        <h3 class="grb-card-title">{{ $bike->getBrand() }} {{ $bike->getModel() }}</h3>
                        <p class="grb-card-type">{{ $bike->getType() }}</p>

                        <ul class="grb-card-details">
                            <li><strong>Desde:</strong> {{ date('d/m/Y H:i', strtotime($bike->getStartDate())) }}</li>
                            <li><strong>Hasta:</strong> {{ date('d/m/Y 23:59', strtotime($bike->getEndDate())) }}</li>
                            <li><strong>Días:</strong> {{ $bike->getRentalDays() }}</li>
                            <li><strong>Precio/día:</strong> {{ number_format($bike->getDailyPrice(), 2) }} €</li>
                            <li><strong>Descuento:</strong> {{ $bike->getDiscount() }}%</li>
                            <li><strong>Total:</strong> {{ number_format($bike->getTotalPrice(), 2) }} €</li>
                        </ul>

                        <form method="POST" onsubmit="removeFromCart({{ $bike->getIdBike() }})">
                            <button type="submit" class="grb-btn grb-btn-danger">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>
        <section class="cart-table-wrapper">
            <table class="grb-table" aria-label="Artículos del carrito">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Bicicleta</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Días</th>
                        <th>Precio/día</th>
                        <th>Descuento</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($bikes as $bike)
                        <tr class="grb-table-row">
                            <td class="cart-img-cell">
                                <img class="grb-table-img" src="/uploads/bikes/{{ $bike->getPath() }}" alt="Imagen de {{ $bike->getBrand() }} {{ $bike->getModel() }}">
                            </td>
                            <td>
                                <h3 class="bike-name">
                                    {{ $bike->getBrand() }} {{ $bike->getModel() }}
                                </h3>
                                <p class="bike-type">{{ $bike->getType() }}</p>
                            </td>
                            <td class="cart-date">{{ date('d/m/Y H:i', strtotime($bike->getStartDate())) }}</td>
                            <td class="cart-date">{{ date('d/m/Y 23:59', strtotime($bike->getEndDate())) }}</td>
                            <td class="cart-date">{{ $bike->getRentalDays() }}</td>
                            <td class="cart-date">{{ number_format($bike->getDailyPrice(), 2) }} €</td>                            
                            <td class="cart-date">
                                <span class="discount">
                                    {{ $bike->getDiscount() }}%
                                </span>
                            </td>
                            <td class="cart-date">
                                <span class="total-price"> 
                                    {{ number_format($bike->getTotalPrice(), 2) }} €
                                </span>
                            </td>
                            <td class="cart-remove">
                                <button type="button" class="grb-btn grb-btn-danger" aria-label="Eliminar bicicleta del carrito" onclick="removeFromCart({{ $bike->getIdBike() }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="cart-wrapper">
            <div class="card-summary">
                <h3 class="grb-billing-title">Resumen del carrito</h3>

                <button id="btnBreakdown" class="btn-breakdown"><i class="fa-solid fa-chevron-down"></i>Mostrar desglose</button>

                <ul id="summaryBreakdown">
                    <li><strong>Subtotal:</strong> {{ number_format($subtotal, 2) }} €</li>
                    <li><strong>IVA (21%):</strong> {{ number_format($iva, 2) }} €</li>
                </ul>

                <ul>
                    <li><strong>Total:</strong> {{ number_format($total, 2) }} €</li>
                </ul>


                <form method="POST" action="/reservation/checkout">
                    @csrf
                    <button type="submit" class="grb-btn grb-btn-success grb-btn-block">
                        <i class="fa-solid fa-credit-card"></i> Finalizar reserva
                    </button>
                </form>
            </div>
        </section>
    @endif
</section>

<script src="/assets/js/cart.js"></script>
@endsection
