<?php
include_once(__DIR__ . '/../../config/conexion.php');

class ObtenerParalelos {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT id_paralelo, nombre_paralelo FROM escuela.paralelos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generarSelect() {
        $paralelos = $this->obtenerTodos();
        $html = '<select class="form-control" id="id_paralelo_estudiante" name="id_paralelo_estudiante" required>';
        $html .= '<option value="" selected disabled>Seleccione un paralelo</option>';
        foreach ($paralelos as $paralelo) {
            $html .= '<option value="' . $paralelo['id_paralelo'] . '">' . $paralelo['nombre_paralelo'] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
?>