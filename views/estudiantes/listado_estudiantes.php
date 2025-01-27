<?php
session_start();
ob_start();
include_once(__DIR__ . '/../../config/config.php');
include_once(__DIR__ . '/../../models/periodos/obtener_periodos.php');
include_once(__DIR__ . '/../../models/estudiantes/mostrar_estudiantes.php');

$pdo = conectarBaseDeDatos(); 
$obtenerPeriodos = new ObtenerPeriodos($pdo);
$listadoEstudiantes = new ListadoEstudiantes($pdo, $obtenerPeriodos);

$id_periodo = isset($_GET['id_periodo']) ? $_GET['id_periodo'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Listado Estudiantes</title>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Listado de Estudiantes</h1>
                    </div>

                    <!-- Fila de contenido -->
                    <div class="row">
                        
                        <?php
                        $listadoEstudiantes->mostrarTablaEstudiantes($id_periodo);
                        ?>
                      
                    </div>
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

    <!-- Modal de Cierre de Sesión-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="login.html">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Botones para abrir el modal con diferentes roles -->
    <div class="form-group">
    </div>

    <!-- Modal para buscar personas -->
    <div class="modal fade" id="buscarPersonaModal" tabindex="-1" role="dialog" aria-labelledby="buscarPersonaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buscarPersonaModalLabel">Buscar Persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="buscarPersonaForm">
                        <input type="hidden" id="tipo_persona" name="tipo_persona">
                        <div class="form-group">
                            <label for="id_periodo_buscar">Periodo:</label>
                            <?php echo $obtenerPeriodos->generarSelect(); ?>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="buscarPersona()">Buscar</button>
                    </form>
                    <div id="tablaResultados">
                        <!-- Aquí se incluirá la tabla generada por AJAX -->
                    </div>
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
<script src="../../js/discapacidad.js"></script>

<!-- Page level plugins -->
<script src="../../vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../js/demo/chart-area-demo.js"></script>
<script src="../../js/demo/chart-pie-demo.js"></script>



<script>
    function abrirModal(tipo) {
        $('#tipo_persona').val(tipo);
        $('#buscarPersonaModal').modal('show');
    }

    function buscarPersona() {
        var tipo = $('#tipo_persona').val();
        var id_periodo = $('#id_periodo_buscar').val();

        console.log('Tipo:', tipo);
        console.log('ID Periodo:', id_periodo);

        if (!id_periodo) {
            alert('Por favor, seleccione un periodo.');
            return;
        }

        $.ajax({
            url: '<?php echo BASE_URL; ?>/models/estudiantes/buscar_estudiante.php',
            type: 'POST',
            data: { tipo_persona: tipo, id_periodo: id_periodo },
            dataType: 'json',
            success: function(response) {
                var html = '<table class="table table-bordered mt-3"><thead><tr><th>Cédula</th><th>Nombres</th><th>Apellidos</th><th>Dirección</th><th>Teléfono</th><th>Correo</th><th>Acción</th></tr></thead><tbody>';
                if (response.length > 0) {
                    response.forEach(function(persona) {
                        html += '<tr>';
                        html += '<td>' + persona.cedula + '</td>';
                        html += '<td>' + persona.nombres + '</td>';
                        html += '<td>' + persona.apellidos + '</td>';
                        html += '<td>' + persona.direccion + '</td>';
                        html += '<td>' + persona.telefono + '</td>';
                        html += '<td>' + persona.correo + '</td>';
                        html += '<td><button type="button" class="btn btn-primary btn-sm" onclick="seleccionarPersona(' + persona.id_persona + ', \'' + persona.cedula + '\', \'' + persona.nombres + '\', \'' + persona.apellidos + '\', \'' + persona.direccion + '\', \'' + persona.telefono + '\', \'' + persona.correo + '\', \'' + tipo + '\', \'' + persona.id_periodo + '\')">Seleccionar</button></td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="7">No se encontraron personas con el rol y periodo especificado</td></tr>';
                }
                html += '</tbody></table>';
                $('#tablaResultados').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Error al buscar personas:', error);
                alert('Error al buscar personas.');
            }
        });
    }

    function seleccionarPersona(id_persona, cedula, nombres, apellidos, direccion, telefono, correo, tipo, id_periodo) {
        $('#cedula_' + tipo).val(cedula);
        $('#nombres_' + tipo).val(nombres);
        $('#apellidos_' + tipo).val(apellidos);
        $('#direccion_' + tipo).val(direccion);
        $('#telefono_' + tipo).val(telefono);
        $('#correo_' + tipo).val(correo);
        $('#id_periodo').val(id_periodo); // Asignar el id_periodo al campo correspondiente
        $('#buscarPersonaModal').modal('hide');
    }

    $(document).ready(function () {
        window.abrirModal = abrirModal;
        window.seleccionarPersona = seleccionarPersona;
    });
</script>



<?php ob_end_flush(); ?>
</body>

</html>