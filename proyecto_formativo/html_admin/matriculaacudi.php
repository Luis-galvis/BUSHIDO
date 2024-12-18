<?php
// Verificar si el parámetro id_usuario está presente en la URL
if (isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
    // Guardar el valor de id_usuario
    $id_usuario = $_GET['id_usuario'];
} else {
    // Si no se encuentra el parámetro id_usuario, mostrar un mensaje de error
    echo "No se proporcionó id_usuario en la URL.";
    exit(); // Salir si no se proporciona el id_usuario
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas</title>
    <link rel="stylesheet" href="../css_admin/main_Ad.css">
    <link rel="stylesheet" href="../css_admin/matricula.css">
    <link rel="shortcut icon"
        href="../fotos/bushido-removebg-preview-removebg-preview-removebg-preview.png">

</head>

<body>
    <header class="Header">
        <div class="left-links">
            <ul class="nav-links">
                <li><a href="main_ad.html">Inicio</a></li>
                <li><a href="tarifas_ac.html">Grupos y accesorios</a></li>
                <li><a href="rango.php">rango </a></li>
                <li><a href="matricula.html">matricula</a></li>
            </ul>
        </div>
        <div class="logo">
            <a href="../html_admin/main_ad.html"><img src="../fotos/nuevobushido.png" alt="Logo de la marca"></a>
        </div>
        <div class="right-links">
            <ul class="nav-links">
                <li><a href="act_matri.html">actualizar matricula</a></li>
                <li><a href="pagos.html">pagos</a></li>
                <li><a href="comentariosad.html">Informacion</a></li>
                <li><a href="asistencia.html">asistencia</a></li>
                <li><a href="../html_usuario/index.html">salir</a></li>
            </ul>
        </div>
    </header> 


    <form class="form" action="../php/insertar_acudiente.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo $_GET['id_usuario'];  echo "ID del usuario recibido: " . $id_usuario; // Esto debería mostrar el ID del usuario recibido en el formulario
?>">
        <div class="flex"></div>
        <div id="mi-div" class="mformularios">
            <p class="p1">DATOS ACUDIENTE</p>
            <label>
                <span>Nombres</span>
                <input required placeholder="" type="text" name="nombre" class="input">
            </label>
            <label>
                <span>Apellidos</span>
                <input required placeholder="" type="text" name="apellido" class="input">
            </label>
            <label>
                <span>Tipo de Documento</span>
                <select required name="tipo_documento" class="input">
                    <option value="" disabled selected>Seleccione</option>
                    <option value="CE">Cédula</option>
                    <option value="CC">Cédula de Extranjería</option>
                </select>
            </label>
            <label>
                <span>Número de Documento</span>
                <input required placeholder="" type="number" name="documento_identidad" class="input">
            </label>
            <label>
                <span>Lugar de Expedición</span>
                <input required placeholder="" type="text" name="lugar_expedicion" class="input">
            </label>
            <label>
                <span>Ocupación</span>
                <input required placeholder="" type="text" name="ocupacion" class="input">
            </label>
            <label>
                <span>Empresa</span>
                <input required placeholder="" type="text" name="empresa" class="input">
            </label>
            <label>
                <span>Número de Teléfono</span>
                <input required placeholder="" type="number" name="telefono" class="input">
            </label>
            <label>
                <span>Dirección</span>
                <input required placeholder="" type="text" name="direccion" class="input">
            </label>
            <label>
                <span>Correo Electrónico</span>
                <input required placeholder="" type="email" name="correo_electronico" class="input">
            </label>
            <label>
                <span>Parentesco</span>
                <input required placeholder="" type="text" name="parentesco" class="input">
            </label>
            <label>
                <span>Fecha de Nacimiento</span>
                <input required placeholder="" type="date" name="fecha_nacimiento" class="input">
            </label>
            <label>
                <span>Género</span>
                <select required name="genero" class="input">
                    <option value="" disabled selected>Seleccione</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="no binario">No Binario</option>
                </select>
            </label>
            <button class="button1" type="submit">Enviar</button>
        </div>
    </form>

</body>

</html>