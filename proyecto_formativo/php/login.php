<?php
// Incluir archivo de conexión a la base de datos
include 'bd.php';
session_start(); // Inicia la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Consultar la base de datos para obtener el usuario con ese correo
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Verificar si el usuario existe
        $usuario = $resultado->fetch_assoc();
        
        // Verificar si la contraseña es correcta
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Iniciar la sesión y almacenar el ID de usuario
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['rol'] = $usuario['rol']; // Guardar el rol del usuario

            // Redirigir según el rol
            if ($usuario['rol'] == "admin") {
                header("Location: ../html_admin/main_ad.html");  // Redirigir a la página de administrador
            } elseif ($usuario['rol'] == "user") {
                header("Location: ../html_admin/mod_usu.html");  // Redirigir a la página de usuario
            } else {
                echo "Rol desconocido.";
            }
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no encontrado.";
    }
    $conn->close();
}
?>

