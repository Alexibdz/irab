<div class="container-fluid px-4 mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-primary"><i class="bi bi-journal-medical"></i> Registrar Nueva Visita</h2>
        <a href="<?= base_url('visitas') ?>" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <form action="<?= base_url('visitas/insertar') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row">    
            <!-- ========================================== -->
            <!-- DATOS DE LA VISITA      -->
            <!-- ========================================== -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Información del Ingreso</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <!-- PACIENTE -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-success">Paciente</label>
                                
                                <select class="form-select border-success" id="select_paciente" name="id_paciente" onchange="filtrarFactoresPorEdad()" required>
                                    <option value="" data-nacimiento="" disabled selected>Seleccione un paciente...</option>
                                    <?php foreach ($pacientes as $paciente): ?>
                                        <option value="<?= $paciente['id'] ?>" data-nacimiento="<?= $paciente['fecha_nacimiento'] ?>">
                                            <?= esc($paciente['nombre']) ?> (DNI: <?= esc($paciente['dni']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                
                                <!--  para registrar nuevo paciente -->
                                <div class="mt-2 text-end">
                                    <small class="text-muted me-2">¿No está en la lista?</small>
                                    <a href="<?= base_url('paciente/nuevo') ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-person-plus"></i> Registrar paciente
                                    </a>
                                </div>
                            </div>

                            <!-- USUARIO -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usuario (Enfermera/Médico)</label>
                                <select class="form-select" name="id_usuario" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <option value="<?= $usuario['id'] ?>">
                                            <?= esc($usuario['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- ESTABLECIMIENTO -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Establecimiento</label>
                                <select class="form-select" name="id_establecimiento" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <?php foreach ($establecimientos as $establecimiento): ?>
                                        <option value="<?= $establecimiento['id'] ?>">
                                            <?= esc($establecimiento['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- FECHA DE INGRESO -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha y Hora de ingreso</label>
                                <input type="datetime-local" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>

                            <!-- DIAGNÓSTICO -->
                            <div class="col-md-6 mb-3">
                                <label for="diagnostico" class="form-label">Diagnóstico Inicial</label>
                                <select class="form-select" id="diagnostico" name="diagnostico" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="SBO">SBO</option>
                                    <option value="BQL">BQL</option>
                                    <option value="NMN">NMN</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>

                            <hr class="my-3">

                            <!-- ESTADO DE DERIVACIÓN -->
                            <div class="col-md-4 mb-3">
                                <label for="estado_derivacion" class="form-label">Estado Derivación</label>
                                <select class="form-select" id="estado_derivacion" name="estado_derivacion" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Internación">Internación</option>
                                    <option value="Derivación">Derivación</option>
                                    <option value="Domicilio">Domicilio</option>
                                </select>
                            </div>

                            <!-- TURNO PROTEGIDO LUGAR -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Lugar Turno Prot.</label>
                                <select class="form-select" name="id_turno_protegido_lugar">
                                    <option value="">Opcional...</option>
                                    <?php foreach ($establecimientos as $establecimiento): ?>
                                        <option value="<?= $establecimiento['id'] ?>"><?= esc($establecimiento['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- FECHA DEL TURNO PROTEGIDO -->
                            <div class="col-md-4 mb-3">
                                <label for="turno_protegido_fecha" class="form-label">Fecha Turno Prot.</label>
                                <input type="date" class="form-control" id="turno_protegido_fecha" name="turno_protegido_fecha">
                            </div>

                            <hr class="my-3">

                            <!-- MEDICACIÓN EGRESO -->
                            <div class="col-md-6 mb-3">
                                <label for="medicacion_egreso" class="form-label">Medicación al egreso</label>
                                <input type="text" class="form-control" id="medicacion_egreso" name="medicacion_egreso">
                            </div>

                            <!-- FECHA DE ALTA -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_alta" class="form-label">Fecha de alta</label>
                                <input type="date" class="form-control" id="fecha_alta" name="fecha_alta">
                            </div>

                            <!-- OBSERVACIONES FINALES -->
                            <div class="col-md-12 mb-3">
                                <label for="observaciones_finales" class="form-label">Observaciones generales de la visita</label>
                                <textarea class="form-control" id="observaciones_finales" name="observaciones_finales" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- FACTORES Y CONTROL        -->
            <!-- ========================================== -->
            <div class="col-lg-6 mb-4">
                
                <!-- FACTORES DE RIESGO Y PROTECCIÓN -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Factores de Riesgo y Protección</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <!-- Columna de RIESGOS -->
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

                            <!--PROTECCIÓN -->
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
                        
                        <div id="mensaje_seleccione_paciente" class="alert alert-info mt-2 mb-0 py-2 text-center">
                            <small>Seleccione un paciente a la izquierda para visualizar los factores y el control clínico.</small>
                        </div>
                    </div>
                </div>

                <!-- CONTROL CLÍNICO DE INGRESO (primer control)-->
                <div class="card shadow-sm border-success" id="seccion_control_inicial" style="display: none;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Control Clínico Inicial</h5>
                    </div>
                    <div class="card-body">
                        
                        <div id="contenedor_sintomas_dinamicos" class="row">
                            
                            <!-- ========================================== -->
                            <!-- SÍNTOMAS ESCALA TAL (MENORES DE 2 AÑOS)    -->
                            <!-- ========================================== -->
                            
                            <div class="col-md-6 mb-3 sintoma-tal" style="display:none;">
                                <label class="form-label fw-bold">Frec. Cardiaca</label>
                                <select class="form-select border-info" name="sintomas[1]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="119">< 120</option>
                                    <option value="130">121-140</option>
                                    <option value="150">141-160</option>
                                    <option value="170">> 160</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-tal" id="div_fr_menor" style="display:none;">
                                <label class="form-label fw-bold">F.R. (<= 6m)</label>
                                <select class="form-select border-info" name="sintomas[2]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="40"><= 40</option>
                                    <option value="50">41-55</option>
                                    <option value="65">56-70</option>
                                    <option value="75">> 70</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-tal" id="div_fr_mayor" style="display:none;">
                                <label class="form-label fw-bold">F.R. (> 6m)</label>
                                <select class="form-select border-info" name="sintomas[3]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="30"><= 30</option>
                                    <option value="40">31-45</option>
                                    <option value="55">46-60</option>
                                    <option value="65">> 60</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-tal" style="display:none;">
                                <label class="form-label fw-bold">Sibilancias</label>
                                <select class="form-select border-info" name="sintomas[4]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="No">No</option>
                                    <option value="Fin espiración con estetoscopio">Fin espir.</option>
                                    <option value="Inspiración y espiración con estetoscopio">Insp/Esp.</option>
                                    <option value="Audible sin estetoscopio">Audibles</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-tal" style="display:none;">
                                <label class="form-label fw-bold">Retracción</label>
                                <select class="form-select border-info" name="sintomas[5]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="No">No</option>
                                    <option value="Subcostal">Subcostal</option>
                                    <option value="Subcostal e intercostal">Sub/Inter.</option>
                                    <option value="Generalizado">General.</option>
                                </select>
                            </div>


                            <!-- ========================================== -->
                            <!-- SÍNTOMAS ESCALA WDF (2 A 5 AÑOS)           -->
                            <!-- ========================================== -->

                            <div class="col-md-6 mb-3 sintoma-wdf" style="display:none;">
                                <label class="form-label fw-bold">Frec. Cardiaca</label>
                                <select class="form-select border-info" name="sintomas[6]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="119">< 120 lpm</option>
                                    <option value="130">> 120 lpm</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-wdf" style="display:none;">
                                <label class="form-label fw-bold">Frec. Respiratoria</label>
                                <select class="form-select border-info" name="sintomas[7]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="29">< 30 rpm</option>
                                    <option value="40">31 - 45</option>
                                    <option value="55">46 - 60</option>
                                    <option value="65">> 60 rpm</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-wdf" style="display:none;">
                                <label class="form-label fw-bold">Sibilancias</label>
                                <select class="form-select border-info" name="sintomas[8]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="No">No</option>
                                    <option value="Final espiración">Fin espir.</option>
                                    <option value="Todo espiración">Toda espir.</option>
                                    <option value="+ Inspiración">Insp/Esp.</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-wdf" style="display:none;">
                                <label class="form-label fw-bold">Tiraje</label>
                                <select class="form-select border-info" name="sintomas[9]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="No">No</option>
                                    <option value="Subcostal / Intercostal">Sub/Intercostal</option>
                                    <option value="+ Supraclavicular + Aleteo nasal">+ Supraclav.</option>
                                    <option value="+ Todo lo anterior + Supraesternal">+ Supraester.</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-wdf" style="display:none;">
                                <label class="form-label fw-bold">Ventilación</label>
                                <select class="form-select border-info" name="sintomas[10]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="Buena, Simétrica">Buena</option>
                                    <option value="Regular. Simétrica">Regular</option>
                                    <option value="Muy disminuida">Muy dism.</option>
                                    <option value="Tórax silente">Silente</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3 sintoma-wdf" style="display:none;">
                                <label class="form-label fw-bold">Cianosis</label>
                                <select class="form-select border-info" name="sintomas[11]">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="No">No</option>
                                    <option value="Sí">Sí</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================== -->
        <!-- botones finales                -->
        <!-- ========================================== -->
        <div class="row">
            <div class="col-12 text-end">
                <hr>
                <button type="button" class="btn btn-secondary btn-lg me-2" onclick="window.location.href='<?= base_url('visitas') ?>'">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-lg px-5">Guardar Visita Completa</button>
            </div>
        </div>

    </form>
</div>

