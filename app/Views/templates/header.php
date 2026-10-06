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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">

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
            <ul class="navbar-nav me-auto gap-1 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link<?= $activo(['visitas', 'control']) ?>" href="<?= base_url('visitas') ?>">
                        <i class="bi bi-journal-medical"></i> Visitas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= $activo(['paciente']) ?>" href="<?= base_url('paciente') ?>">
                        <i class="bi bi-person-badge"></i> Pacientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= $activo(['tutor']) ?>" href="<?= base_url('tutor') ?>">
                        <i class="bi bi-people"></i> Tutores
                    </a>
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
                    <li class="nav-item">
                        <a class="nav-link<?= $activo(['configuracion']) ?>" href="<?= base_url('configuracion') ?>"
                           title="Configuración" aria-label="Configuración">
                            <i class="bi bi-gear-fill fs-5"></i>
                            <span class="d-lg-none">Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item">
                    <!-- Botón que activa el Modal -->
                    <a href="#" class="nav-link text-black" data-bs-toggle="modal" data-bs-target="#modalCerrarSesion">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>

<main class="container my-4">

<!-- Modal de Confirmación de Cierre de Sesión -->
<div class="modal fade" id="modalCerrarSesion" tabindex="-1" aria-labelledby="modalCerrarSesionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header login-verde-degradado text-white">
                <h5 class="modal-title" id="modalCerrarSesionLabel">Cerrar Sesión</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <div class="modal-body text-center py-4">
                <p class="fs-5 mb-0">¿Deseas salir del sistema?</p>
            </div>
            
            <div class="modal-footer justify-content-center bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger px-4">Sí, cerrar sesión</a>
            </div>
            
        </div>
    </div>
</div>