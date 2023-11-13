<?php
session_start();
include('includes/conexion.php');
conectar();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="estilos/estilos.css" />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <nav
      class="navbar navbar-expand-lg navbar-dark p-3 bg-danger"
      id="headerNav"
    >
      <div class="container-fluid">
        <a class="navbar-brand d-block d-lg-none" href="#">
          <img src="imagenes/logo.png" height="80" />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link mx-2 active" aria-current="page" href="index.php"
                >Inicio</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link mx-2" href="index.php?modulo=box">Box de productos</a>
            </li>
            <li class="nav-item d-none d-lg-block">
              <a class="nav-link mx-2" href="#">
                <img src="imagenes/logo.png" height="100" />
              </a>
            </li>
          
          <?php
            if (!empty($_SESSION['nombre_usuario'])) {
                if ($_SESSION['roles'] == 'admin') {
                  ?>
  
                <li class="nav-item">
                  <a class="nav-link mx-2" href="index.php?modulo=tabla">Tabla de productos</a>
                </li>  
                  <?php
                } 
              else{
              ?> 
                <li class="nav-item usuarionav">
              <a class="nav-link " href="index.php?modulo=usuario_compras"> Mis compras</a>
              <a href="index.php?modulo=carrito">
              <img src="imagenes/carrito.png" alt="" width="50px">Mi carrito</a>
            </li>
            <?php
              }
            ?>
            
            <li class="nav-item usuarionav">
              <p>
                  <img src="imagenes/usuario.png" alt="" width="45px" ><?php echo $_SESSION['nombre_usuario']; ?>
              <p>
              <a href="index.php?modulo=login&salir=ok"><img src="imagenes/salir.png" alt="" width="50px">Cerrar Sesión</a>
              </p>
            </li>
           <?php   
          }else { 
              ?>
            <li class="nav-item">
              <a class="nav-link mx-2" href="index.php?modulo=registro">Registrarse</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-2" href="index.php?modulo=login">Iniciar Sesion</a>
            </li>
            <?php
            }
          
            ?>
          </ul>  
        </div>
      </div>
    </nav>
    <main>
    <?php

      if (!empty($_GET['modulo'])) {
        include('modulos/' . $_GET['modulo'] . '.php');
      } else {
      ?>
      <div class="carousel" data-gap="20">
        <h2>Envios nacionales</h2>
        <h2>Tu mejor tienda musical</h2>
        <h1>Discos más vendidos</h1>
        <figure>
          <img src="imagenes/vinilo1.png" alt="imagen 1" />
          <img src="imagenes/vinilo2.png" alt="imagen 2" />
          <img src="imagenes/vinilo3.png" alt="imagen 3" />
          <img src="imagenes/vinilo4.png" alt="imagen 4" />
          <img src="imagenes/vinilo5.png" alt="imagen 5" />
          <img src="imagenes/vinilo6.jpg" alt="imagen 6" />
          <img src="imagenes/vinilo7.jpg" alt="imagen 7" />
        </figure>
        <nav>
          <button class="nav prev"><</button>
          <button class="nav next">></button>
        </nav>
      </div>
      <div class="container my-5">
        <div class="container p-4">
        <h1>Canción del mes</h1>
          <section class="">
            <div class="row d-flex justify-content-center">
              <div class="col-lg-6">
                <div class="ratio ratio-16x9">
                  <iframe
                    width="1060"
                    height="795"
                    src="https://www.youtube.com/embed/pFg0FCx4FGs?autoplay=1&controls=0"
                    title="Bee Gees - How Deep Is Your Love (Live in Las Vegas, 1997 - One Night Only)"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                  ></iframe>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <?php
      } 
      ?>
    </main>
    <footer class="text-center text-black">
      <div class="text-center p-3" style="color: black">
        © 2023 Copyright:
        <a class="text-black" href="#" style="color: black">UMBRA</a>
      </div>
      <section class="mb-4">
        <!-- Facebook -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-facebook-f">Facebook</i></a
        >
        <!-- Instagram -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-instagram">Instagram</i></a
        >
        <!-- Linkedin -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-linkedin">Linkedin</i></a
        >
        <!-- Github -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="https://github.com/Lucianojrd"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-github">Github</i></a
        >
      </section>
    </footer>
  </body>
  <script src="app/app.js"></script>
</html>
    