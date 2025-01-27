<?php
define('BASE_URL', dirname(dirname(dirname(__FILE__)))); // Ajustar BASE_URL para la ruta correcta
require(BASE_URL . '/fpdf/fpdf.php');
include_once(BASE_URL . '/config/conexion.php');

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        // Ruta de la imagen del logo
        $logoPath = BASE_URL . '/img/logo23.png';
        
        // Agregar el logo (ajusta las coordenadas y el tamaño según sea necesario)
        $this->Image($logoPath, 10, 6, 30); // (ruta, x, y, ancho)

        // Establecer la fuente y el color del texto
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, utf8_decode('ESCUELA DE EDUCACIÓN BÁSICA PARTICULAR'), 0, 1, 'C');
        $this->SetTextColor(255, 0, 0); // Establecer el color del texto a rojo (RGB: 255, 0, 0)
        $this->Cell(0, 6, utf8_decode('"LAS ÁGUILAS DEL SABER"'), 0, 1, 'C');
        $this->SetTextColor(0, 0, 0); // Restablecer el color del texto a negro (RGB: 0, 0, 0)
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('RESOLUCIÓN: DEO-DPE:109-2009,'), 0, 1, 'C');
        $this->Cell(0, 6, 'AMIE: 07H01462', 0, 1, 'C');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, 'EL CAMBIO-MACHALA-ECUADOR', 0, 1, 'C');
        $this->Cell(0, 4, 'HOJA DE MATRICULA', 0, 1, 'C');
        $this->Ln(1); // Reducir espacio después del encabezado
    }

    // Pie de página
    function Footer() {
        $this->SetY(-25);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(255, 0, 0); // Establecer el color del texto a rojo (RGB: 255, 0, 0)
        $this->Cell(0, 4, utf8_decode('CDLA. MARIO MINUCHE CALLE ELOY ALFARO Y TERCERA SUR'), 0, 1, 'R');
        $this->SetFont('Arial', 'U', 10); // 'U' para subrayado
        $this->Cell(0, 6, '07H01462@gmail.com', 0, 1, 'R');
        $this->SetFont('Arial', 'B', 10); // Restablecer la fuente a normal
        $this->Cell(0, 6, '0969998542', 0, 1, 'R');
        $this->SetTextColor(0, 0, 0); // Restablecer el color del texto a negro (RGB: 0, 0, 0)
    }

    // Título de sección
    function SectionTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, utf8_decode($title), 0, 1, 'C');
        $this->Ln(4); // Reducir espacio después del título
    }

    // Texto de sección
    function SectionText($label, $text) {
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 6, utf8_decode($label . ':'), 0, 0, 'L'); // Reducir altura de la celda
        $this->Cell(0, 6, utf8_decode($text), 0, 1, 'L'); // Reducir altura de la celda
    }

    // Mostrar imagen al lado de los datos
    function SectionImage($imagePath) {
        if ($imagePath && file_exists($imagePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $imagePath)) {
            $this->Image($imagePath, 150, $this->GetY(), 30); // Ajustar la posición de la imagen
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_estudiante'])) {
    $id_estudiante = $_POST['id_estudiante'];

    // Conectar a la base de datos
    $pdo = conectarBaseDeDatos();

    // Obtener los datos del estudiante
    $sql = "SELECT 
                m.id_matricula AS numero_matricula,
                p.nombre_paralelo,
                -- Datos del Estudiante
                e.cedula AS cedula_estudiante,
                e.nombres AS nombres_estudiante,
                e.apellidos AS apellidos_estudiante,
                e.fecha_nacimiento AS fecha_nacimiento_estudiante,
                e.lugar_nacimiento AS lugar_nacimiento_estudiante,
                e.residencia AS residencia_estudiante,
                e.direccion AS direccion_estudiante,
                e.sector AS sector_estudiante,
                e.foto AS foto_estudiante,
                -- Datos del Padre de Familia
                pf.cedula AS cedula_padre,
                pf.nombres AS nombres_padre,
                pf.apellidos AS apellidos_padre,
                pf.direccion_domiciliaria AS direccion_padre,
                pf.ocupacion_profesion AS ocupacion_padre,
                pf.telefono_celular AS telefono_padre,
                pf.email AS email_padre,
                pf.foto AS foto_padre,
                -- Datos de la Madre de Familia
                mf.cedula AS cedula_madre,
                mf.nombres AS nombres_madre,
                mf.apellidos AS apellidos_madre,
                mf.direccion_domiciliaria AS direccion_madre,
                mf.ocupacion_profesion AS ocupacion_madre,
                mf.telefono_celular AS telefono_madre,
                mf.email AS email_madre,
                mf.foto AS foto_madre,
                -- Datos del Representante
                r.cedula AS cedula_representante,
                r.nombres AS nombres_representante,
                r.apellidos AS apellidos_representante,
                r.direccion_domiciliaria AS direccion_representante,
                r.ocupacion_profesion AS ocupacion_representante,
                r.telefono_celular AS telefono_representante,
                r.email AS email_representante,
                r.foto AS foto_representante,
                r.tipo AS tipo_representante
            FROM 
                escuela.matriculas m
            JOIN 
                escuela.estudiantes e ON m.id_estudiante = e.id_estudiante
            JOIN 
                escuela.paralelos p ON m.id_paralelo = p.id_paralelo
            LEFT JOIN 
                escuela.padre_familia pf ON e.id_padre = pf.id_padre
            LEFT JOIN 
                escuela.madre_familia mf ON e.id_madre = mf.id_madre
            LEFT JOIN 
                escuela.representante r ON e.id_representante = r.id_representante
            WHERE 
                e.id_estudiante = :id_estudiante";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_estudiante' => $id_estudiante]);
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($estudiante) {
        $pdf = new PDF();
        $pdf->AddPage();

        // Encabezado con paralelo, número de matrícula y cédula del estudiante
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(0, 6, utf8_decode($estudiante['nombre_paralelo']), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 4, utf8_decode('Matrícula Nro: ' . $estudiante['numero_matricula']), 0, 1, 'R');
        $pdf->Cell(0, 4, utf8_decode('Código: ' . $estudiante['cedula_estudiante']), 0, 1, 'R');
        $pdf->Ln(3); // Espacio después del encabezado

        // Datos del Estudiante
        $pdf->SectionTitle('Datos del Estudiante');
        $pdf->SectionImage(BASE_URL . '/uploads/fotos_persona/' . $estudiante['foto_estudiante']);
        $pdf->SectionText('Apellidos', $estudiante['apellidos_estudiante']);
        $pdf->SectionText('Nombres', $estudiante['nombres_estudiante']);
        $pdf->SectionText('CI', $estudiante['cedula_estudiante']);
        $pdf->SectionText('Fecha de Nacimiento', $estudiante['fecha_nacimiento_estudiante']);
        $pdf->SectionText('Lugar de Nacimiento', $estudiante['lugar_nacimiento_estudiante']);
        $pdf->SectionText('Residencia', $estudiante['residencia_estudiante']);
        $pdf->SectionText('Dirección', $estudiante['direccion_estudiante']);
        $pdf->SectionText('Sector', $estudiante['sector_estudiante']);
        //$pdf->SectionText('Paralelo', $estudiante['nombre_paralelo']);

        // Datos del Padre
        $pdf->SectionTitle('Datos del Padre');
        $pdf->SectionImage(BASE_URL . '/uploads/fotos_persona/' . $estudiante['foto_padre']);
        $pdf->SectionText('Cédula', $estudiante['cedula_padre']);
        $pdf->SectionText('Apellidos y Nombres', $estudiante['apellidos_padre'] . ' ' . $estudiante['nombres_padre']);
        $pdf->SectionText('Dirección', $estudiante['direccion_padre']);
        $pdf->SectionText('Teléfono', $estudiante['telefono_padre']);
        $pdf->SectionText('Correo', $estudiante['email_padre']);
        $pdf->SectionText('Ocupación', $estudiante['ocupacion_padre']);

        // Datos de la Madre
        $pdf->SectionTitle('Datos de la Madre');
        $pdf->SectionImage(BASE_URL . '/uploads/fotos_persona/' . $estudiante['foto_madre']);
        $pdf->SectionText('Cédula', $estudiante['cedula_madre']);
        $pdf->SectionText('Apellidos y Nombres', $estudiante['apellidos_madre'] . ' ' . $estudiante['nombres_madre']);
        $pdf->SectionText('Dirección', $estudiante['direccion_madre']);
        $pdf->SectionText('Teléfono', $estudiante['telefono_madre']);
        $pdf->SectionText('Correo', $estudiante['email_madre']);
        $pdf->SectionText('Ocupación', $estudiante['ocupacion_madre']);

        // Datos del Representante
        $pdf->SectionTitle('Datos del Representante');
        $pdf->SectionImage(BASE_URL . '/uploads/fotos_persona/' . $estudiante['foto_representante']);
        $pdf->SectionText('Cédula', $estudiante['cedula_representante']);
        $pdf->SectionText('Apellidos y Nombres', $estudiante['apellidos_representante'] . ' ' . $estudiante['nombres_representante']);
        $pdf->SectionText('Dirección', $estudiante['direccion_representante']);
        $pdf->SectionText('Teléfono', $estudiante['telefono_representante']);
        $pdf->SectionText('Correo', $estudiante['email_representante']);
        $pdf->SectionText('Tipo de Representante', $estudiante['tipo_representante']);
        $pdf->SectionText('Ocupación', $estudiante['ocupacion_representante']);

        $pdf->Output();
    } else {
        echo 'No se encontraron datos para el estudiante con ID ' . htmlspecialchars($id_estudiante);
    }
} else {
    echo 'ID de estudiante no proporcionado.';
}
?>