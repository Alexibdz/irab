<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Visitas Eliminadas</h2>

        <a href="<?= base_url('visitas') ?>"
           class="btn btn-secondary">
            Volver a Visitas
        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <?php if (empty($visitas)): ?>

                <div class="alert alert-info mb-0">
                    No hay visitas eliminadas.
                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table table-striped table-hover align-middle">

                        <thead>
                            <tr>

                                <th>Paciente</th>
                                <th>Usuario</th>
                                <th>Establecimiento</th>
                                <th>Fecha de ingreso</th>
                                <th>Diagnóstico</th>
                                <th>Estado</th>
                                <th>Fecha de eliminación</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($visitas as $visita): ?>

                                <tr>

                                    <td>
                                        <?= esc($visita['paciente'] ?? 'Sin información') ?>
                                    </td>

                                    <td>
                                        <?= esc($visita['usuario'] ?? 'Sin información') ?>
                                    </td>

                                    <td>
                                        <?= esc($visita['establecimiento'] ?? 'Sin información') ?>
                                    </td>

                                    <td>
                                        <?= esc($visita['fecha_ingreso']) ?>
                                    </td>

                                    <td>
                                        <?= esc($visita['diagnostico']) ?>
                                    </td>

                                    <td>
                                        <?= esc($visita['estado_derivacion']) ?>
                                    </td>

                                    <td>
                                        <?= esc($visita['fecha_borrado']) ?>
                                    </td>

                                    <td>

                                        <a href="<?= base_url('visitas/recuperar/' . $visita['id']) ?>"
                                           class="btn btn-success btn-sm"
                                           onclick="return confirm('¿Desea recuperar esta visita?');">
                                            Recuperar
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>