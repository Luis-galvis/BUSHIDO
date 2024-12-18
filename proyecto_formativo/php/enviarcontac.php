<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Ajusta esta ruta según sea necesario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);
    
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lgalvismoreno@gmail.com'; // Asegúrate de usar el correo completo
        $mail->Password = 'jrtz ootg wbki foth'; // Reemplaza con la contraseña de aplicación generada
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Configuración del correo
        $mail->setFrom('lgalvismoreno@gmail.com', 'Formulario de Contacto');
        $mail->addAddress('lgalvismoreno@gmail.com'); // Reemplaza con tu dirección de correo
        
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "Nombre: $name<br>Mensaje:<br>$message";
        
        $mail->send();
        echo 'El mensaje se ha enviado correctamente.';
    } catch (Exception $e) {
        echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
    }
} else {
    echo 'Método de solicitud no válido.';
}
?>




