<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $imagen = $_FILES['imagen'];

    // Verificar si se subió una imagen
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
            try {
                $pdo = conectarBaseDeDatos();
                $sql = "INSERT INTO profesor (nombre, cargo, imagen) VALUES (:nombre, :cargo, :imagen)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':cargo' => $cargo,
                    ':imagen' => $nombreImagen
                ]);
                header('Location: ../../views/administrativo/administrativa.php');
                exit;
            } catch (PDOException $e) {
                error_log("Error al crear profesor: " . $e->getMessage());
                echo '<div class="alert alert-danger" role="alert">Ocurrió un error al crear el profesor: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Error al subir la imagen.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Debe seleccionar una imagen.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>