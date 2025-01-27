<?php
class ObtenerPeriodos {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT id_periodo, nombre_periodo FROM escuela.periodos_lectivos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generarSelect() {
        $periodos = $this->obtenerTodos();
        $html = '<select class="form-control" id="id_periodo_buscar" name="id_periodo">';
        $html .= '<option value="">Seleccione un periodo</option>';
        foreach ($periodos as $periodo) {
            $html .= '<option value="' . $periodo['id_periodo'] . '">' . $periodo['nombre_periodo'] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
?>