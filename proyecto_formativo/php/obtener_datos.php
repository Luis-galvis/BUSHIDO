<?php
include('bd.php');

$query = "SELECT id_comentarios, texto, imagen, mime_type FROM comentarios ORDER BY id_comentarios DESC";
$result = $conn->query($query);

$datos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}

echo json_encode($datos);
$conn->close();
?>
