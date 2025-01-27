<!-- Modal para crear un nuevo padre -->
<div class="modal fade" id="crearPadreModal" tabindex="-1" role="dialog" aria-labelledby="crearPadreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearPadreModalLabel">Crear Nuevo Padre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="crearPadreForm" action="../../models/administrativo/crear_padre.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" id="comentario" name="comentario" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para editar un padre -->
    <div class="modal fade" id="editarPadreModal" tabindex="-1" role="dialog" aria-labelledby="editarPadreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPadreModalLabel">Editar Padre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarPadreForm" action="../../models/administrativo/editar_padre.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editarPadreId" name="id">
                        <div class="form-group">
                            <label for="editarNombre">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editarComentario">Comentario</label>
                            <textarea class="form-control" id="editarComentario" name="comentario" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editarImagen">Imagen</label>
                            <input type="file" class="form-control-file" id="editarImagen" name="imagen">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar un padre -->
    <div class="modal fade" id="eliminarPadreModal" tabindex="-1" role="dialog" aria-labelledby="eliminarPadreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarPadreModalLabel">Eliminar Padre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eliminarPadreForm" action="../../models/administrativo/eliminar_padre.php" method="POST">
                        <input type="hidden" id="eliminarPadreId" name="id">
                        <p>¿Está seguro de que desea eliminar este padre?</p>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>