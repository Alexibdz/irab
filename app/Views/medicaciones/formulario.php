<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h2 class="h5 mb-0"><?= esc($titulo) ?></h2>
        </div>
        <form action="<?= base_url(isset($medicacion) ? 'configuracion/medicaciones/actualizar' : 'configuracion/medicaciones/insertar') ?>"
              method="post">
            <?= csrf_field() ?>
            <?php if (isset($medicacion)): ?>
                <input type="hidden" name="id" value="<?= esc($medicacion['id']) ?>">
            <?php endif; ?>

            <div class="card-body">
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <label for="nombre" class="form-label">Nombre de la medicación</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                       maxlength="100" value="<?= esc(old('nombre', $medicacion['nombre'] ?? '')) ?>" required>
            </div>

            <div class="card-footer text-end">
                <a href="<?= base_url('configuracion/medicaciones') ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
