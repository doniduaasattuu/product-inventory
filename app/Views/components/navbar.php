<!-- NAVBAR -->
<nav class="sticky-top navbar absolute navbar-expand-xl bg-dark text-white zindex-fixed shadow-sm border-bottom border-1">
    <div class="container-md">
        <a class="text-white fw-medium me-xl-4 me-lg-3 navbar-brand" href="/">Product Inventory</a>
        <button class="navbar-dark navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="/search" method="POST" class="my-4 mb-xl-0 my-xl-0 d-flex" role="search">
                <?= view('components/input-text', ['id' => 'search', 'name' => 'search', 'placeholder' => 'Product id', 'maxlength' => '20', 'class' => 'me-2', 'value' => null]) ?>
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <!-- SCANNER -->
                <li class="nav-item me-2 me-md-3">
                    <a id="navbar_trends" class="text-white nav-link" href="/scanner">
                        <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code" viewBox="0 0 16 16">
                            <path d="M2 2h2v2H2V2Z" />
                            <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z" />
                            <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z" />
                            <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z" />
                            <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z" />
                        </svg>
                        Scanner
                    </a>
                </li>
                <!-- SCANNER -->

                <?php if (session()->get('user')) : ?>


                    <!-- TRANSACTION START -->
                    <?php if (session()->get('user')['role'] == 'Admin' || session()->get('user')['role'] == 'Manager') : ?>
                        <li class="nav-item dropdown">
                            <a class="text-white nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                                </svg>
                                Transactions
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <a class="text-light dropdown-item" href="/logout">
                                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                        </svg>
                                        Purchase
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/profile">
                                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                            <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1zm1 12h2V2h-2zm-3 0V7H7v7zm-5 0v-3H2v3z" />
                                        </svg>
                                        Sales
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- TRANSACTION END -->

                    <!-- USERS TABLE START -->
                    <?php if (session()->get('user')['role'] == 'Manager') : ?>
                        <li class="nav-item me-2 me-md-3">
                            <a id="navbar_trends" class="text-white nav-link" href="/users">
                                <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                </svg>
                                Users
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- USERS TABLE END -->

                <?php endif; ?>

                <!-- USER -->
                <li class="nav-item dropdown">
                    <a class="text-white nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (session()->get('user')) : ?>
                            <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            </svg>
                            <?= session()->get('user')['name'] ?>
                        <?php else : ?>
                            Hello, guest
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <?php if (session()->get('user')) : ?>
                            <li>
                                <a class="dropdown-item" href="/profile">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                    My profile
                                </a>
                            </li>
                            <li>
                                <a class="text-light dropdown-item" href="/logout">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fd7e14" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                    </svg>
                                    Logout
                                </a>
                            </li>
                        <?php else : ?>
                            <li>
                                <a class="dropdown-item" href="/registration">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                    Registration
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/login">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z" />
                                        <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                    </svg>
                                    Login
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>