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
                                <label for="diagnostico" class="form-label">Diagnóstico</label>
                                
                                <!-- El input muestra el valor guardado y se conecta a la datalist -->
                                <input type="text" class="form-control" id="diagnostico" name="diagnostico" list="lista_diagnosticos" value="<?= esc($visita['diagnostico']) ?>" required>
                                
                                <!-- lista de opciones predefinidas -->
                                <datalist id="lista_diagnosticos">
                                    <option value="SBO">
                                    <option value="BQL">
                                    <option value="NMN">
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- EGRESO: se carga al cerrar la visita       -->
                    <!-- ========================================== -->
                    <div class="col-lg-6 ps-lg-4 mt-4 mt-lg-0">
                        <h5 class="text-success border-bottom pb-2 mb-3">Egreso</h5>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Los datos de egreso (derivación, turno protegido, medicación, fecha de alta
                            y observaciones finales) se cargan desde el botón
                            <strong>Cerrar visita</strong>, en el detalle de la visita.
                            <div class="mt-2">
                                <a href="<?= base_url('visitas/ver/' . $visita['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    Ir al detalle de la visita
                                </a>
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