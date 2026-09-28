<div class="container-fluid px-4 mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-success"><i class="bi bi-pencil-square"></i> Editar Visita</h2>
        <a href="<?= base_url('visitas') ?>" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <form action="<?= base_url('visitas/actualizar') ?>" method="POST">
        
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $visita['id'] ?>">

        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white fw-bold">
                Actualización de Datos Administrativos y Médicos
            </div>
            <div class="card-body">
                
                <div class="row">
                    <!-- ========================================== -->
                    <!-- INGRESO Y DIAGNÓSTICO   -->
                    <!-- ========================================== -->
                    <div class="col-lg-6 border-end pe-lg-4">
                        <h5 class="text-secondary border-bottom pb-2 mb-3">Datos de Ingreso</h5>
                        
                        <div class="row">
                            <!-- PACIENTE -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Paciente</label>
                                <select class="form-select" name="id_paciente" required>
                                    <option value="" disabled>Seleccione un paciente</option>
                                    <?php foreach ($pacientes as $paciente): ?>
                                        <option value="<?= $paciente['id'] ?>" <?= $paciente['id'] == $visita['id_paciente'] ? 'selected' : '' ?>>
                                            <?= esc($paciente['nombre']) ?> (DNI: <?= esc($paciente['dni']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- USUARIO -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usuario</label>
                                <select class="form-select" name="id_usuario" required>
                                    <option value="" disabled>Seleccione un usuario</option>
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <option value="<?= $usuario['id'] ?>" <?= $usuario['id'] == $visita['id_usuario'] ? 'selected' : '' ?>>
                                            <?= esc($usuario['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- ESTABLECIMIENTO -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Establecimiento</label>
                                <select class="form-select" name="id_establecimiento" required>
                                    <option value="" disabled>Seleccione un establecimiento</option>
                                    <?php foreach ($establecimientos as $establecimiento): ?>
                                        <option value="<?= $establecimiento['id'] ?>" <?= $establecimiento['id'] == $visita['id_establecimiento'] ? 'selected' : '' ?>>
                                            <?= esc($establecimiento['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- FECHA DE INGRESO -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                                <input type="datetime-local" class="form-control" id="fecha_ingreso" name="fecha_ingreso" 
                                       value="<?= !empty($visita['fecha_ingreso']) ? date('Y-m-d\TH:i', strtotime($visita['fecha_ingreso'])) : '' ?>" required>
                            </div>

                            <!-- DIAGNÓSTICO -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Diagnóstico</label>
                                <select class="form-select" name="diagnostico" required>
                                    <option value="" disabled>Seleccione un diagnóstico</option>
                                    <option value="SBO" <?= $visita['diagnostico'] == 'SBO' ? 'selected' : '' ?>>SBO</option>
                                    <option value="BQL" <?= $visita['diagnostico'] == 'BQL' ? 'selected' : '' ?>>BQL</option>
                                    <option value="NMN" <?= $visita['diagnostico'] == 'NMN' ? 'selected' : '' ?>>NMN</option>
                                    <option value="Otros" <?= $visita['diagnostico'] == 'Otros' ? 'selected' : '' ?>>Otros</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- DERIVACIÓN Y EGRESO       -->
                    <!-- ========================================== -->
                    <div class="col-lg-6 ps-lg-4 mt-4 mt-lg-0">
                        <h5 class="text-success border-bottom pb-2 mb-3">Evolución y Egreso</h5>
                        
                        <div class="row">
                            <!-- ESTADO DE DERIVACIÓN -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Estado de derivación</label>
                                <select class="form-select" name="estado_derivacion" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <option value="Internación" <?= $visita['estado_derivacion'] == 'Internación' ? 'selected' : '' ?>>Internación</option>
                                    <option value="Derivación" <?= $visita['estado_derivacion'] == 'Derivación' ? 'selected' : '' ?>>Derivación</option>
                                    <option value="Domicilio" <?= $visita['estado_derivacion'] == 'Domicilio' ? 'selected' : '' ?>>Domicilio</option>
                                </select>
                            </div>

                            <!-- TURNO PROTEGIDO-->
                            <div class="col-md-6 mb-3">
                                <label for="id_turno_protegido_lugar" class="form-label">Lugar turno protegido</label>
                                <select class="form-select" name="id_turno_protegido_lugar">
                                    <option value="">Opcional...</option>
                                    <?php foreach ($establecimientos as $establecimiento): ?>
                                        <option value="<?= $establecimiento['id'] ?>" <?= ($visita['id_turno_protegido_lugar'] == $establecimiento['id']) ? 'selected' : '' ?>>
                                            <?= esc($establecimiento['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- FECHA DEL TURNO PROTEGIDO -->
                            <div class="col-md-6 mb-3">
                                <label for="turno_protegido_fecha" class="form-label">Fecha turno protegido</label>
                                <input type="date" class="form-control" id="turno_protegido_fecha" name="turno_protegido_fecha" value="<?= esc($visita['turno_protegido_fecha'] ?? '') ?>">
                            </div>

                            <!-- MEDICACIÓN EGRESO -->
                            <div class="col-md-6 mb-3">
                                <label for="medicacion_egreso" class="form-label">Medicación al egreso</label>
                                <input type="text" class="form-control" id="medicacion_egreso" name="medicacion_egreso" value="<?= esc($visita['medicacion_egreso'] ?? '') ?>">
                            </div>

                            <!-- FECHA DE ALTA -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_alta" class="form-label">Fecha de alta</label>
                                <input type="date" class="form-control" id="fecha_alta" name="fecha_alta" value="<?= esc($visita['fecha_alta'] ?? '') ?>">
                            </div>

                            <!-- OBSERVACIONES FINALES -->
                            <div class="col-12 mb-3">
                                <label for="observaciones_finales" class="form-label">Observaciones finales</label>
                                <textarea class="form-control" id="observaciones_finales" name="observaciones_finales" rows="3"><?= esc($visita['observaciones_finales'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="card-footer bg-light text-end py-3">
                <a href="<?= base_url('visitas') ?>" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Guardar Cambios</button>
            </div>
            
        </div>
    </form>
</div>