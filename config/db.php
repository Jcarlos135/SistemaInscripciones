<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'inst';

// Forzar modo estricto para manejar errores en transacciones
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>