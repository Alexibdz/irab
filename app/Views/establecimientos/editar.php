<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('establecimientos/actualizar'); ?>" method="post"> <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($establecimiento['id']) ?>">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= esc($establecimiento['nombre']) ?>" required>
        </div>
        <div>
            <label for="cuartel">Cuartel</label>
            <select name="cuartel" id="cuartel" required>
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
        <div>
            <label for="tipo">Tipo</label>
            <select name="tipo" id="tipo" required>
                <option value="CAPS" <?= $establecimiento['tipo'] === 'CAPS' ? 'selected' : '' ?>>
                    CAPS
                </option>
                <option value="Hospital" <?= $establecimiento['tipo'] === 'Hospital' ? 'selected' : '' ?>>
                    Hospital
                </option>
            </select>
        </div>
        <button type="submit">Actualizar</button>
        <a href="<?php echo base_url('establecimientos'); ?>">Cancelar</a>
    </form>
</div>