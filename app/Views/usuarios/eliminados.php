<div>
    <h2><?= esc($titulo) ?></h2>
    <a href="<?= base_url('usuarios') ?>">Volver a Usuarios Activos</a>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Fecha de Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= esc($usuario['nombre']) ?></td>
                    <td><?= esc($usuario['username']) ?></td>
                    <td><?= esc($usuario['fecha_borrado']) ?></td>
                    <td><a href="<?= base_url('usuarios/recuperar/' . $usuario['id']) ?>">Recuperar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>