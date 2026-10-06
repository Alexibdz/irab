<div>
    <h2><?= esc($titulo) ?></h2>
    <a href="<?= base_url('configuracion/establecimientos') ?>">Volver a Establecimientos Activos</a>
    <table class="table table-striped table-hover text-center tabla-datos">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cuartel</th>
                <th>Fecha de Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($establecimientos as $establecimiento): ?>
                <tr>
                    <td><?= esc($establecimiento['nombre']) ?></td>
                    <td><?= esc($establecimiento['cuartel']) ?></td>
                    <td><?= esc($establecimiento['fecha_borrado']) ?></td>
                    <td><a href="<?= base_url('configuracion/establecimientos/recuperar/' . $establecimiento['id']) ?>">Recuperar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>