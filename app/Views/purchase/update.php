<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<h2><?= $purchase_id ?></h2>

<!-- PURCHASE ORDER -->
<div class="mb-4">
    <?= view('components/breadcrumb', ['base' => ['link' => '/purchase', 'name' => 'Purchases'], 'action' => 'Purchase update']) ?>
</div>

<form action="/purchase-update" method="POST">

    <?php foreach ($purchase_column as $column) :
        $column = $column->name;
    ?>

        <?php if ($column === 'id' || $column === 'created_at' || $column === 'total') : ?>
            <div class="mb-3">
                <?= view('components/label', ['label' => $column]) ?>
                <?= view('components/input-text', ['id' => $column, 'name' => $column, 'value' => $purchase[$column], 'readonly' => 'readonly']) ?>
                <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => $column]) ?>
            </div>

        <?php elseif ($column === 'status') : ?>
            <div class="mb-3">
                <?= view('components/label', ['label' => $column]) ?>
                <select class="form-select" name="<?= $column ?>" id="<?= $column ?>">
                    <option <?php if ($purchase[$column] == 'Sent') : echo 'selected';
                            endif; ?> value="Sent">Sent</option>
                    <option <?php if ($purchase[$column] == 'Pending') : echo 'selected';
                            endif; ?> value="Pending">Pending</option>
                </select>
                <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => $column]) ?>
            </div>

        <?php elseif ($column === 'admin_email') : ?>
            <div class="mb-3">
                <?= view('components/label', ['label' => $column]) ?>
                <select class="form-select" name="<?= $column ?>" id="<?= $column ?>">

                    <?php foreach ($admin_email as $email) : ?>
                        <option <?php if ($email['email'] == $purchase[$column]) : echo 'selected';
                                endif; ?> value="<?= $email['email'] ?>"><?= $email['email'] ?></option>
                    <?php endforeach; ?>

                </select>
                <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => $column]) ?>
            </div>

        <?php else : ?>
            <div class="mb-3">
                <?= view('components/label', ['label' => $column]) ?>
                <?= view('components/input-text', ['id' => $column, 'name' => $column, 'value' => $purchase[$column], 'readonly' => null]) ?>
                <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => $column]) ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>

</form>


<?= $this->endSection('content') ?>