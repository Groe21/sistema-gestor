<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "UPDATE proyectos SET titulo = :titulo, contenido = :contenido WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':contenido' => $contenido,
            ':id' => $id
        ]);
        header('Location: ../../views/administrativo/administrativa.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al editar proyecto: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al editar el proyecto: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>