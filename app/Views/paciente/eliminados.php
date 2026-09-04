<div class="container mt-5">
    <h2 class="mb-4 text-danger">Pacientes Eliminados (Inactivos)</h2>
    <a href="<?= base_url('paciente') ?>" class="btn btn-secondary mb-3">Volver a Pacientes Activos</a>
    
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
            <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?= $paciente['dni'] ?></td>
                    <td><?= $paciente['nombre'] ?></td>
                    <td><?= $paciente['fecha_borrado'] ?></td>
                    <td>
                        <a href="<?= base_url('paciente/recuperar/'.$paciente['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
