<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0"><?= esc($titulo) ?></h2>
                </div>
                
                <div class="card-body">
                    <form action="<?= base_url('configuracion/establecimientos/insertar') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cuartel" class="form-label">Cuartel</label>
                            <select class="form-select" name="cuartel" id="cuartel" required>
                                <option value="" disabled selected>Seleccione un cuartel</option>
                                <option value="Primer Cuartel">Primer Cuartel</option>
                                <option value="Segundo Cuartel">Segundo Cuartel</option>
                                <option value="Tercer Cuartel">Tercer Cuartel</option>
                                <option value="Cuarto Cuartel">Cuarto Cuartel</option>
                                <option value="Quinto Cuartel">Quinto Cuartel</option>
                                <option value="Zona Abadía y Barrio Arenal">Zona Abadía y Barrio Arenal</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo" required>
                                <option value="" disabled selected>Seleccione un tipo</option>
                                <option value="CAPS">CAPS</option>
                                <option value="Hospital">Hospital</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('configuracion/establecimientos') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Establecimiento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>