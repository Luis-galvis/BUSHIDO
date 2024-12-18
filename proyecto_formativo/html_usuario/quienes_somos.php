<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quiénes somos? - Bushido Dojo</title>
    <link rel="shortcut icon" href="../fotos/bushido-removebg-preview-removebg-preview-removebg-preview.png">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/quienessomos.css">
</head>
<body>
<header class="Header">
  <div class="left-links">
    <ul class="nav-links left-nav">
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
    <ul class="nav-links right-nav">
      <li><a href="dotacion.php">Dotación</a></li>
      <li><a href="iniciose.html">Usuarios</a></li>
      <li><a href="contacto.html">Contacto</a></li>
    </ul>
  </div>

  <!-- Input Checkbox para el menú hamburguesa -->
  <input id="checkbox" type="checkbox">
  <label class="toggle" for="checkbox">
    <div id="bar1" class="bars"></div>
    <div id="bar2" class="bars"></div>
    <div id="bar3" class="bars"></div>
  </label>
</header>


<main>
    <!-- Sección ¿Quiénes somos? -->
    <section id="quienes-somos">
        <h1>SOMOS....</h1>
        <div class="content">
            <div class="texto1">
                <p>En Bushido Dojo, nuestra misión es impartir los valores del Karate: disciplina, respeto y superación personal. Nuestro equipo de senseis altamente capacitados guía a estudiantes de todas las edades en su viaje hacia la excelencia marcial.</p>
            </div>
        </div>
    </section>
        <div class="card">
          <div class="card-inner">
            <div class="card-front">
             <img src="../fotos/se1.jpeg" alt="">
            </div>
            <div class="card-back">
              <p>Back Side</p>
            </div>
          </div>
        </div>
        <div class="card2">
            <div class="card-inner2">
              <div class="card-front2">
               <img src="../fotos/se2.jpeg" alt="">
              </div>
              <div class="card-back2">
                <p>Back Side</p>
              </div>
            </div>
          </div>
          <div class="card3">
            <div class="card-inner3">
              <div class="card-front3">
               <img src="../fotos/se3.jpeg" alt="">
              </div>
              <div class="card-back3">
                <p>Back Side</p>
              </div>
            </div>
          </div>
          <?php include('../php/get_slides.php'); ?>
          
<script src="../js/quienessomos.js"></script>
</main>

</body>
</html>
