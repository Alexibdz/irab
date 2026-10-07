<div class="container mt-4">
    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <h3 class="h5 mb-0">Registrar Nuevo Control Clínico</h3>
        </div>

        <div class="card-body">

            <form action="<?= base_url('control/guardar') ?>" method="POST">
                <?= csrf_field() ?>

                <input type="hidden" name="id_visita" value="<?= $visita['id'] ?? '' ?>">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger mb-4 shadow-sm">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                <div class="row mb-4">

                    <?php if ($tipo_planilla === 'TAL'): ?>

                        <!-- ========================= -->
                        <!-- ESCALA TAL -->
                        <!-- ========================= -->

                        <!-- Frecuencia Cardíaca -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Frec. Cardíaca
                            </label>

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

                            <!-- Frecuencia Respiratoria <= 6 meses -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-success">
                                    F.R. (<= 6m)
                                </label>

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

                            <!-- Frecuencia Respiratoria > 6 meses -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-success">
                                    F.R. (> 6m)
                                </label>

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


                        <!-- Sibilancias -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Sibilancias
                            </label>

                            <select class="form-select select-sintoma border-success"
                                    name="sintomas[4]"
                                    onchange="calcularScoreDinamico()"
                                    required>

                                <option value="" data-puntos="0" selected disabled>
                                    Seleccione...
                                </option>

                                <option value="No" data-puntos="0">
                                    No (0 pts)
                                </option>

                                <option value="Fin espiración con estetoscopio" data-puntos="1">
                                    Fin espir. (1 pt)
                                </option>

                                <option value="Inspiración y espiración con estetoscopio" data-puntos="2">
                                    Insp/Esp. (2 pts)
                                </option>

                                <option value="Audible sin estetoscopio" data-puntos="3">
                                    Audibles (3 pts)
                                </option>

                            </select>
                        </div>


                        <!-- Retracción -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Retracción
                            </label>

                            <select class="form-select select-sintoma border-success"
                                    name="sintomas[5]"
                                    onchange="calcularScoreDinamico()"
                                    required>

                                <option value="" data-puntos="0" selected disabled>
                                    Seleccione...
                                </option>

                                <option value="No" data-puntos="0">
                                    No (0 pts)
                                </option>

                                <option value="Subcostal" data-puntos="1">
                                    Subcostal (1 pt)
                                </option>

                                <option value="Subcostal e intercostal" data-puntos="2">
                                    Sub/Inter. (2 pts)
                                </option>

                                <option value="Generalizado" data-puntos="3">
                                    Generalizado (3 pts)
                                </option>

                            </select>
                        </div>


                        <!-- Saturación -->
                        <!-- NO SUMA AL SCORE -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Saturación de oxígeno
                            </label>

                            <input type="number"
                                   class="form-control border-success"
                                   name="saturacion_oxigeno"
                                   min="0"
                                   max="100"
                                   step="0.1"
                                   placeholder="%">
                        </div>


                        <!-- Temperatura -->
                        <!-- NO SUMA AL SCORE -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Temperatura
                            </label>

                            <input type="number"
                                   class="form-control border-success"
                                   name="temperatura"
                                   step="0.1"
                                   placeholder="°C">
                        </div>


                    <?php else: ?>

                        <!-- ========================= -->
                        <!-- ESCALA WDF -->
                        <!-- ========================= -->

                        <!-- Frecuencia Cardíaca -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Frecuencia Cardíaca
                            </label>

                            <input type="number"
                                   class="form-control input-score border-success"
                                   name="sintomas[6]"
                                   min="0"
                                   data-rangos='[
                                       {"min":0,"max":120,"puntos":0},
                                       {"min":121,"max":999,"puntos":1}
                                   ]'
                                   onchange="calcularScoreDinamico()"
                                   required>
                        </div>


                        <!-- Frecuencia Respiratoria -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Frecuencia Respiratoria
                            </label>

                            <input type="number"
                                   class="form-control input-score border-success"
                                   name="sintomas[7]"
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


                        <!-- Sibilancias -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Sibilancias
                            </label>

                            <select class="form-select select-sintoma border-success"
                                    name="sintomas[8]"
                                    onchange="calcularScoreDinamico()"
                                    required>

                                <option value="" data-puntos="0" selected disabled>
                                    Seleccione...
                                </option>

                                <option value="No" data-puntos="0">
                                    No (0 pts)
                                </option>

                                <option value="Final espiración" data-puntos="1">
                                    Final espiración (1 pt)
                                </option>

                                <option value="Todo espiración" data-puntos="2">
                                    Todo espiración (2 pts)
                                </option>

                                <option value="+ Inspiración" data-puntos="3">
                                    + Inspiración (3 pts)
                                </option>

                            </select>
                        </div>


                        <!-- Tiraje -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Tiraje
                            </label>

                            <select class="form-select select-sintoma border-success"
                                    name="sintomas[9]"
                                    onchange="calcularScoreDinamico()"
                                    required>

                                <option value="" data-puntos="0" selected disabled>
                                    Seleccione...
                                </option>

                                <option value="No" data-puntos="0">
                                    No (0 pts)
                                </option>

                                <option value="Subcostal / Intercostal" data-puntos="1">
                                    Subcostal / Intercostal (1 pt)
                                </option>

                                <option value="+ Supraclavicular + Aleteo nasal" data-puntos="2">
                                    + Supraclavicular (2 pts)
                                </option>

                                <option value="+ Todo lo anterior + Supraesternal" data-puntos="3">
                                    + Supraesternal (3 pts)
                                </option>

                            </select>
                        </div>


                        <!-- Ventilación -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Ventilación
                            </label>

                            <select class="form-select select-sintoma border-success"
                                    name="sintomas[10]"
                                    onchange="calcularScoreDinamico()"
                                    required>

                                <option value="" data-puntos="0" selected disabled>
                                    Seleccione...
                                </option>

                                <option value="Buena, Simétrica" data-puntos="0">
                                    Buena, Simétrica (0 pts)
                                </option>

                                <option value="Regular. Simétrica" data-puntos="1">
                                    Regular. Simétrica (1 pt)
                                </option>

                                <option value="Muy disminuida" data-puntos="2">
                                    Muy disminuida (2 pts)
                                </option>

                                <option value="Tórax silente" data-puntos="3">
                                    Tórax silente (3 pts)
                                </option>

                            </select>
                        </div>


                        <!-- Cianosis -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Cianosis
                            </label>

                            <select class="form-select select-sintoma border-success"
                                    name="sintomas[11]"
                                    onchange="calcularScoreDinamico()"
                                    required>

                                <option value="" data-puntos="0" selected disabled>
                                    Seleccione...
                                </option>

                                <option value="No" data-puntos="0">
                                    No (0 pts)
                                </option>

                                <option value="Sí" data-puntos="1">
                                    Sí (1 pt)
                                </option>

                            </select>
                        </div>


                        <!-- Saturación -->
                        <!-- NO SUMA AL SCORE -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Saturación de oxígeno
                            </label>

                            <input type="number"
                                   class="form-control border-success"
                                   name="saturacion_oxigeno"
                                   min="0"
                                   max="100"
                                   step="0.1"
                                   placeholder="%">
                        </div>


                        <!-- Temperatura -->
                        <!-- NO SUMA AL SCORE -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">
                                Temperatura
                            </label>

                            <input type="number"
                                   class="form-control border-success"
                                   name="temperatura"
                                   step="0.1"
                                   placeholder="°C">
                        </div>

                    <?php endif; ?>

                </div>


                <!-- SCORE -->
                <hr class="text-success">

                <div class="alert alert-success text-center border-success">
                    <h4 class="mb-0 text-success">
                        Score Total en Vivo:

                        <span id="score_display"
                              class="fw-bold fs-2 text-success">
                            0
                        </span>
                    </h4>
                </div>


                <!-- MEDICACIÓN -->
                <div class="mb-3">
                    <label class="form-label text-success fw-bold">
                        Medicación Administrada
                    </label>

                    <input type="text"
                           class="form-control border-success"
                           name="medicacion"
                           placeholder="Ej: Salbutamol">
                </div>


                <!-- OBSERVACIONES -->
                <div class="mb-3">
                    <label class="form-label text-success fw-bold">
                        Observaciones Clínicas
                    </label>

                    <textarea class="form-control border-success"
                              name="observaciones"
                              rows="3"
                              placeholder="Detalles de la evolución..."></textarea>
                </div>


                <!-- BOTONES -->
                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= base_url('visitas') ?>"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Guardar Control
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>