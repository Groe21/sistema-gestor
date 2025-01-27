<div class="modal fade" id="crearProyectoModal" tabindex="-1" role="dialog" aria-labelledby="crearProyectoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearProyectoModalLabel">Crear Nuevo Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearProyectoForm" action="../../models/administrativo/crear_proyecto.php" method="POST">
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

<div class="modal fade" id="editarProyectoModal" tabindex="-1" role="dialog" aria-labelledby="editarProyectoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProyectoModalLabel">Editar Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarProyectoForm" action="../../models/administrativo/editar_proyecto.php" method="POST">
                    <input type="hidden" id="editarProyectoId" name="id">
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


<div class="modal fade" id="eliminarProyectoModal" tabindex="-1" role="dialog" aria-labelledby="eliminarProyectoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarProyectoModalLabel">Eliminar Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eliminarProyectoForm" action="../../models/administrativo/eliminar_proyecto.php" method="POST">
                    <input type="hidden" id="eliminarProyectoId" name="id">
                    <p>¿Está seguro de que desea eliminar este proyecto?</p>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>