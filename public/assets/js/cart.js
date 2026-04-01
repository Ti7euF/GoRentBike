function addToCart(bikeId) {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate) {
        alert("Error. Antes de añadir seleccione fecha de inicio y fin válidas.");
        return;
    }

    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            bikeId: bikeId,
            startDate: startDate,
            endDate: endDate,
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

//Se actualiza el contador del botón del carrito y activa la animación
function updateCartCount(reset) {
    const badge = document.getElementById('cart-count');
    let current = parseInt(badge.textContent);

    if (reset === 0) {
        badge.textContent = 0;
    } else {
        badge.textContent = current + 1;
    }

    badge.classList.remove('flash');
    setTimeout(() => {
        badge.classList.add('flash');
    }, 10);
}


