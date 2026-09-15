<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Registrar Nueva Visita</h2>
                </div>

                <div class="card-body">

                    <form action="<?= base_url('visitas/insertar') ?>" method="POST">

                        <?= csrf_field() ?>


                        <!-- PACIENTE -->
                        <div class="mb-3">

                            <label class="form-label">Paciente</label>

                            <select class="form-select"
                                    name="id_paciente"
                                    required>

                                <option value="" disabled selected>
                                    Seleccione un paciente
                                </option>

                                <?php foreach ($pacientes as $paciente): ?>

                                    <option value="<?= $paciente['id'] ?>">
                                        <?= esc($paciente['nombre']) ?>
                                        (DNI: <?= esc($paciente['dni']) ?>)
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- USUARIO -->
                        <div class="mb-3">

                            <label class="form-label">Usuario</label>

                            <select class="form-select"
                                    name="id_usuario"
                                    required>

                                <option value="" disabled selected>
                                    Seleccione un usuario
                                </option>

                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['id'] ?>">
                                        <?= esc($usuario['nombre']) ?> - <?= esc($usuario['username']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- ESTABLECIMIENTO -->
                        <div class="mb-3">

                            <label class="form-label">
                                Establecimiento
                            </label>

                            <select class="form-select"
                                    name="id_establecimiento"
                                    required>

                                <option value="" disabled selected>
                                    Seleccione un establecimiento
                                </option>

                                <?php foreach ($establecimientos as $establecimiento): ?>

                                    <option value="<?= $establecimiento['id'] ?>">
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- FECHA DE INGRESO -->
                        <div class="mb-3">

                            <label for="fecha_ingreso" class="form-label">
                                Fecha de ingreso
                            </label>

                            <input type="datetime-local"
                                   class="form-control"
                                   id="fecha_ingreso"
                                   name="fecha_ingreso"
                                   required>

                        </div>


                        <!-- DIAGNÓSTICO -->
                        <div class="mb-3">

                            <label for="diagnostico" class="form-label">
                                Diagnóstico
                            </label>

                            <select class="form-select"
                                    id="diagnostico"
                                    name="diagnostico"
                                    required>

                                <option value="" disabled selected>
                                    Seleccione un diagnóstico
                                </option>

                                <option value="SBO">SBO</option>
                                <option value="BQL">BQL</option>
                                <option value="NMN">NMN</option>
                                <option value="Otros">Otros</option>

                            </select>

                        </div>


                        <!-- ESTADO DE DERIVACIÓN -->
                        <div class="mb-3">

                            <label for="estado_derivacion" class="form-label">
                                Estado de derivación
                            </label>

                            <select class="form-select"
                                    id="estado_derivacion"
                                    name="estado_derivacion"
                                    required>

                                <option value="" disabled selected>
                                    Seleccione un estado
                                </option>

                                <option value="Internación">
                                    Internación
                                </option>

                                <option value="Derivación">
                                    Derivación
                                </option>

                                <option value="Domicilio">
                                    Domicilio
                                </option>

                            </select>

                        </div>

                        <!-- TURNO PROTEGIDO LUGAR -->
                        <div class="mb-3">
                            <label class="form-label">Lugar Turno Protegido</label>
                                <select class="form-select" name="id_turno_protegido_lugar">
                                    <option value="">Seleccione un lugar (Opcional)</option>
                                        <?php foreach ($establecimientos as $establecimiento): ?>
                                            <option value="<?= $establecimiento['id'] ?>">
                                                <?= esc($establecimiento['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                </select>
                        </div>

                        <!-- FECHA DEL TURNO PROTEGIDO -->
                        <div class="mb-3">

                            <label for="turno_protegido_fecha" class="form-label">
                                Fecha del turno protegido
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="turno_protegido_fecha"
                                   name="turno_protegido_fecha">

                        </div>


                        <!-- MEDICACIÓN -->
                        <div class="mb-3">

                            <label for="medicacion_egreso" class="form-label">
                                Medicación al egreso
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="medicacion_egreso"
                                   name="medicacion_egreso">

                        </div>


                        <!-- FECHA DE ALTA -->
                        <div class="mb-3">

                            <label for="fecha_alta" class="form-label">
                                Fecha de alta
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="fecha_alta"
                                   name="fecha_alta">

                        </div>


                        <!-- OBSERVACIONES -->
                        <div class="mb-3">

                            <label for="observaciones_finales" class="form-label">
                                Observaciones finales
                            </label>

                            <textarea class="form-control"
                                      id="observaciones_finales"
                                      name="observaciones_finales"
                                      rows="4"></textarea>

                        </div>


                        <!-- BOTONES -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">

                            <a href="<?= base_url('visitas') ?>"
                               class="btn btn-secondary">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Guardar Visita
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>