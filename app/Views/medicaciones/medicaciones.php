    <div class="mt-3" id="bloque-medicaciones">
        <label class="form-label fw-bold text-success">Medicación administrada</label>

        <div id="lista-medicaciones"></div>

        <button type="button" class="btn btn-outline-success btn-sm" id="btn-agregar-medicacion">
            + Agregar medicación
        </button>
        <div class="form-text">Si no se administró ninguna medicación, dejá la lista vacía.</div>
    </div>

    <template id="tpl-medicacion">
        <div class="row g-2 mb-2 fila-medicacion">
            <div class="col-md-6">
                <select class="form-select border-success" data-campo="id_medicacion" required>
                    <option value="" disabled selected>Seleccione medicación...</option>
                    <?php foreach (($medicaciones ?? []) as $m): ?>
                        <option value="<?= (int) $m['id'] ?>"><?= esc($m['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control border-success" data-campo="dosis"
                    maxlength="100" placeholder="Dosis (ej: 4 puffs, 2.5 mg)" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100 btn-quitar-medicacion">Quitar</button>
            </div>
        </div>
    </template>

<script src="<?= base_url('assets/js/medicacion.js') ?>"></script>