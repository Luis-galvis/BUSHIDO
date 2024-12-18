<?php
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $horario = $_POST['horario'];
    $precio = $_POST['precio'];

    // Verificar que los datos no estén vacíos
    if (empty($id) || empty($nombre) || empty($codigo) || empty($horario) || empty($precio)) {
        echo "Todos los campos son requeridos.";
        exit();
    }

    // Cambiar los tipos de parámetros: 's' para cadenas de texto, 'i' para enteros (precio y código)
    $query = "UPDATE creacion_de_grupos SET nombre_grupo = ?, codigo = ?, horario = ?, precio = ? WHERE id_crear_grupos = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "Error al preparar la consulta: " . $conn->error;  // Muestra el error de la conexión si no se prepara la consulta
        exit();
    }

    // Usar 'sssis' para strings (nombre, código, horario) y 'i' para enteros (precio y id)
    $stmt->bind_param('sssis', $nombre, $codigo, $horario, $precio, $id);

    // Verificar si los parámetros se vincularon correctamente
    if ($stmt->errno) {
        echo "Error al vincular los parámetros: " . $stmt->error;
        exit();
    }

    if ($stmt->execute()) {
        echo "Grupo actualizado con éxito.";
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;  // Muestra el error exacto si falla la ejecución
    }

    $stmt->close();
    $conn->close();
}
?>


