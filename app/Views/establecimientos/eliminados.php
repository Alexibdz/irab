<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal text-danger mb-3"><?= esc($titulo) ?></h2>
        <a href="<?= base_url('configuracion/establecimientos') ?>" class="btn btn-secondary fw-semibold">
            <i class="bi bi-arrow-left"></i> Volver a Establecimientos Activos
        </a>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">Nombre</th>
                            <th class="text-center align-middle">Cuartel</th>
                            <th class="text-center align-middle">Fecha de Borrado</th>
                            <th class="text-center align-middle" style="width: 130px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($establecimientos as $establecimiento): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($establecimiento['nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($establecimiento['cuartel']) ?></td>
                                <td class="text-center align-middle"><?= esc($establecimiento['fecha_borrado']) ?></td>
                                <td class="text-center align-middle">
                                    <a href="<?= base_url('configuracion/establecimientos/recuperar/' . $establecimiento['id']) ?>" 
                                       class="btn btn-success btn-sm text-white" 
                                       title="Recuperar establecimiento">
                                        <i class="bi bi-arrow-counterclockwise"></i> Recuperar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>