@extends('_layouts.app')

@section('title', 'Política de Cookies - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/legal.css">
@endpush

@section('content')
<section class="legal-page">
    <header class="titulo">
        <h2>Política de Cookies</h2>
    </header>

    <article>
        <section>
            <p>Este sitio web utiliza cookies para mejorar la experiencia del usuario.</p>
        </section>

        <section>
            <h2>¿Qué son las cookies?</h2>
            <p>Son pequeños archivos que se almacenan en tu dispositivo al visitar una web.</p>
        </section>

        <section>
            <h2>Tipos de cookies utilizadas</h2>
            <ul>
                <li><strong>Técnicas:</strong> necesarias para el funcionamiento del sitio</li>
                <li><strong>Analíticas:</strong> permiten analizar el uso del sitio web</li>
            </ul>
        </section>

        <section>
            <h2>Cookies de terceros</h2>
            <p>Este sitio puede utilizar servicios de terceros como Google Analytics.</p>
        </section>

        <section>
            <h2>Cómo desactivar las cookies</h2>
            <p>Puedes permitir, bloquear o eliminar las cookies desde la configuración de tu navegador.</p>
        </section>

        <section>
            <h2>Consentimiento</h2>
            <p>Al navegar por este sitio web aceptas el uso de cookies.</p>
        </section>
    </article>
</section>
@endsection