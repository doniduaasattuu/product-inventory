<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<?= view('components/breadcrumb', ['base' => ['link' => '/', 'name' => 'Home'], 'action' => 'Purchases']) ?>

<?= view('components/header-transaction', ['name' => 'New Purchase', 'link' => '/purchase-new']) ?>

<?= view('components/alert') ?>

<!-- PURCHASE DATA -->
<?php if ($purchases != null && count($purchases) > 0) : ?>
    <!-- PURCHASE TREND -->
    <?= view('components/canvas-trend', ['title' => 'Purchase trends', 'table' => 'purchases']) ?>

    <!-- PURCHASE DATA -->
    <h4 class="text-center">Purchase Data</h4>
    <div class="overflow-y-auto">
        <div style="min-width: 1500px">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 30px;" scope="col">#</th>
                        <?php foreach ($purchase_column as $column) : ?>
                            <th><?= ucfirst(str_replace('_', ' ', $column->name == 'admin_email' ? 'Admin' : $column->name)) ?></th>
                        <?php endforeach; ?>

                        <!-- ACTION BUTTON -->
                        <?php
                        $user = session()->get('user');
                        if ($user != null && $user->role == 'Admin' || 'Manager') : ?>

                            <?php if ($user->role == 'Manager') : ?>
                                <th scope="col">Update</th>
                            <?php endif; ?>

                            <th scope="col">Detail</th>
                            <th scope="col">Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $numb = 1;
                    foreach ($purchases as $purchase) :
                    ?>
                        <tr>
                            <td style="width: 30px;" scope="row"><?= $numb ?></td>
                            <?php foreach ($purchase_column as $column) : ?>
                                <?php if ($column->name == 'id') : ?>
                                    <td style="font-family: Monospace;" scope="row"><?= $purchase[$column->name] ?></td>
                                <?php elseif ($column->name == 'admin_email') : ?>
                                    <td scope="row"><?php echo db_connect()->table('users')->where('email', $purchase[$column->name])->get()->getFirstRow()->name ?></td>
                                <?php elseif ($column->name == 'total') : ?>
                                    <!-- TOTAL -->
                                    <?php
                                    $temp = '';
                                    $hundred = 0;
                                    for ($i = strlen($purchase[$column->name]) - 1; $i >= 0; $i--) {
                                        if ($hundred == 3) {
                                            $temp = $purchase[$column->name][$i] . '.' . $temp;
                                            $hundred = 0;
                                        } else {
                                            $temp = $purchase[$column->name][$i] . $temp;
                                        }
                                        $hundred++;
                                    }
                                    ?>
                                    <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                                    <!-- TOTAL -->
                                <?php else : ?>
                                    <td scope="row"><?= $purchase[$column->name] ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php if ($user != null && $user->role == 'Admin' || 'Admin') : ?>

                                <?php if ($user->role == 'Manager') : ?>
                                    <!-- UPDATE -->
                                    <td class="text-center" style="width: 40px">
                                        <a href="/purchase-update/<?= $purchase['id'] ?>">
                                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#0d6efd" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <!-- INFO -->
                                <td class="text-center" style="width: 40px">
                                    <a href="/purchase-detail/<?= $purchase['id'] ?>">
                                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                    </a>
                                </td>
                                <!-- DELETE -->
                                <td class="text-center" style="width: 40px">
                                    <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/purchase-delete/<?= $purchase['id'] ?>')">
                                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg>
                                    </button>
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
<?php else : ?>
    <?= view('components/not-found-svg') ?>
<?php endif; ?>

<script>
    const action_button = document.getElementById('action_button');
    const start_date = document.getElementById('start_date');
    const end_date = document.getElementById('end_date');
    action_button.onclick = () => {
        filterFunction(start_date, end_date);
    }

    fillInputFilterFromUrlSearchParams(start_date, end_date)

    const created_at = <?php echo json_encode($created_at) ?>;
    const admin = <?php echo json_encode($admin) ?>;
    const footer = (tooltipItems) => {
        return 'By: ' + admin[tooltipItems[0].dataIndex];
    };

    // PURCHASES
    var ctxt = document.getElementById('purchases').getContext('2d');
    var purchases = new Chart(ctxt, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($total) ?>,
                label: "Total (Rp)",
                borderColor: "rgb(46, 196, 182)",
                backgroundColor: "rgb(46, 196, 182)",
                fill: false,
                tension: 0.3,
            }, ],
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        footer: footer
                    },
                },
                legend: {
                    position: "bottom",
                }
            },
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        color: function(context) {
                            return '#303133';
                        },
                    },
                },
                y: {
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    ticks: {
                        callback: function(value, index, ticks) {
                            if (value != null && value > 1000000) {
                                value = value / 1000000;
                                return value + " Jt";
                            } else {
                                return value;
                            }
                        }
                    },
                    // ticks: {
                    //     display: false,
                    // },
                    grid: {
                        color: function(context) {
                            return '#303133';
                        },
                    },
                },
                // y2: {
                //     type: 'category',
                //     labels: ['Run', 'Stop'],
                //     offset: true,
                //     position: 'left',
                //     stack: 'demo',
                //     stackWeight: 1,
                //     grid: {
                //         color: function(context) {
                //             return '#303133';
                //         },
                //     },
                // }
            },
        },
    });
</script>

<?= $this->endSection('content') ?>