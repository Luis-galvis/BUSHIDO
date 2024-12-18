document.addEventListener("DOMContentLoaded", function () {
    const monthSelect = document.getElementById("month-select");
    const sixMonthsBtn = document.getElementById("six-months-btn");

    // Meses en español a su correspondiente en formato 'YYYY-MM'
    const meses = {
        "enero": "01",
        "febrero": "02",
        "marzo": "03",
        "abril": "04",
        "mayo": "05",
        "junio": "06",
        "julio": "07",
        "agosto": "08",
        "septiembre": "09",
        "octubre": "10",
        "noviembre": "11",
        "diciembre": "12"
    };

    // Escuchar cambios en el selector de mes
    monthSelect.addEventListener("change", function () {
        const selectedMonth = monthSelect.value;

        // Si no se selecciona un mes válido, no hacer nada
        if (!selectedMonth) return;

        // Convertir el mes seleccionado a formato 'YYYY-MM' (año actual y el mes seleccionado)
        const currentYear = new Date().getFullYear();
        const formattedMonth = `${currentYear}-${meses[selectedMonth]}`;

        // Realizamos la solicitud AJAX al servidor con el mes seleccionado
        fetch(`../php/asistencia.php?mes=${formattedMonth}&periodo=mes`)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // Si no hay datos para ese mes
                    mostrarAsistencia([]);
                } else {
                    // Si hay datos, mostrar la asistencia
                    mostrarAsistencia(data);
                }
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    });

    // Escuchar el botón para los últimos 6 meses
    sixMonthsBtn.addEventListener("click", function () {
        // Realizamos la solicitud AJAX al servidor para los últimos 6 meses
        fetch(`../php/asistencia.php?periodo=seis_meses`)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // Si no hay datos para los 6 meses
                    mostrarAsistencia([]);
                } else {
                    // Si hay datos, mostrar la asistencia
                    mostrarAsistencia(data);
                }
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    });

    // Función para mostrar la asistencia en la interfaz
    function mostrarAsistencia(data) {
        const container = document.getElementById("table-container");
        container.innerHTML = ""; // Limpiamos el contenido anterior

        // Si no hay datos, mostrar un mensaje
        if (data.length === 0) {
            container.innerHTML = "<h3>No hay datos de asistencia para este periodo.</h3>";
            return;
        }

        // Si hay datos, mostramos el porcentaje de presencia
        const porcentaje = data.porcentaje_presente.toFixed(2);
        container.innerHTML += `<h3>Asistencia: ${porcentaje}%</h3>`;

        // Crear una tabla con las asistencias
        const table = document.createElement("table");
        table.innerHTML = `
            <tr>
                <th>Estado</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>Presente</td>
                <td>${data.asistencias['Presente'] || 0}</td>
            </tr>
            <tr>
                <td>Ausente</td>
                <td>${data.asistencias['Ausente'] || 0}</td>
            </tr>
        `;
        container.appendChild(table);
    }

    // Disparar la carga de la asistencia inicial (mes actual por defecto)
    monthSelect.dispatchEvent(new Event("change"));
});
