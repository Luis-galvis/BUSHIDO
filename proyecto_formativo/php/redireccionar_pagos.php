<?php
// Verificar si el id_usuario ha sido enviado
if (isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];

    // Redirigir a la página de formulario de matrícula con el id_usuario como parámetro
    header("Location: ../html_admin/pagos.php?id_usuario=$id_usuario");
    exit();
} else {
    echo "ID de usuario no proporcionado.";
}
?>