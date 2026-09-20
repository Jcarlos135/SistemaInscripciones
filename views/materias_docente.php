<?php include 'header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

    <div>
        <h3 class="mb-1"><i class="bi bi-journal-bookmark-fill"></i> Materias del Docente</h3>
        <h5 class="text-muted mb-0">
            <?php echo htmlspecialchars($docente_info['nombre'] . ' ' . $docente_info['ap_pat'] . ' ' . ($docente_info['ap_mat'] ?? '')); ?>
            <span class="badge bg-secondary">CI: <?php echo htmlspecialchars($docente_info['ci']); ?></span>
        </h5>
    </div>
    <a href="index.php?action=gestion_docentes" class="btn btn-negro">
        <i class="bi bi-arrow-left"></i> Volver a Gestión de Docentes
    </a>
</div>

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="alert alert-<?php echo $_SESSION['alerta']['tipo'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
        <?php echo htmlspecialchars($_SESSION['alerta']['msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

<div class="row g-4">
    <!-- MATERIAS ASIGNADAS -->
    <div class="col-lg-8">
        <div class="card card-verde h-100">
            <div class="card-header card-header-verde">
                <i class="bi bi-collection-fill"></i> Materias Asignadas (<?php echo count($materias_asignadas); ?>)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 table-header-negro">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Asignatura</th>
                                <th>Nivel</th>
                                <th>Estudiantes</th>
                                <th style="width: 110px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($materias_asignadas)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle"></i> Este docente no tiene materias asignadas.
                                </td></tr>
                            <?php else: ?>
                                <?php foreach ($materias_asignadas as $mat): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($mat['codigo']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($mat['nombre']); ?></td>
                                        <td><span class="badge bg-dark"><?php echo htmlspecialchars($mat['nivel']); ?></span></td>
                                        <td><?php echo (int)$mat['estudiantes']; ?></td>
                                        <td>
                                            <form method="POST" action="index.php?action=quitar_materia_docente"
                                                  onsubmit="return confirmarQuitar('<?php echo htmlspecialchars($mat['nombre'], ENT_QUOTES); ?>');">
                                                <input type="hidden" name="id_docente" value="<?php echo (int)$id_docente; ?>">
                                                <input type="hidden" name="cod_asig" value="<?php echo htmlspecialchars($mat['codigo']); ?>">
                                                <button type="submit" class="btn btn-action-eliminar btn-sm">
                                                    <i class="bi bi-x-circle"></i> Quitar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ASIGNAR NUEVA MATERIA -->
    <div class="col-lg-4">
        <div class="card card-verde h-100">
            <div class="card-header card-header-verde">
                <i class="bi bi-plus-circle-fill"></i> Asignar Nueva Materia
            </div>
            <div class="card-body">
                <?php if (empty($materias_disponibles)): ?>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> No quedan materias disponibles para asignar.
                    </div>
                <?php else: ?>
                    <form method="POST" action="index.php?action=asignar_materia_docente">
                        <input type="hidden" name="id_docente" value="<?php echo (int)$id_docente; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Asignatura:</label>
                            <select name="cod_asig" class="form-select" required>
                                <option value="" disabled selected>-- Seleccione una materia --</option>
                                <?php foreach ($materias_disponibles as $mat): ?>
                                    <option value="<?php echo htmlspecialchars($mat['codigo']); ?>">
                                        <?php echo htmlspecialchars($mat['codigo'] . ' - ' . $mat['nombre'] . ' (Nivel ' . $mat['nivel'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-verde w-100">
                            <i class="bi bi-check2-circle"></i> Asignar Materia
                        </button>
                    </form>
                    <hr>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-lightbulb"></i> Al asignar, el docente tomará los registros de calificaciones pendientes de esa materia y se crearán los necesarios para los estudiantes inscritos.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarQuitar(nombreMateria) {
    return confirm('¿Quitar la materia "' + nombreMateria + '" de este docente?\n\nLas notas ya registradas NO se eliminan, solo quedan sin docente asignado.');
}
</script>

<?php include 'footer.php'; ?>