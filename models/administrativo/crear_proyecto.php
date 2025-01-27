<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "INSERT INTO proyectos (titulo, contenido) VALUES (:titulo, :contenido)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':contenido' => $contenido
        ]);
        header('Location: ../../views/administrativo/administrativa.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al crear proyecto: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al crear el proyecto: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>