<section class="grb-billing-cards">
    <article class="grb-billing-card grb-billing-card-incomes">
        <i class="fa-solid fa-coins grb-billing-icon"></i>
        <div>
            <h3 class="grb-billing-title">Ingresos</h3>
            <p class="grb-billing-value">{{ number_format($income['incomeTotal'] ?? 0, 2, ',', '.') }} €</p>
        </div>
    </article>

    <article class="grb-billing-card grb-billing-card-expenses">
        <i class="fa-solid fa-wallet grb-billing-icon"></i>
        <div>
            <h3 class="grb-billing-title">Gastos</h3>
            <p class="grb-billing-value">{{ number_format($expenses['maintenanceExpenses'] ?? 0, 2, ',', '.') }} €</p>
        </div>
    </article>

    <article class="grb-billing-card grb-billing-card-iva">
        <i class="fa-solid fa-file-invoice-dollar grb-billing-icon"></i>
        <div>
            <h3 class="grb-billing-title">IVA</h3>
            <p class="grb-billing-value">{{ number_format($iva ?? 0, 2, ',', '.') }} €</p>
        </div>
    </article>

    <article class="grb-billing-card grb-billing-card-benefit">
        <i class="fa-solid fa-chart-line grb-billing-icon"></i>
        <div>
            <h3 class="grb-billing-title">Beneficio</h3>
            <p class="grb-billing-value">{{ number_format($benefit ?? 0, 2, ',', '.') }} €</p>
        </div>
    </article>
</section>

<section class="billing-chart">
    <canvas id="billingChart"></canvas>
</section>

<section class="grb-cards">
    @forelse($movements as $mv)
        <article class="grb-card">
            <div class="grb-card-info">
                <h3 class="grb-card-title">{{ $mv['movementType'] }}</h3>
                <ul class="grb-card-details">
                    <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($mv['movementDate'])->format('d/m/Y') }}</li>
                    <li><strong>Concepto:</strong> {{ $mv['concept'] }}</li>
                    <li><strong>Cantidad:</strong> {{ number_format($mv['amount'], 2, ',', '.') }} €</li>
                </ul>
            </div>
        </article>
    @empty
        <p class="no-results">No hay movimientos en este rango.</p>
    @endforelse
</section>

<section>
    <table class="grb-table">
        <caption>Listado de movimientos</caption>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Concepto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $mv)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($mv['movementDate'])->format('d/m/Y') }}</td>
                    <td>{{ $mv['movementType'] }}</td>
                    <td>{{ $mv['concept'] }}</td>
                    <td>{{ number_format($mv['amount'], 2, ',', '.') }} €</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay movimientos en este rango.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</section>

