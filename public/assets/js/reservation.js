document.addEventListener("DOMContentLoaded", () => {
    let currentPage = 1;

    const radios = document.querySelectorAll('input[name="reservation-status"]');
    const orderButtons = document.querySelectorAll(".order-btn");

    //Evento cambio filtro
    radios.forEach(radio => {
        radio.addEventListener("change", () => {
            currentPage = 1;
            loadReservations();
        });
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

    function loadReservations() {
        const filter = document.querySelector('input[name="reservation-status"]:checked')?.id ?? "all";
        const sort = document.querySelector(".order-btn.active")?.dataset.sort ?? "asc";
        
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

    //Cuando se cambia de página
    window.changePage = function(page) {
        currentPage = page;
        loadReservations();
    };
});