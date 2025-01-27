<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_paralelo = $_POST['nombre_paralelo'];

    $pdo = conectarBaseDeDatos();
    $crearParalelo = new CrearParalelo($pdo);
    $crearParalelo->insertarParalelo($nombre_paralelo);

    header('Location: ../../views/escuela/gestionar_cursos.php');
    exit();
}

class CrearParalelo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertarParalelo($nombre_paralelo) {
        $sql = "INSERT INTO escuela.paralelos (nombre_paralelo) VALUES (:nombre_paralelo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre_paralelo' => $nombre_paralelo]);
    }
}
?>