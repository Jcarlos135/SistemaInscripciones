<?php
date_default_timezone_set('America/La_Paz');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';

if (file_exists(__DIR__ . '/../lib/fpdf/fpdf.php')) {
    require_once __DIR__ . '/../lib/fpdf/fpdf.php';
} else {
    die('Error: Librería FPDF no encontrada.');
}

mysqli_set_charset($conn, 'utf8');

if (empty($_SESSION['estudiante_ci'])) {
    die('Sesión no válida.');
}

$ci = mysqli_real_escape_string($conn, $_SESSION['estudiante_ci']);

// NOTA: Las funciones textoPDF() y nota() YA NO SE DECLARAN AQUÍ. 
// Se usan las que ya existen en models/funciones.php

class PDF extends FPDF {
    public $instituto = 'INSTITUTO TECNOLÓGICO SUPERIOR';
    public $titulo = 'REPORTE DE CALIFICACIONES BIMESTRALES';

    function Header() {
        $this->SetFillColor(2, 40, 24);
        $this->Rect(0, 0, 297, 20, 'F');
        $this->SetFillColor(5, 157, 59);
        $this->Rect(0, 20, 297, 2, 'F');
        $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 14);
        $this->SetXY(12, 3);
        $this->Cell(200, 8, textoPDF($this->instituto), 0, 2, 'L');
        $this->SetFont('Helvetica', '', 10);
        $this->Cell(200, 6, textoPDF($this->titulo), 0, 0, 'L');
        $this->SetFont('Helvetica', '', 9);
        $this->SetXY(-62, 6);
        $this->Cell(50, 6, textoPDF('Emision: ') . date('d/m/Y'), 0, 2, 'R');
        $this->Cell(50, 6, 'CI: ' . ($_SESSION['estudiante_ci'] ?? ''), 0, 0, 'R');
        $this->SetY(26);
    }

    function Footer() {
        $this->SetY(-14);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(110);
        $this->Cell(0, 8, textoPDF('Sistema de Gestion Academica - Pagina ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    function cabeceraTabla() {
        $h1 = 7; $h2 = 6; $x0 = $this->lMargin; $y = $this->GetY();
        $this->SetDrawColor(108, 117, 125);
        
        $this->SetFillColor(33, 37, 41); $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 7);
        $this->SetX($x0);
        $this->Cell(15, $h1, '', 'LTR', 0, 'C', true);
        $this->Cell(60, $h1, '', 'LTR', 0, 'C', true);
        
        $this->SetFillColor(25, 135, 84);
        foreach (['1er BIMESTRE','2do BIMESTRE','3er BIMESTRE','4to BIMESTRE'] as $g) {
            $this->Cell(28, $h1, $g, 1, 0, 'C', true);
        }
        
        $this->SetFillColor(33, 37, 41);
        $this->Cell(15, $h1, '', 'LTR', 0, 'C', true);
        $this->Cell(15, $h1, '', 'LTR', 0, 'C', true);
        $this->Cell(35, $h1, '', 'LTR', 0, 'C', true);
        $this->Cell(24, $h1, '', 'LTR', 0, 'C', true);
        $this->Ln();

        $this->SetFillColor(52, 58, 64);
        $this->SetFont('Helvetica', 'B', 6);
        $this->SetX($x0);
        $this->Cell(15, $h2, '', 'LRB', 0, 'C', true);
        $this->Cell(60, $h2, '', 'LRB', 0, 'C', true);
        
        for ($b = 1; $b <= 4; $b++) {
            $this->Cell(9, $h2, 'T', 1, 0, 'C', true);
            $this->Cell(9, $h2, 'P', 1, 0, 'C', true);
            $this->Cell(10, $h2, 'N', 1, 0, 'C', true);
        }
        
        $this->Cell(15, $h2, '', 'LRB', 0, 'C', true);
        $this->Cell(15, $h2, '', 'LRB', 0, 'C', true);
        $this->Cell(35, $h2, '', 'LRB', 0, 'C', true);
        $this->Cell(24, $h2, '', 'LRB', 0, 'C', true);
        $this->Ln();

        $this->SetXY($x0, $y);
        $this->SetFont('Helvetica', 'B', 6.5);
        $this->Cell(15, $h1 + $h2, 'CODIGO', 1, 0, 'C');
        $this->Cell(60, $h1 + $h2, 'MATERIA', 1, 0, 'C');
        
        $this->SetX($x0 + 15 + 60 + 112);
        $this->Cell(15, $h1 + $h2, 'NOTA PARCIAL', 1, 0, 'C');
        $this->Cell(15, $h1 + $h2, 'TOTAL ANUAL', 1, 0, 'C');
        $this->Cell(35, $h1 + $h2, 'LITERAL', 1, 0, 'C');
        $this->Cell(24, $h1 + $h2, 'ESTADO', 1, 0, 'C');
        
        $this->SetXY($x0, $y + $h1 + $h2);
    }
}

// Datos del estudiante
$resEst = mysqli_query($conn, "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.img,
                                      c.nombre AS carrera, c.resolucion
                               FROM estudiante e
                               LEFT JOIN carrera c ON c.id = e.id_carrera
                               WHERE e.ci = '$ci' LIMIT 1");
$est = mysqli_fetch_assoc($resEst);
if (!$est) {
    die('Estudiante no encontrado.');
}

$nombreCompleto = trim(($est['nombre'] ?? '') . ' ' . ($est['ap_pat'] ?? '') . ' ' . ($est['ap_mat'] ?? ''));

// Consulta actualizada con las nuevas columnas
$gestion_filtro = $_GET['gestion'] ?? date('Y');

$sql = "SELECT a.codigo AS asig_codigo, a.nombre AS asig_nombre,
               h.nota_teorico1, h.nota_pract1, h.nota_primerbim,
               h.nota_teorico2, h.nota_pract2, h.nota_segundobim,
               h.nota_teorico3, h.nota_pract3, h.nota_tercerbim,
               h.nota_teorico4, h.nota_pract4, h.nota_cuartobim,
               h.nota_parcial, h.TotalAnual AS nota_final, h.segundo_turno, h.estado, h.literal, h.gestion
        FROM inscripcion i
        INNER JOIN asignatura a ON a.codigo = i.cod_asig
        LEFT JOIN historial h ON h.id = (SELECT MAX(h2.id) FROM historial h2
                          WHERE h2.ci_est = i.ci_est AND h2.cod_asig = i.cod_asig)
        WHERE i.ci_est = '$ci' AND i.activo = 1 AND COALESCE(h.gestion, a.gestion) = '$gestion_filtro'
        ORDER BY a.codigo";
$res = mysqli_query($conn, $sql);

$filas = []; 
$total_materias = 0; 
$aprobadas = 0; 
$reprobadas = 0; 
$en_proceso = 0; 
$gestion = '';

while ($r = mysqli_fetch_assoc($res)) {
    $filas[] = $r; 
    $total_materias++;
    if (!empty($r['gestion'])) $gestion = $r['gestion'];
    
    $e = strtoupper(trim((string)($r['estado'] ?? 'EN PROCESO')));
    if ($e === 'APROBADO') {
        $aprobadas++;
    } elseif ($e === 'REPROBADO') {
        $reprobadas++;
    } else {
        $en_proceso++;
    }
}

// Lógica de estado académico
if ($total_materias > 0) {
    if ($reprobadas == 0 && $en_proceso == 0) {
        $global = 'APROBADO: Pasa al siguiente Nivel.';
    } elseif ($reprobadas == 3) {
        $global = 'SEGUNDO TURNO: Solo inscribe 3 materias reprobadas.';
    } elseif ($reprobadas > 3) {
        $global = 'REPROBADO: Solo inscribe materias reprobadas.';
    } elseif ($reprobadas > 0 && $reprobadas < 3) {
        $global = 'REGULAR: Cursa materias nuevas y reprobadas.';
    } else {
        $global = 'EN PROCESO: Materias sin calificar.';
    }
} else {
    $global = 'SIN INSCRIPCIONES';
}

// Construir PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 14);
$pdf->SetMargins(10, 0, 10);
$pdf->SetTitle('Reporte de Calificaciones - CI ' . $ci);
$pdf->AddPage();

$pdf->SetFillColor(240, 248, 243);
$pdf->SetDrawColor(25, 135, 84);
$pdf->SetLineWidth(0.4);
$pdf->Rect(10, 26, 277, 22, 'DF');

$fotoPath = false;
if (!empty($est['img'])) {
    foreach ([__DIR__ . '/../' . $est['img'], $est['img']] as $p) {
        $ext = strtolower(pathinfo($p, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png']) && is_file($p)) { 
            $fotoPath = $p; 
            break; 
        }
    }
}
if ($fotoPath) {
    $pdf->SetFillColor(255);
    $pdf->Rect(266, 28, 19, 18, 'DF');
    $pdf->Image($fotoPath, 267, 29, 17, 16);
}

$pdf->SetTextColor(30);
$pdf->SetXY(14, 28);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->Cell(245, 6, textoPDF($nombreCompleto), 0, 2);
$pdf->SetFont('Helvetica', '', 9);
$pdf->Cell(245, 5, textoPDF('CI: ' . $est['ci'] . ' | Carrera: ' . ($est['carrera'] ?? '-') . ' | Resolucion: ' . ($est['resolucion'] ?? '-')), 0, 2);
$pdf->Cell(245, 5, textoPDF('Materias inscritas: ' . $total_materias . ' | Gestion: ' . ($gestion ?: '-') . ' | Nota minima de aprobacion: 51'), 0, 0);

$pdf->SetY(52);
$pdf->cabeceraTabla();

$h = 6;
$grupos = [
    ['nota_teorico1','nota_pract1','nota_primerbim'],
    ['nota_teorico2','nota_pract2','nota_segundobim'],
    ['nota_teorico3','nota_pract3','nota_tercerbim'],
    ['nota_teorico4','nota_pract4','nota_cuartobim'],
];

if (empty($filas)) {
    $pdf->Cell(277, 10, textoPDF('No se encontraron inscripciones para este estudiante.'), 1, 1, 'C');
}

foreach ($filas as $idx => $r) {
    if ($pdf->GetY() + $h > 180) {
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', 'I', 8);
        $pdf->SetTextColor(100);
        $pdf->Cell(277, 4, textoPDF('Continuacion - ' . $nombreCompleto . ' (CI: ' . $est['ci'] . ')'), 0, 1);
        $pdf->cabeceraTabla();
    }
    
    $fondo = ($idx % 2 === 1) ? [243, 247, 245] : [255, 255, 255];
    $pdf->SetDrawColor(108, 117, 125);
    $pdf->SetLineWidth(0.2);
    $pdf->SetTextColor(30);

    $pdf->SetFont('Helvetica', 'B', 6.5);
    $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
    $pdf->Cell(15, $h, textoPDF($r['asig_codigo']), 1, 0, 'C', true);

    $pdf->SetFont('Helvetica', '', 6.5);
    $nombreMat = textoPDF($r['asig_nombre']);
    while ($pdf->GetStringWidth($nombreMat) > 58 && strlen($nombreMat) > 4) {
        $nombreMat = substr($nombreMat, 0, -1);
    }
    $pdf->Cell(60, $h, rtrim($nombreMat), 1, 0, 'L', true);

    $pdf->SetFont('Helvetica', '', 6.5);
    foreach ($grupos as $g) {
        $pdf->Cell(9, $h, nota($r[$g[0]]), 1, 0, 'C', true);
        $pdf->Cell(9, $h, nota($r[$g[1]]), 1, 0, 'C', true);
        $pdf->SetFillColor(219, 240, 228);
        $pdf->Cell(10, $h, nota($r[$g[2]]), 1, 0, 'C', true);
        $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
    }

    $pdf->SetFont('Helvetica', 'B', 6.5);
    $pdf->Cell(15, $h, nota($r['nota_parcial']), 1, 0, 'C', true);

    $total_anual = $r['nota_final'];
    $pdf->SetTextColor(($total_anual !== null && $total_anual !== '' && (float)$total_anual < 51) ? 220 : 19);
    $pdf->Cell(15, $h, nota($total_anual), 1, 0, 'C', true);
    $pdf->SetTextColor(30);

    $pdf->Cell(35, $h, textoPDF($r['literal'] ?? 'SIN NOTA'), 1, 0, 'C', true);

    $e = strtoupper(trim((string)($r['estado'] ?? '')));
    $es_segundo = isset($r['segundo_turno']) && $r['segundo_turno'] == 1;
    
    if ($e === 'APROBADO') { 
        $bg = [25, 135, 84]; $fg = [255, 255, 255]; $lbl = 'APROBADO'; 
    } elseif ($e === 'REPROBADO' && $es_segundo) { 
        $bg = [253, 126, 20]; $fg = [255, 255, 255]; $lbl = '2DO TURNO'; 
    } elseif ($e === 'REPROBADO') { 
        $bg = [220, 53, 69]; $fg = [255, 255, 255]; $lbl = 'REPROBADO'; 
    } else { 
        $bg = [13, 202, 240]; $fg = [0, 0, 0]; $lbl = 'EN PROCESO'; 
    }

    $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
    $pdf->SetTextColor($fg[0], $fg[1], $fg[2]);
    $pdf->SetFont('Helvetica', 'B', 6);
    $pdf->Cell(24, $h, textoPDF($lbl), 1, 0, 'C', true);
    $pdf->Ln();
}

if ($pdf->GetY() + 30 > 190) $pdf->AddPage();
$y = $pdf->GetY() + 4;
$pdf->SetFillColor(240, 248, 243);
$pdf->SetDrawColor(25, 135, 84);
$pdf->SetLineWidth(0.4);
$pdf->Rect(10, $y, 277, 24, 'DF');

$pdf->SetXY(10, $y + 3);
$pdf->SetTextColor(30);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(277, 6, textoPDF('RESUMEN ACADEMICO FINAL'), 0, 2, 'C');

$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(277, 5, textoPDF("Total Materias: $total_materias | Aprobadas: $aprobadas | Reprobadas: $reprobadas | En Proceso: $en_proceso"), 0, 2, 'C');

if (strpos($global, 'APROBADO') !== false) { $bg = [25, 135, 84]; $fg = [255, 255, 255]; }
elseif (strpos($global, 'SEGUNDO TURNO') !== false) { $bg = [253, 126, 20]; $fg = [255, 255, 255]; }
elseif (strpos($global, 'REPROBADO') !== false) { $bg = [220, 53, 69]; $fg = [255, 255, 255]; }
else { $bg = [13, 202, 240]; $fg = [0, 0, 0]; }

$pdf->SetXY(14, $y + 14);
$pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
$pdf->SetTextColor($fg[0], $fg[1], $fg[2]);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(269, 8, textoPDF($global), 1, 0, 'C', true);

$pdf->Output('I', 'Reporte_Notas_' . $est['ci'] . '_' . date('d-m-Y') . '.pdf');
exit;