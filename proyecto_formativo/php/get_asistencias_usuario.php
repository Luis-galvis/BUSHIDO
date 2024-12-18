<?php
header('Content-Type: application/json');
error_reporting(E_ALL); // Mostrar errores
ini_set('display_errors', 1);

include 'bd.php'; // Conexión a la base de datos

// Validar el ID del usuario
if (!isset($_GET['id_usuario']) || !is_numeric($_GET['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'ID de usuario inválido']);
    exit;
}

$id_usuario = $_GET['id_usuario'];

// Consulta para obtener las asistencias del usuario
$query = "
    SELECT asistencia.fechas AS fecha_asistencia, asistencia.estado, asistencia.observaciones, creacion_de_grupos.nombre_grupo 
    FROM asistencia
    JOIN creacion_de_grupos ON asistencia.id_crear_grupos = creacion_de_grupos.id_crear_grupos
    WHERE asistencia.id_usuario = ?
";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
    exit;
}

$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$asistencias = [];
while ($row = $result->fetch_assoc()) {
    $asistencias[] = $row;
}

// Devolver los datos como JSON
echo json_encode($asistencias);
exit;
?>

