@extends('_layouts.app')

@section('title', 'Alquiler de bicicletas - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/bikes.css">
@endpush

@section('content')

<section class="titulo">
	<h2>Alquiler de bicicletas</h2>
<section>

<aside class="filtros">
    <input type="radio" name="tipo" id="montana" checked>
    <label for="montana" class="filtro">Montaña</label>

    <input type="radio" name="tipo" id="carretera">
    <label for="carretera" class="filtro">Carretera</label>
</aside>

<section class="bicicletas">
	<article class="card">
		<img src="/assets/img/ScottSpark2.png">
		<h4 class="nombre">Scott Spark 1</h4>
		<div class="especs">
			<span>Suspensión doble</span>
			<span>Cubiertas Maxxis</span>
			<span>SRAM 12 vel.</span>
			<span>Tija ajustable</span>
		</div>
		<div class="precio">
			<span>1 día: </span><span>40 €</span>
		</div>
		<div class="disponibilidad">
			<a href="#"><span>1 disponible</span></a>
		</div>
	</article>
	<article class="card">
		<img src="/assets/img/ScottSpark2.png">
		<h4 class="nombre">Scott Spark 1</h4>
		<div class="especs">
			<span>Suspensión doble</span>
			<span>Cubiertas Maxxis</span>
			<span>SRAM 12 vel.</span>
			<span>Tija ajustable</span>
		</div>
		<div class="precio">
			<span>1 día: </span><span>40 €</span>
		</div>
		<div class="disponibilidad">
			<a href="#"><span>1 disponible</span></a>
		</div>
	</article>
	<article class="card">
		<img src="/assets/img/ScottSpark2.png">
		<h4 class="nombre">Scott Spark 1</h4>
		<div class="especs">
			<span>Suspensión doble</span>
			<span>Cubiertas Maxxis</span>
			<span>SRAM 12 vel.</span>
			<span>Tija ajustable</span>
		</div>
		<div class="precio">
			<span>1 día: </span><span>40 €</span>
		</div>
		<div class="disponibilidad">
			<a href="#"><span>1 disponible</span></a>
		</div>
	</article>
	<article class="card">
		<img src="/assets/img/ScottSpark2.png">
		<h4 class="nombre">Scott Spark 1</h4>
		<div class="especs">
			<span>Suspensión doble</span>
			<span>Cubiertas Maxxis</span>
			<span>SRAM 12 vel.</span>
			<span>Tija ajustable</span>
		</div>
		<div class="precio">
			<span>1 día: </span><span>40 €</span>
		</div>
		<div class="disponibilidad">
			<a href="#"><span>1 disponible</span></a>
		</div>
	</article>
	<article class="card">
		<img src="/assets/img/ScottSpark2.png">
		<h4 class="nombre">Scott Spark 1</h4>
		<div class="especs">
			<span>Suspensión doble</span>
			<span>Cubiertas Maxxis</span>
			<span>SRAM 12 vel.</span>
			<span>Tija ajustable</span>
		</div>
		<div class="precio">
			<span>1 día: </span><span>40 €</span>
		</div>
		<div class="disponibilidad">
			<a href="#"><span>1 disponible</span></a>
		</div>
	</article>
</section>

@endsection
