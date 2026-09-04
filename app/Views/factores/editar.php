<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h2 class="h4 mb-0">Editar Factor</h2>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('factores/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>

                        <input type="hidden" name="id" value="<?= $factor['id'] ?>">

                        <div class="mb-3">
                            <label for="denominacion" class="form-label">Denominación</label>
                            <input type="text" class="form-control" id="denominacion" name="denominacion" value="<?= esc($factor['denominacion']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" required>
                                <option value="Riesgo" <?= ($factor['tipo'] == 'Riesgo') ? 'selected' : '' ?>>Riesgo</option>
                                <option value="Proteccion" <?= ($factor['tipo'] == 'Proteccion') ? 'selected' : '' ?>>Protección</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Formulario</label>
                            <select class="form-select" name="tipo_formulario" required>
                                <option value="TAL" <?= ($factor['tipo_formulario'] == 'TAL') ? 'selected' : '' ?>>TAL</option>
                                <option value="WDF" <?= ($factor['tipo_formulario'] == 'WDF') ? 'selected' : '' ?>>WDF</option>
                                <option value="Ambos" <?= ($factor['tipo_formulario'] == 'Ambos') ? 'selected' : '' ?>>Ambos</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('factores') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Actualizar Factor</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
