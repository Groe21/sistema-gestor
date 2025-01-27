<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarPadres {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPadres() {
        try {
            $sql = "SELECT * FROM padres";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener padres: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaPadres() {
        try {
            $padres = $this->obtenerPadres();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-warning mb-4" data-toggle="modal" data-target="#crearPadreModal">
                                        <i class="fas fa-plus"></i> Crear
                                    </button>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Comentario</th>
                                                    <th>Imagen</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (empty($padres)) {
                echo '<tr><td colspan="4" class="text-center">No hay padres disponibles.</td></tr>';
            } else {
                foreach ($padres as $padre) {
                    echo '<tr>
                            <td>' . htmlspecialchars($padre['nombre']) . '</td>
                            <td>' . htmlspecialchars($padre['comentario']) . '</td>';
                    if (!empty($padre['imagen'])) {
                        echo '<td><img src="../../uploads/padres/' . htmlspecialchars($padre['imagen']) . '" class="img-thumbnail" width="100" height="50"/>
                              <input type="hidden" name="foto_oculta" value="' . htmlspecialchars($padre['imagen']) . '" /></td>';
                    } else {
                        echo '<td><input type="hidden" name="foto_oculta" value="" /></td>';
                    }
                    echo '<td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarPadreModal" data-id="' . htmlspecialchars($padre['id']) . '" data-nombre="' . htmlspecialchars($padre['nombre']) . '" data-comentario="' . htmlspecialchars($padre['comentario']) . '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarPadreModal" data-id="' . htmlspecialchars($padre['id']) . '">
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
            error_log("Error al mostrar la tabla de padres: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los padres.</div>';
        }
    }

    public function mostrarTarjetaPadres() {
        try {
            $padres = $this->obtenerPadres();
            echo '<div class="owl-carousel testimonial-carousel">';
            if (empty($padres)) {
                echo '<div class="testimonial-item">
                        <div class="testimonial-quote">
                            <p>No hay padres disponibles.</p>
                        </div>
                      </div>';
            } else {
                foreach ($padres as $padre) {
                    echo '<div class="testimonial-item">
                            <div class="testimonial-quote">
                                <p>' . htmlspecialchars($padre['comentario']) . '</p>
                            </div>
                            <div class="testimonial-profile">';
                    if (!empty($padre['imagen'])) {
                        echo '<img class="profile-img" src="uploads/padres/' . htmlspecialchars($padre['imagen']) . '">';
                    } else {
                        echo '<img class="profile-img" src="img/perfil.png">';
                    }
                    echo '      <div class="profile-info">
                                    <h5>' . htmlspecialchars($padre['nombre']) . '</h5>
                                </div>
                            </div>
                          </div>';
                }
            }
            echo '</div>';
        } catch (Exception $e) {
            error_log("Error al mostrar las tarjetas de padres: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar los padres.</div>';
        }
    }
}
?>