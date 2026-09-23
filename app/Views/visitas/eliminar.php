<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <div class="card-header bg-danger text-white">
                    <h2 class="h4 mb-0">Eliminar Visita</h2>
                </div>

                <div class="card-body text-center">

                    <h5 class="mb-3">
                        ¿Está seguro de que desea eliminar esta visita?
                    </h5>

                    <p class="text-muted">
                        La visita no será eliminada definitivamente.
                        Podrá recuperarla desde "Visitas Eliminadas".
                    </p>

                    <hr>

                    <p>
                        <strong>Paciente:</strong>
                        <?= esc($visita['paciente'] ?? 'Sin información') ?>
                    </p>

                    <p>
                        <strong>Fecha de ingreso:</strong>
                        <?= esc($visita['fecha_ingreso'] ?? '') ?>
                    </p>

                    <div class="d-flex justify-content-center gap-2 mt-4">

                        <a href="<?= base_url('visitas') ?>"
                           class="btn btn-secondary">
                            Cancelar
                        </a>

                        <form action="<?= base_url('visitas/') ?>"
                              method="POST">

                            <?= csrf_field() ?>

                            <button type="submit" class="btn btn-danger">
                                Sí, eliminar
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>