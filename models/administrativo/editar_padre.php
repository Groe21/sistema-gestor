<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $comentario = $_POST['comentario'];
    $imagen = $_FILES['imagen'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "UPDATE padres SET nombre = :nombre, comentario = :comentario";

        // Verificar si se subió una nueva imagen
        if ($imagen['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = basename($imagen['name']);
            $rutaUploads = __DIR__ . '/../../uploads';
            $rutaPadres = $rutaUploads . '/padres';

            // Crear las carpetas si no existen
            if (!is_dir($rutaUploads)) {
                mkdir($rutaUploads, 0777, true);
            }
            if (!is_dir($rutaPadres)) {
                mkdir($rutaPadres, 0777, true);
            }

            $rutaDestino = $rutaPadres . '/' . $nombreImagen;

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
            ':comentario' => $comentario,
            ':id' => $id
        ];

        if (isset($nombreImagen)) {
            $params[':imagen'] = $nombreImagen;
        }

        $stmt->execute($params);
        header('Location: ../../views/administrativo/listado_padres.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al editar padre: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al editar el padre: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>