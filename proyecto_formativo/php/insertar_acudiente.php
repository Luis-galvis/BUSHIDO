<?php
// Incluir el archivo de conexión a la base de datos
include 'bd.php';

// Habilitar la visualización de errores para detectar problemas
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el id_usuario se ha enviado correctamente desde el formulario
    if (isset($_POST['id_usuario']) && !empty($_POST['id_usuario'])) {
        $id_usuario = $_POST['id_usuario']; // Obtener el id_usuario del formulario

        // Verificar si todos los campos del formulario están presentes
        if (isset($_POST['nombre'], $_POST['apellido'], $_POST['documento_identidad'], $_POST['fecha_nacimiento'], $_POST['direccion'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['parentesco'], $_POST['ocupacion'], $_POST['empresa'], $_POST['tipo_documento'], $_POST['genero'], $_POST['lugar_expedicion'])) {
            
            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento_identidad = $_POST['documento_identidad'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo_electronico = $_POST['correo_electronico'];
            $parentesco = $_POST['parentesco'];
            $ocupacion = $_POST['ocupacion'];
            $empresa = $_POST['empresa'];
            $tipo_documento = $_POST['tipo_documento'];
            $genero = $_POST['genero'];
            $lugar_expedicion = $_POST['lugar_expedicion'];

            // Preparar la consulta SQL para insertar datos en la tabla 'acudientes'
            $sql = "INSERT INTO acudientes (nombre, apellido, documento_identidad, fecha_nacimiento, direccion, telefono, correo_electronico, parentesco, ocupacion, empresa, tipo_documento, genero, lugar_expedicion, id_usuario) 
                    VALUES ('$nombre', '$apellido', '$documento_identidad', '$fecha_nacimiento', '$direccion', '$telefono', '$correo_electronico', '$parentesco', '$ocupacion', '$empresa', '$tipo_documento', '$genero', '$lugar_expedicion', '$id_usuario')";

            // Ejecutar la consulta y verificar si fue exitosa
            if ($conn->query($sql) === TRUE) {
                // Obtener el ID del acudiente recién insertado
                $id_acudiente = $conn->insert_id;
                echo "ID del usuario y acudiente insertado: " . $id_acudiente . $id_usuario;
                // Redirigir a la página matriculamed.php con id_usuario e id_acudiente
                header("Location: ../html_admin/matriculamed.php?id_usuario=$id_usuario&id_acudiente=$id_acudiente");
                exit();
            } else {
                echo "Error al insertar acudiente: " . $conn->error;
            }

        } else {
            echo "Faltan datos en el formulario.";
            exit();
        }

    } else {
        echo "No se proporcionó id_usuario en el formulario.";
        exit();
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

} else {
    echo "Método no permitido.";
}
?>
