<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0"><?= esc($titulo) ?></h2>
                </div>
                
                <div class="card-body">
                    <!-- Bloque para mostrar errores de validación -->
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger mb-4 shadow-sm">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo base_url('configuracion/usuarios/actualizar'); ?>" method="post"> 
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($usuario['id']) ?>">
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <!-- Solo usamos esc() para mostrar el dato de la BD de forma directa -->
                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?= esc($usuario['nombre']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= esc($usuario['username']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <div class="form-text text-muted">
                                Dejar vacío para mantener la contraseña actual. Si ingresa una nueva, debe tener al menos 8 caracteres y un símbolo especial.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" name="id_rol" id="id_rol" required>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= esc($rol['id']) ?>" <?= set_select('id_rol', $rol['id'], ($usuario['id_rol'] == $rol['id'])) ?>>
                                        <?= esc($rol['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_establecimiento_asignado" class="form-label">Establecimiento asignado</label>
                            <select class="form-select" name="id_establecimiento_asignado" id="id_establecimiento_asignado" required>
                                <option value="">Seleccione un establecimiento</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= esc($establecimiento['id']) ?>" <?= set_select('id_establecimiento_asignado', $establecimiento['id'], ($usuario['id_establecimiento_asignado'] == $establecimiento['id'])) ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('configuracion/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>