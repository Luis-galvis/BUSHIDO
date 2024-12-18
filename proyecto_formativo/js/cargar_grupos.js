document.addEventListener('DOMContentLoaded', () => {
    const grupoSelect = document.getElementById('grupo');
    const tablaEstudiantes = document.getElementById('usuariosTable').querySelector('tbody');
    const filtrarBtn = document.getElementById('filtrarBtn');

    // Cargar los grupos en el select
    fetch('../php/obtener_grupos2.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo obtener los grupos');
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                // Añadir opciones al select
                data.forEach(grupo => {
                    const option = document.createElement('option');
                    option.value = grupo.id_crear_grupos;
                    option.textContent = grupo.nombre_grupo;
                    grupoSelect.appendChild(option);
                });
            } else {
                console.error('No se encontraron grupos');
            }
        })
        .catch(error => {
            console.error('Error al cargar los grupos:', error);
        });

    // Filtrar usuarios según el grupo seleccionado
    filtrarBtn.addEventListener('click', () => {
        const grupoId = grupoSelect.value;

        if (!grupoId) {
            tablaEstudiantes.innerHTML = ''; // Limpiar tabla si no hay selección
            return;
        }

        // Mostrar mensaje de carga mientras se obtienen los estudiantes
        tablaEstudiantes.innerHTML = '<tr><td colspan="3">Cargando estudiantes...</td></tr>';

        fetch(`../php/obtener_estudiantes2.php?id_grupo=${grupoId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudo obtener los estudiantes');
                }
                return response.json();
            })
            .then(data => {
                tablaEstudiantes.innerHTML = ''; // Limpiar tabla antes de llenarla

                if (Array.isArray(data) && data.length > 0) {
                    // Llenar la tabla con los estudiantes
                    data.forEach(estudiante => {
                        const fila = document.createElement('tr');
                        fila.innerHTML = `  
                            <td>${estudiante.nombre_completo}</td>
                            <td>
                                <!-- Crear un formulario oculto con el ID del usuario -->
                                <form action="../php/redireccionar_matricula.php" method="POST">
                                    <input type="hidden" name="id_usuario" value="${estudiante.id_usuario}">
                                    <button type="submit" class="actualizar-matricula-btn">Actualizar Matrícula</button>
                                </form>
                            </td>
                            <td>
                                <!-- Botón para descargar la matrícula -->
                                <a href="../php/descargar_matricula.php?id_usuario=${estudiante.id_usuario}" class="descargar-matricula-btn" target="_blank">
                                    Descargar Matrícula
                                </a>
                            </td>
                        `;
                        tablaEstudiantes.appendChild(fila);
                    });
                } else {
                    tablaEstudiantes.innerHTML = '<tr><td colspan="3">No hay estudiantes en este grupo.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error al cargar los estudiantes:', error);
                tablaEstudiantes.innerHTML = '<tr><td colspan="3">Hubo un error al cargar los estudiantes.</td></tr>';
            });
    });
});
