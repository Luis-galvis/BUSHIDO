<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Matrícula</title>
    <link rel="stylesheet" href="../css_admin/main_Ad.css">
    <link rel="stylesheet" href="../css_admin/matricula.css">
    <link rel="shortcut icon" href="../fotos/bushido-removebg-preview-removebg-preview-removebg-preview.png">
</head>
<body>
    <header class="Header">
        <div class="left-links">
            <ul class="nav-links">
                <li><a href="main_ad.html">Inicio</a></li>
                <li><a href="tarifas_ac.html">Grupos y accesorios</a></li>
                <li><a href="rango.php">rango </a></li>
                <li><a href="matricula.html">Matrícula</a></li>
            </ul>
        </div>
        <div class="logo">
            <a href="../html_admin/main_ad.html"><img src="../fotos/nuevobushido.png" alt="Logo de la marca"></a>
        </div>
        <div class="right-links">
            <ul class="nav-links">
                <li><a href="act_matri.html">Actualizar matrícula</a></li>
                <li><a href="pagos.html">Pagos</a></li>
                <li><a href="comentariosad.html">Información</a></li>
                <li><a href="asistencia.html">Asistencia</a></li>
                <li><a href="../html_usuario/index.html">Salir</a></li>
            </ul>
        </div>
    </header>
    <a class="titulo2" href="../html_admin/matriculaacudi.html">VOLVER</a>

    <form class="form" id="contactMatricula" action="../php/insertar_matricula.php" method="POST" enctype="multipart/form-data">
        <div id="mi-div" class="mformulario2">
            <input type="hidden" name="id_usuario" value="<?php echo $_GET['id_usuario']; ?>">
            <input type="hidden" name="id_acudiente" value="<?php echo $_GET['id_acudiente']; ?>">

            <label>
                <span>Paz y Salvo</span>
                <input required type="file" name="paz_salvo" class="input">
            </label>
            <label>
                <span>Certificado de Rango</span>
                <input required type="file" name="certificado_rango" class="input">
            </label>
            <label>
                <span>Hora de Matrícula</span>
                <input required type="time" name="hora_matricula" class="input">
            </label>
            <label>
                <span>Fecha de Matrícula</span>
                <input required type="date" name="fecha_matricula" class="input">
            </label>

            <!-- Grupo -->
<!-- Grupo -->
<label>
    <span>Grupo</span>
    <select required name="id_crear_grupos" class="input">
        <?php
        include '../php/bd.php';
        $result = $conn->query("SELECT id_crear_grupos, nombre_grupo, horario, codigo FROM creacion_de_grupos");
        
        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Seleccione grupo</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_crear_grupos']}'>{$row['nombre_grupo']} - {$row['horario']} - {$row['codigo']}</option>";
            }
        } else {
            echo "<option value='' disabled>No hay grupos disponibles</option>";
        }
        ?>
    </select>
</label>

<!-- Rango -->
<label>
    <span>Rango</span>
    <select required name="id_rango" class="input">
        <?php
        $result2 = $conn->query("SELECT id_rango, nombre, codigo FROM rango");

        if ($result2->num_rows > 0) {
            echo "<option value='' disabled selected>Seleccione rango</option>";
            while ($row = $result2->fetch_assoc()) {
                echo "<option value='{$row['id_rango']}'>{$row['nombre']} - {$row['codigo']}</option>";
            }
        } else {
            echo "<option value='' disabled>No hay rangos disponibles</option>";
        }

        $conn->close();
        ?>
    </select>
</label>

<button class="button2" type="submit">Registrar Matrícula</button>

        </div>
    </form>

</body>
</html>
