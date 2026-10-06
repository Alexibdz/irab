<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-3"><?= esc($titulo) ?></h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('configuracion/usuarios/nuevo'); ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i> Nuevo Usuario
            </a>
            <a href="<?= base_url('configuracion/usuarios/eliminados'); ?>" class="btn btn-danger fw-semibold">
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
                            <th class="text-center align-middle">Usuario</th>
                            <th class="text-center align-middle">Rol</th>
                            <th class="text-center align-middle">Establecimiento</th>
                            <th class="text-center align-middle" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($usuario['nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($usuario['username']) ?></td>
                                <td class="text-center align-middle"><?= esc($usuario['rol_nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($usuario['establecimiento_nombre']) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <a href="<?= base_url('configuracion/usuarios/editar/' . $usuario["id"]); ?>" 
                                           class="btn btn-warning btn-sm text-dark" 
                                           title="Editar usuario">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= base_url('configuracion/usuarios/eliminar/' . $usuario['id']); ?>" 
                                           class="btn btn-danger btn-sm text-white" 
                                           onclick="return confirm('¿Deseas eliminar este usuario?');" 
                                           title="Eliminar usuario">
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