<?php include 'views/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Alertas -->
            <?php if (isset($_SESSION['alerta'])): ?>
                <div class="alert alert-<?= $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show">
                    <i class="bi bi-info-circle"></i> <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['alerta']); ?>
            <?php endif; ?>

            <!-- Card registro -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-plus-fill"></i> Registro de Estudiante</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?action=procesar_registro" method="POST" enctype="multipart/form-data" id="formRegistro" novalidate>

                        <div class="row g-3">
                            <!-- CI -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Carnet (CI) <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="ci" id="ci_input" required maxlength="15" placeholder="Ej: 4780257">
                                <small id="ci_mensaje" class="form-text"></small>
                            </div>
                            <!-- Nombre -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Nombres <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <!-- Ap Pat -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" name="ap_pat" id="ap_pat" onblur="validarApellidos()">
                            </div>
                            <!-- Ap Mat -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" name="ap_mat" id="ap_mat" onblur="validarApellidos()">
                            </div>
                        </div>

                        <div class="row g-3 mt-2 fw-bold">
                            <!-- Género -->
                            <div class="col-md-2">
                                <label class="form-label">Género <span class="text-danger"></span></label>
                                <select class="form-select" name="genero" required>
                                    <option value="">Seleccione</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="O">Otro</option>
                                </select>
                            </div>
                            <!-- Edad -->
                            <div class="col-md-2 fw-bold">
                                <label class="form-label">Edad <span class="text-danger"></span></label>
                                <input type="number" class="form-control" name="edad" required min="15" max="80" placeholder="20">
                            </div>
                            <!-- Celular -->
                            <div class="col-md-4 fw-bold">
                                <label class="form-label">Celular <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="cel" required maxlength="15" placeholder="70012345">
                            </div>
                            <!-- Carrera -->
                            <div class="col-md-4 fw-bold">
                                <label class="form-label">Carrera</label>
                                <input type="text" class="form-control bg-light" value="SISTEMAS INFORMÁTICOS" disabled>
                                <input type="hidden" name="id_carrera" value="SIS-INF">
                                <small class="text-muted">Carrera por defecto</small>
                            </div>
                        </div>

                        <div class="row g-3 mt-2 fw-bold">
                            <!-- Gestión -->
                            <div class="col-md-3">
                                <label class="form-label">Gestión</label>
                                <input type="text" class="form-control bg-light" value="<?= date('Y') ?>" disabled>
                                <input type="hidden" name="gestion" value="<?= date('Y') ?>">
                                <small class="text-muted">Automático</small>
                            </div>
                            <!-- Tipo inscripción -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Tipo Inscripción <span class="text-danger"></span></label>
                                <select class="form-select" name="tipo_inscripcion" id="tipo_inscripcion" required>
                                    <option value="">Seleccione</option>
                                    <option value="Regular">Regular (1er Año)</option>
                                    <option value="BTH">BTH (1er + 2do Año)</option>
                                    <option value="Beca">Beca (1er Año)</option>
                                </select>
                            </div>
                            <!-- Turno -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Turno <span class="text-danger"></span></label>
                                <select class="form-select" name="turno" id="turno_select" required>
                                    <option value="">Seleccione</option>
                                    <option value="MAÑANA">Mañana</option>
                                    <option value="TARDE">Tarde</option>
                                </select>
                            </div>
                            <!-- Paralelo -->
                            <div class="col-md-3 fw-bold">
                                <label class="form-label">Paralelo</label>
                                <select class="form-select" name="grupo" id="grupo_select" required>
                                    <option value="">-----</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
                                <small class="text-muted">Mañana=A, Tarde=B</small>
                            </div>
                        </div>

                        

                        <div class="row g-3 mt-2 fw-bold">
                            <!-- Doc CI -->
                            <div class="col-md-4">
                                <label class="form-label">Carnet de Identidad <span class="text-danger"></span></label>
                                <input type="file" class="form-control" name="doc_ci" accept="image/,.pdf" required>
                                <small class="text-muted">Foto o PDF</small>
                            </div>
                            <!-- Doc Título -->
                            <div class="col-md-4 fw-bold">
                                <label class="form-label">Título de Bachiller <span class="text-danger"></span></label>
                                <input type="file" class="form-control" name="doc_titulo" accept="image/,.pdf" required>
                                <small class="text-muted">Foto o PDF</small>
                            </div>
                            <!-- Doc Depósito -->
                            <div class="col-md-4 fw-bold">
                                <label class="form-label">Depósito Bancario <span class="text-danger"></span></label>
                                <input type="file" class="form-control" name="doc_deposito" accept="image/,.pdf" required>
                                <small class="text-muted">Foto o PDF</small>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success" id="btnRegistrar">
                                <i class="bi bi-check-circle-fill"></i> Registrarse
                            </button>
                            <a href="index.php?action=login" class="btn btn-outline-success ms-2">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                        </div>

                        <!-- CAMPOS AUTOMÁTICOS DE USUARIO Y CONTRASEÑA (COPIAN EL CI) -->
                        <div class="row g-3 mt-2" style="visibility: hidden;">
                            <div class="col-md-6">
                                <label class="form-label">Usuario</label>
                                <input type="text" class="form-control bg-light" id="usuario_display" value="Se genera con su CI" disabled>
                                <input type="hidden" name="usuario" id="usuario_hidden">
                                <small class="text-muted">Su CI será su usuario</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contraseña</label>
                                <input type="text" class="form-control bg-light" id="clave_display" value="Se genera con su CI" disabled>
                                <input type="hidden" name="clave" id="clave_hidden">
                                <small class="text-muted">Su CI será su contraseña</small>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer text-muted small">
                    <i class="bi bi-shield-lock"></i> Usuario y contraseña = CI. Se genera PDF de inscripción.
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ciInput = document.getElementById('ci_input');
    const ciMensaje = document.getElementById('ci_mensaje');
    const usuarioDisplay = document.getElementById('usuario_display');
    const claveDisplay = document.getElementById('clave_display');
    const usuarioHidden = document.getElementById('usuario_hidden');
    const claveHidden = document.getElementById('clave_hidden');
    const turnoSelect = document.getElementById('turno_select');
    const grupoSelect = document.getElementById('grupo_select');
    
    // --- CAPTURAR CI DE LA URL SI VIENE DEL LOGIN ---
    const urlParams = new URLSearchParams(window.location.search);
    const ciUrl = urlParams.get('ci');
    if (ciUrl) {
        ciInput.value = ciUrl;
        ciInput.dispatchEvent(new Event('input'));
    }
    
    ciInput.addEventListener('input', function() {
        const ci = this.value.trim();
        
        // Copiar automáticamente el CI al usuario y contraseña (visual y oculto)
        if (ci) {
            if (usuarioDisplay) usuarioDisplay.value = ci;
            if (claveDisplay) claveDisplay.value = ci;
            if (usuarioHidden) usuarioHidden.value = ci;
            if (claveHidden) claveHidden.value = ci;
        } else {
            if (usuarioDisplay) usuarioDisplay.value = 'Se genera con su CI';
            if (claveDisplay) claveDisplay.value = 'Se genera con su CI';
            if (usuarioHidden) usuarioHidden.value = '';
            if (claveHidden) claveHidden.value = '';
        }
        
        if (ci.length < 5) {
            ciMensaje.textContent = '';
            ciInput.classList.remove('is-invalid', 'is-valid');
            document.getElementById('btnRegistrar').disabled = false;
            return;
        }
        
       // ciMensaje.textContent = 'Verificando...';
        ciMensaje.className = 'form-text text-muted';
        
        fetch('index.php?action=verificar_ci&ci=' + encodeURIComponent(ci))
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.existe) {
                    ciMensaje.textContent = data.mensaje;
                    ciMensaje.className = 'form-text text-danger fw-bold';
                    ciInput.classList.add('is-invalid');
                    ciInput.classList.remove('is-valid');
                    document.getElementById('btnRegistrar').disabled = true;
                } else {
                    ciMensaje.textContent = data.mensaje;
                    ciMensaje.className = 'form-text text-success fw-bold';
                    ciInput.classList.remove('is-invalid');
                    ciInput.classList.add('is-valid');
                    document.getElementById('btnRegistrar').disabled = false;
                }
            })
           /* .catch(function(err) {
                ciMensaje.textContent = 'Error de conexión al verificar CI.';
                ciMensaje.className = 'form-text text-danger';
            });*/
    });

    if (turnoSelect && grupoSelect) {
        turnoSelect.addEventListener('change', function() {
            if (this.value === 'MAÑANA') grupoSelect.value = 'A';
            else if (this.value === 'TARDE') grupoSelect.value = 'B';
            else grupoSelect.value = '';
        });
    }
});

function validarApellidos() {
    const ap_pat = document.getElementById('ap_pat').value.trim();
    const ap_mat = document.getElementById('ap_mat').value.trim();
    if (ap_pat === '' && ap_mat === '') {
        document.getElementById('ap_pat').classList.add('is-invalid');
        document.getElementById('ap_mat').classList.add('is-invalid');
        return false;
    } else {
        document.getElementById('ap_pat').classList.remove('is-invalid');
        document.getElementById('ap_mat').classList.remove('is-invalid');
        return true;
    }
}

document.getElementById('formRegistro').addEventListener('submit', function(e) {
    if (!validarApellidos()) {
        e.preventDefault();
        alert('Debe ingresar al menos un apellido');
        return;
    }
    // Asegurar envío de credenciales basadas en CI
    const ciVal = document.getElementById('ci_input').value.trim();
    document.getElementById('usuario_hidden').value = ciVal;
    document.getElementById('clave_hidden').value = ciVal;
});
</script>

<?php include 'views/footer.php'; ?>