<div>
    <h2><?= esc($titulo) ?></h2>
    <form action="<?php echo base_url('establecimientos/insertar'); ?>" method="post"> <?= csrf_field() ?>
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div>
            <label for="cuartel">Cuartel</label>
            <select name="cuartel" id="cuartel" required>
                <option value="">Seleccione un cuartel</option>
                <option value="Primer Cuartel">Primer Cuartel</option>
                <option value="Segundo Cuartel">Segundo Cuartel</option>
                <option value="Tercer Cuartel">Tercer Cuartel</option>
                <option value="Cuarto Cuartel">Cuarto Cuartel</option>
                <option value="Quinto Cuartel">Quinto Cuartel</option>
                <option value="Zona Abadía y Barrio Arenal">Zona Abadía y Barrio Arenal</option>
            </select>
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