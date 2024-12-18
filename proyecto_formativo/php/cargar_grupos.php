<?php
include 'bd.php';

// Consultar los datos de la tabla creacion_de_grupos
$query = "SELECT id_crear_grupos, nombre_grupo, codigo, horario, precio FROM creacion_de_grupos";
$result = $conn->query($query);

// Comprobar si hay resultados
if ($result->num_rows > 0) {
    // Comenzar a generar los swiper-slide
    while ($row = $result->fetch_assoc()) {
        $id = htmlspecialchars($row['id_crear_grupos']);
        $nombre = htmlspecialchars($row['nombre_grupo']);
        $codigo = htmlspecialchars($row['codigo']);
        $horario = htmlspecialchars($row['horario']);
        $precio = htmlspecialchars($row['precio']);

        echo "
        <div class='swiper-slide'>
            <div class='pricing-card'>
                <h2 class='title'>{$nombre}</h2>
                <p class='price'>\${$precio}<span>/Mensual</span></p>
                <ul class='features'>
                    <li>Código: {$codigo}</li>
                    <li>Horario: {$horario}</li>
                    <li>Precio: \${$precio}</li>
                </ul>
            </div>
        </div>";
    }
} else {
    echo "<div class='swiper-slide'><p>No hay grupos disponibles.</p></div>";
}

$conn->close();
?>
