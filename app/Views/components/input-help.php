<div class="form-text text-secondary">
    <?= $message ?? 'Provide message here, ' ?>

    <?php if (isset($href) && isset($action)) : ?>
        <a href="<?= $href ?? '#' ?>" class="text-decoration-none text-white"><?= $action ?? 'No action' ?></a>
    <?php endif; ?>
</div>