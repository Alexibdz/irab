<?php
// El paciente llega resuelto del paso 1, asi que la edad se calcula aca
// en vez de deducirla en JS a partir de un <select>.
$diferencia = (new DateTime($paciente['fecha_nacimiento']))->diff(new DateTime('today'));
$meses = $diferencia->y * 12 + $diferencia->m;
$edad  = $meses < 24 ? $meses . ' meses' : $diferencia->y . ' años';
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
                            <!-- PACIENTE: viene resuelto del paso 1, no se elige aca -->
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

                            <!-- USUARIO -->
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

                            <!-- ESTABLECIMIENTO -->
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

                            <!-- FECHA DE INGRESO -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha y Hora de ingreso</label>
                                <input type="datetime-local" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>

                            <!-- DIAGNÓSTICO -->
                            <div class="col-md-6 mb-3">
                                <label for="diagnostico" class="form-label text-success fw-bold">Diagnóstico Inicial</label>
                                
                                <!-- el input text normal, enlazado a la lista  -->
                                <input type="text" class="form-control border-success" id="diagnostico" name="diagnostico" list="lista_diagnosticos" placeholder="Seleccione o escriba..." required>
                                
                                <!-- las opciones (no se ve en pantalla hasta que haces clic en el input) -->
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
                        
                        <div class="alert alert-secondary mt-2 mb-0 py-2 text-center">
                            <small>Se muestran solo los factores que corresponden a <?= esc($edad) ?>.</small>
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

