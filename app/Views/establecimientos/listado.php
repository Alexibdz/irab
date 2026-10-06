<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-3"><?= esc($titulo) ?></h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('configuracion/establecimientos/nuevo'); ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i> Nuevo Establecimiento
            </a>
            <a href="<?= base_url('configuracion/establecimientos/eliminados'); ?>" class="btn btn-danger fw-semibold">
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
                            <th class="text-center align-middle">Nombre</th>
                            <th class="text-center align-middle">Cuartel</th>
                            <th class="text-center align-middle">Tipo</th>
                            <th class="text-center align-middle" style="width: 130px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($establecimientos as $establecimiento): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($establecimiento['nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($establecimiento['cuartel']) ?></td>
                                <td class="text-center align-middle"><?= esc($establecimiento['tipo']) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-inline-flex gap-1 justify-content-center">

                                        <a href="<?= base_url('configuracion/establecimientos/editar/' . $establecimiento['id']); ?>" 
                                           class="btn btn-warning btn-sm text-dark" 
                                           title="Editar establecimiento">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= base_url('configuracion/establecimientos/eliminar/' . $establecimiento['id']); ?>" 
                                           class="btn btn-danger btn-sm text-white" 
                                           onclick="return confirm('¿Deseas eliminar este establecimiento?');" 
                                           title="Eliminar establecimiento">
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