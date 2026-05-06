@extends('_layouts.app')

@section('title', 'Quiénes somos - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/legal.css">
@endpush

@section('content')
<section class="legal-page">
  <header class="titulo">
    <h2>Quiénes somos</h2>
    <div class="logo">
      <img src="uploads/logo/logo-dark.webp" class="logo-dark" alt="Go Rent Bike Logo">
      <img src="uploads/logo/logo-light.webp" class="logo-light" alt="Go Rent Bike Logo">
    </div>
  </header>

  <article>

    <section>
      <p>Go Rent Bike es una empresa joven y dinámica dedicada a ofrecer soluciones fáciles y rápidas para el alquiler de bicicletas. Nuestro objetivo es que cada cliente disfrute de una experiencia cómoda y segura al moverse por la ciudad o explorar rutas al aire libre.</p>
    </section>

    <section>
      <h2>Nuestra misión</h2>
      <p>Facilitar el acceso a bicicletas de calidad, simplificando el proceso de alquiler y ofreciendo un servicio cercano y confiable a nuestros clientes.</p>
    </section>

    <section>
      <h2>Nuestros valores</h2>
      <ul>
        <li><strong>Compromiso:</strong> nos esforzamos por brindar el mejor servicio en cada interacción.</li>
        <li><strong>Transparencia:</strong> precios claros y procesos sencillos.</li>
        <li><strong>Calidad:</strong> bicicletas y accesorios en óptimas condiciones.</li>
        <li><strong>Innovación:</strong> buscamos soluciones que hagan más fácil la movilidad en bicicleta.</li>
      </ul>
    </section>

    <section>
      <h2>Nuestro equipo</h2>
      <p>Contamos con un grupo de profesionales apasionados por la movilidad sostenible y la atención al cliente, siempre dispuestos a mejorar y adaptarse a las necesidades de nuestros usuarios.</p>
    </section>

    <section>
      <h2>Contacto</h2>
      <p>Si quieres conocernos mejor o tienes alguna pregunta, no dudes en ponerte en contacto con nosotros:</p>
      <address>
        <p><i class="fas fa-envelope"></i> Email: <a href="mailto:info@gorentbike.com">info@gorentbike.com</a></p>
        <p><i class="fas fa-phone"></i> Teléfono: <a href="tel:+34600000000">+34 600 000 000</a></p>
      </address>
    </section>

  </article>
</section>
@endsection