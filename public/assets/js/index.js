document.addEventListener("DOMContentLoaded", () => {
    let filter = document.querySelector('input[name="bike-type"]:checked')?.id ?? "all";
    let sort = "asc";
    let currentPage = 1;

    const radios = document.querySelectorAll('input[name="bike-type"]');
    const orderButtons = document.querySelectorAll(".order-btn");

    //Cuando se cambia un filtro
    radios.forEach(radio => {
        radio.addEventListener("change", () => {
            filter = radio.id;
            currentPage = 1;
            loadBikes(currentPage, filter, sort);
        });
    });

    //Cuando se ordena: se actualiza la variable, se cambia el elemento activo y loadBikes
    orderButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            sort = btn.dataset.sort;

            orderButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            loadBikes(currentPage, filter, sort);
        });
    });

    function loadBikes(page, filter, sort) {
        const url = `/?page=${page}&filter=${filter}&sort=${sort}`;

        fetch(url, {
            method: "GET",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#group-bikes").innerHTML = data.html;
            document.querySelector(".paginate").innerHTML = data.pagination;
        })
        .catch(error => console.error("Error:", error));
    }

    //Cuando se cambia de página
    window.changePage = function(page) {
        currentPage = page;
        loadBikes(page, filter, sort);
    };
});


//Selecciona todos los slideshow, mete las img a un array, si el evento es hover: 
//quita y añade clases cada 3 segundos para ocultar/mostrar la foto actual/siguiente
document.querySelectorAll('.slideshow').forEach(slideshow => {
    const slides = Array.from(slideshow.querySelectorAll('img'));
    let index = 0;
    let interval = null;

    const start = () => {
        if (interval !== null) return;

        interval = setInterval(() => {
            slides[index].classList.remove('show');
            slides[index].classList.add('hide');

            index = (index + 1) % slides.length;

            slides[index].classList.remove('hide');
            slides[index].classList.add('show');
        }, 2000);
    };

    const stop = () => {
        clearInterval(interval);
        interval = null;
    };

    slideshow.addEventListener('mouseenter', start);
    slideshow.addEventListener('mouseleave', stop);
});
