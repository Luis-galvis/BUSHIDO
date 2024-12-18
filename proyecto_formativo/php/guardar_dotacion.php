<?php
// Incluir el archivo de conexión
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre-accesorio'];
    $precio = intval($_POST['precio-accesorio']);
    $imagen = null;

    // Manejar la subida de la imagen
    if (isset($_FILES['imagen-accesorio']) && $_FILES['imagen-accesorio']['error'] === UPLOAD_ERR_OK) {
        $imagen = file_get_contents($_FILES['imagen-accesorio']['tmp_name']);
    }

    // Insertar datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO dotacion (nombre, precio, imagen) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nombre, $precio, $imagen);

    if ($stmt->execute()) {
        echo "Accesorio agregado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

