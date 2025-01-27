<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarComunicados {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerComunicados() {
        try {
            $sql = "SELECT * FROM comunicados";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener comunicados: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaComunicados() {
        try {
            $comunicados = $this->obtenerComunicados();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearComunicadoModal">
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
            if (empty($comunicados)) {
                echo '<tr><td colspan="4" class="text-center">No hay comunicados disponibles.</td></tr>';
            } else {
                foreach ($comunicados as $comunicado) {
                    echo '<tr>
                            <td>' . htmlspecialchars($comunicado['titulo']) . '</td>
                            <td>' . htmlspecialchars($comunicado['contenido']) . '</td>
                            <td><img src="../../uploads/comunicados/' . htmlspecialchars($comunicado['imagen']) . '" class="img-thumbnail" width="100" height="50"/></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarComunicadoModal" data-id="' . htmlspecialchars($comunicado['id']) . '" data-titulo="' . htmlspecialchars($comunicado['titulo']) . '" data-contenido="' . htmlspecialchars($comunicado['contenido']) . '" data-imagen="' . htmlspecialchars($comunicado['imagen']) . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarComunicadoModal" data-id="' . htmlspecialchars($comunicado['id']) . '">
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
            error_log("Error al mostrar la tabla de comunicados: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los comunicados.</div>';
        }
    }

    public function mostrarTarjetasComunicados() {
        try {
            $comunicados = $this->obtenerComunicados();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">';
            if (empty($comunicados)) {
                echo '<div class="col-12 text-center">No hay comunicados disponibles.</div>';
            } else {
                foreach ($comunicados as $comunicado) {
                    // Alternar clases de tamaño de imagen
                    $imgClass = 'img-medium'; // Puedes cambiar esto según tus necesidades
                    echo '<div class="col-12 mb-4">
                            <div class="card h-100 shadow-sm rounded">
                                <img class="img-fluid rounded ' . $imgClass . ' mb-4" src="uploads/comunicados/' . htmlspecialchars($comunicado['imagen']) . '" alt="Imagen de Comunicado" />
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($comunicado['titulo']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($comunicado['contenido']) . '</p>
                                </div>
                            </div>
                          </div>';
                }
            }
            echo '      </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas de comunicados: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los comunicados.</div>';
        }
    }

    public function mostrarTarjetasComunicadosPrincipal() {
        try {
            $comunicados = $this->obtenerComunicados();
            echo '<div class="container-fluid mt-5">
                    <div class="row">';
            if (empty($comunicados)) {
                echo '<div class="col-12 text-center">No hay comunicados disponibles.</div>';
            } else {
                foreach ($comunicados as $comunicado) {
                    $contenido = implode(' ', array_slice(explode(' ', htmlspecialchars($comunicado['contenido'])), 0, 25)) . '...';
                    echo '<div class="col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm mb-2">
                                <img class="card-img-top mb-2" src="uploads/comunicados/' . htmlspecialchars($comunicado['imagen']) . '" alt="Imagen de Comunicado">
                                <div class="card-body bg-light text-center p-4">
                                    <h4 class="">' . htmlspecialchars($comunicado['titulo']) . '</h4>
                                    <p>' . $contenido . '</p>
                                    <a href="comunicados.php" class="btn btn-primary px-4 mx-auto my-2">Leer más</a>
                                </div>
                            </div>
                          </div>';
                }
            }
            echo '      </div>
                  </div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas de comunicados: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los comunicados.</div>';
        }
    }
}
?>