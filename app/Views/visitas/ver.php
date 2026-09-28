<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalle de la Visita Médica</h2>
        <a href="<?= base_url('visitas') ?>" class="btn btn-secondary">Volver al Listado</a>
    </div>

    <!-- Información General -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h3 class="h5 mb-0">Información de Ingreso y Diagnóstico</h3>
        </div>
        <div class="card-body">
            <p><strong>Fecha de Ingreso:</strong> <?= esc($visita['fecha_ingreso']) ?></p>
            <p><strong>Diagnóstico:</strong> <?= esc($visita['diagnostico']) ?></p>
            <p><strong>Estado de Derivación:</strong> <?= esc($visita['estado_derivacion']) ?></p>
            <p><strong>Observaciones Finales:</strong> <?= esc($visita['observaciones_finales'] ?? 'Ninguna') ?></p>
        </div>
    </div>

    <!-- Historial de Controles Iterativos -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Historial de Controles (Evolución)</h3>
            <!-- Botón que pasa el ID de la visita actual para crear un nuevo control -->
            <a href="<?= base_url('control/crear/' . $visita['id']) ?>" class="btn btn-light btn-sm">+ Nuevo Control</a>
        </div>
        <div class="card-body">
            <?php if (empty($controles)): ?>
                <div class="alert alert-warning mb-0">No se han registrado controles periódicos para esta visita todavía.</div>
            <?php else: ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Score Total</th>
                            <th>Gravedad</th>
                            <th>Medicación</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($controles as $control): ?>
                            <tr>
                                <td><?= esc($control['fecha_hora']) ?></td>
                                <td><span class="badge bg-danger fs-6"><?= esc($control['score_total']) ?> pts</span></td>
                                <td><?= esc($control['estado_gravedad']) ?></td>
                                <td><?= esc($control['medicacion'] ?? '-') ?></td>
                                <td><?= esc($control['observaciones'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>