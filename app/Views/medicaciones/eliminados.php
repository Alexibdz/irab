<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-3">Medicaciones eliminadas</h2>
        <a href="<?= base_url('configuracion/medicaciones') ?>" class="btn btn-secondary">Volver al catálogo</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de eliminación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicaciones as $medicacion): ?>
                            <tr>
                                <td><?= esc($medicacion['nombre']) ?></td>
                                <td><?= esc($medicacion['fecha_borrado']) ?></td>
                                <td>
                                    <a href="<?= base_url('configuracion/medicaciones/recuperar/' . $medicacion['id']) ?>"
                                       class="btn btn-success btn-sm">Recuperar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
