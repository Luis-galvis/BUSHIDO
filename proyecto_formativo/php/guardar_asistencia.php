<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

include 'bd.php'; // Incluye tu conexión a la base de datos

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verifica si los datos de asistencia fueron recibidos
if (empty($data['asistencia'])) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit;
}

$asistencia = $data['asistencia'];

foreach ($asistencia as $registro) {
    $id_usuario = $registro['id_usuario'];
    $estado = $registro['estado'];
    $observaciones = $registro['observaciones'];
    $id_crear_grupos = $registro['id_crear_grupos'];
    $fecha_asistencia = $registro['fecha_asistencia']; // Captura la fecha de asistencia

    if (empty($id_usuario) || empty($estado) || empty($id_crear_grupos) || empty($fecha_asistencia)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos en el registro']);
        exit;
    }

    // Asegúrate de que la fecha esté en formato correcto para MySQL (YYYY-MM-DD HH:MM:SS)
    // Si la fecha está en un formato incorrecto, intenta convertirla.
    $fecha_asistencia = date('Y-m-d H:i:s', strtotime($fecha_asistencia));

    $query = 'INSERT INTO asistencia (id_usuario, estado, observaciones, id_crear_grupos, fechas) VALUES (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $id_usuario, $estado, $observaciones, $id_crear_grupos, $fecha_asistencia); // Enlaza la fecha también

    if ($stmt->execute()) {
        $result = ['success' => true, 'message' => 'Asistencia guardada correctamente'];
    } else {
        $result = ['success' => false, 'message' => 'Error al guardar la asistencia: ' . $stmt->error];
    }
}

echo json_encode($result); // Devolver la respuesta como JSON
?>
