<?php include 'views/header.php'; ?>

<link rel="stylesheet" href="/sig/public/css/admin_dashboard.css">

<style>
    /* Botones institucionales ROJOS */
    .btn-institucional {
        background-color: #8b0000;
        color: #ffffff;
        border: 1px solid #8b0000;
    }

    .btn-institucional:hover,
    .btn-institucional:focus {
        background-color: #5c0000;
        color: #ffffff;
        border-color: #5c0000;
    }

    .btn-outline-institucional {
        color: #8b0000;
        border: 1px solid #8b0000;
        background-color: transparent;
    }

    .btn-outline-institucional:hover {
        background-color: #8b0000;
        color: #ffffff;
    }
</style>

<h2 class="mb-4" style="color: #212529; font-weight: 700; border-bottom: 3px solid #06414d; padding-bottom: 10px;">
    <i class="bi bi-shield-lock-fill"></i> Panel de Administrador
</h2>

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="alert alert-<?= $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show" style="border-left: 4px solid #06414d;">
        <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

<?php
$stats = obtener_estadisticas($conn);
$tab_activo = $_GET['tab'] ?? 'resumen';
?>

<!-- PESTAÑAS DE NAVEGACIÓN -->
<ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'resumen' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=resumen">
            <i class="bi bi-speedometer2"></i> Resumen
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'estudiantes' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=estudiantes">
            <i class="bi bi-people-fill"></i> Estudiantes
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'docentes' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=docentes">
            <i class="bi bi-person-workspace"></i> Gestión Docente
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'usuarios' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=usuarios">
            <i class="bi bi-person-badge-fill"></i> Usuarios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'institucional' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=institucional">
            <i class="bi bi-building-add"></i> Usuario Institucional
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'roles' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=roles">
            <i class="bi bi-shield-fill-check"></i> Roles y Permisos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'carreras' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=carreras">
            <i class="bi bi-mortarboard-fill"></i> Carreras
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $tab_activo == 'reportes' ? 'active' : '' ?>"
            href="index.php?action=admin_dashboard&tab=reportes">
            <i class="bi bi-file-earmark-pdf"></i> Reportes
        </a>
    </li>
</ul>
<!-- =====================================================
     TAB 1: RESUMEN
     ===================================================== -->
<?php if ($tab_activo == 'resumen'): ?>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Estudiantes Activos</h6>
                    <h2 class="mb-0 fw-bold" style="color: #06414d;"><?= $stats['estudiantes_activos'] ?></h2>
                    <small class="text-muted"><?= $stats['estudiantes_inactivos'] ?> inactivos</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Carreras Activas</h6>
                    <h2 class="mb-0 fw-bold" style="color: #06414d;"><?= $stats['carreras_activas'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Materias Disponibles</h6>
                    <h2 class="mb-0 fw-bold" style="color: #06414d;"><?= $stats['materias_activas'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Estudiantes Inscritos</h6>
                    <h2 class="mb-0 fw-bold" style="color: #06414d;"><?= $stats['estudiantes_inscritos'] ?></h2>
                    <small class="text-muted"><?= $stats['total_inscripciones'] ?> materias inscritas</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Usuarios del Sistema</h6>
                    <h2 class="mb-0 fw-bold" style="color: #06414d;"><?= $stats['usuarios_activos'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #dc3545;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Estudiantes Inactivos</h6>
                    <h2 class="mb-0 fw-bold" style="color: #dc3545;"><?= $stats['estudiantes_inactivos'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
        <div class="card-header" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
            <h5 class="mb-0"><i class="bi bi-lightning-fill"></i> Accesos Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="index.php?action=admin_dashboard&tab=estudiantes" class="btn btn-outline-institucional w-100 py-3">
                        <i class="bi bi-people-fill fs-3 d-block mb-1"></i>
                        Estudiantes
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-institucional w-100 py-3">
                        <i class="bi bi-person-badge-fill fs-3 d-block mb-1"></i>
                        Usuarios
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?action=admin_dashboard&tab=roles" class="btn btn-outline-institucional w-100 py-3">
                        <i class="bi bi-shield-fill-check fs-3 d-block mb-1"></i>
                        Roles y Permisos
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?action=admin_dashboard&tab=reportes" class="btn btn-outline-institucional w-100 py-3">
                        <i class="bi bi-file-earmark-pdf fs-3 d-block mb-1"></i>
                        Reportes
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- =====================================================
     TAB 2: GESTIÓN DE ESTUDIANTES
     ===================================================== -->
<?php if ($tab_activo == 'estudiantes'): ?>
    <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
            <h5 class="mb-0"><i class="bi bi-people-fill"></i> Todos los Estudiantes</h5>
            <a href="index.php?action=admin_nuevo_estudiante" class="btn btn-sm btn-light">Nuevo Estudiante</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead style="background-color: #212529; color: #ffffff;">
                        <tr>
                            <th>CI</th>
                            <th>Nombre Completo</th>
                            <th>Carrera</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT e.*, c.nombre as carrera_nombre FROM estudiante e 
                                  INNER JOIN carrera c ON e.id_carrera = c.id 
                                  ORDER BY e.activo DESC, e.ap_pat";
                        $resultado = mysqli_query($conn, $query);
                        while ($e = mysqli_fetch_assoc($resultado)):
                            $fila_clase = ($e['activo'] == 0) ? 'table-light opacity-75' : '';
                        ?>
                            <tr class="<?= $fila_clase ?>">
                                <td><?= htmlspecialchars($e['ci']) ?></td>
                                <td><?= htmlspecialchars($e['nombre'] . ' ' . $e['ap_pat'] . ' ' . $e['ap_mat']) ?></td>
                                <td><?= htmlspecialchars($e['carrera_nombre']) ?></td>
                                <td>
                                    <?php if ($e['activo'] == 1): ?>
                                        <span class="badge bg-success">ACTIVO</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">INACTIVO</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="index.php?action=admin_ver_materias&ci=<?= $e['ci'] ?>" class="btn btn-sm btn-info">Ver Materias</a>
                                        <?php if ($e['activo'] == 1): ?>
                                            <a href="index.php?action=admin_desactivar_estudiante&ci=<?= $e['ci'] ?>"
                                                class="btn btn-sm btn-institucional"
                                                onclick="return confirm('¿Desactivar a este estudiante?')">
                                                <i class="bi bi-lock-fill"></i> Desactivar
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?action=admin_activar_estudiante&ci=<?= $e['ci'] ?>"
                                                class="btn btn-sm btn-institucional"
                                                onclick="return confirm('¿Reactivar a este estudiante?')">
                                                <i class="bi bi-unlock-fill"></i> Reactivar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- =====================================================
     TAB: GESTIÓN DOCENTE
     ===================================================== -->
<?php if ($tab_activo == 'docentes'): ?>

    <?php
    // Cargar lista de docentes
    $q_docentes = "SELECT d.*, r.nombre AS rol_nombre,
                          u.usuario, u.activo AS usuario_activo,
                          (SELECT COUNT(*) FROM asignacion_docente ad WHERE ad.id_docente = d.id_docente) AS total_materias
                   FROM docente d
                   INNER JOIN rol r ON r.id = d.id_rol
                   LEFT JOIN usuario u ON u.usuario = d.ci
                   ORDER BY d.activo DESC, d.ap_pat, d.nombre";
    $r_docentes = mysqli_query($conn, $q_docentes);
    $docentes = [];
    while ($d = mysqli_fetch_assoc($r_docentes)) $docentes[] = $d;

    // Contadores
    $doc_activos = 0;
    $doc_inactivos = 0;
    foreach ($docentes as $d) {
        if ($d['activo'] == 1) $doc_activos++;
        else $doc_inactivos++;
    }
    ?>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">
            <i class="bi bi-person-workspace"></i> Gestión Docente
            <span class="badge bg-success ms-2"><?= $doc_activos ?> activos</span>
            <span class="badge bg-secondary ms-1"><?= $doc_inactivos ?> inactivos</span>
        </h5>
        <div>
            <a href="index.php?action=gestion_docentes" class="btn btn-institucional">
                <i class="bi bi-person-plus-fill"></i> Nuevo Docente
            </a>
            <a href="index.php?action=admin_reporte_docentes" class="btn btn-outline-institucional" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill"></i> Reporte PDF
            </a>
        </div>
    </div>

    <?php if (!empty($docentes)): ?>
        <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
            <div class="card-header" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
                <h5 class="mb-0">Listado Completo de Docentes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead style="background-color: #212529; color: #ffffff;">
                            <tr>
                                <th>CI</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Celular</th>
                                <th class="text-center">Materias</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($docentes as $d): ?>
                                <tr class="<?= $d['activo'] == 0 ? 'table-light opacity-75' : '' ?>">
                                    <td><strong><?= htmlspecialchars($d['ci']) ?></strong></td>
                                    <td>
                                        <?= htmlspecialchars(trim($d['nombre'] . ' ' . $d['ap_pat'] . ' ' . ($d['ap_mat'] ?? ''))) ?>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars($d['email'] ?? '-') ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($d['cel'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= (int)$d['total_materias'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($d['activo'] == 1): ?>
                                            <span class="badge bg-success">ACTIVO</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">INACTIVO</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="index.php?action=ver_materias_docente&id_docente=<?= (int)$d['id_docente'] ?>"
                                                class="btn btn-sm btn-info" title="Ver materias">
                                                <i class="bi bi-book-fill"></i> Materias
                                            </a>
                                            <?php if ($d['activo'] == 1): ?>
                                                <a href="index.php?action=admin_desactivar_docente&id=<?= (int)$d['id_docente'] ?>"
                                                    class="btn btn-sm btn-institucional"
                                                    onclick="return confirm('¿Desactivar a este docente?')">
                                                    <i class="bi bi-lock-fill"></i> Bloquear
                                                </a>
                                            <?php else: ?>
                                                <a href="index.php?action=admin_activar_docente&id=<?= (int)$d['id_docente'] ?>"
                                                    class="btn btn-sm btn-institucional"
                                                    onclick="return confirm('¿Reactivar a este docente?')">
                                                    <i class="bi bi-unlock-fill"></i> Reactivar
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i>
            No hay docentes registrados.
            <a href="index.php?action=gestion_docentes" class="btn btn-sm btn-institucional ms-2">
                <i class="bi bi-person-plus-fill"></i> Registrar el primero
            </a>
        </div>
    <?php endif; ?>

<?php endif; ?>

<!-- =====================================================
     TAB 3: GESTIÓN DE USUARIOS (crear, bloquear, modificar, asignar roles)
     ===================================================== -->
<?php if ($tab_activo == 'usuarios'): ?>

    <?php
    $modo_usr = $_GET['modo'] ?? 'lista';
    $id_usuario_edit = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $usuario_editar = null;

    if ($modo_usr === 'editar' && $id_usuario_edit > 0) {
        $q_ed = "SELECT u.*, r.nombre AS rol_nombre FROM usuario u
                 INNER JOIN rol r ON r.id = u.id_rol
                 WHERE u.id = $id_usuario_edit LIMIT 1";
        $usuario_editar = mysqli_fetch_assoc(mysqli_query($conn, $q_ed));
        if (!$usuario_editar) $modo_usr = 'lista';
    }
    ?>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0"><i class="bi bi-person-badge-fill"></i> Gestión de Usuarios</h5>
        <div>
            <?php if ($modo_usr === 'lista'): ?>
                <a href="index.php?action=admin_dashboard&tab=usuarios&modo=nuevo" class="btn btn-institucional">
                    <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
                </a>
            <?php else: ?>
                <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-institucional">
                    <i class="bi bi-x-circle-fill"></i> Cancelar
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- FORMULARIO INLINE: NUEVO / EDITAR USUARIO -->
    <?php if ($modo_usr === 'nuevo' || $modo_usr === 'editar'): ?>
        <div class="card shadow-sm mb-4" style="border-top: 3px solid #8b0000;">
            <div class="card-header" style="background: linear-gradient(135deg, #8b0000 0%, #b41428 100%); color: #ffffff;">
                <h5 class="mb-0">
                    <i class="bi bi-<?= $modo_usr === 'editar' ? 'pencil-square' : 'person-plus-fill' ?>"></i>
                    <?= $modo_usr === 'editar' ? 'Editar Usuario' : 'Registrar Nuevo Usuario' ?>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?action=<?= $modo_usr === 'editar' ? 'admin_actualizar_usuario' : 'admin_crear_usuario' ?>">
                    <?php if ($modo_usr === 'editar'): ?>
                        <input type="hidden" name="id_usuario" value="<?= (int)$usuario_editar['id'] ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Usuario (CI o nombre) <span class="text-danger">*</span></label>
                            <input type="text" name="usuario" class="form-control"
                                value="<?= htmlspecialchars($modo_usr === 'editar' ? $usuario_editar['usuario'] : '') ?>"
                                maxlength="30" required>
                            <small class="text-muted">Login único</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Contraseña <?= $modo_usr === 'nuevo' ? '<span class="text-danger">*</span>' : '(dejar vacío para no cambiar)' ?>
                            </label>
                            <input type="text" name="clave" class="form-control"
                                value="<?= $modo_usr === 'nuevo' ? '123456' : '' ?>"
                                <?= $modo_usr === 'nuevo' ? 'required' : '' ?>>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Rol <span class="text-danger">*</span></label>
                            <select name="id_rol" class="form-select" required>
                                <option value="">-- Seleccionar --</option>
                                <?php
                                $r_roles = mysqli_query($conn, "SELECT id, nombre, descripcion FROM rol WHERE activo = 1 ORDER BY id");
                                while ($rol_op = mysqli_fetch_assoc($r_roles)):
                                ?>
                                    <option value="<?= $rol_op['id'] ?>"
                                        <?= ($modo_usr === 'editar' && $usuario_editar['id_rol'] == $rol_op['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($rol_op['nombre']) ?> — <?= htmlspecialchars(substr($rol_op['descripcion'] ?? '', 0, 50)) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold d-block">Estado</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="activo" value="1"
                                    id="chkActivoUsr"
                                    <?= ($modo_usr !== 'editar' || $usuario_editar['activo'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="chkActivoUsr">Activo</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-institucional">
                            <i class="bi bi-save"></i>
                            <?= $modo_usr === 'editar' ? 'Actualizar' : 'Crear' ?> Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- LISTADO DE USUARIOS -->
    <?php if ($modo_usr === 'lista'): ?>
        <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
            <div class="card-header" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
                <h5 class="mb-0">Usuarios del Sistema</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead style="background-color: #212529; color: #ffffff;">
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $usuarios = listar_usuarios($conn);
                            while ($u = mysqli_fetch_assoc($usuarios)):
                                $fila_clase = ($u['activo'] == 0) ? 'table-light opacity-75' : '';
                            ?>
                                <tr class="<?= $fila_clase ?>">
                                    <td><?= $u['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($u['usuario']) ?></strong></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($u['rol_nombre']) ?></span>
                                    </td>
                                    <td>
                                        <?php if ($u['activo'] == 1): ?>
                                            <span class="badge bg-success">ACTIVO</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">INACTIVO</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="index.php?action=admin_dashboard&tab=usuarios&modo=editar&id=<?= $u['id'] ?>"
                                                class="btn btn-sm btn-outline-institucional" title="Editar">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>

                                            <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                                                <?php if ($u['activo'] == 1): ?>
                                                    <a href="index.php?action=admin_cambiar_estado_usuario&id=<?= $u['id'] ?>&estado=0"
                                                        class="btn btn-sm btn-institucional"
                                                        onclick="return confirm('¿Bloquear este usuario?')">
                                                        <i class="bi bi-lock-fill"></i> Bloquear
                                                    </a>
                                                <?php else: ?>
                                                    <a href="index.php?action=admin_cambiar_estado_usuario&id=<?= $u['id'] ?>&estado=1"
                                                        class="btn btn-sm btn-institucional"
                                                        onclick="return confirm('¿Reactivar este usuario?')">
                                                        <i class="bi bi-unlock-fill"></i> Reactivar
                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge bg-info text-dark"><i class="bi bi-person-fill"></i> Tú</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>

<!-- =====================================================
     TAB 4: USUARIO INSTITUCIONAL
     ===================================================== -->
<?php if ($tab_activo == 'institucional'): ?>

    <?php
    // $usuarios_institucionales = ['5550012', '5550013', '5550014', '5550015', 'secretaria', 'admin'];
    $usuarios_institucionales = ['5550012', '5550013', '5550014',  'secretaria', 'admin'];
    $lista_sql = "'" . implode("','", $usuarios_institucionales) . "'";
    ?>

    <div class="alert alert-info" style="border-left: 4px solid #06414d;">
        <i class="bi bi-info-circle-fill"></i>
        <strong>Usuario Institucional:</strong> crea cuentas para personal directivo y administrativo
        (Admin, Secretaria, Dirección Académica, Rector, Jefe de Carrera, Super Admin)
        directamente, sin pasar por el módulo de docentes.
    </div>

    <?php
    $modo_inst = $_GET['modo'] ?? 'lista';
    $id_inst_edit = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $inst_editar = null;

    if ($modo_inst === 'editar' && $id_inst_edit > 0) {
        $q_ed = "SELECT u.*, r.nombre AS rol_nombre FROM usuario u
                 INNER JOIN rol r ON r.id = u.id_rol
                 WHERE u.id = $id_inst_edit 
                   AND u.usuario IN ($lista_sql)
                 LIMIT 1";
        $inst_editar = mysqli_fetch_assoc(mysqli_query($conn, $q_ed));
        if (!$inst_editar) $modo_inst = 'lista';
    }
    ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="bi bi-building-add"></i> Usuarios Institucionales</h5>
        <div>
            <?php if ($modo_inst === 'lista'): ?>
                <a href="index.php?action=admin_dashboard&tab=institucional&modo=nuevo" class="btn btn-institucional">
                    <i class="bi bi-plus-circle-fill"></i> Nuevo Usuario Institucional
                </a>
            <?php else: ?>
                <a href="index.php?action=admin_dashboard&tab=institucional" class="btn btn-outline-institucional">
                    <i class="bi bi-x-circle-fill"></i> Cancelar
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- FORMULARIO INLINE: NUEVO / EDITAR USUARIO INSTITUCIONAL -->
    <?php if ($modo_inst === 'nuevo' || $modo_inst === 'editar'): ?>
        <div class="card shadow-sm mb-4" style="border-top: 3px solid #8b0000;">
            <div class="card-header" style="background: linear-gradient(135deg, #8b0000 0%, #b41428 100%); color: #ffffff;">
                <h5 class="mb-0">
                    <i class="bi bi-<?= $modo_inst === 'editar' ? 'pencil-square' : 'building-add' ?>"></i>
                    <?= $modo_inst === 'editar' ? 'Editar Usuario Institucional' : 'Registrar Usuario Institucional' ?>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?action=<?= $modo_inst === 'editar' ? 'admin_actualizar_usuario_institucional' : 'admin_crear_usuario_institucional' ?>">
                    <?php if ($modo_inst === 'editar'): ?>
                        <input type="hidden" name="id_usuario" value="<?= (int)$inst_editar['id'] ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Usuario <span class="text-danger">*</span></label>
                            <input type="text" name="usuario" class="form-control"
                                value="<?= htmlspecialchars($modo_inst === 'editar' ? $inst_editar['usuario'] : '') ?>"
                                placeholder="Ej: direccion2, rector2"
                                maxlength="30" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Contraseña <?= $modo_inst === 'nuevo' ? '<span class="text-danger">*</span>' : '(dejar vacío para no cambiar)' ?>
                            </label>
                            <input type="text" name="clave" class="form-control"
                                value="<?= $modo_inst === 'nuevo' ? '123456' : '' ?>"
                                <?= $modo_inst === 'nuevo' ? 'required' : '' ?>>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Rol Institucional <span class="text-danger">*</span></label>
                            <select name="id_rol" class="form-select" required>
                                <option value="">-- Seleccionar --</option>
                                <option value="1" <?= ($modo_inst === 'editar' && $inst_editar['id_rol'] == 1) ? 'selected' : '' ?>>
                                    ADMIN
                                </option>
                                <option value="2" <?= ($modo_inst === 'editar' && $inst_editar['id_rol'] == 2) ? 'selected' : '' ?>>
                                    SECRETARIA
                                </option>
                                <option value="5" <?= ($modo_inst === 'editar' && $inst_editar['id_rol'] == 5) ? 'selected' : '' ?>>
                                    DIRECCIÓN ACADÉMICA
                                </option>
                                <option value="6" <?= ($modo_inst === 'editar' && $inst_editar['id_rol'] == 6) ? 'selected' : '' ?>>
                                    RECTOR
                                </option>
                                <option value="7" <?= ($modo_inst === 'editar' && $inst_editar['id_rol'] == 7) ? 'selected' : '' ?>>
                                    JEFE DE CARRERA
                                </option>
                                <option value="8" <?= ($modo_inst === 'editar' && $inst_editar['id_rol'] == 8) ? 'selected' : '' ?>>
                                    SUPER ADMIN
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold d-block">Estado</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="activo" value="1"
                                    id="chkActivoInst"
                                    <?= ($modo_inst !== 'editar' || $inst_editar['activo'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="chkActivoInst">Activo</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light mt-3 mb-0" style="border-left: 4px solid #06414d;">
                        <small>
                            <i class="bi bi-info-circle"></i>
                            <strong>Nota:</strong> Los usuarios institucionales NO aparecen en la tabla de docentes.
                            Solo acceden al sistema con su rol correspondiente.
                        </small>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php?action=admin_dashboard&tab=institucional" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-institucional">
                            <i class="bi bi-save"></i>
                            <?= $modo_inst === 'editar' ? 'Actualizar' : 'Crear' ?> Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- LISTADO -->
    <?php if ($modo_inst === 'lista'): ?>
        <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
            <div class="card-header" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
                <h5 class="mb-0">Usuarios Institucionales Registrados</h5>
            </div>
            <div class="card-body">
                <?php
                $q_inst = "SELECT u.*, r.nombre AS rol_nombre 
                           FROM usuario u
                           INNER JOIN rol r ON r.id = u.id_rol
                           WHERE u.usuario IN ($lista_sql)
                           ORDER BY u.id_rol, u.usuario";
                $r_inst = mysqli_query($conn, $q_inst);
                ?>
                <?php if (mysqli_num_rows($r_inst) > 0): ?>
                    <table class="table table-striped table-hover align-middle">
                        <thead style="background-color: #212529; color: #ffffff;">
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Rol Institucional</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($inst = mysqli_fetch_assoc($r_inst)): ?>
                                <tr class="<?= $inst['activo'] == 0 ? 'table-light opacity-75' : '' ?>">
                                    <td><?= $inst['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($inst['usuario']) ?></strong></td>
                                    <td>
                                        <?php
                                        $colores_rol = [
                                            1 => '#8b0000',
                                            2 => '#0d6efd',
                                            5 => '#06414d',
                                            6 => '#b41428',
                                            7 => '#146c43',
                                            8 => '#000000'
                                        ];
                                        $color = $colores_rol[$inst['id_rol']] ?? '#6c757d';
                                        ?>
                                        <span class="badge" style="background-color: <?= $color ?>;">
                                            <?= htmlspecialchars($inst['rol_nombre']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($inst['activo'] == 1): ?>
                                            <span class="badge bg-success">ACTIVO</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">INACTIVO</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="index.php?action=admin_dashboard&tab=institucional&modo=editar&id=<?= $inst['id'] ?>"
                                            class="btn btn-sm btn-outline-institucional">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <?php if ($inst['id'] != $_SESSION['usuario_id']): ?>
                                            <?php if ($inst['activo'] == 1): ?>
                                                <a href="index.php?action=admin_cambiar_estado_usuario&id=<?= $inst['id'] ?>&estado=0&redirect=institucional"
                                                    class="btn btn-sm btn-institucional"
                                                    onclick="return confirm('¿Bloquear este usuario institucional?')">
                                                    <i class="bi bi-lock-fill"></i> Bloquear
                                                </a>
                                            <?php else: ?>
                                                <a href="index.php?action=admin_cambiar_estado_usuario&id=<?= $inst['id'] ?>&estado=1&redirect=institucional"
                                                    class="btn btn-sm btn-institucional"
                                                    onclick="return confirm('¿Reactivar este usuario?')">
                                                    <i class="bi bi-unlock-fill"></i> Reactivar
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark">
                                                <i class="bi bi-person-fill"></i> Tú
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        No hay usuarios institucionales registrados. Crea el primero con el botón de arriba.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>

<!-- =====================================================
     TAB 5: ROLES Y PERMISOS
     ===================================================== -->
<?php if ($tab_activo == 'roles'): ?>

    <?php
    $rol_seleccionado = isset($_GET['rol']) ? (int)$_GET['rol'] : 0;
    ?>

    <div class="row g-4">
        <!-- Lista de roles -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
                <div class="card-header" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
                    <h5 class="mb-0"><i class="bi bi-shield-fill-check"></i> Roles del Sistema</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php
                        $r_roles = mysqli_query($conn, "SELECT r.*, 
                            (SELECT COUNT(*) FROM rol_permiso rp WHERE rp.id_rol = r.id) AS total_permisos,
                            (SELECT COUNT(*) FROM usuario u WHERE u.id_rol = r.id) AS total_usuarios
                            FROM rol r WHERE r.activo = 1 ORDER BY r.id");
                        while ($rol_list = mysqli_fetch_assoc($r_roles)):
                        ?>
                            <a href="index.php?action=admin_dashboard&tab=roles&rol=<?= $rol_list['id'] ?>"
                                class="list-group-item list-group-item-action <?= $rol_seleccionado == $rol_list['id'] ? 'text-white' : '' ?>"
                                style="<?= $rol_seleccionado == $rol_list['id'] ? 'background-color: #8b0000; border-color: #8b0000;' : '' ?>">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?= htmlspecialchars($rol_list['nombre']) ?></strong>
                                        <br>
                                        <small><?= htmlspecialchars(substr($rol_list['descripcion'] ?? '', 0, 60)) ?></small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark d-block mb-1"><?= (int)$rol_list['total_permisos'] ?> permisos</span>
                                        <span class="badge bg-secondary"><?= (int)$rol_list['total_usuarios'] ?> usuarios</span>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permisos del rol seleccionado -->
        <div class="col-md-8">
            <?php if ($rol_seleccionado > 0): ?>
                <?php
                $q_rol_info = "SELECT * FROM rol WHERE id = $rol_seleccionado LIMIT 1";
                $rol_info = mysqli_fetch_assoc(mysqli_query($conn, $q_rol_info));
                ?>

                <div class="card shadow-sm" style="border-top: 3px solid #8b0000;">
                    <div class="card-header" style="background: linear-gradient(135deg, #8b0000 0%, #b41428 100%); color: #ffffff;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-key-fill"></i> Permisos: <strong><?= htmlspecialchars($rol_info['nombre']) ?></strong>
                            </h5>
                            <span class="badge bg-light text-dark">
                                <?= htmlspecialchars(substr($rol_info['descripcion'] ?? '', 0, 50)) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php?action=admin_actualizar_permisos">
                            <input type="hidden" name="id_rol" value="<?= $rol_seleccionado ?>">

                            <?php
                            $q_permisos = "SELECT p.*, 
                                CASE WHEN rp.id_rol IS NOT NULL THEN 1 ELSE 0 END AS asignado
                                FROM permiso p
                                LEFT JOIN rol_permiso rp ON rp.id_permiso = p.id AND rp.id_rol = $rol_seleccionado
                                ORDER BY p.modulo, p.nombre";
                            $r_permisos = mysqli_query($conn, $q_permisos);

                            $permisos_por_modulo = [];
                            while ($perm = mysqli_fetch_assoc($r_permisos)) {
                                $modulo = $perm['modulo'] ?? 'general';
                                $permisos_por_modulo[$modulo][] = $perm;
                            }
                            ?>

                            <?php if (!empty($permisos_por_modulo)): ?>
                                <?php foreach ($permisos_por_modulo as $modulo => $lista): ?>
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-uppercase" style="color: #8b0000; border-bottom: 2px solid #8b0000; padding-bottom: 5px;">
                                            <i class="bi bi-folder-fill"></i> Módulo: <?= htmlspecialchars($modulo) ?>
                                            <span class="badge bg-secondary ms-2"><?= count($lista) ?></span>
                                        </h6>
                                        <div class="row">
                                            <?php foreach ($lista as $perm): ?>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="permisos[]" value="<?= $perm['id'] ?>"
                                                            id="perm<?= $perm['id'] ?>"
                                                            <?= $perm['asignado'] ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="perm<?= $perm['id'] ?>">
                                                            <strong><?= htmlspecialchars($perm['nombre']) ?></strong>
                                                            <br>
                                                            <small class="text-muted"><?= htmlspecialchars($perm['descripcion'] ?? '') ?></small>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="seleccionarTodosPermisos(true)">
                                            <i class="bi bi-check-square-fill"></i> Seleccionar todos
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="seleccionarTodosPermisos(false)">
                                            <i class="bi bi-square"></i> Deseleccionar
                                        </button>
                                    </div>
                                    <button type="submit" class="btn btn-institucional">
                                        <i class="bi bi-save"></i> Guardar Permisos
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    No hay permisos registrados.
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Selecciona un rol</strong> de la lista de la izquierda para ver y administrar sus permisos.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function seleccionarTodosPermisos(estado) {
            document.querySelectorAll('input[name="permisos[]"]').forEach(chk => {
                chk.checked = estado;
            });
        }
    </script>

<?php endif; ?>

<!-- =====================================================
     TAB 6: GESTIÓN DE CARRERAS
     ===================================================== -->
<?php if ($tab_activo == 'carreras'): ?>
    <div class="card shadow-sm" style="border-top: 3px solid #06414d;">
        <div class="card-header" style="background: linear-gradient(135deg, #06414d 0%, #146c43 100%); color: #ffffff;">
            <h5 class="mb-0"><i class="bi bi-mortarboard-fill"></i> Carreras del Centro Académico</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead style="background-color: #212529; color: #ffffff;">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Resolución</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $carreras = listar_todas_carreras($conn);
                        while ($c = mysqli_fetch_assoc($carreras)):
                            $fila_clase = ($c['activo'] == 0) ? 'table-light opacity-75' : '';
                        ?>
                            <tr class="<?= $fila_clase ?>">
                                <td><strong><?= htmlspecialchars($c['id']) ?></strong></td>
                                <td><?= htmlspecialchars($c['nombre']) ?></td>
                                <td><?= htmlspecialchars($c['resolucion']) ?></td>
                                <td><?= $c['duracion'] ?> semestres (<?= $c['anios'] ?> años)</td>
                                <td>
                                    <?php if ($c['activo'] == 1): ?>
                                        <span class="badge bg-success">ACTIVA</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">INACTIVA</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($c['activo'] == 1): ?>
                                        <a href="index.php?action=admin_cambiar_estado_carrera&id=<?= $c['id'] ?>&estado=0"
                                            class="btn btn-sm btn-institucional"
                                            onclick="return confirm('¿Desactivar esta carrera y todas sus materias?')">
                                            <i class="bi bi-lock-fill"></i> Desactivar
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?action=admin_cambiar_estado_carrera&id=<?= $c['id'] ?>&estado=1"
                                            class="btn btn-sm btn-institucional"
                                            onclick="return confirm('¿Reactivar esta carrera?')">
                                            <i class="bi bi-unlock-fill"></i> Reactivar
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- =====================================================
     TAB 7: REPORTES (COMPLETO - 8 reportes)
     ===================================================== -->
<?php if ($tab_activo == 'reportes'): ?>
    <div class="row g-4">

        <!-- 1. Reporte General -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i> Reporte General
                    </h5>
                    <p class="text-muted small">
                        Resumen institucional completo del sistema: estudiantes, docentes, carreras,
                        materias, paralelos, usuarios, inscripciones y permisos.
                    </p>
                    <a href="index.php?action=admin_reporte_general" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. Reporte por Carrera -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-building"></i> Reporte por Carrera
                    </h5>
                    <p class="text-muted small">
                        Resumen de cada carrera con sus totales y listado nominal de estudiantes
                        con datos personales y estado académico.
                    </p>
                    <a href="index.php?action=admin_reporte_carrera" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 3. Reporte de Inscripciones -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-journal-check"></i> Reporte de Inscripciones
                    </h5>
                    <p class="text-muted small">
                        Inscripciones por gestión, estudiante, materia, nivel, turno, grupo y tipo.
                        Incluye resumen por gestión.
                    </p>
                    <a href="index.php?action=admin_reporte_inscripciones" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 4. Reporte de Usuarios -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-person-badge"></i> Reporte de Usuarios
                    </h5>
                    <p class="text-muted small">
                        Usuarios por rol, permisos asignados, usuarios institucionales y listado
                        detallado con nombre y rol.
                    </p>
                    <a href="index.php?action=admin_reporte_usuarios" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 5. Reporte de Permisos -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-shield-lock-fill"></i> Reporte de Permisos
                    </h5>
                    <p class="text-muted small">
                        Matriz completa de roles y permisos. Muestra los 29 permisos del sistema
                        por módulo y a cuántos roles está asignado cada uno.
                    </p>
                    <a href="index.php?action=admin_reporte_permisos" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 6. NUEVO: Reporte de Auditoría -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-clock-history"></i> Reporte de Auditoría
                    </h5>
                    <p class="text-muted small">
                        Registro completo de operaciones del sistema (INSERT, UPDATE, DELETE).
                        Muestra tabla, acción, usuario y fecha de cada movimiento.
                    </p>
                    <a href="index.php?action=admin_reporte_auditoria" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 7. NUEVO: Reporte de Estudiantes -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-people-fill"></i> Reporte de Estudiantes
                    </h5>
                    <p class="text-muted small">
                        Listado completo de estudiantes con datos personales, género, edad,
                        celular, carrera y estado académico.
                    </p>
                    <a href="index.php?action=admin_reporte_estudiantes" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- 8. NUEVO: Reporte de Docentes -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-top: 3px solid #06414d;">
                <div class="card-body">
                    <h5 style="color: #06414d; font-weight: 700;">
                        <i class="bi bi-person-workspace"></i> Reporte de Docentes
                    </h5>
                    <p class="text-muted small">
                        Listado completo de docentes con datos personales, contacto, materias
                        asignadas y estado.
                    </p>
                    <a href="index.php?action=admin_reporte_docentes" class="btn btn-institucional" target="_blank">
                        <i class="bi bi-download"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>

<?php include 'views/footer.php'; ?>