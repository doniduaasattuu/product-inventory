<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['action' => 'New']) ?>
</div>

<?= view('components/alert') ?>

<form action="/product-new" method="POST">

    <div class="mb-3">
        <?= view('components/label', ['label' => 'name']) ?>
        <?= view('components/input-text', ['id' => 'name', 'name' => 'name', 'required' => 'required']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'name']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'category']) ?>
        <?= view('components/input-select', ['id' => 'category', 'name' => 'category', 'categories' => $categories ?? null]) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'category']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'price']) ?>
        <?= view('components/input-number', ['id' => 'price', 'name' => 'price', 'maxlength' => '8']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'price']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'stock']) ?>
        <?= view('components/input-number', ['id' => 'stock', 'name' => 'stock', 'maxlength' => '6']) ?>
        <?= view('components/input-error', ['validation' => $validation ?? null, 'field' => 'stock']) ?>
    </div>

    <?= view('components/button-primary', ['context' => 'Submit']) ?>

</form>

<?= $this->endSection('content') ?>