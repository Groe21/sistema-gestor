<?php
include_once(__DIR__ . '/../../config/conexion.php');

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id_paralelo = $_GET['id_paralelo'];
        $id_periodo = $_GET['id_periodo'];

        $pdo = conectarBaseDeDatos();
        $sql = "SELECT 
                    e.id_estudiante,
                    CONCAT(e.nombres, ' ', e.apellidos) AS nombre_completo,
                    a.fecha,
                    a.estado
                FROM 
                    escuela.estudiantes e
                LEFT JOIN 
                    escuela.asistencia a ON e.id_estudiante = a.id_estudiante
                WHERE 
                    e.id_paralelo = :id_paralelo
                AND 
                    e.id_periodo = :id_periodo
                ORDER BY 
                    e.apellidos, e.nombres";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_paralelo', $id_paralelo, PDO::PARAM_INT);
        $stmt->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);
        $stmt->execute();
        $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($estudiantes);
    } else {
        echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>