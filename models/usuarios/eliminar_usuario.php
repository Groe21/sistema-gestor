<?php
include_once(__DIR__ . '/../../config/conexion.php');

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = $data['userId'];

        // Depuración
        if (!$userId) {
            echo json_encode(['success' => false, 'error' => 'ID de usuario no proporcionado']);
            exit;
        }

        $pdo = conectarBaseDeDatos();
        $sql = "DELETE FROM escuela.usuarios WHERE id_usuario = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>