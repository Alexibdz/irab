<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h2 class="h4 mb-0">Editar Valor - <?= esc($factor['denominacion']) ?></h2>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('valores-factores/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $valor['id'] ?>">
                        <input type="hidden" name="id_factor" value="<?= $valor['id_factor'] ?>">

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="valor" name="valor" value="<?= esc($valor['valor']) ?>" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('factores/valores/'.$valor['id_factor']) ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Actualizar Valor</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
