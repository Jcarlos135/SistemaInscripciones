<?php
// Capturar salidas accidentales para evitar errores de FPDF
ob_start();

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) die('Acceso denegado.');

date_default_timezone_set('America/La_Paz');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

//  Paleta de colores azul
$AZUL_PRINCIPAL = [41, 128, 185];
$AZUL_OSCURO    = [31, 97, 141];
$VERDE_ACTIVO   = [39, 174, 96];
$ROJO_INACTIVO  = [192, 57, 43];
$AZUL_FILA_ALT  = [235, 245, 251];

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(41, 128, 185);
        $this->SetTextColor(255);
        $this->Cell(0, 12, utf8_decode('REPORTE DE ESTUDIANTES POR CARRERA'), 1, 1, 'C', true);
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
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//  Contador general de estudiantes en todo el reporte
$total_general = 0;
$total_carreras_con_estudiantes = 0;
$total_carreras = 0;

$carreras = listar_todas_carreras($conn);

while ($c = mysqli_fetch_assoc($carreras)) {
    $total_carreras++;
    
    // === TÍTULO DE LA CARRERA ===
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor($AZUL_PRINCIPAL[0], $AZUL_PRINCIPAL[1], $AZUL_PRINCIPAL[2]);
    $pdf->SetTextColor(255);
    $pdf->Cell(0, 9, utf8_decode($c['nombre'] . '  (Código: ' . $c['id'] . ')'), 1, 1, 'L', true);
    
    // === ENCABEZADO DE COLUMNAS (con fondo azul) ===
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetFillColor($AZUL_OSCURO[0], $AZUL_OSCURO[1], $AZUL_OSCURO[2]);
    $pdf->SetTextColor(255);
    
    // Columnas igualadas con ancho total: 28 + 85 + 30 + 27 = 170
    $pdf->Cell(28, 7, 'CI', 1, 0, 'C', true);
    $pdf->Cell(85, 7, 'Nombre Completo', 1, 0, 'C', true);
    $pdf->Cell(50, 7, 'Celular', 1, 0, 'C', true);
    $pdf->Cell(27, 7, 'Estado', 1, 1, 'C', true);
    
    // === LISTADO DE ESTUDIANTES ===
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0);
    
    $ci_carrera = mysqli_real_escape_string($conn, $c['id']);
    $query = "SELECT * FROM estudiante WHERE id_carrera = '$ci_carrera' ORDER BY ap_pat, nombre";
    $result = mysqli_query($conn, $query);
    
    $total_estudiantes_carrera = 0;
    $fill = false; // Para filas alternadas
    
    if (mysqli_num_rows($result) > 0) {
        while ($e = mysqli_fetch_assoc($result)) {
            // Color de fondo alternado
            if ($fill) {
                $pdf->SetFillColor($AZUL_FILA_ALT[0], $AZUL_FILA_ALT[1], $AZUL_FILA_ALT[2]);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            
            $pdf->Cell(28, 6, $e['ci'] ?? '', 1, 0, 'C', true);
            $pdf->Cell(85, 6, utf8_decode(($e['nombre'] ?? '') . ' ' . ($e['ap_pat'] ?? '') . ' ' . ($e['ap_mat'] ?? '')), 1, 0, 'L', true);
            $pdf->Cell(50, 6, $e['cel'] ?? '-', 1, 0, 'C', true);
            
            // Estado con color
            $estado = $e['activo'] == 1 ? 'ACTIVO' : 'INACTIVO';
            if ($e['activo'] == 1) {
                $pdf->SetFillColor($VERDE_ACTIVO[0], $VERDE_ACTIVO[1], $VERDE_ACTIVO[2]);
            } else {
                $pdf->SetFillColor($ROJO_INACTIVO[0], $ROJO_INACTIVO[1], $ROJO_INACTIVO[2]);
            }
            $pdf->SetTextColor(255);
            $pdf->Cell(27, 6, $estado, 1, 1, 'C', true);
            $pdf->SetTextColor(0);
            
            $total_estudiantes_carrera++;
            $fill = !$fill;
        }
        
        // === SUBTOTAL DE LA CARRERA ===
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(220, 235, 245);
        $pdf->Cell(163, 7, utf8_decode('Total de estudiantes en esta carrera:'), 1, 0, 'R', true);
        $pdf->Cell(27, 7, $total_estudiantes_carrera, 1, 1, 'C', true);
        
        $total_general += $total_estudiantes_carrera;
        $total_carreras_con_estudiantes++;
        
    } else {
        // Mensaje cuando no hay estudiantes
        $pdf->SetFillColor(255, 245, 238);
        $pdf->SetTextColor(180, 60, 60);
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->Cell(170, 7, utf8_decode('No hay estudiantes registrados en esta carrera.'), 1, 1, 'C', true);
        $pdf->SetTextColor(0);
    }
    
    $pdf->Ln(6);
    
    // === CONTROL DE SALTO DE PÁGINA ===
    // Si quedan menos de 60mm en la página, forzar salto
    if ($pdf->GetY() > 230) {
        $pdf->AddPage();
    }
}

// === TOTAL GENERAL AL FINAL DEL REPORTE ===
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor($AZUL_PRINCIPAL[0], $AZUL_PRINCIPAL[1], $AZUL_PRINCIPAL[2]);
$pdf->SetTextColor(255);
$pdf->Cell(0, 10, utf8_decode('RESUMEN GENERAL'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0);
$pdf->SetFillColor(240, 240, 240);

$pdf->Cell(150, 8, utf8_decode('Total de carreras registradas:'), 1, 0, 'L', true);
$pdf->Cell(40, 8, $total_carreras, 1, 1, 'C', true);

$pdf->Cell(150, 8, utf8_decode('Carreras con estudiantes activos:'), 1, 0, 'L', true);
$pdf->Cell(40, 8, $total_carreras_con_estudiantes, 1, 1, 'C', true);

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(39, 174, 96);
$pdf->SetTextColor(255);
$pdf->Cell(150, 10, utf8_decode('TOTAL GENERAL DE ESTUDIANTES:'), 1, 0, 'L', true);
$pdf->Cell(40, 10, $total_general, 1, 1, 'C', true);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(128);
$pdf->Cell(0, 6, utf8_decode('Documento generado automáticamente por el Sistema Académico.'), 0, 1, 'C');

// Limpiar buffer antes de enviar el PDF
if (ob_get_length()) ob_end_clean();

$pdf->Output('I', 'Reporte_Estudiantes_por_Carrera_' . date('Y-m-d') . '.pdf');
exit;
?>