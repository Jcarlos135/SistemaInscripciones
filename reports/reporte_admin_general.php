<?php
// Capturar cualquier salida accidental (espacios, warnings, etc.)
ob_start();

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) die('Acceso denegado.');

date_default_timezone_set('America/La_Paz');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

$stats = obtener_estadisticas($conn);

// Verifica qué claves devuelve realmente tu función (descomenta para depurar):
// echo "<pre>"; print_r($stats); echo "</pre>"; exit;

// CONSULTAS ADICIONALES PARA GÉNERO Y EDAD
$query_genero = "SELECT genero, COUNT(*) as total FROM estudiante WHERE activo = 1 GROUP BY genero";
$result_genero = mysqli_query($conn, $query_genero);
$generos = [];
while ($row = mysqli_fetch_assoc($result_genero)) {
    $generos[$row['genero']] = $row['total'];
}
$total_hombres = $generos['M'] ?? 0;
$total_mujeres = $generos['F'] ?? 0;

$query_edad = "SELECT 
    AVG(edad) as promedio,
    MIN(edad) as minimo,
    MAX(edad) as maximo,
    COUNT(*) as total
    FROM estudiante WHERE activo = 1 AND edad IS NOT NULL";
$result_edad = mysqli_query($conn, $query_edad);
$edad_stats = mysqli_fetch_assoc($result_edad);

// Rangos de edad
$query_rangos = "SELECT 
    CASE 
        WHEN edad BETWEEN 18 AND 25 THEN '18-25'
        WHEN edad BETWEEN 26 AND 30 THEN '26-30'
        WHEN edad BETWEEN 31 AND 35 THEN '31-35'
        WHEN edad BETWEEN 36 AND 40 THEN '36-40'
        WHEN edad > 40 THEN '41+'
        ELSE 'Sin dato'
    END as rango,
    COUNT(*) as total
    FROM estudiante WHERE activo = 1
    GROUP BY rango ORDER BY rango";
$result_rangos = mysqli_query($conn, $query_rangos);


// CLASE PDF PERSONALIZADA
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(25, 135, 84);
        $this->SetTextColor(255);
        $this->Cell(0, 12, utf8_decode('REPORTE GENERAL DEL SISTEMA ACADÉMICO'), 1, 1, 'C', true);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(0, 6, utf8_decode('Fecha de emisión: ' . date('d/m/Y H:i:s')), 0, 1, 'C');
        $this->Ln(3);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function TituloSeccion($titulo) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(25, 135, 84);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode($titulo), 1, 1, 'L', true);
        $this->SetTextColor(0);
        $this->Ln(2);
    }
}


// GENERACIÓN DEL PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


// SECCIÓN 1: RESUMEN ESTADÍSTICO GENERAL
$pdf->TituloSeccion('RESUMEN ESTADÍSTICO GENERAL');
$pdf->SetFont('Arial', '', 11);

//  CORRECCIÓN: Usar ?? para evitar el "Undefined array key"
// Ajusta los nombres de las claves según lo que devuelva tu función obtener_estadisticas()
$datos = [
    ['Estudiantes Activos',   $stats['estudiantes_activos']  ?? 0],
    ['Estudiantes Inactivos', $stats['estudiantes_inactivos'] ?? 0],
    ['Carreras Activas',      $stats['carreras_activas']     ?? 0],
    ['Materias Disponibles',  $stats['materias_activas']     ?? 0],
    ['Total de Inscripciones',$stats['inscripciones']        ?? $stats['total_inscripciones'] ?? 0],
    ['Usuarios del Sistema',  $stats['usuarios_activos']     ?? 0],
];

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(120, 8, 'Concepto', 1, 0, 'C', true);
$pdf->Cell(70, 8, 'Cantidad', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

foreach ($datos as $d) {
    $pdf->Cell(120, 8, utf8_decode($d[0]), 1);
    $pdf->Cell(70, 8, $d[1], 1, 1, 'C');
}

$pdf->Ln(8);


// SECCIÓN 2: DISTRIBUCIÓN POR GÉNERO
$pdf->TituloSeccion('DISTRIBUCIÓN POR GÉNERO');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(60, 8, 'Género', 1, 0, 'C', true);
$pdf->Cell(60, 8, 'Cantidad', 1, 0, 'C', true);
$pdf->Cell(70, 8, 'Porcentaje', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

$total_estudiantes = $total_hombres + $total_mujeres;
$porc_hombres = $total_estudiantes > 0 ? round(($total_hombres / $total_estudiantes) * 100, 1) : 0;
$porc_mujeres = $total_estudiantes > 0 ? round(($total_mujeres / $total_estudiantes) * 100, 1) : 0;

$pdf->Cell(60, 8, utf8_decode('Hombres'), 1, 0, 'C');
$pdf->Cell(60, 8, $total_hombres, 1, 0, 'C');
$pdf->Cell(70, 8, $porc_hombres . '%', 1, 1, 'C');

$pdf->Cell(60, 8, utf8_decode('Mujeres'), 1, 0, 'C');
$pdf->Cell(60, 8, $total_mujeres, 1, 0, 'C');
$pdf->Cell(70, 8, $porc_mujeres . '%', 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(232, 245, 233);
$pdf->Cell(60, 8, utf8_decode('TOTAL'), 1, 0, 'C', true);
$pdf->Cell(60, 8, $total_estudiantes, 1, 0, 'C', true);
$pdf->Cell(70, 8, '100%', 1, 1, 'C', true);
$pdf->SetFillColor(255);

$pdf->Ln(8);


// SECCIÓN 3: ESTADÍSTICAS DE EDAD
$pdf->TituloSeccion('ESTADÍSTICAS DE EDAD');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(95, 8, 'Métrica', 1, 0, 'C', true);
$pdf->Cell(95, 8, 'Valor', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(95, 8, utf8_decode('Edad Promedio'), 1, 0, 'C');
$pdf->Cell(95, 8, number_format($edad_stats['promedio'] ?? 0, 1) . ' años', 1, 1, 'C');

$pdf->Cell(95, 8, utf8_decode('Edad Mínima'), 1, 0, 'C');
$pdf->Cell(95, 8, ($edad_stats['minimo'] ?? 0) . ' años', 1, 1, 'C');

$pdf->Cell(95, 8, utf8_decode('Edad Máxima'), 1, 0, 'C');
$pdf->Cell(95, 8, ($edad_stats['maximo'] ?? 0) . ' años', 1, 1, 'C');

$pdf->Ln(5);

// Rangos de edad
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(95, 8, 'Rango de Edad', 1, 0, 'C', true);
$pdf->Cell(95, 8, 'Cantidad de Estudiantes', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

while ($rango = mysqli_fetch_assoc($result_rangos)) {
    $pdf->Cell(95, 8, utf8_decode($rango['rango'] . ' años'), 1, 0, 'C');
    $pdf->Cell(95, 8, $rango['total'], 1, 1, 'C');
}

$pdf->Ln(8);


// SECCIÓN 4: CARRERAS REGISTRADAS
$pdf->TituloSeccion('CARRERAS REGISTRADAS');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(30, 8, utf8_decode('Código'), 1, 0, 'C', true);
$pdf->Cell(120, 8, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Estado', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 9);

$carreras = listar_todas_carreras($conn);
while ($c = mysqli_fetch_assoc($carreras)) {
    $pdf->Cell(30, 7, $c['id'], 1, 0, 'C');
    $pdf->Cell(120, 7, utf8_decode($c['nombre']), 1);
    $pdf->SetFillColor($c['activo'] == 1 ? 25 : 220, $c['activo'] == 1 ? 135 : 53, $c['activo'] == 1 ? 84 : 69);
    $pdf->SetTextColor(255);
    $pdf->Cell(40, 7, $c['activo'] == 1 ? 'ACTIVA' : 'INACTIVA', 1, 1, 'C', true);
    $pdf->SetTextColor(0);
}

$pdf->Ln(8);


// SECCIÓN 5: DETALLE DE ESTUDIANTES
$pdf->TituloSeccion('LISTADO DETALLADO DE ESTUDIANTES');

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(25, 8, 'CI', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Nombre Completo', 1, 0, 'C', true);
$pdf->Cell(15, 8, 'Edad', 1, 0, 'C', true);
$pdf->Cell(15, 8, utf8_decode('Gén.'), 1, 0, 'C', true);
$pdf->Cell(60, 8, 'Carrera', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Estado', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 8);

$query_estudiantes = "SELECT e.*, c.nombre as carrera_nombre 
                      FROM estudiante e 
                      INNER JOIN carrera c ON e.id_carrera = c.id 
                      ORDER BY e.ap_pat";
$result_estudiantes = mysqli_query($conn, $query_estudiantes);

while ($e = mysqli_fetch_assoc($result_estudiantes)) {
    $pdf->Cell(25, 6, $e['ci'], 1, 0, 'C');
    $pdf->Cell(50, 6, utf8_decode($e['nombre'] . ' ' . $e['ap_pat'] . ' ' . $e['ap_mat']), 1);
    $pdf->Cell(15, 6, $e['edad'] ?? '-', 1, 0, 'C');
    $pdf->Cell(15, 6, $e['genero'] ?? '-', 1, 0, 'C');
    $pdf->Cell(60, 6, utf8_decode(substr($e['carrera_nombre'], 0, 20)), 1);
    
    $pdf->SetFillColor($e['activo'] == 1 ? 25 : 220, $e['activo'] == 1 ? 135 : 53, $e['activo'] == 1 ? 84 : 69);
    $pdf->SetTextColor(255);
    $pdf->Cell(25, 6, $e['activo'] == 1 ? 'ACTIVO' : 'INACTIVO', 1, 1, 'C', true);
    $pdf->SetTextColor(0);
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(0, 7, utf8_decode('Total de estudiantes registrados: ') . mysqli_num_rows($result_estudiantes), 1, 1, 'C', true);
$pdf->SetTextColor(0);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(128);
$pdf->Cell(0, 6, utf8_decode('Documento generado automáticamente por el Sistema Académico.'), 0, 1, 'C');

//  CORRECCIÓN CLAVE: Limpiar cualquier salida capturada antes de enviar el PDF
if (ob_get_length()) ob_end_clean();

$pdf->Output('I', 'Reporte_General_Sistema_' . date('Y-m-d') . '.pdf');
exit;