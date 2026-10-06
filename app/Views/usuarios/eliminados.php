<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal text-danger mb-3"><?= esc($titulo) ?></h2>
        <a href="<?= base_url('configuracion/usuarios') ?>" class="btn btn-secondary fw-semibold">
            <i class="bi bi-arrow-left"></i> Volver a Usuarios Activos
        </a>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">Nombre</th>
                            <th class="text-center align-middle">Usuario</th>
                            <th class="text-center align-middle">Fecha de Borrado</th>
                            <th class="text-center align-middle" style="width: 130px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($usuario['nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($usuario['username']) ?></td>
                                <td class="text-center align-middle"><?= esc($usuario['fecha_borrado']) ?></td>
                                <td class="text-center align-middle">
                                    <a href="<?= base_url('configuracion/usuarios/recuperar/' . $usuario['id']) ?>" 
                                       class="btn btn-success btn-sm text-white" 
                                       title="Recuperar usuario">
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