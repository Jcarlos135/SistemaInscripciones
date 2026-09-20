
<?php include 'views/header.php'; ?>

<style>
    .btn-primary{
        background: linear-gradient(135deg, #28a745, #198754);
        border: none; color: #fff; font-weight: 600; transition: all .3s ease;
    }
    .btn-primary:hover{
        background: linear-gradient(135deg, #198754, #146c43);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25,135,84,.35);
        color: #fff;
    }
    .btn-secondary{
        background: linear-gradient(135deg,#6c757d,#495057);
        border:none;
    }
    .btn-secondary:hover{
        background: linear-gradient(135deg,#495057,#343a40);
        color:#fff;
    }
    .btn-registro{
        background: linear-gradient(135deg, #059d3bff, #022818ff);
        border: none; color: #fff; font-weight: 600;
    }
    .btn-registro:hover{
        background: linear-gradient(135deg, #059d3bff, #022818ff);
        color: #fff; transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(17, 92, 48, 0.35);
    }
    #verif_resultado {
        border-radius: 8px;
        margin-top: 10px;
        display: none;
    }
    .card-header{
        background: linear-gradient(135deg, #059d3bff, #022818ff);
        color: #fff; transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(17, 92, 48, 0.35);
        height: 70px;
    }
    .alert-custom {
        border-radius: 8px;
        border-left: 5px solid;
        animation: slideDown 0.3s ease-out;
    }
    .alert-danger-custom {
        background-color: #f8d7da;
        border-color: #dc3545;
        color: #721c24;
    }
    .alert-warning-custom {
        background-color: #fff3cd;
        border-color: #ffc107;
        color: #856404;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .input-group-text {
        cursor: pointer;
        background: #f8f9fa;
        border: 1px solid #ced4da;
        border-left: none;
    }
    .input-group-text:hover {
        background: #e9ecef;
    }
    /* Caja verde para usuarios NO registrados */
    .alerta-verde {
        background-color: #d4edda;
        border: 1px solid #28a745;
        border-left: 5px solid #059d3b;
        color: #155724;
        border-radius: 8px;
        padding: 10px 14px;
        margin-top: 10px;
        font-size: 13px;
        line-height: 1.5;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        animation: slideDown 0.3s ease-out;
    }
    .alerta-verde i { font-size: 16px; margin-top: 2px; }

</style>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <!-- Alertas mejoradas -->
            <?php if (isset($_SESSION['alerta'])): ?>
                <?php 
                $tipo_alerta = $_SESSION['alerta']['tipo'];
                $msg_alerta = $_SESSION['alerta']['msg'];
                $clase_alerta = ($tipo_alerta === 'danger') ? 'alert-danger-custom' : 'alert-warning-custom';
                $icono_alerta = ($tipo_alerta === 'danger') ? 'bi-x-circle-fill' : 'bi-exclamation-triangle-fill';
                ?>
                <div class="alert <?= $clase_alerta ?> alert-custom alert-dismissible fade show shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi <?= $icono_alerta ?> fs-4 me-3"></i>
                        <div class="flex-grow-1">
                            <strong><?= ($tipo_alerta === 'danger') ? 'Error:' : 'Atención:' ?></strong><br>
                            <?= htmlspecialchars($msg_alerta) ?>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                <?php unset($_SESSION['alerta']); ?>
            <?php endif; ?>

            <!-- PDF después de registro -->
            <?php if (isset($_SESSION['abrir_pdf_ci'])): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div class="flex-grow-1">
                            <strong>¡Registro completado!</strong><br>
                            <small>Su usuario y contraseña son su CI. Ahora puede iniciar sesión.</small>
                        </div>
                        <a href="reports/reporte_registro.php?ci=<?= htmlspecialchars($_SESSION['abrir_pdf_ci']) ?>" 
                           target="_blank" class="btn btn-sm btn-primary ms-3">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Ver PDF
                        </a>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                <?php unset($_SESSION['abrir_pdf_ci']); ?>
            <?php endif; ?>

            <!-- LOGIN + VERIFICACIÓN EN UNA SOLA CARD -->
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex align-items-center">
                    <h5 class="mb-0"><i class="bi bi-mortarboard-fill"></i> Sistema de Inscripción</h5>
                </div>
                <div class="card-body">

                    <form action="index.php?action=procesar_login" method="POST" id="formLogin">
                        <!-- USUARIO -->
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="bi bi-person"></i> Usuario (CI)</label>
                            <input type="text" name="usuario" id="login_usuario" class="form-control" placeholder="Ingrese su CI" required autofocus>
                            <small id="verif_resultado" class="form-text"></small>
                        </div>

                        <!-- CONTRASEÑA -->
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="bi bi-key"></i> Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="clave" id="clave_input" class="form-control" placeholder="Ingrese su contraseña" required>
                                <span class="input-group-text" onclick="togglePassword()" title="Mostrar/Ocultar contraseña">
                                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- BOTÓN INGRESAR -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-50">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                            </button>
                            <a href="index.php?action=inicio" class="btn btn-secondary w-50">
                                <i class="bi bi-x-circle me-1"></i> Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Tarjeta de Información General -->
            <div class="mt-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-success border-bottom pb-2">
                            <i class="bi bi-megaphone-fill me-1"></i> Avisos e Información Importante
                        </h6>
                        <p class="card-text text-muted small">
                            Bienvenido al portal académico. Si es tu primera vez ingresando al sistema, utiliza tu número de <strong>Cédula de Identidad (CI)</strong> tanto para el usuario como para la contraseña predeterminada.
                        </p>
                        
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <i class="bi bi-check2-circle text-success me-2"></i>
                                Inscripciones abiertas para el periodo académico actual.
                            </li>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <i class="bi bi-shield-lock text-success me-2"></i>
                                Recuerda cambiar tu contraseña desde tu perfil al ingresar.
                            </li>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <i class="bi bi-file-earmark-text text-success me-2"></i>
                                Descarga tu comprobante de registro al finalizar la inscripción.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tarjeta de Horarios y Contacto de Soporte -->
                <div class="card shadow-sm">
                    <div class="card-body bg-light rounded">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-headset fs-3 text-success me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">¿Necesitas ayuda?</h6>
                                <small class="text-muted">Atención de Secretaría Académica</small>
                            </div>
                        </div>
                        <div class="row g-2 mt-1 text-center small">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white">
                                    <i class="bi bi-clock text-muted d-block mb-1"></i>
                                    <strong>Horario:</strong><br>
                                    08:00 - 16:00
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white">
                                    <i class="bi bi-envelope text-muted d-block mb-1"></i>
                                    <strong>Soporte:</strong><br>
                                    Consultas en oficina
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
// Toggle contraseña
function togglePassword() {
    const input = document.getElementById('clave_input');
    const icon = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text'; 
        icon.className = 'bi bi-eye';
    } else {
        input.type = 'password'; 
        icon.className = 'bi bi-eye-slash';
    }
}

// Verificar inscripción y actualizar el enlace de registro en tiempo real
let verifTimer;
document.getElementById('login_usuario').addEventListener('input', function() {
    clearTimeout(verifTimer);
    const ci = this.value.trim();
    const resultado = document.getElementById('verif_resultado');
    const btnRegistro = document.getElementById('btnIrRegistro');
    
    // Actualizar dinámicamente el enlace de registro con el CI escrito
    if (ci.length > 0 && btnRegistro) {
        btnRegistro.href = 'index.php?action=registro&ci=' + encodeURIComponent(ci);
    }
    
    if (ci.length < 5) {
        resultado.textContent = '';
        resultado.className = 'form-text';
        resultado.style.display = 'none';
        return;
    }
    
    // Esperar 500ms antes de verificar
    verifTimer = setTimeout(function() {
        resultado.textContent = 'Verificando...';
        resultado.className = 'form-text text-muted';
        resultado.style.display = 'block';
        
        fetch('index.php?action=verificar_inscripcion&ci=' + encodeURIComponent(ci))
            .then(r => r.json())
            .then(data => {
                    resultado.style.display = 'block';
                    resultado.className = 'form-text';

                    switch (data.tipo) {

                        case 'no_registrado':
                            resultado.innerHTML =
                                '<div class="alerta-verde"><i class="bi bi-person-x-fill"></i>' +
                                '<span><strong>Usuario NO registrado.</strong> Este CI no existe en el sistema ' +
                                'como estudiante, docente, secretaria ni administrador.</span></div>';
                            break;

                        case 'estudiante_no_inscrito':
                            resultado.innerHTML =
                                '<div class="alerta-verde"><i class="bi bi-exclamation-circle-fill"></i>' +
                                '<span><strong>El estudiante no está inscrito:</strong> ' +
                                data.nombre_completo + '</span></div>';
                            break;

                        case 'estudiante_inscrito':
                            resultado.className = 'form-text text-success';
                            resultado.innerHTML =
                                '<i class="bi bi-check-circle-fill"></i> <strong>Inscrito:</strong> ' +
                                data.nombre_completo + ' — ' + data.carrera +
                                ' <small>(' + data.tipo_inscripcion + ')</small><br>' +
                                '<span class="text-muted">Usuario: <strong>' + ci + '</strong> | Contraseña: su CI</span>';
                            break;

                        case 'docente':
                            resultado.className = 'form-text text-primary';
                            resultado.innerHTML =
                                '<i class="bi bi-person-workspace"></i> <strong>Docente registrado:</strong> ' +
                                data.nombre + ' — ingrese su contraseña.';
                            break;

                        case 'secretaria':
                            resultado.className = 'form-text text-primary';
                            resultado.innerHTML =
                                '<i class="bi bi-person-badge-fill"></i> <strong>Personal de Secretaría Académica</strong> — ingrese su contraseña.';
                            break;

                        case 'admin':
                            resultado.className = 'form-text text-primary';
                            resultado.innerHTML =
                                '<i class="bi bi-shield-lock-fill"></i> <strong>Administrador del sistema</strong> — ingrese su contraseña.';
                            break;

                        case 'desactivado':
                            resultado.className = 'form-text text-danger fw-bold';
                            resultado.innerHTML =
                                '<i class="bi bi-x-circle-fill"></i> <strong>Cuenta Desactivada:</strong> Contacte con Dirección Académica.';
                            break;
                    }
                })
            .catch(err => {
                resultado.className = 'form-text text-danger';
                resultado.textContent = 'Error de conexión.';
            });
    }, 500);
});

</script>
<?php include 'views/footer.php'; ?>