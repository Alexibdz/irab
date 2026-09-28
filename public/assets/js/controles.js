
function calcularScoreDinamico() {
    let scoreTotal = 0;
    
    // Seleccionamos todos los elementos que tengan la clase .select-sintoma
    let selects = document.querySelectorAll('.select-sintoma');

    selects.forEach(function(select) {
        // Obtenemos la opción seleccionada actualmente por el usuario
        let opcionSeleccionada = select.options[select.selectedIndex];
        
        // Extraemos los puntos guardados en el atributo data-puntos (si no existe, toma 0)
        let puntos = parseInt(opcionSeleccionada.getAttribute('data-puntos')) || 0;
        
        // Sumamos al acumulador
        scoreTotal += puntos;
    });

    // Actualizamos el número visible en la pantalla para el personal de enfermería
    let scoreDisplay = document.getElementById('score_display');
    if (scoreDisplay) {
        scoreDisplay.innerText = scoreTotal;
    }
}