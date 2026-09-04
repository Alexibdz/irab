<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h2 class="h4 mb-0">Ver Sintoma</h2>
                </div>

                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nombre del Sintoma</dt>
                        <dd class="col-sm-8"><?= esc($sintoma['nombre_sintoma']) ?></dd>

                        <dt class="col-sm-4">Tipo de Formulario</dt>
                        <dd class="col-sm-8"><?= esc($sintoma['tipo_formulario']) ?></dd>
                    </dl>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="<?= base_url('sintomas') ?>" class="btn btn-secondary">Volver</a>
                        <a href="<?= base_url('sintomas/editar/'.$sintoma['id']) ?>" class="btn btn-warning">Editar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
