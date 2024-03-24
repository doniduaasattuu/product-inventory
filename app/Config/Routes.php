<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ProductController::index');

$routes->group('/', ['filter' => 'onlyguest'], function ($routes) {
    $routes->get('login', 'UserController::login', ['as' => 'login']);
    $routes->post('login', 'UserController::doLogin');
    $routes->get('registration', 'UserController::registration', ['as' => 'registration']);
    $routes->post('registration', 'UserController::register');
    $routes->get('product-detail/(:any)', 'ProductController::productDetail/$1');
});

$routes->group('/', ['filter' => 'onlymember'], function ($routes) {
    // HOME
    $routes->get('scanner', 'HomeController::scanner', ['as' => 'scanner']);
    // USER
    $routes->get('profile', 'UserController::profile', ['as' => 'profile']);
    $routes->post('profile', 'UserController::updateProfile');
    $routes->get('logout', 'UserController::logout', ['as' => 'logout']);
    // PRODUCT
    $routes->get('product-update/(:any)', 'ProductController::productUpdate/$1');
    $routes->post('product-update', 'ProductController::updateProduct');
    $routes->get('product-delete/(:any)', 'ProductController::productDelete/$1');
    $routes->get('product-new', 'ProductController::productNew', ['as' => 'product-new']);
    $routes->post('product-new', 'ProductController::insertProduct');
    // CATEGORY
    $routes->get('categories', 'ProductController::categories');
    $routes->post('category-new', 'ProductController::insertCategory');
    $routes->get('category-delete/(:any)', 'ProductController::categoryDelete/$1');
});
