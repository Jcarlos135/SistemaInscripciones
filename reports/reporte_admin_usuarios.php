<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) die('Acceso denegado.');

date_default_timezone_set('America/La_Paz');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/funciones.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';


// CONSULTAS ESTADÍSTICAS


// Total de usuarios por rol
$query_roles = "SELECT r.nombre as rol, COUNT(*) as total 
                FROM usuario u 
                INNER JOIN rol r ON u.id_rol = r.id 
                GROUP BY r.nombre";
$result_roles = mysqli_query($conn, $query_roles);

// Usuarios activos vs inactivos
$query_estado = "SELECT 
                    SUM(CASE WHEN activo = 1 THEN 1 ELSE 0 END) as activos,
                    SUM(CASE WHEN activo = 0 THEN 1 ELSE 0 END) as inactivos,
                    COUNT(*) as total
                 FROM usuario";
$result_estado = mysqli_query($conn, $query_estado);
$estado_stats = mysqli_fetch_assoc($result_estado);

// ✅ CONSULTA CORREGIDA: Los campos de secretaria ahora son 'id' y 'nombre'
$query_usuarios = "SELECT 
                    u.id,
                    u.usuario,
                    u.activo,
                    r.nombre as rol,
                    u.id_rol,
                    e.ci,
                    e.nombre,
                    e.ap_pat,
                    e.ap_mat,
                    e.edad,
                    e.genero,
                    e.cel,
                    c.nombre as carrera_nombre,
                    s.nombre as secretaria_nombre
                   FROM usuario u
                   INNER JOIN rol r ON u.id_rol = r.id
                   LEFT JOIN estudiante e ON u.id = e.id_usuario
                   LEFT JOIN carrera c ON e.id_carrera = c.id
                   LEFT JOIN secretaria s ON u.id = s.id_usuario
                   ORDER BY r.nombre, u.activo DESC, u.usuario";
$result_usuarios = mysqli_query($conn, $query_usuarios);


// CLASE PDF PERSONALIZADA

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(25, 135, 84);
        $this->SetTextColor(255);
        $this->Cell(0, 12, utf8_decode('REPORTE GENERAL DE USUARIOS'), 1, 1, 'C', true);
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


// SECCIÓN 1: RESUMEN ESTADÍSTICO

$pdf->TituloSeccion('RESUMEN ESTADÍSTICO DE USUARIOS');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(100, 8, 'Métrica', 1, 0, 'C', true);
$pdf->Cell(90, 8, 'Cantidad', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(100, 8, 'Total de Usuarios', 1, 0, 'C');
$pdf->Cell(90, 8, $estado_stats['total'], 1, 1, 'C');

$pdf->Cell(100, 8, 'Usuarios Activos', 1, 0, 'C');
$pdf->Cell(90, 8, $estado_stats['activos'], 1, 1, 'C');

$pdf->Cell(100, 8, 'Usuarios Inactivos', 1, 0, 'C');
$pdf->Cell(90, 8, $estado_stats['inactivos'], 1, 1, 'C');

$pdf->Ln(5);

// Distribución por rol
$pdf->TituloSeccion('DISTRIBUCIÓN POR ROL');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(100, 8, 'Rol', 1, 0, 'C', true);
$pdf->Cell(90, 8, 'Cantidad', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

while ($rol = mysqli_fetch_assoc($result_roles)) {
    $pdf->Cell(100, 8, utf8_decode($rol['rol']), 1, 0, 'C');
    $pdf->Cell(90, 8, $rol['total'], 1, 1, 'C');
}

$pdf->Ln(8);


// SECCIÓN 2: LISTADO DETALLADO DE USUARIOS

$pdf->TituloSeccion('LISTADO DETALLADO DE USUARIOS');

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(10, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Usuario', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Rol', 1, 0, 'C', true);
$pdf->Cell(18, 8, 'CI', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Nombre Completo', 1, 0, 'C', true);
$pdf->Cell(10, 8, 'Edad', 1, 0, 'C', true);
$pdf->Cell(12, 8, utf8_decode('Gén.'), 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Celular', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Estado', 1, 1, 'C', true);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 7);

// Datos de usuarios
while ($u = mysqli_fetch_assoc($result_usuarios)) {
    // Determinar nombre completo según el rol
    if ($u['id_rol'] == 3 && !empty($u['nombre'])) {
        // Es estudiante
        $nombre_completo = $u['nombre'] . ' ' . $u['ap_pat'] . ' ' . $u['ap_mat'];
        $ci = $u['ci'];
        $edad = $u['edad'] ?? '-';
        $genero = $u['genero'] ?? '-';
        $celular = $u['cel'] ?? '-';
    } elseif ($u['id_rol'] == 2 && !empty($u['secretaria_nombre'])) {
        // Es secretaria
        $nombre_completo = $u['secretaria_nombre'];
        $ci = '-';
        $edad = '-';
        $genero = '-';
        $celular = '-';
    } else {
        // Es admin u otro
        $nombre_completo = 'Administrador del Sistema';
        $ci = '-';
        $edad = '-';
        $genero = '-';
        $celular = '-';
    }
    
    // Truncar nombre si es muy largo
    if (strlen($nombre_completo) > 35) {
        $nombre_completo = substr($nombre_completo, 0, 32) . '...';
    }
    
    $pdf->Cell(10, 6, $u['id'], 1, 0, 'C');
    $pdf->Cell(25, 6, $u['usuario'], 1, 0, 'C');
    $pdf->Cell(25, 6, utf8_decode(substr($u['rol'], 0, 10)), 1, 0, 'C');
    $pdf->Cell(18, 6, $ci, 1, 0, 'C');
    $pdf->Cell(40, 6, utf8_decode($nombre_completo), 1);
    $pdf->Cell(10, 6, $edad, 1, 0, 'C');
    $pdf->Cell(12, 6, $genero, 1, 0, 'C');
    $pdf->Cell(20, 6, $celular, 1, 0, 'C');
    
    // Estado con color
    $pdf->SetFillColor($u['activo'] == 1 ? 25 : 220, $u['activo'] == 1 ? 135 : 53, $u['activo'] == 1 ? 84 : 69);
    $pdf->SetTextColor(255);
    $pdf->Cell(30, 6, $u['activo'] == 1 ? 'ACTIVO' : 'INACTIVO', 1, 1, 'C', true);
    $pdf->SetTextColor(0);
}

$pdf->Ln(5);

// Total de usuarios
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(25, 135, 84);
$pdf->SetTextColor(255);
$pdf->Cell(190, 7, utf8_decode('Total de usuarios registrados: ') . $estado_stats['total'], 1, 1, 'C', true);
$pdf->SetTextColor(0);

$pdf->Ln(8);


// SECCIÓN 3: INFORMACIÓN ADICIONAL

$pdf->TituloSeccion('INFORMACIÓN ADICIONAL');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 6, utf8_decode('Este reporte incluye todos los usuarios del sistema con sus datos asociados:'), 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 5, '', 0, 0);
$pdf->Cell(0, 5, utf8_decode('Administradores (Rol 1):'), 0, 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(0, 5, utf8_decode('- Acceso total al sistema, gestión de usuarios, carreras y reportes'), 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 5, '', 0, 0);
$pdf->Cell(0, 5, utf8_decode('Secretarias (Rol 2):'), 0, 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(0, 5, utf8_decode('- Gestión de inscripciones, registro y edición de estudiantes'), 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 5, '', 0, 0);
$pdf->Cell(0, 5, utf8_decode('Estudiantes (Rol 3):'), 0, 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(0, 5, utf8_decode('- Consulta de materias inscritas, generación de reportes personales'), 0, 1);
$pdf->Ln(5);

// Nota final
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(128);
$pdf->Cell(0, 6, utf8_decode('Nota: Los usuarios inactivos han sido dados de baja mediante borrado lógico y no pueden acceder al sistema.'), 0, 1, 'C');
$pdf->Cell(0, 6, utf8_decode('Documento generado automáticamente por el Sistema Académico.'), 0, 1, 'C');

$pdf->Output('I', 'Reporte_Usuarios_' . date('Y-m-d') . '.pdf');
exit;
?>