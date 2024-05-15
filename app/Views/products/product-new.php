<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/', 'name' => 'Home'], 'action' => 'New']) ?>
</div>

<?= view('components/alert') ?>

<form action="/product-new" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <?= view('components/label', ['label' => 'name']) ?>
        <?= view('components/input-text', ['id' => 'name', 'name' => 'name', 'required' => 'required']) ?>
        <?= view('components/input-error-session', ['field' => 'name']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'category']) ?>
        <?= view('components/input-select', ['id' => 'category', 'name' => 'category', 'categories' => $categories ?? null, 'selected' => set_value('category')]) ?>
        <?= view('components/input-error-session', ['field' => 'category']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'price']) ?>
        <?= view('components/input-number', ['id' => 'price', 'name' => 'price', 'maxlength' => '8']) ?>
        <?= view('components/input-error-session', ['field' => 'price']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'stock']) ?>
        <?= view('components/input-number', ['id' => 'stock', 'name' => 'stock', 'maxlength' => '6']) ?>
        <?= view('components/input-error-session', ['field' => 'stock']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'image']) ?>
        <?= view('components/input-file', ['id' => 'image', 'name' => 'image']) ?>
        <?= view('components/input-error-session', ['field' => 'image']) ?>
    </div>

    <?= view('components/button-primary', ['context' => 'Submit']) ?>

</form>

<?= $this->endSection('content') ?>