<?php
session_start();
ob_start();
include_once(__DIR__ . '/../../config/config.php');
include_once(__DIR__ . '/../../models/escuela/mostrar_paralelos.php');
include_once(__DIR__ . '/../../models/asistencia/obtener_profesores_asistencia.php');
$pdo = conectarBaseDeDatos();
$listadoProfesores = new ListadoProfesores($pdo);
$id_periodo = isset($_GET['id_periodo']) ? $_GET['id_periodo'] : null;
$id_paralelo = isset($_GET['id_paralelo']) ? $_GET['id_paralelo'] : null;
$fecha = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestión de asistencia</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
            <?php include_once (__DIR__ . '/../../include/barra_superior.php'); ?>
            <!-- Fin de la barra superior -->

            <!-- Comienzo del contenido de la página -->
            <div class="container-fluid">

                <!-- Encabezado de la página -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Control de asistencia</h1>
                </div>

                <!-- Fila de contenido -->
                <div class="row">
                <?php $listadoProfesores->mostrarTablaEstudiantesConAsistencia($id_periodo, $id_paralelo); ?>
                </div>

            </div>
            <!-- /.contenedor-fluido -->

            </div>
            <!-- Fin del contenido principal -->

            <!-- Pie de página -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    <span>&copy; Las Águilas del saber. Nos reservamos los derechos  </span>
                    </div>
                </div>
            </footer>
            <!-- Fin del pie de página -->

        </div>
        <!-- Fin del contenedor de contenido -->

        </div>
        <!-- Fin del contenedor de la página -->

        <!-- Modal de Éxito -->
        <div class="modal fade" id="modalExito" tabindex="-1" role="dialog" aria-labelledby="modalExitoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalExitoLabel">Éxito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Asistencia registrada correctamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.reload();">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

      <!-- Modal de Error -->
      <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalErrorLabel">Error</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Error al registrar la asistencia.
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                  </div>
              </div>
          </div>
      </div>

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

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>

    <script>
      function darAsistencia(idEstudiante, fecha) {
          $.ajax({
              url: '../../models/asistencia/dar_asistencia.php', // URL directa
              method: 'POST',
              data: { id_estudiante: idEstudiante, fecha: fecha },
              success: function(response) {
                  response = JSON.parse(response);
                  if (response.success) {
                      $('#modalExito').modal('show');
                      setTimeout(function() {
                          location.reload(); // Recargar la página para actualizar la tabla
                      }, 2000); // Esperar 2 segundos antes de recargar
                  } else {
                      $('#modalError').modal('show');
                  }
              },
              error: function(xhr, status, error) {
                  console.error('Error al registrar la asistencia:', error);
                  $('#modalError').modal('show');
              }
          });
      }
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Semanal Estudiante
    document.getElementById('formSemanalEstudiante').addEventListener('submit', function(event) {
        event.preventDefault();
        var fecha = document.getElementById('fechaSemanalEstudiante').value;
        var idEstudiante = document.querySelector('#modalSemanalEstudiante').getAttribute('data-id-estudiante');
        window.open('../../models/asistencia/asistencia_estudiante_semanal.php?id_estudiante=' + idEstudiante + '&fecha=' + fecha, '_blank');
    });

    // Mensual Estudiante
    document.getElementById('formMensualEstudiante').addEventListener('submit', function(event) {
        event.preventDefault();
        var fecha = document.getElementById('fechaMensualEstudiante').value;
        var idEstudiante = document.querySelector('#modalMensualEstudiante').getAttribute('data-id-estudiante');
        window.open('../../models/asistencia/asistencia_estudiante_mensual.php?id_estudiante=' + idEstudiante + '&fecha=' + fecha, '_blank');
    });

    // Anual Estudiante
    document.getElementById('formAnualEstudiante').addEventListener('submit', function(event) {
        event.preventDefault();
        var fecha = document.getElementById('fechaAnualEstudiante').value;
        var idEstudiante = document.querySelector('#modalAnualEstudiante').getAttribute('data-id-estudiante');
        window.open('../../models/asistencia/asistencia_estudiante_anual.php?id_estudiante=' + idEstudiante + '&fecha=' + fecha, '_blank');
    });

    // Eventos para capturar la apertura de los modales y asignar el data-id-estudiante
    $('#modalSemanalEstudiante').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var idEstudiante = button.data('id-estudiante'); // Extraer información del data-* attribute
        var modal = $(this);
        modal.attr('data-id-estudiante', idEstudiante);
    });

    $('#modalMensualEstudiante').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idEstudiante = button.data('id-estudiante');
        var modal = $(this);
        modal.attr('data-id-estudiante', idEstudiante);
    });

    $('#modalAnualEstudiante').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idEstudiante = button.data('id-estudiante');
        var modal = $(this);
        modal.attr('data-id-estudiante', idEstudiante);
    });

    // Semanal General
    document.getElementById('formSemanalGeneral').addEventListener('submit', function(event) {
        event.preventDefault();
        var fecha = document.getElementById('fechaSemanalGeneral').value;
        var idPeriodo = document.querySelector('#modalSemanalGeneral').getAttribute('data-id-periodo');
        var idParalelo = document.querySelector('#modalSemanalGeneral').getAttribute('data-id-paralelo');
        window.open('../../models/asistencia/asistencia_semanal.php?id_periodo=' + idPeriodo + '&id_paralelo=' + idParalelo + '&fecha=' + fecha, '_blank');
    });

    // Mensual General
    document.getElementById('formMensualGeneral').addEventListener('submit', function(event) {
        event.preventDefault();
        var fecha = document.getElementById('fechaMensualGeneral').value;
        var idPeriodo = document.querySelector('#modalMensualGeneral').getAttribute('data-id-periodo');
        var idParalelo = document.querySelector('#modalMensualGeneral').getAttribute('data-id-paralelo');
        window.open('../../models/asistencia/asistencia_mensual.php?id_periodo=' + idPeriodo + '&id_paralelo=' + idParalelo + '&fecha=' + fecha, '_blank');
    });

    // Anual General
    document.getElementById('formAnualGeneral').addEventListener('submit', function(event) {
        event.preventDefault();
        var fecha = document.getElementById('fechaAnualGeneral').value;
        var idPeriodo = document.querySelector('#modalAnualGeneral').getAttribute('data-id-periodo');
        var idParalelo = document.querySelector('#modalAnualGeneral').getAttribute('data-id-paralelo');
        window.open('../../models/asistencia/asistencia_anual.php?id_periodo=' + idPeriodo + '&id_paralelo=' + idParalelo + '&fecha=' + fecha, '_blank');
    });

    // Eventos para capturar la apertura de los modales y asignar los data-id-periodo y data-id-paralelo
    $('#modalSemanalGeneral').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var idPeriodo = button.data('id-periodo'); // Extraer información del data-* attribute
        var idParalelo = button.data('id-paralelo');
        var modal = $(this);
        modal.attr('data-id-periodo', idPeriodo);
        modal.attr('data-id-paralelo', idParalelo);
    });

    $('#modalMensualGeneral').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idPeriodo = button.data('id-periodo');
        var idParalelo = button.data('id-paralelo');
        var modal = $(this);
        modal.attr('data-id-periodo', idPeriodo);
        modal.attr('data-id-paralelo', idParalelo);
    });

    $('#modalAnualGeneral').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idPeriodo = button.data('id-periodo');
        var idParalelo = button.data('id-paralelo');
        var modal = $(this);
        modal.attr('data-id-periodo', idPeriodo);
        modal.attr('data-id-paralelo', idParalelo);
    });
});
</script>

</body>

</html>