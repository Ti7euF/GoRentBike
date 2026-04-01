@foreach ($bikes as $bike)
    <article class="card">
        <div class="slideshow">
            @foreach ($bike->getImages() as $index => $img)
                <img src="/assets/img/{{ $img['path'] }}"
                     alt="{{ $img['description'] }}"
                     class="{{ $index === 0 ? 'show' : 'hide' }}">
            @endforeach
        </div>
        <h3 class="name" title="{{ $bike->getBrand() . ' ' . $bike->getModel() }}">
            {{ $bike->getBrand() . ' ' . $bike->getModel() }}
        </h3>

        <div class="especs">
            @if ($bike->getSuspension())
                <span title="{{ $bike->getSuspension() }}">
                    {{ $bike->getSuspension() }}
                </span>
            @endif
            @if ($bike->getTires())
                <span title="{{ $bike->getTires() }}">
                    {{ $bike->getTires() }}
                </span>
            @endif
            @if ($bike->getGear())
                <span title="{{ $bike->getGear() }}">
                    {{ $bike->getGear() }}
                </span>
            @endif
            @if ($bike->getSeatpost())
                <span title="{{ $bike->getSeatpost() }}">
                    {{ $bike->getSeatpost() }}
                </span>
            @endif

        </div>

        <div class="price">
            <span>{{ number_format($bike->getDailyPrice(), 2) }} € / día</span>
        </div>

        <div class="add-cart">
            <a href="#" onclick="addToCart({{ $bike->getIdBike() }})">
                <i class="fa-solid fa-cart-arrow-down"></i>
            </a>
        </div>
    </article>
@endforeach
