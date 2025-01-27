<?php
include_once(__DIR__ . '/config/config.php');
include_once(__DIR__ . '/models/administrativo/obtener_galeria.php');

$pdo = conectarBaseDeDatos();
$mostrarGaleria = new MostrarGaleria($pdo);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Galeria</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <link rel="icon" href="./img/logo23.ico" type="image/x-icon">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>


  <body>

    <!-- Navbar Start -->
    <?php include_once(__DIR__ . '/include/pagina_principal/cabecera.php'); ?>  
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Galería</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="">Inicio</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Galería</p>
        </div>
      </div>
    </div>
    <?php $mostrarGaleria->mostrarGalerias();?>
    <!-- Header End -->

    <!-- <div class="container-fluid pt-5 pb-3">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Título de galería</span>
          </p>
          <h1 class="mb-4">Descripción</h1>
        </div>

        <div class="row portfolio-container">
          <div class="col-lg-4 col-md-6 mb-4 portfolio-item">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="/img/imagen1.jpg" />
              <div class="portfolio-btn bg-primary d-flex align-items-center justify-content-center">
                <a href="./web2/img/imagen1.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 portfolio-item">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="/img/imagen2.jpg" />
              <div class="portfolio-btn bg-primary d-flex align-items-center justify-content-center">
                <a href="./web2/img/imagen2.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 portfolio-item">
            <div class="position-relative overflow-hidden mb-2">
              <img class="img-fluid w-100" src="/img/imagen3.jpg" />
              <div class="portfolio-btn bg-primary d-flex align-items-center justify-content-center">
                <a href="./web2/img/imagen3.jpg" data-lightbox="portfolio">
                  <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    
    <!-- Detail Start -->
    <div class="container py-5">
      <div class="row pt-5">
        <div class="col-lg-8">
          
        </div>
      </div>
    </div>
    <!-- Detail End -->

    <!-- Footer Start -->
    <?php include_once(__DIR__ . '/include/pagina_principal/pie_de_pagina.php'); ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"
      ><i class="fa fa-angle-double-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
  </body>
</html>
