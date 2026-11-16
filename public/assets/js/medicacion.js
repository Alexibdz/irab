document.addEventListener('DOMContentLoaded', function () {
    const lista = document.getElementById('lista-medicaciones');
    const tpl = document.getElementById('tpl-medicacion');
    const botonAgregar = document.getElementById('btn-agregar-medicacion');

    if (!lista || !tpl || !botonAgregar) return;

    let indice = lista.querySelectorAll('.fila-medicacion').length;

    // Función que conecta los eventos a cualquier fila (nueva o ya existente)
    function inicializarFila(fila) {
        const selectMed = fila.querySelector('[data-campo="id_medicacion"]');
        const inputNueva = fila.querySelector('[data-campo="nueva_medicacion"]');
        const bloqueNueva = fila.querySelector('.bloque-nueva-medicacion');
        const botonCatalogo = fila.querySelector('.btn-volver-catalogo');

        selectMed.addEventListener('change', function () {
            const esNueva = selectMed.value === 'nueva';

            selectMed.classList.toggle('d-none', esNueva);
            selectMed.required = !esNueva; // Evita bloqueo del navegador al ocultar

            bloqueNueva.classList.toggle('d-none', !esNueva);
            inputNueva.required = esNueva;

            if (esNueva) {
                inputNueva.focus();
            } else {
                inputNueva.value = '';
            }
        });

        botonCatalogo.addEventListener('click', function () {
            selectMed.value = '';
            selectMed.dispatchEvent(new Event('change')); // Reutiliza la lógica de arriba
            selectMed.focus();
        });
    }

    // 1. Inicializar filas que ya vengan renderizadas desde PHP (si hay)
    lista.querySelectorAll('.fila-medicacion').forEach(inicializarFila);

    // 2. Agregar filas nuevas
    botonAgregar.addEventListener('click', function () {
        const clon = tpl.content.cloneNode(true);
        const fila = clon.querySelector('.fila-medicacion');

        fila.querySelectorAll('[data-campo]').forEach(function (campo) {
            campo.name = `medicaciones[${indice}][${campo.dataset.campo}]`;
        });

        inicializarFila(fila);
        lista.appendChild(fila);
        indice++;
    });

    // 3. Quitar filas (delegación de eventos)
    lista.addEventListener('click', function (e) {
        const botonQuitar = e.target.closest('.btn-quitar-medicacion');
        if (botonQuitar) {
            botonQuitar.closest('.fila-medicacion').remove();
        }
    });
});