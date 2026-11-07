<div class="container" style="max-width: 820px;">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-1">
        <h2 class="h3 mb-0"><i class="bi bi-journal-medical"></i> Nueva visita</h2>
        <span class="badge bg-secondary">Paso 1 de 2</span>
    </div>

    <p class="text-muted small mb-4">Primero identificamos al paciente. Después se carga la visita.</p>

    <!-- Buscador de pacientes -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= base_url('visitas/crear') ?>" method="GET">
                <label for="q" class="form-label fw-bold">Buscar paciente por DNI, nombre o apellido</label>

                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="q" name="q" value="<?= esc($q) ?>" placeholder="DNI, nombre o apellido del paciente" autocomplete="off" aria-controls="resultados_paciente" aria-autocomplete="list" autofocus>
                    <button class="btn btn-irab px-4" type="submit">Buscar</button>
                </div>

                <div class="list-group mt-1 d-none" id="resultados_paciente" role="listbox"></div>
                <div class="form-text">Se busca al paciente por sus propios datos, no por los del tutor.</div>
            </form>
        </div>
    </div>

    <?php if ($q !== ''): ?>
        <div id="pacientes_encontrados_servidor">

        <!-- Pacientes encontrados -->
        <?php if (!empty($pacientes)): ?>

            <h6 class="text-uppercase text-muted small fw-bold mb-2">
                Pacientes encontrados (<?= count($pacientes) ?>)
            </h6>

            <div class="list-group mb-4 shadow-sm">
                <?php foreach ($pacientes as $paciente): ?>
                    <a href="<?= base_url('visitas/crear/' . $paciente['id']) ?>" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold"><?= esc(nombre_completo($paciente)) ?></div>

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

        </div>
    <?php endif; ?>


    <!-- Alta de paciente -->
    <div class="text-center mb-3">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panelPacienteNuevo">
            <i class="bi bi-person-plus"></i> Registrar paciente nuevo
        </button>
    </div>

    <div class="collapse<?= $panelAbierto ? ' show' : '' ?>" id="panelPacienteNuevo">

        <div class="card shadow-sm border-success">

            <!-- Encabezado -->
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i> Paciente nuevo</h5>
            </div>

            <form action="<?= base_url('visitas/paciente-nuevo') ?>" method="POST">

                <?= csrf_field() ?>

                <div class="card-body">

                    <!-- Errores -->
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger shadow-sm mb-4">
                            <strong><i class="bi bi-exclamation-circle me-1"></i> Revisá los siguientes errores:</strong>

                            <ul class="mb-0 mt-2">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>


                    <!-- Datos del paciente -->
                    <h6 class="text-success border-bottom pb-2 mb-3">
                        <i class="bi bi-person-vcard me-2"></i> Datos del paciente
                    </h6>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre" value="<?= esc(old('nombre')) ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apellido" value="<?= esc(old('apellido')) ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni_paciente_nuevo" value="<?= esc($dniPaciente) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= esc(old('fecha_nacimiento')) ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Barrio</label>
                            <input type="text" class="form-control" name="barrio" value="<?= esc(old('barrio')) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Domicilio</label>
                            <input type="text" class="form-control" name="domicilio" value="<?= esc(old('domicilio')) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Establecimiento habitual <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_establecimiento_habitual" required>
                                <option value="" disabled <?= old('id_establecimiento_habitual') ? '' : 'selected' ?>>Seleccione...</option>

                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= $establecimiento['id'] ?>" <?= old('id_establecimiento_habitual') == $establecimiento['id'] ? 'selected' : '' ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Área programática</label>
                            <select class="form-select" name="id_area_programatica">
                                <option value="">Opcional...</option>

                                <?php foreach ($establecimientos as $establecimiento): ?>
                                    <option value="<?= $establecimiento['id'] ?>" <?= old('id_area_programatica') == $establecimiento['id'] ? 'selected' : '' ?>>
                                        <?= esc($establecimiento['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>


                    <!-- Datos del tutor -->
                    <h6 class="text-success border-bottom pb-2 mt-4 mb-3">
                        <i class="bi bi-people me-2"></i> Tutor responsable
                    </h6>

                    <div class="alert alert-light border small mb-3">
                        <i class="bi bi-info-circle text-success me-1"></i>
                        Todo paciente necesita un tutor. Podés seleccionar uno ya registrado o cargar uno nuevo. Si el DNI o el teléfono ya existen, se reutiliza el tutor registrado.
                    </div>


                    <!-- Tutor existente -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="modo_tutor" id="tutor_existente" value="existente" checked>
                        <label class="form-check-label fw-semibold" for="tutor_existente">Tutor ya registrado</label>
                    </div>

                    <div class="ps-4 mb-3" id="bloque_tutor_existente">

                        <input type="hidden" name="id_tutor" id="id_tutor" value="">

                        <!-- Buscador de tutores -->
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="buscar_tutor" autocomplete="off" placeholder="Buscar por nombre, apellido o DNI...">
                        </div>

                        <!-- Resultados -->
                        <div class="list-group mt-1 d-none" id="resultados_tutor"></div>

                        <!-- Tutor seleccionado -->
                        <div class="alert alert-success d-none d-flex justify-content-between align-items-center py-2 px-3 mt-2 mb-0" id="tutor_elegido">
                            <span id="tutor_elegido_texto"></span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="quitar_tutor">Cambiar</button>
                        </div>

                    </div>


                    <!-- Tutor nuevo -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="modo_tutor" id="tutor_nuevo" value="nuevo">
                        <label class="form-check-label fw-semibold" for="tutor_nuevo">Tutor nuevo</label>
                    </div>

                    <div class="row ps-4" id="campos_tutor_nuevo">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre del tutor</label>
                            <input type="text" class="form-control" name="tutor_nombre" value="<?= esc(old('tutor_nombre')) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido del tutor</label>
                            <input type="text" class="form-control" name="tutor_apellido" value="<?= esc(old('tutor_apellido')) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="tutor_dni" id="tutor_dni_nuevo" value="<?= esc(old('tutor_dni')) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="tutor_telefono" value="<?= esc(old('tutor_telefono')) ?>">
                        </div>

                    </div>

                </div>

                <!-- Pie del formulario -->
                <div class="card-footer bg-light text-end py-3">
                    <button type="submit" class="btn btn-irab px-4">
                        Registrar y continuar <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const buscadorPaciente = document.getElementById('q');
    const resultadosPaciente = document.getElementById('resultados_paciente');
    const pacientesServidor = document.getElementById('pacientes_encontrados_servidor');
    const dniPacienteNuevo = document.getElementById('dni_paciente_nuevo');
    const botonPacienteNuevo = document.querySelector('[data-bs-target="#panelPacienteNuevo"]');
    const dniInicial = buscadorPaciente.value.trim();
    const digitosIniciales = dniInicial.replace(/\D/g, '');
    let dniPacienteAutocompletado =
        /^[0-9.\s]+$/.test(dniInicial) && digitosIniciales.length === 8 && dniPacienteNuevo.value === digitosIniciales
            ? digitosIniciales
            : '';
    let esperaPaciente = null;

    function sincronizarDniPaciente() {
        const q = buscadorPaciente.value.trim();
        const digitos = q.replace(/\D/g, '');
        const esDni = /^[0-9.\s]+$/.test(q) && digitos.length === 8;

        if (esDni && (!dniPacienteNuevo.value || dniPacienteNuevo.value === dniPacienteAutocompletado)) {
            dniPacienteNuevo.value = digitos;
            dniPacienteAutocompletado = digitos;
        } else if (!esDni && dniPacienteAutocompletado && dniPacienteNuevo.value === dniPacienteAutocompletado) {
            dniPacienteNuevo.value = '';
            dniPacienteAutocompletado = '';
        }
    }

    buscadorPaciente.addEventListener('input', sincronizarDniPaciente);
    botonPacienteNuevo.addEventListener('click', sincronizarDniPaciente);

    buscadorPaciente.addEventListener('input', function () {
        const q = buscadorPaciente.value.trim();

        if (pacientesServidor) {
            pacientesServidor.classList.add('d-none');
        }

        clearTimeout(esperaPaciente);

        if (q.length < 2) {
            resultadosPaciente.classList.add('d-none');
            resultadosPaciente.innerHTML = '';
            return;
        }

        resultadosPaciente.innerHTML = '<div class="list-group-item small text-muted">Buscando...</div>';
        resultadosPaciente.classList.remove('d-none');
        esperaPaciente = setTimeout(() => buscarPaciente(q), 300);
    });

    function buscarPaciente(q) {
        fetch('<?= base_url('visitas/buscar-paciente') ?>?q=' + encodeURIComponent(q))
            .then(respuesta => {
                if (!respuesta.ok) {
                    throw new Error('No se pudo buscar el paciente.');
                }

                return respuesta.json();
            })
            .then(pacientes => {
                if (buscadorPaciente.value.trim() !== q) {
                    return;
                }

                mostrarResultadosPaciente(pacientes);
            })
            .catch(() => {
                if (buscadorPaciente.value.trim() === q) {
                    resultadosPaciente.innerHTML =
                        '<div class="list-group-item small text-danger">No se pudo realizar la búsqueda. Intentá nuevamente.</div>';
                    resultadosPaciente.classList.remove('d-none');
                }
            });
    }

    function mostrarResultadosPaciente(pacientes) {
        resultadosPaciente.innerHTML = '';

        if (pacientes.length === 0) {
            resultadosPaciente.innerHTML =
                '<div class="list-group-item small text-muted">Sin resultados. Podés registrar un paciente nuevo.</div>';
            resultadosPaciente.classList.remove('d-none');
            return;
        }

        pacientes.forEach(function (paciente) {
            const item = document.createElement('a');
            item.href = '<?= base_url('visitas/crear') ?>/' + encodeURIComponent(paciente.id);
            item.className = 'list-group-item list-group-item-action py-2';
            item.setAttribute('role', 'option');

            const nombre = document.createElement('strong');
            nombre.textContent = [paciente.nombre, paciente.apellido].filter(Boolean).join(' ');

            const detalle = document.createElement('div');
            detalle.className = 'small text-muted';
            detalle.textContent =
                'DNI ' + (paciente.dni || 's/d') +
                ' — ' + paciente.visitas_previas + ' visita(s) previa(s)';

            item.append(nombre, detalle);
            resultadosPaciente.appendChild(item);
        });

        resultadosPaciente.classList.remove('d-none');
    }

    const existente   = document.getElementById('tutor_existente');
    const nuevo       = document.getElementById('tutor_nuevo');
    const idTutor     = document.getElementById('id_tutor');
    const buscador    = document.getElementById('buscar_tutor');
    const resultados  = document.getElementById('resultados_tutor');
    const elegido     = document.getElementById('tutor_elegido');
    const elegidoTxt  = document.getElementById('tutor_elegido_texto');
    const quitar      = document.getElementById('quitar_tutor');
    const camposNuevo = document.querySelectorAll('#campos_tutor_nuevo input');
    const dniTutorNuevo = document.getElementById('tutor_dni_nuevo');
    let dniTutorNoEncontrado = '';
    let dniTutorAutocompletado = '';

    // Modos excluyentes: deshabilita el que no se usa
    function aplicarModo() {
        idTutor.disabled = !existente.checked;
        buscador.disabled = false;
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
        dniTutorNoEncontrado = '';

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
            .then(tutores => {
                if (buscador.value.trim() !== q) {
                    return;
                }

                mostrarResultados(tutores);
                const digitos = q.replace(/\D/g, '');
                const esDni = /^[0-9.\s]+$/.test(q) && digitos.length === 8;
                dniTutorNoEncontrado = tutores.length === 0 && esDni ? digitos : '';
                if (dniTutorNoEncontrado) {
                    nuevo.checked = true;
                    aplicarModo();
                    if (!dniTutorNuevo.value || dniTutorNuevo.value === dniTutorAutocompletado) {
                        dniTutorNuevo.value = dniTutorNoEncontrado;
                        dniTutorAutocompletado = dniTutorNoEncontrado;
                    }
                }
            })
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
            item.querySelector('strong').textContent = [tutor.nombre, tutor.apellido].filter(Boolean).join(' ');
            item.querySelector('span').textContent =
                ' — DNI ' + tutor.dni + (tutor.telefono ? ' — Tel. ' + tutor.telefono : '');

            item.addEventListener('click', () => elegirTutor(tutor));
            resultados.appendChild(item);
        });

        resultados.classList.remove('d-none');
    }

    function elegirTutor(tutor) {
        existente.checked = true;
        nuevo.checked = false;
        aplicarModo();
        idTutor.value = tutor.id;
        elegidoTxt.textContent =
            [tutor.nombre, tutor.apellido].filter(Boolean).join(' ') +
            ' — DNI ' + tutor.dni + (tutor.telefono ? ' — Tel. ' + tutor.telefono : '');

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
