<?php
// Incluye la conexión a la base de datos
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos del formulario
    $nombreGrupo = $_POST['nombre-grupo'];
    $codigoGrupo = !empty($_POST['codigo-grupo']) ? intval($_POST['codigo-grupo']) : null;
    $horarioGrupo = !empty($_POST['horario-grupo']) ? $_POST['horario-grupo'] : null;
    $precioGrupo = intval($_POST['precio-grupo']);

    // Prepara la consulta
    $stmt = $conn->prepare("INSERT INTO creacion_de_grupos (nombre_grupo, codigo, horario, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", $nombreGrupo, $codigoGrupo, $horarioGrupo, $precioGrupo);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Grupo creado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
