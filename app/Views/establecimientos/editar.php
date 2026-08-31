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
            <input type="text" name="cuartel" id="cuartel" value="<?= esc($establecimiento['cuartel']) ?>">
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