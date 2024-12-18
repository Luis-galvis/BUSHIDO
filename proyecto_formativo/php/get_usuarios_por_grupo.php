<?php
include 'bd.php'; // Incluye tu conexión a la base de datos

// Obtener el ID del grupo
$grupoId = $_GET['grupo_id'];  // El ID del grupo se pasa por parámetro

// Consulta para obtener los usuarios del grupo seleccionado
$query = "SELECT u.id_usuario, u.nombre, u.apellidos 
          FROM usuarios u 
          JOIN matricula m ON m.id_usuario = u.id_usuario
          WHERE m.id_crear_grupos = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $grupoId);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

// Devolver los usuarios como JSON
echo json_encode($usuarios);
?>

