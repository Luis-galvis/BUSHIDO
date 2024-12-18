<?php
include '../php/bd.php';

// Verificar si se han seleccionado pagos
if (isset($_POST['pagos'])) {
    $pagosSeleccionados = $_POST['pagos']; // Obtener los pagos seleccionados

    // Procesar cada pago seleccionado
    foreach ($pagosSeleccionados as $key => $monto) {
        list($anio, $mes) = explode('-', $key); // Separar el año y mes

        // Asignar valores de estado
        $estado = 'pagado'; // Este pago ya está marcado como pagado

        // Insertar el pago en la base de datos
        $sql = "INSERT INTO guardar_pagos (id_usuario, id_matricula, id_crear_grupos, anio, mes, monto, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertarPago = $conn->prepare($sql);
        $insertarPago->bind_param("iiiiiis", $_POST['id_usuario'], $_POST['id_matricula'], $_POST['id_crear_grupos'], $anio, $mes, $monto, $estado);

        if ($insertarPago->execute()) {
            echo "Pago insertado correctamente para $anio-$mes.<br>";
        } else {
            echo "Error al insertar el pago para $anio-$mes. Error: " . $insertarPago->error . "<br>";
        }
    }

    // Redirigir o mostrar un mensaje de éxito
    echo "Pagos guardados correctamente.";
} else {
    echo "No se seleccionaron pagos para guardar.";
}
?>





