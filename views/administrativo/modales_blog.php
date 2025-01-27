<div class="modal fade" id="crearBlogModal" tabindex="-1" role="dialog" aria-labelledby="crearBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearBlogModalLabel">Crear Nuevo Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearBlogForm" action="../../models/administrativo/crear_blog.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="contenido">Contenido</label>
                        <textarea class="form-control" id="contenido" name="contenido" required></textarea>
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

<div class="modal fade" id="editarBlogModal" tabindex="-1" role="dialog" aria-labelledby="editarBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarBlogModalLabel">Editar Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarBlogForm" action="../../models/administrativo/editar_blog.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editarBlogId" name="id">
                    <div class="form-group">
                        <label for="editarTitulo">Título</label>
                        <input type="text" class="form-control" id="editarTitulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="editarContenido">Contenido</label>
                        <textarea class="form-control" id="editarContenido" name="contenido" required></textarea>
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

<div class="modal fade" id="eliminarBlogModal" tabindex="-1" role="dialog" aria-labelledby="eliminarBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarBlogModalLabel">Eliminar Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eliminarBlogForm" action="../../models/administrativo/eliminar_blog.php" method="POST">
                    <input type="hidden" id="eliminarBlogId" name="id">
                    <p>¿Está seguro de que desea eliminar este blog?</p>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>