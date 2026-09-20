<?php

$host   = 'localhost';
$user   = 'root';
$pass   = '';   // Cambia si tienes contraseña en MySQL
$dbname = 'inst';

$log = [];

function ok($msg)  { global $log; $log[] = ['type'=>'ok',   'msg'=>$msg]; }
function err($msg) { global $log; $log[] = ['type'=>'err',  'msg'=>$msg]; }
function inf($msg) { global $log; $log[] = ['type'=>'info', 'msg'=>$msg]; }

$install = isset($_POST['install']);
$success = false;

if ($install) {
    // Conexión sin base de datos primero
    $pdo = null;
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        ok("Conexión a MySQL exitosa ✔");
    } catch (PDOException $e) {
        err("Error de conexión: " . $e->getMessage());
    }

    if ($pdo) {
        // Leer y ejecutar el SQL
        $sqlFile = __DIR__ . '/inst.sql';
        if (!file_exists($sqlFile)) {
            err("No se encontró el archivo inst.sql en " . __DIR__);
        } else {
            inf("Leyendo inst.sql...");

            // Dividir en sentencias individuales
            $sql = file_get_contents($sqlFile);

            // Eliminar comentarios de línea
            $sql = preg_replace('/--[^\n]*\n/', "\n", $sql);

            // Dividir por ";"
            $stmts = array_filter(
                array_map('trim', explode(';', $sql)),
                fn($s) => strlen($s) > 3
            );

            $total = count($stmts);
            $done  = 0;
            $errors= 0;

            foreach ($stmts as $stmt) {
                try {
                    $pdo->exec($stmt);
                    $done++;
                } catch (PDOException $e) {
                    $msg = $e->getMessage();
                    // Ignorar errores de "already exists" o duplicados
                    if (
                        str_contains($msg, 'already exists') ||
                        str_contains($msg, 'Duplicate entry') ||
                        str_contains($msg, 'errno: 121')
                    ) {
                        inf("Ya existe (omitido): " . substr($stmt, 0, 60) . "...");
                    } else {
                        err("Error: " . $msg . " — SQL: " . substr($stmt, 0, 80));
                        $errors++;
                    }
                }
            }

            ok("Sentencias procesadas: $done / $total");
            if ($errors === 0) {
                ok("¡Base de datos <strong>$dbname</strong> instalada correctamente!");
                $success = true;
            } else {
                err("Se encontraron $errors errores durante la instalación.");
            }

            // Verificar tablas creadas
            try {
                $pdo2 = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
                $tables = $pdo2->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                inf("Tablas encontradas en <strong>$dbname</strong>: " . implode(', ', $tables));

                // Verificar roles
                $roles = $pdo2->query("SELECT nombre, descripcion FROM rol")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($roles as $r) {
                    ok("Rol registrado: <strong>{$r['nombre']}</strong> — {$r['descripcion']}");
                }
            } catch (PDOException $e) {
                err("No se pudo verificar las tablas: " . $e->getMessage());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador BD — INST</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f1117; --surface: #1a1d27; --surface2: #22263a;
            --accent: #6c63ff; --accent2: #a78bfa;
            --success: #10b981; --danger: #ef4444; --info: #3b82f6; --warning: #f59e0b;
            --text: #e2e8f0; --text2: #94a3b8; --border: #2d3748;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg); color: var(--text);
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            padding: 40px 20px;
        }
        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 40px; width: 100%; max-width: 760px;
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
        }
        .logo {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 14px; display: flex; align-items: center;
            justify-content: center; font-size: 26px; margin: 0 auto 20px;
        }
        h1 { text-align: center; font-size: 1.6rem; font-weight: 800; margin-bottom: 6px; }
        .sub { text-align: center; color: var(--text2); font-size: .9rem; margin-bottom: 30px; }
        .sep { height: 1px; background: var(--border); margin: 24px 0; }

        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px;
        }
        .info-item {
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 10px; padding: 14px;
        }
        .info-label { font-size: .72rem; color: var(--text2); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
        .info-value { font-size: .9rem; font-weight: 600; }

        .tables-list {
            display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 24px;
        }
        .table-badge {
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 8px; padding: 8px 14px; font-size: .82rem;
            display: flex; align-items: center; gap: 8px;
        }
        .table-badge span { font-size: 1rem; }

        .roles-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 24px; }
        .role-card {
            border-radius: 10px; padding: 14px; text-align: center;
            border: 2px solid transparent;
        }
        .role-admin   { background: rgba(59,130,246,.1);  border-color: rgba(59,130,246,.3); }
        .role-profe   { background: rgba(142,68,173,.12); border-color: rgba(142,68,173,.4); }
        .role-student { background: rgba(16,185,129,.1);  border-color: rgba(16,185,129,.3); }
        .role-icon  { font-size: 1.8rem; margin-bottom: 6px; }
        .role-name  { font-size: .9rem; font-weight: 700; }
        .role-perms { font-size: .72rem; color: var(--text2); margin-top: 4px; line-height: 1.5; }

        .btn {
            width: 100%; padding: 14px; border-radius: 12px; border: none;
            font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 700;
            cursor: pointer; background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff; transition: all .2s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108,99,255,.4); }
        .btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

        .log-container {
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 12px; padding: 20px; max-height: 360px;
            overflow-y: auto; margin-top: 24px;
        }
        .log-entry {
            padding: 7px 10px; border-radius: 7px; margin-bottom: 6px;
            font-size: .82rem; display: flex; gap: 10px; align-items: flex-start;
        }
        .log-ok   { background: rgba(16,185,129,.1);  color: #10b981; }
        .log-err  { background: rgba(239,68,68,.1);   color: #ef4444; }
        .log-info { background: rgba(59,130,246,.1);  color: #60a5fa; }

        .success-banner {
            background: linear-gradient(135deg, rgba(16,185,129,.15), rgba(16,185,129,.05));
            border: 2px solid rgba(16,185,129,.4); border-radius: 14px;
            padding: 20px; text-align: center; margin-top: 20px;
        }
        .success-banner h3 { color: #10b981; font-size: 1.2rem; margin-bottom: 8px; }
        .links { display: flex; gap: 12px; justify-content: center; margin-top: 14px; flex-wrap: wrap; }
        .link-btn {
            padding: 9px 20px; border-radius: 8px; text-decoration: none;
            font-size: .84rem; font-weight: 600; transition: all .2s;
        }
        .link-primary { background: var(--accent); color: #fff; }
        .link-secondary { background: var(--surface2); border: 1px solid var(--border); color: var(--text2); }
        .link-btn:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">📚</div>
    <h1>Instalador — Base de Datos INST</h1>
    <p class="sub">Sistema Académico del Instituto · XAMPP + MySQL</p>
    <div class="sep"></div>

    <!-- Info de conexión -->
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">🖥 Host</div>
            <div class="info-value">localhost</div>
        </div>
        <div class="info-item">
            <div class="info-label">🗄 Base de Datos</div>
            <div class="info-value">inst</div>
        </div>
        <div class="info-item">
            <div class="info-label">👤 Usuario MySQL</div>
            <div class="info-value">root</div>
        </div>
        <div class="info-item">
            <div class="info-label">📁 Script SQL</div>
            <div class="info-value">inst.sql</div>
        </div>
    </div>

    <!-- Tablas que se crearán -->
    <p style="font-size:.8rem;color:var(--text2);margin-bottom:12px;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Tablas que se crearán:</p>
    <div class="tables-list">
        <div class="table-badge"><span>🎓</span> estudiante</div>
        <div class="table-badge"><span>📚</span> carrera</div>
        <div class="table-badge"><span>📖</span> asignatura</div>
        <div class="table-badge"><span>👩‍🏫</span> docente</div>
        <div class="table-badge"><span>🔗</span> docente_asignatura</div>
        <div class="table-badge"><span>📝</span> inscripcion</div>
        <div class="table-badge"><span>📊</span> nota_bimestral</div>
        <div class="table-badge"><span>📋</span> historial</div>
        <div class="table-badge"><span>💰</span> pago_matricula</div>
        <div class="table-badge"><span>👤</span> usuario</div>
        <div class="table-badge"><span>🔑</span> rol</div>
        <div class="table-badge"><span>👁</span> vistas (2)</div>
    </div>

    <!-- Roles -->
    <p style="font-size:.8rem;color:var(--text2);margin-bottom:12px;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Roles del sistema:</p>
    <div class="roles-grid">
        <div class="role-card role-admin">
            <div class="role-icon">🛡</div>
            <div class="role-name">Admin</div>
            <div class="role-perms">Acceso total · Config. sistema · Gestionar usuarios</div>
        </div>
        <div class="role-card role-profe">
            <div class="role-icon">👨‍🏫</div>
            <div class="role-name">Profesor ✨</div>
            <div class="role-perms">Cargar notas · Ver alumnos · Impartir clases</div>
        </div>
        <div class="role-card role-student">
            <div class="role-icon">🎓</div>
            <div class="role-name">Estudiante</div>
            <div class="role-perms">Ver notas · Inscripción · Ver horario</div>
        </div>
    </div>

    <div class="sep"></div>

    <!-- Formulario -->
    <?php if (!$install): ?>
    <form method="POST">
        <button type="submit" name="install" class="btn">
            🚀 Instalar Base de Datos Ahora
        </button>
    </form>
    <?php endif; ?>

    <!-- Log de instalación -->
    <?php if ($install && !empty($log)): ?>
    <div class="log-container">
        <?php foreach ($log as $entry): ?>
            <div class="log-entry log-<?= $entry['type'] ?>">
                <span><?= $entry['type']==='ok' ? '✔' : ($entry['type']==='err' ? '✕' : 'ℹ') ?></span>
                <span><?= $entry['msg'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Banner de éxito -->
    <?php if ($success): ?>
    <div class="success-banner">
        <h3>✅ ¡Instalación completada!</h3>
        <p style="color:var(--text2);font-size:.88rem">La base de datos <strong>inst</strong> fue creada con todas sus tablas, roles y datos de ejemplo.</p>
        <div class="links">
            <a href="calificaciones.html" class="link-btn link-primary">📝 Sistema de Calificaciones</a>
            <a href="deepseek_html_20260916_c430fa.html" class="link-btn link-secondary">📊 Diagrama ER</a>
            <a href="http://localhost/phpmyadmin/index.php?db=inst" target="_blank" class="link-btn link-secondary">🗄 phpMyAdmin</a>
        </div>
    </div>
    <?php elseif ($install): ?>
    <div style="text-align:center;margin-top:20px">
        <form method="POST">
            <button type="submit" name="install" class="btn" style="max-width:280px">
                🔄 Reintentar Instalación
            </button>
        </form>
    </div>
    <?php endif; ?>

    <p style="text-align:center;color:var(--text2);font-size:.75rem;margin-top:24px">
        ⚠ Elimina este archivo (<code>install_db.php</code>) después de instalar por seguridad.
    </p>
</div>
</body>
</html>
