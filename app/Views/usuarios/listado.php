<div>
    <div>
        <h2><?= esc($titulo) ?></h2>
        <a href="<?php echo base_url('usuarios/nuevo'); ?>">Nuevo Usuario</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Establecimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= esc($usuario['nombre']) ?></td>
                    <td><?= esc($usuario['username']) ?></td>
                    <td><?= esc($usuario['rol_nombre']) ?></td>
                    <td><?= esc($usuario['establecimiento_nombre']) ?></td>
                    <td>
                        <!--<a class="" href="<?php echo base_url('usuarios/borrar/' . $usuario["id"]); ?>">Eliminar</a>-->
                        <a href="<?php echo base_url('usuarios/editar/' . $usuario["id"]); ?>">Editar</a>
                        <a href="<?php echo base_url('usuarios/ver/' . $usuario["id"]); ?>">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
