<?php
session_start();

require_once 'config/db.php';
require_once 'models/funciones.php';

$action = $_GET['action'] ?? 'inicio';

// ============================================
// ACCIONES PÚBLICAS (No requieren sesión)
// ============================================
$acciones_publicas = ['inicio', 'login', 'procesar_login', 'verificar_ci', 'verificar_inscripcion', 'registro', 'procesar_registro'];

if (!in_array($action, $acciones_publicas) && !isset($_SESSION['usuario_id'])) {
    header('Location: index.php?action=login');
    exit;
}

// ============================================
// VALIDACIÓN DE ROLES
// ============================================
if (isset($_SESSION['usuario_id'])) {
    $rol = $_SESSION['rol_id'];

    // --- ADMIN ---
    if (strpos($action, 'admin_') === 0 && $rol != 1) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- SECRETARIA ---
    if (strpos($action, 'secretaria_') === 0 && $rol != 2) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- ESTUDIANTE ---
    if (strpos($action, 'estudiante_') === 0 && $rol != 3) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- DOCENTE ---
    if (strpos($action, 'docente_') === 0 && $rol != 4) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- DIRECCION ACADEMICA ---
    if (strpos($action, 'direccion_acad_') === 0 && $rol != 5) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- RECTOR ---
    if (strpos($action, 'rector_') === 0 && $rol != 6) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- JEFE DE CARRERA ---
    if (strpos($action, 'jefe_carrera_') === 0 && $rol != 7) {
        header('Location: index.php?action=login');
        exit;
    }
    // --- SUPER ADMIN ---
    if (strpos($action, 'super_admin_') === 0 && $rol != 8) {
        header('Location: index.php?action=login');
        exit;
    }

    // PERMISOS PARA REPORTES DEL ESTUDIANTE
    if ($action === 'generar_reporte' && $rol != 3) {
        header('Location: index.php?action=login');
        exit;
    }
}

// ============================================
// PERMISOS ESPECIALES PARA REPORTES COMPARTIDOS
// ============================================

// Reportes de Dirección Académica: DIRECCION (5), RECTOR (6), JEFE (7), SUPER_ADMIN (8)
if (strpos($action, 'dir_reporte_') === 0) {
    if (!in_array($rol ?? 0, [5, 6, 7, 8])) {
        header('Location: index.php?action=login');
        exit;
    }
}

// Reportes de Rector: RECTOR (6), SUPER_ADMIN (8)
if (strpos($action, 'rector_reporte_') === 0) {
    if (!in_array($rol ?? 0, [6, 8])) {
        header('Location: index.php?action=login');
        exit;
    }
}

// Reportes de Jefe de Carrera: JEFE (7), SUPER_ADMIN (8)
if (strpos($action, 'jefe_reporte_') === 0) {
    if (!in_array($rol ?? 0, [7, 8])) {
        header('Location: index.php?action=login');
        exit;
    }
}

// Reportes compartidos entre Admin, Secretaria y Docente
if (in_array($action, ['reporte_estudiantes', 'secretaria_reporte_estudiantes', 'reporte_estudiante_gestion'])) {
    if (!in_array($rol ?? 0, [1, 2, 4])) {
        header('Location: index.php?action=login');
        exit;
    }
}

// Gestión de docentes: ADMIN (1), SECRETARIA (2), DIRECCION (5), RECTOR (6), SUPER_ADMIN (8)
if (in_array($action, ['gestion_docentes', 'ver_materias_docente'])) {
    if (!in_array($rol ?? 0, [1, 2, 5, 6, 8])) {
        header('Location: index.php?action=login');
        exit;
    }
}

// ============================================
// PROCESAMIENTO DE FORMULARIOS (POST)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // LOGIN
    if ($action === 'procesar_login') {
        $usuario = trim($_POST['usuario'] ?? '');
        $clave = trim($_POST['clave'] ?? '');

        if (empty($usuario) || empty($clave)) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Todos los campos son obligatorios'];
            header('Location: index.php?action=inicio');
            exit;
        }

        $datos = login($conn, $usuario, $clave);

        if (isset($datos['error'])) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => $datos['msg']];
            header('Location: index.php?action=inicio');
            exit;
        }

        if ($datos) {
            $_SESSION['usuario_id'] = $datos['id'];
            $_SESSION['usuario_nombre'] = $datos['usuario'];
            $_SESSION['rol_id'] = $datos['id_rol'];
            $_SESSION['rol_nombre'] = $datos['rol_nombre'];

            if ($datos['id_rol'] == 3) {
                $_SESSION['estudiante_ci'] = $datos['usuario'];
            }

            switch ($datos['id_rol']) {
                case 1:
                    $redirect = 'admin_dashboard';
                    break;
                case 2:
                    $redirect = 'secretaria_dashboard';
                    break;
                case 3:
                    $redirect = 'estudiante_dashboard';
                    break;
                case 4:
                    $redirect = 'docente_dashboard';
                    break;
                case 5:
                    $redirect = 'direccion_acad_dashboard';
                    break;
                case 6:
                    $redirect = 'rector_dashboard';
                    break;
                case 7:
                    $redirect = 'jefe_carrera_dashboard';
                    break;
                case 8:
                    $redirect = 'super_admin_dashboard';
                    break;
                default:
                    $redirect = 'login';
                    break;
            }

            header("Location: index.php?action=$redirect");
            exit;
        }
    }

    // ============================================
    // GUARDAR DOCENTE
    // ============================================
    if ($action === 'guardar_docente' && in_array($_SESSION['rol_id'] ?? 0, [1, 2, 5, 6, 8])) {
        $ok = guardar_docente(
            $conn,
            trim($_POST['ci']),
            trim($_POST['nombre']),
            trim($_POST['ap_pat']),
            trim($_POST['ap_mat'] ?? ''),
            $_POST['genero'] ?? null,
            trim($_POST['cel'] ?? ''),
            trim($_POST['email'] ?? '')
        );

        if ($ok) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Docente registrado. Usuario: ' . trim($_POST['ci']) . ' / Clave: 123456'];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: el CI ya está registrado o faltan datos obligatorios.'];
        }
        header('Location: index.php?action=gestion_docentes');
        exit;
    }

    // ============================================
    // ASIGNAR MATERIA A DOCENTE
    // ============================================
    if ($action === 'asignar_materia_docente' && in_array($_SESSION['rol_id'] ?? 0, [1, 2, 5, 6, 8])) {
        $id_docente = (int)($_POST['id_docente'] ?? 0);
        $cod_asig   = trim($_POST['cod_asig'] ?? '');

        $r = asignar_materia_docente($conn, $id_docente, $cod_asig);
        $_SESSION['alerta'] = ['tipo' => 'info', 'msg' => $r['msg']];
        header("Location: index.php?action=ver_materias_docente&id_docente=$id_docente");
        exit;
    }

    // ============================================
    // QUITAR MATERIA A DOCENTE
    // ============================================
    if ($action === 'quitar_materia_docente' && in_array($_SESSION['rol_id'] ?? 0, [1, 2, 5, 6, 8])) {
        $id_docente = (int)($_POST['id_docente'] ?? 0);
        $cod_asig   = trim($_POST['cod_asig'] ?? '');

        $r = quitar_materia_docente($conn, $id_docente, $cod_asig);
        $_SESSION['alerta'] = ['tipo' => 'info', 'msg' => $r['msg']];
        header("Location: index.php?action=ver_materias_docente&id_docente=$id_docente");
        exit;
    }

    // ============================================
    // DOCENTE: GUARDAR NOTAS POR BIMESTRE
    // ============================================
    if ($action === 'docente_guardar_notas' && isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4) {
        $docente = obtener_docente_por_ci($conn, $_SESSION['usuario_nombre']);
        if (!$docente) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'No se encontró el registro del docente'];
            header('Location: index.php?action=docente_dashboard');
            exit;
        }

        $cod_asig = $_POST['cod_asig'];
        $bimestre = (int)$_POST['bimestre'];
        $ci_est_array = $_POST['ci_est'];
        $teorico_array = $_POST['nota_teorico'];
        $practico_array = $_POST['nota_practico'];
        $obs_array = $_POST['observaciones'] ?? [];

        $exito_total = true;
        mysqli_begin_transaction($conn);

        for ($i = 0; $i < count($ci_est_array); $i++) {
            $obs = isset($obs_array[$i]) ? $obs_array[$i] : '';
            $teorico = isset($teorico_array[$i]) ? $teorico_array[$i] : '';
            $practico = isset($practico_array[$i]) ? $practico_array[$i] : '';

            $guardar = guardar_notas_bimestre_docente($conn, $ci_est_array[$i], $cod_asig, $docente['id_docente'], $bimestre, $teorico, $practico, $obs);
            if (!$guardar) {
                $exito_total = false;
                break;
            }
        }

        if ($exito_total) {
            mysqli_commit($conn);
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Notas del $bimestre Bimestre guardadas correctamente."];
        } else {
            mysqli_rollback($conn);
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error al guardar algunas notas.'];
        }

        header("Location: index.php?action=docente_ver_estudiantes&cod_asig=$cod_asig&bimestre=$bimestre");
        exit;
    }

    // ============================================
    // DOCENTE: GUARDAR NOTAS VISTA ANUAL
    // ============================================
    if ($action === 'docente_guardar_notas_anual' && isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4) {
        $docente = obtener_docente_por_ci($conn, $_SESSION['usuario_nombre']);
        if (!$docente) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'No se encontró el registro del docente'];
            header('Location: index.php?action=docente_dashboard');
            exit;
        }

        $cod_asig            = $_POST['cod_asig'];
        $ci_est_array        = $_POST['ci_est'] ?? [];
        $segundo_turno_array = $_POST['segundo_turno'] ?? [];   // 🆕 ARRAY de NOTAS indexado
        $exito_total         = true;

        foreach ($ci_est_array as $index => $ci) {
            // 🆕 Leer la NOTA del 2do turno (número entero 0-100)
            $nota_segundo = isset($segundo_turno_array[$index]) && $segundo_turno_array[$index] !== ''
                ? (int)$segundo_turno_array[$index]
                : 0;

            $obs = $_POST['observaciones'][$index] ?? '';

            // Guardar cada bimestre
            for ($bim = 1; $bim <= 4; $bim++) {
                $teorico  = $_POST["nota_teorico$bim"][$index] ?? '';
                $practico = $_POST["nota_practico$bim"][$index] ?? '';

                $ok = guardar_notas_bimestre_docente(
                    $conn,
                    $ci,
                    $cod_asig,
                    $docente['id_docente'],
                    $bim,
                    $teorico,
                    $practico,
                    $obs,
                    $nota_segundo
                );
                if (!$ok) $exito_total = false;
            }
        }

        if ($exito_total) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Notas anuales guardadas correctamente.'];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error al guardar algunas notas.'];
        }
        header("Location: index.php?action=docente_ver_estudiantes&cod_asig=" . urlencode($cod_asig) . "&vista=anual");
        exit;
    }

    // ============================================
    // ADMIN: CREAR USUARIO
    // ============================================
    if ($action === 'admin_crear_usuario' && in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        $usuario = mysqli_real_escape_string($conn, trim($_POST['usuario'] ?? ''));
        $clave   = mysqli_real_escape_string($conn, trim($_POST['clave'] ?? ''));
        $id_rol  = (int)($_POST['id_rol'] ?? 0);
        $activo  = isset($_POST['activo']) ? 1 : 0;

        if (empty($usuario) || empty($clave) || $id_rol <= 0) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Usuario, clave y rol son obligatorios.'];
            header('Location: index.php?action=admin_dashboard&tab=usuarios&modo=nuevo');
            exit;
        }

        $q_dup = "SELECT id FROM usuario WHERE usuario = '$usuario' LIMIT 1";
        if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
            $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => "El usuario $usuario ya existe."];
            header('Location: index.php?action=admin_dashboard&tab=usuarios&modo=nuevo');
            exit;
        }

        $sql = "INSERT INTO usuario (usuario, clave, id_rol, activo) 
                VALUES ('$usuario', '$clave', $id_rol, $activo)";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Usuario $usuario creado correctamente."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
        header('Location: index.php?action=admin_dashboard&tab=usuarios');
        exit;
    }

    // ============================================
    // ADMIN: ACTUALIZAR USUARIO
    // ============================================
    if ($action === 'admin_actualizar_usuario' && in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        $id_usuario = (int)($_POST['id_usuario'] ?? 0);
        $usuario    = mysqli_real_escape_string($conn, trim($_POST['usuario'] ?? ''));
        $clave      = trim($_POST['clave'] ?? '');
        $id_rol     = (int)($_POST['id_rol'] ?? 0);
        $activo     = isset($_POST['activo']) ? 1 : 0;

        if ($id_usuario <= 0 || empty($usuario) || $id_rol <= 0) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Datos incompletos.'];
            header('Location: index.php?action=admin_dashboard&tab=usuarios');
            exit;
        }

        $q_dup = "SELECT id FROM usuario WHERE usuario = '$usuario' AND id <> $id_usuario LIMIT 1";
        if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
            $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => "El usuario $usuario ya está en uso."];
            header("Location: index.php?action=admin_dashboard&tab=usuarios&modo=editar&id=$id_usuario");
            exit;
        }

        if (!empty($clave)) {
            $clave_esc = mysqli_real_escape_string($conn, $clave);
            $sql = "UPDATE usuario SET usuario='$usuario', clave='$clave_esc', id_rol=$id_rol, activo=$activo WHERE id=$id_usuario";
        } else {
            $sql = "UPDATE usuario SET usuario='$usuario', id_rol=$id_rol, activo=$activo WHERE id=$id_usuario";
        }

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Usuario $usuario actualizado."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
        header('Location: index.php?action=admin_dashboard&tab=usuarios');
        exit;
    }

    // ============================================
    // ADMIN: CREAR USUARIO INSTITUCIONAL
    // ============================================
    if ($action === 'admin_crear_usuario_institucional' && in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        $usuario = mysqli_real_escape_string($conn, trim($_POST['usuario'] ?? ''));
        $clave   = mysqli_real_escape_string($conn, trim($_POST['clave'] ?? ''));
        $id_rol  = (int)($_POST['id_rol'] ?? 0);
        $activo  = isset($_POST['activo']) ? 1 : 0;

        if (empty($usuario) || empty($clave) || !in_array($id_rol, [5, 6, 7, 8])) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Usuario, clave y rol institucional (5-8) son obligatorios.'];
            header('Location: index.php?action=admin_dashboard&tab=institucional&modo=nuevo');
            exit;
        }

        $q_dup = "SELECT id FROM usuario WHERE usuario = '$usuario' LIMIT 1";
        if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
            $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => "El usuario $usuario ya existe."];
            header('Location: index.php?action=admin_dashboard&tab=institucional&modo=nuevo');
            exit;
        }

        $sql = "INSERT INTO usuario (usuario, clave, id_rol, activo) 
                VALUES ('$usuario', '$clave', $id_rol, $activo)";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Usuario institucional $usuario creado."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
        header('Location: index.php?action=admin_dashboard&tab=institucional');
        exit;
    }

    // ============================================
    // ADMIN: ACTUALIZAR USUARIO INSTITUCIONAL
    // ============================================
    if ($action === 'admin_actualizar_usuario_institucional' && in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        $id_usuario = (int)($_POST['id_usuario'] ?? 0);
        $usuario    = mysqli_real_escape_string($conn, trim($_POST['usuario'] ?? ''));
        $clave      = trim($_POST['clave'] ?? '');
        $id_rol     = (int)($_POST['id_rol'] ?? 0);
        $activo     = isset($_POST['activo']) ? 1 : 0;

        if ($id_usuario <= 0 || empty($usuario) || !in_array($id_rol, [5, 6, 7, 8])) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Datos incompletos.'];
            header('Location: index.php?action=admin_dashboard&tab=institucional');
            exit;
        }

        if (!empty($clave)) {
            $clave_esc = mysqli_real_escape_string($conn, $clave);
            $sql = "UPDATE usuario SET usuario='$usuario', clave='$clave_esc', id_rol=$id_rol, activo=$activo WHERE id=$id_usuario";
        } else {
            $sql = "UPDATE usuario SET usuario='$usuario', id_rol=$id_rol, activo=$activo WHERE id=$id_usuario";
        }

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Usuario $usuario actualizado."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
        header('Location: index.php?action=admin_dashboard&tab=institucional');
        exit;
    }

    // ============================================
    // ADMIN: ACTUALIZAR PERMISOS DE UN ROL
    // ============================================
    if ($action === 'admin_actualizar_permisos' && in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        $id_rol = (int)($_POST['id_rol'] ?? 0);
        $permisos = $_POST['permisos'] ?? [];

        if ($id_rol <= 0) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Rol inválido.'];
            header('Location: index.php?action=admin_dashboard&tab=roles');
            exit;
        }

        mysqli_begin_transaction($conn);
        try {
            mysqli_query($conn, "DELETE FROM rol_permiso WHERE id_rol = $id_rol");

            foreach ($permisos as $id_perm) {
                $id_perm = (int)$id_perm;
                if ($id_perm > 0) {
                    mysqli_query($conn, "INSERT INTO rol_permiso (id_rol, id_permiso) VALUES ($id_rol, $id_perm)");
                }
            }

            mysqli_commit($conn);
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Permisos actualizados correctamente.'];
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error al actualizar permisos.'];
        }

        header("Location: index.php?action=admin_dashboard&tab=roles&rol=$id_rol");
        exit;
    }

    // ============================================
    // JEFE DE CARRERA: CREAR MATERIA
    // ============================================
    if ($action === 'crear_materia' && in_array($_SESSION['rol_id'] ?? 0, [7, 8])) {
        $codigo   = mysqli_real_escape_string($conn, trim($_POST['codigo'] ?? ''));
        $nombre   = mysqli_real_escape_string($conn, trim($_POST['nombre'] ?? ''));
        $nivel    = (int)($_POST['nivel'] ?? 100);
        $semestre = !empty($_POST['semestre']) ? (int)$_POST['semestre'] : 'NULL';
        $horas    = !empty($_POST['horas']) ? (int)$_POST['horas'] : 'NULL';
        $hora     = mysqli_real_escape_string($conn, $_POST['hora'] ?? '08:00:00');
        $gestion  = mysqli_real_escape_string($conn, $_POST['gestion'] ?? date('Y'));
        $id_carrera = mysqli_real_escape_string($conn, $_POST['id_carrera'] ?? '');
        $activo   = isset($_POST['activo']) ? 1 : 0;

        if (empty($codigo) || empty($nombre) || empty($id_carrera)) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Código, nombre y carrera son obligatorios.'];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=materias&modo=nuevo');
            exit;
        }

        $q_dup = "SELECT codigo FROM asignatura WHERE codigo = '$codigo' LIMIT 1";
        if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
            $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => "Ya existe una materia con el código $codigo."];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=materias&modo=nuevo');
            exit;
        }

        $sql = "INSERT INTO asignatura 
                    (codigo, nombre, horas, gestion, hora, id_carrera, nivel, semestre, activo)
                VALUES 
                    ('$codigo', '$nombre', $horas, '$gestion', '$hora', '$id_carrera', $nivel, $semestre, $activo)";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Materia $codigo creada correctamente."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }

        header('Location: index.php?action=jefe_carrera_dashboard&tab=materias');
        exit;
    }

    // ============================================
    // JEFE DE CARRERA: ACTUALIZAR MATERIA
    // ============================================
    if ($action === 'actualizar_materia' && in_array($_SESSION['rol_id'] ?? 0, [7, 8])) {
        $codigo_original = mysqli_real_escape_string($conn, $_POST['codigo_original'] ?? '');
        $codigo   = mysqli_real_escape_string($conn, trim($_POST['codigo'] ?? ''));
        $nombre   = mysqli_real_escape_string($conn, trim($_POST['nombre'] ?? ''));
        $nivel    = (int)($_POST['nivel'] ?? 100);
        $semestre = !empty($_POST['semestre']) ? (int)$_POST['semestre'] : 'NULL';
        $horas    = !empty($_POST['horas']) ? (int)$_POST['horas'] : 'NULL';
        $hora     = mysqli_real_escape_string($conn, $_POST['hora'] ?? '08:00:00');
        $gestion  = mysqli_real_escape_string($conn, $_POST['gestion'] ?? date('Y'));
        $activo   = isset($_POST['activo']) ? 1 : 0;

        if (empty($codigo_original) || empty($codigo) || empty($nombre)) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Datos incompletos.'];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=materias');
            exit;
        }

        if ($codigo !== $codigo_original) {
            $q_dup = "SELECT codigo FROM asignatura WHERE codigo = '$codigo' LIMIT 1";
            if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
                $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => "Ya existe otra materia con el código $codigo."];
                header("Location: index.php?action=jefe_carrera_dashboard&tab=materias&modo=editar&codigo=" . urlencode($codigo_original));
                exit;
            }
        }

        mysqli_begin_transaction($conn);
        try {
            $sql = "UPDATE asignatura SET
                        codigo = '$codigo',
                        nombre = '$nombre',
                        nivel = $nivel,
                        semestre = $semestre,
                        horas = $horas,
                        hora = '$hora',
                        gestion = '$gestion',
                        activo = $activo
                    WHERE codigo = '$codigo_original'";
            mysqli_query($conn, $sql);

            if ($codigo !== $codigo_original) {
                mysqli_query($conn, "UPDATE historial SET cod_asig = '$codigo' WHERE cod_asig = '$codigo_original'");
                mysqli_query($conn, "UPDATE inscripcion SET cod_asig = '$codigo' WHERE cod_asig = '$codigo_original'");
                mysqli_query($conn, "UPDATE paralelo SET cod_asig = '$codigo' WHERE cod_asig = '$codigo_original'");
                mysqli_query($conn, "UPDATE asignacion_docente SET cod_asig = '$codigo' WHERE cod_asig = '$codigo_original'");
                mysqli_query($conn, "UPDATE prerequisito SET cod_asig = '$codigo' WHERE cod_asig = '$codigo_original'");
                mysqli_query($conn, "UPDATE prerequisito SET cod_req = '$codigo' WHERE cod_req = '$codigo_original'");
            }

            mysqli_commit($conn);
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Materia $codigo actualizada correctamente."];
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error al actualizar: ' . $e->getMessage()];
        }

        header('Location: index.php?action=jefe_carrera_dashboard&tab=materias');
        exit;
    }

    // ============================================
    // JEFE DE CARRERA: CREAR PARALELO
    // ============================================
    if ($action === 'crear_paralelo' && in_array($_SESSION['rol_id'] ?? 0, [7, 8])) {
        $cod_asig  = mysqli_real_escape_string($conn, $_POST['cod_asig'] ?? '');
        $gestion_f = mysqli_real_escape_string($conn, $_POST['gestion'] ?? '');
        $turno     = mysqli_real_escape_string($conn, $_POST['turno'] ?? '');
        $grupo     = mysqli_real_escape_string($conn, $_POST['grupo'] ?? '');
        $cupo      = (int)($_POST['cupo_max'] ?? 40);
        $aula      = mysqli_real_escape_string($conn, $_POST['aula'] ?? '');
        $activo    = isset($_POST['activo']) ? 1 : 0;
        $id_docente = !empty($_POST['id_docente']) ? (int)$_POST['id_docente'] : 'NULL';

        if (empty($cod_asig) || empty($gestion_f) || empty($turno) || empty($grupo)) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Faltan campos obligatorios.'];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=paralelos&modo=nuevo');
            exit;
        }

        $q_dup = "SELECT id FROM paralelo 
                  WHERE cod_asig = '$cod_asig' 
                    AND gestion = '$gestion_f' 
                    AND turno = '$turno' 
                    AND grupo = '$grupo' 
                  LIMIT 1";
        if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
            $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => 'Ya existe un paralelo con esa combinación.'];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=paralelos&modo=nuevo');
            exit;
        }

        $sql = "INSERT INTO paralelo 
                    (cod_asig, gestion, turno, grupo, cupo_max, aula, id_docente, activo)
                VALUES 
                    ('$cod_asig', '$gestion_f', '$turno', '$grupo', $cupo, '$aula', $id_docente, $activo)";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Paralelo creado correctamente.'];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }

        header('Location: index.php?action=jefe_carrera_dashboard&tab=paralelos');
        exit;
    }

    // ============================================
    // JEFE DE CARRERA: ACTUALIZAR PARALELO
    // ============================================
    if ($action === 'actualizar_paralelo' && in_array($_SESSION['rol_id'] ?? 0, [7, 8])) {
        $id        = (int)($_POST['id'] ?? 0);
        $cod_asig  = mysqli_real_escape_string($conn, $_POST['cod_asig'] ?? '');
        $gestion_f = mysqli_real_escape_string($conn, $_POST['gestion'] ?? '');
        $turno     = mysqli_real_escape_string($conn, $_POST['turno'] ?? '');
        $grupo     = mysqli_real_escape_string($conn, $_POST['grupo'] ?? '');
        $cupo      = (int)($_POST['cupo_max'] ?? 40);
        $aula      = mysqli_real_escape_string($conn, $_POST['aula'] ?? '');
        $activo    = isset($_POST['activo']) ? 1 : 0;
        $id_docente = !empty($_POST['id_docente']) ? (int)$_POST['id_docente'] : 'NULL';

        if ($id <= 0) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'ID inválido.'];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=paralelos');
            exit;
        }

        $q_dup = "SELECT id FROM paralelo 
                  WHERE cod_asig = '$cod_asig' 
                    AND gestion = '$gestion_f' 
                    AND turno = '$turno' 
                    AND grupo = '$grupo' 
                    AND id <> $id
                  LIMIT 1";
        if (mysqli_num_rows(mysqli_query($conn, $q_dup)) > 0) {
            $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => 'Ya existe otro paralelo con esos datos.'];
            header("Location: index.php?action=jefe_carrera_dashboard&tab=paralelos&modo=editar&id=$id");
            exit;
        }

        $sql = "UPDATE paralelo SET
                    cod_asig = '$cod_asig',
                    gestion = '$gestion_f',
                    turno = '$turno',
                    grupo = '$grupo',
                    cupo_max = $cupo,
                    aula = '$aula',
                    id_docente = $id_docente,
                    activo = $activo
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Paralelo actualizado correctamente.'];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }

        header('Location: index.php?action=jefe_carrera_dashboard&tab=paralelos');
        exit;
    }

    // ============================================
    // JEFE DE CARRERA: APROBAR / RECHAZAR REPORTE
    // ============================================
    if ($action === 'aprobar_reporte' && in_array($_SESSION['rol_id'] ?? 0, [7, 8])) {
        $id_reporte = (int)($_POST['id_reporte'] ?? 0);
        $accion_rep = $_POST['accion'] ?? '';
        $comentario = mysqli_real_escape_string($conn, $_POST['comentario'] ?? '');
        $estado     = $accion_rep === 'aprobar' ? 'APROBADO' : 'RECHAZADO';
        $id_aprobador = $_SESSION['id_docente'] ?? 1;

        if ($id_reporte <= 0) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'ID de reporte inválido.'];
            header('Location: index.php?action=jefe_carrera_dashboard&tab=reportes');
            exit;
        }

        $sql = "INSERT INTO aprobacion_reporte (id_reporte, id_aprobador, estado, comentario)
                VALUES ($id_reporte, $id_aprobador, '$estado', '$comentario')
                ON DUPLICATE KEY UPDATE 
                    estado = '$estado',
                    comentario = '$comentario',
                    fecha = CURRENT_TIMESTAMP";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Reporte $estado correctamente."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: ' . mysqli_error($conn)];
        }

        header('Location: index.php?action=jefe_carrera_dashboard&tab=reportes');
        exit;
    }
}

// ============================================
// ACCIONES GET QUE MODIFICAN ESTADO
// ============================================
if ($action === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php?action=inicio');
    exit;
}

// ============================================
// ENDPOINT AJAX: verificar_inscripcion
// ============================================
if ($action === 'verificar_inscripcion') {
    header('Content-Type: application/json');
    $ci = isset($_GET['ci']) ? trim($_GET['ci']) : '';

    if (empty($ci)) {
        echo json_encode(['tipo' => 'no_registrado', 'registrado' => false]);
        exit;
    }

    $ci_esc = limpiar($conn, $ci);

    $q_user = "SELECT u.id, u.usuario, u.id_rol, u.activo AS usuario_activo, r.nombre AS rol_nombre
               FROM usuario u
               INNER JOIN rol r ON r.id = u.id_rol
               WHERE u.usuario = '$ci_esc' LIMIT 1";
    $r_user = mysqli_query($conn, $q_user);
    $user = $r_user ? mysqli_fetch_assoc($r_user) : null;

    if (!$user) {
        echo json_encode(['tipo' => 'no_registrado', 'registrado' => false]);
        exit;
    }

    if ($user['usuario_activo'] == 0) {
        echo json_encode(['tipo' => 'desactivado', 'registrado' => true]);
        exit;
    }

    $id_rol = (int)$user['id_rol'];
    $rol_nombre = strtoupper($user['rol_nombre']);

    if ($id_rol == 3) {
        $info = verificar_estudiante_registrado($conn, $ci);
        if ($info['registrado']) {
            $d = $info['datos'];

            if ($d['activo'] == 0) {
                echo json_encode(['tipo' => 'desactivado', 'registrado' => true]);
                exit;
            }

            $q_tipo = "SELECT tipo FROM inscripcion WHERE ci_est = '$ci_esc' AND activo = 1 LIMIT 1";
            $r_tipo = mysqli_query($conn, $q_tipo);
            $tipo_data = $r_tipo ? mysqli_fetch_assoc($r_tipo) : null;

            if (!$tipo_data) {
                echo json_encode([
                    'tipo' => 'estudiante_no_inscrito',
                    'registrado' => true,
                    'nombre_completo' => trim($d['nombre'] . ' ' . $d['ap_pat'] . ' ' . ($d['ap_mat'] ?? ''))
                ]);
                exit;
            }

            $carr_id = limpiar($conn, $d['id_carrera'] ?? 'SIS-INF');
            $q_carr = "SELECT nombre FROM carrera WHERE id = '$carr_id'";
            $r_carr = mysqli_query($conn, $q_carr);
            $carr_data = $r_carr ? mysqli_fetch_assoc($r_carr) : null;

            echo json_encode([
                'tipo' => 'estudiante_inscrito',
                'registrado' => true,
                'nombre_completo' => trim($d['nombre'] . ' ' . $d['ap_pat'] . ' ' . ($d['ap_mat'] ?? '')),
                'carrera' => $carr_data['nombre'] ?? 'N/A',
                'tipo_inscripcion' => $tipo_data['tipo'] ?? 'N/A',
                'usuario' => $d['usuario'] ?? $ci
            ]);
            exit;
        } else {
            echo json_encode(['tipo' => 'estudiante_no_inscrito', 'registrado' => true]);
            exit;
        }
    }

    $nombre_completo = '';
    $q_doc = "SELECT nombre, ap_pat, ap_mat FROM docente WHERE ci = '$ci_esc' LIMIT 1";
    $r_doc = mysqli_query($conn, $q_doc);
    if ($r_doc && $row_doc = mysqli_fetch_assoc($r_doc)) {
        $nombre_completo = trim($row_doc['nombre'] . ' ' . $row_doc['ap_pat'] . ' ' . ($row_doc['ap_mat'] ?? ''));
    }

    $mapa_roles = [
        1 => 'admin',
        2 => 'secretaria',
        4 => 'docente',
        5 => 'direccion_academica',
        6 => 'rector',
        7 => 'jefe_carrera',
        8 => 'super_admin',
    ];

    $tipo = $mapa_roles[$id_rol] ?? 'no_registrado';

    echo json_encode([
        'tipo' => $tipo,
        'registrado' => true,
        'nombre' => $nombre_completo,
        'rol_nombre' => $rol_nombre
    ]);
    exit;
}

// ============================================
// ACCIONES GET (cambios de estado)
// ============================================
if ($action === 'admin_cambiar_estado_usuario') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $id = (int)($_GET['id'] ?? 0);
    $estado = (int)($_GET['estado'] ?? 0);
    $redirect = $_GET['redirect'] ?? '';

    if ($id > 0 && $id != $_SESSION['usuario_id']) {
        mysqli_query($conn, "UPDATE usuario SET activo = $estado WHERE id = $id");
        $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Estado del usuario actualizado.'];
    } else {
        $_SESSION['alerta'] = ['tipo' => 'warning', 'msg' => 'No puedes cambiar tu propio estado.'];
    }

    if ($redirect === 'institucional') {
        header('Location: index.php?action=admin_dashboard&tab=institucional');
    } else {
        header('Location: index.php?action=admin_dashboard&tab=usuarios');
    }
    exit;
}

if ($action === 'admin_cambiar_rol') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $id_usuario = (int)($_POST['id_usuario'] ?? 0);
    $nuevo_rol = (int)($_POST['nuevo_rol'] ?? 0);

    if ($id_usuario > 0 && $nuevo_rol > 0) {
        mysqli_query($conn, "UPDATE usuario SET id_rol = $nuevo_rol WHERE id = $id_usuario");
        $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Rol actualizado.'];
    }
    header('Location: index.php?action=admin_dashboard&tab=usuarios');
    exit;
}

if ($action === 'admin_desactivar_estudiante') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $ci = mysqli_real_escape_string($conn, $_GET['ci'] ?? '');
    if (!empty($ci)) {
        mysqli_query($conn, "UPDATE estudiante SET activo = 0 WHERE ci = '$ci'");
        mysqli_query($conn, "UPDATE usuario SET activo = 0 WHERE usuario = '$ci'");
        $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Estudiante desactivado.'];
    }
    header('Location: index.php?action=admin_dashboard&tab=estudiantes');
    exit;
}

if ($action === 'admin_activar_estudiante') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $ci = mysqli_real_escape_string($conn, $_GET['ci'] ?? '');
    if (!empty($ci)) {
        mysqli_query($conn, "UPDATE estudiante SET activo = 1 WHERE ci = '$ci'");
        mysqli_query($conn, "UPDATE usuario SET activo = 1 WHERE usuario = '$ci'");
        $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Estudiante reactivado.'];
    }
    header('Location: index.php?action=admin_dashboard&tab=estudiantes');
    exit;
}

if ($action === 'admin_cambiar_estado_carrera') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $id = mysqli_real_escape_string($conn, $_GET['id'] ?? '');
    $estado = (int)($_GET['estado'] ?? 0);

    if (!empty($id)) {
        mysqli_query($conn, "UPDATE carrera SET activo = $estado WHERE id = '$id'");
        mysqli_query($conn, "UPDATE asignatura SET activo = $estado WHERE id_carrera = '$id'");
        $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => 'Estado de la carrera actualizado.'];
    }
    header('Location: index.php?action=admin_dashboard&tab=carreras');
    exit;
}

// ============================================
// DOCENTE: DAR DE BAJA
// ============================================
if ($action === 'dar_baja_docente') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 2, 5, 6, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $id_docente = (int)($_GET['id_docente'] ?? 0);

    if ($id_docente > 0) {
        $q_doc = "SELECT ci, nombre, ap_pat FROM docente WHERE id_docente = $id_docente LIMIT 1";
        $doc = mysqli_fetch_assoc(mysqli_query($conn, $q_doc));

        if ($doc) {
            $ci_doc = mysqli_real_escape_string($conn, $doc['ci']);

            mysqli_query($conn, "UPDATE docente SET activo = 0 WHERE id_docente = $id_docente");
            mysqli_query($conn, "UPDATE usuario SET activo = 0 WHERE usuario = '$ci_doc' AND id_rol = 4");

            $_SESSION['alerta'] = [
                'tipo' => 'success',
                'msg' => "Docente {$doc['nombre']} {$doc['ap_pat']} dado de baja correctamente."
            ];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Docente no encontrado.'];
        }
    } else {
        $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'ID de docente inválido.'];
    }

    header('Location: index.php?action=admin_dashboard&tab=docentes');
    exit;
}

// ============================================
// DOCENTE: DESACTIVAR (desde panel admin)
// ============================================
if ($action === 'admin_desactivar_docente') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $id = (int)($_GET['id'] ?? 0);

    if ($id > 0) {
        $doc = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ci, nombre, ap_pat FROM docente WHERE id_docente = $id LIMIT 1"));

        if ($doc) {
            $ci_doc = mysqli_real_escape_string($conn, $doc['ci']);
            mysqli_query($conn, "UPDATE docente SET activo = 0 WHERE id_docente = $id");
            mysqli_query($conn, "UPDATE usuario SET activo = 0 WHERE usuario = '$ci_doc' AND id_rol = 4");
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Docente {$doc['nombre']} {$doc['ap_pat']} desactivado."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Docente no encontrado.'];
        }
    }

    header('Location: index.php?action=admin_dashboard&tab=docentes');
    exit;
}

// ============================================
// DOCENTE: REACTIVAR (desde panel admin)
// ============================================
if ($action === 'admin_activar_docente') {
    if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
        header('Location: index.php?action=login');
        exit;
    }

    $id = (int)($_GET['id'] ?? 0);

    if ($id > 0) {
        $doc = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ci, nombre, ap_pat FROM docente WHERE id_docente = $id LIMIT 1"));

        if ($doc) {
            $ci_doc = mysqli_real_escape_string($conn, $doc['ci']);
            mysqli_query($conn, "UPDATE docente SET activo = 1 WHERE id_docente = $id");
            mysqli_query($conn, "UPDATE usuario SET activo = 1 WHERE usuario = '$ci_doc' AND id_rol = 4");
            $_SESSION['alerta'] = ['tipo' => 'success', 'msg' => "Docente {$doc['nombre']} {$doc['ap_pat']} reactivado."];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Docente no encontrado.'];
        }
    }

    header('Location: index.php?action=admin_dashboard&tab=docentes');
    exit;
}


// ============================================
// ENRUTAMIENTO DE VISTAS (SWITCH)
// ============================================
switch ($action) {

    // ============================================
    // PÚBLICAS
    // ============================================
    case 'inicio':
        include 'views/inicio.php';
        break;

    case 'login':
        if (isset($_SESSION['usuario_id'])) {
            $rol = $_SESSION['rol_id'];
            switch ($rol) {
                case 1:
                    $destino = 'admin_dashboard';
                    break;
                case 2:
                    $destino = 'secretaria_dashboard';
                    break;
                case 3:
                    $destino = 'estudiante_dashboard';
                    break;
                case 4:
                    $destino = 'docente_dashboard';
                    break;
                case 5:
                    $destino = 'direccion_acad_dashboard';
                    break;
                case 6:
                    $destino = 'rector_dashboard';
                    break;
                case 7:
                    $destino = 'jefe_carrera_dashboard';
                    break;
                case 8:
                    $destino = 'super_admin_dashboard';
                    break;
                default:
                    $destino = 'login';
                    break;
            }
            header("Location: index.php?action=$destino");
            exit;
        }
        include 'views/login.php';
        break;

    case 'registro':
        include 'views/registro.php';
        break;

    // ============================================
    // ADMIN (rol 1)
    // ============================================
    case 'admin_dashboard':
        include 'views/admin_dashboard.php';
        break;


    // ============================================
    // GESTIÓN DE DOCENTES (compartida)
    // ============================================
    case 'gestion_docentes':
        if (isset($_SESSION['rol_id']) && in_array($_SESSION['rol_id'], [1, 2, 5, 6, 8])) {
            $docentes = obtener_todos_los_docentes($conn);
            include 'views/gestion_docentes.php';
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;

    case 'ver_materias_docente':
        if (isset($_SESSION['rol_id']) && in_array($_SESSION['rol_id'], [1, 2, 5, 6, 8]) && isset($_GET['id_docente'])) {
            $id_docente = (int)$_GET['id_docente'];
            $docente_info = obtener_docente_por_id($conn, $id_docente);
            if ($docente_info) {
                $materias_asignadas   = obtener_materias_asignadas_docente($conn, $id_docente);
                $materias_disponibles = obtener_materias_disponibles_para_docente($conn, $id_docente);
                include 'views/materias_docente.php';
            } else {
                $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Docente no encontrado.'];
                header('Location: index.php?action=gestion_docentes');
                exit;
            }
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;

    // ============================================
    // SECRETARIA (rol 2)
    // ============================================
    case 'secretaria_dashboard':
        include 'views/secretaria_dashboard.php';
        break;

    case 'secretaria_inscripcion':
        include 'views/secretaria_inscripcion.php';
        break;

    // ============================================
    // DOCENTE (rol 4)
    // ============================================
    case 'docente_dashboard':
        if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4) {
            $ci_docente = $_SESSION['usuario_nombre'];
            $docente = obtener_docente_por_ci($conn, $ci_docente);

            $materias_asignadas = [];
            if ($docente) {
                $mat_result = obtener_materias_docente($conn, $docente['id_docente']);
                while ($m = mysqli_fetch_assoc($mat_result)) {
                    $materias_asignadas[] = $m;
                }
            } else {
                $docente = ['nombre' => 'Usuario', 'ap_pat' => ''];
            }
            include 'views/docente_dashboard.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;

    case 'docente_ver_estudiantes':
        if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4 && isset($_GET['cod_asig'])) {
            $docente = obtener_docente_por_ci($conn, $_SESSION['usuario_nombre']);
            $cod_asig = $_GET['cod_asig'];
            $bimestre = isset($_GET['bimestre']) ? (int)$_GET['bimestre'] : 1;
            $vista = $_GET['vista'] ?? 'bimestral';

            $estudiantes = [];
            if ($docente) {
                if ($vista === 'anual') {
                    $est_result = obtener_resumen_anual_materia_docente($conn, $docente['id_docente'], $cod_asig);
                } else {
                    $est_result = obtener_estudiantes_materia_bimestre($conn, $docente['id_docente'], $cod_asig, $bimestre);
                }
                while ($e = mysqli_fetch_assoc($est_result)) {
                    $estudiantes[] = $e;
                }
            } else {
                $docente = ['nombre' => 'Usuario', 'ap_pat' => ''];
            }
            include 'views/docente_dashboard.php';
        } else {
            header('Location: index.php?action=docente_dashboard');
        }
        break;

    // ============================================
    // ESTUDIANTE (rol 3)
    // ============================================
    case 'estudiante_dashboard':
        include 'views/estudiante_dashboard.php';
        break;

    case 'generar_reporte':
        if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 3) {
            include 'reports/reporte.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;

    // ============================================
    // DIRECCIÓN ACADÉMICA (rol 5, 6, 8)
    // ============================================
    case 'direccion_acad_dashboard':
        if (isset($_SESSION['rol_id']) && in_array($_SESSION['rol_id'], [5, 6, 8])) {
            include 'views/direccion_acad_dashboard.php';
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;

    // ============================================
    // RECTOR (rol 6, 8)
    // ============================================
    case 'rector_dashboard':
        if (isset($_SESSION['rol_id']) && in_array($_SESSION['rol_id'], [6, 8])) {
            include 'views/rector_dashboard.php';
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;

    // ============================================
    // JEFE DE CARRERA (rol 7, 8)
    // ============================================
    case 'jefe_carrera_dashboard':
        if (isset($_SESSION['rol_id']) && in_array($_SESSION['rol_id'], [7, 8])) {
            include 'views/jefe_carrera_dashboard.php';
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;

    // ============================================
    // SUPER ADMIN (rol 8)
    // ============================================
    case 'super_admin_dashboard':
        if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 8) {
            include 'views/super_admin_dashboard.php';
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;

    // ============================================
    // REPORTES PDF - DIRECCIÓN ACADÉMICA
    // ============================================
    case 'dir_reporte_estadisticas':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_estadisticas.php';
        exit;

    case 'dir_reporte_excelencia':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_excelencia.php';
        exit;

    case 'dir_reporte_abandonos':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_abandonos.php';
        exit;

    case 'dir_reporte_record':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_record.php';
        exit;

    case 'dir_reporte_desempeno':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_desempeno.php';
        exit;

    case 'dir_reporte_plan':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_plan.php';
        exit;

    case 'dir_reporte_estadisticas_avanz':
        if (ob_get_length()) ob_end_clean();
        include 'reports/dir_reporte_estadisticas_avanz.php';
        exit;

        // ============================================
        // ADMIN: VER MATERIAS DE UN ESTUDIANTE
        // ============================================
    case 'admin_ver_materias':
        if (!in_array($_SESSION['rol_id'] ?? 0, [1, 8])) {
            header('Location: index.php?action=login');
            exit;
        }

        $ci_est = mysqli_real_escape_string($conn, $_GET['ci'] ?? '');

        if (empty($ci_est)) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'CI no proporcionado.'];
            header('Location: index.php?action=admin_dashboard&tab=estudiantes');
            exit;
        }

        // Datos del estudiante
        $q_est = "SELECT e.*, c.nombre AS carrera, c.resolucion 
                  FROM estudiante e 
                  LEFT JOIN carrera c ON c.id = e.id_carrera 
                  WHERE e.ci = '$ci_est' LIMIT 1";
        $r_est = mysqli_query($conn, $q_est);
        $estudiante_info = $r_est ? mysqli_fetch_assoc($r_est) : null;

        if (!$estudiante_info) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Estudiante no encontrado.'];
            header('Location: index.php?action=admin_dashboard&tab=estudiantes');
            exit;
        }

        // Historial académico (materias del estudiante)
        $q_hist = "SELECT 
                    h.*, 
                    a.nombre AS materia_nombre, 
                    a.nivel,
                    a.id_carrera,
                    CONCAT(d.nombre, ' ', d.ap_pat) AS docente
                   FROM historial h
                   INNER JOIN asignatura a ON a.codigo = h.cod_asig
                   LEFT JOIN docente d ON d.id_docente = h.id_docente
                   WHERE h.ci_est = '$ci_est'
                   ORDER BY h.gestion DESC, a.nivel, h.cod_asig";
        $r_hist = mysqli_query($conn, $q_hist);
        $materias = [];
        while ($m = mysqli_fetch_assoc($r_hist)) {
            $materias[] = $m;
        }

        // Inscripciones activas
        $q_insc = "SELECT i.*, a.nombre AS materia_nombre, a.nivel
                   FROM inscripcion i
                   INNER JOIN asignatura a ON a.codigo = i.cod_asig
                   WHERE i.ci_est = '$ci_est' AND i.activo = 1
                   ORDER BY i.gestion DESC, a.nivel";
        $r_insc = mysqli_query($conn, $q_insc);
        $inscripciones = [];
        while ($i = mysqli_fetch_assoc($r_insc)) {
            $inscripciones[] = $i;
        }

        include 'views/admin_ver_materias.php';
        break;
    // ============================================
    // REPORTES PDF - admin
    // ============================================
    case 'admin_reporte_general':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_general.php';
        exit;

    case 'admin_reporte_carrera':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_carrera.php';
        exit;

    case 'admin_reporte_inscripciones':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_inscripciones.php';
        exit;

    case 'admin_reporte_usuarios':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_usuarios.php';
        exit;

    case 'admin_reporte_permisos':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_permisos.php';
        exit;

    case 'admin_reporte_auditoria':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_auditoria.php';
        exit;

    case 'admin_reporte_estudiantes':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_estudiantes.php';
        exit;

    case 'admin_reporte_docentes':
        if (ob_get_length()) ob_end_clean();
        include 'reports/admin_reporte_docentes.php';
        exit;
        // ============================================
        // REPORTES PDF - RECTOR
        // ============================================
    case 'rector_reporte_general':
        if (ob_get_length()) ob_end_clean();
        include 'reports/rector_reporte_general.php';
        exit;

    case 'rector_reporte_rendimiento':
        if (ob_get_length()) ob_end_clean();
        include 'reports/rector_reporte_rendimiento.php';
        exit;

    case 'rector_reporte_docentes':
        if (ob_get_length()) ob_end_clean();
        include 'reports/rector_reporte_docentes.php';
        exit;

    case 'rector_reporte_carreras':
        if (ob_get_length()) ob_end_clean();
        include 'reports/rector_reporte_carreras.php';
        exit;

    case 'rector_reporte_estadisticas':
        if (ob_get_length()) ob_end_clean();
        include 'reports/rector_reporte_estadisticas.php';
        exit;

    case 'rector_reporte_record':
        if (ob_get_length()) ob_end_clean();
        include 'reports/rector_reporte_record.php';
        exit;

        // ============================================
        // REPORTES PDF - JEFE DE CARRERA
        // ============================================
    case 'jefe_reporte_materias':
        if (ob_get_length()) ob_end_clean();
        include 'reports/jefe_reporte_materias.php';
        exit;

    case 'jefe_reporte_paralelos':
        if (ob_get_length()) ob_end_clean();
        include 'reports/jefe_reporte_paralelos.php';
        exit;

    case 'jefe_reporte_record':
        if (ob_get_length()) ob_end_clean();
        include 'reports/jefe_reporte_record.php';
        exit;

    case 'jefe_reporte_estadisticas':
        if (ob_get_length()) ob_end_clean();
        include 'reports/jefe_reporte_estadisticas.php';
        exit;

        // ============================================
        // REPORTES PDF - COMPARTIDOS
        // ============================================
    case 'reporte_estudiantes':
        if (ob_get_length()) ob_end_clean();
        include 'reports/reporte_estudiantes.php';
        exit;

    case 'reporte_estudiante_gestion':
        if (ob_get_length()) ob_end_clean();
        include 'reports/reporte_estudiante_gestion.php';
        exit;

        // ============================================
        // DEFAULT
        // ============================================
    default:
        include 'views/inicio.php';
        break;
}
