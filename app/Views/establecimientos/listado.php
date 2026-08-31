<div>
    <div>
        <h2><?= esc($titulo) ?></h2>
        <a href="<?php echo base_url('establecimientos/nuevo'); ?>">Nuevo Establecimiento</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cuartel</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($establecimientos as $establecimiento): ?>
                <tr>
                    <td><?= esc($establecimiento['nombre']) ?></td>
                    <td><?= esc($establecimiento['cuartel']) ?></td>
                    <td><?= esc($establecimiento['tipo']) ?></td>
                    <td>
                        <!--<a class="" href="<?php echo base_url('establecimientos/borrar/' . $establecimiento["id"]); ?>">Eliminar</a>-->
                        <a href="<?= base_url('establecimientos/editar/' . $establecimiento['id']) ?>">Editar</a>
                        <a href="<?= base_url('establecimientos/ver/' . $establecimiento['id']) ?>">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>