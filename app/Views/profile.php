<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<section class="mb-4">
    <h3 class="mb-3 fw-semibold">My profile</h3>
    <table class="rounded table mb-0 border border-1 shadow-sm">
        <tbody>

            <?php foreach ($columns as $column) : ?>
                <tr class="table">
                    <?php if ($column->name == 'id' || $column->name == 'password') : ?>
                        <?php continue; ?>
                    <?php else : ?>
                        <div class="row">
                            <td class="col-6 fw-semibold"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></td>

                            <!-- ROLE -->
                            <?php if ($column->name == 'role' && session()->get('user')[$column->name] != null) : ?>
                                <td class="col-6">
                                    <?= session()->get('user')[$column->name] ?>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>
                                </td>
                            <?php else : ?>
                                <td class="col-6">
                                    <?= session()->get('user')[$column->name] ?>
                                </td>
                            <?php endif; ?>
                            <!-- ROLE -->

                        </div>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>
<?= $this->endSection('content') ?>