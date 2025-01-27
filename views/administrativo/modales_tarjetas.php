<div class="modal fade" id="crearTarjetaModal" tabindex="-1" role="dialog" aria-labelledby="crearTarjetaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearTarjetaModalLabel">Crear Nueva Tarjeta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearTarjetaForm" action="../../models/administrativo/crear_tarjeta.php" method="POST">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="contenido">Contenido</label>
                        <textarea class="form-control" id="contenido" name="contenido" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editarTarjetaModal" tabindex="-1" role="dialog" aria-labelledby="editarTarjetaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarTarjetaModalLabel">Editar Tarjeta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarTarjetaForm" action="../../models/administrativo/editar_tarjeta.php" method="POST">
                    <input type="hidden" id="editarTarjetaId" name="id">
                    <div class="form-group">
                        <label for="editarTitulo">Título</label>
                        <input type="text" class="form-control" id="editarTitulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="editarContenido">Contenido</label>
                        <textarea class="form-control" id="editarContenido" name="contenido" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminarTarjetaModal" tabindex="-1" role="dialog" aria-labelledby="eliminarTarjetaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarTarjetaModalLabel">Eliminar Tarjeta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eliminarTarjetaForm" action="../../models/administrativo/eliminar_tarjeta.php" method="POST">
                    <input type="hidden" id="eliminarTarjetaId" name="id">
                    <p>¿Está seguro de que desea eliminar esta tarjeta?</p>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>