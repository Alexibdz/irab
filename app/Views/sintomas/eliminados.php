<div class="container mt-5">
    <h2 class="mb-4 text-danger">Sintomas Eliminados (Inactivos)</h2>
    <a href="<?= base_url('configuracion/sintomas') ?>" class="btn btn-secondary mb-3">Volver a Sintomas Activos</a>

    <table class="table table-bordered bg-white shadow-sm text-center tabla-datos">
        <thead>
            <tr>
                <th class="text-center align-middle">Nombre del Sintoma</th>
                <th class="text-center align-middle">Tipo de Formulario</th>
                <th class="text-center align-middle">Fecha de Borrado</th>
                <th class="text-center align-middle">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sintomas as $sintoma): ?>
                <tr>
                    <td class="text-center align-middle"><?= esc($sintoma['nombre_sintoma']) ?></td>
                    <td class="text-center align-middle"><?= esc($sintoma['tipo_formulario']) ?></td>
                    <td class="text-center align-middle"><?= esc($sintoma['fecha_borrado']) ?></td>
                    <td class="text-center align-middle">
                        <a href="<?= base_url('configuracion/sintomas/recuperar/'.$sintoma['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
