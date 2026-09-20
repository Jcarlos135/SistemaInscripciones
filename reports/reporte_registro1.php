<?php
session_start();
require_once '../config/db.php';
require_once '../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

// Verificar acceso
 $ci = isset($_GET['ci']) ? trim($_GET['ci']) : '';

if (empty($ci)) {
    die('CI no especificado');
}

// Solo permitir si es el propio estudiante, admin o secretaria
 $permitido = false;
if (isset($_SESSION['rol_id'])) {
    if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2) $permitido = true;
    if ($_SESSION['rol_id'] == 3 && $_SESSION['estudiante_ci'] == $ci) $permitido = true;
}
if (isset($_SESSION['abrir_pdf_ci']) && $_SESSION['abrir_pdf_ci'] == $ci) $permitido = true;

if (!$permitido) {
    die('Acceso no autorizado');
}

// Obtener datos completos
 $datos = obtener_datos_completos_registro($conn, $ci);
 $est = $datos['estudiante'];
 $materias = $datos['materias'];
 $docs = $datos['documentos'];

if (!$est) die('Estudiante no encontrado');

require_once '../lib/fpdf/fpdf.php';

class PDFRegistro extends FPDF {
    function Header() {
        // Logo o título
        $this->SetFont('Helvetica', 'B', 16);
        $this->SetTextColor(27, 94, 32);
        $this->Cell(0, 10, 'SISTEMAS INFORMATICOS', 0, 1, 'C');
        $this->SetFont('Helvetica', '', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, 'Ficha de Registro e Inscripcion', 0, 1, 'C');
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Helvetica', 'B', 8);
        $this->SetTextColor(200, 0, 0);
        
        // NOTA DE ACLARACIÓN
        $this->MultiCell(0, 4, 
            'Nota de aclaracion: El registro de datos de usuario y contraseña es de responsabilidad del estudiante.', 
            0, 'C');
        
        $this->Ln(3);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function Seccion($titulo) {
        $this->SetFont('Helvetica', 'B', 11);
        $this->SetFillColor(27, 94, 32);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 8, '  ' . $titulo, 0, 1, 'L', true);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(2);
    }
    
    function Dato($label, $valor, $ancho_label=60, $ancho_valor=130) {
        $this->SetFont('Helvetica', 'B', 9);
        $this->Cell($ancho_label, 6, $label, 0, 0);
        $this->SetFont('Helvetica', '', 9);
        $this->Cell($ancho_valor, 6, $valor, 0, 1);
    }
}

 $pdf = new PDFRegistro();
 $pdf->AliasNbPages();
 $pdf->AddPage();

// ===================== DATOS DEL ESTUDIANTE =====================
 $pdf->Seccion('DATOS DEL ESTUDIANTE');
 $pdf->Dato('Carnet de Identidad:', $est['ci']);
 $pdf->Dato('Nombres:', $est['nombre']);
 $pdf->Dato('Apellido Paterno:', $est['ap_pat']);
 $pdf->Dato('Apellido Materno:', $est['ap_mat'] ?? '-');
 $pdf->Dato('Genero:', $est['genero'] == 'M' ? 'Masculino' : ($est['genero'] == 'F' ? 'Femenino' : 'Otro'));
 $pdf->Dato('Edad:', $est['edad']);
 $pdf->Dato('Celular:', $est['cel']);
 $pdf->Dato('Carrera:', $est['carrera_nombre']);

// ===================== DATOS DE INSCRIPCION =====================
// Obtener tipo y turno de la inscripción
 $query_tipo = "SELECT tipo, turno, grupo, fecha FROM inscripcion WHERE ci_est = '$ci' AND activo = 1 LIMIT 1";
 $res_tipo = mysqli_query($conn, $query_tipo);
 $ins_data = mysqli_fetch_assoc($res_tipo);

 $pdf->Seccion('DATOS DE INSCRIPCION');
 $pdf->Dato('Tipo de Inscripcion:', $ins_data['tipo'] ?? 'N/A');
 $pdf->Dato('Turno:', $ins_data['turno'] ?? 'N/A');
 $pdf->Dato('Paralelo/Grupo:', $ins_data['grupo'] ?? 'N/A');
 $pdf->Dato('Gestion:', date('Y'));
 $pdf->Dato('Fecha de Inscripcion:', date('d/m/Y', strtotime($ins_data['fecha'] ?? 'now')));

// Nivel
 $nivel_map = [100 => '1er Ano (Nivel 100)', 200 => '2do Ano (Nivel 200)', 300 => '3er Ano (Nivel 300)'];
 $tipo_nivel = ($ins_data['tipo'] == 'Regular' || $ins_data['tipo'] == 'Beca') ? 100 : 200;
 $pdf->Dato('Nivel:', $nivel_map[$tipo_nivel] ?? 'N/A');

// ===================== DATOS DE USUARIO =====================
 $pdf->Seccion('DATOS DE USUARIO');
 $pdf->Dato('Usuario:', $est['usuario']);
 $pdf->Dato('Contraseña:', '******** (ver nota al pie)');
 $pdf->SetFont('Helvetica', 'I', 8);
 $pdf->SetTextColor(200, 0, 0);
 $pdf->Cell(0, 5, '(La contraseña por defecto es su numero de CI. Puede cambiarla después.)', 0, 1);
 $pdf->SetTextColor(0, 0, 0);

// ===================== MATERIAS INSCRITAS =====================
 $pdf->Seccion('MATERIAS INSCRITAS');

// Header de tabla
 $pdf->SetFont('Helvetica', 'B', 8);
 $pdf->SetFillColor(40, 167, 69);
 $pdf->SetTextColor(255, 255, 255);
 $pdf->Cell(20, 6, 'Nivel', 1, 0, 'C', true);
 $pdf->Cell(30, 6, 'Codigo', 1, 0, 'C', true);
 $pdf->Cell(80, 6, 'Materia', 1, 0, 'C', true);
 $pdf->Cell(30, 6, 'Tipo', 1, 0, 'C', true);
 $pdf->Cell(30, 6, 'Turno', 1, 1, 'C', true);
 $pdf->SetTextColor(0, 0, 0);

 $nivel_actual = null;
while ($m = mysqli_fetch_assoc($materias)) {
    // Separador de nivel
    if ($nivel_actual !== $m['asig_nivel']) {
        $nivel_actual = $m['asig_nivel'];
        $nombre_nivel = $nivel_map[$nivel_actual] ?? 'Nivel ' . $nivel_actual;
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetFillColor(200, 230, 200);
        $pdf->Cell(190, 6, $nombre_nivel, 1, 1, 'C', true);
    }
    
    $pdf->SetFont('Helvetica', '', 8);
    $pdf->Cell(20, 5, $m['asig_nivel'], 1, 0, 'C');
    $pdf->Cell(30, 5, $m['asig_codigo'], 1, 0, 'C');
    $pdf->Cell(80, 5, $m['asig_nombre'], 1, 0);
    $pdf->Cell(30, 5, $m['tipo'], 1, 0, 'C');
    $pdf->Cell(30, 5, $m['turno'], 1, 1, 'C');
}

// ===================== DOCUMENTOS =====================
 $pdf->Ln(5);
 $pdf->Seccion('DOCUMENTOS PRESENTADOS');

 $pdf->SetFont('Helvetica', 'B', 8);
 $pdf->SetFillColor(13, 110, 253);
 $pdf->SetTextColor(255, 255, 255);
 $pdf->Cell(60, 6, 'Tipo de Documento', 1, 0, 'C', true);
 $pdf->Cell(70, 6, 'Archivo', 1, 0, 'C', true);
 $pdf->Cell(60, 6, 'Fecha de Subida', 1, 1, 'C', true);
 $pdf->SetTextColor(0, 0, 0);

 $tipo_doc_map = [
    'CI' => 'Carnet de Identidad',
    'TITULO_BACHILLER' => 'Titulo de Bachiller',
    'DEPOSITO_BANCARIO' => 'Deposito Bancario'
];

if (mysqli_num_rows($docs) > 0) {
    while ($d = mysqli_fetch_assoc($docs)) {
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(60, 5, $tipo_doc_map[$d['tipo_documento']] ?? $d['tipo_documento'], 1, 0);
        $pdf->Cell(70, 5, $d['nombre_archivo'], 1, 0);
        $pdf->Cell(60, 5, date('d/m/Y H:i', strtotime($d['fecha_subida'])), 1, 1, 'C');
    }
} else {
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->Cell(190, 8, 'Documentos pendientes de verificacion', 1, 1, 'C');
}

 $pdf->Output('I', 'Ficha_Registro_' . $ci . '.pdf');
?>