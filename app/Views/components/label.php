<label class="form-label fw-semibold" for="<?= $label ?? 'Label' ?>">
    <?php
    echo ucfirst(str_replace('_', ' ', $label)) ?? 'Label';
    ?>
</label>