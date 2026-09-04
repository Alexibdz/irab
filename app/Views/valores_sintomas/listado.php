<div class="container mt-5">
    <h2 class="mb-1">Valores de: <?= esc($sintoma['nombre_sintoma']) ?></h2>
    <p class="text-muted">Tipo de formulario: <?= esc($sintoma['tipo_formulario']) ?></p>

    <a href="<?= base_url('sintomas/valores/nuevo/'.$sintoma['id']) ?>" class="btn btn-primary mb-3">+ Nuevo Valor</a>
    <a href="<?= base_url('sintomas') ?>" class="btn btn-secondary mb-3">Volver a Sintomas</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Valor Mínimo</th>
                        <th>Valor Máximo</th>
                        <th>Valor Texto</th>
                        <th>Puntos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($valores as $valor): ?>
                        <tr>
                            <td><?= esc($valor['valor_min'] ?? '-') ?></td>
                            <td><?= esc($valor['valor_max'] ?? '-') ?></td>
                            <td><?= esc($valor['valor_texto'] ?? '-') ?></td>
                            <td><?= esc($valor['puntos']) ?></td>
                            <td>
                                <a href="<?= base_url('valores-sintomas/editar/'.$valor['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= base_url('valores-sintomas/eliminar/'.$valor['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este valor?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
