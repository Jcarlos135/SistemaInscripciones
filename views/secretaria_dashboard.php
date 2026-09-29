<?php include 'views/header.php'; ?>


<link rel="stylesheet" href="/sig/public/css/secretaria_dashboard.css">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Gestión de Estudiantes e Inscripciones</h2>

    <a href="index.php?action=reporte_estudiantes" target="_blank" class="btn btn-danger shadow-sm">
        <i class="bi bi-file-earmark-pdf-fill"></i> Reporte General Académico PDF
    </a>
</div>

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="alert alert-<?= $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show">
        <i class="bi bi-info-circle"></i> <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

<!--  NUEVO: Abrir PDF en nueva pestaña si se acaba de registrar un estudiante -->
<?php if (isset($_SESSION['abrir_pdf_ci'])): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div class="flex-grow-1">
                <strong>¡Estudiante registrado exitosamente!</strong><br>
                <small class="text-muted">El registro se completó correctamente. Puedes ver la ficha de inscripción en PDF.</small>
            </div>
            <a href="reports/reporte_registro.php?ci=<?= htmlspecialchars($_SESSION['abrir_pdf_ci']) ?>"
                target="_blank"
                class="btn btn-primary ms-3">
                <i class="bi bi-file-earmark-pdf-fill"></i> Ver Ficha PDF
            </a>
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['abrir_pdf_ci']); ?>
<?php endif; ?>

<!-- SECCIÓN 1: CUADRO DE BÚSQUEDA -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="index.php" method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="action" value="secretaria_dashboard">
            <div class="col-md-7">
                <label class="form-label fw-bold">Buscar Estudiante_ </label>Genera reporte individual: <i class="bi bi-file-earmark-pdf-fill"></i>
                <input type="text" class="form-control" name="busqueda" placeholder="Escribe nombre, apellido o CI..."
                    value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>" data-tipo="alfanumerico">
            </div>
            <div class="col-md-5 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-search"></i> Buscar</button>
                <a href="index.php?action=secretaria_dashboard" class="btn btn-secondary flex-grow-1"><i class="bi bi-x-circle"></i> Limpiar</a>

                <!-- AGREGAR AQUÍ: BOTÓN DE REPORTE SI HAY UNA BÚSQUEDA POR CI -->
                <?php if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])): ?>
                    <a href="index.php?action=reporte_estudiante_gestion&ci=<?= urlencode($_GET['busqueda']) ?>&gestion=2026"
                        target="_blank" class="btn btn-danger flex-grow-1">
                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF CI
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- SECCIÓN 2: FORMULARIO DE REGISTRO/EDICIÓN -->
<?php if (isset($estudiante_editar) || (isset($_GET['nuevo']) && $_GET['nuevo'] == '1')): ?>
    <?php $es_edicion = isset($estudiante_editar); ?>
    <div class="card shadow-sm mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-person-gear"></i> <?= $es_edicion ? 'Editar Estudiante' : 'Registrar Nuevo Estudiante' ?></h5>
        </div>
        <div class="card-body">
            <form action="index.php?action=<?= $es_edicion ? 'secretaria_procesar_editar' : 'registrar_estudiante' ?>" method="POST" enctype="multipart/form-data" novalidate>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Carnet (CI)</label>
                        <input type="text" class="form-control" name="ci" id="ci_input"
                            value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['ci']) : '' ?>"
                            data-tipo="numero" <?= $es_edicion ? 'readonly' : 'required' ?> maxlength="15" autocomplete="off">
                        <small id="ci_mensaje" class="form-text"></small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['nombre']) : '' ?>" data-tipo="texto" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" name="ap_pat" id="ap_pat"
                            value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['ap_pat']) : '' ?>"
                            data-tipo="texto" onblur="validarApellidos()">
                        <div class="form-text">Obligatorio si no hay materno</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" name="ap_mat" id="ap_mat"
                            value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['ap_mat']) : '' ?>"
                            data-tipo="texto" onblur="validarApellidos()">
                        <div class="form-text">Obligatorio si no hay paterno</div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Género</label>
                        <select class="form-select" name="genero" required>
                            <option value="">Seleccione...</option>
                            <option value="M" <?= ($es_edicion && $estudiante_editar['genero'] == 'M') ? 'selected' : '' ?>>Masculino</option>
                            <option value="F" <?= ($es_edicion && $estudiante_editar['genero'] == 'F') ? 'selected' : '' ?>>Femenino</option>
                            <option value="O" <?= ($es_edicion && $estudiante_editar['genero'] == 'O') ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Edad</label>
                        <input type="text" class="form-control" name="edad" value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['edad']) : '' ?>" data-tipo="numero" required maxlength="3">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Celular</label>
                        <input type="text" class="form-control" name="cel" value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['cel']) : '' ?>" data-tipo="numero" required maxlength="15">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Carrera</label>
                        <select class="form-select" name="id_carrera" required>
                            <option value="">Seleccione...</option>
                            <?php
                            $carreras = listar_carreras($conn);
                            while ($c = mysqli_fetch_assoc($carreras)):
                                $selected = ($es_edicion && $estudiante_editar['id_carrera'] == $c['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $c['id'] ?>" <?= $selected ?>><?= htmlspecialchars($c['nombre']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- NUEVO CAMPO: TIPO DE INSCRIPCIÓN -->
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Inscripción</label>
                        <select class="form-select" name="tipo_inscripcion" required>
                            <option value="">Seleccione...</option>
                            <option value="Regular" <?= ($es_edicion && $estudiante_editar['tipo'] == 'Regular') ? 'selected' : '' ?>>Regular (1er Año - Nivel 100)</option>
                            <option value="BTH" <?= ($es_edicion && $estudiante_editar['tipo'] == 'BTH') ? 'selected' : '' ?>>BTH (2do Año - Nivel 200)</option>
                        </select>
                        <div class="form-text">Define el año de inscripción según el tipo.</div>
                    </div>
                    <!-- NUEVOS CAMPOS: TURNO Y PARALELO -->

                    <div class="col-md-4">
                        <label class="form-label "><i class="bi bi-clock"></i> Turno</label>
                        <select class="form-select" name="turno" id="turno_select" required>
                            <option value="">Seleccione...</option>
                            <option value="MAÑANA" <?= ($es_edicion && $estudiante_editar['turno'] == 'MAÑANA') ? 'selected' : '' ?>>MAÑANA</option>
                            <option value="TARDE" <?= ($es_edicion && $estudiante_editar['turno'] == 'TARDE') ? 'selected' : '' ?>>TARDE</option>
                        </select>
                        <div class="form-text">Al seleccionar el turno, el paralelo se asigna automáticamente.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label "><i class="bi bi-people-fill"></i> Paralelo (Grupo)</label>
                        <select class="form-select" name="grupo" id="grupo_select" required>
                            <option value="">Seleccione turno primero...</option>
                            <option value="A" <?= ($es_edicion && $estudiante_editar['grupo'] == 'A') ? 'selected' : '' ?>>A</option>
                            <option value="B" <?= ($es_edicion && $estudiante_editar['grupo'] == 'B') ? 'selected' : '' ?>>B</option>
                        </select>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i>
                            <strong>MAÑANA</strong> → Paralelo <span class="badge bg-primary">A</span> |
                            <strong>TARDE</strong> → Paralelo <span class="badge bg-danger">B</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Fotografía del Estudiante</label>
                        <?php if ($es_edicion && !empty($estudiante_editar['img'])): ?>
                            <div class="mb-2">
                                <img src="<?= htmlspecialchars($estudiante_editar['img']) ?>" alt="Foto actual" style="height: 80px; border-radius: 5px; border: 1px solid #ccc;">
                                <span class="text-muted small ms-2">Imagen actual</span>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="img_actual" value="<?= $es_edicion ? htmlspecialchars($estudiante_editar['img']) : '' ?>">
                        <input type="file" class="form-control" name="img" accept="image/*">
                        <div class="form-text">Dejar en blanco para mantener la imagen actual (solo en edición).</div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-check-circle"></i> <?= $es_edicion ? 'Actualizar Datos' : 'Registrar Estudiante' ?></button>
                        <a href="index.php?action=secretaria_dashboard" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<!-- TABLA 1: MATERIAS DEL ESTUDIANTE -->
<?php if (isset($est_materias)): ?>
    <div class="card shadow-sm mb-4 border-info">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-book"></i> Materias de: <?= htmlspecialchars($est_materias['nombre'] . ' ' . $est_materias['ap_pat']) ?></h5>
            <div>
                <a href="reports/reporte_registro.php?ci=<?= htmlspecialchars($est_materias['ci']) ?>"
                    class="btn btn-sm btn-light me-2"
                    target="_blank"
                    title="Generar PDF de Ficha de Registro">
                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i> Generar PDF
                </a>
                <a href="index.php?action=secretaria_dashboard" class="btn btn-sm btn-light">
                    <i class="bi bi-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nivel</th>
                            <th>Código</th>
                            <th>Materia</th>
                            <th>Fecha Inscripción</th>
                            <th>Turno</th>
                            <th>Paralelo</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($lista_materias) > 0): ?>
                            <?php
                            $nivel_actual = null;
                            while ($m = mysqli_fetch_assoc($lista_materias)):
                                if ($nivel_actual !== $m['asig_nivel']):
                                    $nivel_actual = $m['asig_nivel'];
                                    $nombre_nivel = ($nivel_actual == 100) ? '1er Año (Nivel 100)' : (($nivel_actual == 200) ? '2do Año (Nivel 200)' : (($nivel_actual == 300) ? '3er Año (Nivel 300)' : 'Nivel ' . $nivel_actual));
                                    $color_nivel = ($nivel_actual == 100) ? 'bg-primary' : (($nivel_actual == 200) ? 'bg-danger' : 'bg-warning');
                            ?>
                                    <tr class="<?= $color_nivel ?> text-white">
                                        <td colspan="7" class="text-center fw-bold">
                                            <i class="bi bi-bookmark-fill"></i> <?= $nombre_nivel ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= $m['asig_nivel'] ?></span>
                                    </td>
                                    <td><strong><?= htmlspecialchars($m['asig_codigo']) ?></strong></td>
                                    <td><?= htmlspecialchars($m['asig_nombre']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($m['fecha'])) ?></td>
                                    <td><?= htmlspecialchars($m['turno']) ?></td>
                                    <td><?= htmlspecialchars($m['grupo']) ?></td>
                                    <td>
                                        <?php
                                        $tipo_mat = isset($m['tipo']) ? $m['tipo'] : 'Normal';
                                        $clase_badge = ($tipo_mat == 'Regular') ? 'badge-regular' : (($tipo_mat == 'BTH') ? 'badge-bth' : 'bg-secondary');
                                        ?>
                                        <span class="badge <?= $clase_badge ?> text-white"><?= htmlspecialchars($tipo_mat) ?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Este estudiante no tiene materias inscritas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Resumen de materias por nivel -->
            <?php
            mysqli_data_seek($lista_materias, 0);
            $total_nivel_100 = 0;
            $total_nivel_200 = 0;
            while ($m = mysqli_fetch_assoc($lista_materias)) {
                if ($m['asig_nivel'] == 100) $total_nivel_100++;
                elseif ($m['asig_nivel'] == 200) $total_nivel_200++;
            }
            ?>
            <div class="alert alert-info mt-3">
                <strong><i class="bi bi-bar-chart-fill"></i> Resumen de Inscripción:</strong><br>
                <span class="badge bg-primary">1er Año (Nivel 100): <?= $total_nivel_100 ?> materias</span>
                <span class="badge bg-danger ms-2">2do Año (Nivel 200): <?= $total_nivel_200 ?> materias</span>
                <span class="badge bg-dark ms-2">Total: <?= ($total_nivel_100 + $total_nivel_200) ?> materias</span>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- TABLA 2: LISTADO PRINCIPAL DE ESTUDIANTES -->
<div class="card shadow-sm">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-people"></i> Listado de Estudiantes</h5>
        <a href="index.php?action=secretaria_dashboard&nuevo=1" class="btn btn-sm btn-light">
            <i class="bi bi-person-plus"></i> Nuevo Estudiante
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Foto</th>
                        <th>CI</th>
                        <th>Nombre Completo</th>
                        <th>Carrera</th>
                        <th class="text-center">Tipo</th>
                        <!-- NUEVA COLUMNA: ESTADO ACADÉMICO -->
                        <th class="text-center">Estado Académico</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $texto_busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
                    $resultado_lista = !empty($texto_busqueda) ? buscar_estudiantes($conn, $texto_busqueda) : listar_estudiantes($conn);

                    if (mysqli_num_rows($resultado_lista) > 0):
                        while ($e = mysqli_fetch_assoc($resultado_lista)):

                            if (!empty($e['img']) && file_exists(__DIR__ . '/../' . $e['img'])) {
                                $url_foto = htmlspecialchars($e['img']);
                            } else {
                                $iniciales = strtoupper(substr($e['nombre'], 0, 1) . substr($e['ap_pat'], 0, 1));
                                $url_foto = "https://ui-avatars.com/api/?name=" . urlencode($iniciales) . "&background=0D8ABC&color=fff&size=128";
                            }

                            $es_inactivo = ($e['activo'] == 0);
                            $fila_clase = $es_inactivo ? 'table-danger opacity-75' : '';
                            $badge_estado = $es_inactivo ? '' : '';

                            // TIPO DE INSCRIPCIÓN
                            $tipo_inscripcion = isset($e['tipo']) ? $e['tipo'] : 'N/A';
                            $clase_badge_tipo = 'bg-secondary';
                            if ($tipo_inscripcion == 'Regular') $clase_badge_tipo = 'badge-regular';
                            elseif ($tipo_inscripcion == 'BTH') $clase_badge_tipo = 'badge-bth';

                            // NUEVO: EVALUACIÓN ACADÉMICA V2
                            $eval_acad = function_exists('evaluarCondicionEstudianteV2') ? evaluarCondicionEstudianteV2($conn, $e['ci'], '2026') : null;
                            $badge_condicion = '<span class="badge bg-secondary">Sin Historial</span>';
                            if ($eval_acad) {
                                if ($eval_acad['estado'] == 'APROBADO') {
                                    $badge_condicion = '<span class="badge bg-danger"><i class="bi bi-check-circle"></i> APROBADO</span>';
                                } elseif ($eval_acad['estado'] == 'ARRASTRE_TURNO_DISTINTO') {
                                    $badge_condicion = '<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> ARRASTRE (' . $eval_acad['reprobadas'] . ')</span>';
                                } elseif (in_array($eval_acad['estado'], ['REPETIDOR_PARCIAL', 'RETIRADO_REINICIO'])) {
                                    $badge_condicion = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> REPROBADO</span>';
                                }
                            }
                    ?>
                            <tr class="<?= $fila_clase ?>">
                                <td class="text-center">
                                    <img src="<?= $url_foto ?>" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                </td>
                                <td><?= htmlspecialchars($e['ci']) ?></td>
                                <td>
                                    <?= htmlspecialchars($e['nombre'] . ' ' . $e['ap_pat'] . ' ' . $e['ap_mat']) ?>
                                    <?= $badge_estado ?>
                                </td>
                                <td><?= htmlspecialchars($e['carrera_nombre']) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $clase_badge_tipo ?> text-white"><?= htmlspecialchars($tipo_inscripcion) ?></span>
                                </td>
                                <!-- MUESTRA EL ESTADO CALCULADO EN LA TABLA -->
                                <td class="text-center">
                                    <?= $badge_condicion ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Botón Ver Materias que ya tienes -->
                                        <a href="index.php?action=secretaria_ver_materias&ci=<?= $e['ci'] ?>" class="btn btn-sm btn-info text-white" title="Ver Materias">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <?php if (!$es_inactivo): ?>
                                            <!-- Botón Editar que ya tienes -->
                                            <a href="index.php?action=secretaria_editar&ci=<?= $e['ci'] ?>" class="btn btn-sm btn-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- AGREGAR AQUÍ: BOTÓN PDF INDIVIDUAL PARA CADA ESTUDIANTE DE LA LISTA -->
                                            <a href="index.php?action=reporte_estudiante_gestion&ci=<?= $e['ci'] ?>&gestion=2026"
                                                target="_blank"
                                                class="btn btn-sm btn-danger"
                                                title="Descargar Ficha Académica PDF">
                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">Sin acciones</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        endwhile;
                    else:
                        ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-search" style="font-size: 2rem;"></i><br>
                                No se encontraron estudiantes con ese criterio.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ciInput = document.getElementById('ci_input');
        const ciMensaje = document.getElementById('ci_mensaje');

        if (ciInput && !ciInput.readOnly) {
            ciInput.addEventListener('input', function() {
                const ci = this.value.trim();

                if (ci.length < 5) {
                    ciMensaje.textContent = '';
                    ciMensaje.className = 'form-text';
                    ciInput.classList.remove('is-invalid', 'is-valid');
                    habilitarBotonRegistro(true);
                    return;
                }

                ciMensaje.textContent = ' Verificando...';
                ciMensaje.className = 'form-text text-muted';

                fetch(`index.php?action=verificar_ci&ci=${encodeURIComponent(ci)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.existe) {
                            ciMensaje.textContent = data.mensaje;
                            ciMensaje.className = 'form-text text-danger fw-bold';
                            ciInput.classList.add('is-invalid');
                            ciInput.classList.remove('is-valid');
                            habilitarBotonRegistro(false);
                        } else {
                            ciMensaje.textContent = data.mensaje;
                            ciMensaje.className = 'form-text text-danger fw-bold';
                            ciInput.classList.remove('is-invalid');
                            ciInput.classList.add('is-valid');
                            habilitarBotonRegistro(true);
                        }
                    })
                    .catch(error => {
                        console.error('Error al verificar CI:', error);
                        ciMensaje.textContent = 'Error de conexión al verificar.';
                        ciMensaje.className = 'form-text text-danger';
                    });
            });
        }

        function habilitarBotonRegistro(permitir) {
            const formRegistro = document.querySelector('form[action*="registrar_estudiante"]');
            if (formRegistro) {
                const btn = formRegistro.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = !permitir;
                    if (!permitir) {
                        btn.classList.add('disabled');
                        btn.title = "No se puede registrar, el CI ya existe";
                    } else {
                        btn.classList.remove('disabled');
                        btn.title = "";
                    }
                }
            }
        }

        // Auto-asignación de Paralelo según Turno
        const turnoSelect = document.getElementById('turno_select');
        const grupoSelect = document.getElementById('grupo_select');

        if (turnoSelect && grupoSelect) {
            turnoSelect.addEventListener('change', function() {
                const turno = this.value;

                if (turno === 'MAÑANA') {
                    grupoSelect.value = 'A';
                } else if (turno === 'TARDE') {
                    grupoSelect.value = 'B';
                } else {
                    grupoSelect.value = '';
                }
            });
        }
    });

    function validarApellidos() {
        const ap_pat = document.getElementById('ap_pat').value.trim();
        const ap_mat = document.getElementById('ap_mat').value.trim();
        const campo_pat = document.getElementById('ap_pat');
        const campo_mat = document.getElementById('ap_mat');

        if (ap_pat === '' && ap_mat === '') {
            campo_pat.classList.add('is-invalid');
            campo_mat.classList.add('is-invalid');
            return false;
        } else {
            campo_pat.classList.remove('is-invalid');
            campo_mat.classList.remove('is-invalid');
            return true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (document.getElementById('ap_pat') && document.getElementById('ap_mat')) {
                    if (!validarApellidos()) {
                        e.preventDefault();
                        return false;
                    }
                }
            });
        });
    });
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

<?php include 'views/footer.php'; ?>[cite: 3]