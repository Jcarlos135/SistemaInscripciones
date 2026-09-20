<?php
// TEST: Verificar estructura de archivos
echo "<h3>Verificación del Sistema</h3>";

 $archivos = [
    'index.php' => 'Controller',
    'config/db.php' => 'Base de datos',
    'models/funciones.php' => 'Funciones',
    'views/login.php' => 'Login',
    'views/registro.php' => 'Registro (nuevo)',
    'views/header.php' => 'Header',
    'views/footer.php' => 'Footer',
    'lib/fpdf/fpdf.php' => 'Librería PDF',
];

 $carpetas = [
    'documentos/' => 'Documentos subidos',
    'fotos/' => 'Fotos de estudiantes',
];

echo "<h4>Archivos:</h4>";
foreach ($archivos as $path => $desc) {
    $existe = file_exists($path);
    $color = $existe ? 'green' : 'red';
    $icon = $existe ? '' : '';
    echo "<p style='color:$color'>$icon $path — $desc</p>";
}

echo "<h4>Carpetas:</h4>";
foreach ($carpetas as $path => $desc) {
    $existe = is_dir($path);
    $color = $existe ? 'green' : 'red';
    $icon = $existe ? '' : '';
    echo "<p style='color:$color'>$icon $path — $desc</p>";
    if ($existe) {
        $writable = is_writable($path);
        $color2 = $writable ? 'green' : 'orange';
        $icon2 = $writable ? '' : '';
        echo "<p style='color:$color2'>$icon2 Escritura: " . ($writable ? 'Sí' : 'No') . "</p>";
    }
}

// Test FPDF
if (file_exists('lib/fpdf/fpdf.php')) {
    require_once 'lib/fpdf/fpdf.php';
    $pdf = new FPDF();
    echo "<p style='color:green'>✅ FPDF cargado correctamente</p>";
} else {
    echo "<p style='color:red'>❌ FPDF no encontrado — descargar de https://github.com/Setas/FPDF</p>";
}

// Test conexión BD
if (file_exists('config/db.php')) {
    require_once 'config/db.php';
    if (isset($conn) && $conn) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM estudiante");
        $row = mysqli_fetch_assoc($result);
        echo "<p style='color:green'>✅ BD conectada — $row['total'] estudiantes</p>";
        
        // Verificar tabla documento
        $check_doc = mysqli_query($conn, "SHOW TABLES LIKE 'documento'");
        if (mysqli_num_rows($check_doc) > 0) {
            echo "<p style='color:green'>✅ Tabla 'documento' existe</p>";
        } else {
            echo "<p style='color:red'>❌ Tabla 'documento' NO existe — ejecutar SQL</p>";
        }
        
        // Verificar SP
        $check_sp = mysqli_query($conn, "SHOW PROCEDURE STATUS WHERE Name = 'sp_inscribir_estudiante_nuevo'");
        if (mysqli_num_rows($check_sp) > 0) {
            echo "<p style='color:green'>✅ Stored Procedure existe</p>";
        } else {
            echo "<p style='color:red'>❌ Stored Procedure NO existe</p>";
        }
    } else {
        echo "<p style='color:red'>❌ No se pudo conectar a BD</p>";
    }
}
?>