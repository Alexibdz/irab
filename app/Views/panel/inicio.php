<?php
$hoy = new DateTime('today');
?>
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Hola, <?= esc(session('nombre') ?? 'equipo') ?></h1>
        <p class="text-muted mb-0"><?= esc(ucfirst(IntlDateFormatter::formatObject($hoy, 'EEEE d MMMM y', 'es_AR'))) ?></p>
    </div>

    <a href="<?= base_url('visitas/crear') ?>" class="btn btn-irab btn-lg px-4">
        <i class="bi bi-plus-lg"></i> Nueva visita
    </a>
</div>

<!-- KPIs -->
<div class="row g-3 mb-4">

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100 border-success">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-semibold">Visitas abiertas</div>
                <div class="panel-hero text-success"><?= count($abiertas) ?></div>
                <div class="text-muted small">
                    <?= $controlesHoy ?> control<?= $controlesHoy === 1 ? '' : 'es' ?> registrado<?= $controlesHoy === 1 ? '' : 's' ?> hoy
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-2">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-semibold">Cerradas</div>
                <div class="panel-dato"><?= $cerradas ?></div>
                <a href="<?= base_url('visitas/historial') ?>" class="small text-decoration-none">Ver historial</a>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-2">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-semibold">Pacientes</div>
                <div class="panel-dato"><?= $pacientes ?></div>
                <a href="<?= base_url('paciente') ?>" class="small text-decoration-none">Ver listado</a>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-2">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-semibold">Tutores</div>
                <div class="panel-dato"><?= $tutores ?></div>
                <a href="<?= base_url('tutor') ?>" class="small text-decoration-none">Ver listado</a>
            </div>
        </div>
    </div>

</div>

<!-- Cola de trabajo -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Visitas abiertas</h2>
        <a href="<?= base_url('visitas') ?>" class="btn btn-sm btn-outline-secondary">Ver todas</a>
    </div>

    <?php if (empty($abiertas)): ?>

        <div class="card-body text-center py-5">
            <i class="bi bi-clipboard2-check fs-1 text-muted"></i>
            <p class="text-muted mt-2 mb-3">No hay visitas abiertas.</p>
            <a href="<?= base_url('visitas/crear') ?>" class="btn btn-irab">
                <i class="bi bi-plus-lg"></i> Nueva visita
            </a>
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Paciente</th>
                        <th>Establecimiento</th>
                        <th>Diagnóstico</th>
                        <th class="text-end">Días</th>
                        <th>Último control</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($abiertas as $visita): ?>
                        <?php
                        $dias = (new DateTime($visita['fecha_ingreso']))->diff(new DateTime())->days;
                        $control = $visita['ultimo_control'];

                        // Sin control en mas de 24hs: la visita esta sin seguimiento
                        $horas = $control
                            ? (int) ((time() - strtotime($control['fecha_hora'])) / 3600)
                            : (int) ((time() - strtotime($visita['fecha_ingreso'])) / 3600);
                        $atrasada = $horas >= 24;
                        ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?= esc($visita['paciente'] ?? 's/d') ?></div>
                                <div class="small text-muted"><?= esc(edad_texto($visita['fecha_nacimiento'] ?? null, $visita['fecha_ingreso'])) ?></div>
                            </td>
                            <td class="small"><?= esc($visita['establecimiento'] ?? '-') ?></td>
                            <td class="small"><?= esc($visita['diagnostico'] ?? '-') ?></td>
                            <td class="text-end panel-num"><?= $dias ?></td>

                            <td>
                                <?php if ($control): ?>
                                    <span class="small"><?= esc($control['fecha_hora']) ?></span>
                                    <?php if ($control['score_total'] !== null): ?>
                                        <span class="badge text-bg-light border ms-1"><?= esc($control['score_total']) ?> pts</span>
                                    <?php endif; ?>
                                    <?php if (!empty($control['estado_gravedad'])): ?>
                                        <?php
                                        $gravedad = [
                                            'Leve'     => ['text-bg-success', 'bi-check-circle'],
                                            'Moderada' => ['text-bg-warning', 'bi-exclamation-triangle'],
                                            'Grave'    => ['text-bg-danger',  'bi-exclamation-octagon'],
                                        ][$control['estado_gravedad']] ?? ['text-bg-secondary', 'bi-dash-circle'];
                                        ?>
                                        <span class="badge <?= $gravedad[0] ?> ms-1">
                                            <i class="bi <?= $gravedad[1] ?>"></i> <?= esc($control['estado_gravedad']) ?>
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted small">Sin controles</span>
                                <?php endif; ?>

                                <?php if ($atrasada): ?>
                                    <div class="small text-danger mt-1">
                                        <i class="bi bi-clock-history"></i> <?= $horas ?> h sin control
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="<?= base_url('control/crear/' . $visita['id']) ?>"
                                   class="btn btn-sm btn-outline-success" title="Nuevo control">
                                    <i class="bi bi-heart-pulse"></i>
                                </a>
                                <a href="<?= base_url('visitas/ver/' . $visita['id']) ?>"
                                   class="btn btn-sm btn-outline-secondary" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>
