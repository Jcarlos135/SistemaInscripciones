
<?php

//die('ARCHIVO ACTUALIZADO: ' . __FILE__);
// Función auxiliar para limpiar datos
function limpiar($conn, $valor) {
    return mysqli_real_escape_string($conn, trim($valor));
}

// ==========================================
// FUNCIONES AUXILIARES PARA REPORTES Y NOTAS (ENTEROS)
// ==========================================

// 1. Convierte texto UTF-8 a formato compatible con FPDF (windows-1252)
function textoPDF($t) {
    $t = (string)($t ?? '');
    $t = html_entity_decode($t, ENT_QUOTES, 'UTF-8');
    if (preg_match('//u', $t) === 1) {
        $t = str_replace(
            ["\xE2\x80\x9C","\xE2\x80\x9D","\xE2\x80\x98","\xE2\x80\x99","\xE2\x80\x94","\xE2\x80\x93","\xE2\x80\xA6"],
            ['"','"',"'","'",'-','-','...'],
            $t
        );
        $c = @iconv('UTF-8', 'windows-1252//TRANSLIT', $t);
        return ($c === false) ? utf8_decode($t) : $c;
    }
    return $t;
}

function obtener_todos_los_docentes($conn) {
    $sql = "SELECT d.*, u.usuario, u.activo AS usuario_activo, u.id AS id_usuario
            FROM docente d 
            LEFT JOIN usuario u ON u.usuario = d.ci 
            ORDER BY d.ap_pat, d.ap_mat, d.nombre";
    $result = mysqli_query($conn, $sql);
    $docentes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $docentes[] = $row;
    }
    return $docentes;
}

// BUSCAR DOCENTE POR CI
function obtener_docente_por_ci($conn, $ci, $solo_activos = false) {
    $ci = limpiar($conn, $ci);
    $filtro = $solo_activos ? " AND d.activo = 1" : "";
    $query = "SELECT d.*, u.id AS usuario_id, u.activo AS usuario_activo
              FROM docente d
              LEFT JOIN usuario u ON d.ci = u.usuario
              WHERE d.ci = '$ci'" . $filtro;
    $result = mysqli_query($conn, $query);
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}

function guardar_docente($conn, $ci, $nombre, $ap_pat, $ap_mat, $genero, $cel, $email) {
    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, 
            "INSERT INTO docente (ci, nombre, ap_pat, ap_mat, genero, cel, email, id_rol, activo) 
             VALUES (?, ?, ?, ?, ?, ?, ?, 4, 1)");
        mysqli_stmt_bind_param($stmt, 'sssssss', $ci, $nombre, $ap_pat, $ap_mat, $genero, $cel, $email);
        mysqli_stmt_execute($stmt);

        $clave = '123456';
        $id_rol = 4;
        $stmt2 = mysqli_prepare($conn, 
            "INSERT INTO usuario (usuario, clave, id_rol, activo) VALUES (?, ?, ?, 1)");
        mysqli_stmt_bind_param($stmt2, 'ssi', $ci, $clave, $id_rol);
        mysqli_stmt_execute($stmt2);

        mysqli_commit($conn);
        return true;
    } catch (mysqli_sql_exception $e) {
        mysqli_rollback($conn);
        return false;
    }
}

// 2. Formatea las notas para el PDF (SIEMPRE ENTEROS, sin decimales)
function nota($v) {
    if ($v === null || $v === '') return '-';
    return is_numeric($v) ? (string)(int)round((float)$v) : textoPDF($v);
}

// 3. Convierte un número a su equivalente en texto (ej: 61 -> SESENTA Y UNO)
function numero_a_literal($numero) {
    if ($numero === null || $numero === '') return 'SIN NOTA';
    $num = (int)round((float)$numero); // Redondeamos a entero para el texto
    
    if ($num == 0) return 'CERO';
    if ($num == 100) return 'CIEN';
    
    $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    $decenas = ['', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    $especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTE', 'VEINTIUNO', 'VEINTIDOS', 'VEINTITRES', 'VEINTICUATRO', 'VEINTICINCO', 'VEINTISEIS', 'VEINTISIETE', 'VEINTIOCHO', 'VEINTINUEVE'];
    
    if ($num < 30) {
        return $especiales[$num];
    }
    
    $dec = (int)($num / 10);
    $uni = $num % 10;
    
    if ($uni == 0) {
        return $decenas[$dec];
    } else {
        return $decenas[$dec] . ' Y ' . $unidades[$uni];
    }
}

// ==========================================
// FUNCIONES PRINCIPALES DEL SISTEMA
// ==========================================

function obtener_documentos_estudiante($conn, $ci) {
    $ci_esc = limpiar($conn, $ci);
    $query = "SELECT * FROM documentos_est WHERE ci_est = '$ci_esc'";
    return mysqli_query($conn, $query);
}

function login($conn, $usuario, $clave) {
    $usuario = limpiar($conn, $usuario);
    
    // Primero buscar el usuario sin importar si está activo o no
    $query = "SELECT u.id, u.usuario, u.clave, u.id_rol, u.activo, r.nombre as rol_nombre 
              FROM usuario u 
              INNER JOIN rol r ON u.id_rol = r.id 
              WHERE u.usuario = '$usuario'";
              
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verificar si está activo
        if ($row['activo'] == 0) {
            return ['error' => 'inactivo', 'msg' => 'Usuario inactivo. Comuníquese con Dirección Académica.'];
        }
        
        // Verificar contraseña
        if ($row['clave'] === $clave || $row['clave'] === md5($clave)) {
            return $row; // Login exitoso
        } else {
            return ['error' => 'clave', 'msg' => 'Contraseña incorrecta. Verifique e intente nuevamente.'];
        }
    }
    
    // Usuario no existe
    return ['error' => 'no_existe', 'msg' => 'Usuario no encontrado en el sistema.'];
}
function verificar_estudiante_registrado($conn, $ci) {
    $ci = limpiar($conn, $ci);
    $query = "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.activo, e.id_carrera,
                     u.usuario, u.activo as usuario_activo, u.id as usuario_id
              FROM estudiante e 
              LEFT JOIN usuario u ON e.id_usuario = u.id
              WHERE e.ci = '$ci'";
    
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        return ['registrado' => true, 'datos' => mysqli_fetch_assoc($result)];
    }
    return ['registrado' => false, 'datos' => null];
}

function registrar_estudiante($conn, $ci, $nombre, $ap_pat, $ap_mat, $genero, $edad, $cel, $id_carrera, $tipo_inscripcion = 'Regular', $clave_custom = null) {
    if (empty(trim($ap_pat)) && empty(trim($ap_mat))) {
        return ['exito' => false, 'msg' => 'El estudiante debe tener al menos un apellido.'];
    }

    $tipos_validos = ['Regular', 'BTH', 'Beca'];
    if (!in_array($tipo_inscripcion, $tipos_validos)) {
        return ['exito' => false, 'msg' => 'Tipo de inscripción inválido.'];
    }

    $ci_esc = limpiar($conn, $ci);
    $check = mysqli_query($conn, "SELECT ci FROM estudiante WHERE ci = '$ci_esc'");
    if (mysqli_num_rows($check) > 0) {
        return ['exito' => false, 'msg' => ' Este CI ya está registrado en el sistema.'];
    }

    mysqli_begin_transaction($conn);
    try {
        $clave = !empty($clave_custom) ? $clave_custom : $ci;
        $clave_esc = limpiar($conn, $clave);
        
        mysqli_query($conn, "INSERT INTO usuario (usuario, clave, id_rol, activo) VALUES ('$ci_esc', '$clave_esc', 3, 1)");
        $id_usuario = mysqli_insert_id($conn);

        $nombre = strtoupper(trim($nombre));
        $ap_pat = strtoupper(trim($ap_pat));
        $ap_mat = strtoupper(trim($ap_mat));

        $ruta_img = '';
        $carpeta_img = __DIR__ . '/../img';
        if (!file_exists($carpeta_img)) mkdir($carpeta_img, 0777, true);
        
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $nombre_archivo = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $_FILES['img']['name']);
            $ruta_destino = $carpeta_img . '/' . $nombre_archivo; 
            if (move_uploaded_file($_FILES['img']['tmp_name'], $ruta_destino)) {
                $ruta_img = 'img/' . $nombre_archivo;
            }
        }

        mysqli_query($conn, "INSERT INTO estudiante (ci, nombre, ap_pat, ap_mat, genero, edad, cel, id_carrera, id_usuario, img, activo) 
                              VALUES ('$ci_esc', '$nombre', '$ap_pat', '$ap_mat', '$genero', $edad, '$cel', '$id_carrera', $id_usuario, '$ruta_img', 1)");

        $msg_niveles = "";
        if ($tipo_inscripcion == 'Regular' || $tipo_inscripcion == 'Beca') {
            mysqli_query($conn, "INSERT INTO inscripcion (ci_est, cod_asig, id_sec, fecha, turno, grupo, tipo, activo)
                                  SELECT '$ci_esc', a.codigo, 1, CURDATE(), 'MAÑANA', 'A', '$tipo_inscripcion', 1
                                  FROM asignatura a WHERE a.id_carrera = '$id_carrera' AND a.nivel = 100 AND a.activo = 1");
            $msg_niveles = "1er año (Nivel 100)";
        } else if ($tipo_inscripcion == 'BTH') {
            mysqli_query($conn, "INSERT INTO inscripcion (ci_est, cod_asig, id_sec, fecha, turno, grupo, tipo, activo)
                                  SELECT '$ci_esc', a.codigo, 1, CURDATE(), 'MAÑANA', 'A', 'BTH', 1
                                  FROM asignatura a WHERE a.id_carrera = '$id_carrera' AND a.nivel IN (100, 200) AND a.activo = 1");
            $msg_niveles = "1er y 2do año (Nivel 100 + 200)";
        }

        mysqli_commit($conn);
        return ['exito' => true, 'msg' => " Estudiante registrado e inscrito en $msg_niveles. Usuario: $ci, Contraseña: $clave"];
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['exito' => false, 'msg' => ' Error al registrar: ' . $e->getMessage()];
    }
}

function registrar_estudiante_publico($conn, $datos, $archivos, $clave_custom = null) {
    $ci = limpiar($conn, $datos['ci']);
    $nombre = strtoupper(limpiar($conn, $datos['nombre']));
    $ap_pat = strtoupper(limpiar($conn, $datos['ap_pat']));
    $ap_mat = strtoupper(limpiar($conn, $datos['ap_mat'] ?? ''));
    $genero = limpiar($conn, $datos['genero']);
    $edad = (int)$datos['edad'];
    $cel = limpiar($conn, $datos['cel']);
    $id_carrera = 'SIS-INF';
    $tipo_inscripcion = limpiar($conn, $datos['tipo_inscripcion']);
    $turno = limpiar($conn, $datos['turno']);
    
    $clave = !empty($clave_custom) ? limpiar($conn, $clave_custom) : $ci;
    
    $check = mysqli_query($conn, "SELECT ci FROM estudiante WHERE ci = '$ci'");
    if (mysqli_num_rows($check) > 0) {
        return ['exito' => false, 'msg' => ' Este CI ya está registrado.'];
    }
    
    if (empty($ap_pat) && empty($ap_mat)) {
        return ['exito' => false, 'msg' => ' Debe ingresar al menos un apellido.'];
    }
    
    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, "INSERT INTO usuario (usuario, clave, id_rol, activo) VALUES ('$ci', '$clave', 3, 1)");
        $id_usuario = mysqli_insert_id($conn);
        
        mysqli_query($conn, "INSERT INTO estudiante (ci, nombre, ap_pat, ap_mat, genero, edad, cel, id_carrera, id_usuario, activo) 
                              VALUES ('$ci', '$nombre', '$ap_pat', '$ap_mat', '$genero', $edad, '$cel', '$id_carrera', $id_usuario, 1)");
        
        if ($tipo_inscripcion == 'Regular' || $tipo_inscripcion == 'Beca') {
            mysqli_query($conn, "INSERT INTO inscripcion (ci_est, cod_asig, id_sec, fecha, turno, grupo, tipo, activo)
                                SELECT '$ci', a.codigo, 1, CURDATE(), '$turno', 'A', '$tipo_inscripcion', 1
                                FROM asignatura a WHERE a.id_carrera = '$id_carrera' AND a.nivel = 100 AND a.activo = 1");
        } else if ($tipo_inscripcion == 'BTH') {
            mysqli_query($conn, "INSERT INTO inscripcion (ci_est, cod_asig, id_sec, fecha, turno, grupo, tipo, activo)
                                SELECT '$ci', a.codigo, 1, CURDATE(), '$turno', 'A', 'BTH', 1
                                FROM asignatura a WHERE a.id_carrera = '$id_carrera' AND a.nivel IN (100, 200) AND a.activo = 1");
        }
        
        subir_documentos_estudiante($conn, $ci, $archivos);
        mysqli_commit($conn);
        
        $clave_msg = !empty($clave_custom) ? '(personalizada)' : $ci;
        return ['exito' => true, 'msg' => " Registro exitoso. Usuario: $ci, Contraseña: $clave_msg", 'ci' => $ci];
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['exito' => false, 'msg' => ' Error al registrar: ' . $e->getMessage()];
    }
}

function subir_documentos_estudiante($conn, $ci, $archivos) {
    $documentos = ['doc_ci' => 'CI', 'doc_titulo' => 'TITULO_BACHILLER', 'doc_deposito' => 'DEPOSITO_BANCARIO'];
    $directorio = __DIR__ . '/../documentos/';
    if (!is_dir($directorio)) mkdir($directorio, 0777, true);
    
    foreach ($documentos as $campo => $tipo_doc) {
        if (isset($archivos[$campo]) && $archivos[$campo]['error'] == 0) {
            $ext = pathinfo($archivos[$campo]['name'], PATHINFO_EXTENSION);
            $nombre_archivo = $ci . '_' . $tipo_doc . '_' . time() . '.' . $ext;
            $ruta_destino = $directorio . $nombre_archivo;
            
            if (move_uploaded_file($archivos[$campo]['tmp_name'], $ruta_destino)) {
                $ruta_archivo = 'documentos/' . $nombre_archivo;
                mysqli_query($conn, "INSERT INTO documentos_est (ci_est, tipo_documento, nombre_archivo, ruta_archivo) 
                                     VALUES ('$ci', '$tipo_doc', '$nombre_archivo', '$ruta_archivo')");
            }
        }
    }
}

function cambiar_contrasena($conn, $id_usuario, $nueva_clave) {
    $id = (int)$id_usuario;
    $clave = limpiar($conn, $nueva_clave);
    return mysqli_query($conn, "UPDATE usuario SET clave = '$clave' WHERE id = $id");
}

function obtener_datos_completos_registro($conn, $ci) {
    $ci_esc = limpiar($conn, $ci);
    $estudiante = mysqli_fetch_assoc(mysqli_query($conn, "SELECT e.*, c.nombre as carrera_nombre, u.usuario, u.clave 
                                                          FROM estudiante e 
                                                          JOIN carrera c ON e.id_carrera = c.id
                                                          JOIN usuario u ON e.id_usuario = u.id
                                                          WHERE e.ci = '$ci_esc'"));
    if (!$estudiante) return null;
    
    $materias = mysqli_query($conn, "SELECT i.tipo, i.turno, i.grupo, a.nombre as asig_nombre, a.nivel as asig_nivel
                                      FROM inscripcion i JOIN asignatura a ON i.cod_asig = a.codigo
                                      WHERE i.ci_est = '$ci_esc' AND i.activo = 1 ORDER BY a.nivel, a.codigo");
    
    return ['estudiante' => $estudiante, 'materias' => $materias, 'documentos' => obtener_documentos_estudiante($conn, $ci)];
}

function actualizar_estudiante($conn, $ci, $nombre, $ap_pat, $ap_mat, $genero, $edad, $cel, $id_carrera, $imagen_actual) {
    if (empty(trim($ap_pat)) && empty(trim($ap_mat))) {
        return ['exito' => false, 'msg' => 'El estudiante debe tener al menos un apellido.'];
    }

    $ci = limpiar($conn, $ci);
    $nombre = strtoupper(limpiar($conn, $nombre));
    $ap_pat = strtoupper(limpiar($conn, $ap_pat));
    $ap_mat = strtoupper(limpiar($conn, $ap_mat));
    $genero = limpiar($conn, $genero);
    $edad = (int)$edad;
    $cel = limpiar($conn, $cel);
    $id_carrera = limpiar($conn, $id_carrera);
    $nueva_ruta_img = $imagen_actual;

    $carpeta_img = __DIR__ . '/../img';
    if (!file_exists($carpeta_img)) mkdir($carpeta_img, 0777, true);

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $_FILES['img']['name']);
        $ruta_destino = $carpeta_img . '/' . $nombre_archivo; 
        if (move_uploaded_file($_FILES['img']['tmp_name'], $ruta_destino)) {
            $nueva_ruta_img = 'img/' . $nombre_archivo;
        }
    }

    $query = "UPDATE estudiante SET nombre='$nombre', ap_pat='$ap_pat', ap_mat='$ap_mat', genero='$genero', edad='$edad', cel='$cel', id_carrera='$id_carrera', img='$nueva_ruta_img' WHERE ci='$ci'";
    $resultado = mysqli_query($conn, $query);
    return ['exito' => $resultado, 'msg' => $resultado ? 'Actualizado correctamente.' : 'Error al actualizar.'];
}

function actualizar_inscripcion_estudiante($conn, $ci, $tipo, $turno, $grupo, $id_carrera) {
    $ci = limpiar($conn, $ci);
    $tipo = limpiar($conn, $tipo);
    $turno = limpiar($conn, $turno);
    $grupo = limpiar($conn, $grupo);
    $id_carrera = limpiar($conn, $id_carrera);
    
    mysqli_query($conn, "UPDATE inscripcion SET tipo = '$tipo', turno = '$turno', grupo = '$grupo' WHERE ci_est = '$ci' AND activo = 1");
    
    if ($tipo == 'BTH') {
        mysqli_query($conn, "INSERT INTO inscripcion (ci_est, cod_asig, id_sec, fecha, turno, grupo, tipo, activo)
                             SELECT '$ci', a.codigo, 1, CURDATE(), '$turno', '$grupo', '$tipo', 1
                             FROM asignatura a WHERE a.id_carrera = '$id_carrera' AND a.nivel = 200 AND a.activo = 1
                             AND NOT EXISTS (SELECT 1 FROM inscripcion i WHERE i.ci_est = '$ci' AND i.cod_asig = a.codigo AND i.activo = 1)");
    } else if ($tipo == 'Regular' || $tipo == 'Beca') {
        mysqli_query($conn, "DELETE FROM inscripcion WHERE ci_est = '$ci' AND activo = 1 AND cod_asig IN (SELECT codigo FROM asignatura WHERE id_carrera = '$id_carrera' AND nivel = 200)");
    }
    return true;
}

function listar_estudiantes($conn) {
    return mysqli_query($conn, "SELECT e.*, c.nombre AS carrera_nombre, (SELECT i.tipo FROM inscripcion i WHERE i.ci_est = e.ci AND i.activo = 1 LIMIT 1) AS tipo
                                FROM estudiante e LEFT JOIN carrera c ON e.id_carrera = c.id WHERE e.activo = 1 ORDER BY e.ap_pat, e.nombre");
}

function listar_carreras($conn) {
    return mysqli_query($conn, "SELECT * FROM carrera WHERE activo = 1");
}

function listar_asignaturas($conn, $id_carrera) {
    return mysqli_query($conn, "SELECT * FROM asignatura WHERE id_carrera = '$id_carrera' AND activo = 1 ORDER BY codigo");
}

function registrar_inscripcion($conn, $ci_est, $cod_asig, $id_sec, $turno, $grupo, $tipo = 'Regular') {
    return mysqli_query($conn, "INSERT INTO inscripcion (ci_est, cod_asig, id_sec, fecha, turno, grupo, tipo, activo) 
                                VALUES ('$ci_est', '$cod_asig', $id_sec, CURDATE(), '$turno', '$grupo', '$tipo', 1)");
}

function listar_inscripciones_estudiante($conn, $ci_est, $gestion_filtro = null) {
    $ci = limpiar($conn, $ci_est);
    $gestion_cond = $gestion_filtro ? " AND COALESCE(h.gestion, a.gestion) = '" . limpiar($conn, $gestion_filtro) . "'" : "";
    
    $sql = "SELECT a.codigo AS asig_codigo, a.nombre AS asig_nombre,
                   h.nota_teorico1, h.nota_pract1, h.nota_primerbim,
                   h.nota_teorico2, h.nota_pract2, h.nota_segundobim,
                   h.nota_teorico3, h.nota_pract3, h.nota_tercerbim,
                   h.nota_teorico4, h.nota_pract4, h.nota_cuartobim,
                   h.nota_parcial, h.TotalAnual AS nota_final, h.segundo_turno, h.estado, h.literal,
                   COALESCE(h.gestion, a.gestion) AS gestion,
                   i.estado_final AS condicion_global
            FROM inscripcion i
            INNER JOIN asignatura a ON a.codigo = i.cod_asig
            LEFT JOIN historial h ON h.id = (SELECT MAX(h2.id) FROM historial h2
                                            WHERE h2.ci_est = i.ci_est AND h2.cod_asig = i.cod_asig)
            WHERE i.ci_est = '$ci' AND i.activo = 1 $gestion_cond
            ORDER BY a.codigo";
    return mysqli_query($conn, $sql);
}

function obtener_datos_estudiante($conn, $ci) {
    $ci = limpiar($conn, $ci);
    $result = mysqli_query($conn, "SELECT e.*, c.nombre as carrera_nombre FROM estudiante e INNER JOIN carrera c ON e.id_carrera = c.id WHERE e.ci = '$ci'");
    return mysqli_fetch_assoc($result);
}

function obtener_estudiante_por_ci($conn, $ci) {
    $ci = limpiar($conn, $ci);
    $result = mysqli_query($conn, "SELECT e.*, c.nombre AS carrera_nombre, i.tipo, i.turno, i.grupo
                                   FROM estudiante e LEFT JOIN carrera c ON e.id_carrera = c.id
                                   LEFT JOIN inscripcion i ON e.ci = i.ci_est AND i.activo = 1
                                   WHERE e.ci = '$ci' AND e.activo = 1 ORDER BY i.fecha DESC LIMIT 1");
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}

function borrar_estudiante_logico($conn, $ci) {
    $ci = limpiar($conn, $ci);
    mysqli_begin_transaction($conn);
    $ok1 = mysqli_query($conn, "UPDATE estudiante SET activo = 0 WHERE ci = '$ci'");
    $ok2 = mysqli_query($conn, "UPDATE usuario u INNER JOIN estudiante e ON u.id = e.id_usuario SET u.activo = 0 WHERE e.ci = '$ci'");
    if ($ok1 && $ok2) { mysqli_commit($conn); return true; }
    mysqli_rollback($conn);
    return false;
}

function activar_estudiante($conn, $ci) {
    $ci = limpiar($conn, $ci);
    mysqli_begin_transaction($conn);
    $q1 = mysqli_query($conn, "UPDATE estudiante SET activo = 1 WHERE ci = '$ci'");
    $q2 = mysqli_query($conn, "UPDATE usuario u INNER JOIN estudiante e ON u.id = e.id_usuario SET u.activo = 1 WHERE e.ci = '$ci'");
    if ($q1 && $q2) { mysqli_commit($conn); return true; }
    mysqli_rollback($conn);
    return false;
}

function desactivar_estudiante($conn, $ci) {
    $ci = limpiar($conn, $ci);
    mysqli_begin_transaction($conn);
    $q1 = mysqli_query($conn, "UPDATE estudiante SET activo = 0 WHERE ci = '$ci'");
    $q2 = mysqli_query($conn, "UPDATE usuario u INNER JOIN estudiante e ON u.id = e.id_usuario SET u.activo = 0 WHERE e.ci = '$ci'");
    if ($q1 && $q2) { mysqli_commit($conn); return true; }
    mysqli_rollback($conn);
    return false;
}

function obtener_estadisticas($conn) {
    $stats = [];
    $stats['estudiantes_activos'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM estudiante WHERE activo = 1"))['total'];
    $stats['estudiantes_inactivos'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM estudiante WHERE activo = 0"))['total'];
    $stats['carreras_activas'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM carrera WHERE activo = 1"))['total'];
    $stats['materias_activas'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM asignatura WHERE activo = 1"))['total'];
    $stats['estudiantes_inscritos'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT ci_est) as total FROM inscripcion WHERE activo = 1"))['total'];
    $stats['total_inscripciones'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM inscripcion WHERE activo = 1"))['total'];
    $stats['usuarios_activos'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM usuario WHERE activo = 1"))['total'];
    return $stats;
}

function listar_usuarios($conn) {
    return mysqli_query($conn, "SELECT u.*, r.nombre as rol_nombre FROM usuario u INNER JOIN rol r ON u.id_rol = r.id ORDER BY u.activo DESC, r.nombre");
}

function cambiar_rol_usuario($conn, $id_usuario, $nuevo_rol) {
    return mysqli_query($conn, "UPDATE usuario SET id_rol = " . (int)$nuevo_rol . " WHERE id = " . (int)$id_usuario);
}

function cambiar_estado_usuario($conn, $id_usuario, $estado) {
    return mysqli_query($conn, "UPDATE usuario SET activo = " . (int)$estado . " WHERE id = " . (int)$id_usuario);
}

function listar_todas_inscripciones($conn) {
    return mysqli_query($conn, "SELECT i.id, i.ci_est, i.cod_asig, i.fecha, i.turno, i.tipo, e.nombre AS est_nombre, e.ap_pat, a.nombre AS asig_nombre
                                FROM inscripcion i INNER JOIN estudiante e ON i.ci_est = e.ci INNER JOIN asignatura a ON i.cod_asig = a.codigo
                                ORDER BY i.fecha DESC, i.id DESC");
}

function listar_todas_carreras($conn) {
    return mysqli_query($conn, "SELECT * FROM carrera ORDER BY activo DESC, nombre");
}

function cambiar_estado_carrera($conn, $id_carrera, $estado) {
    $id_carrera = limpiar($conn, $id_carrera);
    $estado = (int)$estado;
    $q1 = mysqli_query($conn, "UPDATE carrera SET activo = $estado WHERE id = '$id_carrera'");
    $q2 = mysqli_query($conn, "UPDATE asignatura SET activo = $estado WHERE id_carrera = '$id_carrera'");
    return ($q1 && $q2);
}


// FUNCIONES EXCLUSIVAS PARA DOCENTE
function obtener_materias_docente($conn, $id_docente) {
    $id_docente = (int)$id_docente;
    return mysqli_query($conn, "SELECT a.codigo AS cod_asig, a.codigo, a.nombre, a.nivel, a.horas
                                FROM asignacion_docente ad
                                INNER JOIN asignatura a ON ad.cod_asig = a.codigo
                                WHERE ad.id_docente = $id_docente
                                ORDER BY a.nivel, a.codigo");
}
function obtener_estudiantes_materia_docente($conn, $id_docente, $cod_asig) {
    $id_docente = (int)$id_docente;
    $cod_asig = limpiar($conn, $cod_asig);
    return mysqli_query($conn, "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.genero, h.nota_teorico, h.nota_practico, h.nota_bim, h.literal, h.estado, h.observaciones
                                FROM historial h INNER JOIN estudiante e ON h.ci_est = e.ci
                                WHERE h.cod_asig = '$cod_asig' AND h.id_docente = $id_docente ORDER BY e.ap_pat, e.nombre");
}

function registrar_notas_docente($conn, $ci_est, $cod_asig, $id_docente, $notas) {
    $ci_est = limpiar($conn, $ci_est);
    $cod_asig = limpiar($conn, $cod_asig);
    $id_docente = (int)$id_docente;
    $gestion = date('Y');
    
    // FORZAMOS A ENTEROS
    $teorico = (int)($notas['nota_teorico'] ?? 0);
    $practico = (int)($notas['nota_practico'] ?? 0);
    $nota_final = (int)round(($teorico + $practico) / 2); // Redondeo a entero
    
    $literal = ''; $estado = '';
    if ($nota_final >= 51) { $literal = 'A'; $estado = 'APROBADO'; }
    elseif ($nota_final >= 41) { $literal = 'B'; $estado = 'APROBADO'; }
    elseif ($nota_final >= 31) { $literal = 'C'; $estado = 'REPROBADO'; }
    else { $literal = 'D'; $estado = 'REPROBADO'; }
    
    $check = mysqli_query($conn, "SELECT id FROM historial WHERE ci_est = '$ci_est' AND cod_asig = '$cod_asig' AND gestion = '$gestion'");
    
    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE historial SET nota_teorico = $teorico, nota_practico = $practico, nota_bim = $nota_final, literal = '$literal', estado = '$estado', id_docente = $id_docente
                  WHERE ci_est = '$ci_est' AND cod_asig = '$cod_asig' AND gestion = '$gestion'";
    } else {
        $query = "INSERT INTO historial (ci_est, cod_asig, nota_teorico, nota_practico, nota_bim, literal, estado, gestion, id_docente)
                  VALUES ('$ci_est', '$cod_asig', $teorico, $practico, $nota_final, '$literal', '$estado', '$gestion', $id_docente)";
    }
    return mysqli_query($conn, $query);
}

function obtener_detalle_estudiante_admin($conn, $ci) {
    $ci = limpiar($conn, $ci);
    $result = mysqli_query($conn, "SELECT e.*, c.nombre as carrera_nombre, u.usuario, u.activo as usuario_activo 
                                   FROM estudiante e INNER JOIN carrera c ON e.id_carrera = c.id INNER JOIN usuario u ON e.id_usuario = u.id WHERE e.ci = '$ci'");
    return mysqli_fetch_assoc($result);
}


// FUNCIONES CRUD DE NOTAS POR BIMESTRE 
function obtener_estudiantes_materia_bimestre($conn, $id_docente, $cod_asig, $bimestre) {
    $id_docente = (int)$id_docente;
    $cod_asig = limpiar($conn, $cod_asig);
    $bimestre = (int)$bimestre;
    $gestion = date('Y');

    $col_teorico = "nota_teorico$bimestre";
    $col_practico = "nota_pract$bimestre";
    $col_bim = ($bimestre == 1) ? "nota_primerbim" : (($bimestre == 2) ? "nota_segundobim" : (($bimestre == 3) ? "nota_tercerbim" : "nota_cuartobim"));

    $query = "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, 
                     h.$col_teorico as teorico, 
                     h.$col_practico as practico, 
                     h.$col_bim as nota_bim, 
                     h.nota_parcial, h.TotalAnual, h.segundo_turno,
                     h.literal, h.estado, h.observaciones
              FROM inscripcion i
              INNER JOIN estudiante e ON i.ci_est = e.ci AND e.activo = 1
              LEFT JOIN historial h ON i.ci_est = h.ci_est 
                                    AND i.cod_asig = h.cod_asig 
                                    AND h.id_docente = $id_docente 
                                    AND h.gestion = '$gestion'
              WHERE i.cod_asig = '$cod_asig' AND i.activo = 1
              ORDER BY e.ap_pat, e.nombre";
              
    return mysqli_query($conn, $query);
}
function guardar_notas_bimestre_docente($conn, $ci_est, $cod_asig, $id_docente, $bimestre, $teorico, $practico, $observaciones, $segundo_turno = 0) {
    $ci_est = limpiar($conn, $ci_est);
    $cod_asig = limpiar($conn, $cod_asig);
    $id_docente = (int)$id_docente;
    $bimestre = (int)$bimestre;
    $gestion = date('Y');
    $observaciones = limpiar($conn, $observaciones);
    $segundo_turno = (int)$segundo_turno;

    $teorico_val = ($teorico === '' || $teorico === null) ? 'NULL' : (int)$teorico;
    $practico_val = ($practico === '' || $practico === null) ? 'NULL' : (int)$practico;

    $nota_bim_val = 'NULL';
    $literal_bim = '-';
    $estado_bim = 'EN PROCESO';

    if ($teorico_val !== 'NULL' && $practico_val !== 'NULL') {
        $nota_bim_calc = (int)round(($teorico_val * 0.30) + ($practico_val * 0.70));
        $nota_bim_val = $nota_bim_calc;
        
        // Lógica con nota de aprobación 61
        if ($nota_bim_calc >= 81) { 
            $literal_bim = 'A'; 
            $estado_bim = 'APROBADO'; 
        } elseif ($nota_bim_calc >= 61) { 
            $literal_bim = 'B'; 
            $estado_bim = 'APROBADO'; 
        } elseif ($nota_bim_calc >= 51) { 
            $literal_bim = 'C'; 
            $estado_bim = 'REPROBADO';
        } else { 
            $literal_bim = 'D'; 
            $estado_bim = 'REPROBADO'; 
        }
    }

    $col_teorico = "nota_teorico$bimestre";
    $col_practico = "nota_pract$bimestre";
    $col_bim = ($bimestre == 1) ? "nota_primerbim" : (($bimestre == 2) ? "nota_segundobim" : (($bimestre == 3) ? "nota_tercerbim" : "nota_cuartobim"));

    $check = mysqli_query($conn, "SELECT id FROM historial WHERE ci_est = '$ci_est' AND cod_asig = '$cod_asig' AND gestion = '$gestion' AND id_docente = $id_docente");
    
    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE historial SET 
                    $col_teorico = $teorico_val, 
                    $col_practico = $practico_val, 
                    $col_bim = $nota_bim_val, 
                    observaciones = '$observaciones',
                    segundo_turno = $segundo_turno
                  WHERE ci_est = '$ci_est' AND cod_asig = '$cod_asig' AND gestion = '$gestion' AND id_docente = $id_docente";
    } else {
        $query = "INSERT INTO historial (ci_est, cod_asig, id_docente, gestion, $col_teorico, $col_practico, $col_bim, observaciones, segundo_turno)
                  VALUES ('$ci_est', '$cod_asig', $id_docente, '$gestion', $teorico_val, $practico_val, $nota_bim_val, '$observaciones', $segundo_turno)";
    }
    
    $resultado = mysqli_query($conn, $query);
    
    // RECALCULAR TOTALES Y ESTADO AUTOMÁTICAMENTE
    if ($resultado) {
        $fetch_current = mysqli_query($conn, "SELECT nota_primerbim, nota_segundobim, nota_tercerbim, nota_cuartobim, segundo_turno FROM historial WHERE ci_est = '$ci_est' AND cod_asig = '$cod_asig' AND gestion = '$gestion' LIMIT 1");
        $current = mysqli_fetch_assoc($fetch_current);
        
        if ($current) {
            $bims = [$current['nota_primerbim'], $current['nota_segundobim'], $current['nota_tercerbim'], $current['nota_cuartobim']];
            $valid_bims = array_filter($bims, function($val) { return $val !== null && $val !== ''; });
            
            // PROMEDIO REDONDEADO A ENTERO
            $nota_parcial_calc = count($valid_bims) > 0 ? (int)round(array_sum($valid_bims) / count($valid_bims)) : null;
            
            // CALCULAR ESTADO FINAL BASADO EN TOTAL ANUAL (no en estado anterior)
            $total_anual_calc = $nota_parcial_calc;
            $estado_final = 'EN PROCESO';
            
            if ($total_anual_calc !== null) {
                if ($total_anual_calc >= 61) {
                    $estado_final = 'APROBADO';
                } else {
                    $estado_final = 'REPROBADO';
                }
                
                // Si es segundo turno y reprobó, TotalAnual = 0
                if ($current['segundo_turno'] == 1 && $estado_final === 'REPROBADO') {
                    $total_anual_calc = 0;
                }
            }
            
            $literal_texto = ($total_anual_calc !== null) ? numero_a_literal($total_anual_calc) : 'SIN NOTA';
            
            $update_totals = "UPDATE historial SET 
                              nota_parcial = " . ($nota_parcial_calc === null ? 'NULL' : $nota_parcial_calc) . ",
                              TotalAnual = " . ($total_anual_calc === null ? 'NULL' : $total_anual_calc) . ",
                              literal = '" . mysqli_real_escape_string($conn, $literal_texto) . "',
                              estado = '$estado_final'
                              WHERE ci_est = '$ci_est' AND cod_asig = '$cod_asig' AND gestion = '$gestion' AND id_docente = $id_docente";
            
            mysqli_query($conn, $update_totals);
        }
    }
    
    return $resultado;
}
function obtener_resumen_anual_materia_docente($conn, $id_docente, $cod_asig) {
    $id_docente = (int)$id_docente;
    $cod_asig = limpiar($conn, $cod_asig);
    $gestion = date('Y');

    $query = "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, 
                     h.nota_teorico1, h.nota_pract1, h.nota_primerbim,
                     h.nota_teorico2, h.nota_pract2, h.nota_segundobim,
                     h.nota_teorico3, h.nota_pract3, h.nota_tercerbim,
                     h.nota_teorico4, h.nota_pract4, h.nota_cuartobim,
                     h.nota_parcial, h.TotalAnual, h.segundo_turno,
                     h.literal, h.estado, h.observaciones
              FROM inscripcion i
              INNER JOIN estudiante e ON i.ci_est = e.ci AND e.activo = 1
              LEFT JOIN historial h ON i.ci_est = h.ci_est 
                                    AND i.cod_asig = h.cod_asig 
                                    AND h.id_docente = $id_docente 
                                    AND h.gestion = '$gestion'
              WHERE i.cod_asig = '$cod_asig' AND i.activo = 1
              ORDER BY e.ap_pat, e.nombre";
              
    return mysqli_query($conn, $query);
}

function registrar_docente($conn, $ci, $nombre, $ap_pat, $ap_mat, $genero, $cel, $email) {
    $ci = limpiar($conn, $ci);
    $check = mysqli_query($conn, "SELECT ci FROM docente WHERE ci = '$ci'");
    if (mysqli_num_rows($check) > 0) {
        return ['exito' => false, 'msg' => 'Este CI ya está registrado como docente.'];
    }
    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, "INSERT INTO usuario (usuario, clave, id_rol, activo) VALUES ('$ci', '$ci', 4, 1)");
        $nombre = strtoupper(limpiar($conn, $nombre));
        $ap_pat = strtoupper(limpiar($conn, $ap_pat));
        $ap_mat = strtoupper(limpiar($conn, $ap_mat));
        $genero = limpiar($conn, $genero);
        $cel = limpiar($conn, $cel);
        $email = limpiar($conn, $email);
        mysqli_query($conn, "INSERT INTO docente (ci, nombre, ap_pat, ap_mat, genero, cel, email, activo) 
                              VALUES ('$ci', '$nombre', '$ap_pat', '$ap_mat', '$genero', '$cel', '$email', 1)");
        mysqli_commit($conn);
        return ['exito' => true, 'msg' => 'Docente registrado. Usuario y contraseña: ' . $ci];
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['exito' => false, 'msg' => 'Error al registrar docente: ' . $e->getMessage()];
    }
}

function listar_docentes($conn) {
    return mysqli_query($conn, "SELECT * FROM docente WHERE activo = 1 ORDER BY ap_pat, nombre");
}

function desactivar_docente($conn, $ci) {
    $ci = limpiar($conn, $ci);
    mysqli_begin_transaction($conn);
    $q1 = mysqli_query($conn, "UPDATE docente SET activo = 0 WHERE ci = '$ci'");
    $q2 = mysqli_query($conn, "UPDATE usuario SET activo = 0 WHERE usuario = '$ci' AND id_rol = 4");
    if ($q1 && $q2) { mysqli_commit($conn); return true; }
    mysqli_rollback($conn);
    return false;
}

function asignar_materia_a_docente($conn, $id_docente, $cod_asig) {
    $id_docente = (int)$id_docente;
    $cod_asig = limpiar($conn, $cod_asig);
    $query = "UPDATE historial SET id_docente = $id_docente 
              WHERE cod_asig = '$cod_asig' AND (id_docente IS NULL OR id_docente = 0)";
    return mysqli_query($conn, $query);
}


// CRUD: ASIGNACIÓN DE MATERIAS A DOCENTES


function obtener_docente_por_id($conn, $id_docente) {
    $id_docente = (int)$id_docente;
    $result = mysqli_query($conn, "SELECT * FROM docente WHERE id_docente = $id_docente");
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}

function obtener_materias_disponibles_para_docente($conn, $id_docente) {
    $id_docente = (int)$id_docente;
    $sql = "SELECT a.codigo, a.nombre, a.nivel
            FROM asignatura a
            WHERE a.activo = 1
              AND a.codigo NOT IN (SELECT ad.cod_asig FROM asignacion_docente ad 
                                   WHERE ad.id_docente = $id_docente)
            ORDER BY a.nivel, a.codigo";
    $result = mysqli_query($conn, $sql);
    $materias = [];
    while ($row = mysqli_fetch_assoc($result)) $materias[] = $row;
    return $materias;
}

function quitar_materia_docente($conn, $id_docente, $cod_asig) {
    $id_docente = (int)$id_docente;
    $cod_asig = limpiar($conn, $cod_asig);
    mysqli_begin_transaction($conn);
    $ok1 = mysqli_query($conn, "DELETE FROM asignacion_docente WHERE id_docente = $id_docente AND cod_asig = '$cod_asig'");
    $ok2 = mysqli_query($conn, "UPDATE historial SET id_docente = NULL WHERE id_docente = $id_docente AND cod_asig = '$cod_asig'");
    if ($ok1 && $ok2) {
        mysqli_commit($conn);
        return ['exito' => true, 'msg' => 'Materia retirada. Las notas se conservan sin docente asignado.'];
    }
    mysqli_rollback($conn);
    return ['exito' => false, 'msg' => 'Error al quitar la materia.'];
}


// CRUD: ASIGNACIÓN DE MATERIAS A DOCENTES
function obtener_materias_asignadas_docente($conn, $id_docente) {
    $id_docente = (int)$id_docente;
    $sql = "SELECT a.codigo, a.nombre, a.nivel, a.horas, ad.gestion,
                   (SELECT COUNT(DISTINCT i.ci_est) FROM inscripcion i 
                    WHERE i.cod_asig = a.codigo AND i.activo = 1) AS estudiantes
            FROM asignacion_docente ad
            INNER JOIN asignatura a ON ad.cod_asig = a.codigo
            WHERE ad.id_docente = $id_docente
            ORDER BY a.nivel, a.codigo";
    $result = mysqli_query($conn, $sql);
    $materias = [];
    while ($row = mysqli_fetch_assoc($result)) $materias[] = $row;
    return $materias;
}


function asignar_materia_docente($conn, $id_docente, $cod_asig) {
    $id_docente = (int)$id_docente;
    $cod_asig = limpiar($conn, $cod_asig);
    $gestion = date('Y');

    $check = mysqli_query($conn, "SELECT codigo FROM asignatura WHERE codigo = '$cod_asig' AND activo = 1");
    if (!$check || mysqli_num_rows($check) == 0) {
        return ['exito' => false, 'msg' => 'La asignatura no existe o está inactiva.'];
    }

    $doc = mysqli_query($conn, "SELECT id_docente FROM docente WHERE id_docente = $id_docente AND activo = 1");
    if (!$doc || mysqli_num_rows($doc) == 0) {
        return ['exito' => false, 'msg' => 'El docente no existe o está inactivo.'];
    }

    $ya = mysqli_query($conn, "SELECT id FROM asignacion_docente WHERE id_docente = $id_docente AND cod_asig = '$cod_asig'");
    if ($ya && mysqli_num_rows($ya) > 0) {
        return ['exito' => false, 'msg' => 'El docente ya tiene esta materia asignada.'];
    }

    $otro = mysqli_query($conn, "SELECT d.nombre, d.ap_pat FROM asignacion_docente ad
                                 INNER JOIN docente d ON ad.id_docente = d.id_docente
                                 WHERE ad.cod_asig = '$cod_asig' AND ad.id_docente != $id_docente LIMIT 1");
    if ($otro && mysqli_num_rows($otro) > 0) {
        $d = mysqli_fetch_assoc($otro);
        return ['exito' => false, 'msg' => 'Esta materia ya la dicta ' . $d['nombre'] . ' ' . $d['ap_pat'] . '. Debe quitársela primero.'];
    }

    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, "INSERT INTO asignacion_docente (id_docente, cod_asig, gestion) 
                             VALUES ($id_docente, '$cod_asig', '$gestion')");

        mysqli_query($conn, "UPDATE historial SET id_docente = $id_docente
                             WHERE cod_asig = '$cod_asig' AND (id_docente IS NULL OR id_docente = 0)");

        mysqli_query($conn, "INSERT INTO historial (ci_est, cod_asig, id_docente, gestion, estado)
                             SELECT i.ci_est, i.cod_asig, $id_docente, '$gestion', 'EN PROCESO'
                             FROM inscripcion i
                             WHERE i.cod_asig = '$cod_asig' AND i.activo = 1
                               AND NOT EXISTS (SELECT 1 FROM historial h
                                               WHERE h.ci_est = i.ci_est AND h.cod_asig = i.cod_asig AND h.gestion = '$gestion')");
        mysqli_commit($conn);
        return ['exito' => true, 'msg' => 'Materia asignada correctamente al docente.'];
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['exito' => false, 'msg' => 'Error al asignar: ' . $e->getMessage()];
    }
}



?>