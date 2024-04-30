<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['action' => 'Categories']) ?>
</div>

<?= view('components/alert') ?>

<form action="/category-new" method="POST">
    <div class="mb-3">
        <div class="input-group">
            <?= view('components/input-text', ['id' => 'category', 'name' => 'category', 'placeholder' => 'New category', 'required' => 'required']) ?>
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
            </button>
        </div>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'category']) ?>
    </div>
</form>


<div class="overflow-y-auto">
    <div style="min-width: 330px">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Category</th>

                    <!-- ACTION BUTTON -->
                    <?php if (session()->get('user')) : ?>
                        <th scope="col">Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($categories as $category) : ?>
                    <tr>
                        <td><?= $i ?? '' ?></td>
                        <td scope="col"><?= ucfirst(str_replace('_', ' ', $category['category'])) ?></td>
                        <?php if (session()->get('user')) : ?>
                            <!-- DELETE -->
                            <td class="text-center" style="width: 40px">
                                <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/category-delete/<?= $category['category'] ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php
                    $i++;
                endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection('content') ?>