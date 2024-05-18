<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/sales', 'name' => 'Sales'], 'action' => $sales_id]) ?>
</div>

<!-- SALES DATA -->
<div class="overflow-y-auto">
    <div style="min-width: 1200px">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 30px;" scope="col">#</th>
                    <?php foreach ($sales_details_column as $column) : ?>

                        <?php if ($column->name == 'id' || $column->name == 'sales_id') : continue; ?>
                        <?php elseif ($column->name == 'quantity') : ?>
                            <th style="text-align: center;"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                        <?php else : ?>
                            <th><?= ucfirst(str_replace('_', ' ', $column->name == 'admin_email' ? 'Admin' : $column->name)) ?></th>
                        <?php endif;  ?>

                    <?php endforeach; ?>

                </tr>
            </thead>
            <tbody>

                <?php
                $numb = 1;
                foreach ($sales_details as $sale_detail) :
                ?>
                    <tr>
                        <td style="width: 30px;" scope="row"><?= $numb ?></td>
                        <?php foreach ($sales_details_column as $column) : ?>

                            <?php if ($column->name == 'id' || $column->name == 'sales_id') : continue; ?>
                            <?php elseif ($column->name == 'product_id') : ?>
                                <td style="font-family: Monospace;" scope="row"><?= $sale_detail[$column->name] ?></td>
                            <?php elseif ($column->name == 'product_price' || $column->name == 'sub_total') : ?>
                                <!-- TOTAL -->
                                <?php
                                $temp = '';
                                $hundred = 0;
                                for ($i = strlen($sale_detail[$column->name]) - 1; $i >= 0; $i--) {
                                    if ($hundred == 3) {
                                        $temp = $sale_detail[$column->name][$i] . '.' . $temp;
                                        $hundred = 0;
                                    } else {
                                        $temp = $sale_detail[$column->name][$i] . $temp;
                                    }
                                    $hundred++;
                                }
                                ?>
                                <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                            <?php elseif ($column->name == 'quantity') : ?>
                                <td style="text-align: center;" scope="row"><?= $sale_detail[$column->name] ?></td>
                            <?php else : ?>
                                <td scope="row"><?= $sale_detail[$column->name] ?></td>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </tr>
                <?php
                    $numb++;
                endforeach;
                ?>

                <tr class="table-active">
                    <td style="width: 30px;" scope="row"></td>
                    <?php foreach ($sales_details_column as $column) : ?>
                        <?php if ($column->name == 'id' || $column->name == 'sales_id') : continue; ?>

                        <?php elseif ($column->name == 'sub_total') : ?>
                            <!-- TOTAL -->
                            <?php
                            $temp = '';
                            $total = $sales->total;
                            $hundred = 0;
                            for ($i = strlen($total) - 1; $i >= 0; $i--) {
                                if ($hundred == 3) {
                                    $temp = $total[$i] . '.' . $temp;
                                    $hundred = 0;
                                } else {
                                    $temp = $total[$i] . $temp;
                                }
                                $hundred++;
                            }
                            ?>
                            <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>

                        <?php elseif ($column->name == 'quantity') : ?>
                            <th style="text-align: center;">Total</th>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection('content') ?>