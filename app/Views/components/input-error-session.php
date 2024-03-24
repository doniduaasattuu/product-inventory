<?php if (session()->has('errors') && !is_null(session('errors')[$field])) : ?>
    <div class="form-text text-danger"><?= session('errors')[$field] ?></div>
<?php endif; ?>