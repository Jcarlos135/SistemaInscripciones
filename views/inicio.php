<?php include 'views/header.php'; ?>

<link rel="stylesheet" href="/sig/public/css/inicio.css">

<?php if (isset($_SESSION['alerta'])): ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" style="border-radius: 12px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-x-circle-fill fs-4 me-3 text-danger"></i>
                        <div class="flex-grow-1">
                            <strong>Error de acceso:</strong>
                            <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
                        </div>
                        <a href="index.php?action=login" class="btn btn-sm btn-verde ms-3 text-nowrap">
                            <i class="bi bi-arrow-clockwise"></i> Intentar de nuevo
                        </a>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

<!-- Ruta absoluta o dinámica segura -->


<main>
    <!-- SECCIÓN PRINCIPAL: PORTADA Y ACCESO -->
    <div class="container-fluid portada px-4">
        <div class="row portada-card g-0">
            <!-- INFORMACIÓN DEL SISTEMA -->
            <div class="col-lg-12">
                <div class="portada-info position-relative overflow-hidden">

                    <!-- CAPA DE IMÁGENES EN MOVIMIENTO (BACKGROUND SLIDESHOW) -->
                    <div class="slider-background">
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide1.png');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide2.png');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide3.png');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide4.jpg');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide5.jpg');"></div>
                    </div>

                    <!-- CAPA OSCURA SEMITRANSPARENTE PARA MANTENER LA LEGIBILIDAD DEL TEXTO -->
                    <div class="slider-overlay"></div>

                    <!-- CONTENIDO ORIGINAL (LETRAS INTACTAS) -->
                    <div class="position-relative z-2">
                        <div class="logo-portada">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div class="institucion">
                            Instituto Tecnológico Ayacucho
                        </div>
                        <h1 class="titulo-portada">
                            Sistema de<br>
                            Inscripción
                        </h1>
                        <p class="descripcion-portada">
                            Plataforma digital destinada a facilitar el proceso de registro e inscripción de estudiantes de manera rápida, sencilla y segura.
                        </p>
                        <div class="caracteristicas">
                            <span class="caracteristica">
                                <i class="bi bi-person-plus-fill"></i> Registro
                            </span>
                            <span class="caracteristica">
                                <i class="bi bi-file-earmark-text-fill"></i> Inscripción
                            </span>
                            <span class="caracteristica">
                                <i class="bi bi-shield-check"></i> Seguridad
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <!-- ACCESO AL SISTEMA -->
            <!--   <div class="col-lg-5">
            <div class="portada-login">
                <div class="acceso">
                    <div class="icono-acceso">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <h2>Bienvenido</h2>
                    <p>
                        Para acceder al sistema de inscripción, haga clic en el siguiente botón.
                    </p>
                    <a href="index.php?action=login" class="btn-ingresar">
                        <i class="bi bi-box-arrow-in-right"></i> &nbsp; Ingresar al Sistema
                    </a>
                    <div class="info-registro">
                        <i class="bi bi-info-circle-fill"></i>
                        Si aún no tiene una cuenta, podrá registrarse desde el sistema.
                    </div>
                </div>
            </div>
        </div>-->
        </div>
    </div>

    <!-- NUEVA SECCIÓN: VIDEO INSTITUCIONAL / TUTORIAL -->
    <section class="landing-section bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title">Conoce Nuestra Institución y el Proceso</h2>
                    <p class="section-subtitle mb-4">
                        Descubre todo lo que el Instituto Tecnológico Ayacucho tiene para ofrecerte. Mira este breve video guía para conocer paso a paso cómo completar tu inscripción con éxito.
                    </p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i> Carreras técnicas con alta demanda laboral.</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i> Plataforma moderna disponible 24/7.</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i> Soporte técnico permanente durante tu proceso.</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="video-container ratio ratio-16x9">
                        <!-- URL adaptada al formato /embed/ para permitir la reproducción -->
                        <iframe
                            src="https://www.youtube.com/embed/4T-f0S-62V0"
                            title="Video Institucional Tecnológico Ayacucho"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NUEVA SECCIÓN: CARACTERÍSTICAS O PASOS -->
    <section class="landing-section">
        <div class="container text-center">
            <h2 class="section-title">¿Cómo Inscribirte?</h2>
            <p class="section-subtitle">Tres sencillos pasos para formar parte de nuestra comunidad académica.</p>

            <div class="row g-4 text-start">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h4>1. Crea tu cuenta</h4>
                        <p class="text-muted mb-0">Regístrate en el sistema utilizando tus datos personales básicos y correo electrónico válido.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-journal-check"></i>
                        </div>
                        <h4>2. Selecciona tu Carrera</h4>
                        <p class="text-muted mb-0">Elige el programa de estudio de tu preferencia y completa el formulario correspondiente.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <h4>3. Sube tus Documentos</h4>
                        <p class="text-muted mb-0">Adjunta la documentación requerida de forma digital y finaliza tu proceso de inscripción.</p>
                    </div>
                </div>
            </div>

            <!-- Botón llamativo en colores Rojo y Blanco para el Plan de Estudios -->
            <div class="mt-5">
                <a href="/sig/reports/reporte_plan_Estudios.php" target="_blank" class="btn-plan-estudios shadow-lg">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Ver Plan de Estudios (PDF)
                </a>
            </div>

        </div>
    </section>

    <!-- NUEVA SECCIÓN: GALERÍA DE INSTALACIONES E IMÁGENES -->
    <section class="landing-section bg-white">
        <div class="container text-center">
            <h2 class="section-title">Nuestras Instalaciones y Vida Estudiantil</h2>
            <p class="section-subtitle">Espacios diseñados para potenciar tu aprendizaje práctico y profesional.</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="gallery-card">
                        <img src="public/img/portada/est1.jfif" alt="Laboratorios de Computación">
                        <div class="gallery-overlay">Laboratorios Modernos</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-card">
                        <img src="public/img/portada/est2.png" alt="Estudiantes en el Instituto">
                        <div class="gallery-overlay">Comunidad Académica</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-card">
                        <img src="public/img/portada/est3.png" alt="Talleres Técnicos">
                        <div class="gallery-overlay">Talleres Especializados</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'views/footer.php'; ?>