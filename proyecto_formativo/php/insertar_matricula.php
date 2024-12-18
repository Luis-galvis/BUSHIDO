<?php
// Incluir archivo de conexión a la base de datos
include('bd.php'); // Este archivo ya contiene la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $id_usuario = $_POST['id_usuario'];
    $id_acudiente = $_POST['id_acudiente'];
    $paz_salvo = $_FILES['paz_salvo']['name'];
    $certificado_rango = $_FILES['certificado_rango']['name'];
    $hora_matricula = $_POST['hora_matricula'];
    $fecha_matricula = $_POST['fecha_matricula'];
    $id_crear_grupos = $_POST['id_crear_grupos'];
    $id_rango = $_POST['id_rango'];

    // Carpeta donde se almacenarán los archivos
    $target_dir = "../uploads/";
    move_uploaded_file($_FILES['paz_salvo']['tmp_name'], $target_dir . $paz_salvo);
    move_uploaded_file($_FILES['certificado_rango']['tmp_name'], $target_dir . $certificado_rango);

    // Consulta SQL para insertar los datos de la matrícula en la tabla correcta
    $sql = "INSERT INTO matricula (paz_salvo, certificado_rango, hora_matricula, fecha_matricula, id_usuario, id_crear_grupos, id_rango, id_acudientes) 
            VALUES ('$paz_salvo', '$certificado_rango', '$hora_matricula', '$fecha_matricula', '$id_usuario', '$id_crear_grupos', '$id_rango', '$id_acudiente')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Matrícula guardada con éxito.";
        // Redirigir a una página de confirmación o listado
        header("Location: ../html_admin/main_ad.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
