<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarProyectos {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerProyectos() {
        try {
            $sql = "SELECT * FROM proyectos";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener proyectos: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaProyectos() {
        try {
            $proyectos = $this->obtenerProyectos();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearProyectoModal">
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
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (empty($proyectos)) {
                echo '<tr><td colspan="3" class="text-center">No hay proyectos disponibles.</td></tr>';
            } else {
                foreach ($proyectos as $proyecto) {
                    echo '<tr>
                            <td>' . htmlspecialchars($proyecto['titulo']) . '</td>
                            <td>' . htmlspecialchars($proyecto['contenido']) . '</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarProyectoModal" data-id="' . htmlspecialchars($proyecto['id']) . '" data-titulo="' . htmlspecialchars($proyecto['titulo']) . '" data-contenido="' . htmlspecialchars($proyecto['contenido']) . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarProyectoModal" data-id="' . htmlspecialchars($proyecto['id']) . '">
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
            error_log("Error al mostrar la tabla de proyectos: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los proyectos.</div>';
        }
    }

    public function mostrarTarjetaProyectos() {
        try {
            $proyectos = $this->obtenerProyectos();
            echo '<div class="container-fluid mt-5">
                    <div class="row">';
            if (empty($proyectos)) {
                echo '<div class="col-12 text-center">No hay proyectos disponibles.</div>';
            } else {
                foreach ($proyectos as $proyecto) {
                    echo '<div class="col-md-4">
                            <div class="card mb-4">
                                <div class="image-container" style="max-width: 80%; max-height: 800px; overflow: hidden; border-radius: 10px; margin-left: 40px; margin-top: 20px;">
                                    <!-- Aquí puedes agregar una imagen si es necesario -->
                                </div>
                                <div class="card-body" style="text-align: justify;">
                                    <h5 class="card-title text-center">' . htmlspecialchars($proyecto['titulo']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($proyecto['contenido']) . '</p>
                                </div>
                            </div>
                          </div>';
                }
            }
            echo '      </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas de proyectos: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los proyectos.</div>';
        }
    }
}
?>