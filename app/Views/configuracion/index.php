<?php
// Accesos del hub, agrupados por para que sirven
$grupos = [
    'Parámetros clínicos' => [
        ['url' => 'configuracion/factores', 'icono' => 'bi-exclamation-triangle', 'titulo' => 'Factores de riesgo',
         'texto' => 'Factores de riesgo y protección que se evalúan en la visita.'],
        ['url' => 'configuracion/sintomas', 'icono' => 'bi-thermometer-half', 'titulo' => 'Síntomas',
         'texto' => 'Síntomas de cada escala y los puntos de cada valor.'],
    ],
    'Administración' => [
        ['url' => 'configuracion/usuarios', 'icono' => 'bi-person-gear', 'titulo' => 'Usuarios',
         'texto' => 'Cuentas que acceden al sistema y su rol.'],
        ['url' => 'configuracion/establecimientos', 'icono' => 'bi-hospital', 'titulo' => 'Establecimientos',
         'texto' => 'Centros de salud y áreas programáticas.'],
        ['url' => 'configuracion/copia-seguridad/exportar', 'icono' => 'bi-database-down', 'titulo' => 'Copia de seguridad',
         'texto' => 'Descarga la base de datos completa en un archivo .sql.'],
    ],
];
?>
<div class="mb-4">
    <h2 class="h3 mb-1"><i class="bi bi-gear"></i> Configuración</h2>
    <p class="text-muted mb-0">Parámetros del sistema y administración.</p>
</div>

<?php foreach ($grupos as $grupo => $accesos): ?>
    <h3 class="h6 text-uppercase text-muted fw-semibold mb-3"><?= esc($grupo) ?></h3>

    <div class="row g-3 mb-4">
        <?php foreach ($accesos as $acceso): ?>
            <div class="col-12 col-md-6 col-xl-4">
                <a href="<?= base_url($acceso['url']) ?>" class="card shadow-sm h-100 text-decoration-none text-reset acceso-config">
                    <div class="card-body d-flex align-items-start gap-3">
                        <i class="bi <?= $acceso['icono'] ?> fs-2 text-success"></i>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <span class="fw-semibold fs-5"><?= esc($acceso['titulo']) ?></span>
                            </div>
                            <p class="text-muted small mb-0 mt-1"><?= esc($acceso['texto']) ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

