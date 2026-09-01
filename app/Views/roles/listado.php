<div>
    <div>
        <h2><?= esc($titulo) ?></h2>
        <a href="<?php echo base_url('roles/nuevo'); ?>">Nuevo Rol</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= esc($rol['id']) ?></td>
                    <td><?= esc($rol['nombre']) ?></td>
                    <td>
                        <!--<a href="<?php echo base_url('roles/borrar/' . $rol["id"]); ?>"> Eliminar </a> -->
                        <a href="<?php echo base_url('roles/editar/' . $rol["id"]); ?>"> Editar </a>
                        <a href="<?php echo base_url('roles/ver/' . $rol["id"]); ?>"> Ver </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>