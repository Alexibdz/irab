<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h2 class="h4 mb-0">Ver Factor</h2>
                </div>

                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Denominación</dt>
                        <dd class="col-sm-8"><?= esc($factor['denominacion']) ?></dd>

                        <dt class="col-sm-4">Tipo</dt>
                        <dd class="col-sm-8"><?= esc($factor['tipo']) ?></dd>

                        <dt class="col-sm-4">Tipo de Formulario</dt>
                        <dd class="col-sm-8"><?= esc($factor['tipo_formulario']) ?></dd>
                    </dl>

                    <hr>

                    <h3 class="h5">Valores</h3>
                    <?php if (empty($valores)): ?>
                        <p class="text-muted">Todavía no tiene valores cargados.</p>
                    <?php else: ?>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($valores as $valor): ?>
                                    <tr>
                                        <td><?= esc($valor['valor']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="<?= base_url('factores') ?>" class="btn btn-secondary">Volver</a>
                        <a href="<?= base_url('factores/valores/'.$factor['id']) ?>" class="btn btn-primary">Gestionar Valores</a>
                        <a href="<?= base_url('factores/editar/'.$factor['id']) ?>" class="btn btn-warning">Editar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
