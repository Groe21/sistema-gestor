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
        // Ruta de las imágenes del logo
        $logoPathLeft = __DIR__ . '/../../img/logo ministerio.png';
        $logoPathRight = __DIR__ . '/../../img/logo23.png';
        
        // Agregar los logos (ajusta las coordenadas y el tamaño según sea necesario)
        $this->Image($logoPathLeft, 10, 6, 35); // (ruta, x, y, ancho)
        $this->Image($logoPathRight, 270, 6, 20); // (ruta, x, y, ancho)

        // Establecer la fuente y el color del texto
        $this->SetFont('TIMES', 'B', 12);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(0, 6, utf8_decode('ESCUELA DE EDUCACIÓN BÁSICA PARTICULAR "LAS ÁGUILAS DEL SABER"'), 0, 1, 'C');
        $this->SetTextColor(0, 0, 0); // Restablecer el color del texto a negro (RGB: 0, 0, 0)
        $this->Cell(0, 6, utf8_decode(''), 0, 1, 'C');
        $this->SetFont('TIMES', 'B', 12);
        $this->Cell(0, 0, 'CONTROL DE ASISTENCIA', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        // Bloque izquierdo
        $this->SetY(-35); // Ajusta la posición vertical para el primer bloque
        $this->SetFont('TIMES', 'I', 12);
        $this->Cell(0, 0, 'Lcda. Janina Salinas', 0, 1, 'L'); // Alinea el texto a la izquierda
        $this->Ln(8); // Añade un espacio entre los textos
        $this->Cell(0, 0, 'Directora', 0, 1, 'L'); // Alinea el texto a la izquierda

        // Bloque derecho
        $this->SetY(-35); // Ajusta la posición vertical para el segundo bloque
        $this->Cell(0, 0, '', 0, 1, 'R'); // Añade una celda vacía para mover la posición horizontal
        $this->Cell(0, 0, $this->nombreProfesor, 0, 0, 'R'); // Alinea el texto a la derecha
        $this->Ln(8); // Añade un espacio entre los textos
        $this->Cell(0, 0, 'Docente', 0, 0, 'R'); // Alinea el texto a la derecha
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

if (isset($_GET['id_periodo']) && isset($_GET['id_paralelo'])) {
    $id_periodo = $_GET['id_periodo'];
    $id_paralelo = $_GET['id_paralelo'];

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

    // Obtener las fechas de asistencia únicas para la semana actual
    $fechas = obtenerFechasSemana();
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
        $pdf = new PDF('L', 'mm', 'A4'); // 'L' para orientación horizontal (paisaje)
        $pdf->AddPage();

        // Establecer el nombre del profesor
        if ($profesor) {
            $pdf->setNombreProfesor($profesor['nombre']);
        }

        $pdf->SectionTitle('SEMANA DEL ...... AL ...... DE ................... DEL .......');
        $header = array_merge(['Nombre Estudiante'], array_map(function($fecha) {
            return date('d/m', strtotime($fecha));
        }, $fechas));
        $pdf->AttendanceTable($header, $asistencias);

        $pdf->Output();
    } else {
        echo 'No se encontraron datos para los estudiantes en el periodo y paralelo especificados.';
    }
} else {
    echo 'ID de periodo o paralelo no proporcionado.';
}

function obtenerFechasSemana() {
    $fechas = [];
    $inicioSemana = strtotime('last monday', strtotime('tomorrow'));
    for ($i = 0; $i < 5; $i++) { // Solo de lunes a viernes
        $fechas[] = date('Y-m-d', strtotime("+$i days", $inicioSemana));
    }
    return $fechas;
}
?>