<?php
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_dotacion'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
    }

    $sql = "UPDATE dotacion SET nombre = ?, descripcion = ?, precio = ?" . ($imagen ? ", imagen = ?" : "") . " WHERE id_dotacion = ?";
    $stmt = $conn->prepare($sql);

    if ($imagen) {
        $stmt->bind_param('ssibi', $nombre, $descripcion, $precio, $imagen, $id);
    } else {
        $stmt->bind_param('ssii', $nombre, $descripcion, $precio, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
