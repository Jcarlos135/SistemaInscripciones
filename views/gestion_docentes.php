<?php include 'views/header.php'; ?>
<link rel="stylesheet" href="/sig/public/css/gestion_docentes.css">
<h2 class="mb-4"><i class="bi bi-person-workspace"></i> Gestión de Plantel Docente</h2>

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="alert alert-<?= $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show shadow-sm">
        <i class="bi bi-info-circle"></i> <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

<!-- Botón Volver al Panel Admin (encima de todo) -->
<div class="mb-3 d-flex justify-content-end">
    <a href="index.php?action=admin_dashboard&tab=docentes" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>
<div class="row g-4">

    <!-- COLUMNA IZQUIERDA: FORMULARIOS -->
    <div class="col-lg-4">

        <!-- Formulario de Registro -->
        <div class="card card-verde mb-4">
            <div class="card-header card-header-verde">
                <h5 class="mb-0"><i class="bi bi-person-plus-fill"></i> Registrar Nuevo Docente</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=guardar_docente" method="POST">s
                    <div class="mb-3">
                        <label class="form-label fw-bold">Carnet (CI)</label>
                        <input type="text" class="form-control" name="ci" required maxlength="15" placeholder="Ej: 5550001">
                        <small class="text-muted">Será también su usuario y contraseña inicial.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombres</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Apellido Paterno</label>
                            <input type="text" class="form-control" name="ap_pat" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Apellido Materno</label>
                            <input type="text" class="form-control" name="ap_mat">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Género</label>
                        <select class="form-select" name="genero" required>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Celular</label>
                        <input type="text" class="form-control" name="cel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-verde w-100">
                        <i class="bi bi-save"></i> Guardar Docente
                    </button>
                </form>
            </div>
        </div>

        <!-- Formulario de Asignación 
        <div class="card card-verde">
            <div class="card-header card-header-negro">
                <h5 class="mb-0"><i class="bi bi-journal-bookmark-fill"></i> Asignar Materia</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=asignar_materia_docente" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Docente</label>
                        <select class="form-select" name="id_docente" required>
                            <option value="">-- Seleccione --</option>
                            <?php
                            $docentes = listar_docentes($conn);
                            while ($d = mysqli_fetch_assoc($docentes)):
                            ?>
                                <option value="<?= $d['id_docente'] ?>">
                                    <?= htmlspecialchars($d['nombre'] . ' ' . $d['ap_pat']) ?> (CI: <?= $d['ci'] ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Materia</label>
                        <select class="form-select" name="cod_asig" required>
                            <option value="">-- Seleccione --</option>
                            <?php
                            $materias = mysqli_query($conn, "SELECT codigo, nombre FROM asignatura WHERE activo = 1 ORDER BY nombre");
                            while ($m = mysqli_fetch_assoc($materias)):
                            ?>
                                <option value="<?= $m['codigo'] ?>">
                                    <?= htmlspecialchars($m['codigo'] . ' - ' . $m['nombre']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-negro w-100">
                        <i class="bi bi-link-45deg"></i> Asignar Materia
                    </button>
                </form>
                <div class="alert alert-info mt-3 mb-0 small">
                    <i class="bi bi-info-circle"></i> Asigna al docente a todas las inscripciones de estudiantes en esa materia que estén pendientes.
                </div>
            </div>
        </div>  -->

    </div>

    <!-- COLUMNA DERECHA: LISTADO -->
    <div class="col-lg-8">
        <div class="card card-verde">
            <div class="card-header card-header-verde d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people"></i> Plantel Docente Registrado</h5>
                <span class="badge bg-light text-dark"><?= mysqli_num_rows(listar_docentes($conn)) ?> Docentes</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-header-negro">
                        <thead>
                            <tr>
                                <th class="ps-4">CI</th>
                                <th>Nombre Completo</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th class="text-center pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lista_docentes = listar_docentes($conn);
                            if (mysqli_num_rows($lista_docentes) > 0):
                                while ($doc = mysqli_fetch_assoc($lista_docentes)):
                            ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?= htmlspecialchars($doc['ci']) ?></td>
                                        <td><?= htmlspecialchars($doc['nombre'] . ' ' . $doc['ap_pat'] . ' ' . $doc['ap_mat']) ?></td>
                                        <td><?= htmlspecialchars($doc['cel']) ?></td>
                                        <td><?= htmlspecialchars($doc['email']) ?></td>
                                        <td class="text-end">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <!-- Botón Materias -->
                                                <a href="index.php?action=ver_materias_docente&id_docente=<?= $doc['id_docente'] ?>"
                                                    class="btn btn-info btn-sm text-white">
                                                    <i class="bi bi-journal-bookmark-fill"></i> Materias
                                                </a>

                                                <!-- Botón Dar de baja -->
                                                <a href="index.php?action=dar_baja_docente&id_docente=<?= $doc['id_docente'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Está seguro de realizar esta acción?');">
                                                    <i class="bi bi-trash-fill"></i> Dar de baja
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox" style="font-size: 2.5rem;"></i><br>
                                        No hay docentes registrados en el sistema.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'views/footer.php'; ?>