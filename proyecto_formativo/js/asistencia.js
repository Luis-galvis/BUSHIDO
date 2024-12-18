document.addEventListener('DOMContentLoaded', function() {
    // Cargar los grupos desde la base de datos
    fetchGrupos();

    // Cuando el formulario de filtro de grupo sea enviado
    document.getElementById('filtroGrupoForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const grupoId = document.getElementById('grupo').value;
        if (grupoId) {
            cargarUsuariosPorGrupo(grupoId);
        } else {
            alert('Por favor, selecciona un grupo');
        }
    });

    // Función para cargar los grupos
    function fetchGrupos() {
        fetch('../php/get_grupos.php') // Endpoint para obtener los grupos
            .then(response => response.json())
            .then(data => {
                const grupoSelect = document.getElementById('grupo');
                grupoSelect.innerHTML = '<option value="">Seleccione un grupo</option>'; // Limpiar el select antes de agregar opciones
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(grupo => {
                        const option = document.createElement('option');
                        option.value = grupo.id_crear_grupos;
                        option.textContent = grupo.nombre_grupo;
                        grupoSelect.appendChild(option);
                    });
                } else {
                    console.error('No se encontraron grupos o la respuesta no es válida');
                }
            })
            .catch(error => console.error('Error al cargar los grupos:', error));
    }

    // Función para cargar los usuarios por grupo
    function cargarUsuariosPorGrupo(grupoId) {
        fetch(`../php/get_usuarios_por_grupo.php?grupo_id=${grupoId}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('usuariosTable').querySelector('tbody');
                tableBody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos usuarios
    
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(usuario => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="student-name" data-id="${usuario.id_usuario}">${usuario.nombre} ${usuario.apellidos}</td>
                            <td><input type="checkbox" data-id="${usuario.id_usuario}" /></td>
                            <td><input type="text" data-id="${usuario.id_usuario}" placeholder="Observaciones" /></td>
                        `;
                        tableBody.appendChild(row);
                    });
    
                    // Agregar eventos para mostrar asistencias al hacer clic en el nombre
                    const studentNames = document.querySelectorAll('.student-name');
                    studentNames.forEach(name => {
                        name.addEventListener('click', function () {
                            const usuarioId = this.getAttribute('data-id');
                            mostrarAsistencias(usuarioId);
                        });
                    });
                } else {
                    console.log('No se encontraron usuarios para este grupo');
                }
            })
            .catch(error => console.error('Error al cargar los usuarios:', error));
    }

    // Función para mostrar asistencias de un usuario
    function mostrarAsistencias(usuarioId) {
        fetch(`../php/get_asistencias_usuario.php?id_usuario=${usuarioId}`)
            .then(response => response.json())
            .then(data => {
                const asistenciasContainer = document.getElementById('asistenciasContainer');
                asistenciasContainer.innerHTML = ''; // Limpiar el contenedor
    
                if (Array.isArray(data) && data.length > 0) {
                    const table = document.createElement('table');
                    
                    // Asignar una clase específica para diferenciarla de la tabla principal
                    table.classList.add('tabla-detalle'); // Clase específica para la tabla de detalles
                    
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Grupo</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.map(asistencia => `
                                <tr>
                                    <td>${asistencia.fecha_asistencia}</td>
                                    <td>${asistencia.estado}</td>
                                    <td>${asistencia.observaciones}</td>
                                    <td>${asistencia.nombre_grupo}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    `;
                    asistenciasContainer.appendChild(table);
                } else {
                    asistenciasContainer.textContent = 'No se encontraron asistencias para este estudiante.';
                }
            })
            .catch(error => console.error('Error al cargar las asistencias:', error));
    }

    // Función para guardar la asistencia
    document.getElementById('guardarAsistencia').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('#usuariosTable input[type="checkbox"]');
        const observaciones = document.querySelectorAll('#usuariosTable input[type="text"]');
        const asistenciaData = [];
        const grupoId = document.getElementById('grupo').value; // Obtén el grupo seleccionado
        
        // Obtén la fecha y hora actual con el formato correcto
        const fechaActual = new Date();
        const año = fechaActual.getFullYear();
        const mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Mes en formato 2 dígitos
        const dia = fechaActual.getDate().toString().padStart(2, '0'); // Día en formato 2 dígitos
        const horas = fechaActual.getHours().toString().padStart(2, '0'); // Hora en formato 2 dígitos
        const minutos = fechaActual.getMinutes().toString().padStart(2, '0'); // Minutos en formato 2 dígitos
        const segundos = fechaActual.getSeconds().toString().padStart(2, '0'); // Segundos en formato 2 dígitos
        
        const fechaFormateada = `${año}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;  // Formato correcto de fecha y hora
        
        if (!grupoId) {
            alert('Por favor, selecciona un grupo.');
            return;
        }
        
        checkboxes.forEach((checkbox, index) => {
            const usuarioId = checkbox.getAttribute('data-id');  // 'data-id' sigue siendo correcto
            const observacion = observaciones[index].value || ''; // 'observacion' es el campo de texto
            const estado = checkbox.checked ? 'Presente' : 'Ausente';
        
            asistenciaData.push({ 
                id_usuario: usuarioId,  
                estado: estado,
                observaciones: observacion,
                id_crear_grupos: grupoId, // Incluye el grupoId al enviar los datos
                fecha_asistencia: fechaFormateada // Aquí agregamos la fecha y hora correctamente formateada
            });
        });
        
        // Enviar los datos al servidor
        fetch('../php/guardar_asistencia.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ asistencia: asistenciaData })
        })
        .then(response => response.json()) // Cambiar a response.json()
        .then(data => {
            if (data.success) {
                alert('Asistencia guardada con éxito');
            } else {
                alert('Error al guardar la asistencia: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Error en la solicitud');
        });
    });
    
});
