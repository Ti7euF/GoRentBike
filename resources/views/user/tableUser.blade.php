    <section class="grb-cards">
        @if (empty($users))
            <p class="no-results">No hay usuarios con los filtros seleccionados.</p>
        @else
        @foreach ($users as $user)
            <article class="grb-card">
                <div class="grb-card-info">
                    <h3 class="grb-card-title">Usuario #{{ $user->getIdUser() }}</h3>

                    <ul class="grb-card-details">
                        <li><strong>Nombre:</strong> {{ $user->getFirstName() }}</li>
                        <li><strong>Apellidos:</strong> {{ $user->getLastName() }}</li>
                        <li><strong>Email:</strong> {{ $user->getEmail() }}</li>
                    </ul>
                    <div class="actions">
                        @if (session('role') == 1 || session('userId') == $user->getIdUser())
                            <a href="{{ route('user.viewUpdateUser', ['idUser' => $user->getIdUser()]) }}" class="grb-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                        @endif

                        @if (session('role') == 1)
                            <form method="POST" action="{{ route('user.delete', ['idUser' => $user->getIdUser()]) }}" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                            @csrf
                                <button type="submit" class="grb-btn grb-btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
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
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @if (empty($users))
                <tr>
                    <td colspan="7">
                        No hay usuarios con los filtros seleccionados.
                    </td>
                </tr>
            @else
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->getIdUser() }}</td>
                    <td>{{ $user->getFirstName() }}</td>
                    <td>{{ $user->getLastName() }}</td>
                    <td>{{ $user->getEmail() }}</td>
                    <td>{{ $user->getRoleName() }}</td>
                    <td>
                        <span class="status-badge {{ $user->isActive() ? 'status-active' : 'status-inactive' }}">
                            {{ $user->isActive() ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            @if (session('role') == 1 || session('userId') == $user->getIdUser())
                                <a href="{{ route('user.viewUpdateUser', ['idUser' => $user->getIdUser()]) }}" class="grb-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                            @endif

                            @if (session('role') == 1)
                                <form method="POST" action="{{ route('user.delete', ['idUser' => $user->getIdUser()]) }}" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                                    @csrf
                                    <button type="submit" class="grb-btn grb-btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>