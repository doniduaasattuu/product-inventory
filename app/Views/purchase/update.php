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
                    <select id="status" <?php if ($purchase[$column] == 'Done') : echo 'disabled';
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

<!-- PURCHASE DETAIL DATA -->
<section>
    <h4 class="fw-semibold">Purchase Detail</h4>
    <div class="overflow-y-auto">
        <div style="min-width: 1300px">

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
                    $total = 0;
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
                        $total += $detail['sub_total'];
                        $numb++;
                    endforeach;
                    ?>

                    <tr class="table-active">
                        <td></td>
                        <?php foreach ($purchase_detail_column as $column) : ?>

                            <?php if ($column->name === 'id') : continue; ?>
                            <?php elseif ($column->name === 'quantity') : ?>
                                <th>Total</th>
                            <?php elseif ($column->name === 'sub_total') : ?>
                                <td><?= $total ?></td>
                            <?php else : ?>
                                <td></td>
                            <?php endif; ?>

                        <?php endforeach ?>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- MESSAGE IF PURCHASE IS DONE -->
<div class="modal fade" id="modal_done" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="min-width: 330px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class=" modal-title fs-5" id="exampleModalLabel">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                    </svg>
                    Information
                </h1>
            </div>
            <div class="modal-body">
                <span id="modal_message">If status is done, product stock will be updated.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- MESSAGE IF PURCHASE IS DONE -->

<script>
    let status = document.getElementById('status');
    let modalDone = new bootstrap.Modal(document.getElementById('modal_done'), {});

    status.onchange = () => {
        if (status.value == 'Done') {
            modalDone.show();
        }
    }
</script>

<?= $this->endSection('content') ?>