<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0"><?= esc($titulo) ?></h2>
                </div>
                
                <div class="card-body">
                    <!-- para mostrar errores de validación -->
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger mb-4 shadow-sm">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

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
                            <div class="form-text text-muted">
                                Debe tener al menos 8 caracteres y un símbolo especial (ej: #!*@$%&?¿).
                            </div>
                        </div>
                        <!-- Rol -->
                        <h6 class="text-success border-bottom pb-2 mt-3 mb-3">
                            <i class="bi bi-person-badge"></i> Rol
                        </h6>

                        <p class="small text-muted">
                            Elegí un rol existente o cargá uno nuevo.
                        </p>

                        <!-- Rol existente -->
                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                type="radio"
                                name="modo_rol"
                                id="rol_existente"
                                value="existente"
                                checked>

                            <label class="form-check-label" for="rol_existente">
                                Rol ya registrado
                            </label>
                        </div>

                        <div class="mb-3 ps-4" id="bloque_rol_existente">

                            <select class="form-select" name="id_rol" id="id_rol">
                                <option value="" selected disabled>Seleccione un rol</option>

                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= esc($rol['id']) ?>">
                                        <?= esc($rol['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <!-- Rol nuevo -->
                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                type="radio"
                                name="modo_rol"
                                id="rol_nuevo"
                                value="nuevo">

                            <label class="form-check-label" for="rol_nuevo">
                                Crear rol nuevo
                            </label>
                        </div>

                        <div class="mb-3 ps-4 d-none" id="bloque_rol_nuevo">

                            <input type="text"
                                class="form-control"
                                name="nombre_rol"
                                id="nombre_rol"
                                placeholder="Nombre del nuevo rol">

                        </div>            
                        <div class="mb-3">
                            <label for="id_establecimiento_asignado" class="form-label">Establecimiento asignado</label>
                            <select class="form-select" name="id_establecimiento_asignado" id="id_establecimiento_asignado" required>
                                <option value="" disabled <?= set_select('id_establecimiento_asignado', '', true) ?>>Seleccione un establecimiento</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= esc($establecimiento['id']) ?>" <?= set_select('id_establecimiento_asignado', $establecimiento['id']) ?>>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rolExistenteRadio = document.getElementById('rol_existente');
        const rolNuevoRadio = document.getElementById('rol_nuevo');
        const bloqueRolExistente = document.getElementById('bloque_rol_existente');
        const bloqueRolNuevo = document.getElementById('bloque_rol_nuevo');

        rolExistenteRadio.addEventListener('change', toggleRolBlocks);
        rolNuevoRadio.addEventListener('change', toggleRolBlocks);

        function toggleRolBlocks() {
            if (rolExistenteRadio.checked) {
                bloqueRolExistente.classList.remove('d-none');
                bloqueRolNuevo.classList.add('d-none');
            } else if (rolNuevoRadio.checked) {
                bloqueRolExistente.classList.add('d-none');
                bloqueRolNuevo.classList.remove('d-none');
            }
        }
    });
</script>