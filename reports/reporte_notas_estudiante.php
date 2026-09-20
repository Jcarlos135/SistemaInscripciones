<?php

if (session_status() === PHP_SESSION_NONE) session_start();

/* 1) Cargar FPDF */
 $fpdf_ok = false;
foreach ([__DIR__ . '/../lib/fpdf.php', 'lib/fpdf.php'] as $rutaFPDF) {
    if (file_exists($rutaFPDF)) { require $rutaFPDF; $fpdf_ok = true; break; }
}
if (!$fpdf_ok) die('ERROR: no se encontr&oacute; lib/fpdf.php');

/* 2) Conexión (si viene de index.php, $conn ya existe) */
if (empty($conn)) {
    foreach ([__DIR__ . '/../funciones.php', __DIR__ . '/../conexion.php', __DIR__ . '/../db.php'] as $f) {
        if (file_exists($f)) { include $f; break; }
    }
}
if (empty($conn)) die('ERROR: sin conexi&oacute;n a la base de datos');

/* 3) Validar sesión */
if (empty($_SESSION['estudiante_ci'])) die('Sesi&oacute;n no v&aacute;lida.');
 $ci = mysqli_real_escape_string($conn, $_SESSION['estudiante_ci']);

/* ---------- Helpers ---------- */
function limpiar($t) { // UTF-8 -> cp1252 (necesario en FPDF)
    $t = $t ?? '';
    $c = @iconv('UTF-8', 'windows-1252//TRANSLIT', $t);
    return ($c === false) ? utf8_decode($t) : $c;
}
function nota($v) { // 69.00 -> 69 | null -> '-'
    if ($v === null || $v === '') return '-';
    return is_numeric($v) ? rtrim(rtrim(number_format((float)$v, 2, '.', ''), '0'), '.') : limpiar($v);
}
function estiloEstado($estado) {
    $e = strtoupper(trim((string)$estado));
    if ($e === 'APROBADO')            return [[25,135,84],  [255,255,255], 'APROBADO'];
    if ($e === 'REPROBADO')           return [[220,53,69],  [255,255,255], 'REPROBADO'];
    if (strpos($e, 'TURNO') !== false) return [[253,126,20], [255,255,255], '2DO TURNO'];
    return [[13,202,240], [0,0,0], 'EN PROCESO'];
}
function textoAjustado($pdf, $txt, $ancho) {
    if ($pdf->GetStringWidth($txt) <= $ancho - 2) return $txt;
    while ($pdf->GetStringWidth($txt) > $ancho - 2 && strlen($txt) > 4) $txt = substr($txt, 0, -1);
    return rtrim($txt) . '.';
}

/* ---------- Clase PDF ---------- */
class PDF extends FPDF {
    public $instituto = 'INSTITUTO TECNOLOGICO SUPERIOR'; // <-- cambia por el nombre real
    public $titulo    = 'REPORTE DE CALIFICACIONES BIMESTRALES';

    function Header() {
        $this->SetFillColor(2, 40, 24);   // verde oscuro (#022818)
        $this->Rect(0, 0, 297, 20, 'F');
        $this->SetFillColor(5, 157, 59);  // línea acento (#059d3b)
        $this->Rect(0, 20, 297, 2, 'F');
        $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 14);
        $this->SetXY(12, 3);
        $this->Cell(200, 8, limpiar($this->instituto), 0, 2, 'L');
        $this->SetFont('Helvetica', '', 10);
        $this->Cell(200, 6, limpiar($this->titulo), 0, 0, 'L');
        $this->SetFont('Helvetica', '', 9);
        $this->SetXY(-62, 6);
        $this->Cell(50, 6, 'Emisi&oacute;n: ' . date('d/m/Y'), 0, 2, 'R');
        $this->Cell(50, 6, 'CI Estudiante', 0, 0, 'R');
        $this->SetY(26);
    }
    function Footer() {
        $this->SetY(-14);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(110);
        $this->Cell(0, 8, 'Sistema de Gesti&oacute;n Acad&eacute;mica  -  P&aacute;gina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
    /* Cabecera de tabla (2 filas, con celdas "combinadas") */
    function cabeceraTabla() {
        $h1 = 7; $h2 = 6; $x0 = $this->lMargin; $y = $this->GetY();
        $this->SetDrawColor(108, 117, 125);

        // Fila 1: columnas combinadas vacías + grupos bimestrales
        $this->SetFillColor(33, 37, 41); $this->SetTextColor(255);
        $this->SetFont('Helvetica', 'B', 8);
        $this->SetX($x0);
        $this->Cell(18, $h1, '', 'LTR', 0, 'C', true);
        $this->Cell(66, $h1, '', 'LTR', 0, 'C', true);
        $this->SetFillColor(25, 135, 84);
        foreach (['1er BIMESTRE','2do BIMESTRE','3er BIMESTRE','4to BIMESTRE'] as $g)
            $this->Cell(39, $h1, $g, 1, 0, 'C', true);
        $this->SetFillColor(33, 37, 41);
        $this->Cell(13, $h1, '', 'LTR', 0, 'C', true);
        $this->Cell(24, $h1, '', 'LTR', 0, 'C', true);
        $this->Ln();

        // Fila 2: continuación de combinadas + sub-encabezados
        $this->SetFillColor(52, 58, 64);
        $this->SetFont('Helvetica', 'B', 6.5);
        $this->SetX($x0);
        $this->Cell(18, $h2, '', 'LRB', 0, 'C', true);
        $this->Cell(66, $h2, '', 'LRB', 0, 'C', true);
        for ($b = 1; $b <= 4; $b++) {
            $this->Cell(13, $h2, 'TEO 30%', 1, 0, 'C', true);
            $this->Cell(13, $h2, 'PRA 70%', 1, 0, 'C', true);
            $this->Cell(13, $h2, 'NOTA',   1, 0, 'C', true);
        }
        $this->Cell(13, $h2, '', 'LRB', 0, 'C', true);
        $this->Cell(24, $h2, '', 'LRB', 0, 'C', true);
        $this->Ln();

        // Textos de las celdas combinadas (centrados verticalmente)
        $this->SetXY($x0, $y);
        $this->SetFont('Helvetica', 'B', 7.5);
        $this->Cell(18, $h1 + $h2, 'CODIGO',    '', 0, 'C');
        $this->Cell(66, $h1 + $h2, 'MATERIA',   '', 0, 'C');
        $this->SetX($x0 + 18 + 66 + 156);
        $this->Cell(13, $h1 + $h2, 'NOTA FINAL','', 0, 'C');
        $this->Cell(24, $h1 + $h2, 'ESTADO',    '', 0, 'C');
        $this->SetXY($x0, $y + $h1 + $h2);
    }
}

/* ---------- 4) Datos del estudiante ---------- */
 $resEst = mysqli_query($conn, "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.img,
                                      c.nombre AS carrera, c.resolucion
                               FROM estudiante e
                               LEFT JOIN carrera c ON c.id = e.id_carrera
                               WHERE e.ci = '$ci' LIMIT 1");
 $est = mysqli_fetch_assoc($resEst);
if (!$est) die('Estudiante no encontrado.');

 $nombreCompleto = trim(($est['nombre'] ?? '') . ' ' . ($est['ap_pat'] ?? '') . ' ' . ($est['ap_mat'] ?? ''));

/* ---------- 5) Notas (misma consulta corregida del listado) ---------- */
 $sql = "SELECT a.codigo AS asig_codigo, a.nombre AS asig_nombre,
               h.nota_teorico1, h.nota_pract1, h.nota_primerbim,
               h.nota_teorico2, h.nota_pract2, h.nota_segundobim,
               h.nota_teorico3, h.nota_pract3, h.nota_tercerbim,
               h.nota_teorico4, h.nota_pract4, h.nota_cuartobim,
               h.nota_bim AS nota_final, h.literal, h.estado, h.gestion
        FROM inscripcion i
        INNER JOIN asignatura a ON a.codigo = i.cod_asig
        LEFT JOIN historial h
               ON h.id = (SELECT MAX(h2.id) FROM historial h2
                          WHERE h2.ci_est = i.ci_est AND h2.cod_asig = i.cod_asig)
        WHERE i.ci_est = '$ci' AND i.activo = 1
        ORDER BY a.codigo";
 $res = mysqli_query($conn, $sql);

 $filas = []; $total = 0; $aprob = 0; $reprob = 0; $suma = 0; $conNota = 0; $gestion = '';
while ($r = mysqli_fetch_assoc($res)) {
    $filas[] = $r; $total++;
    if (!empty($r['gestion']) $gestion = $r['gestion'];
    $e = strtoupper(trim((string)($r['estado'] ?? '')));
    if ($e === 'APROBADO') $aprob++;
    elseif ($e === 'REPROBADO') $reprob++;
    if ($r['nota_final'] !== null && $r['nota_final'] !== '') {
        $suma += (float)$r['nota_final']; $conNota++;
    }
}
 $promedio = $conNota > 0 ? $suma / $conNota : null;

/* ---------- 6) Construir PDF ---------- */
 $pdf = new PDF('L', 'mm', 'A4');           // horizontal por las 16 columnas
 $pdf->AliasNbPages();
 $pdf->SetAutoPageBreak(true, 14);
 $pdf->SetMargins(10, 0, 10);
 $pdf->SetTitle('Reporte de Calificaciones - CI ' . $ci);
 $pdf->AddPage();

/* --- Cuadro de datos del estudiante --- */
 $pdf->SetFillColor(240, 248, 243);
 $pdf->SetDrawColor(25, 135, 84);
 $pdf->SetLineWidth(0.4);
 $pdf->Rect(10, 26, 277, 22, 'DF');

/* Foto (solo jpg/png; FPDF no soporta webp) */
 $fotoPath = false;
if (!empty($est['img'])) {
    foreach ([__DIR__ . '/../' . $est['img'], $est['img']] as $p) {
        $ext = strtolower(pathinfo($p, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png']) && is_file($p)) { $fotoPath = $p; break; }
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
 $pdf->Cell(245, 6, limpiar($nombreCompleto), 0, 2);
 $pdf->SetFont('Helvetica', '', 9);
 $pdf->Cell(245, 5, 'CI: ' . $est['ci'] . '    |    Carrera: ' . limpiar($est['carrera'] ?? '-') . '    |    Resoluci&oacute;n: ' . limpiar($est['resolucion'] ?? '-'), 0, 2);
 $pdf->Cell(245, 5, 'Materias inscritas: ' . $total . '    |    Gesti&oacute;n: ' . ($gestion ?: '-') . '    |    Nota m&iacute;nima de aprobaci&oacute;n: 51', 0, 0);

/* --- Tabla --- */
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
    $pdf->Cell(277, 10, 'No se encontraron inscripciones para este estudiante.', 1, 1, 'C');
}

foreach ($filas as $idx => $r) {
    if ($pdf->GetY() + $h > 180) {          // salto de página + repetir cabeceras
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', 'I', 8);
        $pdf->SetTextColor(100);
        $pdf->Cell(277, 4, limpiar('Continuación - ' . $nombreCompleto) . ' (CI: ' . $est['ci'] . ')', 0, 1);
        $pdf->cabeceraTabla();
    }
    $fondo = ($idx % 2 === 1) ? [243, 247, 245] : [255, 255, 255];
    $pdf->SetDrawColor(108, 117, 125);
    $pdf->SetLineWidth(0.2);
    $pdf->SetTextColor(30);

    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
    $pdf->Cell(18, $h, limpiar($r['asig_codigo']), 1, 0, 'C', true);

    $pdf->SetFont('Helvetica', '', 7);
    $pdf->Cell(66, $h, textoAjustado($pdf, limpiar($r['asig_nombre']), 66), 1, 0, 'L', true);

    $pdf->SetFont('Helvetica', '', 7.5);
    foreach ($grupos as $g) {
        $pdf->Cell(13, $h, nota($r[$g[0]]), 1, 0, 'C', true);
        $pdf->Cell(13, $h, nota($r[$g[1]]), 1, 0, 'C', true);
        $pdf->SetFillColor(219, 240, 228);  // tinte verde para la nota del bimestre
        $pdf->Cell(13, $h, nota($r[$g[2]]), 1, 0, 'C', true);
        $pdf->SetFillColor($fondo[0], $fondo[1], $fondo[2]);
    }

    // Nota final (roja si es < 51)
    $nf = $r['nota_final'];
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->SetTextColor(($nf !== null && $nf !== '' && (float)$nf < 51) ? 220 : 19);
    $pdf->Cell(13, $h, nota($nf), 1, 0, 'C', true);

    // Estado con color
    list($bg, $fg, $lbl) = estiloEstado($r['estado'] ?? '');
    $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
    $pdf->SetTextColor($fg[0], $fg[1], $fg[2]);
    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->Cell(24, $h, limpiar($lbl), 1, 0, 'C', true);
    $pdf->Ln();
}

/* --- Resumen final --- */
if ($pdf->GetY() + 26 > 190) $pdf->AddPage();
 $y = $pdf->GetY() + 4;
 $pdf->SetFillColor(240, 248, 243);
 $pdf->SetDrawColor(25, 135, 84);
 $pdf->SetLineWidth(0.4);
 $pdf->Rect(10, $y, 277, 20, 'DF');

if ($reprob > 2)                 $global = 'REPROBADO';
elseif ($reprob > 0)             $global = 'SEGUNDO TURNO';
elseif ($total > 0 && $aprob === $total) $global = 'APROBADO';
else                             $global = 'EN PROCESO';

 $pdf->SetXY(14, $y + 3);
 $pdf->SetTextColor(30);
 $pdf->SetFont('Helvetica', 'B', 9);
 $pdf->Cell(150, 6, 'RESUMEN ACAD&Eacute;MICO', 0, 2);
 $pdf->SetFont('Helvetica', '', 9);
 $pdf->Cell(150, 6, "Materias: $total    Aprobadas: $aprob    Reprobadas: $reprob    Promedio: " . nota($promedio), 0, 0);

list($bg, $fg) = estiloEstado($global);
 $pdf->SetXY(190, $y + 5);
 $pdf->SetFillColor($bg[0], $bg[1], $bg[2]);
 $pdf->SetTextColor($fg[0], $fg[1], $fg[2]);
 $pdf->SetFont('Helvetica', 'B', 11);
 $pdf->Cell(90, 10, 'ESTADO FINAL: ' . limpiar($global), 1, 0, 'C', true);

/* ---------- 7) Salida ---------- */
 $pdf->Output('I', 'Reporte_Notas_' . $est['ci'] . '_' . date('d-m-Y') . '.pdf');