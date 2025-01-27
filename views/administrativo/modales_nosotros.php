<div class="modal fade" id="editarNosotrosModal" tabindex="-1" role="dialog" aria-labelledby="editarNosotrosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarNosotrosModalLabel">Editar Información de Nosotros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarNosotrosForm" action="../../models/administrativo/editar_nosotros.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editarNosotrosId" name="id">
                    <div class="form-group">
                        <label for="editarTitulo">Título</label>
                        <input type="text" class="form-control" id="editarTitulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="editarContenido">Contenido</label>
                        <textarea class="form-control" id="editarContenido" name="contenido" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editarImagenPrincipal">Imagen Principal</label>
                        <input type="file" class="form-control-file" id="editarImagenPrincipal" name="imagen_principal">
                    </div>
                    <div class="form-group">
                        <label for="editarImagenSecundaria">Imagen Secundaria</label>
                        <input type="file" class="form-control-file" id="editarImagenSecundaria" name="imagen_secundaria">
                    </div>
                    <div class="form-group">
                        <label for="editarDescripcion1">Descripción 1</label>
                        <textarea class="form-control" id="editarDescripcion1" name="descripcion1" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editarDescripcion2">Descripción 2</label>
                        <textarea class="form-control" id="editarDescripcion2" name="descripcion2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>