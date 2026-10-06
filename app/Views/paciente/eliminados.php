<div class="container mt-5">
    <h2 class="mb-4 text-danger">Pacientes Eliminados (Inactivos)</h2>
    <a href="<?= base_url('paciente') ?>" class="btn btn-secondary mb-3">Volver a Pacientes Activos</a>
    
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
            <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td class="text-center align-middle"><?= $paciente['dni'] ?></td>
                    <td class="text-center align-middle"><?= $paciente['nombre'] ?></td>
                    <td class="text-center align-middle"><?= $paciente['fecha_borrado'] ?></td>
                    <td class="text-center align-middle">
                        <a href="<?= base_url('paciente/recuperar/'.$paciente['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
