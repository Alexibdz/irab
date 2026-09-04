<div>
    <div>
        <h2><?= esc($titulo) ?></h2>
        <a href="<?php echo base_url('roles/nuevo'); ?>">Nuevo Rol</a>
        <a href="<?php echo base_url('roles/eliminados'); ?>">Ver Papelera</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= esc($rol['nombre']) ?></td>
                    <td>
                        <a href="<?= base_url('roles/eliminar/' . $rol['id']); ?>"
                        onclick="return confirm('¿Deseas eliminar este rol?');">
                            Eliminar
                        </a>
                        <a href="<?php echo base_url('roles/editar/' . $rol["id"]); ?>"> Editar </a>
                        <a href="<?php echo base_url('roles/ver/' . $rol["id"]); ?>"> Ver </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>