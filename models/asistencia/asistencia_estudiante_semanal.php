<?php
require_once(__DIR__ . '/../../config/conexion.php');
require_once(__DIR__ . '/../../fpdf/fpdf.php');

class PDF extends FPDF {
    private $nombreProfesor;

    public function setNombreProfesor($nombre) {
        $this->nombreProfesor = $nombre;
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
    $fecha_inicio = $_GET['fecha'];

    if (!is_numeric($id_estudiante) || empty($fecha_inicio)) {
        echo 'ID de estudiante o fecha no válido.';
        exit;
    }

    $pdo = conectarBaseDeDatos();

    // Obtener los datos del estudiante
    $sql = "SELECT nombres, apellidos FROM escuela.estudiantes WHERE id_estudiante = :id_estudiante";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_estudiante' => $id_estudiante]);
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener los datos del profesor
    $sql = "SELECT p.nombre
            FROM escuela.profesores p
            LEFT JOIN escuela.asignaciones a ON p.id_profesor = a.id_profesor
            LEFT JOIN escuela.paralelos pa ON a.id_paralelo = pa.id_paralelo
            WHERE pa.id_paralelo = (SELECT id_paralelo FROM escuela.estudiantes WHERE id_estudiante = :id_estudiante)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_estudiante' => $id_estudiante]);
    $profesor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener las fechas de asistencia únicas para la semana seleccionada
    $fechas = obtenerFechasSemana($fecha_inicio);
    $asistencias = [];
    foreach ($fechas as $fecha) {
        $sql = "SELECT estado FROM escuela.asistencia WHERE id_estudiante = :id_estudiante AND fecha = :fecha";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_estudiante' => $id_estudiante, ':fecha' => $fecha]);
        $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);
        $asistencias[] = $asistencia && $asistencia['estado'] == 'Presente' ? 'Asistió' : 'X';
    }

    if ($estudiante) {
        $pdf = new PDF('L', 'mm', 'A4'); // 'L' para orientación horizontal (paisaje)
        $pdf->AddPage();

        // Establecer el nombre del profesor
        if ($profesor) {
            $pdf->setNombreProfesor($profesor['nombre']);
        }

        $pdf->SectionTitle('Datos del Estudiante');
        $pdf->SectionText('Nombre', $estudiante['nombres'] . ' ' . $estudiante['apellidos']);

        $pdf->SectionTitle('Registro de Asistencia Semanal');
        $header = array_merge(['Nombre Estudiante'], array_map(function($fecha) {
            return traducirDia(date('l', strtotime($fecha))); // Mostrar el día de la semana en español
        }, $fechas));
        $data = [array_merge([$estudiante['nombres'] . ' ' . $estudiante['apellidos']], $asistencias)];
        $pdf->AttendanceTable($header, $data);

        $pdf->Output();
    } else {
        echo 'No se encontraron datos para el estudiante con ID ' . htmlspecialchars($id_estudiante);
    }
} else {
    echo 'ID de estudiante o fecha no proporcionado.';
}

function obtenerFechasSemana($fecha_inicio) {
    $fechas = [];
    $inicioSemana = strtotime($fecha_inicio);
    $diaSemana = date('N', $inicioSemana); // Obtener el día de la semana (1 para lunes, 7 para domingo)
    $inicioSemana = strtotime('-' . ($diaSemana - 1) . ' days', $inicioSemana); // Ajustar al lunes de esa semana
    for ($i = 0; $i < 5; $i++) { // Solo de lunes a viernes
        $fechas[] = date('Y-m-d', strtotime("+$i days", $inicioSemana));
    }
    return $fechas;
}

function traducirDia($diaIngles) {
    $dias = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    ];
    return $dias[$diaIngles];
}
?>