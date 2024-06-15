<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/', 'name' => 'Home'], 'action' => 'List of Users']) ?>
</div>

<?= view('components/alert') ?>

<div class="overflow-y-auto">
    <div style="min-width: 992px">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>

                    <!-- ACTION BUTTON -->
                    <?php foreach ($user_columns as $column) : ?>
                        <th scope="col"><?= ucfirst(str_replace('_', '', $column->name)) ?></th>
                    <?php endforeach; ?>

                    <!-- DELETE -->
                    <?php if (session()->get('user')->role == 'Manager') : ?>
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
                            <?php elseif ($column->name == 'role') : ?>
                                <td scope="col" style="width: 150px;">
                                    <select class="form-select role" user_id='<?= $user['id'] ?>'>
                                        <option value=""></option>
                                        <option <?php if ($user[$column->name] == 'Admin') : echo 'selected';
                                                endif; ?> value="Admin">Admin</option>
                                        <option <?php if ($user[$column->name] == 'Manager') : echo 'selected';
                                                endif; ?> value="Manager">Manager</option>
                                    </select>
                                </td>
                            <?php elseif ($column->name == 'email') : ?>
                                <td scope="col"><?= $user[$column->name] ?></td>
                            <?php else : ?>
                                <td scope="col"><?= ucfirst(str_replace('_', ' ', $user[$column->name])) ?></td>
                            <?php endif; ?>
                        <?php endforeach ?>

                        <?php if (session()->get('user')->role == 'Manager') : ?>
                            <!-- RESET -->
                            <td class="text-center" style="width: 40px">
                                <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/user-reset/<?= $user['id'] ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d6efd" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                    </svg>
                                </button>
                            </td>
                            <!-- RESET -->

                            <!-- DELETE -->
                            <td class="text-center" style="width: 40px">
                                <button data-bs-toggle="modal" data-bs-target="#modal_confirm" class="btn p-0 m-0" onclick="return modalConfirm('/user-delete/<?= $user['id'] ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </button>
                            </td>
                            <!-- DELETE -->
                        <?php endif; ?>

                    </tr>
                <?php
                    $i++;
                endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- MESSAGE IF ROLE ASSIGNMENT SUCCESS -->
<div class="modal fade" id="modal_assign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="min-width: 330px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class=" modal-title fs-5" id="exampleModalLabel">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                    </svg>
                    Information
                </h1>
            </div>
            <div class="modal-body">
                <span id="modal_assign_message">User successfully assigned.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- MESSAGE IF ROLE ASSIGNMENT SUCCESS -->

<script>
    let roles = document.getElementsByClassName('role');
    let modalAssign = new bootstrap.Modal(document.getElementById('modal_assign'), {});
    let modal_assign_message = document.getElementById('modal_assign_message');
    let current_roles = [];

    for (let i = 0; i < roles.length; i++) {

        current_roles.push(roles[i].value);

        roles[i].onchange = () => {

            let new_role = roles[i].value;

            async function assignRole() {
                const roleResponse = await fetch('/user-role-assignment', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        user_id: roles[i].getAttribute('user_id'),
                        role: new_role
                    })
                });

                const content = await roleResponse.json();

                if (content.response) {

                    let message = `User successfully assigned as ${new_role != '' ? new_role : 'regular member'}.`

                    if (content.message !== undefined) {
                        message = content.message;
                        roles[i].value = current_roles[i];
                    }

                    modal_assign_message.textContent = message;
                    modalAssign.show();
                } else {
                    modal_assign_message.textContent = 'Cannot add or update a child row.'
                    modalAssign.show();
                }
            }

            assignRole();
        }
    }
</script>

<?= $this->endSection('content') ?>