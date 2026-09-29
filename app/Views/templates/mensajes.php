<?php
// Toasts de los mensajes flash
$avisos = [
    'exito' => 'text-bg-success',
    'error' => 'text-bg-danger',
];
?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php foreach ($avisos as $clave => $clase): ?>
        <?php if (session()->getFlashdata($clave)): ?>
            <div class="toast align-items-center <?= $clase ?> border-0" role="alert"
                 aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
                <div class="d-flex">
                    <div class="toast-body"><?= esc(session()->getFlashdata($clave)) ?></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
