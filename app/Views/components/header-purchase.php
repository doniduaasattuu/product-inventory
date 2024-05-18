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
        <div class="col col-5 col-sm-6 pe-1">
            <?= view('components/label', ['label' => 'start_date']) ?>
            <?= view('components/input-date', ['id' => 'start_date', 'name' => 'start_date']) ?>
        </div>
        <div class="col col-7 col-sm-6 ps-1">
            <?= view('components/label', ['label' => 'end_date']) ?>
            <div class="input-group">
                <?= view('components/input-date', ['id' => 'end_date', 'name' => 'end_date']) ?>
                <div id="action_button" class="btn btn-primary">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>
                </div>
            </div>
        </div>
        <?= view('components/input-help', ['message' => 'Default value is year to date.', 'action' => null]) ?>
    </div>
</section>