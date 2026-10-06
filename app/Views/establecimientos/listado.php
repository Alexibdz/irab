<div class="container-fluid py-3">
    <div class="mb-3">
        <h2 class=" mb-3"><?= esc($titulo) ?></h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('establecimientos/nuevo'); ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i>  Nuevo Establecimiento
            </a>
            <a href="<?= base_url('establecimientos/eliminados'); ?>" class="btn btn-danger fw-semibold">
                Ver Papelera
            </a>
        </div>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover text-center tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Cuartel</th>
                            <th>Tipo</th>
                            <th class="text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($establecimientos as $establecimiento): ?>
                            <tr>
                                <td><?= esc($establecimiento['nombre']) ?></td>
                                <td><?= esc($establecimiento['cuartel']) ?></td>
                                <td><?= esc($establecimiento['tipo']) ?></td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <a href="<?= base_url('establecimientos/ver/' . $establecimiento['id']); ?>" 
                                           class="btn btn-info btn-sm text-white" 
                                           title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="<?= base_url('establecimientos/editar/' . $establecimiento['id']); ?>" 
                                           class="btn btn-warning btn-sm text-white" 
                                           title="Editar establecimiento">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= base_url('establecimientos/eliminar/' . $establecimiento['id']); ?>" 
                                           onclick="return confirm('¿Deseas eliminar este establecimiento?');" 
                                           class="btn btn-danger btn-sm text-white" 
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