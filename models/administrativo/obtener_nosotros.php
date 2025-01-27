<?php
include_once(__DIR__ . '/../../config/conexion.php');

class MostrarNosotros {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerNosotros() {
        try {
            $sql = "SELECT * FROM nosotros";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener nosotros: " . $e->getMessage());
            return [];
        }
    }

    public function mostrarTablaNosotros() {
        try {
            $nosotros = $this->obtenerNosotros();
            echo '<div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Información de Nosotros</h4>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped w-100">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Título</th>
                                                    <th>Contenido</th>
                                                    <th>Imagen Principal</th>
                                                    <th>Imagen Secundaria</th>
                                                    <th>Descripción 1</th>
                                                    <th>Descripción 2</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (empty($nosotros)) {
                echo '<tr><td colspan="7" class="text-center">No hay información disponible.</td></tr>';
            } else {
                foreach ($nosotros as $info) {
                    echo '<tr>
                            <td>' . htmlspecialchars($info['titulo']) . '</td>
                            <td>' . htmlspecialchars($info['contenido']) . '</td>
                            <td><img src="../../uploads/nosotros/' . htmlspecialchars($info['imagen_principal']) . '" class="img-thumbnail" width="100" height="50"/></td>
                            <td><img src="../../uploads/nosotros/' . htmlspecialchars($info['imagen_secundaria']) . '" class="img-thumbnail" width="100" height="50"/></td>
                            <td>' . htmlspecialchars($info['descripcion1']) . '</td>
                            <td>' . htmlspecialchars($info['descripcion2']) . '</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarNosotrosModal" data-id="' . htmlspecialchars($info['id']) . '" data-titulo="' . htmlspecialchars($info['titulo']) . '" data-contenido="' . htmlspecialchars($info['contenido']) . '" data-imagen_principal="' . htmlspecialchars($info['imagen_principal']) . '" data-imagen_secundaria="' . htmlspecialchars($info['imagen_secundaria']) . '" data-descripcion1="' . htmlspecialchars($info['descripcion1']) . '" data-descripcion2="' . htmlspecialchars($info['descripcion2']) . '">
                                    <i class="fas fa-edit"></i>
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
            error_log("Error al mostrar la tabla de nosotros: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar la información de nosotros.</div>';
        }
    }

    public function mostrarNosotros() {
        try {
            $nosotros = $this->obtenerNosotros();
            if (empty($nosotros)) {
                echo '<div class="container-fluid mt-5">
                        <div class="row align-items-center">
                            <div class="col-12 text-center">No hay información disponible.</div>
                        </div>
                      </div>';
            } else {
                foreach ($nosotros as $info) {
                    echo '<div class="container-fluid mt-5">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <img class="img-fluid rounded mb-5 mb-lg-0" src="uploads/nosotros/' . htmlspecialchars($info['imagen_principal']) . '" alt="">
                                </div>
                                <div class="col-lg-7">
                                    <p class="section-title pr-5">
                                        <span>Sobre Nosotros</span>
                                    </p>
                                    <h1 class="mb-4">' . htmlspecialchars($info['titulo']) . '</h1>
                                    <p>' . htmlspecialchars($info['contenido']) . '</p>
                                    <div class="row pt-2 pb-4">
                                        <div class="col-6 col-md-4">
                                            <img class="img-fluid rounded" src="uploads/nosotros/' . htmlspecialchars($info['imagen_secundaria']) . '" alt="">
                                        </div>
                                        <div class="col-6 col-md-8">
                                            <ul class="list-inline m-0">
                                                <li class="py-2 border-top border-bottom">
                                                    <i class="fa fa-check text-primary mr-3"></i>' . htmlspecialchars($info['descripcion1']) . '
                                                </li>
                                                <li class="py-2 border-bottom">
                                                    <i class="fa fa-check text-primary mr-3"></i>' . htmlspecialchars($info['descripcion2']) . '
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>';
                }
            }
        } catch (Exception $e) {
            error_log("Error al mostrar la información de nosotros: " . $e->getMessage());
            echo '<div class="alert alert-danger" role="alert">Ocurrió un error al mostrar la información de nosotros.</div>';
        }
    }
}
?>