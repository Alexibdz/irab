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
    // Muestra los toasts que haya dejado el controlador
    document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());

    // DataTables solo en las tablas marcadas con .tabla-datos
    $(function () {
        $('.tabla-datos').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' },
            pageLength: 10,
            // la ultima columna es "Acciones": no tiene sentido ordenarla
            columnDefs: [{ orderable: false, targets: -1 }]
        });
    });
</script>
</body>
</html>
