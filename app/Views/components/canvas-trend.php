<section class="mb-4">
    <h6 class="text-center text-secondary"><?= $title ?? 'Data' ?></h6>
    <div class="chart-container" style="position: relative; height: 300px">
        <canvas id="<?= $table ?? 'table' ?>"></canvas>
    </div>
</section>