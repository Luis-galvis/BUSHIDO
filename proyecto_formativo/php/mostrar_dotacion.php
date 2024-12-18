<?php
// Incluir el archivo de conexión
include 'bd.php';

$query = "SELECT nombre, precio, imagen FROM dotacion";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nombre = htmlspecialchars($row['nombre']);
        $precio = htmlspecialchars($row['precio']);
        $imagen = base64_encode($row['imagen']);

        echo "
        <div class='product-card'>
            <img src='data:image/jpeg;base64,{$imagen}' alt='{$nombre}'>
            <h3>{$nombre}</h3>
            <p>\${$precio}</p>
        </div>";
    }
} else {
    echo "<p class='no-results'>No hay productos disponibles.</p>";
}

$conn->close();
?>
