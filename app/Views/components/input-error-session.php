<?php if (session()->has('errors') && isset(session('errors')[$field])) : ?>
    <div class="form-text text-danger"><?= session('errors')[$field] ?></div>
<?php endif; ?>