<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_paralelo = $_POST['id_paralelo'];

    $pdo = conectarBaseDeDatos();
    $eliminarParalelo = new EliminarParalelo($pdo);
    $eliminarParalelo->eliminarParalelo($id_paralelo);

    header('Location: ../../views/escuela/gestionar_cursos.php');
    exit();
}

class EliminarParalelo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function eliminarParalelo($id_paralelo) {
        $sql = "DELETE FROM escuela.paralelos WHERE id_paralelo = :id_paralelo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_paralelo' => $id_paralelo]);
    }
}
?>