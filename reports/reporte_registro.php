<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

// ===================== VERIFICAR ACCESO =====================
$ci = isset($_GET['ci']) ? trim($_GET['ci']) : '';
if (empty($ci)) die('CI no especificado');

$permitido = false;
if (isset($_SESSION['rol_id'])) {
    if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2) $permitido = true;
    if ($_SESSION['rol_id'] == 3 && isset($_SESSION['estudiante_ci']) && $_SESSION['estudiante_ci'] == $ci) $permitido = true;
}
if (isset($_SESSION['abrir_pdf_ci']) && $_SESSION['abrir_pdf_ci'] == $ci) $permitido = true;
if (!$permitido) die('Acceso no autorizado');

$ci_esc = mysqli_real_escape_string($conn, $ci);

// ===================== CONSULTAS =====================
$query_est = "SELECT e.*, c.nombre AS carrera_nombre, u.usuario
              FROM estudiante e
              LEFT JOIN carrera c ON e.id_carrera = c.id
              LEFT JOIN usuario u ON e.id_usuario = u.id
              WHERE e.ci = '$ci_esc' AND e.activo = 1";
$est = mysqli_fetch_assoc(mysqli_query($conn, $query_est));
if (!$est) die('Estudiante no encontrado');

$query_ins = "SELECT tipo, turno, grupo, fecha FROM inscripcion
              WHERE ci_est = '$ci_esc' AND activo = 1
              ORDER BY fecha DESC, id DESC LIMIT 1";
$ins_data = mysqli_fetch_assoc(mysqli_query($conn, $query_ins));

$query_mat = "SELECT a.codigo AS asig_codigo, a.nombre AS asig_nombre, a.nivel AS asig_nivel,
                     i.tipo, i.turno, i.grupo
              FROM inscripcion i
              JOIN asignatura a ON i.cod_asig = a.codigo
              WHERE i.ci_est = '$ci_esc' AND i.activo = 1
              ORDER BY a.nivel, a.codigo";
$materias_res = mysqli_query($conn, $query_mat);

$query_docs = "SELECT tipo_documento, nombre_archivo, fecha_subida
               FROM documento
               WHERE ci_est = '$ci_esc' AND activo = 1
               ORDER BY tipo_documento";
$docs_res = mysqli_query($conn, $query_docs);

// Guardar materias en array (para resumen de niveles y para la tabla)
$materias = [];
if ($materias_res) {
    while ($m = mysqli_fetch_assoc($materias_res)) $materias[] = $m;
}

// ===================== GENERAR CÓDIGO ÚNICO =====================
function generarCodigoUnico($estudiante, $conn) {
    $ci       = $estudiante['ci'];
    $nombre   = trim($estudiante['nombre']);
    $ap_pat   = trim($estudiante['ap_pat']);
    $ap_mat   = trim($estudiante['ap_mat'] ?? '');

    $ini_ap_pat = !empty($ap_pat) ? strtoupper(substr($ap_pat, 0, 1)) : 'X';
    $ini_ap_mat = !empty($ap_mat) ? strtoupper(substr($ap_mat, 0, 1)) : '';
    $ini_nombre = !empty($nombre) ? strtoupper(substr($nombre, 0, 1)) : 'X';

    $anio_inscripcion = date('Y');
    $ci_esc = mysqli_real_escape_string($conn, $ci);
    $res_anio = mysqli_query($conn, "SELECT YEAR(fecha) AS anio FROM inscripcion WHERE ci_est = '$ci_esc' AND activo = 1 LIMIT 1");
    if ($res_anio && mysqli_num_rows($res_anio) > 0) {
        $row = mysqli_fetch_assoc($res_anio);
        $anio_inscripcion = $row['anio'];
    }
    return $ci . '-' . $ini_ap_pat . $ini_ap_mat . $ini_nombre . '-' . $anio_inscripcion;
}
$codigo_unico = generarCodigoUnico($est, $conn);

// ===================== CLASE PDF =====================
class PDFRegistro extends FPDF {
    protected $foto_path;

    public function __construct($foto_path = null) {
        parent::__construct();
        $this->foto_path = $foto_path;
    }

    public function Header() {
        // ---------- Título (lado izquierdo, no pasa por debajo de la foto) ----------
        $this->SetXY(10, 12);
        $this->SetFont('Helvetica', 'B', 16);
        $this->SetTextColor(27, 94, 32);
        $this->Cell(145, 8, utf8_decode('SISTEMAS INFORMÁTICOS'), 0, 1, 'C');
        $this->SetFont('Helvetica', '', 10);
        $this->SetTextColor(110, 110, 110);
        $this->Cell(145, 5, utf8_decode('Ficha de Registro e Inscripción'), 0, 1, 'C');

        // ---------- Foto (posición fija a la derecha) ----------
        $fx = 160; $fy = 12; $fw = 40; $fh = 40;

        if (!empty($this->foto_path) && file_exists($this->foto_path)) {
            $extension = strtolower(pathinfo($this->foto_path, PATHINFO_EXTENSION));
            $ruta_img = $this->foto_path;

            if ($extension === 'webp' && function_exists('imagecreatefromwebp')) {
                $origen = @imagecreatefromwebp($this->foto_path);
                if ($origen !== false) {
                    $ruta_jpg_temp = __DIR__ . '/temp_' . uniqid() . '.jpg';
                    $ancho = imagesx($origen);
                    $alto  = imagesy($origen);
                    $jpg = imagecreatetruecolor($ancho, $alto);
                    $blanco = imagecolorallocate($jpg, 255, 255, 255);
                    imagefill($jpg, 0, 0, $blanco);
                    imagecopy($jpg, $origen, 0, 0, 0, 0, $ancho, $alto);
                    imagejpeg($jpg, $ruta_jpg_temp, 90);
                    imagedestroy($origen);
                    imagedestroy($jpg);
                    $ruta_img = $ruta_jpg_temp;
                }
            }

            $this->Image($ruta_img, $fx, $fy, $fw, $fh);
            $this->SetDrawColor(160, 160, 160);
            $this->Rect($fx, $fy, $fw, $fh);

            if (isset($ruta_jpg_temp) && file_exists($ruta_jpg_temp)) @unlink($ruta_jpg_temp);
        } else {
            $this->SetFillColor(225, 225, 225);
            $this->SetDrawColor(160, 160, 160);
            $this->Rect($fx, $fy, $fw, $fh, 'FD');
            $this->SetXY($fx, $fy + 18);
            $this->SetFont('Helvetica', 'I', 8);
            $this->SetTextColor(140, 140, 140);
            $this->Cell($fw, 5, utf8_decode('Sin Foto'), 0, 0, 'C');
        }

        // ---------- Línea separadora (debajo de título Y foto) ----------
        $this->SetDrawColor(27, 94, 32);
        $this->SetLineWidth(0.5);
        $this->Line(10, 57, 200, 57);

        // El contenido empieza DEBAJO de la foto: ya no habrá traslapes
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(10, 61);
    }

    public function Footer() {
        $this->SetY(-28);
        $this->SetFont('Helvetica', 'B', 8);
        $this->SetTextColor(200, 0, 0);
        $this->MultiCell(0, 4,
            utf8_decode('Nota de aclaración: El registro de datos de usuario y contraseña es de responsabilidad del estudiante.'),
            0, 'C');
        $this->Ln(2);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function Seccion($titulo) {
        $this->SetFont('Helvetica', 'B', 11);
        $this->SetFillColor(27, 94, 32);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 8, utf8_decode('  ' . $titulo), 0, 1, 'L', true);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(2);
    }

    public function Dato($label, $valor) {
        $this->SetFont('Helvetica', 'B', 9);
        $this->Cell(60, 6, utf8_decode($label), 0, 0);
        $this->SetFont('Helvetica', '', 9);
        $this->Cell(130, 6, utf8_decode($valor), 0, 1);
    }
}

// ===== RUTA DE LA FOTO =====
$foto_path = null;
if (!empty($est['img'])) {
    $ruta_foto = __DIR__ . '/../' . ltrim($est['img'], '/');
    if (file_exists($ruta_foto)) $foto_path = $ruta_foto;
}

// ===== CREAR PDF =====
$pdf = new PDFRegistro($foto_path);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 35);   // margen inferior para que no choque con el pie
$pdf->AddPage();

// ===== CÓDIGO ÚNICO (recuadro destacado, ya sin traslapar la foto) =====
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->SetTextColor(27, 94, 32);
$pdf->SetFillColor(232, 245, 233);
$pdf->SetDrawColor(27, 94, 32);
$pdf->Cell(190, 9, utf8_decode('CÓDIGO ÚNICO: ') . $codigo_unico, 1, 1, 'R', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(4);

// ===== DATOS DEL ESTUDIANTE =====
$pdf->Seccion('DATOS DEL ESTUDIANTE');
$pdf->Dato('Carnet de Identidad:', $est['ci']);
$pdf->Dato('Nombres:', $est['nombre']);
$pdf->Dato('Apellido Paterno:', $est['ap_pat']);
$pdf->Dato('Apellido Materno:', !empty($est['ap_mat']) ? $est['ap_mat'] : '-');
$pdf->Dato('Género:', $est['genero'] == 'M' ? 'Masculino' : ($est['genero'] == 'F' ? 'Femenino' : 'Otro'));
$pdf->Dato('Edad:', $est['edad'] . ' años');
$pdf->Dato('Celular:', !empty($est['cel']) ? $est['cel'] : '-');
$pdf->Dato('Carrera:', $est['carrera_nombre']);

// ===== DATOS DE INSCRIPCIÓN =====
$nivel_map = [100 => '1er Año', 101 => '1er Año', 200 => '2do Año', 300 => '3er Año'];
$niveles = array_unique(array_column($materias, 'asig_nivel'));
sort($niveles);
$niveles_txt = implode(', ', array_map(fn($n) => $nivel_map[$n] ?? ('Nivel ' . $n), $niveles));

$pdf->Seccion('DATOS DE INSCRIPCIÓN');
$pdf->Dato('Tipo de Inscripción:', $ins_data['tipo'] ?? 'N/A');
$pdf->Dato('Turno:', $ins_data['turno'] ?? 'N/A');
$pdf->Dato('Paralelo/Grupo:', $ins_data['grupo'] ?? 'N/A');
$pdf->Dato('Nivel(es):', $niveles_txt !== '' ? $niveles_txt : 'N/A');
$pdf->Dato('Gestión:', date('Y'));
$pdf->Dato('Fecha de Inscripción:', isset($ins_data['fecha']) ? date('d/m/Y', strtotime($ins_data['fecha'])) : 'N/A');

// ===== DATOS DE USUARIO =====
$pdf->Seccion('DATOS DE USUARIO');
$pdf->Dato('Usuario:', $est['usuario'] ?? $est['ci']);
$pdf->Dato('Contraseña:', '******** (ver nota al pie)');
$pdf->SetFont('Helvetica', 'I', 8);
$pdf->SetTextColor(200, 0, 0);
$pdf->Cell(0, 5, utf8_decode('(La contraseña por defecto es su número de CI. Puede cambiarla después.)'), 0, 1);
$pdf->SetTextColor(0, 0, 0);

// ===== MATERIAS INSCRITAS =====
$pdf->Seccion('MATERIAS INSCRITAS');

$pdf->SetFont('Helvetica', 'B', 8);
$pdf->SetFillColor(40, 167, 69);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(20, 6, utf8_decode('Nivel'), 1, 0, 'C', true);
$pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C', true);
$pdf->Cell(80, 6, utf8_decode('Materia'), 1, 0, 'C', true);
$pdf->Cell(30, 6, utf8_decode('Tipo'), 1, 0, 'C', true);
$pdf->Cell(30, 6, utf8_decode('Turno'), 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

$nivel_actual = null;
if (count($materias) > 0) {
    foreach ($materias as $m) {
        if ($nivel_actual !== $m['asig_nivel']) {
            $nivel_actual = $m['asig_nivel'];
            $pdf->SetFont('Helvetica', 'B', 9);
            $pdf->SetFillColor(200, 230, 200);
            $pdf->Cell(190, 6, utf8_decode($nivel_map[$nivel_actual] ?? ('Nivel ' . $nivel_actual)), 1, 1, 'C', true);
        }
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(20, 5, $m['asig_nivel'], 1, 0, 'C');
        $pdf->Cell(30, 5, $m['asig_codigo'], 1, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode($m['asig_nombre']), 1, 0);
        $pdf->Cell(30, 5, $m['tipo'], 1, 0, 'C');
        $pdf->Cell(30, 5, $m['turno'], 1, 1, 'C');
    }
} else {
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->Cell(190, 8, utf8_decode('Sin materias inscritas'), 1, 1, 'C');
}

// ===== DOCUMENTOS PRESENTADOS =====
$pdf->Ln(5);
$pdf->Seccion('DOCUMENTOS PRESENTADOS');

$pdf->SetFont('Helvetica', 'B', 9);
$pdf->SetFillColor(40, 167, 69);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(10, 7, 'N°', 1, 0, 'C', true);
$pdf->Cell(50, 7, utf8_decode('Tipo de Documento'), 1, 0, 'C', true);
$pdf->Cell(80, 7, utf8_decode('Archivo'), 1, 0, 'C', true);
$pdf->Cell(50, 7, utf8_decode('Fecha de Subida'), 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

$tipo_doc_map = [
    'CI' => 'Carnet de Identidad',
    'TITULO_BACHILLER' => 'Título de Bachiller',
    'DEPOSITO_BANCARIO' => 'Depósito Bancario'
];

$contador = 0;
if ($docs_res && mysqli_num_rows($docs_res) > 0) {
    while ($d = mysqli_fetch_assoc($docs_res)) {
        $contador++;
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(10, 6, $contador, 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode($tipo_doc_map[$d['tipo_documento']] ?? $d['tipo_documento']), 1, 0);
        $pdf->Cell(80, 6, utf8_decode($d['nombre_archivo']), 1, 0);
        $pdf->Cell(50, 6, date('d/m/Y H:i', strtotime($d['fecha_subida'])), 1, 1, 'C');
    }
} else {
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->Cell(190, 8, utf8_decode('Documentos pendientes de verificación'), 1, 1, 'C');
}

// ===== RESUMEN FINAL =====
$pdf->Ln(6);
$pdf->Seccion('RESUMEN DE INSCRIPCIÓN');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(60, 7, utf8_decode('Total de Documentos:'), 0, 0);
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(0, 7, $contador . utf8_decode(' documento(s) adjunto(s)'), 0, 1);

$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(60, 7, utf8_decode('Total de Materias:'), 0, 0);
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(0, 7, count($materias) . utf8_decode(' materia(s)'), 0, 1);

$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(60, 7, utf8_decode('Código Único:'), 0, 0);
$pdf->SetFont('Helvetica', '', 10);
$pdf->SetTextColor(27, 94, 32);
$pdf->Cell(0, 7, $codigo_unico, 0, 1);
$pdf->SetTextColor(0, 0, 0);

// ===== FIRMA =====
$pdf->Ln(10);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(0, 5, utf8_decode('Firma del Estudiante'), 0, 1, 'C');
$pdf->Cell(0, 10, '_________________________', 0, 1, 'C');
$pdf->Cell(0, 5, utf8_decode('Nombre: ' . $est['nombre'] . ' ' . $est['ap_pat'] . ' ' . ($est['ap_mat'] ?? '')), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Helvetica', '', 9);
$pdf->Cell(0, 5, utf8_decode('Fecha: ') . date('d/m/Y H:i:s'), 0, 1, 'C');

// ===== GENERAR PDF =====
$pdf->Output('I', 'Ficha_Registro_' . $codigo_unico . '.pdf');
exit;
?>