<?php
include '../php/bd.php';

// Habilitar la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicializar variables
$filtro_anio = isset($_GET['filtro_anio']) ? $_GET['filtro_anio'] : date('Y');  // Año seleccionado por el usuario

// Consultar matrícula y grupo del usuario
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Consultar matrícula y grupo del usuario
    $consultaMatricula = $conn->prepare("SELECT m.id_matricula, m.id_crear_grupos, g.precio, m.fecha_matricula
        FROM matricula m
        JOIN creacion_de_grupos g ON m.id_crear_grupos = g.id_crear_grupos
        WHERE m.id_usuario = ?");
    $consultaMatricula->bind_param("i", $id_usuario);
    $consultaMatricula->execute();
    $resultado = $consultaMatricula->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $id_matricula = $fila['id_matricula'];
        $id_crear_grupos = $fila['id_crear_grupos'];
        $precio = intval($fila['precio']); // Convertir el precio a entero
        $fecha_matricula = new DateTime($fila['fecha_matricula']);
    } else {
        echo "No se encontró matrícula para este usuario.";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css_admin/main_Ad.css">
    <link rel="stylesheet" href="../css_admin/pagos.css">
    <link rel="shortcut icon" href="../fotos/bushido-removebg-preview-removebg-preview-removebg-preview.png">
    <title>Inicio Admin</title>
</head>
<body>
    <header class="Header">
        <div class="left-links">    
            <ul class="nav-links">
                <li><a href="main_ad.html">Inicio</a></li>
                <li><a href="tarifas_ac.html">Grupos y accesorios</a></li>
                <li><a href="rango.php">Rango</a></li>
                <li><a href="matricula.html">Matricula</a></li>
            </ul>
        </div>
        <div class="logo">
            <a href="../html_admin/main_ad.html"><img src="../fotos/nuevobushido.png" alt="Logo de la marca"></a>
        </div>
        <div class="right-links">
            <ul class="nav-links">
                <li><a href="act_matri.html">Actualizar Matricula</a></li>
                <li><a href="pagos.html">Pagos</a></li>
                <li><a href="comentariosad.html">Informacion</a></li>
                <li><a href="asistencia.html">Asistencia</a></li>
                <li><a href="../html_usuario/index.html">Salir</a></li>
            </ul>
        </div>
    </header>

    <!-- Filtro por Año -->
    <form method="GET">
        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
        <label for="filtro_anio">Filtrar por año:</label>
        <select name="filtro_anio" id="filtro_anio" onchange="this.form.submit()">
            <?php
            // Mostrar los años desde el año de matrícula hasta el año actual + 5
            $anos = range(date('Y'), date('Y') + 5);  // Ajusta los años según sea necesario
            foreach ($anos as $anio):
            ?>
                <option value="<?php echo $anio; ?>" <?php echo ($filtro_anio == $anio) ? 'selected' : ''; ?> >
                    <?php echo $anio; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Mostrar pagos -->
    <form action="../php/guardar_pagos.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
        <input type="hidden" name="id_matricula" value="<?php echo $id_matricula; ?>">
        <input type="hidden" name="id_crear_grupos" value="<?php echo $id_crear_grupos; ?>">
        
        <table border="1">
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Año</th>
                    <th>Mes</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
            

                <?php
                // Generar pagos dinámicamente dentro de la tabla solo para el año seleccionado
                $fecha_actual = clone $fecha_matricula; // Comienza desde la fecha de matrícula              
                $anio_seleccionado = (int)$filtro_anio;

                // Obtener el último pago realizado para continuar la secuencia
                $consultaUltimoPago = $conn->prepare("
                SELECT anio, mes, MAX(fecha_pago) AS ultima_fecha
                FROM guardar_pagos 
                WHERE id_usuario = ? AND id_matricula = ?
                GROUP BY anio, mes
                ORDER BY ultima_fecha DESC LIMIT 1");
            $consultaUltimoPago->bind_param("ii", $id_usuario, $id_matricula);
            $consultaUltimoPago->execute();
            $resultadoUltimoPago = $consultaUltimoPago->get_result();

            if ($resultadoUltimoPago->num_rows > 0) {
                $ultimoPago = $resultadoUltimoPago->fetch_assoc();
                $ultimaFechaPago = new DateTime($ultimoPago['ultima_fecha']);
                $fecha_actual = clone $ultimaFechaPago; // Comienza desde la fecha del último pago
                $fecha_actual->modify('first day of next month');
                    }
                    // Si el último pago es en el año seleccionado, comenzamos desde el siguiente mes
                    elseif ($fecha_actual->format('Y') == $anio_seleccionado) {

                    }
                else {
                    // Si no hay pagos anteriores, comienza desde la fecha de matrícula
                    $fecha_actual = new DateTime("$anio_seleccionado-01-24");
                }

                // Generar los pagos solo para el año seleccionado y los años siguientes
                $meses_generados = 0;
                while (($fecha_actual->format('Y') == $anio_seleccionado || $fecha_actual->format('Y') > $anio_seleccionado) && $meses_generados < 12) {
                    $anio = $fecha_actual->format('Y');
                    $mes = str_pad($fecha_actual->format('m'), 2, '0', STR_PAD_LEFT);

                    // Consultar estado del pago
                    $consultaPago = $conn->prepare("
                        SELECT estado 
                        FROM guardar_pagos 
                        WHERE id_usuario = ? AND id_matricula = ? AND id_crear_grupos = ? AND anio = ? AND mes = ?");
                    $consultaPago->bind_param("iiiii", $id_usuario, $id_matricula, $id_crear_grupos, $anio, $mes);
                    $consultaPago->execute();
                    $resultadoPago = $consultaPago->get_result();
                    $estado = ($resultadoPago->num_rows > 0) ? $resultadoPago->fetch_assoc()['estado'] : "pendiente";

                    // Calcular las fechas de inicio y fin
                    $fecha_inicio = clone $fecha_actual; // Fecha de inicio
                    $fecha_fin = (clone $fecha_actual)->modify('+29 days'); // Fecha de fin, 30 días después

                    // Asignar monto correctamente
                    $monto = floatval($precio); // Aseguramos que el monto es un float

                    // Mostrar cada fila dentro de la tabla
                    echo '<tr>';
                    echo '<td>';
                    // Verifica si ya está marcado, de lo contrario, muestra el checkbox
                    if ($estado === 'pagado') {
                        echo '<input type="checkbox" name="pagos[' . $anio . '-' . $mes . ']" value="' . $monto . '" id="pago_' . $anio . '-' . $mes . '" disabled checked>';
                    } else {
                        echo '<input type="checkbox" name="pagos[' . $anio . '-' . $mes . ']" value="' . $monto . '" id="pago_' . $anio . '-' . $mes . '">';
                    }
                    echo '</td>';
                    echo '<td>' . $anio . '</td>';
                    echo '<td>' . $mes . '</td>';
                    echo '<td>' . $fecha_inicio->format('Y-m-d') . '</td>';
                    echo '<td>' . $fecha_fin->format('Y-m-d') . '</td>';
                    echo '<td>' . number_format($monto, 2, ',', '.') . '</td>';
                    echo '<td>' . $estado . '</td>';
                    echo '</tr>';

                    // Avanzar al siguiente mes
                    $fecha_actual->modify('+1 month');
                    $meses_generados++;
                }
                ?>
            </tbody>
        </table>

        <button type="submit">Guardar pagos seleccionados</button>
    </form>

</body>
</html>
