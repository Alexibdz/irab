<?php
// Segmento activo del nav
$seg    = explode('/', trim(uri_string(), '/'))[0] ?? '';
$activo = fn(array $rutas) => in_array($seg, $rutas, true) ? ' active' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'IRAB - Enfermería') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg" id="verde-degradado">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= base_url('panel') ?>">
            <i class="bi bi-lungs"></i> IRAB
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Navegacion principal -->
            <ul class="navbar-nav me-auto gap-2 align-items-lg-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= $activo(['visitas', 'paciente', 'tutor', 'control']) ?>"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-clipboard2-pulse"></i> Atención
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('visitas') ?>">
                                <i class="bi bi-journal-medical"></i> Visitas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('paciente') ?>">
                                <i class="bi bi-person-badge"></i> Pacientes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('tutor') ?>">
                                <i class="bi bi-people"></i> Tutores
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= $activo(['factores', 'sintomas', 'valores-factores', 'valores-sintomas']) ?>"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-activity"></i> Evaluación
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('factores') ?>">
                                <i class="bi bi-exclamation-triangle"></i> Factores de riesgo
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('sintomas') ?>">
                                <i class="bi bi-thermometer-half"></i> Síntomas
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <!-- Reloj, administracion y sesion -->
            <ul class="navbar-nav align-items-lg-center gap-2">
                <li class="nav-item">
                    <span class="navbar-text small" id="reloj" aria-live="off">
                        <i class="bi bi-clock"></i>
                        <span id="reloj_hora" class="fw-semibold"></span>
                        <span id="reloj_fecha" class="d-none d-xl-inline text-muted"></span>
                    </span>
                </li>

                <?php if (session('logueado')): ?>
                    <li class="nav-item d-none d-lg-block">
                        <span class="navbar-text small">
                            <i class="bi bi-person-circle"></i> <?= esc(session('nombre')) ?>
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?= $activo(['usuarios', 'roles', 'establecimientos']) ?>"
                           href="#" role="button" data-bs-toggle="dropdown"
                           title="Administración" aria-label="Administración">
                            <i class="bi bi-gear-fill fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><h6 class="dropdown-header">Administración</h6></li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('usuarios') ?>">
                                    <i class="bi bi-person-gear"></i> Usuarios
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('establecimientos') ?>">
                                    <i class="bi bi-hospital"></i> Establecimientos
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout') ?>"
                           title="Cerrar sesión" aria-label="Cerrar sesión"
                           onclick="return confirm('¿Cerrar la sesión?');">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                            <span class="d-lg-none">Cerrar sesión</span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>

<main class="container my-4">