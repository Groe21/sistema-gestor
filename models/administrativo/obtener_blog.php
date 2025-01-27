<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarBlog {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerBlog() {
        try {
            $sql = "SELECT * FROM blog";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener blogs: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaBlog() {
        try {
            $blogs = $this->obtenerBlog();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearBlogModal">
                                        <i class="fas fa-plus"></i> Crear
                                    </button>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Título</th>
                                                    <th>Contenido</th>
                                                    <th>Imagen</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (empty($blogs)) {
                echo '<tr><td colspan="4" class="text-center">No hay blogs disponibles.</td></tr>';
            } else {
                foreach ($blogs as $blog) {
                    echo '<tr>
                            <td>' . htmlspecialchars($blog['titulo']) . '</td>
                            <td>' . htmlspecialchars($blog['contenido']) . '</td>
                            <td><img src="../../uploads/blog/' . htmlspecialchars($blog['imagen']) . '" class="img-thumbnail" width="100" height="50"/></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarBlogModal" data-id="' . htmlspecialchars($blog['id']) . '" data-titulo="' . htmlspecialchars($blog['titulo']) . '" data-contenido="' . htmlspecialchars($blog['contenido']) . '" data-imagen="' . htmlspecialchars($blog['imagen']) . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarBlogModal" data-id="' . htmlspecialchars($blog['id']) . '">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                          </tr>';
                }
            }
            echo '              </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar la tabla de blogs: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los blogs.</div>';
        }
    }

    public function mostrarTarjetaBlog() {
        try {
            $blogs = $this->obtenerBlog();
            echo '<div class="container-fluid mt-5">
                    <div class="row">';
            if (empty($blogs)) {
                echo '<div class="col-12 text-center">No hay blogs disponibles.</div>';
            } else {
                foreach ($blogs as $blog) {
                    echo '<div class="col-12 mb-5">
                            <div class="card">
                                <div class="row no-gutters">
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h2 class="card-title">' . htmlspecialchars($blog['titulo']) . '</h2>
                                            <p class="card-text">' . htmlspecialchars($blog['contenido']) . '</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img class="img-fluid rounded-right" src="uploads/blog/' . htmlspecialchars($blog['imagen']) . '" alt="Image" />
                                    </div>
                                </div>
                            </div>
                          </div>';
                }
            }
            echo '      </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas de blogs: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los blogs.</div>';
        }
    }
}
?>