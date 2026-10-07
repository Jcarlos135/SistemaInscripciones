<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/sig/public/css/header.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-header-oscuro shadow-sm">
        <div class="container-fluid">

            <!-- IZQUIERDA: Logo + nombre del sistema -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                <img src="/sig/public/img/portada/logo.png" alt="Logo" height="60" class="me-2">
                Sistema Académico Instituto Tecnológico Ayacucho
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <?php if (isset($_SESSION['usuario_id'])): ?>

                        <?php if ($_SESSION['rol_id'] == 1): ?>

                        <?php elseif ($_SESSION['rol_id'] == 2): ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?action=secretaria_dashboard"><i class="bi bi-journal-check me-1"></i> Secretaria</a></li>
                        <?php endif; ?>



                        <?php if ($_SESSION['rol_id'] == 3): ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?action=estudiante_dashboard">Mis Materias</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?action=generar_reporte" target="_blank">Reporte PDF</a></li>
                        <?php elseif ($_SESSION['rol_id'] == 4): ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?action=docente_dashboard">Panel Docente</a></li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                                <span class="badge bg-light text-primary"><?= htmlspecialchars($_SESSION['rol_nombre']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>

                    <?php else: ?>

                        <!-- Botón Iniciar Sesión con dropdown que contiene el formulario -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle login-destacado" href="#" id="dropdownLogin"
                                role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3 shadow"
                                aria-labelledby="dropdownLogin" style="min-width: 320px;">

                                <li>
                                    <h6 class="text-center mb-3 fw-bold" style="color: #ad072bff;">
                                        <i class="bi bi-person-circle me-1"></i> Iniciar Sesión
                                    </h6>

                                    <!-- Mostrar alerta de error si existe -->
                                    <?php if (isset($_SESSION['alerta'])): ?>
                                        <div class="alert alert-<?= htmlspecialchars($_SESSION['alerta']['tipo']) ?> py-2 mb-3" style="font-size: 0.85rem;">
                                            <?= htmlspecialchars($_SESSION['alerta']['msg']) ?>
                                        </div>
                                        <?php unset($_SESSION['alerta']); ?>
                                    <?php endif; ?>

                                    <form action="index.php?action=procesar_login" method="POST">
                                        <div class="mb-2">
                                            <label class="form-label small fw-semibold">Usuario (CI)</label>
                                            <input type="text" name="usuario" class="form-control form-control-sm"
                                                placeholder="Ingrese su CI" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Contraseña</label>
                                            <input type="password" name="clave" class="form-control form-control-sm"
                                                placeholder="Ingrese su contraseña" required>
                                        </div>
                                        <button type="submit" class="btn btn-sm w-100 text-white fw-semibold"
                                            style="background: #bd0722ff; ">
                                            <i class="bi bi-box-arrow-in-right"></i> Entrar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container pt-1 pb-4">
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                             -->