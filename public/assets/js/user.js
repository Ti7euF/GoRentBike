document.addEventListener("DOMContentLoaded", () => {
    let currentPage = 1;

    const searchButton = document.getElementById("btn-search");
    const orderButtons = document.querySelectorAll(".order-btn");

    //Evento del botón de búsqueda
    searchButton.addEventListener("click", () => {
        currentPage = 1;
        loadUsers();
    });

    //Evento ordenación: se actualiza la variable, se cambia el elemento activo y loadUsers
    orderButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            orderButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            currentPage = 1;
            loadUsers();
        });
    });

    function loadUsers() {
        const filter = document.querySelector('input[name="search"]')?.value.trim() || "all";
        const sort = document.querySelector(".order-btn.active")?.dataset.sort ?? "asc";
        
        const url = `/user?page=${currentPage}&filter=${encodeURIComponent(filter)}&sort=${sort}`;

        fetch(url, {
            method: "GET",
            credentials: "include",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#group-users").innerHTML = data.html;
            document.querySelector(".paginate").innerHTML = data.pagination;
        })
        .catch(error => console.error("Error:", error));
    }

    //Cuando se cambia de página
    window.changePage = function(page) {
        currentPage = page;
        loadUsers();
    };
});