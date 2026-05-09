@foreach ($bikes as $bike)
    <article class="card">
        <div class="slideshow">
            @foreach ($bike->getImages() as $index => $img)
                <img src="/uploads/bikes/{{ $img['path'] }}"
                     alt="{{ $img['description'] }}"
                     class="{{ $index === 0 ? 'show' : 'hide' }}">
            @endforeach
        </div>
        <h3 class="name" title="{{ $bike->getBrand() . ' ' . $bike->getModel() }}">
            {{ '#' . $bike->getIdBike() . ' ' . $bike->getBrand() . ' ' . $bike->getModel() }}
        </h3>

        <div class="especs">
            @if ($bike->getType())
                <span title="{{ $bike->getType() }}">
                    {{ $bike->getType() }}
                </span>
            @endif
            <span title="{{ $bike->getTotalKm() }} km">
                {{ $bike->getTotalKm() . ' km'}}
            </span>
            <span title="{{ $bike->isActive() ? 'Activo' : 'Inactivo' }}">
                {{ $bike->isActive() ? 'Activo' : 'Inactivo' }}
            </span>
            @if ($bike->getBikeStatus())
                <span title="{{ $bike->getBikeStatus() }}">
                    {{ $bike->getBikeStatus() }}
                </span>
            @endif
        </div>

        <div class="price">
            <span>{{ number_format($bike->getAmortizationPrice(), 2, ',', '.') . '€ restantes por amortizar'}} </span>
        </div>

        <div class="add-cart">
            <a href="{{ route('bike.viewUpdateBike', ['idBike' => $bike->getIdBike()]) }}"><i class="fa-solid fa-pen-to-square"></i></a>
        </div>
    </article>
@endforeach
