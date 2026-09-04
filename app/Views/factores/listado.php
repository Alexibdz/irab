<div class="container mt-5">
    <h2 class="mb-4">Listado de Factores</h2>

    <a href="<?= base_url('factores/nuevo') ?>" class="btn btn-primary mb-3">+ Nuevo Factor</a>
    <a href="<?= base_url('factores/eliminados') ?>" class="btn btn-danger mb-3">Ver Factores Eliminados</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Denominación</th>
                        <th>Tipo</th>
                        <th>Tipo de Formulario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($factores as $factor): ?>
                        <tr>
                            <td><?= esc($factor['denominacion']) ?></td>
                            <td><?= esc($factor['tipo']) ?></td>
                            <td><?= esc($factor['tipo_formulario']) ?></td>
                            <td>
                                <a href="<?= base_url('factores/ver/'.$factor['id']) ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="<?= base_url('factores/valores/'.$factor['id']) ?>" class="btn btn-primary btn-sm">Valores</a>
                                <a href="<?= base_url('factores/editar/'.$factor['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= base_url('factores/eliminar/'.$factor['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este factor?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
