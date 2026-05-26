    <section class="grb-cards">
        @if (empty($maintenances))
            <p class="no-results">No hay mantenimientos con los filtros seleccionados.</p>
        @else
        @foreach ($maintenances as $mnt)
        <article class="grb-card">
            <div class="grb-card-info">
                <h3 class="grb-card-title">Mantenimiento #{{ $mnt->getIdMaintenance() }}</h3>
                <ul class="grb-card-details">
                    <li><strong>Bicicleta:</strong> {{ $mnt->getBikeName() }}</li>
                    <li><strong>Inicio:</strong> {{ date('d/m/Y H:i', strtotime($mnt->getStartDate())) }}</li>
                    <li><strong>Fin:</strong> {{ date('d/m/Y H:i', strtotime($mnt->getEndDate())) }}</li>
                    <li><strong>Técnico:</strong> {{ $mnt->getUserName() }}</li>
                    <li><strong>Coste:</strong>                         
                        @if($mnt->getCost() !== null)
                            {{ number_format($mnt->getCost(), 2) }} €
                        @endif
                    </li>
                    <li><strong>Descripción:</strong> {{ $mnt->getDescription() }}</li>
                </ul>
                <div class="actions">
                    @if ($mnt->getEndDate() === null && (session('role') == 1 || session('userId') == $mnt->getIdUser()))
                        <a href="{{ route('maintenance.viewUpdateMaintenance', ['idMaintenance' => $mnt->getIdMaintenance()]) }}" class="grb-btn">Finalizar mantenimiento</a>
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
                <th>ID</th>
                <th>Bicicleta</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Técnico</th>
                <th>Descripción</th>
                <th>Coste</th>
            </tr>
        </thead>

        <tbody>
            @if (empty($maintenances))
                <tr>
                    <td colspan="7">
                        No hay mantenimientos con los filtros seleccionados.
                    </td>
                </tr>
            @else
                @foreach ($maintenances as $mnt)
                <tr>
                    <td>{{ $mnt->getIdMaintenance() }}</td>
                    <td>{{ $mnt->getBikeName() }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($mnt->getStartDate())) }} </td>
                    <td>{{ $mnt->getEndDate() ? date('d/m/Y H:i', strtotime($mnt->getEndDate())) : '-' }}</td>
                    <td>{{ $mnt->getUserName() }}</td>
                    <td>{{ $mnt->getDescription() }}</td>
                    <td>
                        @if($mnt->getCost() !== null)
                            {{ number_format($mnt->getCost(), 2) }} €
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            @if ($mnt->getEndDate() === null && (session('role') == 1 || session('userId') == $mnt->getIdUser()))
                                <a href="{{ route('maintenance.viewUpdateMaintenance', ['idMaintenance' => $mnt->getIdMaintenance()]) }}" class="grb-btn">Finalizar mantenimiento</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>