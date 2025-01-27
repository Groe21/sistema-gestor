<?php
include_once(__DIR__ . '/../../config/conexion.php');

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_profesor = $_POST['id_profesor'];

        $pdo = conectarBaseDeDatos();
        $sql = "DELETE FROM escuela.profesores WHERE id_profesor = :id_profesor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_profesor', $id_profesor, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>