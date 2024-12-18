<?php
// Incluir el archivo de conexión a la base de datos
include 'bd.php';

// Incluir el archivo de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Ajusta esta ruta según sea necesario

// Habilitar la visualización de errores para detectar problemas
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario enviados por POST
    $tipo_documento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $lugar_expedicion = $_POST['lugar_expedicion'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_naci = $_POST['fecha_naci'];
    $genero = $_POST['genero'];
    $direccion = $_POST['direccion'];
    $numero_tel = $_POST['numero_tel'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $talla = $_POST['talla'];
    $eps = $_POST['eps'];
    $medicina_pregada = $_POST['medicina_pregada'];
    $regimen_especial = $_POST['regimen_especial'];
    $sufre_enfermedad = $_POST['sufre_enfermedad'];
    $sufre_alergias = $_POST['sufre_alergias'];
    $toma_medicamentos = $_POST['toma_medicamentos'];
    $lesiones = $_POST['lesiones'];
    $recomendacion_medica = $_POST['recomendacion_medica'];
    $grupo_sanguineo = $_POST['grupo_sanguineo'];
    $antecedentes_familiares = $_POST['antecedentes_familiares'];
    $rol = $_POST['rol'];

    // Generar una contraseña aleatoria
    $password = bin2hex(random_bytes(8)); // Genera una contraseña aleatoria de 16 caracteres hexadecimales

    // Cifrar la contraseña generada con password_hash
    $contraseña_cifrada = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar datos en la tabla 'usuarios'
    $sql = "INSERT INTO usuarios (tipo_documento, documento, lugar_expedicion, nombre, apellidos, fecha_naci, genero, direccion, numero_tel, correo, edad, peso, talla, eps, medicina_pregada, regimen_especial, sufre_enfermedad, sufre_alergias, toma_medicamentos, lesiones, recomendacion_medica, grupo_sanguineo, antecedentes_familiares, rol, contraseña) 
            VALUES ('$tipo_documento', '$documento', '$lugar_expedicion', '$nombre', '$apellidos', '$fecha_naci', '$genero', '$direccion', '$numero_tel', '$correo', '$edad', '$peso', '$talla', '$eps', '$medicina_pregada', '$regimen_especial', '$sufre_enfermedad', '$sufre_alergias', '$toma_medicamentos', '$lesiones', '$recomendacion_medica', '$grupo_sanguineo', '$antecedentes_familiares', '$rol', '$contraseña_cifrada')";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql) === TRUE) {
        // Obtener el ID del último usuario insertado
        $id_usuario = $conn->insert_id;

        // Asegurarse de que id_usuario no esté vacío y redirigir a la página de matrícula de acudiente
        if ($id_usuario) {
            // Configurar PHPMailer
            $mail = new PHPMailer(true);
            
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Usar el servidor SMTP de tu elección
                $mail->SMTPAuth = true;
                $mail->Username = 'lgalvismoreno@gmail.com'; // Tu dirección de correo electrónico
                $mail->Password = 'jrtz ootg wbki foth'; // Tu contraseña de correo
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Destinatario
                $mail->setFrom('lgalvismoreno@gmail.com', 'Bushidojo'); // Dirección de quien envía el correo
                $mail->addAddress($correo, $nombre . ' ' . $apellidos); // Dirección del destinatario
                
                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Bienvenido a Bushidojo';
                $mail->Body    = "Hola $nombre $apellidos,<br><br>Gracias por registrarte en Bushidojo. Tu cuenta ha sido creada exitosamente. A continuación, te proporcionamos tu contraseña para que inicies sesión:<br><br><b>Contraseña: $password</b><br><br>Por favor, cambia esta contraseña una vez que hayas iniciado sesión.<br><br>Saludos,<br>El equipo de Bushidojo.";

                // Enviar el correo
                $mail->send();
                echo "Correo enviado con éxito a $correo.";
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }

            // Redirigir a la página de matrícula de acudiente y pasar el id_usuario a través de la URL
            header("Location: ../html_admin/matriculaacudi.php?id_usuario=" . $id_usuario);
            exit();
            
        } else {
            // Si no se obtuvo un id_usuario, mostrar un mensaje de error
            echo "Error al obtener el ID del usuario.";
            error_log("Error al obtener el ID del usuario después de la inserción.");
        }
    } else {
        // Mostrar error si la consulta falla
        echo "Error: " . $sql . "<br>" . $conn->error;
        error_log("Error al insertar en la base de datos: " . $conn->error);
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>
