<?php
include_once(__DIR__ . '/../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $descripcion1 = $_POST['descripcion1'];
    $descripcion2 = $_POST['descripcion2'];

    // Verificar si se subió una nueva imagen principal
    if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] === UPLOAD_ERR_OK) {
        $imagenPrincipal = basename($_FILES['imagen_principal']['name']);
        $rutaUploads = __DIR__ . '/../../uploads';
        $rutaNosotros = $rutaUploads . '/nosotros';

        // Crear las carpetas si no existen
        if (!is_dir($rutaUploads)) {
            mkdir($rutaUploads, 0777, true);
        }
        if (!is_dir($rutaNosotros)) {
            mkdir($rutaNosotros, 0777, true);
        }

        $rutaDestinoPrincipal = $rutaNosotros . '/' . $imagenPrincipal;

        // Mover la imagen a la carpeta de destino
        if (!move_uploaded_file($_FILES['imagen_principal']['tmp_name'], $rutaDestinoPrincipal)) {
            echo '<div class="alert alert-danger" role="alert">Error al subir la imagen principal.</div>';
            exit;
        }
    } else {
        $imagenPrincipal = null;
    }

    // Verificar si se subió una nueva imagen secundaria
    if (isset($_FILES['imagen_secundaria']) && $_FILES['imagen_secundaria']['error'] === UPLOAD_ERR_OK) {
        $imagenSecundaria = basename($_FILES['imagen_secundaria']['name']);
        $rutaDestinoSecundaria = $rutaNosotros . '/' . $imagenSecundaria;

        // Mover la imagen a la carpeta de destino
        if (!move_uploaded_file($_FILES['imagen_secundaria']['tmp_name'], $rutaDestinoSecundaria)) {
            echo '<div class="alert alert-danger" role="alert">Error al subir la imagen secundaria.</div>';
            exit;
        }
    } else {
        $imagenSecundaria = null;
    }

    try {
        $pdo = conectarBaseDeDatos();
        $sql = "UPDATE nosotros SET titulo = :titulo, contenido = :contenido, descripcion1 = :descripcion1, descripcion2 = :descripcion2";

        if ($imagenPrincipal) {
            $sql .= ", imagen_principal = :imagen_principal";
        }
        if ($imagenSecundaria) {
            $sql .= ", imagen_secundaria = :imagen_secundaria";
        }

        $sql .= " WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $params = [
            ':titulo' => $titulo,
            ':contenido' => $contenido,
            ':descripcion1' => $descripcion1,
            ':descripcion2' => $descripcion2,
            ':id' => $id
        ];

        if ($imagenPrincipal) {
            $params[':imagen_principal'] = $imagenPrincipal;
        }
        if ($imagenSecundaria) {
            $params[':imagen_secundaria'] = $imagenSecundaria;
        }

        $stmt->execute($params);
        header('Location: ../../views/administrativo/administrativa.php');
        exit;
    } catch (PDOException $e) {
        error_log("Error al editar nosotros: " . $e->getMessage());
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error al editar la información de nosotros: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método de solicitud no permitido.</div>';
}
?>