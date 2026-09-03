<div class="card shadow-sm mt-2">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Editar Datos del Tutor</h4>
    </div>
    <div class="card-body">
        <form action="<?= base_url('tutor/actualizar/'.$tutor['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="number" class="form-control" name="dni" value="<?= $tutor['dni'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" name="nombre" value="<?= $tutor['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?= $tutor['telefono'] ?>" required>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('tutor') ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-warning">Actualizar Datos</button>
            </div>
        </form>
    </div>
</div>