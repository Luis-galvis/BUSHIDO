<?php
ob_start(); // Inicia el almacenamiento en búfer de salida
include('../php/bd.php');

// Obtener id_usuario desde POST o GET
$id_usuario = $_POST['id_usuario'] ?? $_GET['id_usuario'] ?? null;
if (!$id_usuario) {
    die("ID de usuario no especificado.");
}

// Consultar datos de usuario, acudiente y matrícula
$query_usuario = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = mysqli_prepare($conn, $query_usuario);
mysqli_stmt_bind_param($stmt_usuario, 'i', $id_usuario);
mysqli_stmt_execute($stmt_usuario);
$result_usuario = mysqli_stmt_get_result($stmt_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

$query_acudiente = "SELECT * FROM acudientes WHERE id_usuario = ?";
$stmt_acudiente = mysqli_prepare($conn, $query_acudiente);
mysqli_stmt_bind_param($stmt_acudiente, 'i', $id_usuario);
mysqli_stmt_execute($stmt_acudiente);
$result_acudiente = mysqli_stmt_get_result($stmt_acudiente);
$acudiente = mysqli_fetch_assoc($result_acudiente);

$query_matricula = "SELECT * FROM matricula WHERE id_usuario = ?";
$stmt_matricula = mysqli_prepare($conn, $query_matricula);
mysqli_stmt_bind_param($stmt_matricula, 'i', $id_usuario);
mysqli_stmt_execute($stmt_matricula);
$result_matricula = mysqli_stmt_get_result($stmt_matricula);
$matricula = mysqli_fetch_assoc($result_matricula);

// Verificar los datos recibidos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST); // Para depurar los datos recibidos del formulario

    try {
        mysqli_begin_transaction($conn);

        // Actualizar usuarios
        $query_update_usuario = "UPDATE usuarios SET 
                                    nombre = ?, apellidos = ?, documento = ?, tipo_documento = ?, 
                                    edad = ?, direccion = ?, numero_tel = ?, lugar_expedicion = ?, 
                                    fecha_naci = ?, correo = ?, eps = ?, peso = ?, talla = ?, 
                                    genero = ?, lesiones = ?, recomendacion_medica = ?, 
                                    regimen_especial = ?, medicina_pregada = ?, grupo_sanguineo = ?, 
                                    antecedentes_familiares = ?, sufre_enfermedad = ?, 
                                    sufre_alergias = ?, toma_medicamentos = ?, rol = ? 
                                  WHERE id_usuario = ?";
        $stmt_update_usuario = mysqli_prepare($conn, $query_update_usuario);
        mysqli_stmt_bind_param($stmt_update_usuario, 'ssssisssssssssssssssssssi', 
            $_POST['nombre_usuario'], $_POST['apellidos_usuario'], $_POST['documento_usuario'], 
            $_POST['tipo_documento'], $_POST['edad'], $_POST['direccion_usuario'], 
            $_POST['telefono_usuario'], $_POST['lugar_expedicion'], $_POST['fecha_naci'], 
            $_POST['correo_usuario'], $_POST['eps'], $_POST['peso'], $_POST['talla'], 
            $_POST['genero'], $_POST['lesiones'], $_POST['recomendacion_medica'], 
            $_POST['regimen_especial'], $_POST['medicina_pregada'], $_POST['grupo_sanguineo'], 
            $_POST['antecedentes_familiares'], $_POST['sufre_enfermedad'], $_POST['sufre_alergias'], 
            $_POST['toma_medicamentos'], $_POST['rol'], $id_usuario);
        if (!mysqli_stmt_execute($stmt_update_usuario)) {
            throw new Exception("Error al actualizar el usuario: " . mysqli_stmt_error($stmt_update_usuario));
        }

        // Actualizar acudientes
        $query_update_acudiente = "UPDATE acudientes SET 
                                    nombre = ?, apellido = ?, documento_identidad = ?, 
                                    telefono = ?, correo_electronico = ?, parentesco = ? 
                                  WHERE id_usuario = ?";
        $stmt_update_acudiente = mysqli_prepare($conn, $query_update_acudiente);
        mysqli_stmt_bind_param($stmt_update_acudiente, 'ssssssi', 
            $_POST['nombre_acudiente'], $_POST['apellido_acudiente'], $_POST['documento_identidad'], 
            $_POST['telefono_acudiente'], $_POST['correo_acudiente'], $_POST['parentesco'], $id_usuario);
        if (!mysqli_stmt_execute($stmt_update_acudiente)) {
            throw new Exception("Error al actualizar el acudiente: " . mysqli_stmt_error($stmt_update_acudiente));
        }

        // Actualizar matrícula
        $query_update_matricula = "UPDATE matricula SET 
                                    fecha_matricula = ?, hora_matricula = ?, paz_salvo = ?, 
                                    certificado_rango = ?, id_crear_grupos = ?, id_rango = ?, 
                                    id_acudientes = ? 
                                  WHERE id_usuario = ?";
        $stmt_update_matricula = mysqli_prepare($conn, $query_update_matricula);
        mysqli_stmt_bind_param($stmt_update_matricula, 'sssssssi', 
            $_POST['fecha_matricula'], $_POST['hora_matricula'], $_POST['paz_salvo'], 
            $_POST['certificado_rango'], $_POST['id_crear_grupos'], $_POST['id_rango'], 
            $_POST['id_acudientes'], $id_usuario);
        if (!mysqli_stmt_execute($stmt_update_matricula)) {
            throw new Exception("Error al actualizar la matrícula: " . mysqli_stmt_error($stmt_update_matricula));
        }

        // Confirmar transacción
        mysqli_commit($conn);

        header("Location: ../html_admin/act_matri.html");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}

ob_end_flush(); // Finaliza el almacenamiento en búfer
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css_admin/main_Ad.css">
    <link rel="stylesheet" href="../css_admin/matriculaactu.css">
    <title>Actualizar Matrícula</title>
</head>
<body>
    <header class="Header">
        <div class="left-links">
            <ul class="nav-links">
                <li><a href="main_ad.html">Inicio</a></li>
                <li><a href="tarifas_ac.html">Grupos y accesorios</a></li>
                <li><a href="rango.php">Rango</a></li>
                <li><a href="matricula.html">Matrícula</a></li>
            </ul>
        </div>
        <div class="logo">
            <a href="main_ad.html"><img src="../fotos/nuevobushido.png" alt="Logo"></a>
        </div>
        <div class="right-links">
            <ul class="nav-links">
                <li><a href="act_matri.html">Actualizar Matrícula</a></li>
                <li><a href="pagos.html">Pagos</a></li>
                <li><a href="comentariosad.html">Información</a></li>
                <li><a href="asistencia.html">Asistencia</a></li>
                <li><a href="../html_usuario/index.html">Salir</a></li>
            </ul>
        </div>
    </header>

    <div id="mi-div" class="mformulario1">
    <form action="formulario_matricula.php" id="contactmatri" method="POST" enctype="multipart/form-data">
        <!-- Información del Usuario -->
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">

        <h3>Información del Usuario</h3>
        <label for="nombre_usuario">Nombre:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br>

        <label for="apellidos_usuario">Apellidos:</label>
        <input type="text" id="apellidos_usuario" name="apellidos_usuario" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required><br>

        <label for="documento_usuario">Documento:</label>
        <input type="number" id="documento_usuario" name="documento_usuario" value="<?= htmlspecialchars($usuario['documento']) ?>" required><br>

        <label for="tipo_documento">Tipo de Documento:</label>
        <input type="text" id="tipo_documento" name="tipo_documento" value="<?= htmlspecialchars($usuario['tipo_documento']) ?>" required><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?= htmlspecialchars($usuario['edad']) ?>" required><br>

        <label for="direccion_usuario">Dirección:</label>
        <input type="text" id="direccion_usuario" name="direccion_usuario" value="<?= htmlspecialchars($usuario['direccion']) ?>" required><br>

        <label for="telefono_usuario">Número de Teléfono:</label>
        <input type="text" id="telefono_usuario" name="telefono_usuario" value="<?= htmlspecialchars($usuario['numero_tel']) ?>"><br>

        <label for="lugar_expedicion">Lugar de Expedición:</label>
        <input type="text" id="lugar_expedicion" name="lugar_expedicion" value="<?= htmlspecialchars($usuario['lugar_expedicion']) ?>"><br>

        <label for="fecha_naci">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_naci" name="fecha_naci" value="<?= htmlspecialchars($usuario['fecha_naci']) ?>" required><br>

        <label for="correo_usuario">Correo Electrónico:</label>
        <input type="email" id="correo_usuario" name="correo_usuario" value="<?= htmlspecialchars($usuario['correo']) ?>" required><br>

        <label for="eps">EPS:</label>
        <input type="text" id="eps" name="eps" value="<?= htmlspecialchars($usuario['eps']) ?>" required><br>

        <label for="peso">Peso:</label>
        <input type="number" id="peso" name="peso" value="<?= htmlspecialchars($usuario['peso']) ?>" required><br>

        <label for="talla">Talla:</label>
        <input type="text" id="talla" name="talla" value="<?= htmlspecialchars($usuario['talla']) ?>" required><br>

        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($usuario['genero']) ?>" required><br>

        <label for="lesiones">Lesiones:</label>
        <input type="text" id="lesiones" name="lesiones" value="<?= htmlspecialchars($usuario['lesiones']) ?>"><br>

        <label for="recomendacion_medica">Recomendación Médica:</label>
        <input type="text" id="recomendacion_medica" name="recomendacion_medica" value="<?= htmlspecialchars($usuario['recomendacion_medica']) ?>"><br>

        <label for="regimen_especial">Régimen Especial:</label>
        <input type="text" id="regimen_especial" name="regimen_especial" value="<?= htmlspecialchars($usuario['regimen_especial']) ?>"><br>

        <label for="medicina_pregada">Medicina Pregada:</label>
        <input type="text" id="medicina_pregada" name="medicina_pregada" value="<?= htmlspecialchars($usuario['medicina_pregada']) ?>"><br>

        <label for="grupo_sanguineo">Grupo Sanguíneo:</label>
        <input type="text" id="grupo_sanguineo" name="grupo_sanguineo" value="<?= htmlspecialchars($usuario['grupo_sanguineo']) ?>"><br>

        <label for="antecedentes_familiares">Antecedentes Familiares:</label>
        <input type="text" id="antecedentes_familiares" name="antecedentes_familiares" value="<?= htmlspecialchars($usuario['antecedentes_familiares']) ?>"><br>

        <label for="sufre_enfermedad">¿Sufre Enfermedades?</label>
        <input type="text" id="sufre_enfermedad" name="sufre_enfermedad" value="<?= htmlspecialchars($usuario['sufre_enfermedad']) ?>"><br>

        <label for="sufre_alergias">¿Sufre Alergias?</label>
        <input type="text" id="sufre_alergias" name="sufre_alergias" value="<?= htmlspecialchars($usuario['sufre_alergias']) ?>"><br>

        <label for="toma_medicamentos">¿Toma Medicamentos?</label>
        <input type="text" id="toma_medicamentos" name="toma_medicamentos" value="<?= htmlspecialchars($usuario['toma_medicamentos']) ?>"><br>

        <label for="rol">Rol:</label>
        <input type="text" id="rol" name="rol" value="<?= htmlspecialchars($usuario['rol']) ?>"><br>

        <!-- Información del Acudiente -->
        <h3>Información del Acudiente</h3>
        <label for="nombre_acudiente">Nombre del Acudiente:</label>
        <input type="text" id="nombre_acudiente" name="nombre_acudiente" value="<?= htmlspecialchars($acudiente['nombre']) ?>"><br>

        <label for="apellido_acudiente">Apellido del Acudiente:</label>
        <input type="text" id="apellido_acudiente" name="apellido_acudiente" value="<?= htmlspecialchars($acudiente['apellido']) ?>"><br>

        <label for="documento_identidad">Documento de Identidad:</label>
        <input type="text" id="documento_identidad" name="documento_identidad" value="<?= htmlspecialchars($acudiente['documento_identidad']) ?>"><br>

        <label for="telefono_acudiente">Teléfono:</label>
        <input type="text" id="telefono_acudiente" name="telefono_acudiente" value="<?= htmlspecialchars($acudiente['telefono']) ?>"><br>

        <label for="correo_acudiente">Correo Electrónico:</label>
        <input type="email" id="correo_acudiente" name="correo_acudiente" value="<?= htmlspecialchars($acudiente['correo_electronico']) ?>"><br>

        <label for="parentesco">Parentesco:</label>
        <input type="text" id="parentesco" name="parentesco" value="<?= htmlspecialchars($acudiente['parentesco']) ?>"><br>

        <!-- Información de la Matrícula -->
        <h3>Información de la Matrícula</h3>
        <label for="fecha_matricula">Fecha de Matrícula:</label>
        <input type="date" id="fecha_matricula" name="fecha_matricula" value="<?= htmlspecialchars($matricula['fecha_matricula']) ?>"><br>

        <label for="hora_matricula">Hora de Matrícula:</label>
        <input type="time" id="hora_matricula" name="hora_matricula" value="<?= htmlspecialchars($matricula['hora_matricula']) ?>"><br>

        <label for="paz_salvo">Paz y Salvo:</label>
        <input type="text" id="paz_salvo" name="paz_salvo" value="<?= htmlspecialchars($matricula['paz_salvo']) ?>"><br>

        <label for="certificado_rango">Certificado de Rango:</label>
        <input type="text" id="certificado_rango" name="certificado_rango" value="<?= htmlspecialchars($matricula['certificado_rango']) ?>"><br>

        <label for="id_crear_grupos">ID Crear Grupos:</label>
        <input type="text" id="id_crear_grupos" name="id_crear_grupos" value="<?= htmlspecialchars($matricula['id_crear_grupos']) ?>"><br>

        <label for="id_rango">ID Rango:</label>
        <input type="text" id="id_rango" name="id_rango" value="<?= htmlspecialchars($matricula['id_rango']) ?>"><br>

        <label for="id_acudientes">ID Acudiente:</label>
        <input type="text" id="id_acudientes" name="id_acudientes" value="<?= htmlspecialchars($matricula['id_acudientes']) ?>"><br>

        <button type="submit">Actualizar</button>
    </form>
</div>
</body>
</html>

