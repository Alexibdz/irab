<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Tutores</h2>
    <div>
        <a href="<?= base_url('tutor/nuevo') ?>" class="btn btn-primary">Registrar Tutor</a>
        <a href="<?= base_url('tutor/eliminados') ?>" class="btn btn-danger">Ver Papelera</a>
    </div>
</div>
<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-dark">
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
                    <a href="<?= base_url('tutor/editar/'.$tutor['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="<?= base_url('tutor/borrar/'.$tutor['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este tutor?');">Borrar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>