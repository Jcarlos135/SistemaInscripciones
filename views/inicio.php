<?php include 'views/header.php'; ?>

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

<style>
    body {
        background: #f4f7f5;
    }
    .portada {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        padding: 40px 0;
    }
    .portada-card {
        width: 100%;
        min-height: 600px;
        border-radius: 25px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 15px 45px rgba(0,0,0,.15);
    }
    /* PANEL IZQUIERDO */
    .portada-info {
        min-height: 600px;
        padding: 60px;
        background: linear-gradient(135deg, #a0dbb5, #0b3523);
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .logo-portada {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,.25);
    }
    .logo-portada i {
        font-size: 50px;
        color: #059d3b;
    }
    .institucion {
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    .titulo-portada {
        font-size: 48px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 25px;
    }
    .descripcion-portada {
        font-size: 18px;
        line-height: 1.7;
        color: rgba(255,255,255,.9);
        max-width: 600px;
    }
    .caracteristicas {
        margin-top: 30px;
    }
    .caracteristica {
        display: inline-block;
        padding: 8px 14px;
        margin: 5px;
        border-radius: 30px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        font-size: 14px;
    }
    /* PANEL DERECHO */
    .portada-login {
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
    }
    .acceso {
        width: 100%;
        max-width: 380px;
        text-align: center;
    }
    .icono-acceso {
        width: 90px;
        height: 90px;
        margin: 0 auto 25px;
        border-radius: 20px;
        background: linear-gradient(135deg, #059d3b, #022818);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(5,157,59,.3);
    }
    .icono-acceso i {
        font-size: 45px;
    }
    .acceso h2 {
        font-weight: 700;
        margin-bottom: 15px;
    }
    .acceso p {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .btn-ingresar {
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #059d3b, #022818);
        color: white;
        font-size: 17px;
        font-weight: 700;
        text-decoration: none;
        display: block;
        transition: all .3s ease;
    }
    .btn-ingresar:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(5,157,59,.35);
    }
    .info-registro {
        margin-top: 25px;
        font-size: 14px;
        color: #777;
    }
    .info-registro i {
        color: #059d3b;
    }

    /* ESTILOS NUEVOS PARA LAS SECCIONES DE LA LANDING PAGE */
    .landing-section {
        padding: 80px 0;
    }
    .section-title {
        font-weight: 800;
        color: #022818;
        margin-bottom: 15px;
    }
    .section-subtitle {
        color: #6c757d;
        font-size: 18px;
        margin-bottom: 50px;
    }
    /* Estilos para tarjetas informativas y galería */
    .feature-box {
        background: #fff;
        padding: 35px 25px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.05);
        height: 100%;
        transition: transform .3s ease;
    }
    .feature-box:hover {
        transform: translateY(-5px);
    }
    .feature-icon {
        width: 65px;
        height: 65px;
        background: rgba(5, 157, 59, 0.1);
        color: #059d3b;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 30px;
        margin-bottom: 20px;
    }
    /* Galería de imágenes */
    .gallery-card {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        height: 250px;
    }
    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .gallery-card:hover img {
        transform: scale(1.08);
    }
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(2,40,24,0.85), transparent);
        color: white;
        padding: 20px;
        font-weight: 600;
    }
    /* Sección de Video */
    .video-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,.15);
        background: #000;
    }

    @media(max-width: 768px) {
        .portada {
            padding: 20px 0;
        }
        .portada-info {
            min-height: auto;
            padding: 45px 30px;
            text-align: center;
        }
        .portada-login {
            min-height: auto;
            padding: 45px 30px;
        }
        .logo-portada {
            margin-left: auto;
            margin-right: auto;
        }
        .titulo-portada {
            font-size: 36px;
        }
    }
</style>

<!-- SECCIÓN PRINCIPAL: PORTADA Y ACCESO -->
<div class="container portada">
    <div class="row portada-card g-0">
        <!-- INFORMACIÓN DEL SISTEMA -->
        <div class="col-lg-7">
            <div class="portada-info">
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

        <!-- ACCESO AL SISTEMA -->
        <div class="col-lg-5">
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
        </div>
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
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Carreras técnicas con alta demanda laboral.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Plataforma moderna disponible 24/7.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Soporte técnico permanente durante tu proceso.</li>
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
                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80" alt="Laboratorios de Computación">
                    <div class="gallery-overlay">Laboratorios Modernos</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80" alt="Estudiantes en el Instituto">
                    <div class="gallery-overlay">Comunidad Académica</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80" alt="Talleres Técnicos">
                    <div class="gallery-overlay">Talleres Especializados</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/footer.php'; ?>