// Fecha de nacimiento: ficha del paso 2, o el select como alternativa
function obtenerFechaNacimiento() {
    let fichaPaciente = document.getElementById('paciente_fijo');
    if (fichaPaciente) {
        return fichaPaciente.dataset.nacimiento;
    }

    let selectPaciente = document.getElementById('select_paciente');
    if (!selectPaciente || selectPaciente.selectedIndex < 0) {
        return null;
    }
    return selectPaciente.options[selectPaciente.selectedIndex].getAttribute('data-nacimiento');
}

function filtrarFactoresPorEdad() {
    let fechaNacimiento = obtenerFechaNacimiento();

    let seccionControl = document.getElementById('seccion_control_inicial');
    if (seccionControl) {
        seccionControl.style.display = fechaNacimiento ? 'block' : 'none';
    }

    if (fechaNacimiento) {
        // Edad en meses
        let fechaNac = new Date(fechaNacimiento);
        let hoy = new Date();
        let mesesEdad = (hoy.getFullYear() - fechaNac.getFullYear()) * 12 + (hoy.getMonth() - fechaNac.getMonth());

        if (hoy.getDate() < fechaNac.getDate()) {
            mesesEdad--;
        }

        // Oculta todo por defecto
        $('.div-factor').hide();
        $('.div-factor input, .div-factor select').prop('disabled', true);

        $('.sintoma-tal, .sintoma-wdf').hide();
        $('.sintoma-tal select, .sintoma-wdf select').prop('disabled', true);

        // Activa segun la edad
        if (mesesEdad < 24) {
            // Menor de 2 anios: TAL
            $('.tipo-TAL, .tipo-Ambos').show();
            $('.tipo-TAL input, .tipo-TAL select, .tipo-Ambos input, .tipo-Ambos select').prop('disabled', false);

            // Sintomas TAL
            $('.sintoma-tal').show();
            $('.sintoma-tal select').prop('disabled', false);

            // FR segun corte de 6 meses
            if (mesesEdad <= 6) {
                $('#div_fr_mayor').hide();
                $('#div_fr_mayor select').prop('disabled', true);
            } else {
                $('#div_fr_menor').hide();
                $('#div_fr_menor select').prop('disabled', true);
            }

        } else {
            // 2 anios o mas: WDF
            $('.tipo-WDF, .tipo-Ambos').show();
            $('.tipo-WDF input, .tipo-WDF select, .tipo-Ambos input, .tipo-Ambos select').prop('disabled', false);

            // Sintomas WDF
            $('.sintoma-wdf').show();
            $('.sintoma-wdf select').prop('disabled', false);
        }
    }
}

// Autocompleta el establecimiento segun el usuario elegido
function cargarEstablecimientoPorUsuario() {
    const usuarioSelect = document.getElementById('id_usuario');
    const establecimientoSelect = document.getElementById('id_establecimiento');
    if (!usuarioSelect || !establecimientoSelect) return;

    const usuarioSeleccionado = usuarioSelect.options[usuarioSelect.selectedIndex];
    const establecimientoAsignado = usuarioSeleccionado ? usuarioSeleccionado.dataset.establecimiento : '';

    if (!establecimientoAsignado) {
        establecimientoSelect.value = '';
        return;
    }

    let encontrado = false;
    for (const option of establecimientoSelect.options) {
        if (option.value === establecimientoAsignado) {
            establecimientoSelect.value = establecimientoAsignado;
            encontrado = true;
            break;
        }
    }

    if (!encontrado) {
        establecimientoSelect.value = '';
    }
}

// Eventos
document.addEventListener("DOMContentLoaded", function() {
    // Autocompleta fecha y hora
    let inputFecha = document.getElementById('fecha_ingreso');
    if (inputFecha && !inputFecha.value) {
        let ahora = new Date();
        ahora.setMinutes(ahora.getMinutes() - ahora.getTimezoneOffset());
        inputFecha.value = ahora.toISOString().slice(0, 16);
    }
    // Solo con bloque de factores
    if (document.getElementById('seccion_control_inicial')) {
        filtrarFactoresPorEdad();
    }

    let selectPaciente = document.getElementById('select_paciente');
    if (selectPaciente) {
        selectPaciente.addEventListener('change', filtrarFactoresPorEdad);
    }

    // Sincronizar establecimiento segun usuario (si existen los selects)
    const usuarioSelect = document.getElementById('id_usuario');
    const establecimientoSelect = document.getElementById('id_establecimiento');
    if (usuarioSelect && establecimientoSelect) {
        usuarioSelect.addEventListener('change', cargarEstablecimientoPorUsuario);
        cargarEstablecimientoPorUsuario();
    }
});