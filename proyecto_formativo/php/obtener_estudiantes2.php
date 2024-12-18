<?php
// Incluye tu conexión a la base de datos
include('bd.php'); // Conexión a la base de datos

// Obtiene el ID del grupo desde la URL
$id_grupo = $_GET['id_grupo'];

// Prepara la consulta SQL
$query = 'SELECT u.id_usuario, CONCAT(u.nombre, " ", u.apellidos) AS nombre_completo
          FROM usuarios u
          JOIN matricula m ON u.id_usuario = m.id_usuario
          WHERE m.id_crear_grupos = ?';

// Prepara la consulta
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_grupo); // Vincula el parámetro con el ID del grupo

// Ejecuta la consulta
$stmt->execute();

// Obtiene el resultado
$result = $stmt->get_result();

// Crea un array para almacenar los estudiantes
$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

// Devuelve los resultados como JSON
echo json_encode($estudiantes);

// Cierra la conexión
$stmt->close();
$conn->close();
?>

