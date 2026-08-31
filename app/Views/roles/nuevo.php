<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('roles/insertar'); ?>" method="post"> <?= csrf_field() ?>
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <button type="submit">Guardar</button>
        <a href="<?php echo base_url('roles'); ?>">Cancelar</a>
    </form>
</div>