<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-3">Listado de Factores</h2>
        <div class="d-flex gap-2">
            <a href="<?= base_url('configuracion/factores/nuevo') ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i> Nuevo Factor
            </a>
            <a href="<?= base_url('configuracion/factores/eliminados') ?>" class="btn btn-danger fw-semibold">
              Factores Eliminados
            </a>
        </div>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">Denominación</th>
                            <th class="text-center align-middle">Tipo</th>
                            <th class="text-center align-middle">Tipo de Formulario</th>
                            <th class="text-center align-middle" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($factores as $factor): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($factor['denominacion']) ?></td>
                                <td class="text-center align-middle"><?= esc($factor['tipo']) ?></td>
                                <td class="text-center align-middle"><?= esc($factor['tipo_formulario']) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <a href="<?= base_url('configuracion/factores/ver/' . $factor['id']) ?>" 
                                           class="btn btn-info btn-sm text-white" 
                                           title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="<?= base_url('configuracion/factores/valores/' . $factor['id']) ?>" 
                                           class="btn btn-primary btn-sm text-white" 
                                           title="Valores del factor">
                                            <i class="bi bi-bar-chart-line"></i> Valores
                                        </a>

                                        <a href="<?= base_url('configuracion/factores/editar/' . $factor['id']) ?>" 
                                           class="btn btn-warning btn-sm text-dark" 
                                           title="Editar factor">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= base_url('configuracion/factores/eliminar/' . $factor['id']) ?>" 
                                           class="btn btn-danger btn-sm text-white" 
                                           onclick="return confirm('¿Seguro que deseas borrar este factor?');" 
                                           title="Eliminar factor">
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