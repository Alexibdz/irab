<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('roles/actualizar'); ?>" method="post"> <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($rol['id']) ?>">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= esc($rol['nombre']) ?>" required>
        </div>
        <button type="submit">Guardar</button>
        <a href="<?php echo base_url('roles'); ?>">Cancelar</a>
    </form>
</div>