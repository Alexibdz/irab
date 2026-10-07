<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h2 class="h4 mb-0"><?= esc($titulo) ?>: <?= esc($rol['nombre']) ?></h2>
        </div>
        <div class="card-body">
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('configuracion/usuarios/permisos/actualizar') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_usuario" value="<?= esc($usuario['id']) ?>">
                <input type="hidden" name="id_rol" value="<?= esc($rol['id']) ?>">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Módulo</th>
                                <?php foreach ($acciones as $etiqueta): ?>
                                    <th class="text-center"><?= esc($etiqueta) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $numero = 1; ?>
                            <?php foreach ($modulos as $clave => $nombre): ?>
                                <tr>
                                    <td><?= $numero++ ?></td>
                                    <td><?= esc($nombre) ?></td>
                                    <?php foreach ($acciones as $accion => $etiqueta): ?>
                                        <td class="text-center">
                                            <?php
                                            $campo = 'puede_' . $accion;
                                            $marcado = !empty($actuales[$clave][$campo]);
                                            ?>
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" role="switch" name="permisos[<?= esc($clave) ?>][<?= $accion ?>]" value="1" <?= $marcado ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Guardar
                    </button>
                    <a href="<?= base_url('configuracion/usuarios') ?>" class="btn btn-danger">
                        <i class="bi bi-box-arrow-left"></i>
                        Salir
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>