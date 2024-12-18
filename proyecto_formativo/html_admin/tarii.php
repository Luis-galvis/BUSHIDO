<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesorios</title>
    <link rel="stylesheet" href="../css_admin/main_Ad.css">
    <link rel="stylesheet" href="../css_admin/tarii.css">
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

    <div class="container">
        <div class="header">
            <h1>grupos</h1>
        </div>

        <table id="gruposTable">
    <thead>
        <tr>
            <th>Nombre del Grupo</th>
            <th>Código</th>
            <th>Horario</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php include '../php/obtener_grupos.php'; // Incluir el código PHP anterior ?>
    </tbody>
</table>


        <!-- Ventana emergente para editar -->
<!-- Popup de edición -->
<div id="editPopup" class="popup">
    <div class="popup-content">
        <h3>Editar Grupo</h3>
        <label for="groupName">Nombre del Grupo</label>
        <input type="text" id="groupName" name="groupName" required>

        <label for="groupCode">Código</label>
        <input type="text" id="groupCode" name="groupCode" required>

        <label for="groupSchedule">Horario</label>
        <input type="text" id="groupSchedule" name="groupSchedule" required>

        <label for="groupPrice">Precio</label>
        <input type="number" id="groupPrice" name="groupPrice" required>

        <input type="hidden" id="groupId" name="groupId">

        <button type="button" onclick="saveGroup()">Guardar</button>
        <button type="button" onclick="closeEditPopup()">Cerrar</button>
    </div>
</div>

    </div>

    <script src="../js/tarii.js"></script>
</body>

</html>