<div class="modal fade" id="crearGaleriaModal" tabindex="-1" role="dialog" aria-labelledby="crearGaleriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearGaleriaModalLabel">Crear Nueva Galería</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearGaleriaForm" action="../../models/administrativo/crear_galeria.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fotos">Fotos</label>
                        <input type="file" class="form-control-file" id="fotos" name="fotos[]" multiple required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminarGaleriaModal" tabindex="-1" role="dialog" aria-labelledby="eliminarGaleriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarGaleriaModalLabel">Eliminar Galería</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eliminarGaleriaForm" action="../../models/administrativo/eliminar_galeria.php" method="POST">
                    <input type="hidden" id="eliminarGaleriaId" name="id">
                    <p>¿Está seguro de que desea eliminar esta galería?</p>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>