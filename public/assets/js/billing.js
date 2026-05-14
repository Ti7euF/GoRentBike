/**
 * Script de facturación
 * - Renderiza el gráfico y barra de control (carga dinámica, ordenación)
 */
document.addEventListener("DOMContentLoaded", () => {
    let billingChart = null;

    const rangeSelect = document.getElementById("range");
    const orderButtons = document.querySelectorAll(".order-btn");
    const initialChartData = JSON.parse(document.getElementById("initialChartData").textContent);

    // Funciones
    function renderChart(chartData) {
        const ctx = document.getElementById("billingChart");

        if (billingChart) {
            billingChart.destroy();
        }

        billingChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: "Ingresos",
                        data: chartData.income,
                        borderColor: "#3fbf7f",
                        backgroundColor: "rgba(63, 191, 127, 0.25)",
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: "#3fbf7f",
                        pointBorderColor: "#1e293b",
                        tension: 0.4
                    },
                    {
                        label: "Gastos",
                        data: chartData.expenses,
                        borderColor: "#e57373",
                        backgroundColor: "rgba(229, 115, 115, 0.25)",
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: "#e57373",
                        pointBorderColor: "#1e293b",
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: "#6eb6de" }
                    },
                    x: {
                        ticks: { color: "#6eb6de" }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: "#6eb6de" }
                    }
                }
            }
        });
    }

    function loadBilling() {
        const range = rangeSelect.value || "";
        const sort = document.querySelector(".order-btn.active")?.dataset.sort ?? "asc";
        
        const url = `/billing?range=${encodeURIComponent(range)}&sort=${sort}`;

        fetch(url, {
            method: "GET",
            credentials: "include",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#group-billing").innerHTML = data.html;
            renderChart(data.chartData);
        })
        .catch(error => console.error("Error:", error));
    }

    renderChart(initialChartData);

    //Evento select
    rangeSelect.addEventListener("change", () => {
        loadBilling();
    });

    //Evento ordenación: se actualiza la variable, se cambia el elemento activo y loadBilling
    orderButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            orderButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            loadBilling();
        });
    });
});



