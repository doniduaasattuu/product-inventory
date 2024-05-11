<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<?= view('components/header-products') ?>

<?= view('components/alert') ?>

<?php if (!session()->get('user')) : ?>
    <div class="alert alert-warning" role="alert">You're not logged in yet, <a class="alert-link fw-semibold" href="/login">login here.</a></div>
<?php endif; ?>

<div class="overflow-y-auto">
    <div style="min-width: 1500px">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 30px;" scope="col">#</th>
                    <?php foreach ($product_column as $column) : ?>
                        <?php if ($column->name == 'id' || $column->name == 'admin_email' || $column->name == 'created_at') : ?>
                            <?php continue; ?>
                        <?php elseif ($column->name == 'attachment') : ?>
                            <th style="text-align: center" scope="col">Image</th>
                        <?php else : ?>
                            <th scope="col"><?= ucfirst(str_replace('_', ' ', $column->name)) ?></th>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- ACTION BUTTON -->
                    <?php if (session()->get('user')) : ?>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    <?php else : ?>
                        <th scope="col">Detail</th>
                    <?php endif; ?>

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
                            <?php if ($column->name == 'id' || $column->name == 'admin_email' || $column->name == 'created_at') : ?>
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

                        <?php if (session()->get('user')) : ?>
                            <!-- EDIT -->
                            <td class="text-center" style="width: 40px">
                                <a href="/product-update/<?= $product['id'] ?>">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#0d6efd" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </a>
                            </td>
                            <!-- DELETE -->
                            <td class="text-center" style="width: 40px">
                                <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/product-delete/<?= $product['id'] ?>')">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </button>
                            </td>
                        <?php else : ?>
                            <!-- INFO -->
                            <td class="text-center" style="width: 40px">
                                <a href="/product-detail/<?= $product['id'] ?>">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    </svg>
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php
                    $numb++;
                endforeach;
                ?>

            </tbody>
        </table>
    </div>
</div>

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