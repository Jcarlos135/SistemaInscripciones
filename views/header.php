<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body { background-color: #f4f6f9; }
    .alerta-flotante { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 300px; }
    html, body { height: 100%; margin: 0; }
    body { display: flex; flex-direction: column; min-height: 100vh; background-color: #f8f9fa; }
    main { flex: 1 0 auto; }
    footer { flex-shrink: 0; }

    .footer-verde { background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: #ffffff; padding: 2.5rem 0 1rem 0; margin-top: auto; font-family: 'Segoe UI', sans-serif; }
    .footer-verde h6 { color: #ffffff; font-weight: 700; text-transform: uppercase; font-size: 0.95rem; letter-spacing: 1px; margin-bottom: 1.2rem; padding-bottom: 0.6rem; border-bottom: 2px solid rgba(255, 255, 255, 0.3); }
    .footer-verde p, .footer-verde a, .footer-verde li { color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; text-decoration: none; transition: all 0.25s ease; line-height: 1.7; }
    .footer-verde a:hover { color: #ffffff; text-decoration: underline; }
    .footer-verde ul { padding-left: 0; list-style: none; }
    .footer-verde ul li { margin-bottom: 0.5rem; }
    .footer-verde .divider { border-top: 1px solid rgba(255, 255, 255, 0.2); margin: 2rem 0 1rem 0; }
    .footer-verde .copyright { color: rgba(255, 255, 255, 0.75); font-size: 0.85rem; letter-spacing: 0.3px; }

    .btn-action-ver { background-color: #0dcaf0; color: #ffffff; border: 1px solid #0dcaf0; font-weight: 500; transition: all 0.25s ease; }
    .btn-action-ver:hover { background-color: #0aa2c0; color: #ffffff; border-color: #0aa2c0; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(13, 202, 240, 0.4); }
    .btn-action-editar { background-color: #ffc107; color: #000000; border: 1px solid #ffc107; font-weight: 500; transition: all 0.25s ease; }
    .btn-action-editar:hover { background-color: #e0a800; color: #000000; border-color: #e0a800; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4); }
    .btn-action-eliminar { background-color: #dc3545; color: #ffffff; border: 1px solid #dc3545; font-weight: 500; transition: all 0.25s ease; }
    .btn-action-eliminar:hover { background-color: #bb2d3b; color: #ffffff; border-color: #bb2d3b; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4); }
    .btn-acceso { background-color: #ffffff; color: #198754; border: 2px solid #198754; font-weight: 600; letter-spacing: 0.3px; transition: all 0.25s ease; padding: 8px 20px; }
    .btn-acceso:hover { background-color: #d1e7dd; color: #146c43; border-color: #198754; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2); }
    .btn-verde { background-color: #198754; color: #ffffff; border: 1px solid #198754; font-weight: 500; transition: all 0.25s ease; }
    .btn-verde:hover { background-color: #146c43; color: #ffffff; border-color: #146c43; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(25, 135, 84, 0.35); }
    .btn-negro { background-color: #212529; color: #ffffff; border: 1px solid #212529; font-weight: 500; transition: all 0.25s ease; }
    .btn-negro:hover { background-color: #000000; color: #ffffff; border-color: #000000; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(33, 37, 41, 0.35); }

    .card-verde { border: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); transition: all 0.25s ease; border-top: 3px solid #198754; }
    .card-verde:hover { box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12); }
    .card-header-verde { background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: #ffffff; border: none; font-weight: 600; letter-spacing: 0.5px; }
    .card-header-negro { background-color: #212529; color: #ffffff; border: none; font-weight: 600; }
    .table-header-negro thead { background-color: #212529; color: #ffffff; }
    .table-header-negro thead th { border: none; font-weight: 600; letter-spacing: 0.5px; }
    .bg-header-oscuro { background: linear-gradient(135deg, #06613b 0%, #146c43 100%) !important; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-header-oscuro shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-mortarboard-fill"></i> Sistema Académico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    
                    <?php if ($_SESSION['rol_id'] == 1): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=admin_dashboard"><i class="bi bi-person-gear me-1"></i> Administrador</a></li>
                    <?php elseif ($_SESSION['rol_id'] == 2): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=secretaria_dashboard"><i class="bi bi-journal-check me-1"></i> Secretaria</a></li>
                    <?php endif; ?>

                    <!-- Opción exclusiva para Admin y Secretaria -->
                    <?php if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=gestion_docentes">
                                <i class="bi bi-person-workspace"></i> Gestión de Docentes
                            </a>
                        </li>
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
                    <?php 
                    // Detectar la acción actual para no mostrar el botón si ya estamos en login o inicio
                    $current_action = $_GET['action'] ?? 'inicio';
                    if ($current_action !== 'login' && $current_action !== 'inicio'): 
                    ?>
                    <li class="nav-item">
                        <a class="btn btn-acceso" href="index.php?action=login">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">