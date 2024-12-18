<?php
include('bd.php'); // Archivo de conexión a la base de datos.

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener la ruta del archivo y su tipo MIME.
    $stmt = $conn->prepare("SELECT mime_type, imagen FROM comentarios WHERE id_comentarios = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($mime_type, $ruta);
        $stmt->fetch();

        // Verificar si el archivo realmente existe.
        if (file_exists("../" . $ruta)) {
            // Configurar encabezados HTTP para el archivo.
            if (!headers_sent()) {
                header("Content-Type: $mime_type");
                header("Content-Disposition: inline; filename=" . basename($ruta));
                header("Content-Length: " . filesize("../" . $ruta));
            }

            // Leer y enviar el contenido del archivo.
            readfile("../" . $ruta);
        } else {
            // Error si el archivo no se encuentra.
            http_response_code(404);
            echo "Archivo no encontrado en el servidor.";
        }
    } else {
        // Error si no se encuentra el ID en la base de datos.
        http_response_code(404);
        echo "Registro no encontrado.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Error si no se proporciona el parámetro 'id'.
    http_response_code(400);
    echo "ID no especificado.";
}


