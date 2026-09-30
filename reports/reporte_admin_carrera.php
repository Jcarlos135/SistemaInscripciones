<?php
// Capturar salidas accidentales para evitar errores de FPDF
ob_start();

date_default_timezone_set('America/La_Paz');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

// 1. Obtener asignaturas ordenadas por nivel y código desde la BD
$stmt = $pdo->query("SELECT codigo, nombre, horas, nivel FROM asignatura ORDER BY nivel, codigo");
$asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Obtener prerrequisitos desde la BD
$stmt_pre = $pdo->query("SELECT cod_asig, cod_req FROM prerequisito");
$prerequisitos_raw = $stmt_pre->fetchAll(PDO::FETCH_ASSOC);
$prerequisitos = [];
foreach ($prerequisitos_raw as $p) {
    $prerequisitos[$p['cod_asig']] = $p['cod_req'];
}

// Clasificar asignaturas por año según su nivel
$primer_anio = [];
$segundo_anio = [];
$tercer_anio = [];

foreach ($asignaturas as $asig) {
    $item = [
        'codigo' => $asig['codigo'],
        'nombre' => $asig['nombre'],
        'horas' => ($asig['horas'] !== null && $asig['horas'] > 0) ? $asig['horas'] : 4,
        'prereq' => isset($prerequisitos[$asig['codigo']]) ? $prerequisitos[$asig['codigo']] : '-'
    ];

    if ($asig['nivel'] == 100 || substr($asig['codigo'], -3, 1) == '1') {
        $primer_anio[] = $item;
    } elseif ($asig['nivel'] == 200 || substr($asig['codigo'], -3, 1) == '2') {
        $segundo_anio[] = $item;
    } else {
        $tercer_anio[] = $item;
    }
}

class PDF extends FPDF
{
    function Header()
    {
        // =====================================================
        // ENCABEZADO PRINCIPAL EN ROJO OSCURO
        // =====================================================
        $this->SetFillColor(100, 0, 0); // Rojo oscuro
        $this->Rect(10, 10, 277, 28, 'F');

        // Línea roja brillante inferior
        $this->SetFillColor(180, 0, 0);
        $this->Rect(10, 38, 277, 1.5, 'F');

        // Título PLAN DE ESTUDIOS (izquierda)
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(255, 255, 255);
        $this->SetXY(12, 12);
        $this->Cell(95, 6, utf8_decode('PLAN DE ESTUDIOS'), 0, 1, 'C');

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(12, 18);
        $this->MultiCell(95, 4, utf8_decode('ÁREA DE FORMACIÓN: COMERCIAL Y SERVICIOS'), 0, 'C');

        $this->SetFont('Arial', '', 8);
        $this->SetXY(12, 28);
        $this->Cell(95, 4, utf8_decode('CARGA HORARIA: 3600 Hrs.'), 0, 1, 'C');

        // Título CARRERA (derecha)
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(110, 12);
        $this->Cell(175, 7, utf8_decode('CARRERA: SISTEMAS INFORMÁTICOS'), 0, 1, 'C');

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(110, 20);
        $this->MultiCell(175, 4, utf8_decode('DENOMINACIÓN DEL TÍTULO PROFESIONAL:
TÉCNICO SUPERIOR EN SISTEMAS INFORMÁTICOS'), 0, 'C');

        // =====================================================
        // FRANJA DE HORAS EN ROJO CLARO
        // =====================================================
        $this->SetFillColor(255, 240, 240); // Rojo muy claro
        $this->SetDrawColor(180, 0, 0);      // Borde rojo
        $this->SetTextColor(180, 0, 0);      // Texto rojo
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(10, 40);
        $this->Cell(277, 5, utf8_decode('HORAS SEMANA: 30  -  HORAS MES: 120  -  HORAS AÑO: 1200'), 1, 1, 'C', true);
        $this->Ln(2);
    }

    function Footer()
    {
        $this->SetY(-18);
        $this->SetFont('Arial', '', 6.5);
        $this->SetTextColor(100, 0, 0); // Rojo oscuro para el texto del pie
        $nota = utf8_decode('Nota: Los Valores Sociocomunitarios, descolonización y despatriarcalización, cuidado del medio ambiente, prevención de la violencia de género, ética profesional, y la articulación con los sectores sociales y productivo bajo un enfoque de emprendimiento, deben ser desarrolladas en todas las asignaturas por las y los docentes para la formación integral de las y los estudiantes.');
        $this->MultiCell(277, 3.5, $nota, 0, 'L');
    }
}

// Crear instancia en orientación Horizontal (Landscape - L), tamaño A4
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// =====================================================
// CABECERAS DE AÑOS EN ROJO
// =====================================================
$pdf->SetY(48);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(180, 0, 0); // Rojo brillante
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(62, 6, utf8_decode('PRIMER AÑO'), 1, 0, 'C', true);
$pdf->Cell(105, 6, utf8_decode('SEGUNDO AÑO'), 1, 0, 'C', true);
$pdf->Cell(110, 6, utf8_decode('TERCER AÑO'), 1, 1, 'C', true);

// =====================================================
// SUB-CABECERAS DE COLUMNAS EN ROJO CLARO
// =====================================================
$pdf->SetFillColor(255, 240, 240); // Rojo muy claro
$pdf->SetDrawColor(180, 0, 0);      // Borde rojo
$pdf->SetTextColor(100, 0, 0);      // Texto rojo oscuro
$pdf->SetFont('Arial', 'B', 7.5);

// Primer Año
$pdf->Cell(16, 5, utf8_decode('CÓDIGO'), 1, 0, 'C', true);
$pdf->Cell(40, 5, utf8_decode('ASIGNATURAS'), 1, 0, 'C', true);
$pdf->Cell(6,  5, utf8_decode('HR'), 1, 0, 'C', true);

// Segundo Año
$pdf->Cell(16, 5, utf8_decode('CÓDIGO'), 1, 0, 'C', true);
$pdf->Cell(71, 5, utf8_decode('ASIGNATURAS'), 1, 0, 'C', true);
$pdf->Cell(6,  5, utf8_decode('HR'), 1, 0, 'C', true);
$pdf->Cell(12, 5, utf8_decode('P.REQ'), 1, 0, 'C', true);

// Tercer Año
$pdf->Cell(16, 5, utf8_decode('CÓDIGO'), 1, 0, 'C', true);
$pdf->Cell(74, 5, utf8_decode('ASIGNATURAS'), 1, 0, 'C', true);
$pdf->Cell(6,  5, utf8_decode('HR'), 1, 0, 'C', true);
$pdf->Cell(14, 5, utf8_decode('P.REQ'), 1, 1, 'C', true);

// =====================================================
// FILAS DE DATOS CON ALTERNANCIA BLANCO / ROJO CLARO
// =====================================================
$max_rows = max(count($primer_anio), count($segundo_anio), count($tercer_anio));

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetDrawColor(180, 0, 0); // Bordes rojos en toda la tabla

for ($i = 0; $i < $max_rows; $i++) {
    // Alternar fondo: blanco / rojo muy claro
    $fill = ($i % 2 == 0) ? true : true;
    $bg = ($i % 2 == 0) ? 255 : 255; // 255 = blanco puro
    $bg_g = ($i % 2 == 0) ? 255 : 240;
    $bg_b = ($i % 2 == 0) ? 255 : 240;
    $pdf->SetFillColor($bg, $bg_g, $bg_b);
    $pdf->SetTextColor(30, 30, 30);

    // Primer Año
    if (isset($primer_anio[$i])) {
        $pdf->Cell(16, 5.5, utf8_decode($primer_anio[$i]['codigo']), 1, 0, 'C', true);
        $pdf->Cell(40, 5.5, utf8_decode($primer_anio[$i]['nombre']), 1, 0, 'L', true);
        $pdf->Cell(6,  5.5, utf8_decode($primer_anio[$i]['horas']), 1, 0, 'C', true);
    } else {
        $pdf->Cell(16, 5.5, '', 1, 0, 'C', true);
        $pdf->Cell(40, 5.5, '', 1, 0, 'L', true);
        $pdf->Cell(6,  5.5, '', 1, 0, 'C', true);
    }

    // Segundo Año
    if (isset($segundo_anio[$i])) {
        $pdf->Cell(16, 5.5, utf8_decode($segundo_anio[$i]['codigo']), 1, 0, 'C', true);
        $pdf->Cell(71, 5.5, utf8_decode($segundo_anio[$i]['nombre']), 1, 0, 'L', true);
        $pdf->Cell(6,  5.5, utf8_decode($segundo_anio[$i]['horas']), 1, 0, 'C', true);
        $pdf->Cell(12, 5.5, utf8_decode($segundo_anio[$i]['prereq']), 1, 0, 'C', true);
    } else {
        $pdf->Cell(16, 5.5, '', 1, 0, 'C', true);
        $pdf->Cell(71, 5.5, '', 1, 0, 'L', true);
        $pdf->Cell(6,  5.5, '', 1, 0, 'C', true);
        $pdf->Cell(12, 5.5, '', 1, 0, 'C', true);
    }

    // Tercer Año
    if (isset($tercer_anio[$i])) {
        $pdf->Cell(16, 5.5, utf8_decode($tercer_anio[$i]['codigo']), 1, 0, 'C', true);
        $pdf->Cell(74, 5.5, utf8_decode($tercer_anio[$i]['nombre']), 1, 0, 'L', true);
        $pdf->Cell(6,  5.5, utf8_decode($tercer_anio[$i]['horas']), 1, 0, 'C', true);
        $pdf->Cell(14, 5.5, utf8_decode($tercer_anio[$i]['prereq']), 1, 1, 'C', true);
    } else {
        $pdf->Cell(16, 5.5, '', 1, 0, 'C', true);
        $pdf->Cell(74, 5.5, '', 1, 0, 'L', true);
        $pdf->Cell(6,  5.5, '', 1, 0, 'C', true);
        $pdf->Cell(14, 5.5, '', 1, 1, 'C', true);
    }
}

// Asegurar que la carpeta reports exista
$output_dir = __DIR__ . '/../reports';
if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}

// Limpiar buffer de salida antes de generar el archivo PDF
ob_end_clean();

// Guardar archivo en la carpeta reports
$pdf->Output('F', $output_dir . '/plan_estudios.pdf');
echo "PDF generado exitosamente en reports/plan_estudios.pdf";
