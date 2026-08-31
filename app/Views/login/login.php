<form action="<?php echo base_url('/validarLogin') ?>" method="post"> <?= csrf_field() ?>
    <div>
        <label for="username">Usuario</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Entrar</button>
</form>
<?php if (session()->getFlashdata('error')): ?>
    <div>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>