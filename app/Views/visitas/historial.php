<?php
// Mapas id => nombre
$nombrePaciente        = array_column(array_map(static fn ($persona) => ['id' => $persona['id'], 'nombre' => nombre_completo($persona)], $pacientes), 'nombre', 'id');
$nombreUsuario         = array_column(array_map(static fn ($persona) => ['id' => $persona['id'], 'nombre' => nombre_completo($persona)], $usuarios), 'nombre', 'id');
$nombreEstablecimiento = array_column($establecimientos, 'nombre', 'id');

$esAltas = $tipo === 'altas';
$esTodas = $tipo === 'todas';

$descripciones = [
    'todas'    => 'Todas las visitas que ya salieron de abiertas: en curso y con alta definitiva.',
    'cerradas' => 'Visitas con cierre temporal: se pueden reabrir para seguir controlando.',
    'altas'    => 'Casos con alta médica definitiva: quedan cerrados y no se pueden reabrir.',
];

$tituloFecha = ['todas' => 'Cierre / alta', 'cerradas' => 'Cierre de visita', 'altas' => 'Alta definitiva'];
?>
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1"><i class="bi bi-clock-history"></i> Historial de visitas</h2>
            <p class="text-muted mb-0 small">
                <?= esc($descripciones[$tipo]) ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('visitas') ?>" class="btn btn-outline-success">
                <i class="bi bi-journal-medical"></i> Visitas abiertas
                <span class="badge bg-success ms-1"><?= $abiertas ?></span>
            </a>
            <a href="<?= base_url('visitas/eliminados') ?>" class="btn btn-outline-danger">
                <i class="bi bi-trash"></i> Eliminadas
            </a>
        </div>
    </div>

    <!-- Pestañas: todas / en curso / altas definitivas -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link <?= $esTodas ? 'active' : '' ?>" href="<?= base_url('visitas/historial') ?>">
                <i class="bi bi-list-ul"></i> Todas
                <span class="badge bg-dark ms-1"><?= $totalCerradas + $totalAltas ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $tipo === 'cerradas' ? 'active' : '' ?>" href="<?= base_url('visitas/historial?tipo=cerradas') ?>">
                <i class="bi bi-box-arrow-right"></i> En curso
                <span class="badge bg-secondary ms-1"><?= $totalCerradas ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $esAltas ? 'active' : '' ?>" href="<?= base_url('visitas/historial?tipo=altas') ?>">
                <i class="bi bi-check-all"></i> Altas definitivas
                <span class="badge bg-primary ms-1"><?= $totalAltas ?></span>
            </a>
        </li>
    </ul>

    <?php if (empty($visitas)): ?>

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <?php if ($esTodas): ?>
                Todavía no hay visitas en el historial. Una visita entra acá cuando se la cierra
                o se le da el <strong>Alta Definitiva</strong>, desde el detalle.
            <?php elseif ($esAltas): ?>
                Todavía no hay altas definitivas. Se otorgan con el botón <strong>Alta Definitiva</strong>, en el detalle de la visita.
            <?php else: ?>
                No hay visitas en curso. Una visita entra acá cuando se le
                carga la fecha de cierre desde <strong>Cerrar visita</strong>, en el detalle.
            <?php endif; ?>
        </div>

    <?php else: ?>

        <div class="card shadow-sm">
            <div class="table-responsive card-body">

                <!-- DataTables desde el footer -->
                <table class="table table-striped table-hover table-bordered align-middle tabla-datos">

                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <?php if ($esTodas): ?>
                                <th class="text-center">Estado</th>
                            <?php endif; ?>
                            <th>Establecimiento</th>
                            <th class="text-center text-nowrap">Ingreso</th>
                            <th class="text-center text-nowrap"><?= esc($tituloFecha[$tipo]) ?></th>
                            <th>Diagnóstico</th>
                            <th>Derivación</th>
                            <th>Turno protegido</th>
                            <th>Medicación al egreso</th>
                            <th>Usuario</th>
                            <th class="text-center text-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($visitas as $visita): ?>
                            <?php $conAlta = !empty($visita['fecha_alta_definitiva']); ?>
                            <tr>
                                <td><?= esc($nombrePaciente[$visita['id_paciente']] ?? '-') ?></td>
                                <?php if ($esTodas): ?>
                                    <td class="text-center">
                                        <?php if ($conAlta): ?>
                                            <span class="badge bg-primary">Alta definitiva</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">En curso</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <td><?= esc($nombreEstablecimiento[$visita['id_establecimiento']] ?? '-') ?></td>
                                <td class="text-center text-nowrap"><?= esc($visita['fecha_ingreso']) ?></td>
                                <td class="text-center text-nowrap"><?= esc($conAlta ? date('d/m/Y H:i', strtotime($visita['fecha_alta_definitiva'])) : $visita['fecha_alta']) ?></td>
                                <td><?= esc($visita['diagnostico'] ?? '-') ?></td>

                                <td>
                                    <?php if (!empty($visita['estado_derivacion'])): ?>
                                        <?= esc($visita['estado_derivacion']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($visita['turno_protegido_fecha'])): ?>
                                        <?= esc($visita['turno_protegido_fecha']) ?>
                                        <?php if (!empty($visita['id_turno_protegido_lugar'])): ?>
                                            <div class="small text-muted">
                                                <?= esc($nombreEstablecimiento[$visita['id_turno_protegido_lugar']] ?? '') ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= esc($visita['medicacion_egreso'] ?? '-') ?></td>
                                <td><?= esc($nombreUsuario[$visita['id_usuario']] ?? '-') ?></td>

                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('visitas/ver/' . $visita['id']) ?>"
                                       class="btn btn-info btn-sm text-white"
                                       title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if (!$conAlta): ?>
                                        <a href="<?= base_url('visitas/reabrir/' . $visita['id']) ?>"
                                           class="btn btn-outline-warning btn-sm"
                                           title="Reabrir visita"
                                           onclick="return confirm('¿Reabrir la visita? Se borran cierre temporal y egreso para permitir nuevos controles.');">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>

    <?php endif; ?>

</div>
