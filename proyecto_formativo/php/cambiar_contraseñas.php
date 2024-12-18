<?php
// Incluir archivo de conexión a la base de datos
include 'bd.php'; // Ajusta la ruta si es necesario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las contraseñas del formulario
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Obtener el número de documento y lugar de expedición del formulario
    $documento = $_POST['documento'];
    $lugar_expedicion = $_POST['lugar_expedicion'];

    // Verificar si las contraseñas coinciden
    if ($nueva_contraseña !== $confirmar_contraseña) {
        echo "Las contraseñas no coinciden.";
        return;
    }

    // Validar que la nueva contraseña tenga al menos 8 caracteres
    if (strlen($nueva_contraseña) < 8) {
        echo "La contraseña debe tener al menos 8 caracteres.";
        return;
    }

    // Verificar que el documento y lugar de expedición coincidan con los datos del usuario
    $sql = "SELECT * FROM usuarios WHERE documento = '$documento' AND lugar_expedicion = '$lugar_expedicion'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // El documento y lugar de expedición coinciden, procedemos a cambiar la contraseña

        // Cifrar la nueva contraseña
        $nueva_contraseña_cifrada = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

        // Obtener el ID del usuario para actualizar la contraseña
        $usuario = $resultado->fetch_assoc();
        $usuario_id = $usuario['id_usuario'];

        // Actualizar la contraseña en la base de datos
        $sql_update = "UPDATE usuarios SET contraseña = '$nueva_contraseña_cifrada' WHERE id_usuario = $usuario_id";

        if ($conn->query($sql_update) === TRUE) {
            echo "Contraseña actualizada correctamente.";
        } else {
            echo "Error al actualizar la contraseña: " . $conn->error;
        }
    } else {
        echo "El número de documento o el lugar de expedición no coinciden con los registros.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
