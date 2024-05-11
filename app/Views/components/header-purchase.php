<section class="mb-4">

    <!-- BUTTON -->
    <div class="mb-3">
        <div class="">
            <button type="button" class="btn btn-primary">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/purchase-new">
                    <svg class="my-1 me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    New purchase
                </a>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/categories">Categories</a></li>
            </ul>
        </div>
    </div>

    <div class="row mb-3">
        <!-- FILTER -->
        <div class="col pe-1">
            <?= view('components/label', ['label' => 'filter']) ?>
            <?= view('components/input-text', ['id' => 'filter', 'name' => 'filter', 'placeholder' => 'Any']) ?>
        </div>
        <div class="col ps-1">
            <?= view('components/label', ['label' => 'date']) ?>
            <?= view('components/input-date', ['id' => 'date', 'name' => 'date', 'placeholder' => 'Any']) ?>
        </div>
        <!-- FILTER CATEGORY -->
    </div>
</section>