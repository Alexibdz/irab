// La fecha de nacimiento sale de la ficha del paciente, que en el paso 2 ya
// viene fija desde el servidor. Se deja el <select> como alternativa por si
// alguna pantalla todavia deja elegir al paciente a mano.
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
        // Calcular la edad exacta en meses
        let fechaNac = new Date(fechaNacimiento);
        let hoy = new Date();
        let mesesEdad = (hoy.getFullYear() - fechaNac.getFullYear()) * 12 + (hoy.getMonth() - fechaNac.getMonth());
        
        if (hoy.getDate() < fechaNac.getDate()) {
            mesesEdad--; 
        }

        // Ocultar y deshabilitar todos los factores y síntomas por defecto
        $('.div-factor').hide();
        $('.div-factor input, .div-factor select').prop('disabled', true);
        
        $('.sintoma-tal, .sintoma-wdf').hide();
        $('.sintoma-tal select, .sintoma-wdf select').prop('disabled', true);

        //Activar los campos según la edad (Soportando 'Ambos' por compatibilidad)
        if (mesesEdad < 24) {
            // Es menor de 2 años: Mostrar factores TAL y Ambos
            $('.tipo-TAL, .tipo-Ambos').show();
            $('.tipo-TAL input, .tipo-TAL select, .tipo-Ambos input, .tipo-Ambos select').prop('disabled', false);
            
            // Mostrar síntomas TAL
            $('.sintoma-tal').show();
            $('.sintoma-tal select').prop('disabled', false);

            // Filtrar Frecuencia Respiratoria por límite de 6 meses
            if (mesesEdad <= 6) {
                $('#div_fr_mayor').hide();
                $('#div_fr_mayor select').prop('disabled', true);
            } else {
                $('#div_fr_menor').hide();
                $('#div_fr_menor select').prop('disabled', true);
            }

        } else {
            // Es mayor o igual a 2 años: Mostrar factores WDF y Ambos
            $('.tipo-WDF, .tipo-Ambos').show();
            $('.tipo-WDF input, .tipo-WDF select, .tipo-Ambos input, .tipo-Ambos select').prop('disabled', false);
            
            // Mostrar síntomas WDF
            $('.sintoma-wdf').show();
            $('.sintoma-wdf select').prop('disabled', false);
        }
    }
}

//  detector de eventos
document.addEventListener("DOMContentLoaded", function() {
    // se autocompleta la fecha y hora ---
    let inputFecha = document.getElementById('fecha_ingreso');
    if (inputFecha && !inputFecha.value) {
        let ahora = new Date();
        ahora.setMinutes(ahora.getMinutes() - ahora.getTimezoneOffset());
        inputFecha.value = ahora.toISOString().slice(0, 16);
    }
    // ------------------------------------------------
    // Solo corre en las pantallas que tienen el bloque de factores.
    if (document.getElementById('seccion_control_inicial')) {
        filtrarFactoresPorEdad();
    }

    let selectPaciente = document.getElementById('select_paciente');
    if (selectPaciente) {
        selectPaciente.addEventListener('change', filtrarFactoresPorEdad);
    }
});