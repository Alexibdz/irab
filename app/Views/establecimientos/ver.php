<div>
    <h2><?= esc($titulo) ?></h2>
    <div>
        <label for="nombre">Nombre: </label>
        <?php echo esc($establecimiento['nombre']); ?>
    </div>
    <div>
        <label for="cuartel">Cuartel: </label>
        <?php echo esc($establecimiento['cuartel']); ?>
    </div>
    <div>
        <label for="tipo">Tipo: </label>
        <?php echo esc($establecimiento['tipo']); ?>
    </div>
    <a href="<?php echo base_url('establecimientos'); ?>">Volver</a>
</div>