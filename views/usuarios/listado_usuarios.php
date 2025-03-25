<?php
include_once(__DIR__ . '/../../config/config.php');
session_start();
include_once(__DIR__ . '/../../models/usuarios/mostrar_usuarios.php');

$pdo = conectarBaseDeDatos();
$usuario = new Usuario($pdo);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Listado Usuario</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="icon" href="../../img/logo23.ico" type="image/x-icon">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
                    <h1 class="h3 mb-0 text-gray-800">Listado de Usuarios</h1>
                </div>

                <!-- Fila de contenido -->
                <div class="row">
                        <!-- Tabla de usuarios -->
                    <?php $usuario->mostrarTablaUsuarios(); ?>
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

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarUsuarioForm">
                        <input type="hidden" id="editUserId" name="id_usuario">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarEdicion">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este usuario?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
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

     <!-- DataTables JS -->
     <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaUsuarios').DataTable({
                "pageLength": 10,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
                }
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let userIdToDelete = null;

        // Manejar el clic en el botón de eliminar
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                userIdToDelete = this.getAttribute('data-user-id');
                $('#deleteModal').modal('show');
            });
        });

        // Manejar la confirmación de eliminación
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (userIdToDelete) {
                fetch('<?php echo BASE_URL; ?>/models/usuarios/eliminar_usuario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ userId: userIdToDelete })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recargar la página o actualizar la tabla para reflejar los cambios
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al eliminar el usuario.');
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Manejar el clic en el botón de editar
        $('.btn-edit').on('click', function() {
            const userId = $(this).data('user-id');
            const username = $(this).data('username');
            
            $('#editUserId').val(userId);
            $('#editUsername').val(username);
            $('#editPassword').val('');
            
            $('#editarUsuarioModal').modal('show');
        });

        // Manejar el envío del formulario de edición
        $('#guardarEdicion').on('click', function() {
            const formData = new FormData($('#editarUsuarioForm')[0]);
            
            $.ajax({
                url: '<?php echo BASE_URL; ?>/models/usuarios/editar_usuario.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editarUsuarioModal').modal('hide');
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Usuario actualizado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.error || 'Error al actualizar el usuario',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al procesar la solicitud',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    });
</script>

</body>

</html>

