<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $imagen = $_FILES['imagen'];

    // Verificar si se subió una imagen
    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($imagen['name']);
        $rutaUploads = __DIR__ . '/../../uploads';
        $rutaBlog = $rutaUploads . '/blog';

        // Crear las carpetas si no existen
        if (!is_dir($rutaUploads)) {
            mkdir($rutaUploads, 0777, true);
        }
        if (!is_dir($rutaBlog)) {
            mkdir($rutaBlog, 0777, true);
        }

        $rutaDestino = $rutaBlog . '/' . $nombreImagen;

        // Mover la imagen a la carpeta de destino
        if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
            try {
                $pdo = conectarBaseDeDatos();
                $sql = "INSERT INTO blog (titulo, contenido, imagen) VALUES (:titulo, :contenido, :imagen)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':titulo' => $titulo,
                    ':contenido' => $contenido,
                    ':imagen' => $nombreImagen
                ]);
                header('Location: ../../views/administrativo/blog.php');
                exit;
            } catch (PDOException $e) {
                error_log("Error al crear blog: " . $e->getMessage());
                echo '<div class="alert alert-danger" role="alert">Ocurrió un error al crear el blog: ' . htmlspecialchars($e->getMessage()) . '</div>';
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