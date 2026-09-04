<div class="container mt-5">
    <h2 class="mb-4 text-danger">Sintomas Eliminados (Inactivos)</h2>
    <a href="<?= base_url('sintomas') ?>" class="btn btn-secondary mb-3">Volver a Sintomas Activos</a>

    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nombre del Sintoma</th>
                <th>Tipo de Formulario</th>
                <th>Fecha de Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sintomas as $sintoma): ?>
                <tr>
                    <td><?= esc($sintoma['nombre_sintoma']) ?></td>
                    <td><?= esc($sintoma['tipo_formulario']) ?></td>
                    <td><?= esc($sintoma['fecha_borrado']) ?></td>
                    <td>
                        <a href="<?= base_url('sintomas/recuperar/'.$sintoma['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
