<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarGaleria {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerGalerias() {
        try {
            $sql = "SELECT * FROM galeria";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener galerías: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFotos($galeria_id) {
        try {
            $sql = "SELECT * FROM fotos WHERE galeria_id = :galeria_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':galeria_id' => $galeria_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener fotos: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarGalerias() {
        try {
            $galerias = $this->obtenerGalerias();
            echo '<div class="container-fluid pt-2 pb-3">';
            if (empty($galerias)) {
                echo '<div class="text-center">No hay galerías disponibles.</div>';
            } else {
                foreach ($galerias as $galeria) {
                    echo '<div class="container">
                            <div class="text-center pb-2">
                                <p class="section-title px-5">
                                    <span class="px-2">' . htmlspecialchars($galeria['titulo']) . '</span>
                                </p>
                                <h1 class="mb-4">' . htmlspecialchars($galeria['descripcion']) . '</h1>
                            </div>
                            <div class="row portfolio-container">';
                    $fotos = $this->obtenerFotos($galeria['id']);
                    foreach ($fotos as $foto) {
                        echo '<div class="col-lg-4 col-md-6 mb-4 portfolio-item">
                                <div class="position-relative overflow-hidden mb-2">
                                    <img class="img-fluid w-100" src="' . htmlspecialchars($foto['ruta']) . '" />
                                    <div class="portfolio-btn bg-primary d-flex align-items-center justify-content-center">
                                        <a href="' . htmlspecialchars($foto['ruta']) . '" data-lightbox="portfolio">
                                            <i class="fa fa-plus text-white" style="font-size: 60px"></i>
                                        </a>
                                    </div>
                                </div>
                              </div>';
                    }
                    echo '      </div>
                          </div>';
                }
            }
            echo '</div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las galerías: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar las galerías.</div>';
        }
    }

    public function obtenerTablaGalerias() {
        try {
            $galerias = $this->obtenerGalerias();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearGaleriaModal">
                                        <i class="fas fa-plus"></i> Crear
                                    </button>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Título</th>
                                                    <th>Descripción</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (empty($galerias)) {
                echo '<tr><td colspan="3" class="text-center">No hay galerías disponibles.</td></tr>';
            } else {
                foreach ($galerias as $galeria) {
                    echo '<tr>
                            <td>' . htmlspecialchars($galeria['titulo']) . '</td>
                            <td>' . htmlspecialchars($galeria['descripcion']) . '</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarGaleriaModal" data-id="' . htmlspecialchars($galeria['id']) . '">
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
            error_log("Error al mostrar la tabla de galerías: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar las galerías.</div>';
        }
    }
}
?>