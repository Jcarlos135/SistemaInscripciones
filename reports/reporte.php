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
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';

if (file_exists(__DIR__ . '/../lib/fpdf/fpdf.php')) {
    require_once __DIR__ . '/../lib/fpdf/fpdf.php';
} else {
    die('Error: Librería FPDF no encontrada.');
}

mysqli_set_charset($conn, 'utf8');

$ci_est = isset($_GET['ci']) ? trim($_GET['ci']) : '';

if (empty($ci_est)) {
    if (!empty($_SESSION['estudiante_ci'])) {
        $ci_est = trim($_SESSION['estudiante_ci']);
    } elseif (!empty($_SESSION['ci'])) {
        $ci_est = trim($_SESSION['ci']);
    } elseif (!empty($_SESSION['username'])) {
        $ci_est = trim($_SESSION['username']);
    } else {
        $id_usr = $_SESSION['usuario_id'];
        $q_u = mysqli_query($conn, "SELECT ci FROM estudiante WHERE id_usuario = '$id_usr' LIMIT 1");
        if ($q_u && $row_u = mysqli_fetch_assoc($q_u)) {
            $ci_est = $row_u['ci'];
        }
    }
}

if (empty($ci_est)) {
    die('Sesión no válida o C.I. de estudiante no encontrado.');
}

$ci = mysqli_real_escape_string($conn, $ci_est);

class PDF extends FPDF {
    public $instituto = 'INSTITUTO TECNOLÓGICO SUPERIOR';
    public $titulo = 'FICHA ACADÉMICA DEL ESTUDIANTE POR AÑO';

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

$gestion_filtro = $_GET['gestion'] ?? date('Y');

// Consulta corregida usando inscripcion y LEFT JOIN historial para capturar todas las notas (incluyendo reprobados)
$q_hist = "SELECT h.*, a.nombre AS materia_nombre, a.codigo AS cod_asignatura 
           FROM inscripcion i
           INNER JOIN asignatura a ON a.codigo = i.cod_asig
           LEFT JOIN historial h ON h.id = (SELECT MAX(h2.id) FROM historial h2
                           WHERE h2.ci_est = i.ci_est AND h2.cod_asig = i.cod_asig)
           WHERE i.ci_est = '$ci' AND i.activo = 1 AND COALESCE(h.gestion, a.gestion, '$gestion_filtro') = '$gestion_filtro'
           ORDER BY a.codigo ASC";
$res_hist = mysqli_query($conn, $q_hist);

$materias_por_anio = [
    '1' => [],
    '2' => [],
    '3' => [],
    'X' => []
];

$total_materias = 0;
$aprobadas = 0;
$reprobadas = 0;

if ($res_hist && mysqli_num_rows($res_hist) > 0) {
    while ($m = mysqli_fetch_assoc($res_hist)) {
        $codigo = trim($m['cod_asignatura']);
        preg_match('/\d/', $codigo, $matches);
        $digito = isset($matches[0]) ? $matches[0] : 'X';

        if (array_key_exists($digito, $materias_por_anio)) {
            $materias_por_anio[$digito][] = $m;
        } else {
            $materias_por_anio['X'][] = $m;
        }
        $total_materias++;
        
        $nota = (int)($m['TotalAnual'] ?? 0);
        if ($nota >= 61) {
            $aprobadas++;
        } else {
            $reprobadas++;
        }
    }
}

$nombres_anios = [
    '1' => 'PRIMER AÑO',
    '2' => 'SEGUNDO AÑO',
    '3' => 'TERCER AÑO',
    'X' => 'OTROS NIVELES'
];

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 14);
$pdf->SetMargins(12, 0, 12);
$pdf->SetTitle('Reporte Ficha Académica - CI ' . $ci);
$pdf->AddPage();

$pdf->SetFillColor(240, 248, 243);
$pdf->SetDrawColor(25, 135, 84);
$pdf->SetLineWidth(0.4);
$pdf->Rect(12, 26, 192, 20, 'DF');

$pdf->SetTextColor(30);
$pdf->SetXY(15, 28);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(185, 5, textoPDF($nombreCompleto), 0, 2);
$pdf->SetFont('Helvetica', '', 8.5);
$pdf->Cell(185, 5, textoPDF('CI: ' . $est['ci'] . ' | Carrera: ' . ($est['carrera'] ?? 'Sin Asignar') . ' | Resolucion: ' . ($est['resolucion'] ?? '-')), 0, 2);
$pdf->Cell(185, 5, textoPDF('Gestion Evaluada: ' . $gestion_filtro . ' | Nota minima de aprobacion: 61'), 0, 0);

$pdf->SetY(50);

$h = 6;
$hay_registros = false;

foreach ($materias_por_anio as $key => $lista_materias) {
    if (empty($lista_materias)) continue;
    $hay_registros = true;

    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->SetFillColor(2, 40, 24);
    $pdf->SetTextColor(255);
    $pdf->Cell(192, 7, textoPDF('MATERIAS DE ' . $nombres_anios[$key]), 1, 1, 'L', true);

    $pdf->SetFillColor(33, 37, 41);
    $pdf->SetTextColor(255);
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->Cell(25, $h, textoPDF('CODIGO'), 1, 0, 'C', true);
    $pdf->Cell(102, $h, textoPDF('MATERIA / ASIGNATURA'), 1, 0, 'L', true);
    $pdf->Cell(30, $h, textoPDF('NOTA ANUAL'), 1, 0, 'C', true);
    $pdf->Cell(35, $h, textoPDF('CONDICION'), 1, 1, 'C', true);

    $fill = false;
    foreach ($lista_materias as $m) {
        $fondo = ($fill) ? [243, 247, 245] : [255, 255, 255];
        $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
        $pdf->SetTextColor(30);
        $pdf->SetFont('Helvetica', '', 8);

        $nota = (int)($m['TotalAnual'] ?? 0);
        $estado_materia = ($nota >= 61) ? 'APROBADO' : 'REPROBADO';

        $pdf->Cell(25, $h, textoPDF($m['cod_asignatura']), 1, 0, 'C', true);
        $pdf->Cell(102, $h, textoPDF($m['materia_nombre']), 1, 0, 'L', true);
        
        $pdf->SetFont('Helvetica', 'B', 8);
        if ($nota < 61) {
            $pdf->SetTextColor(180, 0, 0); // Rojo oscuro legible para reprobados
        } else {
            $pdf->SetTextColor(0, 100, 0); // Verde oscuro para aprobados
        }
        $pdf->Cell(30, $h, nota($nota), 1, 0, 'C', true);
        $pdf->SetTextColor(30); // Restablecer color base

        if ($estado_materia == 'APROBADO') {
            $bg = [25, 135, 84]; $fg = [255, 255, 255];
        } else {
            $bg = [220, 53, 69]; $fg = [255, 255, 255];
        }

        $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
        $pdf->SetTextColor($fg[0], $fg[1], $fg[2]);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell(35, $h, textoPDF($estado_materia), 1, 1, 'C', true);

        $fill = !$fill;
    }
    $pdf->Ln(4);
}

if (!$hay_registros) {
    $pdf->SetFillColor(255, 245, 238);
    $pdf->SetTextColor(180, 60, 60);
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->Cell(192, 8, textoPDF('El estudiante no cuenta con materias registradas en esta gestion.'), 1, 1, 'C', true);
    $pdf->Ln(4);
}

$eval = function_exists('evaluarCondicionEstudianteV2') 
        ? evaluarCondicionEstudianteV2($conn, $ci, $gestion_filtro) 
        : ['estado' => 'N/A', 'reprobadas' => $reprobadas];

$estado_final = $eval['estado'];
if ($estado_final == 'APROBADO') {
    $global = 'APROBADO: Pasa al siguiente Nivel.';
    $bg_glob = [25, 135, 84];
} elseif ($estado_final == 'ARRASTRE_TURNO_DISTINTO') {
    $global = 'ARRASTRE (' . $eval['reprobadas'] . ' materia/s): Inscribe materias reprobadas en Turno Distinto.';
    $bg_glob = [253, 126, 20];
} elseif ($estado_final == 'REPETIDOR_PARCIAL') {
    $global = 'REPETIDOR: Repite materias reprobadas en Mismo Turno.';
    $bg_glob = [220, 53, 69];
} elseif ($estado_final == 'RETIRADO_REINICIO') {
    $global = 'RETIRADO (Pérdida de Año): Reinicia el nivel desde cero.';
    $bg_glob = [220, 53, 69];
} else {
    $global = 'ESTADO EN PROCESO O SIN DEFINIR';
    $bg_glob = [13, 202, 240];
}

if ($pdf->GetY() + 30 > 250) $pdf->AddPage();
$y = $pdf->GetY() + 2;

$pdf->SetFillColor(240, 248, 243);
$pdf->SetDrawColor(25, 135, 84);
$pdf->SetLineWidth(0.4);
$pdf->Rect(12, $y, 192, 22, 'DF');

$pdf->SetXY(12, $y + 3);
$pdf->SetTextColor(30);
$pdf->SetFont('Helvetica', 'B', 8.5);
$pdf->Cell(192, 5, textoPDF('RESUMEN ACADEMICO FINAL'), 0, 2, 'C');

$pdf->SetFont('Helvetica', '', 8.5);
$pdf->Cell(192, 5, textoPDF("Total Materias: $total_materias | Aprobadas: $aprobadas | Reprobadas: $reprobadas"), 0, 2, 'C');

$pdf->SetXY(15, $y + 13);
$pdf->SetFillColor($bg_glob[0], $bg_glob[1], $bg_glob[2]);
$pdf->SetTextColor(255);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(186, 7, textoPDF($global), 1, 0, 'C', true);

if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output('I', 'Reporte_Estudiante_' . $ci . '_' . date('d-m-Y') . '.pdf');
exit;