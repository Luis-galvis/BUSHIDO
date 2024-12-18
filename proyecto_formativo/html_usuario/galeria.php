<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bushido Dojo</title>
    <link rel="shortcut icon" href="../fotos/bushido-removebg-preview-removebg-preview-removebg-preview.png">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/galeria.css">


</head>
<body>
    <header class="Header">
        <div class="left-links">
            <ul class="nav-links">
            <li><a href="quienes_somos.php">¿Quiénes somos?</a></li>
            <li><a href="cinturones.html">Cinturones</a></li>
                <li><a href="tarifas.php">Tarifas</a></li>
                <li><a href="galeria.php">Galeria</a></li>
            </ul>
        </div>

        <div class="logo">
            <a href="../html_usuario/index.html"><img src="../fotos/nuevobushido.png" alt="Logo de la marca"></a>
        </div>

        <div class="right-links">
            <ul class="nav-links">
                <li><a href="dotacion.php">Dotación</a></li>
                <li><a href="iniciose.html">Usuarios</a></li>
                <li><a href="contacto.html">Contacto</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div class="image1">

        <h1>GALERIA BUSHIDO</h1>
        </div>

    <div id="productGrid" class="product-grid">
    <?php include '../php/mostrar_galeria.php'; ?>
</div>

        
    </main>
</body>

</html>