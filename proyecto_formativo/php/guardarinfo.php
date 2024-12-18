<?php
// Conectar a la base de datos
include('bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el campo 'texto' existe en $_POST
    if (isset($_POST['texto'])) {
        $texto = $_POST['texto'];
    } else {
        echo "El campo texto no está definido.<br>";
        exit;
    }

    // Verificar si se marca la opción de fijar
    $fijar = isset($_POST['fijar']) ? 1 : 0;

    // Inicializar variables para los archivos
    $imagen_path = '';  // Inicializamos la ruta de la imagen
    $video_path = '';   // Inicializamos la ruta del video
    $mime_type = '';    // Inicializamos el tipo MIME

    // Procesar la imagen si se ha subido
    if (!empty($_FILES['imagen']['name'])) {
        $target_dir = "../uploads/";  // Directorio de destino para las imágenes
        $target_file = $target_dir . basename($_FILES['imagen']['name']);
        
        // Mover la imagen a la carpeta de uploads
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            $imagen_path = "uploads/" . basename($_FILES['imagen']['name']);  // Guardamos la ruta de la imagen
            $mime_type = mime_content_type($target_file);  // Capturamos el tipo MIME real de la imagen
            echo "Imagen subida correctamente: " . $imagen_path . "<br>";
            echo "Tipo MIME de la imagen: " . $mime_type . "<br>";
        } else {
            echo "Error subiendo la imagen.<br>";
        }
    }

    // Procesar el video si se ha subido
    if (!empty($_FILES['video']['name'])) {
        $target_dir = "../uploads/";  // Directorio de destino para los videos
        $target_file = $target_dir . basename($_FILES['video']['name']);
        
        // Mover el video a la carpeta de uploads
        if (move_uploaded_file($_FILES['video']['tmp_name'], $target_file)) {
            $video_path = "uploads/" . basename($_FILES['video']['name']);  // Guardamos la ruta del video
            $mime_type = mime_content_type($target_file);  // Capturamos el tipo MIME real del video
            echo "Video subido correctamente: " . $video_path . "<br>";
            echo "Tipo MIME del video: " . $mime_type . "<br>";
        } else {
            echo "Error subiendo el video.<br>";
        }
    }

    // Usar consultas preparadas para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO comentarios (texto, imagen, mime_type, fijado) VALUES (?, ?, ?, ?)");

    // Verificar si se subió imagen o video, y guardar en la base de datos
    if (!empty($imagen_path) && !empty($video_path)) {
        // Si se suben tanto imagen como video, guardamos solo el video y el mime_type correspondiente
        $stmt->bind_param("sssi", $texto, $video_path, $mime_type, $fijar);
    } else if (!empty($imagen_path)) {
        // Solo se sube imagen
        $stmt->bind_param("sssi", $texto, $imagen_path, $mime_type, $fijar);
    } else if (!empty($video_path)) {
        // Solo se sube video
        $stmt->bind_param("sssi", $texto, $video_path, $mime_type, $fijar);
    } else {
        // No se sube ni imagen ni video
        $mime_type = 'text';  // Establecer un valor predeterminado para mime_type
        $stmt->bind_param("ssi", $texto, $mime_type, $fijar);  // Pasar valor predeterminado
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Nuevo comentario guardado con éxito.<br>";
        $stmt->close();  // Cerrar la consulta preparada
    } else {
        echo "Error al insertar en la base de datos: " . $stmt->error . "<br>";
    }

    $conn->close();
}
?>









