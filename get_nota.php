<?php
// get_nota.php — Devuelve las notas existentes de un estudiante en una materia
session_start();
if (!isset($_SESSION['uid'])) { http_response_code(401); echo json_encode(['error'=>'no auth']); exit; }

header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=inst;charset=utf8mb4", 'root', '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);

$ci      = $_GET['ci']      ?? '';
$asig    = $_GET['asig']    ?? '';
$gestion = $_GET['gestion'] ?? date('Y');

$stmt = $pdo->prepare("
    SELECT bimestre_1 AS b1, bimestre_2 AS b2, bimestre_3 AS b3, bimestre_4 AS b4,
           promedio_parcial, estado_materia
    FROM nota_bimestral
    WHERE ci_estudiante = ? AND codigo_asig = ? AND gestion = ?
    LIMIT 1
");
$stmt->execute([$ci, $asig, $gestion]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode(['found'=>true] + $row);
} else {
    echo json_encode(['found'=>false]);
}
