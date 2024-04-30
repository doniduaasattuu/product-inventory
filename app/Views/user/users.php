<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['action' => 'List of Users']) ?>
</div>

<?= view('components/alert') ?>

<div class="overflow-y-auto">
    <div style="min-width: 330px">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>

                    <!-- ACTION BUTTON -->
                    <?php foreach ($user_columns as $column) : ?>
                        <th scope="col"><?= ucfirst(str_replace('_', '', $column->name)) ?></th>
                    <?php endforeach; ?>

                    <!-- DELETE -->
                    <?php if (session()->get('user')) : ?>
                        <th scope="col">Reset</th>
                        <th scope="col">Delete</th>
                    <?php endif; ?>
                    <!-- DELETE -->
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $i ?? '' ?></td>

                        <?php foreach ($user_columns as $column) : ?>
                            <?php if ($column->name == 'password') : ?>
                                <td scope="col"><?= base64_encode($user[$column->name]) ?></td>
                            <?php else : ?>
                                <td scope="col"><?= ucfirst(str_replace('_', ' ', $user[$column->name])) ?></td>
                            <?php endif; ?>
                        <?php endforeach ?>

                        <!-- RESET -->
                        <?php if (session()->get('user')) : ?>
                            <td class="text-center" style="width: 40px">
                                <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/user-reset/<?= $user['id'] ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d6efd" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                    </svg>
                                </button>
                            </td>
                        <?php endif; ?>
                        <!-- RESET -->

                        <!-- DELETE -->
                        <?php if (session()->get('user')) : ?>
                            <td class="text-center" style="width: 40px">
                                <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/user-delete/<?= $user['id'] ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </button>
                            </td>
                        <?php endif; ?>
                        <!-- DELETE -->
                    </tr>
                <?php
                    $i++;
                endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection('content') ?>