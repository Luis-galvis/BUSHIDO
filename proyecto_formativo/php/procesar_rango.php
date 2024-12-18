<?php
// Conectar a la base de datos
include('../php/bd.php');

// Obtener la acción (crear, editar, eliminar) y los datos del formulario
$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;
$id_rango = $_POST['id_rango'] ?? $_GET['id_rango'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$codigo = $_POST['codigo'] ?? null;

if ($accion === 'crear') {
    // Acción para crear un nuevo rango
    if ($nombre && $codigo) {
        $sql = "INSERT INTO rango (nombre, codigo) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $codigo);
        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: ../html_admin/rango.php?mensaje=Rango creado exitosamente");
        } else {
            header("Location: ../html_admin/rango.php?error=Error al crear el rango");
        }
    }
} elseif ($accion === 'editar' && $id_rango) {
    // Acción para editar un rango existente
    if ($nombre && $codigo) {
        $sql = "UPDATE rango SET nombre = ?, codigo = ? WHERE id_rango = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $nombre, $codigo, $id_rango);
        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: ../html_admin/rango.php?mensaje=Rango actualizado exitosamente");
        } else {
            header("Location: ../html_admin/rango.php?error=Error al actualizar el rango");
        }
    }
} elseif ($accion === 'eliminar' && $id_rango) {
    // Acción para eliminar un rango
    $sql = "DELETE FROM rango WHERE id_rango = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_rango);
    if ($stmt->execute()) {
        header("Location: ../html_admin/rango.php?mensaje=Rango eliminado exitosamente");
    } else {
        header("Location: ../html_admin/rango.php?error=Error al eliminar el rango");
    }
}

// Cerrar la conexión
$conn->close();
?>
