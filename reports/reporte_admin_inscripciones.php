<?php
// Capturar salidas accidentales para evitar errores de FPDF
ob_start();

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) die('Acceso denegado.');

date_default_timezone_set('America/La_Paz');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';


// ELIMINADA la función duplicada que causaba el error
// Ahora se hace la consulta directamente aquí


// PALETA DE COLOR AZUL
$AZUL_PRINCIPAL = [30, 90, 170];     // Azul fuerte (headers)
$AZUL_CLARO     = [227, 242, 253];   // Azul muy claro (resaltados)


// OBTENER ESTADÍSTICAS DE GÉNERO Y EDAD
$stats_genero = mysqli_query($conn, "
    SELECT 
        genero,
        COUNT(*) as total,
        AVG(edad) as edad_promedio,
        MIN(edad) as edad_minima,
        MAX(edad) as edad_maxima
    FROM estudiante 
    WHERE activo = 1
    GROUP BY genero
");

$stats_edad_general = mysqli_query($conn, "
    SELECT 
        AVG(edad) as edad_promedio,
        MIN(edad) as edad_minima,
        MAX(edad) as edad_maxima,
        COUNT(*) as total_estudiantes
    FROM estudiante 
    WHERE activo = 1
");

$edad_general = mysqli_fetch_assoc($stats_edad_general);


// CLASE PDF PERSONALIZADA (con color azul)
class PDF extends FPDF {
    public $azul_principal = [34, 139, 34];
    public $azul_claro     = [227, 242, 253];

    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor($this->azul_principal[0], $this->azul_principal[1], $this->azul_principal[2]);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode('REPORTE DE INSCRIPCIONES'), 1, 1, 'C', true);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(0, 6, utf8_decode('Fecha de emisión: ' . date('d/m/Y H:i:s')), 0, 1, 'C');
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function SeccionEstadisticas($titulo, $datos) {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor($this->azul_principal[0], $this->azul_principal[1], $this->azul_principal[2]);
        $this->SetTextColor(255);
        $this->Cell(0, 8, utf8_decode($titulo), 1, 1, 'L', true);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 9);
        
        foreach ($datos as $label => $valor) {
            $this->Cell(90, 6, utf8_decode($label), 1);
            $this->Cell(100, 6, utf8_decode($valor), 1, 1, 'C');
        }
        $this->Ln(5);
    }
}


// GENERACIÓN DEL PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


// SECCIÓN 1: ESTADÍSTICAS DE GÉNERO
$datos_genero = [];
$total_hombres = 0;
$total_mujeres = 0;

while ($row = mysqli_fetch_assoc($stats_genero)) {
    if ($row['genero'] == 'M') {
        $total_hombres = $row['total'];
        $datos_genero['Hombres'] = $row['total'] . ' estudiantes (Edad promedio: ' . number_format($row['edad_promedio'], 1) . ' años)';
    } elseif ($row['genero'] == 'F') {
        $total_mujeres = $row['total'];
        $datos_genero['Mujeres'] = $row['total'] . ' estudiantes (Edad promedio: ' . number_format($row['edad_promedio'], 1) . ' años)';
    }
}

$datos_genero['Total de Estudiantes Activos'] = ($total_hombres + $total_mujeres);
$datos_genero['Edad Promedio General'] = number_format($edad_general['edad_promedio'] ?? 50, 1) . ' años';
$datos_genero['Edad Mínima'] = ($edad_general['edad_minima'] ?? 0) . ' años';
$datos_genero['Edad Máxima'] = ($edad_general['edad_maxima'] ?? 0) . ' años';

$pdf->SeccionEstadisticas('ESTADÍSTICAS DEMOGRÁFICAS', $datos_genero);


// SECCIÓN 2: TABLA DE INSCRIPCIONES (encabezado azul)
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor($pdf->azul_principal[0], $pdf->azul_principal[1], $pdf->azul_principal[2]);
$pdf->SetTextColor(255);

$pdf->Cell(20, 8, 'CI', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Estudiante', 1, 0, 'C', true);
$pdf->Cell(12, 8, 'Edad', 1, 0, 'C', true);
$pdf->Cell(12, 8, utf8_decode('Gén.'), 1, 0, 'C', true);
$pdf->Cell(18, 8, utf8_decode('Cód.'), 1, 0, 'C', true);
$pdf->Cell(48, 8, 'Materia', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Turno', 1, 1, 'C', true);

$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 7);

// ✅ CONSULTA DIRECTA con JOINs (evita el problema N+1 y no depende de funciones externas)
$sql_inscripciones = "SELECT 
                        i.id,
                        i.ci_est,
                        i.cod_asig,
                        i.fecha,
                        i.turno,
                        e.nombre AS est_nombre,
                        e.ap_pat,
                        e.edad,
                        e.genero,
                        a.nombre AS asig_nombre
                      FROM inscripcion i
                      INNER JOIN estudiante e ON i.ci_est = e.ci
                      INNER JOIN asignatura a ON i.cod_asig = a.codigo
                      ORDER BY i.fecha DESC, i.id DESC";

$inscripciones = mysqli_query($conn, $sql_inscripciones);
$n = 0;
$fill = false; // Para filas alternadas

while ($i = mysqli_fetch_assoc($inscripciones)) {
    // Color alternado para mejor legibilidad
    if ($fill) {
        $pdf->SetFillColor(245, 249, 255); // Azul muy tenue
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }

    $edad   = $i['edad'] ?? '-';
    $genero = $i['genero'] ?? '-';

    $pdf->Cell(20, 6, $i['ci_est'] ?? '', 1, 0, 'C', true);
    $pdf->Cell(40, 6, utf8_decode(($i['est_nombre'] ?? '') . ' ' . ($i['ap_pat'] ?? '')), 1, 0, 'L', true);
    $pdf->Cell(12, 6, $edad, 1, 0, 'C', true);
    $pdf->Cell(12, 6, $genero, 1, 0, 'C', true);
    $pdf->Cell(18, 6, $i['cod_asig'] ?? '', 1, 0, 'C', true);
    $pdf->Cell(48, 6, utf8_decode($i['asig_nombre'] ?? ''), 1, 0, 'L', true);
    $pdf->Cell(20, 6, !empty($i['fecha']) ? date('d/m/Y', strtotime($i['fecha'])) : '-', 1, 0, 'C', true);
    $pdf->Cell(20, 6, utf8_decode($i['turno'] ?? ''), 1, 1, 'C', true);

    $fill = !$fill;
    $n++;
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetFillColor($pdf->azul_principal[0], $pdf->azul_principal[1], $pdf->azul_principal[2]);
$pdf->SetTextColor(255);
$pdf->Cell(0, 7, utf8_decode('Total de inscripciones registradas: ') . $n, 1, 1, 'C', true);
$pdf->SetTextColor(0);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(128);
$pdf->Cell(0, 6, utf8_decode('Documento generado automáticamente por el Sistema Académico.'), 0, 1, 'C');

// Limpiar cualquier salida antes de generar el PDF
if (ob_get_length()) ob_end_clean();

$pdf->Output('I', 'Reporte_Inscripciones_' . date('Y-m-d') . '.pdf');
exit;