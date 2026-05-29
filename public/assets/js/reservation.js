/**
 * Script de reservas
 *
 * - Barra de control (carga dinámica, ordenación y paginación)
 */
document.addEventListener("DOMContentLoaded", () => {
    let currentPage = 1;
    const reservationStatusSelect = document.getElementById("reservationStatus");
    const orderButtons = document.querySelectorAll(".order-btn");

    function loadReservations() {
        const filter = reservationStatusSelect.value;
        const sort = document.querySelector(".order-btn.active")?.dataset.sort ?? "desc";
        
        const url = `/reservation?page=${currentPage}&filter=${filter}&sort=${sort}`;

        fetch(url, {
            method: "GET",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#group-reservations").innerHTML = data.html;
            document.querySelector(".paginate").innerHTML = data.pagination;
        })
        .catch(error => console.error("Error:", error));
    }

    //Evento cambio select
    reservationStatusSelect.addEventListener("change", () => {
        currentPage = 1;
        loadReservations();
    });

    //Evento ordenación: se actualiza la variable, se cambia el elemento activo y loadReservations
    orderButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            orderButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            currentPage = 1;
            loadReservations();
        });
    });

    //Cuando se cambia de página
    window.changePage = function(page) {
        currentPage = page;
        loadReservations();
    };
});