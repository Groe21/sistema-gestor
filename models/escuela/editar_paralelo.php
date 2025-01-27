<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_paralelo = $_POST['id_paralelo'];
    $nombre_paralelo = $_POST['nombre_paralelo'];

    $pdo = conectarBaseDeDatos();
    $editarParalelo = new EditarParalelo($pdo);
    $editarParalelo->actualizarParalelo($id_paralelo, $nombre_paralelo);

    header('Location: ../../views/escuela/gestionar_cursos.php');
    exit();
}

class EditarParalelo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerParaleloPorId($id_paralelo) {
        $sql = "SELECT * FROM escuela.paralelos WHERE id_paralelo = :id_paralelo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_paralelo' => $id_paralelo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarParalelo($id_paralelo, $nombre_paralelo) {
        $sql = "UPDATE escuela.paralelos SET nombre_paralelo = :nombre_paralelo WHERE id_paralelo = :id_paralelo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre_paralelo' => $nombre_paralelo, ':id_paralelo' => $id_paralelo]);
    }
}
?>