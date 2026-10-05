</main>

<footer class="border-top py-3 mt-5 text-center text-muted small">
    IRAB - Sistema de Enfermería &copy; <?= date('Y') ?>
</footer>

<?= view('templates/mensajes') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>

<!-- botones -->
<!-- Librerías indispensables para exportar en DataTables -->
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>



<script>
    // Toasts del controlador
    document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());

    // Reloj del navbar, con la hora local de la maquina
    (function () {
        const hora  = document.getElementById('reloj_hora');
        const fecha = document.getElementById('reloj_fecha');
        if (!hora) return;

        function actualizar() {
            const ahora = new Date();
            hora.textContent = ahora.toLocaleTimeString('es-AR', {
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hourCycle: 'h23'
            });
            fecha.textContent = ahora.toLocaleDateString('es-AR', {
                weekday: 'short', day: 'numeric', month: 'short'
            });
        }

        actualizar();
        setInterval(actualizar, 1000);
    })();

    // DataTables en .tabla-datos
// DataTables en .tabla-datos y #tabla-dato
// Inicialización estructurada de DataTables
    $(function () {
    $('.tabla-datos, #tabla-dato').DataTable({
        // Disposición estructural (dom): Botones a la izquierda, buscador a la derecha
        dom: "<'row mb-2'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        // Estructura y definición de los botones
        buttons: [
            {
                extend: 'csvHtml5',
                text: '<i class="bi bi-filetype-csv"></i> CSV',
                className: 'btn-blanco-dt',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluye la columna de acciones
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-filetype-pdf"></i> PDF',
                className: 'btn-blanco-dt',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Imprimir',
                className: 'btn-blanco-dt',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        
        // Configuración regional y paginación
        language: { 
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' 
        },
        pageLength: 10,
        
        // Última columna fija sin ordenación
        columnDefs: [
            { orderable: false, targets: -1 }
        ]
    });
});
</script>
<script src="<?= base_url('assets/js/visitas.js') ?>"></script>
<script src="<?= base_url('assets/js/controles.js') ?>"></script>
</body>
</html>
