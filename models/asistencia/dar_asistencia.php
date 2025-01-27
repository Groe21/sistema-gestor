<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $fecha = $_POST['fecha'];

    $pdo = conectarBaseDeDatos();

    // Verificar si ya existe un registro de asistencia para el estudiante y la fecha
    $sql = "SELECT id_asistencia FROM escuela.asistencia WHERE id_estudiante = :id_estudiante AND fecha = :fecha";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->execute();
    $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($asistencia) {
        // Si ya existe un registro, actualizar el estado
        $sql = "UPDATE escuela.asistencia SET estado = 'Presente' WHERE id_asistencia = :id_asistencia";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_asistencia', $asistencia['id_asistencia'], PDO::PARAM_INT);
    } else {
        // Si no existe un registro, insertar uno nuevo
        $sql = "INSERT INTO escuela.asistencia (id_estudiante, fecha, estado) VALUES (:id_estudiante, :fecha, 'Presente')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>