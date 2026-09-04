<div class="container mt-5">
    <h2 class="mb-4">Listado de Sintomas</h2>

    <a href="<?= base_url('sintomas/nuevo') ?>" class="btn btn-primary mb-3">+ Nuevo Sintoma</a>
    <a href="<?= base_url('sintomas/eliminados') ?>" class="btn btn-danger mb-3">Ver Sintomas Eliminados</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre del Sintoma</th>
                        <th>Tipo de Formulario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sintomas as $sintoma): ?>
                        <tr>
                            <td><?= esc($sintoma['nombre_sintoma']) ?></td>
                            <td><?= esc($sintoma['tipo_formulario']) ?></td>
                            <td>
                                <a href="<?= base_url('sintomas/ver/'.$sintoma['id']) ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="<?= base_url('sintomas/editar/'.$sintoma['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= base_url('sintomas/eliminar/'.$sintoma['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este sintoma?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
