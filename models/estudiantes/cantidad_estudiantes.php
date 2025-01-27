<?php
include_once(__DIR__ . '/../../config/conexion.php');

class CantidadEstudiantes {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerCantidadEstudiantes() {
        $sql = "SELECT COUNT(*) as cantidad FROM escuela.estudiantes"; // Contar todos los estudiantes en la tabla estudiantes
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cantidad'];
    }

    public function mostrarCardEstudiantes() {
        $cantidad = $this->obtenerCantidadEstudiantes();
        echo '<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Estudiantes Matriculados
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">' . htmlspecialchars($cantidad) . '</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
              </div>';
    }
    
}
?>