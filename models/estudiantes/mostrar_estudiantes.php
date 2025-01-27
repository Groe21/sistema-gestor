<?php
include_once(__DIR__ . '/../../config/conexion.php');

class ListadoEstudiantes {
    private $pdo;
    private $obtenerPeriodos;

    public function __construct($pdo, $obtenerPeriodos) {
        $this->pdo = $pdo;
        $this->obtenerPeriodos = $obtenerPeriodos;
    }

    public function obtenerEstudiantes($id_periodo) {
        $sql = "SELECT 
                    e.id_estudiante,
                    e.cedula AS cedula_estudiante,
                    e.apellidos AS apellidos_estudiante,
                    e.nombres AS nombres_estudiante,
                    p.nombre_paralelo,
                    r.cedula AS cedula_representante,
                    r.apellidos AS apellidos_representante,
                    r.nombres AS nombres_representante,
                    r.telefono_celular AS telefono_representante
                FROM 
                    escuela.estudiantes e
                JOIN 
                    escuela.paralelos p ON e.id_paralelo = p.id_paralelo
                JOIN 
                    escuela.representante r ON e.id_representante = r.id_representante
                WHERE 
                    e.id_periodo = :id_periodo
                ORDER BY 
                    e.apellidos, e.nombres";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_periodo' => $id_periodo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarTablaEstudiantes($id_periodo = null) {
        $estudiantes = $this->obtenerEstudiantes($id_periodo);
        echo '<div class="container-fluid mt-5">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Lista de Estudiantes</h4>
                                <form method="GET" action="" class="form-inline">
                                    <div class="form-group mb-0">
                                        <label for="id_periodo" class="mr-2">Periodo:</label>
                                        ' . $this->generarSelectPeriodos() . '
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-sm ml-2">Filtrar</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaEstudiantes" class="table table-bordered table-striped w-100">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Cédula Estudiante</th>
                                                <th>Apellidos Estudiante</th>
                                                <th>Nombres Estudiante</th>
                                                <th>Paralelo</th>
                                                <th>Cédula Representante</th>
                                                <th>Apellidos Representante</th>
                                                <th>Nombres Representante</th>
                                                <th>Teléfono Representante</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
        if (empty($estudiantes)) {
            echo '<tr><td colspan="9" class="text-center">No hay estudiantes en este periodo.</td></tr>';
        } else {
            foreach ($estudiantes as $estudiante) {
                echo '<tr>
                        <td>' . htmlspecialchars($estudiante['cedula_estudiante']) . '</td>
                        <td>' . htmlspecialchars($estudiante['apellidos_estudiante']) . '</td>
                        <td>' . htmlspecialchars($estudiante['nombres_estudiante']) . '</td>
                        <td>' . htmlspecialchars($estudiante['nombre_paralelo']) . '</td>
                        <td>' . htmlspecialchars($estudiante['cedula_representante']) . '</td>
                        <td>' . htmlspecialchars($estudiante['apellidos_representante']) . '</td>
                        <td>' . htmlspecialchars($estudiante['nombres_representante']) . '</td>
                        <td>' . htmlspecialchars($estudiante['telefono_representante']) . '</td>
                        <td>
                             <form method="POST" action="' . BASE_URL . '/models/estudiantes/generar_pdf.php">
                                <input type="hidden" name="id_estudiante" value="' . htmlspecialchars($estudiante['id_estudiante']) . '">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i> Generar
                                </button>
                            </form>
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
    }

    private function generarSelectPeriodos() {
        return $this->obtenerPeriodos->generarSelect();
    }
}
?>