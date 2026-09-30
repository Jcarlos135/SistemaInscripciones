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

// Reportes de Dirección Académica: DIRECCION (5), RECTOR (6), SUPER_ADMIN (8)
if (strpos($action, 'dir_reporte_') === 0) {
    if (!in_array($rol ?? 0, [5, 6, 8])) {
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

        // VALIDAR SI HAY ERROR
        if (isset($datos['error'])) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => $datos['msg']];
            header('Location: index.php?action=inicio');
            exit;
        }

        // LOGIN EXITOSO
        if ($datos) {
            $_SESSION['usuario_id'] = $datos['id'];
            $_SESSION['usuario_nombre'] = $datos['usuario'];
            $_SESSION['rol_id'] = $datos['id_rol'];
            $_SESSION['rol_nombre'] = $datos['rol_nombre'];

            if ($datos['id_rol'] == 3) {
                $_SESSION['estudiante_ci'] = $datos['usuario'];
            }

            // ============================================
            // REDIRECCIÓN SEGÚN ROL
            // ============================================
            switch ($datos['id_rol']) {
                case 1: $redirect = 'admin_dashboard';          break; // ADMIN
                case 2: $redirect = 'secretaria_dashboard';     break; // SECRETARIA
                case 3: $redirect = 'estudiante_dashboard';     break; // ESTUDIANTE
                case 4: $redirect = 'docente_dashboard';        break; // DOCENTE
                case 5: $redirect = 'direccion_acad_dashboard'; break; // DIRECCION ACADEMICA
                case 6: $redirect = 'rector_dashboard';         break; // RECTOR
                case 7: $redirect = 'jefe_carrera_dashboard';   break; // JEFE DE CARRERA
                case 8: $redirect = 'super_admin_dashboard';    break; // SUPER ADMIN
                default: $redirect = 'login';                   break;
            }

            header("Location: index.php?action=$redirect");
            exit;
        }
    }

    // GUARDAR DOCENTE
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
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Docente registrado. Usuario: ' . trim($_POST['ci']) . ' / Clave: 123456'];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error: el CI ya está registrado o faltan datos obligatorios.'];
        }
        header('Location: index.php?action=gestion_docentes');
        exit;
    }

    // ASIGNAR MATERIA A DOCENTE
    if ($action === 'asignar_materia_docente' && in_array($_SESSION['rol_id'] ?? 0, [1, 2, 5, 6, 8])) {
        $id_docente = (int)($_POST['id_docente'] ?? 0);
        $cod_asig   = trim($_POST['cod_asig'] ?? '');

        $r = asignar_materia_docente($conn, $id_docente, $cod_asig);
        $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => $r['msg']];
        header("Location: index.php?action=ver_materias_docente&id_docente=$id_docente");
        exit;
    }

    // QUITAR MATERIA A DOCENTE
    if ($action === 'quitar_materia_docente' && in_array($_SESSION['rol_id'] ?? 0, [1, 2, 5, 6, 8])) {
        $id_docente = (int)($_POST['id_docente'] ?? 0);
        $cod_asig   = trim($_POST['cod_asig'] ?? '');

        $r = quitar_materia_docente($conn, $id_docente, $cod_asig);
        $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => $r['msg']];
        header("Location: index.php?action=ver_materias_docente&id_docente=$id_docente");
        exit;
    }

    // DOCENTE: GUARDAR NOTAS POR BIMESTRE
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
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => "Notas del $bimestre Bimestre guardadas correctamente."];
        } else {
            mysqli_rollback($conn);
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error al guardar algunas notas.'];
        }

        header("Location: index.php?action=docente_ver_estudiantes&cod_asig=$cod_asig&bimestre=$bimestre");
        exit;
    }

    // DOCENTE: GUARDAR NOTAS VISTA ANUAL
    if ($action === 'docente_guardar_notas_anual' && isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4) {
        $docente = obtener_docente_por_ci($conn, $_SESSION['usuario_nombre']);
        if (!$docente) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'No se encontró el registro del docente'];
            header('Location: index.php?action=docente_dashboard');
            exit;
        }

        $cod_asig       = $_POST['cod_asig'];
        $ci_est_array   = $_POST['ci_est'] ?? [];
        $segundo_array  = $_POST['segundo_turno'] ?? [];
        $exito_total    = true;

        foreach ($ci_est_array as $index => $ci) {
            $es_segundo = in_array($ci, $segundo_array) ? 1 : 0;
            $obs = $_POST['observaciones'][$index] ?? '';

            for ($bim = 1; $bim <= 4; $bim++) {
                $teorico  = $_POST["nota_teorico$bim"][$index] ?? '';
                $practico = $_POST["nota_practico$bim"][$index] ?? '';

                $ok = guardar_notas_bimestre_docente($conn, $ci, $cod_asig, $docente['id_docente'], $bim, $teorico, $practico, $obs, $es_segundo);
                if (!$ok) $exito_total = false;
            }
        }

        if ($exito_total) {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Notas anuales guardadas correctamente.'];
        } else {
            $_SESSION['alerta'] = ['tipo' => 'danger', 'msg' => 'Error al guardar algunas notas.'];
        }
        header("Location: index.php?action=docente_ver_estudiantes&cod_asig=" . urlencode($cod_asig) . "&vista=anual");
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

    // Buscar en usuario con su rol
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

    // Si el usuario está inactivo
    if ($user['usuario_activo'] == 0) {
        echo json_encode(['tipo' => 'desactivado', 'registrado' => true]);
        exit;
    }

    $id_rol = (int)$user['id_rol'];
    $rol_nombre = strtoupper($user['rol_nombre']);

    // ============================================
    // ESTUDIANTE (rol 3) — lógica especial
    // ============================================
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

    // ============================================
    // OTROS ROLES
    // ============================================
    $nombre_completo = '';
    $q_doc = "SELECT nombre, ap_pat, ap_mat FROM docente WHERE ci = '$ci_esc' LIMIT 1";
    $r_doc = mysqli_query($conn, $q_doc);
    if ($r_doc && $row_doc = mysqli_fetch_assoc($r_doc)) {
        $nombre_completo = trim($row_doc['nombre'] . ' ' . $row_doc['ap_pat'] . ' ' . ($row_doc['ap_mat'] ?? ''));
    }

    // Mapeo rol → tipo de respuesta
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
                case 1: $destino = 'admin_dashboard';          break;
                case 2: $destino = 'secretaria_dashboard';     break;
                case 3: $destino = 'estudiante_dashboard';     break;
                case 4: $destino = 'docente_dashboard';        break;
                case 5: $destino = 'direccion_acad_dashboard'; break;
                case 6: $destino = 'rector_dashboard';         break;
                case 7: $destino = 'jefe_carrera_dashboard';   break;
                case 8: $destino = 'super_admin_dashboard';    break;
                default: $destino = 'login';                   break;
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
    // REPORTES PDF - DIRECCIÓN ACADÉMICA (rol 5, 6, 8)
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

    // ============================================
    // REPORTES PDF - RECTOR (rol 6, 8)
    // ============================================
    case 'rector_reporte_general':
    if (ob_get_length()) ob_end_clean();
    include 'views/rector_reporte_general.php';  // ← CAMBIA reports/ por views/
    exit;

case 'rector_reporte_rendimiento':
    if (ob_get_length()) ob_end_clean();
    include 'views/rector_reporte_rendimiento.php';  // ← CAMBIA
    exit;

case 'rector_reporte_docentes':
    if (ob_get_length()) ob_end_clean();
    include 'views/rector_reporte_docentes.php';  // ← CAMBIA
    exit;

case 'rector_reporte_carreras':
    if (ob_get_length()) ob_end_clean();
    include 'views/rector_reporte_carreras.php';  // ← CAMBIA
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