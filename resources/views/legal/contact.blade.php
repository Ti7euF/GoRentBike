@extends('_layouts.app')

@section('title', 'Contacto - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/legal.css">
@endpush

@section('content')
<section class="legal-page">
    <header class="titulo">
        <h2>Contacto</h2>
    </header>

    <article>
        <section>
            <p>¿Tienes alguna duda o necesitas más información?</p>
            <p>Puedes ponerte en contacto con nosotros a través de los siguientes medios:</p>
        </section>

        <section>
            <h2>Contacto directo</h2>
            <address>
                <p><i class="fas fa-envelope"></i> Email: <a href="mailto:info@gorentbike.com">info@gorentbike.com</a></p>
                <p><i class="fas fa-phone"></i> Teléfono: <a href="tel:+34600000000">+34 600 000 000</a></p>
            </address>
        </section>

        <section>
            <h2>Horario de atención</h2>
            <p>Lunes a Domingo: 09:00 - 20:00</p>
        </section>

        <section>
            <h2>Tiempo de respuesta</h2>
            <p>Intentamos responder a todos los correos en un plazo máximo de 24 horas.</p>
        </section>
    </article>
</section>
@endsection