<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Nuevo Factor</h2>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('factores/insertar') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="denominacion" class="form-label">Denominación</label>
                            <input type="text" class="form-control" id="denominacion" name="denominacion" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" required>
                                <option value="" disabled selected>Seleccione un tipo</option>
                                <option value="Riesgo">Riesgo</option>
                                <option value="Proteccion">Protección</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Formulario</label>
                            <select class="form-select" name="tipo_formulario" required>
                                <option value="" disabled selected>Seleccione un formulario</option>
                                <option value="TAL">TAL</option>
                                <option value="WDF">WDF</option>
                                <option value="Ambos">Ambos</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('factores') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Factor</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
