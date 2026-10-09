<?php
// Edad del paciente.
$edad = edad_texto($paciente['fecha_nacimiento']);

$meses_edad = null;
$edad_numero = null;

if (!empty($paciente['fecha_nacimiento'])) {
    $fechaNac = new DateTime($paciente['fecha_nacimiento']);
    $hoy = new DateTime('today');
    $meses_edad = ($fechaNac->diff($hoy)->y * 12) + $fechaNac->diff($hoy)->m;
    $edad_numero = $meses_edad;
}
?>
<div class="container-fluid px-4 mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <h2 class="h3 mb-0 text-primary"><i class="bi bi-journal-medical"></i> Registrar Nueva Visita</h2>
            <span class="badge bg-secondary">Paso 2 de 2</span>
        </div>
        <a href="<?= base_url('visitas') ?>" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <form action="<?= base_url('visitas/insertar') ?>" method="POST">
        <?= csrf_field() ?>
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger mb-4 shadow-sm">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

        <div class="row">    
            <!-- Datos DE LA visita -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Información del Ingreso</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <!-- Paciente -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-success">Paciente</label>

                                <div class="border border-success rounded p-3 bg-light d-flex justify-content-between align-items-start"
                                     id="paciente_fijo" data-nacimiento="<?= esc($paciente['fecha_nacimiento']) ?>">
                                    <div>
                                        <div class="fw-bold fs-5"><?= esc($paciente['nombre']) ?></div>
                                        <div class="small text-muted">
                                            DNI <?= esc($paciente['dni'] ?: 's/d') ?> · <?= esc($edad) ?>
                                            <?php if ($tutor): ?>
                                                <br>Tutor: <?= esc($tutor['nombre']) ?>
                                                <?php if (!empty($tutor['telefono'])): ?>
                                                    · Tel. <?= esc($tutor['telefono']) ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('visitas/crear') ?>" class="btn btn-sm btn-outline-secondary text-nowrap">
                                        <i class="bi bi-arrow-left"></i> Cambiar
                                    </a>
                                </div>

                                <input type="hidden" name="id_paciente" value="<?= $paciente['id'] ?>">
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usuario (Enfermera/Médico)</label>
                                <select class="form-select" id="id_usuario" name="id_usuario" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <option value="<?= $usuario['id'] ?>" data-establecimiento="<?= esc($usuario['id_establecimiento_asignado'] ?? '') ?>">
                                            <?= esc($usuario['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Establecimiento -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Establecimiento</label>
                                <select class="form-select" id="id_establecimiento" name="id_establecimiento" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <?php foreach ($establecimientos as $establecimiento): ?>
                                        <option value="<?= $establecimiento['id'] ?>">
                                            <?= esc($establecimiento['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Fecha de ingreso -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha y Hora de ingreso</label>
                                <input type="datetime-local" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>

                            <!-- Diagnostico -->
                            <div class="col-md-6 mb-3">
                                <label for="diagnostico" class="form-label text-success fw-bold">Diagnóstico Inicial</label>
                                
                                <!-- Input del diagnostico -->
                                <input type="text" class="form-control border-success" id="diagnostico" name="diagnostico" list="lista_diagnosticos" placeholder="Seleccione o escriba..." required>
                                
                                <!-- Opciones -->
                                <datalist id="lista_diagnosticos">
                                    <option value="SBO">
                                    <option value="BQL">
                                    <option value="NMN">
                                </datalist>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Factores Y control -->
            <div class="col-lg-6 mb-4">
                
                <!-- Factores de riesgo y proteccion -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Factores de Riesgo y Protección</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <!-- Riesgos -->
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border border-danger rounded bg-white h-100">
                                    <h6 class="text-danger border-bottom pb-2 mb-3">
                                        <i class="bi bi-exclamation-triangle"></i> Riesgos
                                    </h6>
                                    <?php if (!empty($factores)): ?>
                                        <?php foreach ($factores as $factor): ?>
                                            <?php if (strtolower($factor['tipo']) === 'riesgo'): ?>
                                                
                                                <div class="mb-2 div-factor tipo-<?= $factor['tipo_formulario'] ?>" style="display: none;">
                                                    <?php if ($factor['id'] == 8): ?>
                                                        <label class="form-label mb-1 small" for="factor_<?= $factor['id'] ?>">
                                                            <?= esc($factor['denominacion']) ?>
                                                        </label>
                                                        <select class="form-select form-select-sm border-danger" name="factores[<?= $factor['id'] ?>]" id="factor_<?= $factor['id'] ?>">
                                                            <option value="" disabled selected>Gravedad...</option>
                                                            <option value="Leve">Leve (L)</option>
                                                            <option value="Moderado">Moderado (M)</option>
                                                            <option value="Grave">Grave (G)</option>
                                                        </select>
                                                    <?php else: ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input border-danger" type="checkbox" name="factores[<?= $factor['id'] ?>]" value="Sí" id="factor_<?= $factor['id'] ?>">
                                                            <label class="form-check-label small" for="factor_<?= $factor['id'] ?>">
                                                                <?= esc($factor['denominacion']) ?>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Proteccion -->
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border border-success rounded bg-white h-100">
                                    <h6 class="text-success border-bottom pb-2 mb-3">
                                        <i class="bi bi-shield-check"></i> Protección
                                    </h6>
                                    <?php if (!empty($factores)): ?>
                                        <?php foreach ($factores as $factor): ?>
                                            <?php if (strtolower($factor['tipo']) === 'protección' || strtolower($factor['tipo']) === 'proteccion'): ?>
                                                <div class="form-check mb-2 div-factor tipo-<?= $factor['tipo_formulario'] ?>" style="display: none;">
                                                    <input class="form-check-input border-success" type="checkbox" name="factores[<?= $factor['id'] ?>]" value="Sí" id="factor_<?= $factor['id'] ?>">
                                                    <label class="form-check-label small" for="factor_<?= $factor['id'] ?>">
                                                        <?= esc($factor['denominacion']) ?>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-secondary mt-2 mb-0 py-2 text-center">
                            <small>Se muestran solo los factores que corresponden a <?= esc($edad) ?>.</small>
                        </div>
                    </div>
                </div>

                <!-- Control clinico de ingreso -->
                <div class="card shadow-sm border-success" id="seccion_control_inicial" style="display: none;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Control Clínico Inicial</h5>
                    </div>
                    <div class="card-body">

                        <div id="contenedor_sintomas_dinamicos" class="row">

                            <?php if ($edad_numero !== null && $edad_numero < 24): ?>

                                <div class="col-md-4 mb-3 sintoma-tal">
                                    <label class="form-label fw-bold small text-success">Frec. Cardíaca</label>
                                    <input type="number"
                                           class="form-control input-score border-success"
                                           name="sintomas[1]"
                                           min="0"
                                           data-rangos='[
                                               {"min":0,"max":120,"puntos":0},
                                               {"min":121,"max":140,"puntos":1},
                                               {"min":141,"max":160,"puntos":2},
                                               {"min":161,"max":999,"puntos":3}
                                           ]'
                                           onchange="calcularScoreDinamico()"
                                           required>
                                </div>

                                <?php if ($meses_edad <= 6): ?>
                                    <div class="col-md-4 mb-3 sintoma-tal" id="div_fr_menor">
                                        <label class="form-label fw-bold small text-success">F.R. (<= 6m)</label>
                                        <input type="number"
                                               class="form-control input-score border-success"
                                               name="sintomas[2]"
                                               min="0"
                                               data-rangos='[
                                                   {"min":0,"max":40,"puntos":0},
                                                   {"min":41,"max":55,"puntos":1},
                                                   {"min":56,"max":70,"puntos":2},
                                                   {"min":71,"max":999,"puntos":3}
                                               ]'
                                               onchange="calcularScoreDinamico()"
                                               required>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-4 mb-3 sintoma-tal" id="div_fr_mayor">
                                        <label class="form-label fw-bold small text-success">F.R. (> 6m)</label>
                                        <input type="number"
                                               class="form-control input-score border-success"
                                               name="sintomas[3]"
                                               min="0"
                                               data-rangos='[
                                                   {"min":0,"max":30,"puntos":0},
                                                   {"min":31,"max":45,"puntos":1},
                                                   {"min":46,"max":60,"puntos":2},
                                                   {"min":61,"max":999,"puntos":3}
                                               ]'
                                               onchange="calcularScoreDinamico()"
                                               required>
                                    </div>
                                <?php endif; ?>

                                <div class="col-md-4 mb-3 sintoma-tal">
                                    <label class="form-label fw-bold small text-success">Sibilancias</label>
                                    <select class="form-select select-sintoma border-success" name="sintomas[4]" onchange="calcularScoreDinamico()" required>
                                        <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                        <option value="No" data-puntos="0">No (0 pts)</option>
                                        <option value="Fin espiración con estetoscopio" data-puntos="1">Fin espir. (1 pt)</option>
                                        <option value="Inspiración y espiración con estetoscopio" data-puntos="2">Insp/Esp. (2 pts)</option>
                                        <option value="Audible sin estetoscopio" data-puntos="3">Audibles (3 pts)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-tal">
                                    <label class="form-label fw-bold small text-success">Retracción</label>
                                    <select class="form-select select-sintoma border-success" name="sintomas[5]" onchange="calcularScoreDinamico()" required>
                                        <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                        <option value="No" data-puntos="0">No (0 pts)</option>
                                        <option value="Subcostal" data-puntos="1">Subcostal (1 pt)</option>
                                        <option value="Subcostal e intercostal" data-puntos="2">Sub/Inter. (2 pts)</option>
                                        <option value="Generalizado" data-puntos="3">Generalizado (3 pts)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-tal">
                                    <label class="form-label fw-bold small text-success">Saturación de oxígeno</label>
                                    <input type="number" class="form-control border-success" name="sintomas[6]" min="0" max="100" step="0.1" placeholder="%">
                                </div>

                                <div class="col-md-4 mb-3 sintoma-tal">
                                    <label class="form-label fw-bold small text-success">Temperatura</label>
                                    <input type="number" class="form-control border-success" name="sintomas[7]" step="0.1" placeholder="°C">
                                </div>

                            <?php else: ?>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Frecuencia Cardíaca</label>
                                    <input type="number"
                                           class="form-control input-score border-success"
                                           name="sintomas[8]"
                                           min="0"
                                           data-rangos='[
                                               {"min":0,"max":120,"puntos":0},
                                               {"min":121,"max":999,"puntos":1}
                                           ]'
                                           onchange="calcularScoreDinamico()"
                                           required>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Frecuencia Respiratoria</label>
                                    <input type="number"
                                           class="form-control input-score border-success"
                                           name="sintomas[9]"
                                           min="0"
                                           data-rangos='[
                                               {"min":0,"max":30,"puntos":0},
                                               {"min":31,"max":45,"puntos":1},
                                               {"min":46,"max":60,"puntos":2},
                                               {"min":61,"max":999,"puntos":3}
                                           ]'
                                           onchange="calcularScoreDinamico()"
                                           required>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Sibilancias</label>
                                    <select class="form-select select-sintoma border-success" name="sintomas[10]" onchange="calcularScoreDinamico()" required>
                                        <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                        <option value="No" data-puntos="0">No (0 pts)</option>
                                        <option value="Final de la espiración" data-puntos="1">Final espiración (1 pt)</option>
                                        <option value="Todo la espiración" data-puntos="2">Todo espiración (2 pts)</option>
                                        <option value="+ Inspiración" data-puntos="3">+ Inspiración (3 pts)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Tiraje</label>
                                    <select class="form-select select-sintoma border-success" name="sintomas[11]" onchange="calcularScoreDinamico()" required>
                                        <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                        <option value="No" data-puntos="0">No (0 pts)</option>
                                        <option value="Subcostal o Intercostal" data-puntos="1">Subcostal / Intercostal (1 pt)</option>
                                        <option value="+ supraclavicular + aleteo nasal" data-puntos="2">+ Supraclavicular (2 pts)</option>
                                        <option value="+ Todo lo anterior + supraesternal" data-puntos="3">+ Supraesternal (3 pts)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Ventilación</label>
                                    <select class="form-select select-sintoma border-success" name="sintomas[12]" onchange="calcularScoreDinamico()" required>
                                        <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                        <option value="Buena y Simétrica" data-puntos="0">Buena, Simétrica (0 pts)</option>
                                        <option value="Regular y Simétrica" data-puntos="1">Regular. Simétrica (1 pt)</option>
                                        <option value="Muy disminuida" data-puntos="2">Muy disminuida (2 pts)</option>
                                        <option value="Tórax silente" data-puntos="3">Tórax silente (3 pts)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Cianosis</label>
                                    <select class="form-select select-sintoma border-success" name="sintomas[13]" onchange="calcularScoreDinamico()" required>
                                        <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                        <option value="No" data-puntos="0">No (0 pts)</option>
                                        <option value="Sí" data-puntos="1">Sí (1 pt)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Saturación de oxígeno</label>
                                    <input type="number" class="form-control border-success" name="sintomas[14]" min="0" max="100" step="0.1" placeholder="%">
                                </div>

                                <div class="col-md-4 mb-3 sintoma-wdf">
                                    <label class="form-label fw-bold small text-success">Temperatura</label>
                                    <input type="number" class="form-control border-success" name="sintomas[15]" step="0.1" placeholder="°C">
                                </div>

                            <?php endif; ?>
                        </div>

                        <div class="alert alert-success text-center mt-3 mb-0 border-success">
                            <h5 class="mb-0 text-success">Score Total en Vivo: <span id="score_display" class="fw-bold fs-2 text-success">0</span></h5>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Botones finales -->
        <div class="row">
            <div class="col-12 text-end">
                <hr>
                <button type="button" class="btn btn-secondary btn-lg me-2" onclick="window.location.href='<?= base_url('visitas') ?>'">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-lg px-5">Guardar Visita Completa</button>
            </div>
        </div>

    </form>
</div>

