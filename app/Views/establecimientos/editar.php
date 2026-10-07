<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0"><i class="bi bi-pencil-square me-2"></i><?= esc($titulo) ?></h2>
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

                    <form action="<?= base_url('configuracion/establecimientos/actualizar') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($establecimiento['id']) ?>">
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-semibold">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?= esc($establecimiento['nombre']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cuartel" class="form-label fw-semibold">Cuartel</label>
                            <select class="form-select" name="cuartel" id="cuartel" required>
                                <option value="Primer Cuartel" <?= $establecimiento['cuartel'] === 'Primer Cuartel' ? 'selected' : '' ?>>
                                    Primer Cuartel
                                </option>
                                <option value="Segundo Cuartel" <?= $establecimiento['cuartel'] === 'Segundo Cuartel' ? 'selected' : '' ?>>
                                    Segundo Cuartel
                                </option>
                                <option value="Tercer Cuartel" <?= $establecimiento['cuartel'] === 'Tercer Cuartel' ? 'selected' : '' ?>>
                                    Tercer Cuartel
                                </option>
                                <option value="Cuarto Cuartel" <?= $establecimiento['cuartel'] === 'Cuarto Cuartel' ? 'selected' : '' ?>>
                                    Cuarto Cuartel
                                </option>
                                <option value="Quinto Cuartel" <?= $establecimiento['cuartel'] === 'Quinto Cuartel' ? 'selected' : '' ?>>
                                    Quinto Cuartel
                                </option>
                                <option value="Zona Abadía y Barrio Arenal" <?= $establecimiento['cuartel'] === 'Zona Abadía y Barrio Arenal' ? 'selected' : '' ?>>
                                    Zona Abadía y Barrio Arenal
                                </option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tipo" class="form-label fw-semibold">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo" required>
                                <option value="CAPS" <?= $establecimiento['tipo'] === 'CAPS' ? 'selected' : '' ?>>
                                    CAPS
                                </option>
                                <option value="Hospital" <?= $establecimiento['tipo'] === 'Hospital' ? 'selected' : '' ?>>
                                    Hospital
                                </option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('configuracion/establecimientos') ?>" class="btn btn-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4 fw-semibold">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>