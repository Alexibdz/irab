<h2 class="mb-4 text-danger">Tutores Inactivos (Papelera)</h2>
<a href="<?= base_url('tutor') ?>" class="btn btn-secondary mb-3">Volver a Tutores Activos</a>

<table class="table table-bordered bg-white shadow-sm text-center tabla-datos">
    <thead>
        <tr>
            <th class="text-center align-middle">DNI</th>
            <th class="text-center align-middle">Nombre Completo</th>
            <th class="text-center align-middle">Fecha de Borrado</th>
            <th class="text-center align-middle">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tutores as $tutor): ?>
            <tr>
                <td class="text-center align-middle"><?= $tutor['dni'] ?></td>
                <td class="text-center align-middle"><?= $tutor['nombre'] ?></td>
                <td class="text-center align-middle"><?= $tutor['fecha_borrado'] ?></td>
                <td class="text-center align-middle">
                    <a href="<?= base_url('tutor/recuperar/'.$tutor['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>