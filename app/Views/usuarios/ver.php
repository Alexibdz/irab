<div>
    <h2><?php echo esc($titulo); ?></h2>
    <div>
        <label>Nombre: </label>
        <?php echo esc($usuario['nombre']); ?>
    </div>
    <div>
        <label>Usuario: </label>
        <?php echo esc($usuario['username']); ?>
    </div>
    <div>
        <label>Rol: </label>
        <?php echo esc($usuario['rol_nombre']); ?>
    </div>
    <div>
        <label>Establecimiento asignado: </label>
        <?php echo esc($usuario['establecimiento_nombre']); ?>
    </div>
    <a href="<?php echo base_url('usuarios'); ?>">
        Volver
    </a>
</div>