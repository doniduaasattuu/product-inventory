<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<?= view('components/breadcrumb', ['base' => ['link' => '/', 'name' => 'Home'], 'action' => 'Sales']) ?>

<?= view('components/header-transaction', ['name' => 'New Sales', 'link' => '/sales-new']) ?>

<?= view('components/alert') ?>

<!-- SALES DATA -->
<?php if ($sales != null && count($sales) > 0) : ?>

    <!-- SALES TREND -->
    <?= view('components/canvas-trend', ['title' => 'Sales trend', 'table' => 'sales']) ?>

    <!-- SALES DATA -->
    <h4 class="text-center">Sales Data</h4>
    <div class="overflow-y-auto">
        <div style="min-width: 1200px">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 30px;" scope="col">#</th>
                        <?php foreach ($sales_column as $column) : ?>
                            <th><?= ucfirst(str_replace('_', ' ', $column->name == 'admin_email' ? 'Admin' : $column->name)) ?></th>
                        <?php endforeach; ?>

                        <!-- ACTION BUTTON -->
                        <?php
                        $user = session()->get('user');
                        if ($user != null && $user->role == 'Admin' || 'Manager') : ?>
                            <th scope="col">Detail</th>
                            <th scope="col">Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $numb = 1;
                    foreach ($sales as $sale) :
                    ?>
                        <tr>
                            <td style="width: 30px;" scope="row"><?= $numb ?></td>
                            <?php foreach ($sales_column as $column) : ?>
                                <?php if ($column->name == 'id') : ?>
                                    <td style="font-family: Monospace;" scope="row"><?= $sale[$column->name] ?></td>
                                <?php elseif ($column->name == 'admin_email') : ?>
                                    <td scope="row"><?php echo db_connect()->table('users')->where('email', $sale[$column->name])->get()->getFirstRow()->name ?></td>
                                <?php elseif ($column->name == 'total') : ?>
                                    <!-- TOTAL -->
                                    <?php
                                    $temp = '';
                                    $hundred = 0;
                                    for ($i = strlen($sale[$column->name]) - 1; $i >= 0; $i--) {
                                        if ($hundred == 3) {
                                            $temp = $sale[$column->name][$i] . '.' . $temp;
                                            $hundred = 0;
                                        } else {
                                            $temp = $sale[$column->name][$i] . $temp;
                                        }
                                        $hundred++;
                                    }
                                    ?>
                                    <td scope="col"><?= 'Rp' . ucfirst(str_replace('_', ' ', $temp)) . ',-' ?></td>
                                    <!-- TOTAL -->
                                <?php else : ?>
                                    <td scope="row"><?= $sale[$column->name] ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php if ($user != null && $user->role == 'Admin' || 'Admin') : ?>

                                <!-- INFO -->
                                <td class="text-center" style="width: 40px">
                                    <a href="/sales-detail/<?= $sale['id'] ?>">
                                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                    </a>
                                </td>
                                <!-- DELETE -->
                                <td class="text-center" style="width: 40px">
                                    <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/sales-delete/<?= $sale['id'] ?>')">
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

    // SALES
    var ctxt = document.getElementById('sales').getContext('2d');
    var sales = new Chart(ctxt, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($total) ?>,
                label: "Total (Rp)",
                borderColor: "rgb(138, 201, 38)",
                backgroundColor: "rgb(138, 201, 38)",
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