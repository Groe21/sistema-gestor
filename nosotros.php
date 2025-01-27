<?php
include_once(__DIR__ . '/config/config.php');
include_once(__DIR__ . '/models/administrativo/obtener_nosotros.php');
include_once(__DIR__ . '/models/administrativo/obtener_tarjetas.php');

$pdo = conectarBaseDeDatos();
$mostrarNosotros = new MostrarNosotros($pdo);
$mostrarTarjetas = new MostrarTarjetas($pdo);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sobre Nosotros</title>
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
        <h3 class="display-3 font-weight-bold text-white">Sobre Nosotros</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="">Inicio</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Sobre Nosotros</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <div class="container-fluid py-1">
      <div class="container">
      <?php $mostrarNosotros->mostrarNosotros(); ?>
      </div>
    </div>

    <section class="text-justify text-white text-center py-4 d-flex align-items-center" style="background-color: #DD4A48;">
      <div class="container">
        <h1 class="display-3 font-weight-bold text-white m-0">Historia del Plantel</h1>
        <p class="lead">Conoce nuestra trayectoria y cómo hemos llegado hasta aquí­.</p>
      </div>
    </section>

    <div class="text-justify container-fluid py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5">
            <img class="img-fluid rounded mb-5 mb-lg-0" src="img/img2.jpg" alt="">
          </div>
          <div class="col-lg-7">
            <h1 class="mb-4">Identidad Institucional</h1>
            <p>La Escuela de Educación Básica Particular Las Águilas del Saber, desde sus inicios, 
              ubica al estudiante como protagonista principal del aprendizaje, con predominio de las 
              vías metodológicas constructivistas. Este enfoque permite construir conocimientos en un 
              ambiente de calidez, acompañado de excelentes maestros que unen esfuerzos en esta labor.
              Es fundamental cumplir con los procedimientos legales que señala el MINEDUC, 
              los cuales se convierten en una fortaleza para implementar los cambios necesarios y mantener 
              a nuestra institución en los altos sitiales que siempre ha ocupado. Con la participación activa 
              de toda la comunidad educativa, se ha logrado plasmar este documento que abarca las dimensiones 
              de los estándares de gestión escolar: convivencia, participación escolar y cooperación, gestión 
              pedagógica, seguridad escolar y gestión administrativa.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="text-justify container-fluid py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <h1 class="mb-4">El primer paso..</h1>
            <p>El centro educativo obtiene su permiso de funcionamiento
              mediante la RESOLUCIÓN DEO-DPE-109-2009, el 4 de marzo de 
              2009, para la jornada matutina. Se encuentra ubicado en 
              la parroquia El Cambio, ciudadela Mario Minuche, calle 
              Eloy Alfaro y Tercera Sur. Inicia la jornada escolar en 
              abril del año lectivo 2009-2010.</p>
            <p>El 10 de julio de 2014, mediante la RESOLUCIÓN 863-14, 
              se obtiene la autorización para la creación y funcionamiento 
              del centro de educación inicial "Las Águilas del Saber". 
              En 2018, mediante la RESOLUCIÓN N° MINEDUC-CZ7-2018-00175-R 
              del 3 de abril de 2018, se autoriza la creación y funcionamiento 
              del subnivel de preparatoria, correspondiente al primer grado de 
              educación general básica, en la Escuela de Educación Básica 
              Particular "Las Águilas del Saber".</p>
            <div class="row pt-2 pb-4">
              <div class="col-6 col-md-4">
                <img class="img-fluid rounded" src="img/imghistoria.jpg" alt="" />
              </div>
              <div class="col-6 col-md-8">
                <ul class="list-inline m-0">
                  <p>Ese mismo año, el centro de educación inicial recibe 
                    la denominación oficial de Escuela de Educación Básica 
                    Particular "Las Águilas del Saber", consolidando su 
                    identidad institucional.</p>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <img class="img-fluid rounded mb-5 mb-lg-0" src="img/imghistoria2.jpg" alt="" />
          </div>
        </div>
      </div>
    </div>

    <div class="text-justify container-fluid py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <h1 class="mb-4">La historia continua..</h1>
            <p>Janina e Iván Salinas Salinas, licenciados en Ciencias de la Educación, 
              impulsados por su vocación, amor, servicio a la comunidad y la convicción 
              de que las bases sólidas para una buena formación humana y profesional se 
              inician en los primeros años de vida, gestionaron y llevaron a la práctica 
              el proyecto de creación del Centro de Educación Inicial "Las Águilas del 
              Saber".</p>
            <p>Su primer director fue el Lic. José Cedeño Hidalgo, acompañado por las 
              maestras Prof. Rosario Cárdenas y Prof. Janina Salinas. Durante los años 
              lectivos 2011-2012 hasta 2017-2018, el centro creció como una institución 
              de educación inicial, ofreciendo el servicio educativo en el subnivel 2 
              para infantes de tres y cuatro años de edad.</p>
            <p>En el período 2017-2019, el Lic. Iván Salinas Salinas asumió la dirección 
              del plantel, ampliando la oferta educativa en educación inicial subnivel 2 
              y educación general básica con el subnivel de Preparatoria. Proyectándose 
              al 2020, el centro planificó la creación del subnivel de Básica Elemental.</p>
          </div>
          <div class="col-lg-5">
            <img class="img-fluid rounded mb-5 mb-lg-0" src="img/imghistoria3.jpg" alt="" />
          </div>
        </div>
      </div>
    </div>

    <section id="about" class="text-justify bg-light py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <p>En el período lectivo 2020-2021, la Mgs. Janina Marisel Salinas Salinas
               asume la dirección del plantel, enfrentando el reto de continuar ofreciendo 
               el servicio educativo de manera virtual a estudiantes de 3 a 5 años. Debido 
               a la pandemia de COVID-19, el gobierno ecuatoriano declaró la emergencia 
               sanitaria y dispuso que el servicio educativo en cada institución 
               continuara adaptándose a las circunstancias.En este contexto, la 
               escuela mantuvo una educación cíclica y proyectos permanentes como 
               el ajedrez y Aprendiendo de la Naturaleza, teniendo como eje principal 
               la metodología Montessori, destacando el contacto con materiales concretos, 
               especialmente de origen natural. En la actualidad, la Mgs. Janina Marisel Salinas Salinas 
               continúa liderando la institución.</p>
          </div>
          <div class="col-lg-6 d-flex justify-content-center">
            <div class="image-container" style="max-width: 50%; max-height: 700px; overflow: hidden; border-radius: 10px; margin-left: 40px;">
              <img src="img/imghistoria4.jpg" alt="Imagen de la fundación" class="img-fluid" style="width: 300px; height: 250px;">
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="container-fluid pt-5">
      <div class="container pb-3">
        <div class="row">
        <?php $mostrarTarjetas->mostrarTarjetaTarjetas();?>
        </div>
      </div>
    </div>

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
