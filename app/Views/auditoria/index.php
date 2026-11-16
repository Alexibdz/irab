<?php
// Color del badge segun la accion registrada
$colores = [
    'ALTA'            => 'success',
    'MODIFICACION'    => 'warning',
    'BAJA'            => 'danger',
    'RECUPERACION'    => 'info',
    'CIERRE'          => 'secondary',
    'ALTA_DEFINITIVA' => 'primary',
    'REAPERTURA'      => 'dark',
];
?>
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-1"><i class="bi bi-journal-text"></i> Auditoría</h2>
        <p class="text-muted mb-0">Movimientos registrados sobre visitas y controles.</p>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle tabla-datos sin-acciones w-100" data-order='[[0, "desc"]]'>
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Registro</th>
                            <th>Acción</th>
                            <th>Paciente</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $r): ?>
                            <?php
                            $registro = ($r['tabla_auditada'] === 'controles' ? 'Control' : 'Visita') . ' #' . $r['id_registro'];
                            ?>
                            <tr>
                                <td data-order="<?= esc($r['fecha']) ?>"><?= esc(date('H:i d/m/Y', strtotime($r['fecha']))) ?></td>
                                <td><?= esc($r['usuario'] ?? '—') ?></td>
                                <td><?= esc($registro) ?></td>
                                <td>
                                    <span class="badge text-bg-<?= $colores[$r['accion']] ?? 'secondary' ?>">
                                        <?= esc(str_replace('_', ' ', $r['accion'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= esc($r['paciente'] ?? '—') ?>
                                    <?php if (! empty($r['dni'])): ?>
                                        <div class="small text-muted">DNI <?= esc($r['dni']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="small"><?= esc($r['detalle']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
