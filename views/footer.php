</main>

<!-- ============================================ -->
<!-- FOOTER VERDE CORPORATIVO                     -->
<!-- ============================================ -->
<footer class="footer-verde">
    <div class="container">
        <div class="row g-4">
            
            <!-- Columna 1: Información del Sistema -->
            <div class="col-lg-4 col-md-6">
                <h6>Sistema Académico</h6>
                <p>
                    Plataforma integral de gestión académica para el control de estudiantes, 
                    inscripciones, carreras y reportes institucionales.
                </p>
                <p class="mb-0">
                    <strong>Versión:</strong> 1.0.0<br>
                    <strong>Desarrollado con:</strong> PHP, MySQL, Bootstrap 5
                </p>
            </div>
            
            <!-- Columna 2: Enlaces Rápidos -->
            <div class="col-lg-4 col-md-6">
                <h6>Enlaces Rápidos</h6>
                <ul>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <?php if ($_SESSION['rol_id'] == 1): ?>
                            <li><a href="index.php?action=admin_dashboard&tab=resumen">Panel de Administración</a></li>
                            <li><a href="index.php?action=admin_dashboard&tab=estudiantes">Gestión de Estudiantes</a></li>
                            <li><a href="index.php?action=admin_dashboard&tab=reportes">Reportes del Sistema</a></li>
                        <?php elseif ($_SESSION['rol_id'] == 2): ?>
                            <li><a href="index.php?action=secretaria_dashboard">Panel de Secretaría</a></li>
                            <li><a href="index.php?action=secretaria_inscripcion">Nueva Inscripción</a></li>
                        <?php elseif ($_SESSION['rol_id'] == 3): ?>
                            <li><a href="index.php?action=estudiante_dashboard">Mis Materias</a></li>
                            <li><a href="index.php?action=generar_reporte" target="_blank">Descargar Reporte</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="index.php?action=login">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Columna 3: Contacto -->
            <div class="col-lg-4 col-md-12">
                <h6>Contacto Institucional</h6>
                <div class="info-item">
                    <strong>Dirección:</strong>
                    Av. Gral. Juan José Torrez #123, La Paz - Bolivia
                </div>
                <div class="info-item">
                    <strong>Teléfono:</strong>
                    +591 4 1234567
                </div>
                <div class="info-item">
                    <strong>Email:</strong>
                    info@sistemaacademico.edu.bo
                </div>
                <div class="info-item mb-0">
                    <strong>Horario de Atención:</strong>
                    Lunes a Viernes: 8:00 - 18:00
                </div>
            </div>
        </div>
        
        <!-- Divisor y Copyright -->
        <div class="divider"></div>
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="copyright mb-0">
                    &copy; <?= date('Y') ?> Sistema Académico. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="copyright mb-0">
                    Desarrollado para gestión educativa institucional
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/js/validaciones.js"></script>
</body>
</html>