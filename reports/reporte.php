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

// =====================================================
// RUTA DEL LOGO
// =====================================================
$logo_path = __DIR__ . '/../public/img/portada/logo.png';
if (!file_exists($logo_path)) {
    $logo_path = $_SERVER['DOCUMENT_ROOT'] . '/sig/public/img/portada/logo.png';
}
if (!file_exists($logo_path)) {
    $logo_path = $_SERVER['DOCUMENT_ROOT'] . '/public/img/portada/logo.png';
}

class PDF extends FPDF
{
    public $instituto = 'INSTITUTO TECNOLÓGICO SUPERIOR';
    public $titulo = 'FICHA ACADÉMICA DEL ESTUDIANTE POR AÑO';
    public $logo_path = '';

    function Header()
    {
        // Fondo rojo principal
        $this->SetFillColor(180, 0, 0);
        $this->Rect(0, 0, 216, 24, 'F');
        // Línea más oscura inferior
        $this->SetFillColor(100, 0, 0);
        $this->Rect(0, 24, 216, 2, 'F');

        // Logo (si existe)
        $x_texto = 12;
        if (!empty($this->logo_path) && file_exists($this->logo_path)) {
            $this->Image($this->logo_path, 10, 3, 18, 18);
            $x_texto = 32;
        }

        // Texto institucional
        $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 12);
        $this->SetXY($x_texto, 4);
        $this->Cell(150, 7, textoPDF($this->instituto), 0, 2, 'L');
        $this->SetFont('Helvetica', '', 9);
        $this->SetXY($x_texto, 12);
        $this->Cell(150, 5, textoPDF($this->titulo), 0, 0, 'L');

        // Fecha emisión (derecha)
        $this->SetFont('Helvetica', '', 8);
        $this->SetXY(-55, 6);
        $this->Cell(45, 5, textoPDF('Emision: ') . date('d/m/Y'), 0, 2, 'R');

        $this->SetY(30);
    }

    function Footer()
    {
        $this->SetY(-14);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(110);
        $this->Cell(0, 8, textoPDF('Sistema de Gestion Academica - Pagina ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}

// =====================================================
// DATOS DEL ESTUDIANTE
// =====================================================
$resEst = mysqli_query($conn, "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.img, e.id_usuario,
                                       c.nombre AS carrera, c.resolucion
                                FROM estudiante e
                                LEFT JOIN carrera c ON c.id = e.id_carrera
                                WHERE e.ci = '$ci' LIMIT 1");
$est = mysqli_fetch_assoc($resEst);
if (!$est) {
    die('Estudiante no encontrado.');
}

// =====================================================
// OBTENER CONTRASEÑA DEL USUARIO
// =====================================================
$clave_usuario = '';
$usuario_login = '';

$id_usr_est = (int)($est['id_usuario'] ?? 0);
if ($id_usr_est > 0) {
    $resPass = mysqli_query($conn, "SELECT usuario, clave FROM usuario WHERE id = $id_usr_est LIMIT 1");
    if ($resPass && $rowPass = mysqli_fetch_assoc($resPass)) {
        $usuario_login = $rowPass['usuario'];
        $clave_usuario = $rowPass['clave'];
    }
}
// Fallback: buscar por CI
if (empty($clave_usuario)) {
    $resPass = mysqli_query($conn, "SELECT usuario, clave FROM usuario WHERE usuario = '$ci' LIMIT 1");
    if ($resPass && $rowPass = mysqli_fetch_assoc($resPass)) {
        $usuario_login = $rowPass['usuario'];
        $clave_usuario = $rowPass['clave'];
    }
}
if (empty($usuario_login)) $usuario_login = $est['ci'];
if (empty($clave_usuario)) $clave_usuario = '(no asignada)';

$nombreCompleto = trim(($est['nombre'] ?? '') . ' ' . ($est['ap_pat'] ?? '') . ' ' . ($est['ap_mat'] ?? ''));

$gestion_filtro = $_GET['gestion'] ?? date('Y');

// =====================================================
// CONSULTA DE HISTORIAL
// =====================================================
$q_hist = "SELECT h.*, a.nombre AS materia_nombre, a.codigo AS cod_asignatura, a.nivel
           FROM inscripcion i
           INNER JOIN asignatura a ON a.codigo = i.cod_asig
           LEFT JOIN historial h ON h.id = (SELECT MAX(h2.id) FROM historial h2
                           WHERE h2.ci_est = i.ci_est AND h2.cod_asig = i.cod_asig)
           WHERE i.ci_est = '$ci' AND i.activo = 1 
             AND COALESCE(h.gestion, a.gestion, '$gestion_filtro') = '$gestion_filtro'
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
$convalidadas = 0;

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

        $literal = strtoupper(trim($m['literal'] ?? ''));
        $nota = (int)($m['TotalAnual'] ?? 0);

        if ($literal === 'CONVALIDADO') {
            $convalidadas++;
            $aprobadas++;
        } elseif ($nota >= 61) {
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
$pdf->logo_path = $logo_path;
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 14);
$pdf->SetMargins(12, 0, 12);
$pdf->SetTitle('Reporte Ficha Académica - CI ' . $ci);
$pdf->AddPage();

// =====================================================
// CUADRO DE DATOS DEL ESTUDIANTE (rojo/blanco)
// =====================================================
$pdf->SetFillColor(255, 240, 240);
$pdf->SetDrawColor(180, 0, 0);
$pdf->SetLineWidth(0.4);
$pdf->Rect(12, 30, 192, 28, 'DF');

$pdf->SetTextColor(30);
$pdf->SetXY(15, 32);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(185, 5, textoPDF($nombreCompleto), 0, 2);
$pdf->SetFont('Helvetica', '', 8.5);
$pdf->Cell(185, 5, textoPDF('CI: ' . $est['ci'] . ' | Carrera: ' . ($est['carrera'] ?? 'Sin Asignar') . ' | Resolucion: ' . ($est['resolucion'] ?? '-')), 0, 2);
$pdf->Cell(185, 5, textoPDF('Gestion Evaluada: ' . $gestion_filtro . ' | Nota minima de aprobacion: 61'), 0, 2);

// Usuario y contraseña (en rojo)
$pdf->SetFont('Helvetica', 'B', 8.5);
$pdf->SetTextColor(180, 0, 0);
$pdf->Cell(185, 5, textoPDF('Usuario: ' . $usuario_login . '   |   Contraseña: ' . $clave_usuario), 0, 0);

$pdf->SetY(62);

$h = 6;
$hay_registros = false;

foreach ($materias_por_anio as $key => $lista_materias) {
    if (empty($lista_materias)) continue;
    $hay_registros = true;

    // Encabezado del año (rojo oscuro)
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->SetFillColor(180, 0, 0);
    $pdf->SetTextColor(255);
    $pdf->Cell(192, 7, textoPDF('MATERIAS DE ' . $nombres_anios[$key]), 1, 1, 'L', true);

    // Encabezado de columnas (rojo más oscuro)
    $pdf->SetFillColor(100, 0, 0);
    $pdf->SetTextColor(255);
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->Cell(25, $h, textoPDF('CODIGO'), 1, 0, 'C', true);
    $pdf->Cell(102, $h, textoPDF('MATERIA / ASIGNATURA'), 1, 0, 'L', true);
    $pdf->Cell(30, $h, textoPDF('NOTA ANUAL'), 1, 0, 'C', true);
    $pdf->Cell(35, $h, textoPDF('CONDICION'), 1, 1, 'C', true);

    $fill = false;
    foreach ($lista_materias as $m) {
        $fondo = ($fill) ? [255, 240, 240] : [255, 255, 255];
        $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
        $pdf->SetTextColor(30);
        $pdf->SetFont('Helvetica', '', 8);

        $literal = strtoupper(trim($m['literal'] ?? ''));
        $nota = (int)($m['TotalAnual'] ?? 0);
        $es_convalidado = ($literal === 'CONVALIDADO');

        // Determinar estado: CONVALIDADO tiene prioridad
        if ($es_convalidado) {
            $estado_materia = 'CONVALIDADO';
        } elseif ($nota >= 61) {
            $estado_materia = 'APROBADO';
        } else {
            $estado_materia = 'REPROBADO';
        }

        $pdf->Cell(25, $h, textoPDF($m['cod_asignatura']), 1, 0, 'C', true);
        $pdf->Cell(102, $h, textoPDF($m['materia_nombre']), 1, 0, 'L', true);

        // Columna de nota
        $pdf->SetFont('Helvetica', 'B', 8);
        if ($es_convalidado) {
            $pdf->SetTextColor(0, 80, 150); // Azul para convalidado
            $pdf->Cell(30, $h, 'CONVALIDADO', 1, 0, 'C', true);
        } else {
            $pdf->SetTextColor(180, 0, 0); // Rojo para notas
            $pdf->Cell(30, $h, nota($nota), 1, 0, 'C', true);
        }
        $pdf->SetTextColor(30);

        // Badge de condición
        if ($estado_materia === 'CONVALIDADO') {
            $bg = [0, 80, 150];
        } elseif ($estado_materia === 'APROBADO') {
            $bg = [180, 0, 0];
        } else {
            $bg = [60, 0, 0];
        }

        $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell(35, $h, textoPDF($estado_materia), 1, 1, 'C', true);

        $fill = !$fill;
    }
    $pdf->Ln(4);
}

if (!$hay_registros) {
    $pdf->SetFillColor(255, 240, 240);
    $pdf->SetTextColor(180, 0, 0);
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->Cell(192, 8, textoPDF('El estudiante no cuenta con materias registradas en esta gestion.'), 1, 1, 'C', true);
    $pdf->Ln(4);
}

// =====================================================
// EVALUACIÓN FINAL
// =====================================================
$eval = function_exists('evaluarCondicionEstudianteV2')
    ? evaluarCondicionEstudianteV2($conn, $ci, $gestion_filtro)
    : ['estado' => 'N/A', 'reprobadas' => $reprobadas];

$estado_final = $eval['estado'];
if ($estado_final == 'APROBADO') {
    $global = 'APROBADO: Pasa al siguiente Nivel.';
    $bg_glob = [180, 0, 0];
} elseif ($estado_final == 'ARRASTRE_TURNO_DISTINTO') {
    $global = 'ARRASTRE (' . $eval['reprobadas'] . ' materia/s): Inscribe materias reprobadas en Turno Distinto.';
    $bg_glob = [200, 80, 0];
} elseif ($estado_final == 'REPETIDOR_PARCIAL') {
    $global = 'REPETIDOR: Repite materias reprobadas en Mismo Turno.';
    $bg_glob = [120, 0, 0];
} elseif ($estado_final == 'RETIRADO_REINICIO') {
    $global = 'RETIRADO (Pérdida de Año): Reinicia el nivel desde cero.';
    $bg_glob = [80, 0, 0];
} else {
    $global = 'ESTADO EN PROCESO O SIN DEFINIR';
    $bg_glob = [150, 50, 50];
}

if ($pdf->GetY() + 30 > 250) $pdf->AddPage();
$y = $pdf->GetY() + 2;

$pdf->SetFillColor(255, 240, 240);
$pdf->SetDrawColor(180, 0, 0);
$pdf->SetLineWidth(0.4);
$pdf->Rect(12, $y, 192, 24, 'DF');

$pdf->SetXY(12, $y + 3);
$pdf->SetTextColor(30);
$pdf->SetFont('Helvetica', 'B', 8.5);
$pdf->Cell(192, 5, textoPDF('RESUMEN ACADEMICO FINAL'), 0, 2, 'C');

$pdf->SetFont('Helvetica', '', 8.5);
$resumen_txt = "Total Materias: $total_materias | Aprobadas: $aprobadas | Reprobadas: $reprobadas";
if ($convalidadas > 0) {
    $resumen_txt .= " | Convalidadas: $convalidadas";
}
$pdf->Cell(192, 5, textoPDF($resumen_txt), 0, 2, 'C');

$pdf->SetXY(15, $y + 15);
$pdf->SetFillColor($bg_glob[0], $bg_glob[1], $bg_glob[2]);
$pdf->SetTextColor(255);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(186, 7, textoPDF($global), 1, 0, 'C', true);

if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output('I', 'Reporte_Estudiante_' . $ci . '_' . date('d-m-Y') . '.pdf');
exit;
