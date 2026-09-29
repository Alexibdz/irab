<?php
// Cerrada = tiene fecha de alta
$cerrada = !empty($visita['fecha_alta']) && $visita['fecha_alta'] !== '0000-00-00';

// Mapa id => nombre de establecimientos
$nombreEstablecimiento = array_column($establecimientos, 'nombre', 'id');

// Edad a la fecha de ingreso, que es la que define la escala
$edad = edad_texto($paciente['fecha_nacimiento'] ?? null, $visita['fecha_ingreso']);
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <h2 class="mb-0">Detalle de la Visita Médica</h2>
            <?php if ($cerrada): ?>
                <span class="badge bg-secondary fs-6">Cerrada</span>
            <?php else: ?>
                <span class="badge bg-success fs-6">Abierta</span>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <?php if ($cerrada): ?>
                <a href="<?= base_url('visitas/reabrir/' . $visita['id']) ?>" class="btn btn-outline-warning"
                   onclick="return confirm('¿Reabrir la visita? Se borran los datos de egreso.');">
                    <i class="bi bi-arrow-counterclockwise"></i> Reabrir
                </a>
            <?php else: ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCerrarVisita">
                    <i class="bi bi-box-arrow-right"></i> Cerrar visita
                </button>
            <?php endif; ?>
            <a href="<?= base_url('visitas') ?>" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>

    <!-- Paciente y tutor -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0"><i class="bi bi-person-badge"></i> Paciente y tutor</h3>
            <?php if ($paciente): ?>
                <a href="<?= base_url('paciente/editar/' . $paciente['id']) ?>" class="btn btn-sm btn-light">
                    <i class="bi bi-pencil-square"></i> Editar paciente
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if (!$paciente): ?>

                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    El paciente de esta visita fue eliminado.
                </div>

            <?php else: ?>

                <div class="row">
                    <div class="col-md-6 border-end">
                        <div class="fw-bold fs-5 mb-2"><?= esc($paciente['nombre']) ?></div>
                        <p class="mb-1"><strong>DNI:</strong> <?= esc($paciente['dni'] ?: 's/d') ?></p>
                        <p class="mb-1">
                            <strong>Nacimiento:</strong> <?= esc($paciente['fecha_nacimiento']) ?>
                            <span class="text-muted">(<?= esc($edad) ?> al ingreso)</span>
                        </p>
                        <p class="mb-1"><strong>Domicilio:</strong> <?= esc($paciente['domicilio'] ?: '-') ?></p>
                        <p class="mb-1"><strong>Barrio:</strong> <?= esc($paciente['barrio'] ?: '-') ?></p>
                        <p class="mb-1">
                            <strong>Establecimiento habitual:</strong>
                            <?= esc($nombreEstablecimiento[$paciente['id_establecimiento_habitual']] ?? '-') ?>
                        </p>
                        <p class="mb-0">
                            <strong>Área programática:</strong>
                            <?= esc($nombreEstablecimiento[$paciente['id_area_programatica']] ?? '-') ?>
                        </p>
                    </div>

                    <div class="col-md-6 mt-3 mt-md-0 ps-md-4">
                        <h4 class="h6 text-muted text-uppercase mb-2">Tutor responsable</h4>
                        <?php if ($tutor): ?>
                            <div class="fw-bold fs-5 mb-2"><?= esc($tutor['nombre']) ?></div>
                            <p class="mb-1"><strong>DNI:</strong> <?= esc($tutor['dni'] ?: 's/d') ?></p>
                            <p class="mb-0">
                                <strong>Teléfono:</strong>
                                <?php if (!empty($tutor['telefono'])): ?>
                                    <a href="tel:<?= esc($tutor['telefono']) ?>"><?= esc($tutor['telefono']) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">sin registrar</span>
                                <?php endif; ?>
                            </p>
                        <?php else: ?>
                            <p class="text-muted mb-0">Sin tutor registrado.</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <!-- Informacion general -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h3 class="h5 mb-0">Información de Ingreso y Diagnóstico</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fecha de Ingreso:</strong> <?= esc($visita['fecha_ingreso']) ?></p>
                    <p class="mb-0"><strong>Diagnóstico:</strong> <?= esc($visita['diagnostico'] ?? '-') ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Establecimiento:</strong> <?= esc($nombreEstablecimiento[$visita['id_establecimiento']] ?? '-') ?></p>
                    <p class="mb-0"><strong>Atendió:</strong> <?= esc($usuario['nombre'] ?? '-') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Datos de egreso -->
    <?php if ($cerrada): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="h5 mb-0">Datos de Egreso</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Fecha de Alta:</strong> <?= esc($visita['fecha_alta']) ?></p>
                        <p><strong>Estado de Derivación:</strong> <?= esc($visita['estado_derivacion'] ?? '-') ?></p>
                        <p class="mb-0"><strong>Medicación al Egreso:</strong> <?= esc($visita['medicacion_egreso'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Turno Protegido:</strong> <?= esc($visita['turno_protegido_fecha'] ?? '-') ?></p>
                        <p class="mb-0"><strong>Observaciones Finales:</strong> <?= esc($visita['observaciones_finales'] ?? '-') ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Historial de controles -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Historial de Controles (Evolución)</h3>
            <!-- Nuevo control -->
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

<!-- Modal: cerrar visita (datos de egreso) -->
<?php if (!$cerrada): ?>
<div class="modal fade" id="modalCerrarVisita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('visitas/cerrar') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id_visita" value="<?= $visita['id'] ?>">

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Cerrar visita — datos de egreso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="fecha_alta" class="form-label">Fecha de alta <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_alta" name="fecha_alta" required>
                            <div class="form-text">Es lo que marca la visita como cerrada.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="estado_derivacion" class="form-label">Estado de derivación</label>
                            <select class="form-select" id="estado_derivacion" name="estado_derivacion">
                                <option value="" selected>Seleccione...</option>
                                <option value="Internacion">Internación</option>
                                <option value="Derivacion">Derivación</option>
                                <option value="Domicilio">Domicilio</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lugar del turno protegido</label>
                            <select class="form-select" name="id_turno_protegido_lugar">
                                <option value="">Opcional...</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= $establecimiento['id'] ?>"><?= esc($establecimiento['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="turno_protegido_fecha" class="form-label">Fecha del turno protegido</label>
                            <input type="date" class="form-control" id="turno_protegido_fecha" name="turno_protegido_fecha">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="medicacion_egreso" class="form-label">Medicación al egreso</label>
                            <input type="text" class="form-control" id="medicacion_egreso" name="medicacion_egreso">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones_finales" class="form-label">Observaciones finales</label>
                            <textarea class="form-control" id="observaciones_finales" name="observaciones_finales" rows="3"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cerrar visita</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>