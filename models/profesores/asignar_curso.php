<?php
include_once(__DIR__ . '/../../config/conexion.php');

class AsignarCurso {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerParalelos() {
        $sql = "SELECT * FROM escuela.paralelos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarCursoAProfesor($idProfesor, $idParalelo) {
        $sql = "UPDATE escuela.profesores SET id_paralelo = :idParalelo WHERE id_profesor = :idProfesor";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idParalelo', $idParalelo, PDO::PARAM_INT);
        $stmt->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

header('Content-Type: application/json');

try {
    $pdo = conectarBaseDeDatos();
    $asignarCurso = new AsignarCurso($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener_paralelos') {
        $paralelos = $asignarCurso->obtenerParalelos();
        echo json_encode($paralelos);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idProfesor = $_POST['profesorId'];
        $idParalelo = $_POST['curso'];

        if ($asignarCurso->asignarCursoAProfesor($idProfesor, $idParalelo)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>