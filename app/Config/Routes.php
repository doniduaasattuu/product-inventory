<?php

use App\Controllers\PurchaseController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/current', function () {
    return response()->setJSON(session()->get('user'));
});

$routes->get('/', 'ProductController::index');
// SCANNER
$routes->get('scanner', 'HomeController::scanner', ['as' => 'scanner']);
// SEARCH
$routes->post('search', 'HomeController::search');

// SCANNED PRODUCT
$routes->get('/scanned-product/(:any)', 'ProductController::scannedProduct/$1');

// ONLY GUEST
$routes->group('/', ['filter' => 'onlyguest'], function ($routes) {
    $routes->get('login', 'UserController::login', ['as' => 'login']);
    $routes->post('login', 'UserController::doLogin');
    $routes->get('registration', 'UserController::registration', ['as' => 'registration']);
    $routes->post('registration', 'UserController::register');
    $routes->get('product-detail/(:any)', 'ProductController::productDetail/$1');
});

// ONLY MEMBER
$routes->group('/', ['filter' => 'onlymember'], function ($routes) {

    // USER
    $routes->get('profile', 'UserController::profile', ['as' => 'profile']);
    $routes->post('profile', 'UserController::updateProfile');
    $routes->get('logout', 'UserController::logout', ['as' => 'logout']);

    // ONLY ADMIN OR MANAGER
    $routes->group('', ['filter' => 'onlyadmin'], function ($routes) {
        $routes->get('purchase', 'PurchaseController::index');
        $routes->get('purchase-new', 'PurchaseController::purchaseNew');
        $routes->get('purchase-order/(:any)', 'PurchaseController::purchaseOrderAdd/$1');
        $routes->get('purchase-order', 'PurchaseController::purchaseOrder');
        $routes->get('purchase-order-delete', 'PurchaseController::purchaseOrderDelete');
        $routes->get('purchase-order-delete/(:any)', 'PurchaseController::purchaseOrderDeleteProduct/$1');

        $routes->post('purchase-detail', 'PurchaseController::purchaseDetailSubmit');
        $routes->get('purchase-detail/(:any)', 'PurchaseController::purchaseDetail/$1');
        $routes->get('purchase-update/(:any)', 'PurchaseController::purchaseUpdate/$1');
        $routes->get('purchase-delete/(:any)', 'PurchaseController::purchaseDelete/$1');
        $routes->post('purchase-update', 'PurchaseController::purchaseUpdateEnd');
    });

    // ONLY MANAGER
    $routes->group('', ['filter' => 'onlymanager'], function ($routes) {
        $routes->get('user-delete/(:any)', 'UserController::userDelete/$1');
        $routes->get('user-reset/(:any)', 'UserController::userReset/$1');
        $routes->get('users', 'UserController::users', ['as' => 'users']);
    });

    // PRODUCT
    $routes->get('product-update/(:any)', 'ProductController::productUpdate/$1');
    $routes->post('product-update', 'ProductController::updateProduct');
    $routes->get('product-delete/(:any)', 'ProductController::productDelete/$1');
    $routes->get('product-new', 'ProductController::productNew', ['as' => 'product-new']);
    $routes->post('product-new', 'ProductController::insertProduct');

    // CATEGORY
    $routes->get('categories', 'CategoryController::categories');
    $routes->post('category-new', 'CategoryController::insertCategory');
    $routes->get('category-delete/(:any)', 'CategoryController::categoryDelete/$1');
});
