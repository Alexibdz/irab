</main>

<footer class="border-top py-3 mt-5 text-center text-muted small">
    IRAB - Sistema de Enfermería &copy; <?= date('Y') ?>
</footer>

<?= view('templates/mensajes') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
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
    $(function () {
        $('.tabla-datos').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' },
            pageLength: 10,
            // Ultima columna: Acciones, sin orden
            columnDefs: [{ orderable: false, targets: -1 }]
        });
    });
</script>
<script src="<?= base_url('assets/js/visitas.js') ?>"></script>
<script src="<?= base_url('assets/js/controles.js') ?>"></script>
</body>
</html>
