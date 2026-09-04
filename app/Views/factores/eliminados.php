<div class="container mt-5">
    <h2 class="mb-4 text-danger">Factores Eliminados (Inactivos)</h2>
    <a href="<?= base_url('factores') ?>" class="btn btn-secondary mb-3">Volver a Factores Activos</a>

    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Denominación</th>
                <th>Tipo</th>
                <th>Fecha de Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($factores as $factor): ?>
                <tr>
                    <td><?= esc($factor['denominacion']) ?></td>
                    <td><?= esc($factor['tipo']) ?></td>
                    <td><?= esc($factor['fecha_borrado']) ?></td>
                    <td>
                        <a href="<?= base_url('factores/recuperar/'.$factor['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
