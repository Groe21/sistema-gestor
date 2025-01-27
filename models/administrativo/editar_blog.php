<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $imagen = $_FILES['imagen'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "UPDATE blog SET titulo = :titulo, contenido = :contenido";

        // Verificar si se subió una nueva imagen
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
                $sql .= ", imagen = :imagen";
            } else {
                echo '<div class="alert alert-danger" role="alert">Error al subir la imagen.</div>';
                exit;
            }
        }

        $sql .= " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $params = [
            ':titulo' => $titulo,
            ':contenido' => $contenido,
            ':id' => $id
        ];

        if (isset($nombreImagen)) {
            $params[':imagen'] = $nombreImagen;
        }

        $stmt->execute($params);
        header('Location: ../../views/administrativo/blog.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al editar blog: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al editar el blog: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>