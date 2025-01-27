<?php
require_once(__DIR__ . '/../../config/conexion.php');
require_once(__DIR__ . '/../../fpdf/fpdf.php');

class PDF extends FPDF {
    private $nombreProfesor;
    private $anio;

    public function setNombreProfesor($nombre) {
        $this->nombreProfesor = $nombre;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    // Cabecera de página
    function Header() {
        $logoPathLeft = __DIR__ . '/../../img/logo ministerio.png';
        $logoPathRight = __DIR__ . '/../../img/logo23.png';
        $this->Image($logoPathLeft, 10, 6, 35);
        $this->Image($logoPathRight, 270, 6, 20);
        $this->SetFont('TIMES', 'B', 12);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(0, 6, utf8_decode('ESCUELA DE EDUCACIÓN BÁSICA PARTICULAR "LAS ÁGUILAS DEL SABER"'), 0, 1, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 6, utf8_decode(''), 0, 1, 'C');
        $this->SetFont('TIMES', 'B', 12);
        $this->Cell(0, 0, 'CONTROL DE ASISTENCIA', 0, 1, 'C');
        $this->Ln(5);
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-35);
        $this->SetFont('TIMES', 'I', 12);
        $this->Cell(0, 0, 'Lcda. Janina Salinas', 0, 1, 'L');
        $this->Ln(8);
        $this->Cell(0, 0, 'Directora', 0, 1, 'L');
        $this->SetY(-35);
        $this->Cell(0, 0, '', 0, 1, 'R');
        $this->Cell(0, 0, $this->nombreProfesor, 0, 0, 'R');
        $this->Ln(8);
        $this->Cell(0, 0, 'Docente', 0, 0, 'R');
    }

    // Título de sección
    function SectionTitle($title) {
        $this->SetFont('TIMES', 'B', 12);
        $this->Cell(0, 10, utf8_decode($title), 0, 1, 'L');
        $this->Ln(4);
    }

    // Texto de sección
    function SectionText($label, $text) {
        $this->SetFont('TIMES', '', 12);
        $this->Cell(50, 10, utf8_decode($label . ':'), 0, 0, 'L');
        $this->Cell(0, 10, utf8_decode($text), 0, 1, 'L');
    }

    // Tabla de asistencia
    function AttendanceTable($header, $data) {
        $this->SetFont('TIMES', 'B', 12);
        $pageWidth = $this->GetPageWidth() - 40; // Ancho de la página menos márgenes
        $nameColumnWidth = 50; // Ancho de la columna de nombres
        $remainingWidth = $pageWidth - $nameColumnWidth;
        $columnWidth = $remainingWidth / (count($header) - 1); // Ancho de las columnas de días

        $widths = array_merge([$nameColumnWidth], array_fill(0, count($header) - 1, $columnWidth));
        $marginLeft = 20; // Margen izquierdo para mover la tabla a la derecha

        $this->SetX($marginLeft);
        foreach ($header as $i => $col) {
            $this->Cell($widths[$i], 10, utf8_decode($col), 1, 0, 'C');
        }
        $this->Ln();
        $this->SetFont('TIMES', '', 10);
        foreach ($data as $row) {
            $this->SetX($marginLeft);
            foreach ($row as $i => $col) {
                $this->Cell($widths[$i], 8, utf8_decode($col), 1, 0, 'C');
            }
            $this->Ln();
        }
    }
}

if (isset($_GET['id_estudiante']) && isset($_GET['fecha'])) {
    $id_estudiante = $_GET['id_estudiante'];
    $fecha = $_GET['fecha'];
    $anio = date('Y', strtotime($fecha));

    $pdo = conectarBaseDeDatos();

    // Obtener los datos del estudiante
    $sql = "SELECT nombres, apellidos, id_paralelo FROM escuela.estudiantes WHERE id_estudiante = :id_estudiante";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_estudiante' => $id_estudiante]);
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener los datos del profesor
    $sql = "SELECT p.nombre
            FROM escuela.profesores p
            LEFT JOIN escuela.asignaciones a ON p.id_profesor = a.id_profesor
            LEFT JOIN escuela.paralelos pa ON a.id_paralelo = pa.id_paralelo
            WHERE pa.id_paralelo = :id_paralelo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_paralelo' => $estudiante['id_paralelo']]);
    $profesor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener las fechas de asistencia únicas para el año seleccionado
    $fechas = obtenerFechasAno($anio);
    $asistencias = obtenerResumenMensual($pdo, $id_estudiante, $anio);

    if ($estudiante) {
        $pdf = new PDF('L', 'mm', 'A4'); // 'L' para orientación horizontal (paisaje)
        $pdf->setAnio($anio);
        $pdf->AddPage();

        // Establecer el nombre del profesor
        if ($profesor) {
            $pdf->setNombreProfesor($profesor['nombre']);
        }

        $pdf->SectionTitle('Año ' . $anio);
        $pdf->SectionText('Nombre', $estudiante['nombres'] . ' ' . $estudiante['apellidos']);

        $pdf->SectionTitle('Registro de Asistencia Anual');
        $header = ['Nombre Estudiante', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $data = [array_merge([$estudiante['nombres'] . ' ' . $estudiante['apellidos']], $asistencias)];
        $pdf->AttendanceTable($header, $data);

        $pdf->Output();
    } else {
        echo 'No se encontraron datos para el estudiante con ID ' . htmlspecialchars($id_estudiante);
    }
} else {
    echo 'ID de estudiante o fecha no proporcionado.';
}

function obtenerFechasAno($anio) {
    $fechas = [];
    $inicioAno = strtotime($anio . '-01-01');
    $finAno = strtotime($anio . '-12-31');
    for ($fecha = $inicioAno; $fecha <= $finAno; $fecha = strtotime('+1 day', $fecha)) {
        if (date('N', $fecha) < 6) { // Excluir sábados (6) y domingos (7)
            $fechas[] = date('Y-m-d', $fecha);
        }
    }
    return $fechas;
}

function obtenerResumenMensual($pdo, $id_estudiante, $anio) {
    $resumen = [];
    for ($mes = 1; $mes <= 12; $mes++) {
        $sql = "SELECT COUNT(*) as total_dias, SUM(CASE WHEN estado = 'Presente' THEN 1 ELSE 0 END) as dias_asistidos
                FROM escuela.asistencia
                WHERE id_estudiante = :id_estudiante AND EXTRACT(YEAR FROM fecha) = :anio AND EXTRACT(MONTH FROM fecha) = :mes";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_estudiante' => $id_estudiante, ':anio' => $anio, ':mes' => $mes]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_dias = $result['total_dias'];
        $dias_asistidos = $result['dias_asistidos'];
        $resumen[] = $dias_asistidos . '/' . $total_dias;
    }
    return $resumen;
}
?>