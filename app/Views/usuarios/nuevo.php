<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0"><?= esc($titulo) ?></h2>
                </div>
                
                <div class="card-body">
                    <form action="<?= base_url('configuracion/usuarios/insertar') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" name="id_rol" id="id_rol" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= esc($rol['id']) ?>">
                                        <?= esc($rol['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_establecimiento_asignado" class="form-label">Establecimiento asignado</label>
                            <select class="form-select" name="id_establecimiento_asignado" id="id_establecimiento_asignado" required>
                                <option value="" disabled selected>Seleccione un establecimiento</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= esc($establecimiento['id']) ?>">
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('configuracion/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>