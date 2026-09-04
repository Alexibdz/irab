<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Nuevo Valor - <?= esc($factor['denominacion']) ?></h2>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('valores-factores/insertar') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_factor" value="<?= $factor['id'] ?>">

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="valor" name="valor" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('factores/valores/'.$factor['id']) ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Valor</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
