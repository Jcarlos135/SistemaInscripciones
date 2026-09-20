<?php include 'views/header.php'; ?>

<style> 
.btn-danger {
    background: linear-gradient(135deg, #059d3b, #022818);
    border: none;
    color: #fff;
    font-weight: 600;
    
}

.btn-danger:hover {
    background: rgba(5, 157, 59, 0.15);
    border: 1px solid #059d3b;
    color: #03461aff;
    box-shadow: 0 8px 20px rgba(5, 157, 59, 0.25);
}

.btn-info {
    background: linear-gradient(135deg, #059d3b, #022818);
    border: none;
    color: #fff;
    font-weight: 600;
    
}

.btn-info:hover {
    background: rgba(5, 157, 59, 0.15);
    border: 1px solid #059d3b;
    color: #035520ff;
    box-shadow: 0 8px 20px rgba(5, 157, 59, 0.25);
}
</style>


<h2 class="mb-4" style="color: #212529; font-weight: 700; border-bottom: 3px solid #198754; padding-bottom: 10px;">Panel de Administrador</h2>

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="alert alert-<?= $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show" style="border-left: 4px solid #198754;">
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
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= $tab_activo == 'resumen' ? 'active' : '' ?>" 
           href="index.php?action=admin_dashboard&tab=resumen">Resumen General</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= $tab_activo == 'estudiantes' ? 'active' : '' ?>" 
           href="index.php?action=admin_dashboard&tab=estudiantes">Gestión de Estudiantes</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= $tab_activo == 'usuarios' ? 'active' : '' ?>" 
           href="index.php?action=admin_dashboard&tab=usuarios">Gestión de Usuarios</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= $tab_activo == 'carreras' ? 'active' : '' ?>" 
           href="index.php?action=admin_dashboard&tab=carreras">Gestión de Carreras</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= $tab_activo == 'reportes' ? 'active' : '' ?>" 
           href="index.php?action=admin_dashboard&tab=reportes">Reportes e Informes</a>
    </li>
</ul>

<!-- TAB 1: RESUMEN GENERAL -->
<?php if ($tab_activo == 'resumen'): ?>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Estudiantes Activos</h6>
                    <h2 class="mb-0 fw-bold" style="color: #198754;"><?= $stats['estudiantes_activos'] ?></h2>
                    <small class="text-muted"><?= $stats['estudiantes_inactivos'] ?> inactivos</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Carreras Activas</h6>
                    <h2 class="mb-0 fw-bold" style="color: #198754;"><?= $stats['carreras_activas'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Materias Disponibles</h6>
                    <h2 class="mb-0 fw-bold" style="color: #198754;"><?= $stats['materias_activas'] ?></h2>
                </div>
            </div>
        </div>

            <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Estudiantes Inscritos</h6>
                    <h2 class="mb-0 fw-bold" style="color: #198754;"><?= $stats['estudiantes_inscritos'] ?></h2>
                    <small class="text-muted"><?= $stats['total_inscripciones'] ?> materias inscritas en total</small>
                </div>
            </div>
        </div>
                
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h6 class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">Usuarios del Sistema</h6>
                    <h2 class="mb-0 fw-bold" style="color: #198754;"><?= $stats['usuarios_activos'] ?></h2>
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

    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #0d492dff 100%); color: #ffffff;">
            <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?action=admin_dashboard&tab=estudiantes" class="btn btn-outline-success">Gestionar Estudiantes</a>
                <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-success">Gestionar Usuarios</a>
                <a href="index.php?action=admin_dashboard&tab=carreras" class="btn btn-outline-success">Gestionar Carreras</a>
                <a href="index.php?action=admin_dashboard&tab=reportes" class="btn btn-outline-success">Generar Reportes</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- TAB 2: GESTIÓN DE ESTUDIANTES -->
<?php if ($tab_activo == 'estudiantes'): ?>
    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: #ffffff;">
            <h5 class="mb-0">Todos los Estudiantes (Activos e Inactivos)</h5>
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
                                        <span class="badge bg-danger">INACTIVO</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="index.php?action=admin_ver_materias&ci=<?= $e['ci'] ?>" 
                                           class="btn btn-sm btn-info ">Ver Materias</a>
                                        
                                        <?php if ($e['activo'] == 1): ?>
                                            <a href="index.php?action=admin_desactivar_estudiante&ci=<?= $e['ci'] ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('¿Desactivar a este estudiante? (Borrado Lógico)')">
                                                Desactivar
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?action=admin_activar_estudiante&ci=<?= $e['ci'] ?>" 
                                               class="btn btn-sm btn-success"
                                               onclick="return confirm('¿Reactivar a este estudiante?')">
                                                Reactivar
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
<div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #0d492dff 100%); color: #ffffff;">
            <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?action=admin_dashboard&tab=estudiantes" class="btn btn-outline-success">Gestionar Estudiantes</a>
                <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-success">Gestionar Usuarios</a>
                <a href="index.php?action=admin_dashboard&tab=carreras" class="btn btn-outline-success">Gestionar Carreras</a>
                <a href="index.php?action=admin_dashboard&tab=reportes" class="btn btn-outline-success">Generar Reportes</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- TAB 3: GESTIÓN DE USUARIOS -->
<?php if ($tab_activo == 'usuarios'): ?>
    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: #ffffff;">
            <h5 class="mb-0">Usuarios del Sistema (Admin, Secretaria, Estudiantes, Docente)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead style="background-color: #212529; color: #ffffff;">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Rol Actual</th>
                            <th>Estado</th>
                            <th class="text-center">Cambiar Rol</th>
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
                                        <span class="badge bg-danger">INACTIVO</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="index.php?action=admin_cambiar_rol" method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="id_usuario" value="<?= $u['id'] ?>">
                                        <select name="nuevo_rol" class="form-select form-select-sm">
                                            <option value="1" <?= $u['id_rol'] == 1 ? 'selected' : '' ?>>ADMIN</option>
                                            <option value="2" <?= $u['id_rol'] == 2 ? 'selected' : '' ?>>SECRETARIA</option>
                                            <option value="3" <?= $u['id_rol'] == 3 ? 'selected' : '' ?>>ESTUDIANTE</option>
                                            <option value="4" <?= $u['id_rol'] == 4 ? 'selected' : '' ?>>DOCENTE</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success">Cambiar</button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <?php if ($u['activo'] == 1): ?>
                                        <a href="index.php?action=admin_cambiar_estado_usuario&id=<?= $u['id'] ?>&estado=0" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Desactivar este usuario?')">
                                            Desactivar
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?action=admin_cambiar_estado_usuario&id=<?= $u['id'] ?>&estado=1" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirm('¿Reactivar este usuario?')">
                                            Reactivar
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
    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #0d492dff 100%); color: #ffffff;">
            <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?action=admin_dashboard&tab=estudiantes" class="btn btn-outline-success">Gestionar Estudiantes</a>
                <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-success">Gestionar Usuarios</a>
                <a href="index.php?action=admin_dashboard&tab=carreras" class="btn btn-outline-success">Gestionar Carreras</a>
                <a href="index.php?action=admin_dashboard&tab=reportes" class="btn btn-outline-success">Generar Reportes</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- TAB 4: GESTIÓN DE CARRERAS -->
<?php if ($tab_activo == 'carreras'): ?>
    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: #ffffff;">
            <h5 class="mb-0">Carreras del Centro Académico</h5>
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
                                        <span class="badge bg-danger">INACTIVA</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($c['activo'] == 1): ?>
                                        <a href="index.php?action=admin_cambiar_estado_carrera&id=<?= $c['id'] ?>&estado=0" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Desactivar esta carrera y todas sus materias?')">
                                            Desactivar Carrera
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?action=admin_cambiar_estado_carrera&id=<?= $c['id'] ?>&estado=1" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirm('¿Reactivar esta carrera?')">
                                            Reactivar Carrera
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

    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #0d492dff 100%); color: #ffffff;">
            <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?action=admin_dashboard&tab=estudiantes" class="btn btn-outline-success">Gestionar Estudiantes</a>
                <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-success">Gestionar Usuarios</a>
                <a href="index.php?action=admin_dashboard&tab=carreras" class="btn btn-outline-success">Gestionar Carreras</a>
                <a href="index.php?action=admin_dashboard&tab=reportes" class="btn btn-outline-success">Generar Reportes</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- TAB 5: REPORTES E INFORMES -->
<?php if ($tab_activo == 'reportes'): ?>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h5 style="color: #198754; font-weight: 700;">Reporte General del Sistema</h5>
                    <p class="text-muted">Genera un PDF con estadísticas completas: total de estudiantes, carreras, materias, inscripciones y usuarios del sistema.</p>
                    <a href="index.php?action=admin_reporte_general" class="btn btn-outline-success" target="_blank">
                        Generar Reporte General
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h5 style="color: #198754; font-weight: 700;">Reporte por Carrera</h5>
                    <p class="text-muted">Listado completo de estudiantes agrupados por carrera, con su estado (activo/inactivo) y datos de contacto.</p>
                    <a href="index.php?action=admin_reporte_carrera" class="btn btn-outline-success" target="_blank">
                        Generar Reporte por Carrera
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h5 style="color: #198754; font-weight: 700;">Reporte de Inscripciones</h5>
                    <p class="text-muted">Detalle de todas las inscripciones realizadas, agrupadas por estudiante, materia, turno y grupo.</p>
                    <a href="index.php?action=admin_reporte_inscripciones" class="btn btn-outline-success" target="_blank">
                        Generar Reporte de Inscripciones
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm" style="border-top: 3px solid #198754;">
                <div class="card-body">
                    <h5 style="color: #198754; font-weight: 700;">Reporte de Usuarios</h5>
                    <p class="text-muted">Listado completo de todos los usuarios del sistema con sus roles, datos personales y estado.</p>
                    <a href="index.php?action=admin_reporte_usuarios" class="btn btn-outline-success" target="_blank">
                        Generar Reporte de Usuarios
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm" style="border-top: 3px solid #198754;">
        <div class="card-header" style="background: linear-gradient(135deg, #198754 0%, #0d492dff 100%); color: #ffffff;">
            <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?action=admin_dashboard&tab=estudiantes" class="btn btn-outline-success">Gestionar Estudiantes</a>
                <a href="index.php?action=admin_dashboard&tab=usuarios" class="btn btn-outline-success">Gestionar Usuarios</a>
                <a href="index.php?action=admin_dashboard&tab=carreras" class="btn btn-outline-success">Gestionar Carreras</a>
                <a href="index.php?action=admin_dashboard&tab=reportes" class="btn btn-outline-success">Generar Reportes</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'views/footer.php'; ?>