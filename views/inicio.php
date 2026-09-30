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

<main>
    <!-- =====================================================
         SECCIÓN 1: PORTADA PRINCIPAL CON SLIDESHOW (INTACTA)
         ===================================================== -->
    <div class="container-fluid portada px-4">
        <div class="row portada-card g-0">
            <div class="col-lg-12">
                <div class="portada-info position-relative overflow-hidden">

                    <!-- CAPA DE IMÁGENES EN MOVIMIENTO -->
                    <div class="slider-background">
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide1.png');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide2.png');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide3.png');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide4.jpg');"></div>
                        <div class="slide-img" style="background-image: url('/sig/public/img/portada/slide5.jpg');"></div>
                    </div>

                    <div class="slider-overlay"></div>

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
        </div>
    </div>

    <!-- 
         SECCIÓN 2: ESTADÍSTICAS / NÚMEROS DESTACADOS
         
    <section class="landing-section stats-section">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-number" data-count="1250">0</div>
                        <div class="stat-label">Estudiantes Activos</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-book-fill"></i></div>
                        <div class="stat-number" data-count="24">0</div>
                        <div class="stat-label">Carreras Técnicas</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-award-fill"></i></div>
                        <div class="stat-number" data-count="35">0</div>
                        <div class="stat-label">Años de Experiencia</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                        <div class="stat-number" data-count="92">0</div>
                        <div class="stat-label">% Inserción Laboral</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 -->
    <!-- =====================================================
         SECCIÓN 3: VIDEO INSTITUCIONAL (INTACTA)
         ===================================================== -->
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

    <!-- =====================================================
         SECCIÓN 4: CARRERAS DESTACADAS (NUEVA)
         ===================================================== -->
    <section class="landing-section carreras-section">
        <div class="container text-center">
            <h2 class="section-title">Nuestras Carreras Técnicas</h2>
            <p class="section-subtitle">Programas diseñados según las demandas del mercado laboral actual.</p>

            <div class="row g-4 text-start">
                <div class="col-md-6 col-lg-3">
                    <div class="carrera-card">
                        <div class="carrera-icon"><i class="bi bi-laptop"></i></div>
                        <h5>Sistemas Informáticos</h5>
                        <p class="text-muted small mb-3">Desarrollo de software, redes y bases de datos.</p>
                        <span class="carrera-badge">3 años</span>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="carrera-card">
                        <div class="carrera-icon"><i class="bi bi-calculator"></i></div>
                        <h5>Contaduría General</h5>
                        <p class="text-muted small mb-3">Gestión contable, tributaria y financiera.</p>
                        <span class="carrera-badge">3 años</span>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="carrera-card">
                        <div class="carrera-icon"><i class="bi bi-lightning-charge"></i></div>
                        <h5>Electricidad Industrial</h5>
                        <p class="text-muted small mb-3">Instalaciones, mantenimiento y automatización.</p>
                        <span class="carrera-badge">3 años</span>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="carrera-card">
                        <div class="carrera-icon"><i class="bi bi-gear-wide-connected"></i></div>
                        <h5>Mecánica Automotriz</h5>
                        <p class="text-muted small mb-3">Diagnóstico, reparación y mantenimiento vehicular.</p>
                        <span class="carrera-badge">3 años</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         SECCIÓN 5: ¿CÓMO INSCRIBIRTE? (INTACTA)
         ===================================================== -->
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

            <div class="mt-5">
                <a href="/sig/reports/reporte_plan_Estudios.php" target="_blank" class="btn-plan-estudios shadow-lg">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Ver Plan de Estudios (PDF)
                </a>
            </div>
        </div>
    </section>

    <!-- =====================================================
         SECCIÓN 6: BENEFICIOS / POR QUÉ ELEGIRNOS (NUEVA)
         ===================================================== -->
    <section class="landing-section bg-white">
        <div class="container text-center">
            <h2 class="section-title">¿Por Qué Elegirnos?</h2>
            <p class="section-subtitle">Ventajas que nos diferencian como institución técnica de calidad.</p>

            <div class="row g-4 text-start">
                <div class="col-md-6 col-lg-3">
                    <div class="beneficio-box">
                        <i class="bi bi-patch-check-fill beneficio-icon"></i>
                        <h6>Formación Técnica Certificada</h6>
                        <p class="text-muted small mb-0">Títulos avalados por el Ministerio de Educación.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="beneficio-box">
                        <i class="bi bi-people-fill beneficio-icon"></i>
                        <h6>Docentes Especializados</h6>
                        <p class="text-muted small mb-0">Profesionales con experiencia en el sector productivo.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="beneficio-box">
                        <i class="bi bi-building-gear beneficio-icon"></i>
                        <h6>Laboratorios Equipados</h6>
                        <p class="text-muted small mb-0">Ambientes modernos con tecnología actualizada.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="beneficio-box">
                        <i class="bi bi-graph-up-arrow beneficio-icon"></i>
                        <h6>Bolsa de Trabajo</h6>
                        <p class="text-muted small mb-0">Convenios con empresas para prácticas profesionales.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         SECCIÓN 7: GALERÍA (INTACTA)
         ===================================================== -->
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

    <!-- =====================================================
         SECCIÓN 8: TESTIMONIOS DE EGRESADOS (NUEVA)
         ===================================================== -->
    <section class="landing-section testimonios-section">
        <div class="container text-center">
            <h2 class="section-title">Lo Que Dicen Nuestros Egresados</h2>
            <p class="section-subtitle">Historias reales de estudiantes que hoy son profesionales exitosos.</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonio-card">
                        <div class="testimonio-quote"><i class="bi bi-quote"></i></div>
                        <p class="testimonio-text">
                            "Gracias al Instituto pude formarme como técnico en sistemas y hoy trabajo en una empresa de desarrollo de software. La formación práctica fue clave."
                        </p>
                        <div class="testimonio-author">
                            <div class="testimonio-avatar"><i class="bi bi-person-circle"></i></div>
                            <div>
                                <strong>Carlos Mamani</strong>
                                <div class="small text-muted">Egresado - Sistemas Informáticos</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonio-card">
                        <div class="testimonio-quote"><i class="bi bi-quote"></i></div>
                        <p class="testimonio-text">
                            "Los docentes son excelentes profesionales y siempre están dispuestos a ayudar. La infraestructura es moderna y los laboratorios están muy bien equipados."
                        </p>
                        <div class="testimonio-author">
                            <div class="testimonio-avatar"><i class="bi bi-person-circle"></i></div>
                            <div>
                                <strong>María Quispe</strong>
                                <div class="small text-muted">Egresada - Contaduría General</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonio-card">
                        <div class="testimonio-quote"><i class="bi bi-quote"></i></div>
                        <p class="testimonio-text">
                            "El sistema de inscripción en línea me facilitó todo el proceso. Además, la bolsa de trabajo me permitió conseguir mi primera oportunidad laboral rápidamente."
                        </p>
                        <div class="testimonio-author">
                            <div class="testimonio-avatar"><i class="bi bi-person-circle"></i></div>
                            <div>
                                <strong>Luis Condori</strong>
                                <div class="small text-muted">Egresado - Electricidad Industrial</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         SECCIÓN 9: PREGUNTAS FRECUENTES (NUEVA)
         ===================================================== -->
    <section class="landing-section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Preguntas Frecuentes</h2>
                <p class="section-subtitle">Resolvemos las dudas más comunes sobre el proceso de inscripción.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="bi bi-question-circle-fill me-2 text-danger"></i> ¿Cómo me registro en el sistema?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Debes ingresar al sistema con tu C.I. como usuario y contraseña inicial. Si es tu primera vez, acércate a secretaría académica para que habiliten tu cuenta.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="bi bi-question-circle-fill me-2 text-danger"></i> ¿Cuántas materias puedo inscribir por gestión?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Depende de tu situación académica. Un estudiante regular inscribe todas las materias del nivel correspondiente. Si tienes materias reprobadas, se te asignará un turno diferenciado.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="bi bi-question-circle-fill me-2 text-danger"></i> ¿Qué significa BTH y en qué se diferencia de Regular?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    BTH significa Bachillerato Técnico Humanístico. Los estudiantes BTH convalidan las materias del primer año por Resolución Ministerial y continúan desde el segundo año.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="bi bi-question-circle-fill me-2 text-danger"></i> ¿Qué pasa si repruebo 3 o más materias?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Si repruebas entre 1 y 3 materias, puedes arrastrarlas en un turno diferenciado. Si repruebas más de 3, repites el nivel completo y solo cursas las materias reprobadas.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="bi bi-question-circle-fill me-2 text-danger"></i> ¿Cómo obtengo mi ficha académica?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ingresando al sistema con tu cuenta, en la sección "Mis Materias" puedes generar tu ficha académica en PDF con todas tus notas por gestión.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 
         SECCIÓN 10: LLAMADO A LA ACCIÓN (NUEVA)
        
    <section class="landing-section cta-section">
        <div class="container text-center">
            <h2 class="cta-title">¿Listo para comenzar tu formación técnica?</h2>
            <p class="cta-subtitle">Únete a nuestra comunidad académica y construye tu futuro profesional con nosotros.</p>
            <div class="cta-buttons">
                <a href="index.php?action=login" class="btn btn-light btn-lg me-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Ingresar al Sistema
                </a>
                <a href="#contacto" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-telephone-fill me-2"></i> Contactar
                </a>
            </div>
        </div>
    </section>-->


</main>

<!-- =====================================================
     SCRIPTS ADICIONALES (Contador animado + AOS)
     ===================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // =====================================================
        // CONTADOR ANIMADO DE ESTADÍSTICAS
        // =====================================================
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-count');
            const increment = target / speed;

            const updateCount = () => {
                const current = +counter.innerText;
                if (current < target) {
                    counter.innerText = Math.ceil(current + increment);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        // Detectar cuándo entran en viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(counter => observer.observe(counter));
    });
</script>

<?php include 'views/footer.php'; ?>