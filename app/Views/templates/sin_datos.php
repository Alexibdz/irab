<?php
/*
 * Aviso para cuando una tabla no tiene registros (mismo estilo que Visitas abiertas).
 *
 * Uso:
 * <?= view('templates/sin_datos', [
 *     'mensaje'  => 'No hay pacientes registrados.',
 *     'acciones' => ['Registrar una nueva visita' => 'visitas/crear'],   // opcional
 * ]) ?>
 */
$acciones = $acciones ?? [];
$links = [];
foreach ($acciones as $texto => $url) {
    $links[] = '<a href="' . base_url($url) . '" class="alert-link">' . esc($texto) . '</a>';
}
?>
<div class="alert alert-info">
    <i class="bi bi-info-circle"></i>
    <?= esc($mensaje) ?>
    <?php if ($links): ?>
        <?= implode(' o ', $links) ?>.
    <?php endif; ?>
</div>
