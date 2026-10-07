<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0">Nuevo Valor - <?= esc($factor['denominacion']) ?></h2>
                </div>

                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger mb-4 shadow-sm">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('configuracion/valores-factores/insertar') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_factor" value="<?= esc($factor['id']) ?>">

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="valor" name="valor" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('configuracion/factores/valores/'.esc($factor['id'])) ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Valor</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
