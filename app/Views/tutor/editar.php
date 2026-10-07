<div class="card shadow-sm mt-2">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Editar Datos del Tutor</h4>
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

        <form action="<?= base_url('tutor/actualizar/'. esc($tutor['id'])) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="number" class="form-control" name="dni" value="<?= esc($tutor['dni']) ?>" required>
                <div class="form-text text-muted">
                    Ingrese el número sin puntos ni espacios
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" name="nombre" value="<?= esc($tutor['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?= esc($tutor['telefono']) ?>" required>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('tutor') ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>
</div>