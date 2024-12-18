<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dotacion</title>
    <link rel="shortcut icon" href="/proyecto formativo/fotos/bushido_dojo_imagen-removebg-preview-removebg-preview.png">
    <link rel="stylesheet" href="../css/dotacion.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
   

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Buscar productos..." oninput="searchProducts()">
    </div>

    <div id="productGrid" class="product-grid">
    <?php include '../php/mostrar_dotacion.php'; ?>
</div>

    <a href="https://wa.me/1234567890" target="_blank" class="whatsapp-icon">
        <i class="fab fa-whatsapp"></i>
    </a>
    <script src="../js/dotacion.js"></script>
</body>
</html>