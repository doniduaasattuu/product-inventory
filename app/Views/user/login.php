<?= $this->extend('layouts/guest'); ?>

<?= $this->section('content'); ?>

<h2 class="mb-4 fw-semibold"><?= $title ?? '' ?></h2>

<?= view('components/alert') ?>

<form action="/login" method="POST">

    <div class="mb-3">
        <?= view('components/label', ['label' => 'email']) ?>
        <?= view('components/input-text', ['id' => 'email', 'name' => 'email']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'email']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'password']) ?>
        <?= view('components/input-password', ['id' => 'password', 'name' => 'password']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'password']) ?>
    </div>

    <?= view('components/button-primary', ['context' => 'Submit']) ?>
    <?= view('components/input-help', ['message' => "Don't have an account ?, ", 'href' => '/registration', 'action' => 'Register here.']) ?>
</form>

<?= $this->endSection('content'); ?>