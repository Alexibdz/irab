<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('establecimientos/insertar'); ?>" method="post"> <?= csrf_field() ?>
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div>
            <label for="cuartel">Cuartel</label>
            <input type="text" name="cuartel" id="cuartel">
        </div>
        <div>
            <label for="tipo">Tipo</label>
            <select name="tipo" id="tipo" required>
                <option value="">Seleccione un tipo</option>
                <option value="CAPS">CAPS</option>
                <option value="Hospital">Hospital</option>
            </select>
        </div>
        <button type="submit">Guardar</button>
        <a href="<?php echo base_url('establecimientos'); ?>">Cancelar</a>
    </form>
</div>