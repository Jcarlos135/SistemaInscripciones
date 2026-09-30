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

// =====================================================
// FUNCIÓN AUXILIAR PARA MOSTRAR NOTAS
// =====================================================
function verNotaPDF($val)
{
    return (isset($val) && $val !== '' && $val !== null) ? htmlspecialchars($val) : '-';
}

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
    public $titulo = 'FICHA ACADÉMICA DEL ESTUDIANTE';
    public $logo_path = '';

    function Header()
    {
        $this->SetFillColor(180, 0, 0);
        $this->Rect(0, 0, 216, 24, 'F');
        $this->SetFillColor(100, 0, 0);
        $this->Rect(0, 24, 216, 2, 'F');

        $x_texto = 12;
        if (!empty($this->logo_path) && file_exists($this->logo_path)) {
            $this->Image($this->logo_path, 10, 3, 18, 18);
            $x_texto = 32;
        }

        $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 12);
        $this->SetXY($x_texto, 4);
        $this->Cell(150, 7, textoPDF($this->instituto), 0, 2, 'L');
        $this->SetFont('Helvetica', '', 9);
        $this->SetXY($x_texto, 12);
        $this->Cell(150, 5, textoPDF($this->titulo), 0, 0, 'L');

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
$resEst = mysqli_query($conn, "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.img, e.id_usuario, e.id_carrera,
                                       c.nombre AS carrera, c.resolucion
                                FROM estudiante e
                                LEFT JOIN carrera c ON c.id = e.id_carrera
                                WHERE e.ci = '$ci' LIMIT 1");
$est = mysqli_fetch_assoc($resEst);
if (!$est) {
    die('Estudiante no encontrado.');
}

// =====================================================
// CONTRASEÑA DEL USUARIO
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

// =====================================================
// DETECTAR MODO: ¿Gestión específica o TODAS?
// =====================================================
$gestion_filtro = isset($_GET['gestion']) && trim($_GET['gestion']) !== ''
    ? trim($_GET['gestion'])
    : null;

$modo_todas = ($gestion_filtro === null);

// =====================================================
// CONSULTA DE HISTORIAL (según modo)
// =====================================================
if ($modo_todas) {
    $q_hist = "SELECT 
                    h.id AS hist_id,
                    i.gestion AS gestion,
                    i.cod_asig AS cod_asignatura,
                    a.nombre AS materia_nombre,
                    a.nivel,
                    h.nota_teorico1, h.nota_pract1, h.nota_primerbim,
                    h.nota_teorico2, h.nota_pract2, h.nota_segundobim,
                    h.nota_teorico3, h.nota_pract3, h.nota_tercerbim,
                    h.nota_teorico4, h.nota_pract4, h.nota_cuartobim,
                    h.nota_parcial, h.segundo_turno, h.TotalAnual,
                    h.literal, h.observaciones, h.estado, h.id_docente
               FROM inscripcion i
               INNER JOIN asignatura a ON a.codigo = i.cod_asig
               LEFT JOIN historial h 
                    ON h.ci_est = i.ci_est 
                    AND h.cod_asig = i.cod_asig 
                    AND h.gestion = i.gestion
               WHERE i.ci_est = '$ci' 
                 AND i.activo = 1
               ORDER BY i.gestion ASC, a.nivel ASC, a.codigo ASC";
} else {
    $q_hist = "SELECT 
                    h.id AS hist_id,
                    i.gestion AS gestion,
                    i.cod_asig AS cod_asignatura,
                    a.nombre AS materia_nombre,
                    a.nivel,
                    h.nota_teorico1, h.nota_pract1, h.nota_primerbim,
                    h.nota_teorico2, h.nota_pract2, h.nota_segundobim,
                    h.nota_teorico3, h.nota_pract3, h.nota_tercerbim,
                    h.nota_teorico4, h.nota_pract4, h.nota_cuartobim,
                    h.nota_parcial, h.segundo_turno, h.TotalAnual,
                    h.literal, h.observaciones, h.estado, h.id_docente
               FROM inscripcion i
               INNER JOIN asignatura a ON a.codigo = i.cod_asig
               LEFT JOIN historial h 
                    ON h.ci_est = i.ci_est 
                    AND h.cod_asig = i.cod_asig 
                    AND h.gestion = i.gestion
               WHERE i.ci_est = '$ci' 
                 AND i.activo = 1
                 AND i.gestion = '$gestion_filtro'
               ORDER BY a.nivel ASC, a.codigo ASC";
}
$res_hist = mysqli_query($conn, $q_hist);

// =====================================================
// AGRUPAR DATOS
// =====================================================
$datos_por_gestion = [];
$materias_por_anio = ['1' => [], '2' => [], '3' => [], 'X' => []];

$total_materias = 0;
$aprobadas = 0;
$reprobadas = 0;
$convalidadas = 0;

if ($res_hist && mysqli_num_rows($res_hist) > 0) {
    while ($m = mysqli_fetch_assoc($res_hist)) {
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

        if ($modo_todas) {
            $g = $m['gestion'] ?? 'SIN GESTION';
            if (!isset($datos_por_gestion[$g])) {
                $datos_por_gestion[$g] = [];
            }
            $datos_por_gestion[$g][] = $m;
        } else {
            $codigo = trim($m['cod_asignatura']);
            preg_match('/\d/', $codigo, $matches);
            $digito = isset($matches[0]) ? $matches[0] : 'X';
            if (array_key_exists($digito, $materias_por_anio)) {
                $materias_por_anio[$digito][] = $m;
            } else {
                $materias_por_anio['X'][] = $m;
            }
        }
    }
}

$nombres_anios = [
    '1' => 'PRIMER AÑO',
    '2' => 'SEGUNDO AÑO',
    '3' => 'TERCER AÑO',
    'X' => 'OTROS NIVELES'
];

// =====================================================
// INICIALIZAR PDF
// =====================================================
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->logo_path = $logo_path;
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 14);
$pdf->SetMargins(12, 0, 12);
$pdf->SetTitle('Ficha Académica - CI ' . $ci);
$pdf->AddPage();

// =====================================================
// CUADRO DE DATOS DEL ESTUDIANTE
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

$texto_gestion = $modo_todas ? 'TODAS LAS GESTIONES' : $gestion_filtro;
$pdf->Cell(185, 5, textoPDF('Gestion Evaluada: ' . $texto_gestion . ' | Nota minima de aprobacion: 61'), 0, 2);

$pdf->SetFont('Helvetica', 'B', 8.5);
$pdf->SetTextColor(180, 0, 0);
$pdf->Cell(185, 5, textoPDF('Usuario: ' . $usuario_login . '   |   Contraseña: ' . $clave_usuario), 0, 0);

$pdf->SetY(62);

$h = 6;
$hay_registros = false;

// =====================================================
// FUNCIÓN PARA DIBUJAR ENCABEZADO DE TABLA
// =====================================================
function dibujarEncabezadoTabla($pdf, $h)
{
    // Primera fila
    $pdf->SetFillColor(100, 0, 0);
    $pdf->SetTextColor(255);
    $pdf->SetFont('Helvetica', 'B', 7);

    $pdf->Cell(20, 5, textoPDF('CODIGO'), 1, 0, 'C', true);
    $pdf->Cell(54, 5, textoPDF('MATERIA / ASIGNATURA'), 1, 0, 'L', true);
    $pdf->Cell(48, 5, textoPDF('NOTAS BIMESTRALES'), 1, 0, 'C', true);
    $pdf->Cell(14, 5, textoPDF('PARC'), 1, 0, 'C', true);
    $pdf->Cell(14, 5, textoPDF('2DO T'), 1, 0, 'C', true);
    $pdf->Cell(14, 5, textoPDF('TOTAL'), 1, 0, 'C', true);
    $pdf->Cell(28, 5, textoPDF('CONDICION'), 1, 1, 'C', true);

    // Segunda fila (subcolumnas)
    $pdf->Cell(20, 5, '', 1, 0, 'C', true);
    $pdf->Cell(54, 5, '', 1, 0, 'C', true);
    $pdf->Cell(12, 5, textoPDF('1B'), 1, 0, 'C', true);
    $pdf->Cell(12, 5, textoPDF('2B'), 1, 0, 'C', true);
    $pdf->Cell(12, 5, textoPDF('3B'), 1, 0, 'C', true);
    $pdf->Cell(12, 5, textoPDF('4B'), 1, 0, 'C', true);
    $pdf->Cell(14, 5, '', 1, 0, 'C', true);
    $pdf->Cell(14, 5, '', 1, 0, 'C', true);
    $pdf->Cell(14, 5, '', 1, 0, 'C', true);
    $pdf->Cell(28, 5, '', 1, 1, 'C', true);
}

// =====================================================
// FUNCIÓN PARA DIBUJAR UNA FILA DE MATERIA
// =====================================================
function dibujarFilaMateria($pdf, $m, $h, $fill)
{
    $fondo = ($fill) ? [255, 240, 240] : [255, 255, 255];
    $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
    $pdf->SetTextColor(30);
    $pdf->SetFont('Helvetica', '', 7);

    $literal = strtoupper(trim($m['literal'] ?? ''));
    $nota = (int)($m['TotalAnual'] ?? 0);
    $es_convalidado = ($literal === 'CONVALIDADO');

    if ($es_convalidado) {
        $estado_materia = 'CONVALIDADO';
    } elseif ($nota >= 61) {
        $estado_materia = 'APROBADO';
    } else {
        $estado_materia = 'REPROBADO';
    }

    // Código y materia
    $pdf->Cell(20, $h, textoPDF($m['cod_asignatura']), 1, 0, 'C', true);
    $pdf->Cell(54, $h, textoPDF($m['materia_nombre']), 1, 0, 'L', true);

    // Notas bimestrales
    if ($es_convalidado) {
        $pdf->SetTextColor(0, 80, 150);
        $pdf->SetFont('Helvetica', 'B', 6.5);
        $pdf->Cell(48, $h, 'CONVALIDADO', 1, 0, 'C', true);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(30);
        $pdf->Cell(14, $h, '-', 1, 0, 'C', true);
        $pdf->Cell(14, $h, '-', 1, 0, 'C', true);
        $pdf->Cell(14, $h, '-', 1, 0, 'C', true);
    } else {
        $pdf->Cell(12, $h, verNotaPDF($m['nota_primerbim']), 1, 0, 'C', true);
        $pdf->Cell(12, $h, verNotaPDF($m['nota_segundobim']), 1, 0, 'C', true);
        $pdf->Cell(12, $h, verNotaPDF($m['nota_tercerbim']), 1, 0, 'C', true);
        $pdf->Cell(12, $h, verNotaPDF($m['nota_cuartobim']), 1, 0, 'C', true);

        // Nota parcial
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->SetTextColor(0, 0, 180);
        $pdf->Cell(14, $h, verNotaPDF($m['nota_parcial']), 1, 0, 'C', true);

        // Segundo turno
        $pdf->SetTextColor(200, 100, 0);
        $pdf->Cell(14, $h, verNotaPDF($m['segundo_turno']), 1, 0, 'C', true);

        // Total anual
        $pdf->SetTextColor(180, 0, 0);
        $pdf->Cell(14, $h, verNotaPDF($m['TotalAnual']), 1, 0, 'C', true);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(30);
    }

    // Condición
    if ($estado_materia === 'CONVALIDADO') {
        $bg = [0, 80, 150];
    } elseif ($estado_materia === 'APROBADO') {
        $bg = [180, 0, 0];
    } else {
        $bg = [60, 0, 0];
    }

    $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->Cell(28, $h, textoPDF($estado_materia), 1, 1, 'C', true);
}
// =====================================================
// RENDERIZAR TABLAS
// =====================================================

// ---------- MODO TODAS LAS GESTIONES ----------
if ($modo_todas) {
    if (!empty($datos_por_gestion)) {
        foreach ($datos_por_gestion as $gestion => $materias) {
            $hay_registros = true;

            // Encabezado de la gestión
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->SetFillColor(180, 0, 0);
            $pdf->SetTextColor(255);
            $pdf->Cell(192, 8, textoPDF('GESTIÓN ' . $gestion), 1, 1, 'C', true);

            // Encabezado de columnas
            dibujarEncabezadoTabla($pdf, $h);

            $fill = false;
            $materias_aprobadas_g = 0;
            $materias_reprobadas_g = 0;
            $materias_convalidadas_g = 0;

            foreach ($materias as $m) {
                $literal = strtoupper(trim($m['literal'] ?? ''));
                $nota = (int)($m['TotalAnual'] ?? 0);

                if ($literal === 'CONVALIDADO') {
                    $materias_convalidadas_g++;
                    $materias_aprobadas_g++;
                } elseif ($nota >= 61) {
                    $materias_aprobadas_g++;
                } else {
                    $materias_reprobadas_g++;
                }

                dibujarFilaMateria($pdf, $m, $h, $fill);
                $fill = !$fill;
            }

            // Subtotal por gestión
            $pdf->SetFont('Helvetica', 'I', 8);
            $pdf->SetTextColor(80);
            $subtotal_txt = "Subtotal Gestión $gestion: " . count($materias) . " materias";
            if ($materias_convalidadas_g > 0) $subtotal_txt .= " | Convalidadas: $materias_convalidadas_g";
            $subtotal_txt .= " | Aprobadas: $materias_aprobadas_g | Reprobadas: $materias_reprobadas_g";
            $pdf->Cell(192, 5, textoPDF($subtotal_txt), 0, 1, 'R');

            $pdf->Ln(4);

            // Salto de página si es necesario
            if ($pdf->GetY() + 40 > 250) {
                $pdf->AddPage();
            }
        }
    }
}
// ---------- MODO GESTIÓN ESPECÍFICA ----------
else {
    foreach ($materias_por_anio as $key => $lista_materias) {
        if (empty($lista_materias)) continue;
        $hay_registros = true;

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetFillColor(180, 0, 0);
        $pdf->SetTextColor(255);
        $pdf->Cell(192, 7, textoPDF('MATERIAS DE ' . $nombres_anios[$key]), 1, 1, 'L', true);

        // Encabezado de columnas
        dibujarEncabezadoTabla($pdf, $h);

        $fill = false;
        foreach ($lista_materias as $m) {
            dibujarFilaMateria($pdf, $m, $h, $fill);
            $fill = !$fill;
        }
        $pdf->Ln(4);
    }
}

if (!$hay_registros) {
    $pdf->SetFillColor(255, 240, 240);
    $pdf->SetTextColor(180, 0, 0);
    $pdf->SetFont('Helvetica', 'I', 9);
    $mensaje = $modo_todas
        ? 'El estudiante no cuenta con materias registradas en ninguna gestión.'
        : 'El estudiante no cuenta con materias registradas en la gestión ' . $gestion_filtro . '.';
    $pdf->Cell(192, 8, textoPDF($mensaje), 1, 1, 'C', true);
    $pdf->Ln(4);
}

// =====================================================
// TIPO DE ESTUDIANTE
// =====================================================
$q_tipo_est = mysqli_query($conn, "SELECT tipo FROM inscripcion 
                                    WHERE ci_est = '$ci' 
                                    ORDER BY FIELD(tipo, 'BTH','Beca','Regular'), id DESC 
                                    LIMIT 1");
$row_tipo_est = $q_tipo_est ? mysqli_fetch_assoc($q_tipo_est) : null;
$tipo_estudiante = strtoupper($row_tipo_est['tipo'] ?? 'REGULAR');

// =====================================================
// DETECTAR CASO ESPECIAL BTH
// =====================================================
$es_bth_convalidado = (
    $tipo_estudiante === 'BTH'
    && $total_materias > 0
    && $convalidadas === $total_materias
);

$especialidades = [
    'SIS-INF' => 'SISTEMAS INFORMÁTICOS',
    'CON-ADM' => 'CONTADURÍA GENERAL',
    'ELE-IND' => 'ELECTRICIDAD INDUSTRIAL',
];
$id_carrera_est = $est['id_carrera'] ?? 'SIS-INF';
$especialidad = $especialidades[$id_carrera_est] ?? 'SISTEMAS INFORMÁTICOS';

// =====================================================
// EVALUACIÓN FINAL
// =====================================================
if ($es_bth_convalidado) {
    $estado_final = 'CONVALIDADO_BTH';
    $global = "Materias convalidadas en el marco de la Resolución Ministerial N° 0166/2025 (Reglamento de Transitabilidad), correspondientes al Título de Técnico Medio en la Especialidad de $especialidad, emitido por el Ministerio de Educación.";
    $bg_glob = [0, 80, 150];
} else {
    if ($modo_todas && !empty($datos_por_gestion)) {
        $ultima_gestion = max(array_keys($datos_por_gestion));
    } else {
        $ultima_gestion = $gestion_filtro;
    }

    $eval = function_exists('evaluarCondicionEstudianteV2')
        ? evaluarCondicionEstudianteV2($conn, $ci, $ultima_gestion)
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
}

// =====================================================
// CAJA DE RESUMEN FINAL
// =====================================================
if ($pdf->GetY() + 45 > 250) $pdf->AddPage();

$altura_caja = $es_bth_convalidado ? 36 : 24;
$y = $pdf->GetY() + 2;

$pdf->SetFillColor(255, 240, 240);
$pdf->SetDrawColor(180, 0, 0);
$pdf->SetLineWidth(0.4);
$pdf->Rect(12, $y, 192, $altura_caja, 'DF');

$titulo_resumen = $modo_todas
    ? 'RESUMEN ACADEMICO FINAL (TODAS LAS GESTIONES)'
    : 'RESUMEN ACADEMICO FINAL (GESTIÓN ' . $gestion_filtro . ')';

$pdf->SetXY(12, $y + 3);
$pdf->SetTextColor(30);
$pdf->SetFont('Helvetica', 'B', 8.5);
$pdf->Cell(192, 5, textoPDF($titulo_resumen), 0, 2, 'C');

$pdf->SetFont('Helvetica', '', 8.5);
$resumen_txt = "Total Materias: $total_materias | Aprobadas: $aprobadas | Reprobadas: $reprobadas";
if ($convalidadas > 0) {
    $resumen_txt .= " | Convalidadas: $convalidadas";
}
$pdf->Cell(192, 5, textoPDF($resumen_txt), 0, 2, 'C');

if ($es_bth_convalidado) {
    $pdf->SetXY(15, $y + 15);
    $pdf->SetFillColor($bg_glob[0], $bg_glob[1], $bg_glob[2]);
    $pdf->SetTextColor(255);
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->MultiCell(186, 5, textoPDF($global), 1, 'C', true);
} else {
    $pdf->SetXY(15, $y + 15);
    $pdf->SetFillColor($bg_glob[0], $bg_glob[1], $bg_glob[2]);
    $pdf->SetTextColor(255);
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->Cell(186, 7, textoPDF($global), 1, 0, 'C', true);
}

if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output('I', 'Reporte_Estudiante_' . $ci . '_' . date('d-m-Y') . '.pdf');
exit;