<div class="container mt-4">
    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <h3 class="h5 mb-0">Registrar Nuevo Control Clínico</h3>
        </div>
        <div class="card-body">
            
            <form action="<?= base_url('control/guardar') ?>" method="POST">
                <?= csrf_field() ?>
                
                <input type="hidden" name="id_visita" value="<?= $visita['id'] ?? '' ?>">
                
                <div class="row mb-4">
                    
                    <?php if ($tipo_planilla === 'TAL'): ?>
                        <!-- ========================================== -->
                        <!-- SÍNTOMAS ESCALA TAL (MENORES DE 2 AÑOS)    -->
                        <!-- ========================================== -->
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Frec. Cardiaca</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[1]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="119" data-puntos="0">< 120 lpm (0 pts)</option>
                                <option value="130" data-puntos="1">121-140 lpm (1 pt)</option>
                                <option value="150" data-puntos="2">141-160 lpm (2 pts)</option>
                                <option value="170" data-puntos="3">> 160 lpm (3 pts)</option>
                            </select>
                        </div>
                        
                        <?php if ($meses_edad <= 6): ?>
                            <!-- Para 6 meses o menos -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-success">F.R. (<= 6m)</label>
                                <select class="form-select select-sintoma border-success" name="sintomas[2]" onchange="calcularScoreDinamico()" required>
                                    <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                    <option value="40" data-puntos="0"><= 40 rpm (0 pts)</option>
                                    <option value="50" data-puntos="1">41-55 rpm (1 pt)</option>
                                    <option value="65" data-puntos="2">56-70 rpm (2 pts)</option>
                                    <option value="75" data-puntos="3">> 70 rpm (3 pts)</option>
                                </select>
                            </div>
                        <?php else: ?>
                            <!-- Para más de 6 meses (y menores de 2 años) -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-success">F.R. (> 6m)</label>
                                <select class="form-select select-sintoma border-success" name="sintomas[3]" onchange="calcularScoreDinamico()" required>
                                    <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                    <option value="30" data-puntos="0"><= 30 rpm (0 pts)</option>
                                    <option value="40" data-puntos="1">31-45 rpm (1 pt)</option>
                                    <option value="55" data-puntos="2">46-60 rpm (2 pts)</option>
                                    <option value="65" data-puntos="3">> 60 rpm (3 pts)</option>
                                </select>
                            </div>
                        <?php endif; ?>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Sibilancias</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[4]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="No" data-puntos="0">No (0 pts)</option>
                                <option value="Fin espiración con estetoscopio" data-puntos="1">Fin espir. (1 pt)</option>
                                <option value="Inspiración y espiración con estetoscopio" data-puntos="2">Insp/Esp. (2 pts)</option>
                                <option value="Audible sin estetoscopio" data-puntos="3">Audibles (3 pts)</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Retracción</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[5]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="No" data-puntos="0">No (0 pts)</option>
                                <option value="Subcostal" data-puntos="1">Subcostal (1 pt)</option>
                                <option value="Subcostal e intercostal" data-puntos="2">Sub/Inter. (2 pts)</option>
                                <option value="Generalizado" data-puntos="3">Generalizado (3 pts)</option>
                            </select>
                        </div>

                    <?php else: ?>
                        <!-- ========================================== -->
                        <!-- SÍNTOMAS ESCALA WDF (MAYORES DE 2 AÑOS)    -->
                        <!-- ========================================== -->
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Frecuencia Cardiaca</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[6]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="119" data-puntos="0">< 120 lpm (0 pts)</option>
                                <option value="130" data-puntos="1">> 120 lpm (1 pt)</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Frecuencia Respiratoria</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[7]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="29" data-puntos="0">< 30 rpm (0 pts)</option>
                                <option value="40" data-puntos="1">31 - 45 rpm (1 pt)</option>
                                <option value="55" data-puntos="2">46 - 60 rpm (2 pts)</option>
                                <option value="65" data-puntos="3">> 60 rpm (3 pts)</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Sibilancias</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[8]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="No" data-puntos="0">No (0 pts)</option>
                                <option value="Final espiración" data-puntos="1">Final espiración (1 pt)</option>
                                <option value="Todo espiración" data-puntos="2">Todo espiración (2 pts)</option>
                                <option value="+ Inspiración" data-puntos="3">+ Inspiración (3 pts)</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Tiraje</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[9]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="No" data-puntos="0">No (0 pts)</option>
                                <option value="Subcostal / Intercostal" data-puntos="1">Subcostal / Intercostal (1 pt)</option>
                                <option value="+ Supraclavicular + Aleteo nasal" data-puntos="2">+ Supraclavicular (2 pts)</option>
                                <option value="+ Todo lo anterior + Supraesternal" data-puntos="3">+ Supraesternal (3 pts)</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Ventilación</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[10]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="Buena, Simétrica" data-puntos="0">Buena, Simétrica (0 pts)</option>
                                <option value="Regular. Simétrica" data-puntos="1">Regular. Simétrica (1 pt)</option>
                                <option value="Muy disminuida" data-puntos="2">Muy disminuida (2 pts)</option>
                                <option value="Tórax silente" data-puntos="3">Tórax silente (3 pts)</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-success">Cianosis</label>
                            <select class="form-select select-sintoma border-success" name="sintomas[11]" onchange="calcularScoreDinamico()" required>
                                <option value="" data-puntos="0" selected disabled>Seleccione...</option>
                                <option value="No" data-puntos="0">No (0 pts)</option>
                                <option value="Sí" data-puntos="1">Sí (1 pt)</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    
                </div>

                <hr class="text-success">
                
                <div class="alert alert-success text-center border-success">
                    <h4 class="mb-0 text-success">Score Total en Vivo: <span id="score_display" class="fw-bold fs-2 text-success">0</span></h4>
                </div>

                <div class="mb-3">
                    <label class="form-label text-success fw-bold">Medicación Administrada</label>
                    <input type="text" class="form-control border-success" name="medicacion" placeholder="Ej: Salbutamol">
                </div>

                <div class="mb-3">
                    <label class="form-label text-success fw-bold">Observaciones Clínicas</label>
                    <textarea class="form-control border-success" name="observaciones" rows="3" placeholder="Detalles de la evolución..."></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('visitas') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Control</button>
                </div>
            </form>

        </div>
    </div>
</div>

