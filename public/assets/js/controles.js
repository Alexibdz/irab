function calcularScoreDinamico() {

    let score = 0;

    // ==========================================
    // INPUTS NUMÉRICOS CON DATA-RANGOS
    // ==========================================

    $('.input-score').each(function () {

        const input = $(this);
        const valor = Number(input.val());

        if (input.val() === '') {
            return;
        }

        const rangos = JSON.parse(input.attr('data-rangos'));

        rangos.forEach(function (rango) {

            if (valor >= rango.min && valor <= rango.max) {
                score += Number(rango.puntos);
            }

        });

    });


    // ==========================================
    // SELECTS CON DATA-PUNTOS
    // ==========================================

    $('.select-sintoma').each(function () {

        const opcion = $(this).find('option:selected');

        const puntos = opcion.attr('data-puntos');

        if (puntos !== undefined) {
            score += Number(puntos);
        }

    });


    // ==========================================
    // MOSTRAR SCORE
    // ==========================================

    $('#score_display').text(score);
}