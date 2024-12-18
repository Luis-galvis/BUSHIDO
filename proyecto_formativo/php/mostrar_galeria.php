<?php
// Incluir el archivo de conexión
include 'bd.php';

$query = "SELECT imagen, mime_type FROM comentarios";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagen = $row['imagen'];  // Ruta del archivo
        $mime_type = $row['mime_type'];  // Tipo MIME del archivo

        // Si el mime_type es solo "image", tratamos de inferir el tipo por la extensión
        if ($mime_type === 'image') {
            // Aquí determinamos el tipo basado en la extensión del archivo
            $extension = pathinfo($imagen, PATHINFO_EXTENSION);
            switch (strtolower($extension)) {
                case 'jpg':
                case 'jpeg':
                    $mime_type = 'image/jpeg';
                    break;
                case 'png':
                    $mime_type = 'image/png';
                    break;
                case 'gif':
                    $mime_type = 'image/gif';
                    break;
                default:
                    $mime_type = 'image/jpeg'; // Asignamos un tipo por defecto si no podemos determinarlo
            }
        }

        // Mostrar MIME para depuración

        // Verificar si los datos existen
        if ($imagen === null || $mime_type === null) {
            echo "<p>Imagen o MIME no disponible para este comentario.</p>";
            continue;
        }

        // Concatenar la ruta completa desde la carpeta raíz
        $realPath = $_SERVER['DOCUMENT_ROOT'] . "/proyecto_formativo22222/proyecto_formativo/" . $imagen;

        echo "<div class='product-card'>";

        // Si es una imagen, mostrarla usando la ruta completa
        if (strpos($mime_type, 'image/') === 0) {
            if (file_exists($realPath)) {
                echo "<img src='/proyecto_formativo22222/proyecto_formativo/$imagen' alt='Imagen del comentario'>";
            } else {
                echo "<p>Imagen no encontrada: $realPath</p>";
            }
        }
        // Si es un video, mostrar el video usando la ruta completa
        elseif (strpos($mime_type, 'video/') === 0) {
            if (file_exists($realPath)) {
                echo "<video controls style='max-width: 100%;'>
                        <source src='/proyecto_formativo22222/proyecto_formativo/$imagen' type='$mime_type'>
                        Tu navegador no soporta este formato de video.
                      </video>";
            } else {
                echo "<p>Video no encontrado: $realPath</p>";
            }
        }

        echo "</div>";
    }
} else {
    echo "<p class='no-results'>No hay productos disponibles.</p>";
}

$conn->close();
?>









