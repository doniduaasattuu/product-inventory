<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- SALES NEW -->
<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/sales', 'name' => 'Sales'], 'action' => 'New']) ?>
</div>

<?php if (isset($sale_order) && null != $sale_order) : ?>
    <div class="mb-3">
        <div class="btn-group dropend">
            <button type="button" class="btn btn-success">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/sales-order">
                    <div>
                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                        Sales order
                    </div>
                </a>
            </button>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <div style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_confirm" class="px-2" onclick="return modalConfirm('/sales-order-delete')">
                        Delete sales order
                    </div>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?= view('components/alert') ?>

<div class="row mb-3">
    <!-- FILTER -->
    <div class="col pe-1">
        <?= view('components/label', ['label' => 'filter']) ?>
        <?= view('components/input-text', ['id' => 'filter', 'name' => 'filter', 'placeholder' => 'Product name']) ?>
    </div>
    <!-- FILTER CATEGORY -->
    <div class="col ps-1">
        <?= view('components/label', ['label' => 'category']) ?>
        <?= view('components/input-select', ['id' => 'category', 'name' => 'category', 'categories' => $categories ?? null]) ?>
    </div>
</div>

<section>
    <div class="overflow-y-auto">
        <div style="min-width: 1000px">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 30px;" scope="col">#</th>
                        <?php foreach ($product_column as $column) : ?>
                            <?php if ($column->name == 'id' || $column->name == 'admin_email' || $column->name == 'created_at' || $column->name == 'updated_at' || $column->name == 'attachment') : ?>
                                <?php continue; ?>
                            <?php elseif ($column->name == 'attachment') : ?>
                                <th style="text-align: center" scope="col">Image</th>
                            <?php else : ?>
                                <th scope="col"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- ACTION BUTTON -->
                        <th scope="col">Add</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    $numb = 1;
                    foreach ($products as $product) :
                    ?>
                        <tr>
                            <td scope="row"><?= $numb ?></td>

                            <?php foreach ($product_column as $column) : ?>
                                <?php if ($column->name == 'id' || $column->name == 'admin_email' || $column->name == 'created_at' || $column->name == 'updated_at' || $column->name == 'attachment') : ?>
                                    <?php continue; ?>
                                    <!-- PRICE -->
                                <?php elseif ($column->name == 'price') : ?>
                                    <?php
                                    $temp = '';
                                    $hundred = 0;
                                    for ($i = strlen($product[$column->name]) - 1; $i >= 0; $i--) {
                                        if ($hundred == 3) {
                                            $temp = $product[$column->name][$i] . '.' . $temp;
                                            $hundred = 0;
                                        } else {
                                            $temp = $product[$column->name][$i] . $temp;
                                        }
                                        $hundred++;
                                    }
                                    ?>
                                    <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                                    <!-- PRICE -->
                                <?php elseif ($column->name == 'attachment') : ?>
                                    <!-- ATTACHMENT -->
                                    <?php if ($product[$column->name] != null) : ?>
                                        <td style="text-align: center">
                                            <a href="/images/products/<?= $product[$column->name] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z" />
                                                </svg>
                                            </a>
                                        </td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php endif; ?>
                                    <!-- ATTACHMENT -->
                                <?php else : ?>
                                    <td scope="col"><?= ucfirst(str_replace('_', ' ', $product[$column->name])) ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- ADD -->
                            <td class="text-center" style="width: 40px; cursor: pointer;">
                                <a href="/sales-order/<?= $product['id'] ?>">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d6efd" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                    </svg>
                                </a>
                            </td>
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

<script>
    let filter = document.getElementById("filter");
    let category = document.getElementById("category");

    fillInputFilterFromUrlSearchParams(filter, category)

    function doFilter() {
        filterFunction(filter, category);
    }

    filter.oninput = debounce(doFilter, 300);
    category.oninput = debounce(doFilter, 0);
</script>


<?= $this->endSection('content') ?>