<?php
// save_nota.php — Guarda notas bimestrales y recalcula el historial académico
session_start();

if (!isset($_SESSION['uid'])) { 
    http_response_code(401); 
    echo json_encode(['ok' => false, 'msg' => 'No autorizado']); 
    exit; 
}

if ($_SESSION['rol'] !== 'Profesor' && $_SESSION['rol'] !== 'Admin') {
    echo json_encode(['ok' => false, 'msg' => 'Sin permisos de edición']); 
    exit;
}

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=inst;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $ci_est     = trim($_POST['ci'] ?? '');
    $cod_asig   = trim($_POST['asig'] ?? '');
    $gestion    = trim($_POST['gestion'] ?? date('Y'));
    $bimestre   = intval($_POST['bimestre'] ?? 1);
    $id_docente = intval($_SESSION['id_docente'] ?? 1);

    // Notas de entrada
    $nota_t = isset($_POST['teorico']) ? floatval($_POST['teorico']) : null;
    $nota_p = isset($_POST['practico']) ? floatval($_POST['practico']) : null;

    if (!$ci_est || !$cod_asig) {
        echo json_encode(['ok' => false, 'msg' => 'Datos incompletos: C.I. o Asignatura faltantes']); 
        exit;
    }

    if ($nota_t === null || $nota_p === null) {
        echo json_encode(['ok' => false, 'msg' => 'Debe ingresar nota teórica y práctica']); 
        exit;
    }

    // Ponderación: 30% Teórico + 70% Práctico = Nota Bimestral (Entero)
    $nota_bim = intval(round(($nota_t * 0.30) + ($nota_p * 0.70)));

    // Mapeo dinámico de columnas por bimestre
    $col_t = "nota_teorico" . $bimestre;
    $col_p = "nota_pract" . $bimestre;
    
    $mapa_bim = [
        1 => "nota_primerbim", 
        2 => "nota_segundobim", 
        3 => "nota_tercerbim", 
        4 => "nota_cuartobim"
    ];
    $col_b = $mapa_bim[$bimestre] ?? "nota_primerbim";

    // Insertar o actualizar registro en historial (UPSERT)
    $sql = "INSERT INTO historial (ci_est, cod_asig, gestion, $col_t, $col_p, $col_b, id_docente, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'En Proceso')
            ON DUPLICATE KEY UPDATE 
                $col_t = VALUES($col_t), 
                $col_p = VALUES($col_p), 
                $col_b = VALUES($col_b),
                id_docente = VALUES(id_docente)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ci_est, $cod_asig, $gestion, $nota_t, $nota_p, $nota_bim, $id_docente]);

    // Recalcular estado de materias y condición general del estudiante
    recalcularAcademicoEstudiante($pdo, $ci_est, $gestion);

    echo json_encode(['ok' => true, 'msg' => 'Nota registrada y estado actualizado correctamente']);

} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'msg' => 'Error BD: ' . $e->getMessage()]);
}

// ── Evalúa la nota final de cada materia y la condición académica global ──
function recalcularAcademicoEstudiante(PDO $pdo, string $ci, string $gestion) {
    // 1. Consultar materias del estudiante
    $stmt = $pdo->prepare("SELECT id, nota_primerbim, nota_segundobim, nota_tercerbim, nota_cuartobim FROM historial WHERE ci_est = ? AND gestion = ?");
    $stmt->execute([$ci, $gestion]);
    $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_materias = count($materias);
    $reprobadas = 0;
    $aprobadas = 0;

    foreach ($materias as $m) {
        $n1 = $m['nota_primerbim'];
        $n2 = $m['nota_segundobim'];
        $n3 = $m['nota_tercerbim'];
        $n4 = $m['nota_cuartobim'];

        // Si los 4 bimestres tienen calificación
        if ($n1 !== null && $n2 !== null && $n3 !== null && $n4 !== null) {
            $nota_final = intval(round(($n1 + $n2 + $n3 + $n4) / 4));
            $estado_mat = ($nota_final >= 51) ? 'Aprobado' : 'Reprobado';
            $literal    = ($estado_mat === 'Aprobado') ? 'APROBADO' : 'REPROBADO';

            if ($estado_mat === 'Reprobado') {
                $reprobadas++;
            } else {
                $aprobadas++;
            }

            // Actualizar materia individual
            $upd = $pdo->prepare("UPDATE historial SET nota_bim = ?, estado = ?, literal = ? WHERE id = ?");
            $upd->execute([$nota_final, $estado_mat, $literal, $m['id']]);
        }
    }

    // 2. Definir estado final global del estudiante
    if ($reprobadas > 3) {
        $estado_global = 'REPROBADO';
        $obs = "Reprobó $reprobadas materias (>3). Solo cursará materias reprobadas.";
    } elseif ($reprobadas > 0 && $reprobadas <= 3) {
        $estado_global = 'SEGUNDO TURNO';
        $obs = "Tiene $reprobadas materia(s) reprobada(s). Pasa a Segundo Turno.";
    } elseif ($aprobadas > 0 && $reprobadas === 0 && ($aprobadas === $total_materias)) {
        $estado_global = 'APROBADO - PASA AL SIGUIENTE NIVEL';
        $obs = 'Aprobó todas las materias. Promovido automáticamente al siguiente nivel.';
    } else {
        $estado_global = 'EN PROCESO';
        $obs = 'Evaluaciones bimestrales en curso.';
    }

    // Actualizar tabla inscripcion
    $updInscr = $pdo->prepare("UPDATE inscripcion SET estado_final = ?, observaciones = ? WHERE ci_estudiante = ? AND gestion = ?");
    $updInscr->execute([$estado_global, $obs, $ci, $gestion]);
}
?>