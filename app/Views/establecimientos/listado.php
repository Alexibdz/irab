<div>
    <div>
        <h2><?= esc($titulo) ?></h2>
        <a href="<?php echo base_url('configuracion/establecimientos/nuevo'); ?>">Nuevo Establecimiento</a>
        <a href="<?php echo base_url('configuracion/establecimientos/eliminados'); ?>">Ver Papelera</a>
    </div>
    <table class="table table-striped table-hover tabla-datos">
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
                        <a href="<?= base_url('configuracion/establecimientos/eliminar/' . $establecimiento['id']); ?>"
                        onclick="return confirm('¿Deseas eliminar este establecimiento?');">
                            Eliminar
                        </a>
                        <a href="<?= base_url('configuracion/establecimientos/editar/' . $establecimiento['id']) ?>">Editar</a>
                        <a href="<?= base_url('configuracion/establecimientos/ver/' . $establecimiento['id']) ?>">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>