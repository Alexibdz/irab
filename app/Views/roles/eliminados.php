<div>
    <h2>Roles Eliminados (Inactivos)</h2>
    <a href="<?php echo base_url('roles'); ?>">Volver a Roles Activos</a>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= $rol['nombre'] ?></td>
                    <td><?= $rol['fecha_borrado'] ?></td>
                    <td><a href="<?= base_url('roles/recuperar/' . $rol['id']) ?>">Recuperar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>