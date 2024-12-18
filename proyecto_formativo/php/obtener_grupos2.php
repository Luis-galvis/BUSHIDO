<?php
include('bd.php'); // Conexión a la base de datos

$query = "SELECT id_crear_grupos, nombre_grupo FROM creacion_de_grupos";
$result = $conn->query($query);

$grupos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $grupos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($grupos);
?>
