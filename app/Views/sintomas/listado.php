<div class="container mt-5">
    <h2 class="mb-4">Listado de Sintomas</h2>

    <a href="<?= base_url('sintomas/nuevo') ?>" class="btn btn-primary mb-3">+ Nuevo Sintoma</a>
    <a href="<?= base_url('sintomas/eliminados') ?>" class="btn btn-danger mb-3">Ver Sintomas Eliminados</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover text-center tabla-datos">
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
                                <a href="<?= base_url('sintomas/ver/'.$sintoma['id']) ?>" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= base_url('sintomas/valores/'.$sintoma['id']) ?>" class="btn btn-primary btn-sm" title="Ver sintomas">
                                    <i class="bi bi-bar-chart"></i>
                                </a>
                                <a href="<?= base_url('sintomas/editar/'.$sintoma['id']) ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= base_url('sintomas/eliminar/'.$sintoma['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este sintoma?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
