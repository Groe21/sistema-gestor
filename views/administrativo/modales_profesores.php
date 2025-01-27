<div class="modal fade" id="crearProfesorModal" tabindex="-1" role="dialog" aria-labelledby="crearProfesorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearProfesorModalLabel">Crear Nuevo Profesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearProfesorForm" action="../../models/administrativo/crear_profesor.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" required>
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
                <form id="editarProfesorForm" action="../../models/administrativo/editar_profesor.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editarProfesorId" name="id">
                    <div class="form-group">
                        <label for="editarNombre">Nombre</label>
                        <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editarCargo">Cargo</label>
                        <input type="text" class="form-control" id="editarCargo" name="cargo" required>
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

<div class="modal fade" id="eliminarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="eliminarProfesorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarProfesorModalLabel">Eliminar Profesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eliminarProfesorForm" action="../../models/administrativo/eliminar_profesor.php" method="POST">
                    <input type="hidden" id="eliminarProfesorId" name="id">
                    <p>¿Está seguro que desea eliminar este profesor?</p>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>