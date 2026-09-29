<?php
// Paso 1 alta de visita

// Panel abierto si el POST volvio con error
$panelAbierto = !empty(old('nombre'));
?>
<div class="container" style="max-width: 820px;">

    <div class="d-flex justify-content-between align-items-center mb-1">
        <h2 class="h3 mb-0"><i class="bi bi-journal-medical"></i> Nueva visita</h2>
        <span class="badge bg-secondary">Paso 1 de 2</span>
    </div>
    <p class="text-muted small mb-4">Primero identificamos al paciente. Después se carga la visita.</p>

    <!-- Buscador -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= base_url('visitas/crear') ?>" method="GET">
                <label for="q" class="form-label fw-bold">Buscar paciente por DNI, nombre o apellido</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="q" name="q"
                           value="<?= esc($q) ?>" placeholder="DNI, nombre o apellido del paciente" autofocus>
                    <button class="btn btn-irab px-4" type="submit">Buscar</button>
                </div>
                <div class="form-text">Se busca al paciente por sus propios datos, no por los del tutor.</div>
            </form>
        </div>
    </div>

    <?php if ($q !== ''): ?>

        <!-- Pacientes encontrados -->
        <?php if (!empty($pacientes)): ?>
            <h6 class="text-uppercase text-muted small fw-bold mb-2">
                Pacientes encontrados (<?= count($pacientes) ?>)
            </h6>
            <div class="list-group mb-4 shadow-sm">
                <?php foreach ($pacientes as $paciente): ?>
                    <a href="<?= base_url('visitas/crear/' . $paciente['id']) ?>"
                       class="list-group-item list-group-item-action py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold"><?= esc($paciente['nombre']) ?></div>
                                <div class="small text-muted">
                                    DNI <?= esc($paciente['dni'] ?: 's/d') ?>
                                    · <?= esc(edad_texto($paciente['fecha_nacimiento'])) ?>
                                    <?php if (!empty($paciente['tutor_nombre'])): ?>
                                        · Tutor: <?= esc($paciente['tutor_nombre']) ?>
                                        <?php if (!empty($paciente['tutor_telefono'])): ?>
                                            (<?= esc($paciente['tutor_telefono']) ?>)
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark border text-nowrap ms-3">
                                <?= $paciente['visitas_previas'] ?>
                                visita<?= $paciente['visitas_previas'] === 1 ? '' : 's' ?> previa<?= $paciente['visitas_previas'] === 1 ? '' : 's' ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="bi bi-search"></i>
                No hay pacientes que coincidan con <strong><?= esc($q) ?></strong>.
                Registralo abajo.
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- Alta de paciente -->
    <div class="text-center mb-3">
        <button class="btn btn-outline-secondary" type="button"
                data-bs-toggle="collapse" data-bs-target="#panelPacienteNuevo">
            <i class="bi bi-person-plus"></i> Registrar paciente nuevo
        </button>
    </div>

    <div class="collapse<?= $panelAbierto ? ' show' : '' ?>" id="panelPacienteNuevo">
        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Paciente nuevo</h5>
            </div>

            <form action="<?= base_url('visitas/paciente-nuevo') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="card-body">

                    <!-- Datos del paciente -->
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre" value="<?= esc(old('nombre')) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" value="<?= esc(old('dni')) ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha de nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= esc(old('fecha_nacimiento')) ?>" required>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Domicilio</label>
                            <input type="text" class="form-control" name="domicilio" value="<?= esc(old('domicilio')) ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Barrio</label>
                            <input type="text" class="form-control" name="barrio" value="<?= esc(old('barrio')) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Establecimiento habitual <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_establecimiento_habitual" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= $establecimiento['id'] ?>"
                                        <?= old('id_establecimiento_habitual') == $establecimiento['id'] ? 'selected' : '' ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Área programática</label>
                            <select class="form-select" name="id_area_programatica">
                                <option value="">Opcional...</option>
                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= $establecimiento['id'] ?>"
                                        <?= old('id_area_programatica') == $establecimiento['id'] ? 'selected' : '' ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tutor -->
                    <h6 class="text-success border-bottom pb-2 mt-3 mb-3">
                        <i class="bi bi-people"></i> Tutor responsable
                    </h6>
                    <p class="small text-muted">
                        Todo paciente necesita un tutor. Elegí uno existente o cargá uno nuevo;
                        si el DNI o el teléfono ya están registrados, se reutiliza ese tutor en vez de duplicarlo.
                    </p>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="modo_tutor" id="tutor_existente"
                               value="existente" checked>
                        <label class="form-check-label" for="tutor_existente">Tutor ya registrado</label>
                    </div>

                    <div class="mb-3 ps-4" id="bloque_tutor_existente">
                        <!-- Id del tutor elegido -->
                        <input type="hidden" name="id_tutor" id="id_tutor" value="">

                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="buscar_tutor" autocomplete="off"
                                   placeholder="Buscar tutor por nombre, apellido o DNI...">
                        </div>

                        <!-- Resultados -->
                        <div class="list-group mt-1 d-none" id="resultados_tutor"></div>

                        <!-- Tutor elegido -->
                        <div class="alert alert-success py-2 px-3 mt-2 mb-0 d-none d-flex justify-content-between align-items-center"
                             id="tutor_elegido">
                            <span id="tutor_elegido_texto"></span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="quitar_tutor">Cambiar</button>
                        </div>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="modo_tutor" id="tutor_nuevo" value="nuevo">
                        <label class="form-check-label" for="tutor_nuevo">Tutor nuevo</label>
                    </div>

                    <div class="row ps-4" id="campos_tutor_nuevo">
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Nombre del tutor</label>
                            <input type="text" class="form-control" name="tutor_nombre" value="<?= esc(old('tutor_nombre')) ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="tutor_dni" value="<?= esc(old('tutor_dni')) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="tutor_telefono" value="<?= esc(old('tutor_telefono')) ?>">
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-light text-end py-3">
                    <button type="submit" class="btn btn-irab px-4">
                        Registrar y continuar <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const existente   = document.getElementById('tutor_existente');
    const nuevo       = document.getElementById('tutor_nuevo');
    const idTutor     = document.getElementById('id_tutor');
    const buscador    = document.getElementById('buscar_tutor');
    const resultados  = document.getElementById('resultados_tutor');
    const elegido     = document.getElementById('tutor_elegido');
    const elegidoTxt  = document.getElementById('tutor_elegido_texto');
    const quitar      = document.getElementById('quitar_tutor');
    const camposNuevo = document.querySelectorAll('#campos_tutor_nuevo input');

    // Modos excluyentes: deshabilita el que no se usa
    function aplicarModo() {
        idTutor.disabled = !existente.checked;
        buscador.disabled = !existente.checked;
        camposNuevo.forEach(campo => campo.disabled = existente.checked);
    }

    existente.addEventListener('change', aplicarModo);
    nuevo.addEventListener('change', aplicarModo);
    aplicarModo();

    // Buscador de tutor: por GET, no rota el token CSRF
    let esperando = null;

    buscador.addEventListener('input', function () {
        const q = buscador.value.trim();

        // Al tipear se descarta la eleccion previa
        idTutor.value = '';
        elegido.classList.add('d-none');

        clearTimeout(esperando);

        if (q.length < 2) {
            resultados.classList.add('d-none');
            return;
        }

        // Debounce
        esperando = setTimeout(() => buscarTutor(q), 300);
    });

    function buscarTutor(q) {
        fetch('<?= base_url('visitas/buscar-tutor') ?>?q=' + encodeURIComponent(q))
            .then(respuesta => respuesta.json())
            .then(mostrarResultados)
            .catch(() => resultados.classList.add('d-none'));
    }

    function mostrarResultados(tutores) {
        resultados.innerHTML = '';

        if (tutores.length === 0) {
            resultados.innerHTML =
                '<div class="list-group-item small text-muted">' +
                'Sin resultados. Si el tutor no está registrado, elegí "Tutor nuevo".' +
                '</div>';
            resultados.classList.remove('d-none');
            return;
        }

        tutores.forEach(function (tutor) {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action py-2';
            item.innerHTML =
                '<strong></strong><span class="small text-muted"></span>';
            item.querySelector('strong').textContent = tutor.nombre;
            item.querySelector('span').textContent =
                ' — DNI ' + tutor.dni + (tutor.telefono ? ' — Tel. ' + tutor.telefono : '');

            item.addEventListener('click', () => elegirTutor(tutor));
            resultados.appendChild(item);
        });

        resultados.classList.remove('d-none');
    }

    function elegirTutor(tutor) {
        idTutor.value = tutor.id;
        elegidoTxt.textContent =
            tutor.nombre + ' — DNI ' + tutor.dni + (tutor.telefono ? ' — Tel. ' + tutor.telefono : '');

        buscador.value = '';
        resultados.classList.add('d-none');
        elegido.classList.remove('d-none');
    }

    quitar.addEventListener('click', function () {
        idTutor.value = '';
        elegido.classList.add('d-none');
        buscador.focus();
    });
});
</script>
