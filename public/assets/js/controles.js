
function calcularScoreDinamico() {
    let scoreTotal = 0;
    
    // Selects de sintomas
    let selects = document.querySelectorAll('.select-sintoma');

    selects.forEach(function(select) {
        // Opcion elegida
        let opcionSeleccionada = select.options[select.selectedIndex];
        
        // Puntos desde data-puntos
        let puntos = parseInt(opcionSeleccionada.getAttribute('data-puntos')) || 0;
        
        // Acumula
        scoreTotal += puntos;
    });

    // Muestra el total
    let scoreDisplay = document.getElementById('score_display');
    if (scoreDisplay) {
        scoreDisplay.innerText = scoreTotal;
    }
}