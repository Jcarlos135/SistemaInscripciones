<?php
include 'views/header.php';

$datos_est = obtener_datos_estudiante($conn, $_SESSION['estudiante_ci']);

// 1. VERIFICAR QUE EL ESTUDIANTE ESTÉ ACTIVO
if (!$datos_est || $datos_est['activo'] == 0) {
    echo '<div class="alert alert-danger mt-4 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
            <strong>Cuenta Inactiva:</strong> Su registro de estudiante se encuentra desactivado. Por favor, contacte a secretaría académica para regularizar su situación.
          </div>';
    include 'views/footer.php';
    exit;
}

// 2. OBTENER GESTIÓN SELECCIONADA Y FILTRAR
$gestion_seleccionada = $_GET['gestion'] ?? null;
$inscripciones = listar_inscripciones_estudiante($conn, $_SESSION['estudiante_ci'], $gestion_seleccionada);

// Obtener lista de gestiones disponibles para el combo box
$gestiones_query = mysqli_query($conn, "SELECT DISTINCT COALESCE(h.gestion, a.gestion) as gestion 
                                        FROM inscripcion i
                                        INNER JOIN asignatura a ON a.codigo = i.cod_asig
                                        LEFT JOIN historial h ON h.ci_est = i.ci_est AND h.cod_asig = i.cod_asig
                                        WHERE i.ci_est = '" . limpiar($conn, $_SESSION['estudiante_ci']) . "' AND i.activo = 1
                                        ORDER BY gestion DESC");
$gestiones = [];
while ($g = mysqli_fetch_assoc($gestiones_query)) {
    if ($g['gestion']) $gestiones[] = $g['gestion'];
}

function verNota($val)
{
    return (isset($val) && $val !== '' && $val !== null) ? htmlspecialchars($val) : '-';
}

// Contadores para el estado académico
$total_materias = 0;
$aprobadas = 0;
$reprobadas = 0;
$en_proceso = 0;
$temp_inscripciones = [];

if ($inscripciones && mysqli_num_rows($inscripciones) > 0) {
    while ($i = mysqli_fetch_assoc($inscripciones)) {
        $temp_inscripciones[] = $i;
        $total_materias++;
        $estado = strtoupper(trim($i['estado'] ?? 'EN PROCESO'));
        if ($estado === 'APROBADO') $aprobadas++;
        elseif ($estado === 'REPROBADO') $reprobadas++;
        else $en_proceso++;
    }
}

// Determinar el estado final según las reglas académicas
if ($total_materias > 0) {
    if ($reprobadas == 0 && $en_proceso == 0) {
        $estado_final_titulo = "APROBADO";
        $estado_final_texto = "Ha aprobado todas las materias. Pasa automáticamente al siguiente año y debe inscribir todas las materias del nuevo nivel.";
        $estado_final_clase = "estado-aprobado";
        $estado_final_badge = "badge-aprobado";
    } elseif ($reprobadas == 3) {
        $estado_final_titulo = "SEGUNDO TURNO";
        $estado_final_texto = "Tiene exactamente 3 materias reprobadas. Solo podrá inscribir estas 3 materias para recuperarlas.";
        $estado_final_clase = "estado-segundo";
        $estado_final_badge = "badge-2doturno";
    } elseif ($reprobadas > 3) {
        $estado_final_titulo = "REPROBADO";
        $estado_final_texto = "Tiene más de 3 materias reprobadas. No pasa de año y solo podrá inscribir las materias que ha reprobado.";
        $estado_final_clase = "estado-reprobado";
        $estado_final_badge = "badge-reprobado";
    } elseif ($reprobadas > 0 && $reprobadas < 3) {
        $estado_final_titulo = "REGULAR CON PENDIENTES";
        $estado_final_texto = "Tiene entre 1 y 2 materias reprobadas. Debe inscribir las materias del nuevo año junto con las materias reprobadas.";
        $estado_final_clase = "estado-proceso";
        $estado_final_badge = "badge-proceso";
    } else {
        $estado_final_titulo = "EN PROCESO";
        $estado_final_texto = "Aún hay materias sin calificaciones finales registradas.";
        $estado_final_clase = "estado-proceso";
        $estado_final_badge = "badge-proceso";
    }
} else {
    $estado_final_titulo = "SIN INSCRIPCIONES";
    $estado_final_texto = "No se encontraron materias registradas para este estudiante en la gestión seleccionada.";
    $estado_final_clase = "estado-proceso";
    $estado_final_badge = "badge-proceso";
}
?>
<link rel="stylesheet" href="/sig/public/css/estudiante_dashboard.css">
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <h3><i class="bi bi-person-badge"></i> Bienvenido(a), <?= htmlspecialchars(($datos_est['nombre'] ?? '') . ' ' . ($datos_est['ap_pat'] ?? '')) ?></h3>
                <p class="mb-0">CI: <?= htmlspecialchars($datos_est['ci'] ?? '') ?> | Carrera: <?= htmlspecialchars($datos_est['carrera_nombre'] ?? '') ?></p>
            </div>
        </div>
    </div>
</div>

<!-- COMBO BOX PARA FILTRAR POR GESTIÓN -->
<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label fw-bold"><i class="bi bi-calendar3"></i> Filtrar por Gestión Académica:</label>
        <select class="form-select shadow-sm" onchange="window.location.href='index.php?action=estudiante_dashboard' + (this.value ? '&gestion=' + this.value : '')">
            <option value="">-- Todas las gestiones --</option>
            <?php foreach ($gestiones as $g): ?>
                <option value="<?= htmlspecialchars($g) ?>" <?= ($gestion_seleccionada == $g) ? 'selected' : '' ?>>
                    Gestión <?= htmlspecialchars($g) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-8 d-flex align-items-end justify-content-end">
        <a href="index.php?action=generar_reporte<?= $gestion_seleccionada ? '&gestion=' . urlencode($gestion_seleccionada) : '' ?>" class="btn btn-danger" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Generar Reporte PDF
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="bi bi-journal-check"></i> Mis Materias y Calificaciones Bimestrales</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle bg-dark text-white">Código</th>
                        <th rowspan="2" class="align-middle bg-dark text-white" style="text-align: left;">Materia</th>
                        <th colspan="3" class="th-bim">1er Bimestre</th>
                        <th colspan="3" class="th-bim">2do Bimestre</th>
                        <th colspan="3" class="th-bim">3er Bimestre</th>
                        <th colspan="3" class="th-bim">4to Bimestre</th>
                        <th rowspan="2" class="align-middle bg-dark text-white">Nota Parcial</th>
                        <th rowspan="2" class="align-middle bg-dark text-white">Total Anual</th>
                        <th rowspan="2" class="align-middle bg-dark text-white">Literal</th>
                        <th rowspan="2" class="align-middle bg-dark text-white">Estado</th>
                    </tr>
                    <tr class="th-sub">
                        <th>Teórico</th>
                        <th>Práctica</th>
                        <th>Nota</th>
                        <th>Teórico</th>
                        <th>Práctica</th>
                        <th>Nota</th>
                        <th>Teórico</th>
                        <th>Práctica</th>
                        <th>Nota</th>
                        <th>Teórico</th>
                        <th>Práctica</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($temp_inscripciones)): ?>
                        <?php foreach ($temp_inscripciones as $i):
                            $estado_materia = strtoupper(trim($i['estado'] ?? 'EN PROCESO'));
                            $nota_parcial = $i['nota_parcial'] ?? null;
                            $total_anual = $i['nota_final'] ?? null;
                            $es_segundo_turno = isset($i['segundo_turno']) && $i['segundo_turno'] == 1;
                            $literal = $i['literal'] ?? null;
                        ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($i['asig_codigo'] ?? '-') ?></strong></td>
                                <td style="text-align: left;"><?= htmlspecialchars($i['asig_nombre'] ?? '-') ?></td>

                                <td><?= verNota($i['nota_teorico1']) ?></td>
                                <td><?= verNota($i['nota_pract1']) ?></td>
                                <td class="table-danger"><strong><?= verNota($i['nota_primerbim']) ?></strong></td>

                                <td><?= verNota($i['nota_teorico2']) ?></td>
                                <td><?= verNota($i['nota_pract2']) ?></td>
                                <td class="table-danger"><strong><?= verNota($i['nota_segundobim']) ?></strong></td>

                                <td><?= verNota($i['nota_teorico3']) ?></td>
                                <td><?= verNota($i['nota_pract3']) ?></td>
                                <td class="table-danger"><strong><?= verNota($i['nota_tercerbim']) ?></strong></td>

                                <td><?= verNota($i['nota_teorico4']) ?></td>
                                <td><?= verNota($i['nota_pract4']) ?></td>
                                <td class="table-danger"><strong><?= verNota($i['nota_cuartobim']) ?></strong></td>

                                <td class="fw-bold text-primary"><?= verNota($nota_parcial) ?></td>

                                <td class="fs-6 fw-bold <?= ($total_anual !== null && (float)$total_anual < 51 && !$es_segundo_turno) ? 'text-danger' : 'text-danger' ?>">
                                    <?= verNota($total_anual) ?>
                                </td>

                                <td class="fw-bold text-dark"><?= verNota($literal) ?></td>

                                <td>
                                    <?php if ($estado_materia === 'APROBADO'): ?>
                                        <span class="badge-aprobado">Aprobado</span>
                                    <?php elseif ($estado_materia === 'REPROBADO' && $es_segundo_turno): ?>
                                        <span class="badge-2doturno">2do Turno</span>
                                    <?php elseif ($estado_materia === 'REPROBADO'): ?>
                                        <span class="badge-reprobado">Reprobado</span>
                                    <?php else: ?>
                                        <span class="badge-proceso">En Proceso</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="18" class="text-center p-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                No se encontraron inscripciones o notas registradas<?= $gestion_seleccionada ? ' para la gestión ' . htmlspecialchars($gestion_seleccionada) : '' ?>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- LÍNEA DE ESTADO ACADÉMICO FINAL -->
        <div class="estado-final-box <?= $estado_final_clase ?>">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill fs-3 me-3"></i>
                <div>
                    <div class="fs-5 mb-1">Estado Académico: <span class="<?= $estado_final_badge ?>" style="padding: 4px 10px; border-radius: 4px; color: white; font-size: 0.9rem;"><?= $estado_final_titulo ?></span></div>
                    <div class="fs-6 fw-normal"><?= $estado_final_texto ?></div>
                    <div class="fs-6 fw-normal mt-1">
                        Resumen: <?= $total_materias ?> materias totales | <?= $aprobadas ?> aprobadas | <?= $reprobadas ?> reprobadas | <?= $en_proceso ?> en proceso.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'views/footer.php'; ?>