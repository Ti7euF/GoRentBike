/**
 * Añade una bicicleta al carrito.
 * - Obtiene las fechas de los inputs.
 * - Valida las fechas (existen, formato, fechas reales, no reservas en el pasado)
 * - Envía los datos al backend mediante AJAX.
 */
function addToCart(bikeId) {
    const startDateInput = document.getElementById('startDate').value;
    const endDateInput = document.getElementById('endDate').value;

    if (!startDateInput || !endDateInput) {
        alert("Error. Antes de añadir seleccione fecha de inicio y fin válidas.");
        return;
    }

    const startDate = new Date(startDateInput + "T00:00:00");
    const endDate = new Date(endDateInput + "T00:00:00");
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Validar fechas reales
    if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
        alert("Formato de fecha no válido.");
        return;
    }

    // Fecha de inicio debe ser mayor o igual que hoy
    if (startDate < today) {
        alert("La fecha de inicio no puede ser anterior a hoy.");
        return;
    }

    // Fecha de fin debe ser mayor que la de inicio
    if (endDate <= startDate) {
        alert("La fecha de fin debe ser mayor que la fecha de inicio.");
        return;
    }

    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            bikeId: bikeId,
            startDate: startDateInput,
            endDate: endDateInput,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            switch (response.status) {
                case 'added':
                    updateCartCount();
                    break;

                case 'exists':
                    alert("Esta bicicleta ya está en tu carrito.");
                    break;

                case 'unavailable':
                    alert("Esta bicicleta no está disponible.");
                    break;

                default:
                    alert("Error al añadir al carrito.");
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Error al añadir al carrito.");
        }
    });
}

/**
 * Elimina una bicicleta del carrito.
 * - Envía una petición al backend con el ID de la bicicleta a eliminar.
 * - Si se elimina recarga la página y si no muestra un mensaje de error.
 */
function removeFromCart(bikeId) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ bikeId })
    })
    .then(res => res.json())
    .then(success => {
        if (success === true) {
            location.reload();
        } else {
            alert("No se pudo eliminar el artículo.");
        }
    });
}

/**
 * Actualiza el contador del carrito y activa la animación.
 * - Suma 1 al contador actual
 */
function updateCartCount() {
    const badge = document.getElementById('cart-count');
    let current = parseInt(badge.textContent);

    badge.textContent = current + 1;

    badge.classList.remove('flash');
    setTimeout(() => badge.classList.add('flash'), 10);
}


/**
 * Oculta/Muestra el desglose del carrito con un slide.
 * - Al hacer clic sobre el botón hace el slide y cuando acaba cambia el botón
 */
document.addEventListener('DOMContentLoaded', () => {
    $('#btnBreakdown').on('click', function () {
        const panel = $('#summaryBreakdown');
        const btn = $(this);

        panel.slideToggle(250, function () {
            if (panel.is(':visible')) {
                btn.html('<i class="fa-solid fa-chevron-up"></i> Ocultar desglose');
            } else {
                btn.html('<i class="fa-solid fa-chevron-down"></i> Mostrar desglose');
            }
        });
    });
});



