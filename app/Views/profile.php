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
                            <td class="col-6"><?= session()->get('user')[$column->name] ?></td>
                        </div>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>
<?= $this->endSection('content') ?>