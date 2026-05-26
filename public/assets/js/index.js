/**
 * Script de página inicial
 *
 * - Barra de control (carga dinámica, ordenación y paginación) y slideshow
 */
document.addEventListener("DOMContentLoaded", () => {
    initSlideshows();
    
    let currentPage = 1;

    const bikeTypeSelect = document.getElementById("bikeType");
    const startInput = document.getElementById('startDate');
    const endInput = document.getElementById('endDate');
    const orderButtons = document.querySelectorAll(".order-btn");

    function loadBikes() {
        const filter = bikeTypeSelect.value;
        const sort = document.querySelector(".order-btn.active")?.dataset.sort ?? "asc";
        const startDate = startInput.value;
        const endDate = endInput.value;
        
        const url = `/?page=${currentPage}&filter=${filter}&sort=${sort}&startDate=${startDate}&endDate=${endDate}`;

        fetch(url, {
            method: "GET",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#group-bikes").innerHTML = data.html;
            document.querySelector(".paginate").innerHTML = data.pagination;
            initSlideshows();
        })
        .catch(error => console.error("Error:", error));
    }


    // Evento cambio select
    bikeTypeSelect.addEventListener("change", () => {
        currentPage = 1;
        loadBikes();
    });

    //Evento cambio fecha
    startInput.addEventListener("change", () => {
        if (startInput.value >= endInput.value) {
            const newEnd = new Date(startInput.value);
            newEnd.setDate(newEnd.getDate() + 1);
            endInput.value = newEnd.toISOString().split('T')[0];
        }

        endInput.min = startInput.value;
        currentPage = 1;
        loadBikes();
    });

    endInput.addEventListener("change", () => {
        currentPage = 1;
        loadBikes();
    });

    //Evento ordenación: se actualiza la variable, se cambia el elemento activo y loadBikes
    orderButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            orderButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            currentPage = 1;
            loadBikes();
        });
    });

    //Cuando se cambia de página
    window.changePage = function(page) {
        currentPage = page;
        loadBikes();
    };


    //Crea un objeto imagen para cada ruta y aplica un fadeOut, cambia la imagen y aplica un fadeIn a la nueva
    const slides = [
        { src: "/uploads/promo/descuentos_dias.webp", alt: "Descuentos por días de reserva."},
        { src: "/uploads/promo/dos_rutas.webp", alt: "Elige tu ruta." }
    ];

    const img = document.getElementById("promoSliderImg");
    if (!img) {
        return;
    }

    slides.forEach(s => { const pre = new Image(); pre.src = s.src; });

    let index = 0;
    const changeImage = () => {
        $(img).fadeOut(700, function () {
            img.src = slides[index].src;
            img.alt = slides[index].alt;

            $(img).fadeIn(700);
        });
    };

    changeImage();
    setInterval(() => {
        index = (index + 1) % slides.length;
        changeImage();
    }, 4000);
});


//Selecciona todos los slideshow, mete las img a un array, si el evento es hover: 
//quita y añade clases cada 3 segundos para ocultar/mostrar la foto actual/siguiente
function initSlideshows() {
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
}
