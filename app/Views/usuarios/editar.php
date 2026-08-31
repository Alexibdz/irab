<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('usuarios/actualizar'); ?>" method="post"> <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($usuario['id']) ?>">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= esc($usuario['nombre']) ?>" required>
        </div>
        <div>
            <label for="username">Usuario</label>
            <input type="text" name="username" id="username" value="<?= esc($usuario['username']) ?>" required>
        </div>
        <div>
            <label for="password">Nueva contraseña</label>
            <input type="password" name="password" id="password">
            <small>Dejar vacío para mantener la contraseña actual.</small>
        </div>
        <div>
            <label for="id_rol">Rol</label>
            <select name="id_rol" id="id_rol" required>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= esc($rol['id']) ?>"
                        <?= $usuario['id_rol'] == $rol['id'] ? 'selected' : '' ?>>
                        <?= esc($rol['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="id_establecimiento_asignado"> Establecimiento asignado</label>
            <select name="id_establecimiento_asignado" id="id_establecimiento_asignado" required>
                <option value="">Seleccione un establecimiento</option>
                <?php foreach ($establecimientos as $establecimiento): ?>
                    <option value="<?= esc($establecimiento['id']) ?>"
                        <?= $usuario['id_establecimiento_asignado'] == $establecimiento['id'] ? 'selected' : '' ?>>
                        <?= esc($establecimiento['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Actualizar</button>
        <a href="<?= base_url('usuarios') ?>">
            Cancelar
        </a>
    </form>
</div>