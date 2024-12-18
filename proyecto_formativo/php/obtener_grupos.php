<?php
// Incluir el archivo de conexión
include 'bd.php';

// Consultar los datos de la tabla creacion_de_grupos
$query = "SELECT id_crear_grupos, nombre_grupo, codigo, horario, precio FROM creacion_de_grupos";
$result = $conn->query($query);

// Comprobar si hay resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = isset($row['id_crear_grupos']) ? htmlspecialchars($row['id_crear_grupos']) : '';
        $nombre = isset($row['nombre_grupo']) ? htmlspecialchars($row['nombre_grupo']) : '';
        $codigo = isset($row['codigo']) ? htmlspecialchars($row['codigo']) : '';
        $horario = isset($row['horario']) ? htmlspecialchars($row['horario']) : '';
        $precio = isset($row['precio']) ? htmlspecialchars($row['precio']) : '';
        

        echo "
        <tr data-id='{$id}'>
            <td class='group-name'>{$nombre}</td>
            <td class='group-code'>{$codigo}</td>
            <td class='group-schedule'>{$horario}</td>
            <td class='group-price'>\${$precio}</td>
            <td>
                <button class='edit-btn' onclick='openEditPopup({$id})'>✎</button>
                <button class='delete-btn' onclick='deleteGroup({$id})'>✖</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay grupos disponibles.</td></tr>";
}

$conn->close();
?>
