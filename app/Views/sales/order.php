<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- SALES ORDER -->
<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/sales-new', 'name' => 'Back'], 'action' => 'Order']) ?>
</div>

<?= view('components/alert') ?>

<section>
    <form action="<?= $action ?>" method="POST">
        <div class="overflow-y-auto mb-3">
            <div style="min-width: 1300px">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 30px;" scope="col">#</th>
                            <?php foreach ($sale_order_column as $column) : ?>
                                <?php if ($column->name == 'id') : ?>
                                    <?php continue; ?>
                                <?php elseif ($column->name == 'quantity') : ?>
                                    <th style="text-align: center" scope="col"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                                <?php else : ?>
                                    <th scope="col"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <th>Sub total</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $data = 0;
                        $total = 0;
                        $numb = 1;
                        foreach ($sales_orders as $sales_order) :
                        ?>
                            <tr>
                                <td scope="row"><?= $numb ?></td>

                                <?php foreach ($sale_order_column as $column) : ?>
                                    <?php if ($column->name == 'id') : ?>
                                        <?php continue; ?>

                                    <?php elseif ($column->name == 'product_price') : ?>
                                        <!-- PRODUCT PRICE -->
                                        <?php
                                        $temp = '';
                                        $hundred = 0;
                                        for ($i = strlen($sales_order[$column->name]) - 1; $i >= 0; $i--) {
                                            if ($hundred == 3) {
                                                $temp = $sales_order[$column->name][$i] . '.' . $temp;
                                                $hundred = 0;
                                            } else {
                                                $temp = $sales_order[$column->name][$i] . $temp;
                                            }
                                            $hundred++;
                                        }
                                        ?>

                                        <td style="width: 150px;">
                                            <input readonly class="form-control p-0 px-1 m-0 product_price" type="text" id="qty_<?= $sales_order['product_price'] ?>" name="<?= "data[$data][$column->name]" ?>" value="<?= ucfirst(str_replace('_', ' ', $sales_order[$column->name])) ?>">
                                        </td>
                                        <!-- PRODUCT PRICE -->
                                    <?php elseif ($column->name == 'quantity') : ?>
                                        <td style="text-align: center; width: 30px;" scope="col">
                                            <input class="form-control p-0 px-1 m-0 quantity" type="number" id="qty_<?= $sales_order['product_id'] ?>" name="<?= "data[$data][$column->name]" ?>" value="<?= ucfirst(str_replace('_', ' ', $sales_order[$column->name])) ?>">
                                        </td>
                                        <!-- <td style="text-align: center;" scope="col"><?php // echo ucfirst(str_replace('_', ' ', $sales_order[$column->name])) 
                                                                                            ?></td> -->
                                    <?php
                                    else : ?>
                                        <input type="hidden" name="<?= "data[$data][$column->name]" ?>" value="<?= ucfirst(str_replace('_', ' ', $sales_order[$column->name])) ?>">
                                        <td scope="col"><?= ucfirst(str_replace('_', ' ', $sales_order[$column->name])) ?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <!-- SUB TOTAL -->
                                <?php
                                $temp = '';
                                $sub_total = (string) ($sales_order['product_price'] * $sales_order['quantity']);
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

                                <!-- SUB TOTAL -->
                                <td style="width: 150px;">
                                    <input readonly class="form-control p-0 px-1 m-0 sub_total" type="number" id="sub_total_<?= $sales_order['product_id'] ?>" name="<?= "data[$data][sub_total]" ?>" value="<?= $sub_total ?>">
                                </td>

                                <!-- DELETE -->
                                <td class="text-center" style="width: 40px">
                                    <div data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/sales-order-delete/<?= $sales_order['product_id'] ?>')">
                                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg>
                                    </div>
                                </td>
                                <!-- DELETE -->
                            </tr>

                        <?php
                            $data++;
                            $numb++;
                        endforeach;
                        ?>

                        <!-- ======================= SUB TOTAL ======================= -->
                        <tr class="table-active">
                            <td style="width: 30px;" scope="row"></td>
                            <?php foreach ($sale_order_column as $column) : ?>
                                <?php if ($column->name == 'id') : ?>
                                    <?php continue; ?>

                                <?php elseif ($column->name == 'quantity') : ?>
                                    <th style="text-align: center;">Total</th>

                                <?php else : ?>
                                    <td></td>

                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- TOTAL -->
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

                            <!-- TOTAL -->
                            <td style="width: 150px;">
                                <input readonly class="form-control p-0 px-1 m-0 total" type="number" id="total" name="total" value="<?= $total ?>">
                            </td>
                            <!-- TOTAL -->

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-3 input-group">
            <button type="submit" class="btn btn-primary">Checkout</button>
        </div>

    </form>
</section>

<script>
    let quantities = document.getElementsByClassName('quantity');
    let products_price = document.getElementsByClassName('product_price');
    let sub_totals = document.getElementsByClassName('sub_total');
    let total = document.getElementById('total');

    // for (let quantity of quantities) {
    //     let id = quantity.getAttribute('id').split('_')[1];
    //     console.log(id);
    // }

    for (let i = 0; i < quantities.length; i++) {
        quantities[i].onchange = () => {
            if (quantities[i].value < 1) {
                quantities[i].value = 1;
            } else {
                sub_totals[i].value = products_price[i].value * quantities[i].value;
            }

            updateTotal();
        }

        // console.log(products_price[i]);
        // console.log(quantities[i]);
        // console.log(sub_totals[i]);
    }

    function updateTotal() {
        let new_total = 0;

        for (let j = 0; j < sub_totals.length; j++) {
            new_total += Number(sub_totals[j].value);
            // console.log(Number(sub_totals[j].value));
        }

        total.value = new_total;
    }

    // for (let product_price of products_price) {
    //     console.log(product_price);
    // }

    // for (let sub_total of sub_totals) {
    //     console.log(sub_total);
    // }
</script>

<?= $this->endSection('content') ?>