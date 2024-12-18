<?php
header('Content-Type: application/json');
include 'bd.php'; // Incluye tu conexión a la base de datos

// Consulta para obtener todos los grupos
$query = "SELECT id_crear_grupos, nombre_grupo FROM creacion_de_grupos";

$result = $conn->query($query);
$grupos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $grupos[] = $row; // Añadir cada grupo al arreglo
    }
    echo json_encode($grupos); // Devolver los grupos como JSON
} else {
    echo json_encode([]); // Si no hay grupos, retornar un array vacío
}
?>
