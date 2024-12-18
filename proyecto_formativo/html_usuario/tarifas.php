<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas</title>
    <link rel="shortcut icon" href="/proyecto formativo/fotos/bushido_dojo_imagen-removebg-preview-removebg-preview.png">
    <link rel="stylesheet" href="../css/tarifas.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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
        <div class="swiper-container mySwiper">
            <div class="swiper-wrapper">
                <?php
                // Aquí va el código PHP que se generará dinámicamente los grupos
                include '../php/bd.php';
                
                // Consultar los datos de la tabla creacion_de_grupos
                $query = "SELECT id_crear_grupos, nombre_grupo, codigo, horario, precio FROM creacion_de_grupos";
                $result = $conn->query($query);
                
                // Comprobar si hay resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id_crear_grupos']);
                        $nombre = htmlspecialchars($row['nombre_grupo']);
                        $codigo = htmlspecialchars($row['codigo']);
                        $horario = htmlspecialchars($row['horario']);
                        $precio = htmlspecialchars($row['precio']);
                        echo "
                        <div class='swiper-slide'>
                            <div class='pricing-card'>
                                <h2 class='title'>{$nombre}</h2>
                                <p class='price'>\${$precio}<span>/Mensual</span></p>
                                <ul class='features'>

                                    <li>Horario: {$horario}</li>
                                    <li>Precio: \${$precio}</li>
                                </ul>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<div class='swiper-slide'><p>No hay grupos disponibles.</p></div>";
                }
        
                $conn->close();
                ?>
            </div> <!-- End swiper-wrapper -->
        
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        
            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        
        <!-- Swiper JS -->
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        
        <!-- Initialize Swiper -->
        <script src="../js/tarifas.js"></script>
        
</main>
</body>
</html>