<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fotos = $_FILES['fotos'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "INSERT INTO galeria (titulo, descripcion) VALUES (:titulo, :descripcion)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion
        ]);
        $galeria_id = $pdo->lastInsertId();

        $rutaUploads = __DIR__ . '/../../uploads';
        $rutaGaleria = $rutaUploads . '/galeria';

        // Crear las carpetas si no existen
        if (!is_dir($rutaUploads)) {
            mkdir($rutaUploads, 0777, true);
        }
        if (!is_dir($rutaGaleria)) {
            mkdir($rutaGaleria, 0777, true);
        }

        foreach ($fotos['tmp_name'] as $key => $tmp_name) {
            if ($fotos['error'][$key] === UPLOAD_ERR_OK) {
                $nombreFoto = basename($fotos['name'][$key]);
                $rutaDestino = $rutaGaleria . '/' . $nombreFoto;

                // Mover la imagen a la carpeta de destino
                if (move_uploaded_file($tmp_name, $rutaDestino)) {
                    $sql = "INSERT INTO fotos (galeria_id, ruta) VALUES (:galeria_id, :ruta)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':galeria_id' => $galeria_id,
                        ':ruta' => 'uploads/galeria/' . $nombreFoto
                    ]);
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error al subir la imagen.</div>';
                }
            }
        }

        header('Location: ../../views/administrativo/galeria.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al crear galería: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al crear la galería: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>