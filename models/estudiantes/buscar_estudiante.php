<?php
include_once(__DIR__ . '/../../config/conexion.php');

class BuscarPersona {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorRolYPeriodo($tipo, $id_periodo) {
        $sql = "SELECT id_persona, cedula, nombres, apellidos, direccion, telefono, correo FROM escuela.personas WHERE rol = :tipo AND id_periodo = :id_periodo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':tipo' => $tipo, ':id_periodo' => $id_periodo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$pdo = conectarBaseDeDatos();
$buscarPersona = new BuscarPersona($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_persona = $_POST['tipo_persona'];
    $id_periodo = $_POST['id_periodo'];
    $personas = $buscarPersona->buscarPorRolYPeriodo($tipo_persona, $id_periodo);
    echo json_encode($personas);
}
?>