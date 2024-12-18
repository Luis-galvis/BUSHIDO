<?php
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Verificar si el ID es válido
    if (empty($id) || !is_numeric($id)) {
        echo "ID no válido.";
        exit();
    }

    // Preparar la consulta de eliminación
    $query = "DELETE FROM creacion_de_grupos WHERE id_crear_grupos = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "Error al preparar la consulta: " . $conn->error;  // Muestra el error de la conexión si no se prepara la consulta
        exit();
    }

    // Enlazar el parámetro
    $stmt->bind_param('i', $id);

    // Verificar si los parámetros se vincularon correctamente
    if ($stmt->errno) {
        echo "Error al vincular los parámetros: " . $stmt->error;
        exit();
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Grupo eliminado con éxito.";
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;  // Muestra el error exacto si falla la ejecución
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
