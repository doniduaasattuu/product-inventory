<?= $this->extend('layouts/guest'); ?>

<?= $this->section('content'); ?>

<h2 class="mb-4 fw-semibold"><?= $title ?? '' ?></h2>

<?= view('components/alert') ?>

<form action="/registration" method="POST">

    <div class="mb-3">
        <?= view('components/label', ['label' => 'name *']) ?>
        <?= view('components/input-text', ['id' => 'name', 'name' => 'name']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'name']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'email *']) ?>
        <?= view('components/input-email', ['id' => 'email', 'name' => 'email']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'email']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'password *']) ?>
        <?= view('components/input-password', ['id' => 'password', 'name' => 'password']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'password']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'phone_number']) ?>
        <?= view('components/input-number', ['id' => 'phone_number', 'name' => 'phone_number', 'maxlength' => '13']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'phone_number']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'registration_code *']) ?>
        <?= view('components/input-text', ['id' => 'registration_code', 'name' => 'registration_code', 'required' => false, 'maxlength' => null]) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'registration_code']) ?>
    </div>

    <?= view('components/button-primary', ['context' => 'Submit']) ?>
    <?= view('components/input-help', ['message' => 'Already have an account ?, ', 'href' => '/login', 'action' => 'Login here.']) ?>
</form>

<?= $this->endSection('content'); ?>