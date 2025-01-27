<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $imagen = $_FILES['imagen'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "UPDATE profesor SET nombre = :nombre, cargo = :cargo";

        // Verificar si se subió una nueva imagen
        if ($imagen['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = basename($imagen['name']);
            $rutaUploads = __DIR__ . '/../../uploads';
            $rutaProfesores = $rutaUploads . '/profesores';

            // Crear las carpetas si no existen
            if (!is_dir($rutaUploads)) {
                mkdir($rutaUploads, 0777, true);
            }
            if (!is_dir($rutaProfesores)) {
                mkdir($rutaProfesores, 0777, true);
            }

            $rutaDestino = $rutaProfesores . '/' . $nombreImagen;

            // Mover la imagen a la carpeta de destino
            if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                $sql .= ", imagen = :imagen";
            } else {
                echo '<div class="alert alert-danger" role="alert">Error al subir la imagen.</div>';
                exit;
            }
        }

        $sql .= " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $params = [
            ':nombre' => $nombre,
            ':cargo' => $cargo,
            ':id' => $id
        ];

        if (isset($nombreImagen)) {
            $params[':imagen'] = $nombreImagen;
        }

        $stmt->execute($params);
        header('Location: ../../views/administrativo/administrativa.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al editar profesor: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al editar el profesor: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>