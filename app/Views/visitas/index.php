<?php
// Mapas id => nombre
$nombrePaciente        = array_column($pacientes, 'nombre', 'id');
$nombreUsuario         = array_column($usuarios, 'nombre', 'id');
$nombreEstablecimiento = array_column($establecimientos, 'nombre', 'id');
?>
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1"><i class="bi bi-journal-medical"></i> Visitas abiertas</h2>
            <p class="text-muted mb-0 small">Visitas en curso, todavía sin fecha de alta.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('visitas/historial') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-clock-history"></i> Historial
                <span class="badge bg-secondary ms-1"><?= $cerradas ?></span>
            </a>
            <a href="<?= base_url('visitas/eliminados') ?>" class="btn btn-outline-danger">
                <i class="bi bi-trash"></i> Eliminadas
            </a>
        </div>
    </div>

    <?php if (empty($visitas)): ?>

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            No hay visitas abiertas.
            <a href="<?= base_url('visitas/crear') ?>" class="alert-link">Registrar una nueva visita</a>
            o revisar el <a href="<?= base_url('visitas/historial') ?>" class="alert-link">historial</a>.
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
                            <th>Fecha de ingreso</th>
                            <th>Diagnóstico</th>
                            <th>Usuario</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($visitas as $visita): ?>
                            <tr>
                                <td><?= esc($nombrePaciente[$visita['id_paciente']] ?? '-') ?></td>
                                <td><?= esc($nombreEstablecimiento[$visita['id_establecimiento']] ?? '-') ?></td>
                                <td><?= esc($visita['fecha_ingreso']) ?></td>
                                <td><?= esc($visita['diagnostico'] ?? '-') ?></td>
                                <td><?= esc($nombreUsuario[$visita['id_usuario']] ?? '-') ?></td>

                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('visitas/ver/' . $visita['id']) ?>"
                                       class="btn btn-info btn-sm text-white"
                                       title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="<?= base_url('visitas/editar/' . $visita['id']) ?>"
                                       class="btn btn-warning btn-sm text-dark"
                                       title="Editar visita">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('visitas/borrar/' . $visita['id']) ?>"
                                       class="btn btn-danger btn-sm"
                                       title="Borrar visita"
                                       onclick="return confirm('¿Seguro que deseas eliminar esta visita?');">
                                        <i class="bi bi-trash"></i>
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
