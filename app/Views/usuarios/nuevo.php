<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('usuarios/insertar'); ?>" method="post"> <?= csrf_field() ?>
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" class="" name="nombre" id="nombre" required>
        </div>
        <div>
            <label for="username">Usuario</label>
            <input type="text" class="" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" class="" name="password" id="password" required>
        </div>
        <div>
            <label for="id_rol">Rol</label>
            <select name="id_rol" id="id_rol" required>
                <option value="">Seleccione un rol</option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= esc($rol['id']) ?>">
                        <?= esc($rol['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="id_establecimiento_asignado">Establecimiento asignado</label>
            <select name="id_establecimiento_asignado" id="id_establecimiento_asignado" required>
                <option value="">Seleccione un establecimiento</option>
                <?php foreach ($establecimientos as $establecimiento): ?>
                    <option value="<?= esc($establecimiento['id']) ?>">
                        <?= esc($establecimiento['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="">Guardar</button>
        <a href="<?php echo base_url('usuarios'); ?>" class="">Cancelar</a>
    </form>
</div>