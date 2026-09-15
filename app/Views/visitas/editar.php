<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h2 class="h4 mb-0">Editar Visita</h2>
                </div>

                <div class="card-body">

                <form action="<?= base_url('visitas/actualizar') ?>" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id" value="<?= $visita['id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Paciente</label>

                            <select class="form-select" name="id_paciente" required>
                                <option value="" disabled>
                                    Seleccione un paciente
                                </option>

                                <?php foreach ($pacientes as $paciente): ?>

                                    <option
                                        value="<?= $paciente['id'] ?>"
                                        <?= $paciente['id'] == $visita['id_paciente'] ? 'selected' : '' ?>
                                    >
                                        <?= esc($paciente['nombre']) ?>
                                        (DNI: <?= esc($paciente['dni']) ?>)
                                    </option>

                                <?php endforeach; ?>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Usuario</label>

                            <select class="form-select" name="id_usuario" required>
                                <option value="" disabled>
                                    Seleccione un usuario
                                </option>

                                <?php foreach ($usuarios as $usuario): ?>

                                    <option
                                        value="<?= $usuario['id'] ?>"
                                        <?= $usuario['id'] == $visita['id_usuario'] ? 'selected' : '' ?>
                                    >
                                        <?= esc($usuario['nombre']) ?>
                                        - <?= esc($usuario['username']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Establecimiento</label>

                            <select class="form-select" name="id_establecimiento" required>
                                <option value="" disabled>
                                    Seleccione un establecimiento
                                </option>

                                <?php foreach ($establecimientos as $establecimiento): ?>

                                    <option
                                        value="<?= $establecimiento['id'] ?>"
                                        <?= $establecimiento['id'] == $visita['id_establecimiento'] ? 'selected' : '' ?>
                                    >
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="fecha_ingreso" class="form-label">
                                Fecha de ingreso
                            </label>

                            <input
                                type="datetime-local"
                                class="form-control"
                                id="fecha_ingreso"
                                name="fecha_ingreso"
                                value="<?= !empty($visita['fecha_ingreso']) ? date('Y-m-d\TH:i', strtotime($visita['fecha_ingreso'])) : '' ?>"
                                required
                            >
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Diagnóstico</label>

                            <select class="form-select" name="diagnostico" required>

                                <option value="" disabled>
                                    Seleccione un diagnóstico
                                </option>

                                <option value="SBO"
                                    <?= $visita['diagnostico'] == 'SBO' ? 'selected' : '' ?>>
                                    SBO
                                </option>

                                <option value="BQL"
                                    <?= $visita['diagnostico'] == 'BQL' ? 'selected' : '' ?>>
                                    BQL
                                </option>

                                <option value="NMN"
                                    <?= $visita['diagnostico'] == 'NMN' ? 'selected' : '' ?>>
                                    NMN
                                </option>

                                <option value="Otros"
                                    <?= $visita['diagnostico'] == 'Otros' ? 'selected' : '' ?>>
                                    Otros
                                </option>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Estado de derivación</label>

                            <select class="form-select" name="estado_derivacion" required>

                                <option value="" disabled>
                                    Seleccione un estado
                                </option>

                                <option value="Internación"
                                    <?= $visita['estado_derivacion'] == 'Internación' ? 'selected' : '' ?>>
                                    Internación
                                </option>

                                <option value="Derivación"
                                    <?= $visita['estado_derivacion'] == 'Derivación' ? 'selected' : '' ?>>
                                    Derivación
                                </option>

                                <option value="Domicilio"
                                    <?= $visita['estado_derivacion'] == 'Domicilio' ? 'selected' : '' ?>>
                                    Domicilio
                                </option>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="id_turno_protegido_lugar" class="form-label">
                                Lugar del turno protegido
                            </label>
                            <select class="form-select" name="id_establecimiento" require>

                                <?php foreach ($establecimientos as $establecimiento): ?>

                                    <option value="<?= $establecimiento['id'] ?>" <?php  ($visita['id_establecimiento'] == $establecimiento['id']) ? 'selected' : '' ?>>
                                    
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="turno_protegido_fecha" class="form-label">
                                Fecha del turno protegido
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="turno_protegido_fecha"
                                name="turno_protegido_fecha"
                                value="<?= esc($visita['turno_protegido_fecha']) ?>"
                            >
                        </div>


                        <div class="mb-3">
                            <label for="medicacion_egreso" class="form-label">
                                Medicación al egreso
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="medicacion_egreso"
                                name="medicacion_egreso"
                                value="<?= esc($visita['medicacion_egreso']) ?>"
                            >
                        </div>


                        <div class="mb-3">
                            <label for="fecha_alta" class="form-label">
                                Fecha de alta
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="fecha_alta"
                                name="fecha_alta"
                                value="<?= esc($visita['fecha_alta']) ?>"
                            >
                        </div>


                        <div class="mb-3">
                            <label for="observaciones_finales" class="form-label">
                                Observaciones finales
                            </label>

                            <textarea
                                class="form-control"
                                id="observaciones_finales"
                                name="observaciones_finales"
                                rows="4"
                            ><?= esc($visita['observaciones_finales']) ?></textarea>
                        </div>


                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">

                            <a href="<?= base_url('visitas') ?>"
                               class="btn btn-secondary">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-warning">
                                Guardar cambios
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>