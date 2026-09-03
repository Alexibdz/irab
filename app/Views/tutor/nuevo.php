<div class="card shadow-sm mt-2">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Nuevo Responsable</h4>
    </div>
    <div class="card-body">
        <form action="<?= base_url('tutor/insertar') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="number" class="form-control" name="dni" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" required>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('tutor') ?>" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>