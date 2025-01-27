<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "DELETE FROM galeria WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header('Location: ../../views/administrativo/galeria.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al eliminar galería: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al eliminar la galería: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>