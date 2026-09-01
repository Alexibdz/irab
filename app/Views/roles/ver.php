<div>
    <h2><?= esc($titulo) ?></h2>
    <div>
        <label for="id">ID: </label>
        <?php echo esc($rol['id']); ?>
    </div>
    <div>
        <label for="nombre">Nombre: </label>
        <?php echo esc($rol['nombre']); ?>
    </div>
    <a href="<?php echo base_url('roles'); ?>">Volver</a>
</div>