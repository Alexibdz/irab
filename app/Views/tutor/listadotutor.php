<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-3">Listado de Tutores</h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('visitas/crear') ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i> Nuevo Tutor
            </a>
            <a href="<?= base_url('tutor/eliminados') ?>" class="btn btn-danger fw-semibold">
                Ver Papelera
            </a>
        </div>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">DNI</th>
                            <th class="text-center align-middle">Nombre Completo</th>
                            <th class="text-center align-middle">Teléfono</th>
                            <th class="text-center align-middle" style="width: 130px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tutores as $tutor): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($tutor['dni']) ?></td>
                                <td class="text-center align-middle"><?= esc($tutor['nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($tutor['telefono']) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <a href="<?= base_url('tutor/editar/' . $tutor['id']) ?>" 
                                           class="btn btn-warning btn-sm text-dark" 
                                           title="Editar tutor">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('tutor/borrar/' . $tutor['id']) ?>" 
                                           class="btn btn-danger btn-sm text-white" 
                                           onclick="return confirm('¿Seguro que deseas borrar este tutor?');" 
                                           title="Borrar tutor">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>