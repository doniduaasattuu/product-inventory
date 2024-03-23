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
    $routes->get('profile', 'UserController::profile', ['as' => 'profile']);
    $routes->get('scanner', 'HomeController::scanner', ['as' => 'scanner']);

    $routes->get('product-update/(:any)', 'ProductController::productUpdate/$1');
    $routes->get('product-delete/(:any)', 'ProductController::productDelete/$1');
    $routes->get('new-product', 'ProductController::newProduct', ['as' => 'new-product']);

    $routes->get('logout', 'UserController::logout', ['as' => 'logout']);
});
