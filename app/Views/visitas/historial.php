<?php
// Mapas id => nombre
$nombrePaciente        = array_column($pacientes, 'nombre', 'id');
$nombreUsuario         = array_column($usuarios, 'nombre', 'id');
$nombreEstablecimiento = array_column($establecimientos, 'nombre', 'id');
?>
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1"><i class="bi bi-clock-history"></i> Historial de visitas</h2>
            <p class="text-muted mb-0 small">Visitas cerradas, con sus datos de egreso.</p>
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

    <?php if (empty($visitas)): ?>

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Todavía no hay visitas cerradas. Una visita entra al historial cuando se le
            carga la fecha de alta desde <strong>Cerrar visita</strong>, en el detalle.
        </div>

    <?php else: ?>

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- DataTables desde el footer -->
                <table class="table table-striped table-hover table-bordered align-middle tabla-datos">

                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Establecimiento</th>
                            <th>Ingreso</th>
                            <th>Alta</th>
                            <th>Días</th>
                            <th>Diagnóstico</th>
                            <th>Derivación</th>
                            <th>Turno protegido</th>
                            <th>Medicación al egreso</th>
                            <th>Usuario</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($visitas as $visita): ?>
                            <?php
                            // Duracion en dias
                            $dias = '-';
                            if (!empty($visita['fecha_ingreso'])) {
                                $ingreso = new DateTime($visita['fecha_ingreso']);
                                $alta    = new DateTime($visita['fecha_alta']);
                                $dias    = $ingreso->diff($alta)->days;
                            }
                            ?>
                            <tr>
                                <td><?= esc($nombrePaciente[$visita['id_paciente']] ?? '-') ?></td>
                                <td><?= esc($nombreEstablecimiento[$visita['id_establecimiento']] ?? '-') ?></td>
                                <td><?= esc($visita['fecha_ingreso']) ?></td>
                                <td><?= esc($visita['fecha_alta']) ?></td>
                                <td><?= esc($dias) ?></td>
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

                                    <a href="<?= base_url('visitas/reabrir/' . $visita['id']) ?>"
                                       class="btn btn-outline-warning btn-sm"
                                       title="Reabrir visita"
                                       onclick="return confirm('¿Reabrir la visita? Se borran los datos de egreso.');">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>

    <?php endif; ?>

</div>
