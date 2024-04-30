<select class="form-select" name="<?= $name ?? '' ?>" id="<?= $id ?? '' ?>" <?= $disabled ?? null ?>>
    <?php if (isset($categories)) : ?>
        <option value=""></option>
        <?php foreach ($categories as $key => $value) : ?>
            <option <?= (isset($selected) && $selected == $value['category']) ? 'selected' : '' ?> value="<?= $value['category'] ?>"><?= $value['category'] ?></option>
        <?php endforeach; ?>
    <?php else : ?>
        <option>Failed load categories</option>
    <?php endif; ?>
</select>