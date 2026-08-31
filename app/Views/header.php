<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'Enfermeria IRAB' ?></title>
</head>
<body>
<p>
    <a href="<?= base_url('panel') ?>">Inicio</a>
    <a href="<?= base_url('roles') ?>">Roles</a>
    <a href="<?= base_url('usuarios') ?>">Usuarios</a>
    <a href="<?= base_url('establecimientos') ?>">Establecimientos</a>
    <a href="<?= base_url('rol/index.php') ?>">...</a>
    <a href="<?= base_url('rol/index.php') ?>">....</a>
</p>
