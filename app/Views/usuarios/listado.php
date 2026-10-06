<div class="container-fluid py-3">
    <div class="mb-3">
        <h2 class=" mb-3"><?= esc($titulo) ?></h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('usuarios/nuevo'); ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i>  Nuevo Usuario
            </a>
            <a href="<?= base_url('usuarios/eliminados'); ?>" class="btn btn-danger fw-semibold">
                Ver Papelera
            </a>
        </div>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Establecimiento</th>
                            <th class="text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= esc($usuario['nombre']) ?></td>
                                <td><?= esc($usuario['username']) ?></td>
                                <td><?= esc($usuario['rol_nombre']) ?></td>
                                <td><?= esc($usuario['establecimiento_nombre']) ?></td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <!-- Ver -->
                                        <a href="<?= base_url('usuarios/ver/' . $usuario['id']); ?>" 
                                           class="btn btn-info btn-sm text-white" 
                                           title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Editar -->
                                        <a href="<?= base_url('usuarios/editar/' . $usuario['id']); ?>" 
                                           class="btn btn-warning btn-sm text-white" 
                                           title="Editar usuario">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Eliminar -->
                                        <a href="<?= base_url('usuarios/eliminar/' . $usuario['id']); ?>" 
                                           onclick="return confirm('¿Deseas eliminar este usuario?');" 
                                           class="btn btn-danger btn-sm text-white" 
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