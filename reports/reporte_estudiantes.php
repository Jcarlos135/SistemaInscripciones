<?php
if (ob_get_length()) {
    ob_end_clean();
}
ob_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?action=login");
    exit();
}

date_default_timezone_set('America/La_Paz');
require_once 'config/db.php';
require_once 'models/funciones.php';
require_once 'lib/fpdf/fpdf.php';

mysqli_set_charset($conn, 'utf8');

class PDF_ReporteGeneral extends FPDF {
    public $instituto = 'INSTITUTO TECNOLÓGICO SUPERIOR';
    public $titulo = 'REPORTE GENERAL DE ESTUDIANTES Y CONDICIÓN ACADÉMICA';

    function Header() {
        $this->SetFillColor(2, 40, 24);
        $this->Rect(0, 0, 216, 20, 'F');
        $this->SetFillColor(5, 157, 59);
        $this->Rect(0, 20, 216, 2, 'F');
        
        $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 12);
        $this->SetXY(12, 3);
        $this->Cell(150, 8, textoPDF($this->instituto), 0, 2, 'L');
        
        $this->SetFont('Helvetica', '', 9);
        $this->Cell(150, 6, textoPDF($this->titulo), 0, 0, 'L');
        
        $this->SetFont('Helvetica', '', 8);
        $this->SetXY(-55, 6);
        $this->Cell(45, 5, textoPDF('Emision: ') . date('d/m/Y'), 0, 2, 'R');
        $this->SetY(26);
    }

    function Footer() {
        $this->SetY(-14);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(110);
        $this->Cell(0, 8, textoPDF('Sistema de Gestion Academica - Pagina ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}

$gestion = isset($_GET['gestion']) ? $_GET['gestion'] : '2026';
$tipo_reporte = isset($_GET['tipo']) ? $_GET['tipo'] : 'TODOS';
$ci_filtro = isset($_GET['ci']) ? trim($_GET['ci']) : '';

$pdf = new PDF_ReporteGeneral('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 14);
$pdf->SetMargins(12, 0, 12);
$pdf->AddPage();

// Cabecera de la tabla general
$pdf->SetFillColor(33, 37, 41);
$pdf->SetTextColor(255);
$pdf->SetFont('Helvetica', 'B', 8.5);

$pdf->Cell(30, 7, textoPDF('C.I.'), 1, 0, 'C', true);
$pdf->Cell(82, 7, textoPDF('ESTUDIANTE'), 1, 0, 'L', true);
$pdf->Cell(40, 7, textoPDF('ESTADO ACADEMICO'), 1, 0, 'C', true);
$pdf->Cell(40, 7, textoPDF('ACCION REQUERIDA'), 1, 1, 'C', true);

$total_estudiantes = 0;
$total_aprobados = 0;
$total_arrastres = 0;
$total_repetidores = 0;
$total_retirados = 0;

$sql_est = "SELECT DISTINCT e.ci, e.nombre, e.ap_pat, e.ap_mat 
            FROM estudiante e 
            INNER JOIN historial h ON e.ci = h.ci_est 
            WHERE h.gestion = '$gestion'";

if (!empty($ci_filtro)) {
    $sql_est .= " AND e.ci = '$ci_filtro'";
}
$sql_est .= " ORDER BY e.ap_pat, e.nombre";

$res_est = mysqli_query($conn, $sql_est);
$fill = false;
$h = 6;

if ($res_est && mysqli_num_rows($res_est) > 0) {
    while ($e = mysqli_fetch_assoc($res_est)) {
        $eval = function_exists('evaluarCondicionEstudianteV2') ? evaluarCondicionEstudianteV2($conn, $e['ci'], $gestion) : ['estado' => 'N/A', 'reprobadas' => 0];
        $estado = $eval['estado'];

        if ($tipo_reporte == 'APROBADO' && $estado != 'APROBADO') continue;
        if ($tipo_reporte == 'ARRASTRE' && $estado != 'ARRASTRE_TURNO_DISTINTO') continue;
        if ($tipo_reporte == 'REPROBADO' && !in_array($estado, ['REPETIDOR_PARCIAL', 'RETIRADO_REINICIO'])) continue;

        $fondo = ($fill) ? [243, 247, 245] : [255, 255, 255];
        $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
        $pdf->SetTextColor(30);
        $pdf->SetFont('Helvetica', '', 8.5);

        $nombre = trim($e['ap_pat'] . ' ' . $e['ap_mat'] . ' ' . $e['nombre']);

        $pdf->Cell(30, $h, textoPDF($e['ci']), 1, 0, 'C', true);
        $pdf->Cell(82, $h, textoPDF($nombre), 1, 0, 'L', true);

        $texto_estado = '';
        $accion = '';

        if ($estado == 'APROBADO') {
            $bg = [25, 135, 84]; $fg = [255, 255, 255];
            $texto_estado = 'APROBADO';
            $accion = 'Promovido';
            $total_aprobados++;
        } elseif ($estado == 'ARRASTRE_TURNO_DISTINTO') {
            $bg = [253, 126, 20]; $fg = [255, 255, 255];
            $texto_estado = 'ARRASTRE (' . $eval['reprobadas'] . ' mat.)';
            $accion = 'Turno Distinto';
            $total_arrastres++;
        } elseif ($estado == 'REPETIDOR_PARCIAL') {
            $bg = [220, 53, 69]; $fg = [255, 255, 255];
            $texto_estado = 'REPETIDOR';
            $accion = 'Mismo Turno';
            $total_repetidores++;
        } else {
            $bg = [220, 53, 69]; $fg = [255, 255, 255];
            $texto_estado = 'RETIRADO';
            $accion = 'Pérdida de Año';
            $total_retirados++;
        }

        $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
        $pdf->SetTextColor($fg[0], $fg[1], $fg[2]);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell(40, $h, textoPDF($texto_estado), 1, 0, 'C', true);

        // Celda de acción con estilo limpio
        $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
        $pdf->SetTextColor(30);
        $pdf->SetFont('Helvetica', '', 8.5);
        $pdf->Cell(40, $h, textoPDF($accion), 1, 1, 'C', true);

        $total_estudiantes++;
        $fill = !$fill;
    }
} else {
    $pdf->SetFillColor(255, 245, 238);
    $pdf->SetTextColor(180, 60, 60);
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->Cell(192, 8, textoPDF('No hay estudiantes registrados con los criterios seleccionados.'), 1, 1, 'C', true);
}

// Cuadro de Resumen General
if ($pdf->GetY() + 35 > 250) $pdf->AddPage();
$y = $pdf->GetY() + 4;

$pdf->SetFillColor(240, 248, 243);
$pdf->SetDrawColor(25, 135, 84);
$pdf->SetLineWidth(0.4);
$pdf->Rect(12, $y, 192, 28, 'DF');

$pdf->SetXY(12, $y + 3);
$pdf->SetTextColor(30);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(192, 5, textoPDF('RESUMEN GENERAL DEL REPORTE'), 0, 2, 'C');

$pdf->SetFont('Helvetica', '', 8.5);
$pdf->Cell(192, 5, textoPDF("Aprobados: $total_aprobados | Arrastres: $total_arrastres | Repetidores: $total_repetidores | Retirados: $total_retirados"), 0, 2, 'C');

$pdf->SetXY(15, $y + 16);
$pdf->SetFillColor(2, 40, 24);
$pdf->SetTextColor(255);
$pdf->SetFont('Helvetica', 'B', 9.5);
$pdf->Cell(186, 7, textoPDF('TOTAL GENERAL EVALUADOS: ' . $total_estudiantes), 1, 0, 'C', true);

if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output('I', 'Reporte_General_Estudiantes_' . date('Y-m-d') . '.pdf');
exit;
?>