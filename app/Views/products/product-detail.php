<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['action' => $product['id']]) ?>
</div>

<?= view('components/alert') ?>

<form>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'id']) ?>
        <?= view('components/input-text', ['id' => 'id', 'name' => 'id', 'value' => $product['id'], 'readonly' => 'readonly']); ?>
        <?= view('components/input-error-session', ['field' => 'id']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'name']) ?>
        <?= view('components/input-text', ['id' => 'name', 'name' => 'name', 'value' => $product['name'], 'readonly' => 'readonly']) ?>
        <?= view('components/input-error-session', ['field' => 'name']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'category']) ?>
        <?= view('components/input-select', ['id' => 'category', 'name' => 'category', 'selected' => $product['category'], 'categories' => $categories ?? null, 'disabled' => 'disabled']) ?>
        <?= view('components/input-error-session', ['field' => 'category']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'price']) ?>
        <?= view('components/input-number', ['id' => 'price', 'name' => 'price', 'value' => $product['price'], 'maxlength' => '8', 'readonly' => 'readonly']) ?>
        <?= view('components/input-error-session', ['field' => 'price']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'stock']) ?>
        <?= view('components/input-number', ['id' => 'stock', 'name' => 'stock', 'value' => $product['stock'], 'maxlength' => '6', 'readonly' => 'readonly']) ?>
        <?= view('components/input-error-session', ['field' => 'stock']) ?>
    </div>

</form>

<?= $this->endSection('content') ?>