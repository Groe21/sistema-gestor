<?php
include_once(__DIR__ . '/../../config/conexion.php');

class ObtenerProfesor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerProfesores($id_periodo = null) {
        $sql = "SELECT p.id_profesor, p.nombre, p.id_periodo, pa.nombre_paralelo, pl.nombre_periodo
                FROM escuela.profesores p
                LEFT JOIN escuela.asignaciones a ON p.id_profesor = a.id_profesor
                LEFT JOIN escuela.paralelos pa ON a.id_paralelo = pa.id_paralelo
                LEFT JOIN escuela.periodos_lectivos pl ON p.id_periodo = pl.id_periodo";
        
        if ($id_periodo !== null) {
            $sql .= " WHERE p.id_periodo = :id_periodo";
        }

        $stmt = $this->pdo->prepare($sql);
        
        if ($id_periodo !== null) {
            $stmt->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerParalelos() {
        $sql = "SELECT * FROM escuela.paralelos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarCursoAProfesor($idProfesor, $idParalelo) {
        $sql = "INSERT INTO escuela.asignaciones (id_profesor, id_paralelo) VALUES (:idProfesor, :idParalelo)
                ON CONFLICT (id_profesor, id_paralelo) DO NOTHING";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idParalelo', $idParalelo, PDO::PARAM_INT);
        $stmt->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function generarSelectPeriodos() {
        $periodos = $this->obtenerPeriodos();
        $html = '<select class="form-control" id="id_periodo" name="id_periodo">';
        $html .= '<option value="">Seleccione un periodo</option>';
        foreach ($periodos as $periodo) {
            $html .= '<option value="' . $periodo['id_periodo'] . '">' . $periodo['nombre_periodo'] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function obtenerPeriodos() {
        $sql = "SELECT * FROM escuela.periodos_lectivos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarTablaProfesores($id_periodo = null) {
        $profesores = $this->obtenerProfesores($id_periodo);
        echo '<div class="container-fluid mt-5">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h4 class="mb-0">Lista de Profesores</h4>
                                    </div>
                                    <div class="col-md-8 text-right">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form method="GET" action="" class="form-inline">
                                                    <div class="form-group mb-0">
                                                        ' . $this->generarSelectPeriodos() . '
                                                    </div>
                                                    <button type="submit" class="btn btn-secondary btn-sm ml-2">Filtrar</button>
                                                </form>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#crearProfesorModal">
                                                    <i class="fas fa-plus"></i> Crear Profesor
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped w-100">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Curso</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if (empty($profesores)) {
            echo '<tr><td colspan="3" class="text-center">No hay profesores disponibles en este periodo.</td></tr>';
        } else {
            foreach ($profesores as $profesor) {
                echo '<tr>
                        <td>' . htmlspecialchars($profesor['nombre']) . '</td>
                        <td>' . ($profesor['nombre_paralelo'] ? htmlspecialchars($profesor['nombre_paralelo']) : '<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#asignarCursoModal" data-id="' . htmlspecialchars($profesor['id_profesor']) . '"><i class="fas fa-plus"></i> Asignar Curso</button>') . '</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarProfesorModal" data-id="' . htmlspecialchars($profesor['id_profesor']) . '" data-nombre="' . htmlspecialchars($profesor['nombre']) . '" data-periodo="' . htmlspecialchars($profesor['id_periodo']) . '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarProfesorModal" data-id="' . htmlspecialchars($profesor['id_profesor']) . '">
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
              </div>';
    }
}