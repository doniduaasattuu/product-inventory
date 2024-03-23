<select class="form-select" name="<?= $name ?? '' ?>" id="<?= $id ?? '' ?>">
    <?php if (isset($categories)) : ?>
        <option value=""></option>
        <?php foreach ($categories as $key => $value) : ?>
            <option value="<?= $value['category'] ?>"><?= $value['category'] ?></option>
        <?php endforeach; ?>
    <?php else : ?>
        <option>Failed load categories</option>
    <?php endif; ?>
</select>