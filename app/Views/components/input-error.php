<?php if (isset($validation)) : ?>
    <div class="form-text text-danger"><?= $validation->getError($field) ?></div>
<?php endif; ?>