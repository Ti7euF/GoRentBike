@extends('_layouts.app')

@section('title', 'Privacidad - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/legal.css">
@endpush

@section('content')
<section class="legal-page">
    <header class="titulo">
        <h2>Privacidad</h2>
    </header>  

    <article>
        <section>
            <p>En Go Rent Bike nos comprometemos a proteger la privacidad de nuestros usuarios.</p>
        </section>

        <section>
            <h2>Responsable del tratamiento</h2>
            <address>
                Go Rent Bike<br>
                Email: <a href="mailto:info@gorentbike.com">info@gorentbike.com</a>
            </address>
        </section>

        <section>
            <h2>Datos que recopilamos</h2>
            <ul>
                <li>Nombre</li>
                <li>Email</li>
                <li>Teléfono</li>
                <li>Información enviada mediante formularios</li>
            </ul>
        </section>

        <section>
            <h2>Finalidad del tratamiento</h2>
            <ul>
                <li>Responder consultas</li>
                <li>Gestionar reservas</li>
                <li>Mejorar nuestros servicios</li>
            </ul>
        </section>

        <section>
            <h2>Base legal</h2>
            <p>El tratamiento se basa en el consentimiento del usuario.</p>
        </section>

        <section>
            <h2>Conservación de datos</h2>
            <p>Los datos se conservarán el tiempo necesario para cumplir con su finalidad.</p>
        </section>

        <section>
            <h2>Derechos del usuario</h2>
            <ul>
                <li>Acceder a tus datos</li>
                <li>Rectificarlos</li>
                <li>Eliminarlos</li>
                <li>Limitar su uso</li>
            </ul>
            <p>Puedes ejercer estos derechos enviando un email a 
                <a href="mailto:info@gorentbike.com">info@gorentbike.com</a>
            </p>
        </section>

        <section>
            <h2>Seguridad</h2>
            <p>Aplicamos medidas de seguridad para proteger tus datos.</p>
        </section>
    </article>
</section>
@endsection