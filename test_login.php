<?php
// test_login.php - Diagnóstico completo
require_once 'config/db.php';
require_once 'models/funciones.php';

echo "<h3>🔍 Diagnóstico del Sistema</h3>";
echo "<hr>";

// 1. Verificar conexión BD
echo "<h4>1. Conexión Base de Datos</h4>";
if ($conn) {
    echo "<p style='color:green'> Conectado a MySQL</p>";
} else {
    echo "<p style='color:red'> NO conectado</p>";
    die();
}

// 2. Verificar tabla documento existe
echo "<h4>2. Tabla 'documento'</h4>";
 $check_doc = mysqli_query($conn, "SHOW TABLES LIKE 'documento'");
if (mysqli_num_rows($check_doc) > 0) {
    echo "<p style='color:green'> Tabla 'documento' existe</p>";
} else {
    echo "<p style='color:red'> Tabla 'documento' NO existe — ejecutar SQL</p>";
}

// 3. Verificar contraseñas de estudiantes
echo "<h4>3. Contraseñas de Estudiantes (deben ser = CI)</h4>";
 $users = mysqli_query($conn, "SELECT id, usuario, clave, id_rol, activo FROM usuario WHERE id_rol = 3 ORDER BY id");
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Usuario</th><th>Clave</th><th>¿Clave=CI?</th><th>Activo</th></tr>";
while ($u = mysqli_fetch_assoc($users)) {
    $match = ($u['clave'] === $u['usuario']) ? ' Sí' : ' No';
    $color = ($u['clave'] === $u['usuario']) ? 'green' : 'red';
    $activo = $u['activo'] ? '✅' : '❌';
    echo "<tr><td>{$u['id']}</td><td>{$u['usuario']}</td><td>{$u['clave']}</td><td style='color:$color'>$match</td><td>$activo</td></tr>";
}
echo "</table>";

// 4. Test login con datos existentes
echo "<h4>4. Test Login (usuario existente)</h4>";
 $test_users = [
    ['usuario' => 'admin', 'clave' => '123456'],
    ['usuario' => 'secretaria', 'clave' => '123456'],
    ['usuario' => '12345678', 'clave' => '12345678'],
    ['usuario' => '7685675', 'clave' => '7685675'],
];

foreach ($test_users as $test) {
    $result = login($conn, $test['usuario'], $test['clave']);
    if ($result) {
        echo "<p style='color:green'> Login OK: {$test['usuario']} → Rol: {$result['rol_nombre']}</p>";
    } else {
        echo "<p style='color:red'> Login FAIL: {$test['usuario']} / {$test['clave']}</p>";
        
        // Debug: mostrar qué se encontró en BD
        $u_esc = mysqli_real_escape_string($conn, $test['usuario']);
        $debug_q = "SELECT * FROM usuario WHERE usuario = '$u_esc'";
        $debug_r = mysqli_query($conn, $debug_q);
        if (mysqli_num_rows($debug_r) > 0) {
            $debug_row = mysqli_fetch_assoc($debug_r);
            echo "<p style='color:orange'>→ En BD: clave='{$debug_row['clave']}', activo={$debug_row['activo']}, id_rol={$debug_row['id_rol']}</p>";
            echo "<p style='color:orange'>→ Comparando: md5('{$test['clave']}')='" . md5($test['clave']) . "' vs stored='{$debug_row['clave']}'</p>";
        } else {
            echo "<p style='color:red'>→ Usuario '{$test['usuario']}' NO EXISTE en la tabla usuario</p>";
        }
    }
}

// 5. Test verificar_inscripcion
echo "<h4>5. Test Verificar Inscripción</h4>";
 $test_cis = ['12345678', '7685675', '99999999']; // último no existe

foreach ($test_cis as $ci) {
    $info = verificar_estudiante_registrado($conn, $ci);
    if ($info['registrado']) {
        $d = $info['datos'];
        echo "<p style='color:green'> CI $ci registrado: {$d['nombre']} {$d['ap_pat']} — activo={$d['activo']}</p>";
    } else {
        echo "<p style='color:red'> CI $ci NO registrado</p>";
    }
}

// 6. Test endpoint verificar_inscripcion directamente
echo "<h4>6. Test Endpoint verificar_inscripcion</h4>";
 $ci_test = '12345678';
 $ci_esc = mysqli_real_escape_string($conn, $ci_test);

 $q = "SELECT e.ci, e.nombre, e.ap_pat, e.ap_mat, e.activo, e.id_carrera,
             u.usuario, u.activo as usuario_activo
      FROM estudiante e 
      LEFT JOIN usuario u ON e.id_usuario = u.id
      WHERE e.ci = '$ci_esc'";
 $r = mysqli_query($conn, $q);

if ($r && mysqli_num_rows($r) > 0) {
    $d = mysqli_fetch_assoc($r);
    echo "<p style='color:green'> Query OK para CI $ci_test</p>";
    echo "<pre>"; print_r($d); echo "</pre>";
    
    // Test carrera query
    $carr_id = mysqli_real_escape_string($conn, $d['id_carrera'] ?? 'SIS-INF');
    $q_carr = "SELECT nombre FROM carrera WHERE id = '$carr_id'";
    $r_carr = mysqli_query($conn, $q_carr);
    if ($r_carr) {
        $carr_data = mysqli_fetch_assoc($r_carr);
        echo "<p style='color:green'> Carrera: {$carr_data['nombre']}</p>";
    } else {
        echo "<p style='color:red'> Error carrera: " . mysqli_error($conn) . "</p>";
    }
    
    // Test inscripcion query
    $q_tipo = "SELECT tipo FROM inscripcion WHERE ci_est = '$ci_esc' AND activo = 1 LIMIT 1";
    $r_tipo = mysqli_query($conn, $q_tipo);
    if ($r_tipo) {
        $tipo_data = mysqli_fetch_assoc($r_tipo);
        echo "<p style='color:green'> Tipo inscripción: {$tipo_data['tipo']}</p>";
    } else {
        echo "<p style='color:red'> Error inscripción: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:red'> No se encontró CI $ci_test</p>";
}
?>