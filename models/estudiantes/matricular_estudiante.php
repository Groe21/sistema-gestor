<?php
include_once(__DIR__ . '/../../config/conexion.php');

function matricular_estudiante(
    $cedula_estudiante, $apellidos_estudiante, $nombres_estudiante, $fecha_nacimiento_estudiante, $lugar_nacimiento_estudiante, $residencia_estudiante, $direccion_estudiante, $sector_estudiante, $foto_estudiante, $id_paralelo_estudiante, $id_periodo,
    $cedula_padre, $apellidos_padre, $nombres_padre, $direccion_padre, $ocupacion_padre, $telefono_padre, $correo_padre, $foto_padre,
    $cedula_madre, $apellidos_madre, $nombres_madre, $direccion_madre, $ocupacion_madre, $telefono_madre, $correo_madre, $foto_madre,
    $cedula_representante, $apellidos_representante, $nombres_representante, $direccion_representante, $ocupacion_representante, $telefono_representante, $correo_representante, $tipo_representante, $foto_representante
) {
    $pdo = conectarBaseDeDatos();

    $sql = "SELECT matricular_estudiante(
        :cedula_estudiante, :apellidos_estudiante, :nombres_estudiante, :fecha_nacimiento_estudiante, :lugar_nacimiento_estudiante, :residencia_estudiante, :direccion_estudiante, :sector_estudiante, :foto_estudiante, :id_paralelo_estudiante, :id_periodo,
        :cedula_padre, :apellidos_padre, :nombres_padre, :direccion_padre, :ocupacion_padre, :telefono_padre, :correo_padre, :foto_padre,
        :cedula_madre, :apellidos_madre, :nombres_madre, :direccion_madre, :ocupacion_madre, :telefono_madre, :correo_madre, :foto_madre,
        :cedula_representante, :apellidos_representante, :nombres_representante, :direccion_representante, :ocupacion_representante, :telefono_representante, :correo_representante, :foto_representante, :tipo_representante
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_estudiante' => $cedula_estudiante,
        ':apellidos_estudiante' => $apellidos_estudiante,
        ':nombres_estudiante' => $nombres_estudiante,
        ':fecha_nacimiento_estudiante' => $fecha_nacimiento_estudiante,
        ':lugar_nacimiento_estudiante' => $lugar_nacimiento_estudiante,
        ':residencia_estudiante' => $residencia_estudiante,
        ':direccion_estudiante' => $direccion_estudiante,
        ':sector_estudiante' => $sector_estudiante,
        ':foto_estudiante' => $foto_estudiante,
        ':id_paralelo_estudiante' => $id_paralelo_estudiante,
        ':id_periodo' => $id_periodo,
        ':cedula_padre' => $cedula_padre,
        ':apellidos_padre' => $apellidos_padre,
        ':nombres_padre' => $nombres_padre,
        ':direccion_padre' => $direccion_padre,
        ':ocupacion_padre' => $ocupacion_padre,
        ':telefono_padre' => $telefono_padre,
        ':correo_padre' => $correo_padre,
        ':foto_padre' => $foto_padre,
        ':cedula_madre' => $cedula_madre,
        ':apellidos_madre' => $apellidos_madre,
        ':nombres_madre' => $nombres_madre,
        ':direccion_madre' => $direccion_madre,
        ':ocupacion_madre' => $ocupacion_madre,
        ':telefono_madre' => $telefono_madre,
        ':correo_madre' => $correo_madre,
        ':foto_madre' => $foto_madre,
        ':cedula_representante' => $cedula_representante,
        ':apellidos_representante' => $apellidos_representante,
        ':nombres_representante' => $nombres_representante,
        ':direccion_representante' => $direccion_representante,
        ':ocupacion_representante' => $ocupacion_representante,
        ':telefono_representante' => $telefono_representante,
        ':correo_representante' => $correo_representante,
        ':foto_representante' => $foto_representante,
        ':tipo_representante' => $tipo_representante
    ]);

    echo json_encode(['success' => true]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejar la subida de archivos
    $foto_estudiante = $_FILES['foto_estudiante']['name'];
    $foto_padre = $_FILES['foto_padre']['name'];
    $foto_madre = $_FILES['foto_madre']['name'];
    $foto_representante = $_FILES['foto_representante']['name'];

    // Mover los archivos subidos a la carpeta de destino
    move_uploaded_file($_FILES['foto_estudiante']['tmp_name'], __DIR__ . '/../../uploads/fotos_persona/' . $foto_estudiante);
    move_uploaded_file($_FILES['foto_padre']['tmp_name'], __DIR__ . '/../../uploads/fotos_persona/' . $foto_padre);
    move_uploaded_file($_FILES['foto_madre']['tmp_name'], __DIR__ . '/../../uploads/fotos_persona/' . $foto_madre);
    move_uploaded_file($_FILES['foto_representante']['tmp_name'], __DIR__ . '/../../uploads/fotos_persona/' . $foto_representante);

    matricular_estudiante(
        $_POST['cedula_estudiante'], $_POST['apellidos_estudiante'], $_POST['nombres_estudiante'], $_POST['fecha_nacimiento_estudiante'], $_POST['lugar_nacimiento_estudiante'], $_POST['residencia_estudiante'], $_POST['direccion_estudiante'], $_POST['sector_estudiante'], $foto_estudiante, $_POST['id_paralelo_estudiante'], $_POST['id_periodo'],
        $_POST['cedula_padre'], $_POST['apellidos_padre'], $_POST['nombres_padre'], $_POST['direccion_padre'], $_POST['ocupacion_padre'], $_POST['telefono_padre'], $_POST['correo_padre'], $foto_padre,
        $_POST['cedula_madre'], $_POST['apellidos_madre'], $_POST['nombres_madre'], $_POST['direccion_madre'], $_POST['ocupacion_madre'], $_POST['telefono_madre'], $_POST['correo_madre'], $foto_madre,
        $_POST['cedula_representante'], $_POST['apellidos_representante'], $_POST['nombres_representante'], $_POST['direccion_representante'], $_POST['ocupacion_representante'], $_POST['telefono_representante'], $_POST['correo_representante'], $_POST['tipo_representante'], $foto_representante
    );
}
?>