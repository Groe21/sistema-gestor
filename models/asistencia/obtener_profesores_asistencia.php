<?php
include_once(__DIR__ . '/../../config/conexion.php');

class ListadoProfesores {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerEstudiantesConAsistencia($id_periodo, $id_paralelo, $fechas) {
        $sql = "SELECT 
                    e.id_estudiante,
                    e.nombres,
                    e.apellidos,
                    a_lunes.id_asistencia AS asistencia_lunes,
                    a_martes.id_asistencia AS asistencia_martes,
                    a_miercoles.id_asistencia AS asistencia_miercoles,
                    a_jueves.id_asistencia AS asistencia_jueves,
                    a_viernes.id_asistencia AS asistencia_viernes
                FROM 
                    escuela.estudiantes e
                LEFT JOIN 
                    escuela.asistencia a_lunes ON e.id_estudiante = a_lunes.id_estudiante AND a_lunes.fecha = :fecha_lunes
                LEFT JOIN 
                    escuela.asistencia a_martes ON e.id_estudiante = a_martes.id_estudiante AND a_martes.fecha = :fecha_martes
                LEFT JOIN 
                    escuela.asistencia a_miercoles ON e.id_estudiante = a_miercoles.id_estudiante AND a_miercoles.fecha = :fecha_miercoles
                LEFT JOIN 
                    escuela.asistencia a_jueves ON e.id_estudiante = a_jueves.id_estudiante AND a_jueves.fecha = :fecha_jueves
                LEFT JOIN 
                    escuela.asistencia a_viernes ON e.id_estudiante = a_viernes.id_estudiante AND a_viernes.fecha = :fecha_viernes
                WHERE 
                    e.id_periodo = :id_periodo";
        
        if ($id_paralelo !== null) {
            $sql .= " AND e.id_paralelo = :id_paralelo";
        }

        $sql .= " ORDER BY e.apellidos, e.nombres";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_lunes', $fechas['lunes'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_martes', $fechas['martes'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_miercoles', $fechas['miercoles'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_jueves', $fechas['jueves'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_viernes', $fechas['viernes'], PDO::PARAM_STR);
        
        if ($id_paralelo !== null) {
            $stmt->bindParam(':id_paralelo', $id_paralelo, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarTablaEstudiantesConAsistencia($id_periodo, $id_paralelo) {
        $fechas = $this->obtenerFechasSemana();
        $estudiantes = $this->obtenerEstudiantesConAsistencia($id_periodo, $id_paralelo, $fechas);
        echo '<div class="container-fluid mt-5">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Estudiantes con Asistencia</h4>
                                <form method="GET" action="" class="form-inline">
                                    <div class="form-group mb-0">
                                        <label for="id_periodo" class="mr-2">Periodo:</label>
                                        ' . $this->generarSelectPeriodos($id_periodo) . '
                                    </div>
                                    <div class="form-group mb-0 ml-3">
                                        <label for="id_paralelo" class="mr-2">Paralelo:</label>
                                        ' . $this->generarSelectParalelos($id_paralelo) . '
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-sm ml-2">Filtrar</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaEstudiantes" class="table table-bordered table-striped w-100">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Nombre Estudiante</th>
                                                <th>Lunes</th>
                                                <th>Martes</th>
                                                <th>Miércoles</th>
                                                <th>Jueves</th>
                                                <th>Viernes</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
        if (empty($estudiantes)) {
            echo '<tr><td colspan="7" class="text-center">No hay estudiantes en este periodo.</td></tr>';
        } else {
            foreach ($estudiantes as $estudiante) {
                echo '<tr>
                        <td>' . htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) . '</td>';
                foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia) {
                    echo '<td class="text-center">';
                    if ($estudiante['asistencia_' . $dia] == null) {
                        echo '<button class="btn btn-success btn-sm" onclick="darAsistencia(' . htmlspecialchars($estudiante['id_estudiante']) . ', \'' . $fechas[$dia] . '\')">
                                <i class="fas fa-check"></i> Dar Asistencia
                              </button>';
                    } else {
                        echo 'Sí';
                    }
                    echo '</td>';
                }
                echo '  <td class="text-center">
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSemanalEstudiante" data-id-estudiante="' . htmlspecialchars($estudiante['id_estudiante']) . '">
                                <i class="fas fa-file-pdf"></i> Semanal
                            </button>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalMensualEstudiante" data-id-estudiante="' . htmlspecialchars($estudiante['id_estudiante']) . '">
                                <i class="fas fa-calendar-alt"></i> Mensual
                            </button>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAnualEstudiante" data-id-estudiante="' . htmlspecialchars($estudiante['id_estudiante']) . '">
                                <i class="fas fa-calendar"></i> Anual
                            </button>
                        </td>
                      </tr>';
            }
        }
        echo '              </tbody>
                                    </table>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalSemanalGeneral" data-id-periodo="' . htmlspecialchars($id_periodo) . '" data-id-paralelo="' . htmlspecialchars($id_paralelo) . '">
                                            <i class="fas fa-calendar-week"></i> Asistencia Semanal
                                        </button>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#modalMensualGeneral" data-id-periodo="' . htmlspecialchars($id_periodo) . '" data-id-paralelo="' . htmlspecialchars($id_paralelo) . '">
                                            <i class="fas fa-calendar-alt"></i> Asistencia Mensual
                                        </button>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#modalAnualGeneral" data-id-periodo="' . htmlspecialchars($id_periodo) . '" data-id-paralelo="' . htmlspecialchars($id_paralelo) . '">
                                            <i class="fas fa-calendar"></i> Asistencia Anual
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>';
    
        // Modales para seleccionar fechas
        echo $this->generarModales();
    }
    
    private function generarModales() {
        return '
        <!-- Modal Semanal Estudiante -->
        <div class="modal fade" id="modalSemanalEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalSemanalEstudianteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSemanalEstudianteLabel">Seleccionar Semana</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formSemanalEstudiante">
                            <div class="form-group">
                                <label for="fechaSemanalEstudiante">Fecha de inicio de la semana</label>
                                <input type="date" class="form-control" id="fechaSemanalEstudiante" name="fecha">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modal Mensual Estudiante -->
        <div class="modal fade" id="modalMensualEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalMensualEstudianteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMensualEstudianteLabel">Seleccionar Mes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formMensualEstudiante">
                            <div class="form-group">
                                <label for="fechaMensualEstudiante">Fecha de inicio del mes</label>
                                <input type="month" class="form-control" id="fechaMensualEstudiante" name="fecha">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modal Anual Estudiante -->
        <div class="modal fade" id="modalAnualEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalAnualEstudianteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAnualEstudianteLabel">Seleccionar Año</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAnualEstudiante">
                            <div class="form-group">
                                <label for="fechaAnualEstudiante">Fecha de inicio del año</label>
                                <input type="number" class="form-control" id="fechaAnualEstudiante" name="fecha" min="2000" max="2100">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modal Semanal General -->
        <div class="modal fade" id="modalSemanalGeneral" tabindex="-1" role="dialog" aria-labelledby="modalSemanalGeneralLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSemanalGeneralLabel">Seleccionar Semana</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formSemanalGeneral">
                            <div class="form-group">
                                <label for="fechaSemanalGeneral">Fecha de inicio de la semana</label>
                                <input type="date" class="form-control" id="fechaSemanalGeneral" name="fecha">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modal Mensual General -->
        <div class="modal fade" id="modalMensualGeneral" tabindex="-1" role="dialog" aria-labelledby="modalMensualGeneralLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMensualGeneralLabel">Seleccionar Mes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formMensualGeneral">
                            <div class="form-group">
                                <label for="fechaMensualGeneral">Fecha de inicio del mes</label>
                                <input type="month" class="form-control" id="fechaMensualGeneral" name="fecha">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modal Anual General -->
        <div class="modal fade" id="modalAnualGeneral" tabindex="-1" role="dialog" aria-labelledby="modalAnualGeneralLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAnualGeneralLabel">Seleccionar Año</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAnualGeneral">
                            <div class="form-group">
                                <label for="fechaAnualGeneral">Fecha de inicio del año</label>
                                <input type="number" class="form-control" id="fechaAnualGeneral" name="fecha" min="2000" max="2100">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function obtenerFechasSemana() {
        $fechas = [];
        $inicioSemana = strtotime('last monday', strtotime('tomorrow'));
        $fechas['lunes'] = date('Y-m-d', $inicioSemana);
        $fechas['martes'] = date('Y-m-d', strtotime('+1 day', $inicioSemana));
        $fechas['miercoles'] = date('Y-m-d', strtotime('+2 days', $inicioSemana));
        $fechas['jueves'] = date('Y-m-d', strtotime('+3 days', $inicioSemana));
        $fechas['viernes'] = date('Y-m-d', strtotime('+4 days', $inicioSemana));
        return $fechas;
    }

    private function generarSelectPeriodos($selected_periodo = null) {
        $periodos = $this->obtenerPeriodos();
        $html = '<select class="form-control" id="id_periodo" name="id_periodo">';
        $html .= '<option value="">Seleccione un periodo</option>';
        foreach ($periodos as $periodo) {
            $selected = ($selected_periodo == $periodo['id_periodo']) ? 'selected' : '';
            $html .= '<option value="' . $periodo['id_periodo'] . '" ' . $selected . '>' . $periodo['nombre_periodo'] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    private function generarSelectParalelos($selected_paralelo = null) {
        $paralelos = $this->obtenerParalelos();
        $html = '<select class="form-control" id="id_paralelo" name="id_paralelo">';
        $html .= '<option value="">Seleccione un paralelo</option>';
        foreach ($paralelos as $paralelo) {
            $selected = ($selected_paralelo == $paralelo['id_paralelo']) ? 'selected' : '';
            $html .= '<option value="' . $paralelo['id_paralelo'] . '" ' . $selected . '>' . $paralelo['nombre_paralelo'] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    private function obtenerPeriodos() {
        $sql = "SELECT * FROM escuela.periodos_lectivos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerParalelos() {
        $sql = "SELECT * FROM escuela.paralelos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>