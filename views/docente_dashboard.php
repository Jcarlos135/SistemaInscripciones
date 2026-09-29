<?php
include 'header.php';
$vista    = $vista    ?? 'bimestral';
$bimestre = $bimestre ?? 1;
?>
<link rel="stylesheet" href="/sig/public/css/docente_dashboard.css">
<div class="container">
    <div class="header-panel">
        <h2>Panel del Docente - Sistema SIG</h2>
    </div>

    <div class="card">
        <?php if (isset($_SESSION['alerta'])): ?>
            <div class="<?php echo $_SESSION['alerta']['tipo'] === 'danger' ? 'alert-danger' : 'alert-danger'; ?>">
                <?php echo $_SESSION['alerta']['tipo'] === 'danger' ? '✓ ' : '✗ '; ?>
                <?php echo $_SESSION['alerta']['msg']; ?>
            </div>
            <?php unset($_SESSION['alerta']); ?>
        <?php endif; ?>

        <?php if (isset($cod_asig) && isset($estudiantes)): ?>

            <div class="tabs-nav">
                <a href="index.php?action=docente_ver_estudiantes&cod_asig=<?php echo urlencode($cod_asig); ?>&vista=bimestral&bimestre=<?php echo $bimestre; ?>"
                    class="tab-link <?php echo ($vista === 'bimestral') ? 'active' : ''; ?>">
                    Vista Bimestral
                </a>
                <a href="index.php?action=docente_ver_estudiantes&cod_asig=<?php echo urlencode($cod_asig); ?>&vista=anual"
                    class="tab-link <?php echo ($vista === 'anual') ? 'active' : ''; ?>">
                    Vista Anual (Editable)
                </a>
                <a href="index.php?action=docente_dashboard" class="tab-link" style="margin-left: auto; background: transparent;">
                    Volver a Materias
                </a>
            </div>

            <?php if ($vista === 'anual'): ?>
                <!-- VISTA ANUAL EDITABLE CON CÁLCULO EN TIEMPO REAL -->
                <form action="index.php?action=docente_guardar_notas_anual" method="POST">
                    <input type="hidden" name="cod_asig" value="<?php echo htmlspecialchars($cod_asig); ?>">
                    <h3 style="margin:0 0 15px 0; color:#2c3e50;">Resumen y Edición Anual de Calificaciones</h3>

                    <div class="leyenda" style="margin-bottom: 15px;">
                        <div class="leyenda-item"><strong>Nota mínima de aprobación: 61</strong></div>
                        <div class="leyenda-item">
                            <div class="leyenda-color" style="background:#d1fae5;"></div> Aprobado (≥61)
                        </div>
                        <div class="leyenda-item">
                            <div class="leyenda-color" style="background:#fee2e2;"></div> Reprobado (<61)< /div>
                        </div>

                        <div style="overflow-x: auto;">
                            <table>
                                <thead>
                                    <tr>
                                        <th rowspan="2">C.I.</th>
                                        <th rowspan="2" style="text-align: left; min-width: 150px;">Apellidos y Nombres</th>
                                        <th colspan="3">1er Bim</th>
                                        <th colspan="3">2do Bim</th>
                                        <th colspan="3">3er Bim</th>
                                        <th colspan="3">4to Bim</th>
                                        <th rowspan="2">Parcial</th>
                                        <th rowspan="2">Total Anual</th>
                                        <th rowspan="2">Literal</th>
                                        <th rowspan="2">Estado</th>
                                        <th rowspan="2">2do Turno</th>
                                        <th rowspan="2">Obs</th>
                                    </tr>
                                    <tr>
                                        <th>T</th>
                                        <th>P</th>
                                        <th>Total</th>
                                        <th>T</th>
                                        <th>P</th>
                                        <th>Total</th>
                                        <th>T</th>
                                        <th>P</th>
                                        <th>Total</th>
                                        <th>T</th>
                                        <th>P</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($estudiantes)): ?>
                                        <tr>
                                            <td colspan="19" style="padding: 30px; color: #64748b;">No hay estudiantes activos inscritos.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($estudiantes as $index => $est): ?>
                                            <?php
                                            $estado_actual = strtoupper(trim($est['estado'] ?? 'EN PROCESO'));
                                            $es_segundo = isset($est['segundo_turno']) && $est['segundo_turno'] == 1;
                                            $estado_class = 'estado-proceso';
                                            if ($estado_actual === 'APROBADO') $estado_class = 'estado-aprobado';
                                            elseif ($estado_actual === 'REPROBADO' && $es_segundo) $estado_class = 'estado-segundo';
                                            elseif ($estado_actual === 'REPROBADO') $estado_class = 'estado-reprobado';
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo htmlspecialchars($est['ci']); ?>
                                                    <input type="hidden" name="ci_est[]" value="<?php echo htmlspecialchars($est['ci']); ?>">
                                                </td>
                                                <td style="text-align: left; font-weight: 500; font-size: 11px;">
                                                    <?php echo htmlspecialchars($est['ap_pat'] . ' ' . $est['ap_mat'] . ', ' . $est['nombre']); ?>
                                                </td>

                                                <!-- Bimestre 1 -->
                                                <td><input type="number" name="nota_teorico1[<?php echo $index; ?>]" class="input-nota t1" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_teorico1'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td><input type="number" name="nota_practico1[<?php echo $index; ?>]" class="input-nota p1" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_pract1'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td class="info-adicional"><strong class="total-bim-1"><?php echo htmlspecialchars($est['nota_primerbim'] ?? '-'); ?></strong></td>

                                                <!-- Bimestre 2 -->
                                                <td><input type="number" name="nota_teorico2[<?php echo $index; ?>]" class="input-nota t2" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_teorico2'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td><input type="number" name="nota_practico2[<?php echo $index; ?>]" class="input-nota p2" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_pract2'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td class="info-adicional"><strong class="total-bim-2"><?php echo htmlspecialchars($est['nota_segundobim'] ?? '-'); ?></strong></td>

                                                <!-- Bimestre 3 -->
                                                <td><input type="number" name="nota_teorico3[<?php echo $index; ?>]" class="input-nota t3" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_teorico3'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td><input type="number" name="nota_practico3[<?php echo $index; ?>]" class="input-nota p3" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_pract3'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td class="info-adicional"><strong class="total-bim-3"><?php echo htmlspecialchars($est['nota_tercerbim'] ?? '-'); ?></strong></td>

                                                <!-- Bimestre 4 -->
                                                <td><input type="number" name="nota_teorico4[<?php echo $index; ?>]" class="input-nota t4" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_teorico4'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td><input type="number" name="nota_practico4[<?php echo $index; ?>]" class="input-nota p4" min="0" max="100" value="<?php echo htmlspecialchars($est['nota_pract4'] ?? ''); ?>" oninput="recalcularFila(this)"></td>
                                                <td class="info-adicional"><strong class="total-bim-4"><?php echo htmlspecialchars($est['nota_cuartobim'] ?? '-'); ?></strong></td>

                                                <td class="info-adicional"><strong class="nota-parcial"><?php echo htmlspecialchars($est['nota_parcial'] ?? '-'); ?></strong></td>
                                                <td class="info-adicional"><strong class="total-anual <?php echo ($est['TotalAnual'] !== null && (float)$est['TotalAnual'] < 61) ? 'nota-reprobado' : 'text-danger'; ?>"><?php echo htmlspecialchars($est['TotalAnual'] ?? '-'); ?></strong></td>
                                                <td style="font-size: 9px;" class="literal-text"><?php echo htmlspecialchars($est['literal'] ?? '-'); ?></td>
                                                <td><span class="estado-badge estado-dinamica-<?php echo $index; ?> <?php echo $estado_class; ?>"><?php echo $es_segundo && $estado_actual === 'REPROBADO' ? '2DO TURNO' : htmlspecialchars($estado_actual); ?></span></td>
                                                <td><input type="checkbox" name="segundo_turno[]" value="<?php echo htmlspecialchars($est['ci']); ?>" class="checkbox-2turno" <?php echo $es_segundo ? 'checked' : ''; ?> onchange="recalcularFila(this)"></td>
                                                <td><input type="text" name="observaciones[<?php echo $index; ?>]" class="input-obs" value="<?php echo htmlspecialchars($est['observaciones'] ?? ''); ?>"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-container">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?action=docente_ver_estudiantes&cod_asig=<?php echo urlencode($cod_asig); ?>&vista=bimestre'">Volver a Vista Bimestral</button>
                            <button type="submit" class="btn btn-danger">💾 Guardar Todas las Notas Anuales</button>
                        </div>
                </form>

            <?php else: ?>
                <!-- VISTA BIMESTRAL -->
                <h3 style="margin:0 0 20px 0; color:#2c3e50;">Registro de Calificaciones Bimestral</h3>
                <form id="formNotas" action="index.php?action=docente_guardar_notas" method="POST">
                    <input type="hidden" name="cod_asig" value="<?php echo htmlspecialchars($cod_asig); ?>">
                    <div class="grid-filters">
                        <div class="form-group">
                            <label>Asignatura:</label>
                            <input type="text" value="<?php echo htmlspecialchars($cod_asig); ?>" readonly style="background:#e2e8f0; font-weight:bold;">
                        </div>
                        <div class="form-group">
                            <label for="bimestre">Bimestre a Evaluar:</label>
                            <select id="bimestre" name="bimestre" onchange="cambiarBimestre(this.value)" required>
                                <option value="1" <?php echo ($bimestre == 1) ? 'selected' : ''; ?>>1° Bimestre</option>
                                <option value="2" <?php echo ($bimestre == 2) ? 'selected' : ''; ?>>2° Bimestre</option>
                                <option value="3" <?php echo ($bimestre == 3) ? 'selected' : ''; ?>>3° Bimestre</option>
                                <option value="4" <?php echo ($bimestre == 4) ? 'selected' : ''; ?>>4° Bimestre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gestión Académica:</label>
                            <input type="text" value="<?php echo date('Y'); ?>" readonly style="background:#e2e8f0;">
                        </div>
                    </div>

                    <div style="overflow-x: auto; margin-top: 15px;">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 90px;">C.I.</th>
                                    <th style="text-align: left; min-width: 180px;">Apellidos y Nombres</th>
                                    <th style="width: 75px;">Teórico<br><small>(30%)</small></th>
                                    <th style="width: 75px;">Práctico<br><small>(70%)</small></th>
                                    <th style="width: 70px;">Nota Bim.<br><small>(Preview)</small></th>
                                    <th style="width: 90px;">Estado</th>
                                    <th style="width: 70px;">2do Turno</th>
                                    <th style="min-width: 130px;">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($estudiantes)): ?>
                                    <tr>
                                        <td colspan="8" style="padding: 30px; color: #64748b;">No hay estudiantes activos inscritos.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($estudiantes as $index => $est): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($est['ci']); ?><input type="hidden" name="ci_est[]" value="<?php echo htmlspecialchars($est['ci']); ?>"></td>
                                            <td style="text-align: left; font-weight: 500; font-size: 12px;"><?php echo htmlspecialchars($est['ap_pat'] . ' ' . $est['ap_mat'] . ', ' . $est['nombre']); ?></td>
                                            <td><input type="number" name="nota_teorico[]" class="input-nota teorico" min="0" max="100" value="<?php echo htmlspecialchars($est['teorico'] ?? ''); ?>" placeholder="0" oninput="calcularNota(this, <?php echo $index; ?>)"></td>
                                            <td><input type="number" name="nota_practico[]" class="input-nota practico" min="0" max="100" value="<?php echo htmlspecialchars($est['practico'] ?? ''); ?>" placeholder="0" oninput="calcularNota(this, <?php echo $index; ?>)"></td>
                                            <td><span class="nota-final" id="nota_bim_<?php echo $index; ?>"><?php echo htmlspecialchars($est['nota_bim'] ?? '-'); ?></span></td>
                                            <td><span class="estado-badge estado-proceso" id="estado_<?php echo $index; ?>">EN PROCESO</span></td>
                                            <td><input type="checkbox" name="segundo_turno[]" value="<?php echo htmlspecialchars($est['ci']); ?>" class="checkbox-2turno" <?php echo (isset($est['segundo_turno']) && $est['segundo_turno'] == 1) ? 'checked' : ''; ?>></td>
                                            <td><input type="text" name="observaciones[]" class="input-obs" value="<?php echo htmlspecialchars($est['observaciones'] ?? ''); ?>" placeholder="Opcional"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn-container">
                        <button type="button" class="btn btn-secondary" onclick="limpiarTodasLasNotas()">Limpiar Todo</button>
                        <button type="submit" class="btn btn-danger">💾 Guardar Notas del Bimestre</button>
                    </div>
                </form>
            <?php endif; ?>

        <?php else: ?>
            <!-- VISTA 1: LISTADO DE MATERIAS ASIGNADAS -->
            <h3 style="margin-top:0; color:#2c3e50;">Hola, <?php echo htmlspecialchars($docente['nombre'] . ' ' . $docente['ap_pat']); ?></h3>
            <p style="color:#64748b; margin-bottom: 20px;">Selecciona una asignatura para administrar las calificaciones:</p>
            <table>
                <thead>
                    <tr>
                        <th style="width: 120px;">Código</th>
                        <th style="text-align: left;">Asignatura</th>
                        <th style="width: 100px;">Nivel</th>
                        <th style="width: 180px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($materias_asignadas)): ?>
                        <tr>
                            <td colspan="4" style="padding: 30px; color: #476c49ff;">No tienes materias asignadas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($materias_asignadas as $materia): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($materia['cod_asig']); ?></strong></td>
                                <td style="text-align: left;"><?php echo htmlspecialchars($materia['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($materia['nivel']); ?></td>
                                <td><a href="index.php?action=docente_ver_estudiantes&cod_asig=<?php echo urlencode($materia['cod_asig']); ?>&bimestre=1" class="btn btn-primary btn-sm">Administrar Notas</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
    function cambiarBimestre(valor) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('bimestre', valor);
        urlParams.set('vista', 'bimestral');
        window.location.href = 'index.php?action=docente_ver_estudiantes&' + urlParams.toString();
    }

    function calcularNota(input, index) {
        const fila = input.closest('tr');
        const teorico = parseFloat(fila.querySelector('.teorico').value) || 0;
        const practico = parseFloat(fila.querySelector('.practico').value) || 0;

        const notaBim = Math.round((teorico * 0.30) + (practico * 0.70));
        const elemNotaFinal = document.getElementById('nota_bim_' + index);
        const elemEstado = document.getElementById('estado_' + index);

        elemNotaFinal.textContent = (teorico === 0 && practico === 0) ? '0' : notaBim;

        if (teorico === 0 && practico === 0) {
            elemEstado.textContent = 'EN PROCESO';
            elemEstado.className = 'estado-badge estado-proceso';
            elemNotaFinal.classList.remove('nota-reprobado');
        } else if (notaBim >= 61) {
            elemEstado.textContent = 'APROBADO';
            elemEstado.className = 'estado-badge estado-aprobado';
            elemNotaFinal.classList.remove('nota-reprobado');
        } else {
            elemEstado.textContent = 'REPROBADO';
            elemEstado.className = 'estado-badge estado-reprobado';
            elemNotaFinal.classList.add('nota-reprobado');
        }
    }

    function limpiarTodasLasNotas() {
        if (confirm('¿Estás seguro de que deseas LIMPIAR/ANULAR todas las notas de este bimestre?')) {
            document.querySelectorAll('.teorico, .practico').forEach(input => {
                input.value = '';
                input.dispatchEvent(new Event('input'));
            });
            document.querySelectorAll('.input-obs').forEach(input => {
                input.value = '';
            });
        }
    }

    // ==========================================
    // CÁLCULO EN TIEMPO REAL PARA VISTA ANUAL
    // ==========================================
    function recalcularFila(input) {
        const row = input.closest('tr');

        const getVal = (cls) => {
            const el = row.querySelector('.' + cls);
            return el && el.value !== '' ? parseFloat(el.value) : null;
        };

        const t1 = getVal('t1'),
            p1 = getVal('p1');
        const t2 = getVal('t2'),
            p2 = getVal('p2');
        const t3 = getVal('t3'),
            p3 = getVal('p3');
        const t4 = getVal('t4'),
            p4 = getVal('p4');

        const calcBim = (t, p) => (t !== null && p !== null) ? Math.round(t * 0.30 + p * 0.70) : null;

        const b1 = calcBim(t1, p1);
        const b2 = calcBim(t2, p2);
        const b3 = calcBim(t3, p3);
        const b4 = calcBim(t4, p4);

        const setBimTotal = (cls, val) => {
            const el = row.querySelector('.' + cls);
            if (el) el.textContent = val !== null ? val : '-';
        };
        setBimTotal('total-bim-1', b1);
        setBimTotal('total-bim-2', b2);
        setBimTotal('total-bim-3', b3);
        setBimTotal('total-bim-4', b4);

        const bims = [b1, b2, b3, b4].filter(v => v !== null);
        let notaParcial = null;
        if (bims.length > 0) {
            notaParcial = Math.round(bims.reduce((a, b) => a + b, 0) / bims.length);
        }

        const esSegundo = row.querySelector('.checkbox-2turno').checked;

        let totalAnual = null;
        let estado = 'EN PROCESO';

        if (notaParcial !== null) {
            if (esSegundo && notaParcial < 61) {
                totalAnual = 0;
                estado = 'REPROBADO';
            } else {
                totalAnual = notaParcial;
                estado = (totalAnual >= 61) ? 'APROBADO' : 'REPROBADO';
            }
        }

        const elParcial = row.querySelector('.nota-parcial');
        if (elParcial) elParcial.textContent = notaParcial !== null ? notaParcial : '-';

        const elTotal = row.querySelector('.total-anual');
        if (elTotal) {
            elTotal.textContent = totalAnual !== null ? totalAnual : '-';
            elTotal.className = 'total-anual ' + (totalAnual !== null && totalAnual < 61 ? 'nota-reprobado' : 'text-danger');
        }

        const elLiteral = row.querySelector('.literal-text');
        if (elLiteral) elLiteral.textContent = totalAnual !== null ? numeroALiteral(totalAnual) : '-';

        // Actualizar badge de estado
        const elEstado = row.querySelector('[class*="estado-dinamica-"]');
        if (elEstado) {
            elEstado.textContent = estado === 'EN PROCESO' ? 'EN PROCESO' : (esSegundo && estado === 'REPROBADO' ? '2DO TURNO' : estado);
            elEstado.className = elEstado.className.replace(/estado-\w+/g, '').trim(); // Limpiar clases de estado anteriores
            if (estado === 'APROBADO') elEstado.classList.add('estado-aprobado');
            else if (estado === 'REPROBADO' && esSegundo) elEstado.classList.add('estado-segundo');
            else if (estado === 'REPROBADO') elEstado.classList.add('estado-reprobado');
            else elEstado.classList.add('estado-proceso');
        }
    }

    function numeroALiteral(num) {
        if (num === null || num === '' || num === '-') return '-';
        num = Math.round(parseFloat(num));
        if (num === 0) return 'CERO';
        if (num === 100) return 'CIEN';
        const unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        const decenas = ['', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        const especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTE', 'VEINTIUNO', 'VEINTIDOS', 'VEINTITRES', 'VEINTICUATRO', 'VEINTICINCO', 'VEINTISEIS', 'VEINTISIETE', 'VEINTIOCHO', 'VEINTINUEVE'];
        if (num < 30) return especiales[num];
        const dec = Math.floor(num / 10);
        const uni = num % 10;
        if (uni === 0) return decenas[dec];
        return decenas[dec] + ' Y ' + unidades[uni];
    }

    // Ejecutar cálculo inicial al cargar la página para la vista anual
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.t1, .p1, .t2, .p2, .t3, .p3, .t4, .p4').forEach(input => {
            if (input.value !== '') {
                recalcularFila(input);
            }
        });
    });
</script>

<?php include 'footer.php'; ?>