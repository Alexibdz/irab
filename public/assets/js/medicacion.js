document.addEventListener('DOMContentLoaded', function () {
    var lista = document.getElementById('lista-medicaciones');
    var tpl = document.getElementById('tpl-medicacion');
    var botonAgregar = document.getElementById('btn-agregar-medicacion');

    if (!lista || !tpl || !botonAgregar) {
        return;
    }

    var indice = 0;

    botonAgregar.addEventListener('click', function () {
        var fila = tpl.content.cloneNode(true);
        fila.querySelectorAll('[data-campo]').forEach(function (campo) {
            campo.name = 'medicaciones[' + indice + '][' + campo.dataset.campo + ']';
        });
        indice++;
        lista.appendChild(fila);
    });

    lista.addEventListener('click', function (e) {
        var botonQuitar = e.target.closest('.btn-quitar-medicacion');
        if (botonQuitar) {
            botonQuitar.closest('.fila-medicacion').remove();
        }
    });
});