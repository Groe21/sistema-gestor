<?php
session_start();
ob_start();
include_once(__DIR__ . '/../../config/config.php');
include_once(__DIR__ . '/../../config/conexion.php');
include_once(__DIR__ . '/../../models/administrativo/obtener_galeria.php');

$pdo = conectarBaseDeDatos();
$mostrarGaleria = new MostrarGaleria($pdo);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Galeria</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="../../img/logo23.ico" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Barra lateral -->
        <?php include_once(__DIR__ . '/../../include/barra_lateral.php'); ?>
        <!-- Fin de la barra lateral -->

        <!-- Contenedor de contenido -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Contenido principal -->
            <div id="content">

                <!-- Barra superior -->
                <?php include_once(__DIR__ . '/../../include/barra_superior.php'); ?>
                <!-- Fin de la barra superior -->

                <!-- Comienzo del contenido de la página -->
                <div class="container-fluid">

                    <!-- Encabezado de la página -->
                    

                    <!-- Fila de contenido -->
                    <div class="row">
                        <h1 class="h3 mb-0 text-gray-800">Crear galeria</h1>
                        <?php $mostrarGaleria->obtenerTablaGalerias();?>
                        <?php include_once(__DIR__ . '/modales_galeria.php'); ?>
                    </div>
                    <hr>
                    
                    
                    
                </div>
                <!-- /.contenedor-fluido -->

            </div>
            <!-- Fin del contenido principal -->

            <!-- Pie de página -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Las Águilas del saber. Nos reservamos los derechos</span>
                    </div>
                </div>
            </footer>
            <!-- Fin del pie de página -->

        </div>
        <!-- Fin del contenedor de contenido -->

    </div>
    <!-- Fin del contenedor de la página -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

<!-- Bootstrap core JavaScript-->
<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../js/sb-admin-2.min.js"></script>
<script src="../../js/discapacidad.js"></script>

<!-- Page level plugins -->
<script src="../../vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../js/demo/chart-area-demo.js"></script>
<script src="../../js/demo/chart-pie-demo.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#eliminarGaleriaModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id');

            var modal = $(this);
            modal.find('#eliminarGaleriaId').val(id);
        });
    });
</script>

<?php ob_end_flush(); ?>
</body>

</html>