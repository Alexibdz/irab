<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0">Editar Paciente</h2>
                </div>
                
                <div class="card-body">
                    
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger mb-4 shadow-sm">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('paciente/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <input type="hidden" name="id" value="<?= esc($paciente['id']) ?>">

                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="number" class="form-control" id="dni" name="dni" value="<?= esc($paciente['dni']) ?>" required>
                            <div class="form-text text-muted">
                                Ingrese el número sin puntos ni espacios
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($paciente['nombre']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= esc($paciente['fecha_nacimiento']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tutor / Responsable</label>
                            <select class="form-select" name="id_tutor" required>
                                <option value="" disabled>Seleccione un tutor</option>
                                <?php foreach ($tutores as $tutor): ?>
                                    <option value="<?= esc($tutor['id']) ?>" <?= ($tutor['id'] == $paciente['id_tutor']) ? 'selected' : '' ?>>
                                        <?= esc($tutor['nombre']) ?> (DNI: <?= esc($tutor['dni']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono del Tutor</label>
                            <select class="form-select">
                                <option value="" disabled>Seleccione para ver el teléfono</option>
                                <?php foreach ($tutores as $tutor): ?>
                                    <option value="<?= esc($tutor['id']) ?>" <?= ($tutor['id'] == $paciente['id_tutor']) ? 'selected' : '' ?>>
                                        <?= esc($tutor['nombre']) ?> (Teléfono: <?= esc($tutor['telefono'] ?: 'No registrado') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Domicilio</label>
                            <input type="text" class="form-control" name="domicilio" value="<?= esc($paciente['domicilio']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barrio</label>
                            <input type="text" class="form-control" name="barrio" value="<?= esc($paciente['barrio']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Área Programática (Zona/Cuartel)</label>
                            <select class="form-select" name="id_area_programatica" required>
                                <option value="" disabled>Seleccione un área programática</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= esc($establecimiento['id']) ?>" <?= ($establecimiento['id'] == $paciente['id_area_programatica']) ? 'selected' : '' ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Establecimiento Habitual</label>
                            <select class="form-select" name="id_establecimiento_habitual" required>
                                <option value="" disabled>Seleccione un establecimiento...</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= esc($establecimiento['id']) ?>" <?= ($establecimiento['id'] == $paciente['id_establecimiento_habitual']) ? 'selected' : '' ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('paciente') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar Datos</button>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>