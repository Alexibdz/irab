<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Nuevo Valor - <?= esc($sintoma['nombre_sintoma']) ?></h2>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('valores-sintomas/insertar') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_sintoma" value="<?= $sintoma['id'] ?>">

                        <div class="mb-3">
                            <label for="valor_min" class="form-label">Valor Mínimo</label>
                            <input type="number" step="0.01" class="form-control" id="valor_min" name="valor_min">
                        </div>

                        <div class="mb-3">
                            <label for="valor_max" class="form-label">Valor Máximo</label>
                            <input type="number" step="0.01" class="form-control" id="valor_max" name="valor_max">
                        </div>

                        <div class="mb-3">
                            <label for="valor_texto" class="form-label">Valor Texto (para escalas descriptivas)</label>
                            <input type="text" class="form-control" id="valor_texto" name="valor_texto">
                        </div>

                        <div class="mb-3">
                            <label for="puntos" class="form-label">Puntos</label>
                            <input type="number" class="form-control" id="puntos" name="puntos" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('sintomas/valores/'.$sintoma['id']) ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Valor</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
