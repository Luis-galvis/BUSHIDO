// Función para abrir el modal de edición
function openEditPopup(id) {
    const row = document.querySelector(`tr[data-id='${id}']`);

    // Verifica que la fila fue encontrada
    if (!row) {
        console.log("No se encontró la fila con ID:", id);
        return;
    }

    // Asignar los valores del grupo a los campos del modal
    document.getElementById('groupId').value = id;
    document.getElementById('groupName').value = row.querySelector('.group-name').textContent.trim();
    document.getElementById('groupCode').value = row.querySelector('.group-code').textContent.trim();
    document.getElementById('groupSchedule').value = row.querySelector('.group-schedule').textContent.trim();
    document.getElementById('groupPrice').value = row.querySelector('.group-price').textContent.trim();

    // Verifica que los valores se asignen correctamente
    console.log("Valores asignados: ", {
        id: id,
        name: row.querySelector('.group-name').textContent.trim(),
        code: row.querySelector('.group-code').textContent.trim(),
        schedule: row.querySelector('.group-schedule').textContent.trim(),
        price: row.querySelector('.group-price').textContent.trim(),
    });

    // Mostrar el modal de edición
    document.getElementById('editPopup').style.display = 'block';
}


// Función para cerrar el modal de edición
function closeEditPopup() {
    // Cerrar el modal
    document.getElementById('editPopup').style.display = 'none';
}


function saveGroup() {
    const id = document.getElementById('groupId').value;
    const name = document.getElementById('groupName').value;
    const code = document.getElementById('groupCode').value;
    const schedule = document.getElementById('groupSchedule').value;
    const price = document.getElementById('groupPrice').value;

    // Imprimir los valores antes de enviar la solicitud
    console.log({ id, name, code, schedule, price });

    // Enviar los datos al servidor para actualizar
    fetch('../php/update_group.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&nombre=${name}&codigo=${code}&horario=${schedule}&precio=${price}`
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);  // Mostrar la respuesta del servidor
        if (data.includes('éxito')) {
            location.reload();  // Recargar la página para reflejar los cambios
        } else {
            alert('Error al guardar el grupo: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


// Función para borrar un grupo
function deleteGroup(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este grupo?')) {
        // Imprimir el ID antes de enviarlo
        console.log("Eliminando grupo con ID:", id);

        // Enviar la solicitud de borrado al servidor
        fetch('../php/delete_group.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);  // Mostrar la respuesta del servidor
            if (data.includes('éxito')) {
                document.querySelector(`tr[data-id='${id}']`).remove();  // Eliminar la fila de la tabla
            } else {
                alert('Error al eliminar el grupo: ' + data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}


