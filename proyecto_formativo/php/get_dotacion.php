<?php
include('bd.php');

// Consulta para obtener todos los accesorios
$sql = "SELECT id_dotacion, nombre, descripcion, precio, imagen FROM dotacion";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Verificar valores NULL y asignar un texto predeterminado
        $nombre = htmlspecialchars($row['nombre'] ?? 'Sin nombre');
        $descripcion = htmlspecialchars($row['descripcion'] ?? 'Sin descripción');
        $precio = htmlspecialchars($row['precio'] ?? '0');

        // Mostrar datos
        echo '<div class="box" data-id="' . $row['id_dotacion'] . '">';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" alt="Accesorio">';
        echo '<h3 class="item-name">' . $nombre . '</h3>';
        echo '<p class="item-description">' . $descripcion . '</p>';
        echo '<p class="item-price">$' . $precio . '</p>';
        echo '<button class="info">Editar</button>';
        echo '</div>';
    }
} else {
    echo '<p>No se encontraron accesorios.</p>';
}

$conn->close();
?>
