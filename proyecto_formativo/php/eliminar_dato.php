<?php
include('bd.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM comentarios WHERE id_comentarios = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Registro eliminado correctamente.";
    } else {
        echo "Error al eliminar el registro.";
    }

    $stmt->close();
} else {
    echo "ID no proporcionado.";
}

$conn->close();
?>
