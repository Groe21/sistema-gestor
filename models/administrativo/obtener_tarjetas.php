<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarTarjetas {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTarjetas() {
        try {
            $sql = "SELECT * FROM tarjetas";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener tarjetas: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaTarjetas() {
        try {
            $tarjetas = $this->obtenerTarjetas();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearTarjetaModal">
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
            if (empty($tarjetas)) {
                echo '<tr><td colspan="3" class="text-center">No hay tarjetas disponibles.</td></tr>';
            } else {
                foreach ($tarjetas as $tarjeta) {
                    echo '<tr>
                            <td>' . htmlspecialchars($tarjeta['titulo']) . '</td>
                            <td>' . htmlspecialchars($tarjeta['contenido']) . '</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarTarjetaModal" data-id="' . htmlspecialchars($tarjeta['id']) . '" data-titulo="' . htmlspecialchars($tarjeta['titulo']) . '" data-contenido="' . htmlspecialchars($tarjeta['contenido']) . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarTarjetaModal" data-id="' . htmlspecialchars($tarjeta['id']) . '">
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
            error_log("Error al mostrar la tabla de tarjetas: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar las tarjetas.</div>';
        }
    }

    public function mostrarTarjetaTarjetas() {
        try {
            $tarjetas = $this->obtenerTarjetas();
            echo '<div class="container-fluid mt-5">
                    <div class="row">';
            if (empty($tarjetas)) {
                echo '<div class="col-12 text-center">No hay tarjetas disponibles.</div>';
            } else {
                foreach ($tarjetas as $tarjeta) {
                    echo '<div class="col-lg-4 col-md-6 pb-1">
                            <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px">
                                <i class="flaticon-022-drum h1 font-weight-normal text-primary mb-3"></i>
                                <div class="pl-4">
                                    <h4>' . htmlspecialchars($tarjeta['titulo']) . '</h4>
                                    <p class="m-0">' . htmlspecialchars($tarjeta['contenido']) . '</p>
                                </div>
                            </div>
                          </div>';
                }
            }
            echo '      </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar las tarjetas.</div>';
        }
    }
}
?>