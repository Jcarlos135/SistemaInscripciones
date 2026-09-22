<?php
// Capturar salidas accidentales para evitar errores de FPDF
if (ob_get_length()) {
    ob_end_clean();
}
ob_start();

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?action=login");
    exit();
}

date_default_timezone_set('America/La_Paz');
require_once 'config/db.php';
require_once 'models/funciones.php';
require_once 'lib/fpdf/fpdf.php';

// Paleta de colores azul y estados
$AZUL_PRINCIPAL = [41, 128, 185];
$AZUL_OSCURO    = [31, 97, 141];
$VERDE_ACTIVO   = [39, 174, 96];
$ROJO_INACTIVO  = [192, 57, 43];
$AMARILLO_WARN  = [230, 126, 34];
$AZUL_FILA_ALT  = [235, 245, 251];

// Parámetros por URL
$ci_est = isset($_GET['ci']) ? trim($_GET['ci']) : '';
$gestion = isset($_GET['gestion']) ? trim($_GET['gestion']) : '2026';

if (empty($ci_est)) {
    die("Error: Se requiere el C.I. del estudiante para generar este reporte.");
}

// Obtenemos los datos personales del estudiante
$q_est = "SELECT e.*, c.nombre AS nombre_carrera 
          FROM estudiante e 
          LEFT JOIN carrera c ON e.id_carrera = c.id 
          WHERE e.ci = '$ci_est'";
$res_est = mysqli_query($conn, $q_est);
$estudiante = mysqli_fetch_assoc($res_est);

if (!$estudiante) {
    die("Error: Estudiante no encontrado.");
}

class PDF_FichaEstudiante extends FPDF {
    function Header() {
        global $AZUL_PRINCIPAL;
        $this->SetFont('Arial', 'B', 15);
        $this->SetFillColor($AZUL_PRINCIPAL[0], $AZUL_PRINCIPAL[1], $AZUL_PRINCIPAL[2]);
        $this->SetTextColor(255);
        $this->Cell(0, 12, utf8_decode('FICHA ACADÉMICA DEL ESTUDIANTE POR AÑO'), 1, 1, 'C', true);
        
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(80);
        $this->Cell(0, 6, utf8_decode('Fecha de emisión: ' . date('d/m/Y H:i:s')), 0, 1, 'C');
        $this->Ln(3);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF_FichaEstudiante('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();

// === BLOQUE 1: DATOS PERSONALES DEL ESTUDIANTE ===
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor($AZUL_OSCURO[0], $AZUL_OSCURO[1], $AZUL_OSCURO[2]);
$pdf->SetTextColor(255);
$pdf->Cell(190, 7, utf8_decode('DATOS DEL ESTUDIANTE'), 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);
$pdf->SetFillColor(245, 245, 245);

$nombre_completo = utf8_decode($estudiante['ap_pat'] . ' ' . $estudiante['ap_mat'] . ' ' . $estudiante['nombre']);

$pdf->Cell(35, 6, utf8_decode('C.I.:'), 1, 0, 'L', true);
$pdf->Cell(60, 6, $estudiante['ci'], 1, 0, 'L');
$pdf->Cell(35, 6, utf8_decode('Gestión Evaluada:'), 1, 0, 'L', true);
$pdf->Cell(60, 6, $gestion, 1, 1, 'L');

$pdf->Cell(35, 6, utf8_decode('Estudiante:'), 1, 0, 'L', true);
$pdf->Cell(60, 6, $nombre_completo, 1, 0, 'L');
$pdf->Cell(35, 6, utf8_decode('Carrera:'), 1, 0, 'L', true);
$pdf->Cell(60, 6, utf8_decode($estudiante['nombre_carrera'] ?? 'Sin Asignar'), 1, 1, 'L');

$pdf->Ln(4);

// Obtener todo el historial de materias del estudiante en la gestión
$q_hist = "SELECT h.*, a.nombre AS materia_nombre, a.codigo AS cod_asignatura 
           FROM historial h 
           INNER JOIN asignatura a ON h.cod_asig = a.codigo 
           WHERE h.ci_est = '$ci_est' AND h.gestion = '$gestion'
           ORDER BY a.codigo ASC";
$res_hist = mysqli_query($conn, $q_hist);

// Agrupar materias por año según el código (Ej: ADS-206 extrae '2' para segundo año)
$materias_por_anio = [
    '1' => [], // Primer Año
    '2' => [], // Segundo Año
    '3' => [], // Tercer Año
    'X' => []  // Otros / Sin clasificar
];

if ($res_hist && mysqli_num_rows($res_hist) > 0) {
    while ($m = mysqli_fetch_assoc($res_hist)) {
        $codigo = trim($m['cod_asig']);
        // Extraer el primer dígito numérico que encuentre en el código (ej: de ADS-206 extrae '2')
        preg_match('/\d/', $codigo, $matches);
        $digito = isset($matches[0]) ? $matches[0] : 'X';

        if (array_key_exists($digito, $materias_por_anio)) {
            $materias_por_anio[$digito][] = $m;
        } else {
            $materias_por_anio['X'][] = $m;
        }
    }
}

$total_materias = 0;
$aprobadas = 0;
$reprobadas = 0;

$nombres_anios = [
    '1' => 'PRIMER AÑO',
    '2' => 'SEGUNDO AÑO',
    '3' => 'TERCER AÑO',
    'X' => 'OTROS NIVELES'
];

$hay_registros = false;

foreach ($materias_por_anio as $key => $lista_materias) {
    if (empty($lista_materias)) continue;
    $hay_registros = true;

    // === TÍTULO DE LA SECCIÓN POR AÑO ACADÉMICO ===
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor($AZUL_PRINCIPAL[0], $AZUL_PRINCIPAL[1], $AZUL_PRINCIPAL[2]);
    $pdf->SetTextColor(255);
    $pdf->Cell(190, 7, utf8_decode('MATERIAS DE ' . $nombres_anios[$key] . ' (GESTIÓN ' . $gestion . ')'), 1, 1, 'L', true);

    // Encabezado de columnas
    $pdf->SetFont('Arial', 'B', 8.5);
    $pdf->SetFillColor($AZUL_OSCURO[0], $AZUL_OSCURO[1], $AZUL_OSCURO[2]);
    $pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C', true);
    $pdf->Cell(85, 6, utf8_decode('Materia / Asignatura'), 1, 0, 'C', true);
    $pdf->Cell(35, 6, utf8_decode('Nota Anual'), 1, 0, 'C', true);
    $pdf->Cell(40, 6, utf8_decode('Condición'), 1, 1, 'C', true);

    $fill = false;
    foreach ($lista_materias as $m) {
        if ($fill) {
            $pdf->SetFillColor($AZUL_FILA_ALT[0], $AZUL_FILA_ALT[1], $AZUL_FILA_ALT[2]);
        } else {
            $pdf->SetFillColor(255, 255, 255);
        }

        $pdf->SetFont('Arial', '', 8.5);
        $pdf->SetTextColor(0);

        $nota = (int)($m['TotalAnual'] ?? 0);
        $estado_materia = ($nota >= 61) ? 'APROBADO' : 'REPROBADO';

        $pdf->Cell(30, 6, utf8_decode($m['cod_asig']), 1, 0, 'C', true);
        $pdf->Cell(85, 6, utf8_decode($m['materia_nombre']), 1, 0, 'L', true);
        $pdf->Cell(35, 6, $nota, 1, 0, 'C', true);

        if ($estado_materia == 'APROBADO') {
            $pdf->SetFillColor($VERDE_ACTIVO[0], $VERDE_ACTIVO[1], $VERDE_ACTIVO[2]);
            $aprobadas++;
        } else {
            $pdf->SetFillColor($ROJO_INACTIVO[0], $ROJO_INACTIVO[1], $ROJO_INACTIVO[2]);
            $reprobadas++;
        }

        $pdf->SetTextColor(255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 6, utf8_decode($estado_materia), 1, 1, 'C', true);

        $total_materias++;
        $fill = !$fill;
    }
    $pdf->Ln(3);
}

if (!$hay_registros) {
    $pdf->SetFillColor(255, 245, 238);
    $pdf->SetTextColor(180, 60, 60);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Cell(190, 8, utf8_decode('El estudiante no cuenta con materias registradas en esta gestión.'), 1, 1, 'C', true);
    $pdf->Ln(3);
}

// === EVALUACIÓN DE CONDICIÓN ACADÉMICA DEL ESTUDIANTE V2 ===
$eval = function_exists('evaluarCondicionEstudianteV2') 
        ? evaluarCondicionEstudianteV2($conn, $ci_est, $gestion) 
        : ['estado' => 'N/A', 'reprobadas' => $reprobadas];

$estado_final = $eval['estado'];
$texto_estado = '';
$accion_requerida = '';
$color_bg = $AZUL_OSCURO;

if ($estado_final == 'APROBADO') {
    $texto_estado = 'APROBADO (Promovido)';
    $accion_requerida = 'Inscribe siguiente nivel en Turno Normal';
    $color_bg = $VERDE_ACTIVO;
} elseif ($estado_final == 'ARRASTRE_TURNO_DISTINTO') {
    $texto_estado = 'ARRASTRE (' . $eval['reprobadas'] . ' materia/s)';
    $accion_requerida = 'Inscribe materias reprobadas en TURNO DISTINTO';
    $color_bg = $AMARILLO_WARN;
} elseif ($estado_final == 'REPETIDOR_PARCIAL') {
    $texto_estado = 'REPROBADO / REPETIDOR';
    $accion_requerida = 'Repite materias reprobadas en Mismo Turno';
    $color_bg = $ROJO_INACTIVO;
} elseif ($estado_final == 'RETIRADO_REINICIO') {
    $texto_estado = 'RETIRADO (Pérdida de Año)';
    $accion_requerida = 'El estudiante se retiró / Reinicia el nivel desde cero';
    $color_bg = $ROJO_INACTIVO;
} else {
    $texto_estado = 'SIN REGISTROS';
    $accion_requerida = 'Sin información suficiente registrada';
}

// === RESUMEN GENERAL Y CONDICIÓN FINAL ===
if ($pdf->GetY() > 220) {
    $pdf->AddPage();
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor($AZUL_PRINCIPAL[0], $AZUL_PRINCIPAL[1], $AZUL_PRINCIPAL[2]);
$pdf->SetTextColor(255);
$pdf->Cell(190, 8, utf8_decode('RESUMEN DE GESTIÓN Y CONDICIÓN FINAL'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);
$pdf->SetFillColor(240, 240, 240);

$pdf->Cell(140, 6, utf8_decode('Materias Aprobadas:'), 1, 0, 'L', true);
$pdf->Cell(50, 6, $aprobadas, 1, 1, 'C', true);

$pdf->Cell(140, 6, utf8_decode('Materias Reprobadas:'), 1, 0, 'L', true);
$pdf->Cell(50, 6, $reprobadas, 1, 1, 'C', true);

$pdf->Cell(140, 6, utf8_decode('Total Materias Inscritas:'), 1, 0, 'L', true);
$pdf->Cell(50, 6, $total_materias, 1, 1, 'C', true);

// Condición Final del Estudiante
$pdf->SetFont('Arial', 'B', 9.5);
$pdf->SetFillColor($color_bg[0], $color_bg[1], $color_bg[2]);
$pdf->SetTextColor(255);
$pdf->Cell(60, 8, utf8_decode('ESTADO FINAL:'), 1, 0, 'L', true);
$pdf->Cell(130, 8, utf8_decode($texto_estado), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 8.5);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetTextColor(0);
$pdf->Cell(60, 7, utf8_decode('OBSERVACIÓN / ACCIÓN:'), 1, 0, 'L', true);
$pdf->Cell(130, 7, utf8_decode($accion_requerida), 1, 1, 'L', true);

$pdf->Ln(6);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(128);
$pdf->Cell(0, 5, utf8_decode('Reporte académico individual clasificado por nivel académico.'), 0, 1, 'C');

// Limpiar buffer y exportar PDF
if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output('I', 'Reporte_Estudiante_' . $ci_est . '_Gestion_' . $gestion . '.pdf');
exit;
?>