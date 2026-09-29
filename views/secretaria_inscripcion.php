<?php include 'views/header.php'; ?>


<link rel="stylesheet" href="/sig/public/css/secretaria_dashboard.css">
<h2 class="mb-4"><i class="bi bi-pencil-square"></i> Registrar Inscripción</h2>

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="alert alert-<?= $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show">
        <i class="bi bi-info-circle"></i> <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="index.php?action=registrar_inscripcion" method="POST" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Estudiante</label>
                    <select class="form-select" name="ci_est" id="ci_est" required>
                        <option value="">Seleccione...</option>
                        <?php
                        $estudiantes = listar_estudiantes($conn);
                        while ($e = mysqli_fetch_assoc($estudiantes)): ?>
                            <option value="<?= $e['ci'] ?>" data-carrera="<?= $e['id_carrera'] ?>">
                                <?= htmlspecialchars($e['ci'] . ' - ' . $e['nombre'] . ' ' . $e['ap_pat']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Materia</label>
                    <select class="form-select" name="cod_asig" id="cod_asig" required>
                        <option value="">Primero seleccione un estudiante...</option>
                    </select>
                </div>

                <!-- NUEVO CAMPO: TIPO DE INSCRIPCIÓN -->
                <div class="col-md-6">
                    <label class="form-label">Tipo de Inscripción</label>
                    <select class="form-select" name="tipo_inscripcion" required>
                        <option value="">Seleccione...</option>
                        <option value="Regular">Regular (1er Año - Nivel 100)</option>
                        <option value="BTH">BTH (2do Año - Nivel 200)</option>
                    </select>
                    <div class="form-text">Define el año de inscripción según el tipo.</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Turno</label>
                    <select class="form-select" name="turno" id="turno" required>
                        <option value="">Seleccione...</option>
                        <option value="MAÑANA">MAÑANA</option>
                        <option value="TARDE">TARDE</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Grupo (Paralelo)</label>
                    <select class="form-select" name="grupo" id="grupo" required>
                        <option value="">Seleccione...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-check-circle"></i> Inscribir</button>
                    <a href="index.php?action=secretaria_dashboard" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('ci_est').addEventListener('change', function() {
        const carreraId = this.options[this.selectedIndex].getAttribute('data-carrera');
        const selectMateria = document.getElementById('cod_asig');
        selectMateria.innerHTML = '<option value="">Cargando...</option>';

        if (carreraId) {
            fetch(`?action=api_materias&carrera=${carreraId}`)
                .then(res => res.json())
                .then(data => {
                    selectMateria.innerHTML = '<option value="">Seleccione materia...</option>';
                    data.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.codigo;
                        opt.textContent = m.codigo + ' - ' + m.nombre;
                        selectMateria.appendChild(opt);
                    });
                });
        }
    });

    // Auto-asignación de Grupo según Turno
    const turnoSelect = document.getElementById('turno');
    const grupoSelect = document.getElementById('grupo');

    turnoSelect.addEventListener('change', function() {
        const turnoSeleccionado = this.value;

        if (turnoSeleccionado === 'MAÑANA') {
            grupoSelect.value = 'A';
        } else if (turnoSeleccionado === 'TARDE') {
            grupoSelect.value = 'B';
        } else {
            grupoSelect.value = '';
        }
    });
</script>

<?php include 'views/footer.php'; ?>