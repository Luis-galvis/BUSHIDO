<?php
// Asegúrate de que el tipo de contenido sea JSON
header('Content-Type: application/json');

// Conexión a la base de datos
include 'bd.php';  // Asegúrate de que el archivo bd.php está correctamente configurado

// Obtener los parámetros de la URL
$mes = isset($_GET['mes']) ? $_GET['mes'] : null;
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : null;

// Verificamos si el periodo es 'seis_meses' o si es un mes específico
if ($periodo === 'seis_meses') {
    // Obtener la fecha actual
    $fecha_fin = date('Y-m-d'); // Fecha actual
    $fecha_inicio = date('Y-m-d', strtotime('-6 months', strtotime($fecha_fin))); // Fecha hace 6 meses
} elseif ($mes) {
    // Si se seleccionó un mes, establecemos las fechas según el mes
    $fecha_inicio = date('Y-m-01', strtotime($mes)); // Primer día del mes seleccionado
    $fecha_fin = date('Y-m-t', strtotime($mes)); // Último día del mes seleccionado
} else {
    echo json_encode(['message' => 'Parámetros incorrectos.']);
    exit;
}

// Consulta SQL para obtener las asistencias usando consultas preparadas
$sql = "SELECT estado, COUNT(*) AS total_asistencias 
        FROM asistencia 
        WHERE id_usuario = 29 
        AND DATE(fechas) BETWEEN ? AND ? 
        GROUP BY estado";

// Preparar la consulta
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['message' => 'Error en la preparación de la consulta.']);
    exit;
}

// Enlazar los parámetros
$stmt->bind_param('ss', $fecha_inicio, $fecha_fin);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado
$resultado = $stmt->get_result();

// Verificar si la consulta devuelve resultados
if ($resultado->num_rows > 0) {
    $asistencias = ['Presente' => 0, 'Ausente' => 0];

    // Procesar los resultados
    while ($row = $resultado->fetch_assoc()) {
        $asistencias[$row['estado']] = $row['total_asistencias'];
    }

    // Calcular el porcentaje de presencia
    $total = $asistencias['Presente'] + $asistencias['Ausente'];
    $porcentaje_presente = ($total > 0) ? ($asistencias['Presente'] / $total) * 100 : 0;

    // Enviar los datos como JSON
    echo json_encode([
        'asistencias' => $asistencias,
        'porcentaje_presente' => $porcentaje_presente
    ]);
} else {
    // Si no hay resultados, enviar una respuesta vacía
    echo json_encode(['message' => 'No se encontraron registros de asistencia.']);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>



