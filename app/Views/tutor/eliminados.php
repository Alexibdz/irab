<h2 class="mb-4 text-danger">Tutores Inactivos (Papelera)</h2>
<a href="<?= base_url('tutor') ?>" class="btn btn-secondary mb-3">Volver a Tutores Activos</a>

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>DNI</th>
            <th>Nombre Completo</th>
            <th>Fecha de Borrado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tutores as $tutor): ?>
            <tr>
                <td><?= $tutor['dni'] ?></td>
                <td><?= $tutor['nombre'] ?></td>
                <td><?= $tutor['fecha_borrado'] ?></td>
                <td>
                    <a href="<?= base_url('tutor/recuperar/'.$tutor['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>