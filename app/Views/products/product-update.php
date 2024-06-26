<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-semibold"><?= $title ?? '' ?></h2>
    <?= view('components/breadcrumb', ['base' => ['link' => '/', 'name' => 'Home'], 'action' => $product['id']]) ?>
</div>

<?= view('components/alert') ?>

<form action="/product-update" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <?= view('components/label', ['label' => 'id']) ?>
        <?= view('components/input-text', ['id' => 'id', 'name' => 'id', 'value' => $product['id'], 'readonly' => 'readonly']); ?>
        <?= view('components/input-error-session', ['field' => 'id']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'name']) ?>
        <?= view('components/input-text', ['id' => 'name', 'name' => 'name', 'value' => $product['name'], 'readonly' => null]) ?>
        <?= view('components/input-error-session', ['field' => 'name']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'category']) ?>
        <?= view('components/input-select', ['id' => 'category', 'name' => 'category', 'selected' => $product['category'], 'categories' => $categories ?? null]) ?>
        <?= view('components/input-error-session', ['field' => 'category']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'price']) ?>
        <?= view('components/input-number', ['id' => 'price', 'name' => 'price', 'value' => $product['price'], 'maxlength' => '8']) ?>
        <?= view('components/input-error-session', ['field' => 'price']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'stock']) ?>
        <?= view('components/input-number', ['id' => 'stock', 'name' => 'stock', 'value' => $product['stock'], 'maxlength' => '6']) ?>
        <?= view('components/input-error-session', ['field' => 'stock']) ?>
    </div>

    <div class="mb-3">
        <?= view('components/label', ['label' => 'image']) ?>
        <div class="input-group">
            <?= view('components/input-file', ['id' => 'image', 'name' => 'image']) ?>
            <?php if ($product['attachment']) : ?>
                <button class="btn btn-outline-secondary" type="button">
                    <a class="text-reset text-decoration-none" href="/images/products/<?= $product['attachment'] ?>">
                        Existing
                    </a>
                </button>
            <?php endif; ?>
        </div>
        <?= view('components/input-error-session', ['field' => 'image']) ?>
    </div>

    <?= view('components/button-primary', ['context' => 'Update']) ?>

</form>

<?= $this->endSection('content') ?>