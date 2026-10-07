<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0">Nuevo Sintoma</h2>
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
                    <form action="<?= base_url('configuracion/sintomas/insertar') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nombre_sintoma" class="form-label">Nombre del Sintoma</label>
                            <input type="text" class="form-control" id="nombre_sintoma" name="nombre_sintoma" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Formulario</label>
                            <select class="form-select" name="tipo_formulario" required>
                                <option value="" disabled selected>Seleccione un formulario</option>
                                <option value="TAL">TAL</option>
                                <option value="WDF">WDF</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('configuracion/sintomas') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Sintoma</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
