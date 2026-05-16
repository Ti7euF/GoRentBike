    <section class="grb-cards">
        @if (empty($reservation))
            <p class="no-results">No hay reservas con los filtros seleccionados.</p>
        @else
        @foreach ($reservation as $res)
        <article class="grb-card">
            <div class="grb-card-info">
                <h3 class="grb-card-title">Reserva #{{ $res->getIdReservation() }}</h3>
                <p class="grb-card-type">Bicicleta ID: {{ $res->getIdBike() }}</p>

                <ul class="grb-card-details">
                    <li><strong>Cliente:</strong> {{ $res->getFirstName() }} {{ $res->getLastName() }}</li>
                    <li><strong>Inicio:</strong> {{ date('d/m/Y', strtotime($res->getStartDate())) }}</li>
                    <li><strong>Fin:</strong> {{ date('d/m/Y', strtotime($res->getEndDate())) }}</li>
                    <li><strong>Precio:</strong> {{ number_format($res->getPrice(), 2) }} €</li>
                    <li><span class="status-badge {{ $res->getStatusClass() }}">{{ $res->getReservationStatus() }}</span></li>
                </ul>
                <div class="actions">
                    {{-- Cancelar (admin/facturación) --}}
                    @if ((session('role') == 1 || session('role') == 3) && $res->getIdReservationStatus() == 1)
                        <form method="POST" action="{{ route('reservation.cancel') }}" onsubmit="return confirm('¿Seguro que quieres cancelar esta reserva?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $res->getIdReservation() }}">
                            <input type="hidden" name="startDate" value="{{ $res->getStartDate() }}">
                            <button type="submit" class="grb-btn grb-btn-danger">Cancelar</button>
                        </form>
                    @endif

                    {{-- Entregar (admin/facturación) --}}
                    @if ((session('role') == 1 || session('role') == 3) && $res->getIdReservationStatus() == 1)
                        <form method="POST" action="{{ route('reservation.confirm') }}" onsubmit="return confirm('¿Confirmar esta reserva y entregar bicicleta?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $res->getIdReservation() }}">
                            <input type="hidden" name="startDate" value="{{ $res->getStartDate() }}">
                            <button type="submit" class="grb-btn grb-btn-success">Entregar</button>
                        </form>
                    @endif

                    {{-- Recepcionar (admin/facturación) --}}
                    @if ((session('role') == 1 || session('role') == 3) && $res->getIdReservationStatus() == 4)
                        <form method="POST" action="{{ route('reservation.receive') }}" onsubmit="return confirm('¿Recepcionar bicicleta?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $res->getIdReservation() }}">
                            <button type="submit" class="grb-btn">Recepcionar</button>
                        </form>
                    @endif

                    {{-- Formulario técnico (estado == 5) --}}
                    @if ((session('role') == 1 || session('role') == 2) && $res->getIdReservationStatus() == 5)
                        <a href="{{ route('reservation.supervising', ['id' => $res->getIdReservation()]) }}" class="grb-btn">Revisar bicicleta</a>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
        @endif
    </section>

    <table class="grb-table">
        <thead>
            <tr>
                <th>Reserva</th>
                <th>Bicicleta</th>
                <th>Cliente</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @if (empty($reservation))
                <tr>
                    <td colspan="8">
                        No hay reservas con los filtros seleccionados.
                    </td>
                </tr>
            @else
                @foreach ($reservation as $res)
                <tr>
                    <td>{{ $res->getIdReservation() }}</td>
                    <td>{{ $res->getIdBike() }}</td>
                    <td>{{ $res->getFirstName() }} {{ $res->getLastName() }}</td>
                    <td>{{ date('d/m/Y', strtotime($res->getStartDate())) }}</td>
                    <td>{{ date('d/m/Y', strtotime($res->getEndDate())) }}</td>
                    <td>{{ number_format($res->getPrice(), 2) }} €</td>
                    <td><span class="status-badge {{ $res->getStatusClass() }}">{{ $res->getReservationStatus() }}</span></td>
                    <td>
                        <div class="actions">
                            {{-- Cancelar (admin/facturación) --}}
                            @if ((session('role') == 1 || session('role') == 3) && $res->getIdReservationStatus() == 1)
                                <form method="POST" action="{{ route('reservation.cancel') }}" onsubmit="return confirm('¿Seguro que quieres cancelar esta reserva?')">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $res->getIdReservation() }}">
                                    <input type="hidden" name="startDate" value="{{ $res->getStartDate() }}">
                                    <button type="submit" class="grb-btn grb-btn-danger">Cancelar</button>
                                </form>
                            @endif

                            {{-- Entregar (admin/facturación) --}}
                            @if ((session('role') == 1 || session('role') == 3) && $res->getIdReservationStatus() == 1)
                                <form method="POST" action="{{ route('reservation.confirm') }}" onsubmit="return confirm('¿Confirmar esta reserva y entregar bicicleta?')">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $res->getIdReservation() }}">
                                    <input type="hidden" name="startDate" value="{{ $res->getStartDate() }}">
                                    <button type="submit" class="grb-btn grb-btn-success">Entregar</button>
                                </form>
                            @endif

                            {{-- Recepcionar (admin/facturación) --}}
                            @if ((session('role') == 1 || session('role') == 3) && $res->getIdReservationStatus() == 4)
                                <form method="POST" action="{{ route('reservation.receive') }}" onsubmit="return confirm('¿Recepcionar bicicleta?')">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $res->getIdReservation() }}">
                                    <button type="submit" class="grb-btn">Recepcionar</button>
                                </form>
                            @endif

                            {{-- Formulario técnico (estado == 5) --}}
                            @if ((session('role') == 1 || session('role') == 2) && $res->getIdReservationStatus() == 5)
                                <a href="{{ route('reservation.supervising', ['id' => $res->getIdReservation()]) }}" class="grb-btn">Revisar bicicleta</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>