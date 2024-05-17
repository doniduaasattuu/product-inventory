<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<h2><?= $purchase_id ?></h2>

<!-- PURCHASE ORDER -->
<div class="mb-4">
    <?= view('components/breadcrumb', ['base' => ['link' => '/purchase', 'name' => 'Purchases'], 'action' => 'Purchase update']) ?>
</div>

<?= view('components/alert') ?>

<section class="mb-4">
    <form action="/purchase-update" method="POST">

        <?php foreach ($purchase_column as $column) :
            $column = $column->name;
        ?>

            <?php if ($column === 'id' || $column === 'created_at' || $column === 'updated_at' || $column === 'total') : ?>
                <div class="mb-3">
                    <?= view('components/label', ['label' => $column]) ?>
                    <?= view('components/input-text', ['id' => $column, 'name' => $column, 'value' => $purchase[$column], 'readonly' => 'readonly']) ?>
                    <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => $column]) ?>
                </div>

            <?php elseif ($column === 'status') : ?>
                <div class="mb-3">
                    <?= view('components/label', ['label' => $column]) ?>
                    <select <?php if ($purchase[$column] == 'Done') : echo 'disabled';
                            endif; ?> class="form-select" name="<?= $column ?>" id="<?= $column ?>">
                        <?php foreach ($status as $data) : ?>
                            <option <?php if ($purchase[$column] == $data) : echo 'selected';
                                    endif; ?> value="<?= $data ?>"><?= $data ?></option>
                        <?php endforeach; ?>
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
</section>

<section>
    <h4 class="fw-semibold">Purchase Detail</h4>
    <div class="overflow-y-auto">
        <div style="min-width: 1250px">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 30px;" scope="col">#</th>
                        <?php foreach ($purchase_detail_column as $column) : ?>

                            <?php if ($column->name === 'id') : continue; ?>
                            <?php else : ?>
                                <th scope="col"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $numb = 1;
                    foreach ($purchase_detail as $detail) :
                    ?>
                        <tr>
                            <td scope="row"><?= $numb ?></td>
                            <?php foreach ($purchase_detail_column as $column) : ?>

                                <?php if ($column->name === 'id') : continue; ?>
                                <?php else : ?>
                                    <td scope="col"><?= ucfirst(str_replace('_', ' ', $detail[$column->name])) ?></td>
                                <?php endif; ?>

                            <?php endforeach ?>
                        </tr>
                    <?php
                        $numb++;
                    endforeach;
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</section>


<?= $this->endSection('content') ?>