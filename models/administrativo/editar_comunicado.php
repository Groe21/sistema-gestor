<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $imagen = $_FILES['imagen'];

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "UPDATE comunicados SET titulo = :titulo, contenido = :contenido";

        // Verificar si se subió una nueva imagen
        if ($imagen['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = basename($imagen['name']);
            $rutaUploads = __DIR__ . '/../../uploads';
            $rutaComunicados = $rutaUploads . '/comunicados';

            // Crear las carpetas si no existen
            if (!is_dir($rutaUploads)) {
                mkdir($rutaUploads, 0777, true);
            }
            if (!is_dir($rutaComunicados)) {
                mkdir($rutaComunicados, 0777, true);
            }

            $rutaDestino = $rutaComunicados . '/' . $nombreImagen;

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
        error_log("Error al editar comunicado: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al editar el comunicado: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>