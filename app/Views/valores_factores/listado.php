<div class="container mt-5">
    <h2 class="mb-1">Valores de: <?= esc($factor['denominacion']) ?></h2>
    <p class="text-muted">Tipo: <?= esc($factor['tipo']) ?> — Formulario: <?= esc($factor['tipo_formulario']) ?></p>

    <a href="<?= base_url('factores/valores/nuevo/'.$factor['id']) ?>" class="btn btn-primary mb-3">+ Nuevo Valor</a>
    <a href="<?= base_url('factores') ?>" class="btn btn-secondary mb-3">Volver a Factores</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Valor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($valores as $valor): ?>
                        <tr>
                            <td><?= esc($valor['valor']) ?></td>
                            <td>
                                <a href="<?= base_url('valores-factores/editar/'.$valor['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= base_url('valores-factores/eliminar/'.$valor['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este valor?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
