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

    // Tabla de asistencia
    function AttendanceTable($header, $data) {
        $this->SetFont('TIMES', 'B', 12);
        $pageWidth = $this->GetPageWidth() - 40; // Ancho de la página menos márgenes
        $nameColumnWidth = 50; // Ancho de la columna de nombres
        $remainingWidth = $pageWidth - $nameColumnWidth;
        $columnWidth = count($header) > 1 ? $remainingWidth / (count($header) - 1) : $remainingWidth; // Ancho de las columnas de días

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

if (isset($_GET['id_periodo']) && isset($_GET['id_paralelo']) && isset($_GET['fecha'])) {
    $id_periodo = $_GET['id_periodo'];
    $id_paralelo = $_GET['id_paralelo'];
    $anio_elegido = $_GET['fecha'];

    $pdo = conectarBaseDeDatos();

    // Obtener los datos del profesor
    $sql = "SELECT p.nombre
            FROM escuela.profesores p
            LEFT JOIN escuela.asignaciones a ON p.id_profesor = a.id_profesor
            LEFT JOIN escuela.paralelos pa ON a.id_paralelo = pa.id_paralelo
            WHERE p.id_periodo = :id_periodo AND pa.id_paralelo = :id_paralelo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_periodo' => $id_periodo, ':id_paralelo' => $id_paralelo]);
    $profesor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener los datos de los estudiantes
    $sql = "SELECT id_estudiante, nombres, apellidos FROM escuela.estudiantes WHERE id_periodo = :id_periodo AND id_paralelo = :id_paralelo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_periodo' => $id_periodo, ':id_paralelo' => $id_paralelo]);
    $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener las fechas de asistencia únicas para el año elegido
    $sql = "SELECT DISTINCT fecha FROM escuela.asistencia WHERE EXTRACT(YEAR FROM fecha) = :anio_elegido ORDER BY fecha";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':anio_elegido' => $anio_elegido]);
    $fechas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($fechas)) {
        echo 'No se encontraron fechas de asistencia para el año especificado.';
        exit;
    }

    $asistencias = [];
    foreach ($estudiantes as $estudiante) {
        $asistencia_estudiante = [];
        foreach ($fechas as $fecha) {
            $sql = "SELECT estado FROM escuela.asistencia WHERE id_estudiante = :id_estudiante AND fecha = :fecha";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_estudiante' => $estudiante['id_estudiante'], ':fecha' => $fecha]);
            $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);
            $asistencia_estudiante[] = $asistencia ? ($asistencia['estado'] == 'Presente' ? 'Asistió' : 'X') : 'X';
        }
        $asistencias[] = array_merge([$estudiante['nombres'] . ' ' . $estudiante['apellidos']], $asistencia_estudiante);
    }

    if ($estudiantes) {
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AddPage();

        if ($profesor) {
            $pdf->setNombreProfesor($profesor['nombre']);
        }

        $pdf->setAnio($anio_elegido);

        $pdf->SectionTitle('Año ' . $anio_elegido);
        $header = array_merge(['Nombre Estudiante'], array_map(function($fecha) {
            return date('d/m', strtotime($fecha));
        }, $fechas));
        $pdf->AttendanceTable($header, $asistencias);

        $pdf->Output();
    } else {
        echo 'No se encontraron datos para los estudiantes en el periodo y paralelo especificados.';
    }
} else {
    echo 'ID de periodo, paralelo o fecha no proporcionado.';
}
?>