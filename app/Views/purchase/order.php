<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- PURCHASE ORDER -->
<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/purchase-new', 'name' => 'Back'], 'action' => 'Order']) ?>
</div>

<section>
    <form action="/purchase-detail" method="POST">
        <div class="overflow-y-auto mb-3">
            <div style="min-width: 1000px">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 30px;" scope="col">#</th>
                            <?php foreach ($purchase_order_column as $column) : ?>
                                <?php if ($column->name == 'id' || $column->name == 'admin_email' || $column->name == 'created_at' || $column->name == 'updated_at' || $column->name == 'attachment') : ?>
                                    <?php continue; ?>
                                <?php elseif ($column->name == 'attachment') : ?>
                                    <th style="text-align: center" scope="col">Image</th>
                                <?php else : ?>
                                    <th scope="col"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $data = 0;
                        $total = 0;
                        $numb = 1;
                        foreach ($purchase_orders as $purchase_order) :
                        ?>
                            <tr>
                                <td scope="row"><?= $numb ?></td>

                                <?php foreach ($purchase_order_column as $column) : ?>
                                    <?php if ($column->name == 'id') : ?>
                                        <?php continue; ?>

                                    <?php elseif ($column->name == 'product_price') : ?>
                                        <!-- PRODUCT PRICE -->
                                        <?php
                                        $temp = '';
                                        $hundred = 0;
                                        for ($i = strlen($purchase_order[$column->name]) - 1; $i >= 0; $i--) {
                                            if ($hundred == 3) {
                                                $temp = $purchase_order[$column->name][$i] . '.' . $temp;
                                                $hundred = 0;
                                            } else {
                                                $temp = $purchase_order[$column->name][$i] . $temp;
                                            }
                                            $hundred++;
                                        }
                                        ?>
                                        <input type="hidden" name="<?= "data[$data][product_price]" ?>" value="<?= $purchase_order[$column->name] ?>">
                                        <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                                        <!-- PRODUCT PRICE -->
                                    <?php
                                    else : ?>
                                        <input type="hidden" name="<?= "data[$data][$column->name]" ?>" value="<?= ucfirst(str_replace('_', ' ', $purchase_order[$column->name])) ?>">
                                        <td scope="col"><?= ucfirst(str_replace('_', ' ', $purchase_order[$column->name])) ?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <!-- SUB TOTAL -->
                                <?php
                                $temp = '';
                                $sub_total = (string) ($purchase_order['product_price'] * $purchase_order['quantity']);
                                $total += $sub_total;
                                $hundred = 0;
                                for ($i = strlen($sub_total) - 1; $i >= 0; $i--) {
                                    if ($hundred == 3) {
                                        $temp = $sub_total[$i] . '.' . $temp;
                                        $hundred = 0;
                                    } else {
                                        $temp = $sub_total[$i] . $temp;
                                    }
                                    $hundred++;
                                }
                                ?>
                                <input type="hidden" name="<?= "data[$data][sub_total]" ?>" value="<?= $sub_total ?>">
                                <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                                <!-- SUB TOTAL -->

                            </tr>

                        <?php
                            $data++;
                            $numb++;
                        endforeach;
                        ?>

                        <!-- ======================= SUB TOTAL ======================= -->
                        <tr class="table-active">
                            <td style="width: 30px;" scope="row"></td>
                            <?php foreach ($purchase_order_column as $column) : ?>
                                <?php if ($column->name == 'id') : ?>
                                    <?php continue; ?>

                                <?php elseif ($column->name == 'product_price') : ?>

                                <?php endif; ?>
                                <td></td>
                            <?php endforeach; ?>

                            <!-- SUB TOTAL -->
                            <?php
                            $temp = '';
                            $string_total = (string) $total;
                            $hundred = 0;
                            for ($i = strlen($string_total) - 1; $i >= 0; $i--) {
                                if ($hundred == 3) {
                                    $temp = $string_total[$i] . '.' . $temp;
                                    $hundred = 0;
                                } else {
                                    $temp = $string_total[$i] . $temp;
                                }
                                $hundred++;
                            }
                            ?>
                            <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                            <!-- SUB TOTAL -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
</section>

<?= $this->endSection('content') ?>