<?php
include_once(__DIR__ . '/../../config/conexion.php');

class InsertarPeriodo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertar($nombre_periodo, $fecha_inicio, $fecha_fin) {
        $sql = "INSERT INTO escuela.periodos_lectivos (nombre_periodo, fecha_inicio, fecha_fin) VALUES (:nombre_periodo, :fecha_inicio, :fecha_fin)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre_periodo', $nombre_periodo);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        return $stmt->execute();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_periodo = $_POST['nombre_periodo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $pdo = conectarBaseDeDatos();
    if ($pdo) {
        $insertarPeriodo = new InsertarPeriodo($pdo);
        if ($insertarPeriodo->insertar($nombre_periodo, $fecha_inicio, $fecha_fin)) {
            echo "Periodo insertado correctamente.";
        } else {
            echo "Error al insertar el periodo.";
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}
?>