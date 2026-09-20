<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require_once 'config/db.php';
require_once 'models/funciones.php';


$error = '';

// ── Procesar el formulario cuando se envía por POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = trim($_POST['clave'] ?? '');

    // 1. Validación básica
    if (empty($usuario) || empty($clave)) {
        $error = 'Complete usuario y contraseña.';
       } else {
            // 4. Login exitoso: Guardar datos en variables de sesión
            $_SESSION['usuario_id']     = $datos['id'];
            $_SESSION['usuario_nombre'] = $datos['usuario'];
            $_SESSION['rol_id']         = $datos['id_rol'];
            $_SESSION['rol_nombre']     = $datos['rol_nombre'];

            // Si es estudiante, guardamos su CI en sesión para consultas rápidas
            if ($datos['id_rol'] == 3) {
                $_SESSION['estudiante_ci'] = $datos['usuario'];
            }

            // Regenerar ID de sesión para evitar reenvío de formulario y doble clic
            session_regenerate_id(true);

            // 5. Redirección según el rol
            switch ($datos['id_rol']) {
                case 1:
                    header('Location: index.php?action=admin_dashboard');
                    break;
                case 2:
                    header('Location: index.php?action=secretaria_dashboard');
                    break;
                case 3:
                    header('Location: index.php?action=estudiante_dashboard');
                    break;
                case 4:
                    header('Location: index.php?action=docente_dashboard');
                    break;
                default:
                    header('Location: index.php?action=inicio');
            }
            exit;
        }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — INST</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg: #0a0c12; --surface: #13151f; --surface2: #1c1f2e; --accent: #6c63ff; --accent2: #a78bfa; --success: #10b981; --danger: #ef4444; --warning: #f59e0b; --text: #e2e8f0; --text2: #94a3b8; --border: #252840; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; overflow: hidden; }
        .left-panel { flex: 1; background: linear-gradient(145deg, #0f1030 0%, #1a0f3c 50%, #0f1030 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px; position: relative; overflow: hidden; }
        .left-panel::before { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(108,99,255,.25) 0%, transparent 70%); top: -100px; left: -100px; border-radius: 50%; }
        .left-panel::after { content: ''; position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(167,139,250,.15) 0%, transparent 70%); bottom: -80px; right: -80px; border-radius: 50%; }
        .brand { display: flex; align-items: center; gap: 18px; margin-bottom: 60px; position: relative; z-index: 1; }
        .brand-icon { width: 64px; height: 64px; background: linear-gradient(135deg, var(--accent), var(--accent2)); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 30px; box-shadow: 0 8px 32px rgba(108,99,255,.5); }
        .brand-name { font-size: 1.8rem; font-weight: 800; }
        .brand-sub  { font-size: .85rem; color: var(--text2); }
        .roles-showcase { width: 100%; max-width: 380px; position: relative; z-index: 1; }
        .roles-title { font-size: .72rem; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px; text-align: center; }
        .role-item { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; padding: 14px 18px; margin-bottom: 10px; display: flex; align-items: center; gap: 14px; backdrop-filter: blur(10px); transition: all .25s; }
        .role-item:hover { background: rgba(108,99,255,.12); border-color: rgba(108,99,255,.3); transform: translateX(4px); }
        .role-emoji { font-size: 1.6rem; }
        .role-info-name  { font-size: .9rem; font-weight: 700; }
        .role-info-perms { font-size: .74rem; color: var(--text2); margin-top: 2px; }
        .role-tag { margin-left: auto; padding: 3px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; }
        .tag-admin   { background: rgba(59,130,246,.2); color: #60a5fa; }
        .tag-profe   { background: rgba(167,139,250,.2); color: var(--accent2); }
        .tag-student { background: rgba(16,185,129,.2);  color: #10b981; }
        .right-panel { width: 480px; min-width: 480px; background: var(--surface); border-left: 1px solid var(--border); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 50px 48px; }
        .form-header { text-align: center; margin-bottom: 36px; }
        .form-header h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 6px; }
        .form-header p  { color: var(--text2); font-size: .88rem; }
        .form-group { margin-bottom: 18px; width: 100%; }
        label { display: block; font-size: .75rem; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 8px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 1rem; color: var(--text2); pointer-events: none; }
        input[type=text], input[type=password] { width: 100%; background: var(--surface2); border: 1.5px solid var(--border); border-radius: 12px; padding: 13px 16px 13px 44px; color: var(--text); font-family: 'Inter', sans-serif; font-size: .9rem; outline: none; transition: border .2s, box-shadow .2s; }
        input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(108,99,255,.18); }
        .toggle-pass { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text2); cursor: pointer; font-size: 1.1rem; padding: 4px; }
        .toggle-pass:hover { color: var(--accent2); }
        .error-box { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #f87171; border-radius: 10px; padding: 12px 16px; font-size: .84rem; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; width: 100%; }
        .btn-login { width: 100%; padding: 14px; border-radius: 12px; border: none; background: linear-gradient(135deg, var(--accent), var(--accent2)); color: #fff; font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .2s; box-shadow: 0 4px 20px rgba(108,99,255,.35); margin-top: 6px; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(108,99,255,.5); }
        .btn-login:active { transform: none; }
        .demo-section { width: 100%; margin-top: 28px; }
        .demo-title { font-size: .72rem; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: .8px; text-align: center; margin-bottom: 12px; display: flex; align-items: center; gap: 10px; }
        .demo-title::before, .demo-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .demo-creds { display: flex; flex-direction: column; gap: 8px; }
        .cred-item { background: var(--surface2); border: 1px solid var(--border); border-radius: 10px; padding: 10px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: all .15s; }
        .cred-item:hover { border-color: var(--accent); background: rgba(108,99,255,.06); }
        .cred-icon { font-size: 1.3rem; }
        .cred-rol  { font-size: .8rem; font-weight: 700; color: var(--text); }
        .cred-data { font-size: .74rem; color: var(--text2); margin-top: 1px; font-family: monospace; }
        .cred-use  { margin-left: auto; font-size: .7rem; font-weight: 600; color: var(--accent2); background: rgba(108,99,255,.1); padding: 3px 10px; border-radius: 8px; }
        @media(max-width: 900px) { .left-panel { display: none; } .right-panel { width: 100%; min-width: 0; } }
    </style>
</head>
<body>

<!-- PANEL IZQUIERDO -->
<div class="left-panel">
    <div class="brand">
        <div class="brand-icon">📚</div>
        <div>
            <div class="brand-name">Sistema INST</div>
            <div class="brand-sub">Plataforma Académica del Instituto</div>
        </div>
    </div>

    <div class="roles-showcase">
        <div class="roles-title">Roles del sistema</div>
        <div class="role-item">
            <span class="role-emoji">🛡️</span>
            <div>
                <div class="role-info-name">Administrador</div>
                <div class="role-info-perms">Acceso total · Gestión de usuarios · Configuración</div>
            </div>
            <span class="role-tag tag-admin">Admin</span>
        </div>
        <div class="role-item">
            <span class="role-emoji">👨‍🏫</span>
            <div>
                <div class="role-info-name">Docente</div>
                <div class="role-info-perms">Cargar notas · Ver alumnos · Impartir clases</div>
            </div>
            <span class="role-tag tag-profe">Docente</span>
        </div>
        <div class="role-item">
            <span class="role-emoji">🎓</span>
            <div>
                <div class="role-info-name">Estudiante</div>
                <div class="role-info-perms">Ver notas · Horario · Inscripciones</div>
            </div>
            <span class="role-tag tag-student">Alumno</span>
        </div>
    </div>
</div>

<!-- PANEL DERECHO — FORMULARIO -->
<div class="right-panel">
    <div class="form-header">
        <div style="font-size:2.4rem;margin-bottom:12px">🔐</div>
        <h2>Iniciar Sesión</h2>
        <p>Ingresa con tu cuenta asignada</p>
    </div>

    <?php if (!empty($error)): ?>
    <div class="error-box">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- ✅ CORRECCIÓN CLAVE: action="" envía los datos a este mismo archivo (login.php) -->
    <form method="POST" action="" style="width:100%">
        <div class="form-group">
            <label>Usuario (CI o Nombre de usuario)</label>
            <div class="input-wrap">
                <span class="input-icon">👤</span>
                <input type="text" name="usuario" id="input-usuario"
                       value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>"
                       placeholder="Ej: 5550001 o admin" autocomplete="username" required>
            </div>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <div class="input-wrap">
                <span class="input-icon">🔑</span>
                <input type="password" name="clave" id="input-clave"
                       placeholder="••••••••" autocomplete="current-password" required>
                <button type="button" class="toggle-pass" onclick="togglePass()" title="Mostrar/ocultar">👁️</button>
            </div>
        </div>

        <button type="submit" class="btn-login">Ingresar al Sistema →</button>
    </form>

    <!-- Credenciales de prueba (Coinciden con tu base de datos real) -->
    <div class="demo-section">
        <div class="demo-title">Cuentas de prueba</div>
        <div class="demo-creds">
            <div class="cred-item" onclick="fillCreds('admin','123456')">
                <span class="cred-icon">🛡️</span>
                <div>
                    <div class="cred-rol">Administrador</div>
                    <div class="cred-data">admin / 123456</div>
                </div>
                <span class="cred-use">Usar</span>
            </div>
            <div class="cred-item" onclick="fillCreds('5550001','123456')">
                <span class="cred-icon">👨‍🏫</span>
                <div>
                    <div class="cred-rol">Docente — Jonatan Hinojosa</div>
                    <div class="cred-data">5550001 / 123456</div>
                </div>
                <span class="cred-use">Usar</span>
            </div>
            <div class="cred-item" onclick="fillCreds('12345678','12345678')">
                <span class="cred-icon">🎓</span>
                <div>
                    <div class="cred-rol">Estudiante — Maria Mercado</div>
                    <div class="cred-data">12345678 / 12345678</div>
                </div>
                <span class="cred-use">Usar</span>
            </div>
        </div>
    </div>

    <p style="color:var(--text2);font-size:.74rem;text-align:center;margin-top:24px">
        ¿Sin acceso? Contacta a la secretaria académica.
    </p>
</div>

<script>
function togglePass() {
    const el = document.getElementById('input-clave');
    el.type = el.type === 'password' ? 'text' : 'password';
}

function fillCreds(user, pass) {
    document.getElementById('input-usuario').value = user;
    document.getElementById('input-clave').value   = pass;
    document.getElementById('input-clave').focus();
}
</script>
</body>
</html>