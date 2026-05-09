@extends('_layouts.app')

@section('title', 'Editar bicicleta - Go Rent Bike')

@push('styles')
<link rel="stylesheet" href="/assets/css/components.css">
@endpush

@section('content')
<section>
    <header class="titulo">
        <h1>Editar bicicleta #{{ $bike->getIdBike() }}</h1>
    </header>
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @elseif(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
    <form action="{{ route('bike.update.post') }}" method="POST" class="grb-form">
        @csrf
        <fieldset>
            <legend>Ficha de bicicleta</legend>

            <input type="hidden" name="idBike" value="{{ $bike->getIdBike() }}">

            <label for="brand">Marca <i class="fa-solid fa-circle-info" title="Introduce la marca de la bicicleta."></i></label>
            <input type="text" name="brand" id="brand" class="grb-input" value="{{ $bike->getBrand() }}" required>

            <label for="model">Modelo <i class="fa-solid fa-circle-info" title="Introduce el modelo de la bicicleta."></i></label>
            <input type="text" name="model" id="model" class="grb-input" value="{{ $bike->getModel() }}" required>

            <label for="type">Tipo <i class="fa-solid fa-circle-info" title="Selecciona el tipo de bicicleta."></i></label>
            <select name="type" id="type" class="grb-input">
                <option value="Montaña" {{ $bike->getType() == 'Montaña' ? 'selected' : '' }}>Montaña</option>
                <option value="Carretera" {{ $bike->getType() == 'Carretera' ? 'selected' : '' }}>Carretera</option>
            </select>

            <label for="dailyPrice">Precio diario <i class="fa-solid fa-circle-info" title="Introduce el precio de alquiler por día."></i></label>
            <input type="number" name="dailyPrice" id="dailyPrice" class="grb-input" step="0.01" value="{{ $bike->getDailyPrice() }}" required>

            <label for="active">Activa <i class="fa-solid fa-circle-info" title="Indica si la bicicleta está disponible para alquilar."></i></label>
            <input type="checkbox" name="active" id="active" value="1" {{ $bike->isActive() ? 'checked' : '' }}>

            <label for="frame">Cuadro <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo del cuadro."></i></label>
            <input type="text" name="frame" id="frame" class="grb-input" value="{{ $bike->getFrame() }}" required>

            <label for="gear">Transmisión <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de la transmisión."></i></label>
            <input type="text" name="gear" id="gear" class="grb-input" value="{{ $bike->getGear() }}" required>

            <label for="brakes">Frenos <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de los frenos."></i></label>
            <input type="text" name="brakes" id="brakes" class="grb-input" value="{{ $bike->getBrakes() }}" required>

            <label for="suspension">Suspensión <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de la suspensión."></i></label>
            <input type="text" name="suspension" id="suspension" class="grb-input" value="{{ $bike->getSuspension() }}" required>

            <label for="tires">Ruedas <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo de las ruedas."></i></label>
            <input type="text" name="tires" id="tires" class="grb-input" value="{{ $bike->getTires() }}" required>

            <label for="seatpost">Sillín <i class="fa-solid fa-circle-info" title="Introduce el tipo o modelo del sillín."></i></label>
            <input type="text" name="seatpost" id="seatpost" class="grb-input" value="{{ $bike->getSeatpost() }}" required>
        </fieldset>

        <button type="submit" class="grb-btn grb-btn-success grb-btn-large grb-btn-block">Guardar datos</button>
        <a href="{{ route('bike.index') }}" class="grb-btn grb-btn-danger grb-btn-large grb-btn-block">Volver</a>
        
        <p id="errorBrand" class="validation">Máximo 50 caracteres (marca).</p>
        <p id="errorModel" class="validation">Máximo 50 caracteres (modelo).</p>
        <p id="errorDailyPrice" class="validation">Introduce un precio diario válido.</p>
        <p id="errorFrame" class="validation">Máximo 50 caracteres (cuadro).</p>
        <p id="errorGear" class="validation">Máximo 50 caracteres (transmisión).</p>
        <p id="errorBrakes" class="validation">Máximo 50 caracteres (frenos).</p>
        <p id="errorSuspension" class="validation">Máximo 50 caracteres (suspension).</p>
        <p id="errorTires" class="validation">Máximo 50 caracteres (ruedas).</p>
        <p id="errorSeatpost" class="validation">Máximo 50 caracteres (sillín).</p>

    </form>

    <div class="grb-list-images">
        @if (!empty($bike->getImages()))
            <h3>Imágenes asociadas a la bicicleta</h3>
            <ul>
                @foreach ($bike->getImages() as $img)
                    <li>
                        <span>{{ $img['path'] }}</span>
                        <form action="{{ route('bike.deleteImage.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idBike" value="{{ $bike->getIdBike() }}">
                            <input type="hidden" name="path" value="{{ $img['path'] }}">
                            <button type="submit" class="grb-btn grb-btn-danger" title="Eliminar imagen"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
            <div>
                <form action="{{ route('bike.addImage.post') }}" method="POST" enctype="multipart/form-data" id="formAddImage">
                    @csrf
                    <input type="hidden" name="idBike" value="{{ $bike->getIdBike() }}">
                    <input type="hidden" name="nameBike" value="{{ $bike->getBrand() . '' . $bike->getModel() }}">
                    <input type="file" name="images[]" id="inputAddImage" accept="image/*" multiple style="display:none">
                    <button type="button" class="grb-btn grb-btn-primary" id="btnAddImage" title="Selecccione una o varias imágenes para asociarlas a la bicicleta"><i class="fa-solid fa-image"></i> Añadir imagen</button>
                </form>
            </div>
        </div>
</section>

<script src="/assets/js/bikeForm.js"></script>
@endsection
