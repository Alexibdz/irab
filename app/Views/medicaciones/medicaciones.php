    <div class="mt-3" id="bloque-medicaciones">
        <label class="form-label fw-bold text-success"><?= esc($titulo ?? 'Medicación administrada') ?></label>

        <div id="lista-medicaciones"></div>

        <button type="button" class="btn btn-outline-success btn-sm" id="btn-agregar-medicacion">
            + Agregar medicación
        </button>
        <div class="form-text"><?= esc($ayuda ?? 'Si no se administró ninguna medicación, dejá la lista vacía.') ?></div>
    </div>

    <template id="tpl-medicacion">
        <div class="row g-2 align-items-start mb-3 fila-medicacion">
            <div class="col-md-5">
                <select class="form-select border-success" data-campo="id_medicacion" required>
                    <option value="" disabled selected>Seleccione medicación...</option>
                    <?php foreach (($medicaciones ?? []) as $m): ?>
                        <option value="<?= (int) $m['id'] ?>"><?= esc($m['nombre']) ?></option>
                    <?php endforeach; ?>
                    <option value="nueva">+ Agregar otra medicación</option>
                </select>
                <div class="input-group d-none bloque-nueva-medicacion">
                    <input type="text" class="form-control border-success" data-campo="nueva_medicacion"
                        maxlength="100" placeholder="Nombre de la nueva medicación">
                    <button type="button" class="btn btn-outline-secondary btn-volver-catalogo"
                        aria-label="Volver al catálogo de medicaciones">Catálogo</button>
                </div>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control border-success" data-campo="dosis"
                    maxlength="100" placeholder="Dosis (ej: 4 puffs, 2.5 mg)" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100 btn-quitar-medicacion">Quitar</button>
            </div>
        </div>
    </template>

<script src="<?= base_url('assets/js/medicacion.js?v=' . filemtime(FCPATH . 'assets/js/medicacion.js')) ?>"></script>