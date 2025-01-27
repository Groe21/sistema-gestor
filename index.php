<?php
include_once(__DIR__ . '/config/config.php');
include_once(__DIR__ . '/models/administrativo/obtener_padre.php');
include_once(__DIR__ . '/models/administrativo/obtener_nosotros.php');
include_once(__DIR__ . '/models/administrativo/obtener_proyectos.php');
include_once(__DIR__ . '/models/administrativo/obtener_tarjetas.php');
include_once(__DIR__ . '/models/administrativo/obtener_profesor.php');
include_once(__DIR__ . '/models/administrativo/obtener_comunicado.php');

$pdo = conectarBaseDeDatos();
$mostrarPadres = new MostrarPadres($pdo);
$mostrarNosotros = new MostrarNosotros($pdo);
$mostrarProyectos = new MostrarProyectos($pdo);
$mostrarTarjetas = new MostrarTarjetas($pdo);
$mostrarProfesores = new MostrarProfesores($pdo);
$mostrarComunicados = new MostrarComunicados($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Las Aguilas del Saber</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <link rel="icon" href="./img/logo23.ico" type="image/x-icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/fondo.css" rel="stylesheet" />
    <link href="css/padres.css" rel="stylesheet" />

    <link rel="icon" href="img/logo23.ico" type="image/x-icon">


</head>

  <body>

  <!-- Navbar Start -->
  <?php include_once(__DIR__ . '/include/pagina_principal/cabecera.php'); ?>
    <!-- Navbar End -->

    <section id="hero" class="d-flex align-items-center">
      <div class="container" data-aos="zoom-out" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-6 text-center text-lg-left">
            <h4 class="text-highlight mb-4 mt-5 mt-lg-0">Centro De Educacion Inicial Particular</h4>
            <h1 class="display-3 font-weight-bold">Nuevo enfoque para la educación infantil</h1>
            <a href="nosotros.php" class="btn btn-primary mt-1 py-3 px-5 font-weight-bold" style="color: white;">Ver más</a>
          </div>
          <div class="col-lg-6 text-center text-lg-right">
            <img class="img-fluid rounded mb-5 mb-lg-0 dynamic-image" src="img/perfil.png" alt="Imagen educativa" style="width: 100%; height: auto;">
          </div>
        </div>
      </div>
    </section>

    <div class="container-fluid pt-5">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Detalles de nuestros comunicados</span>
          </p>
          <h1 class="mb-4">¡Ultima Hora!</h1>
        </div>
        <div class="row pb-3">
        <?php $mostrarComunicados->mostrarTarjetasComunicadosPrincipal(); ?>
        </div>
      </div>
    </div>

    <div class="container-fluid py-1">
      <div class="container">
      <?php $mostrarNosotros->mostrarNosotros(); ?>
      </div>
    </div>

    <!-- Facilities Start -->
    <div class="container-fluid pt-1">
      <div class="container pb-3">
        <div class="row">
        <?php $mostrarTarjetas->mostrarTarjetaTarjetas();?>
        </div>
      </div>
    </div>

    <!-- Proyectos -->
    <section id="projects" class="text-justify py-1">
      <div class="container">
        <h2 class="display-5 text-center">Proyectos</h2>
        <div class="row">
        <?php $mostrarProyectos->mostrarTarjetaProyectos(); ?>
        </div>
      </div>
    </section>

    <div class="container-fluid py-1">
    <div class="container p-0">
      <div class="text-center pb-2">
        <h1 class="mb-4">Qué dicen los Padres!</h1>
      </div>
      <?php $mostrarPadres->mostrarTarjetaPadres(); ?>
      </div>
    </div>
  </div>

    <!-- Team Start -->
    <div class="container-fluid pt-1">
      <div class="container">
        <div class="text-center pb-2">
          <h1 class="mb-4">Conoce a Nuestros Profesores</h1>
        </div>
        <div class="row">
        <?php $mostrarProfesores->mostrarTarjetaProfesores(); ?>
        </div>
      </div>
    </div>
    <!-- Team End -->

    <!-- Footer Start -->
    <?php include_once(__DIR__ . '/include/pagina_principal/pie_de_pagina.php'); ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"
      ><i class="fa fa-angle-double-up"></i
    ></a>

     <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Inicializar Owl Carousel -->
    <script>
      $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
          loop: false,
          margin: 10,
          nav: true,
          responsive: {
            0: {
              items: 1
            },
            600: {
              items: 2
            },
            1000: {
              items: 3
            }
          }
        });
      });
    </script>

  </body>
</html>
