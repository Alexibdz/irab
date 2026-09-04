<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h2 class="h4 mb-0">Editar Sintoma</h2>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('sintomas/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>

                        <input type="hidden" name="id" value="<?= $sintoma['id'] ?>">

                        <div class="mb-3">
                            <label for="nombre_sintoma" class="form-label">Nombre del Sintoma</label>
                            <input type="text" class="form-control" id="nombre_sintoma" name="nombre_sintoma" value="<?= esc($sintoma['nombre_sintoma']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Formulario</label>
                            <select class="form-select" name="tipo_formulario" required>
                                <option value="TAL" <?= ($sintoma['tipo_formulario'] == 'TAL') ? 'selected' : '' ?>>TAL</option>
                                <option value="WDF" <?= ($sintoma['tipo_formulario'] == 'WDF') ? 'selected' : '' ?>>WDF</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('sintomas') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Actualizar Sintoma</button>
                        </div>

                    </form>

                    <hr>

                    <h3 class="h5">Valores y Puntos</h3>
                    <?php if (empty($valores)): ?>
                        <p class="text-muted">Todavía no tiene valores cargados.</p>
                    <?php else: ?>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Valor Mínimo</th>
                                    <th>Valor Máximo</th>
                                    <th>Valor Texto</th>
                                    <th>Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($valores as $valor): ?>
                                    <tr>
                                        <td><?= esc($valor['valor_min'] ?? '-') ?></td>
                                        <td><?= esc($valor['valor_max'] ?? '-') ?></td>
                                        <td><?= esc($valor['valor_texto'] ?? '-') ?></td>
                                        <td><?= esc($valor['puntos']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <a href="<?= base_url('sintomas/valores/'.$sintoma['id']) ?>" class="btn btn-primary btn-sm">Gestionar Valores</a>

                </div>
            </div>

        </div>
    </div>
</div>
