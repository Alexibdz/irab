<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1"><i class="bi bi-trash"></i> Visitas Abiertas Eliminadas</h2>
            <p class="text-muted mb-0 small">
                Visitas abiertas descartadas. Al recuperarlas, vuelven al listado de visitas abiertas.
            </p>
        </div>

        <a href="<?= base_url('visitas') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Visitas Abiertas
        </a>
    </div>

    <?php if (empty($visitas)): ?>

        <?= view('templates/sin_datos', [
            'mensaje'  => 'No hay visitas abiertas eliminadas.',
            'acciones' => ['Volver a Visitas abiertas' => 'visitas']
        ]) ?>

    <?php else: ?>

        <div class="card shadow-sm">
            <div class="table-responsive card-body">

                <table class="table table-striped table-hover table-bordered align-middle tabla-datos">

                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Usuario</th>
                            <th>Establecimiento</th>
                            <th class="text-center text-nowrap">Fecha de ingreso</th>
                            <th>Diagnóstico</th>
                            <th class="text-center text-nowrap">Fecha de eliminación</th>
                            <th class="text-center text-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($visitas as $visita): ?>
                            <tr>
                                <td><?= esc($visita['paciente'] ?? 'Sin información') ?></td>
                                <td><?= esc($visita['usuario'] ?? 'Sin información') ?></td>
                                <td><?= esc($visita['establecimiento'] ?? 'Sin información') ?></td>
                                <td class="text-center text-nowrap"><?= esc($visita['fecha_ingreso']) ?></td>
                                <td><?= esc($visita['diagnostico'] ?? '-') ?></td>
                                <td class="text-center text-nowrap"><?= esc($visita['fecha_borrado']) ?></td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('visitas/recuperar/' . $visita['id']) ?>"
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('¿Desea recuperar esta visita abierta?');">
                                        <i class="bi bi-arrow-counterclockwise"></i> Recuperar
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