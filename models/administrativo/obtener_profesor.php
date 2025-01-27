<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarProfesores {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerProfesores() {
        try {
            $sql = "SELECT * FROM profesor";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener profesores: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaProfesores() {
        try {
            $profesores = $this->obtenerProfesores();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearProfesorModal">
                                        <i class="fas fa-plus"></i> Crear
                                    </button>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Cargo</th>
                                                    <th>Imagen</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (empty($profesores)) {
                echo '<tr><td colspan="4" class="text-center">No hay profesores disponibles.</td></tr>';
            } else {
                foreach ($profesores as $profesor) {
                    echo '<tr>
                            <td>' . htmlspecialchars($profesor['nombre']) . '</td>
                            <td>' . htmlspecialchars($profesor['cargo']) . '</td>
                            <td><img src="../../uploads/profesores/' . htmlspecialchars($profesor['imagen']) . '" class="img-thumbnail" width="100" height="50"/></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarProfesorModal" data-id="' . htmlspecialchars($profesor['id']) . '" data-nombre="' . htmlspecialchars($profesor['nombre']) . '" data-cargo="' . htmlspecialchars($profesor['cargo']) . '" data-imagen="' . htmlspecialchars($profesor['imagen']) . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarProfesorModal" data-id="' . htmlspecialchars($profesor['id']) . '">
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
            error_log("Error al mostrar la tabla de profesores: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los profesores.</div>';
        }
    }

    public function mostrarTarjetaProfesores() {
        try {
            $profesores = $this->obtenerProfesores();
            echo '<div class="container-fluid mt-5">
                    <div class="row">';
            if (empty($profesores)) {
                echo '<div class="col-12 text-center">No hay profesores disponibles.</div>';
            } else {
                foreach ($profesores as $profesor) {
                    echo '<div class="col-md-6 col-lg-3 text-center team mb-5">
                            <div class="position-relative overflow-hidden mb-4 mx-auto" style="border-radius: 100%; width: 200px; height: 200px; overflow: hidden;">
                                <img class="img-fluid" src="uploads/profesores/' . htmlspecialchars($profesor['imagen']) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;">
                                <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                                    <!-- Social icons can be placed here -->
                                </div>
                            </div>
                            <h4>' . htmlspecialchars($profesor['nombre']) . '</h4>
                            <i>' . htmlspecialchars($profesor['cargo']) . '</i>
                          </div>';
                }
            }
            echo '      </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas de profesores: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los profesores.</div>';
        }
    }
}
?>