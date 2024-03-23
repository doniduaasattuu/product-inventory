<?php if ($alert = session()->getFlashData('alert')) : ?>
    <div class="alert <?= $alert['variant'] ?? 'alert-danger' ?> alert-dismissible" role="alert">
        <?= $alert['message'] ?? 'Error occured.' ?>
    </div>
<?php endif; ?>