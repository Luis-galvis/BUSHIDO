<?php
// Incluir el archivo de conexión
include 'bd.php';

// Obtener los 3 comentarios más recientes
$query = "SELECT texto, imagen, mime_type FROM comentarios ORDER BY id_comentarios DESC LIMIT 3";
$result = $conn->query($query);

// Creamos un arreglo para almacenar los slides
$slides = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagen = $row['imagen'];  // Ruta del archivo
        $mime_type = $row['mime_type'];  // Tipo MIME del archivo

        // Inicializamos la variable que contendrá el HTML de la imagen o video
        $media_html = '';

        // Verificar si existe una imagen
        if (strpos($mime_type, 'image/') === 0) {
            // Ruta completa para la imagen
            $realPath = $_SERVER['DOCUMENT_ROOT'] . "/proyecto_formativo22222/proyecto_formativo/" . $imagen;
            
            if (file_exists($realPath)) {
                $media_html = "<img src='/proyecto_formativo22222/proyecto_formativo/$imagen' alt='Imagen del Slide' onclick=\"showModal('/proyecto_formativo22222/proyecto_formativo/$imagen', '{$row['texto']}')\">";
            } else {
                $media_html = "<p>Imagen no encontrada: $realPath</p>";
            }
        }
        // Verificar si es un video
        elseif (strpos($mime_type, 'video/') === 0) {
            // Ruta completa al video
            $realPath = $_SERVER['DOCUMENT_ROOT'] . "/proyecto_formativo22222/proyecto_formativo/" . $imagen;

            if (file_exists($realPath)) {
                $media_html = "<video controls style='max-width: 100%;'>
                                <source src='/proyecto_formativo22222/proyecto_formativo/$imagen' type='$mime_type'>
                                Tu navegador no soporta este formato de video.
                              </video>";
            } else {
                $media_html = "<p>Video no encontrado: $realPath</p>";
            }
        }

        // Si la imagen o el video están disponibles, lo agregamos al arreglo de slides
        $slides[] = [
            'texto' => htmlspecialchars($row['texto']),  // Sanitizar el texto
            'media' => $media_html
        ];
    }
}

// Aquí empieza la parte de la generación del HTML para el slider
?>
<div class="slider">
    <div class="slide-container" id="slide-container">
        <?php
        // Generar cada slide con sus datos
        foreach ($slides as $slideContent) {
            ?>
            <div class="slide">
                <p><?php echo $slideContent['texto']; ?></p>
                <?php echo $slideContent['media']; ?>
            </div>
            <?php
        }
        ?>
    </div>

    <!-- Botones de navegación (ya no es necesario usar `id` para estos botones en este caso) -->
    <a class="prev" onclick="moveSlide(-1)">&#10094;</a>
    <a class="next" onclick="moveSlide(1)">&#10095;</a>
</div>

<!-- Modal para imágenes -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

<?php
// Cerrar la conexión
$conn->close();
?>


