<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Listado de Tutores</h2>
    <div>
        <a href="<?= base_url('tutor/eliminados') ?>" class="btn btn-danger">Ver Papelera</a>
    </div>
</div>
<table class="table table-striped bg-white shadow-sm text-center tabla-datos">
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre Completo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tutores as $tutor): ?>
            <tr>
                <td><?= $tutor['dni'] ?></td>
                <td><?= $tutor['nombre'] ?></td>
                <td><?= $tutor['telefono'] ?></td>
                <td>
                    <a href="<?= base_url('tutor/editar/'.$tutor['id']) ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="<?= base_url('tutor/borrar/'.$tutor['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este tutor?');">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>