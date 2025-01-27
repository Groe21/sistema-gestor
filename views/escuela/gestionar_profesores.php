<?php
session_start();
ob_start();
include_once(__DIR__ . '/../../config/config.php');
include_once(__DIR__ . '/../../models/periodos/obtener_periodos.php');
include_once(__DIR__ . '/../../models/profesores/mostrar_profesor.php');
$pdo = conectarBaseDeDatos(); 
$profesor = new ObtenerProfesor($pdo);
$obtenerPeriodos = new ObtenerPeriodos($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProfesor = $_POST['profesorId'];
    $idParalelo = $_POST['curso'];

    if ($profesor->asignarCursoAProfesor($idProfesor, $idParalelo)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    } 
    exit;
}
$id_periodo = $_GET['id_periodo'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener_paralelos') {
    $paralelos = $profesor->obtenerParalelos();
    echo json_encode($paralelos);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestión de Profesores</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="icon" href="../../img/logo23.ico" type="image/x-icon">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h1 class="h3 mb-0 text-gray-800">Profesores</h1>
                </div>

                <!-- Fila de contenido -->
                <div class="row">
                <?php $profesor->mostrarTablaProfesores($id_periodo); ?>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modales para gestión de profesores -->

    <!-- Modal de Creación de Profesor -->
    <div class="modal fade" id="crearProfesorModal" tabindex="-1" role="dialog" aria-labelledby="crearProfesorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearProfesorModalLabel">Crear Profesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearProfesorForm" action="<?php echo BASE_URL; ?>/models/profesores/crear_profesor.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="id_periodo">Periodo:</label>
                    <?php echo $profesor->generarSelectPeriodos(); ?>
                </div>
                <button type="submit" class="btn btn-primary" onclick="location.reload();">Crear</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal para Asignar Curso -->
    <div class="modal fade" id="asignarCursoModal" tabindex="-1" role="dialog" aria-labelledby="asignarCursoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignarCursoModalLabel">Asignar Curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="asignarCursoForm">
                        <div class="form-group">
                            <label for="curso">Curso</label>
                            <select class="form-control" id="curso" name="curso">
                                <!-- Opciones de cursos se cargarán dinámicamente -->
                            </select>
                        </div>
                        <input type="hidden" id="profesorId" name="profesorId">
                        <button type="submit" class="btn btn-primary" onclick="location.reload();">Asignar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar éxito -->
    <div class="modal fade" id="exitoModal" tabindex="-1" role="dialog" aria-labelledby="exitoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exitoModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>El curso ha sido asignado exitosamente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar error -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Hubo un error al asignar el curso. Por favor, inténtelo de nuevo.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="eliminarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="eliminarProfesorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminarProfesorModalLabel">Confirmar Eliminación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este profesor?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="confirmarEliminar" onclick="location.reload();">Eliminar</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal de Edición de Profesor -->
    <div class="modal fade" id="editarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="editarProfesorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editarProfesorModalLabel">Editar Profesor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editarProfesorForm" action="<?php echo BASE_URL; ?>/models/profesores/editar_profesor.php" method="POST">
            <input type="hidden" id="id_profesor" name="id_profesor">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="id_periodo">Periodo:</label>
                <?php echo $profesor->generarSelectPeriodos(); ?>
            </div>
            <button type="submit" class="btn btn-primary" onclick="location.reload();">Guardar Cambios</button>
            </form>
        </div>
        </div>
    </div>
    </div>

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

    <!-- Script para manejar el modal y la asignación de curso -->
    <script>
        $(document).ready(function() {
            $('#asignarCursoModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var profesorId = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #profesorId').val(profesorId);

                console.log('Profesor ID:', profesorId);

                // Verificar si el profesor ya tiene un curso asignado
                var cursoAsignado = button.closest('tr').find('td:nth-child(2)').text().trim();
                if (cursoAsignado !== 'Asignar Curso') {
                    console.log('Este profesor ya tiene un curso asignado:', cursoAsignado);
                    $('#mensajeContenido').text('Este profesor ya tiene un curso asignado.');
                    $('#mensajeModal').modal('show');
                    return false;
                }

                // Cargar opciones de cursos dinámicamente
                $.ajax({
                    url: 'gestionar_profesores.php?action=obtener_paralelos',
                    method: 'GET',
                    success: function(data) {
                        var cursos = JSON.parse(data);
                        var select = modal.find('.modal-body #curso');
                        select.empty();
                        cursos.forEach(function(curso) {
                            select.append('<option value="' + curso.id_paralelo + '">' + curso.nombre_paralelo + '</option>');
                        });
                        console.log('Cursos obtenidos:', cursos);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener cursos:', error);
                    }
                });
            });

            $('#asignarCursoForm').on('submit', function (event) {
                event.preventDefault();
                var form = $(this);
                $.ajax({
                    url: 'gestionar_profesores.php',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            console.log('Curso asignado exitosamente');
                            $('#exitoModal').modal('show');
                        } else {
                            console.error('Error al asignar curso');
                            $('#errorModal').modal('show');
                        }
                        $('#asignarCursoModal').modal('hide');
                        //location.reload(); // Recargar la página para ver los cambios
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud de asignación:', error);
                        $('#errorModal').modal('show');
                    }
                });
            });
        });
    </script>

    <!-- Script dedicado a la gestión de profesores, incluyendo eliminación y edición mediante modales y AJAX. -->
    <script>
        $(document).ready(function() {
            // Manejar el clic en el botón de eliminar
            $('#eliminarProfesorModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var idProfesor = button.data('id');
                var modal = $(this);
                modal.find('#confirmarEliminar').data('id', idProfesor);
            });

            $('#confirmarEliminar').on('click', function() {
                var idProfesor = $(this).data('id');
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/models/profesores/eliminar_profesor.php',
                    method: 'POST',
                    data: { id_profesor: idProfesor },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + result.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Ocurrió un error al eliminar el profesor.');
                    }
                });
            });

            // Manejar el clic en el botón de editar
            $('#editarProfesorModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var idProfesor = button.data('id');
                var nombre = button.data('nombre');
                var idPeriodo = button.data('periodo');
                var modal = $(this);
                modal.find('#id_profesor').val(idProfesor);
                modal.find('#nombre').val(nombre);
                modal.find('#id_periodo').val(idPeriodo);
            });

            $('#editarProfesorForm').on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/models/profesores/editar_profesor.php',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + result.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Ocurrió un error al editar el profesor.');
                    }
                });
            });
        });
    </script>

    <!-- Script dedicado a la gestión de la creación de profesores mediante AJAX en un formulario. -->
    <script>
        $(document).ready(function() {
            $('#crearProfesorForm').on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            $('#exitoModal').modal('show');
                            form[0].reset(); // Limpiar el formulario
                        } else {
                            $('#errorModal .modal-body p').text('Error: ' + result.error);
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $('#errorModal .modal-body p').text('Ocurrió un error al crear el profesor.');
                        $('#errorModal').modal('show');
                    }
                });
            });
        });
    </script>

    <?php ob_end_flush(); ?>

</body>

</html>