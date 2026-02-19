<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Redirect root ke dashboard atau login
$routes->get('/', function () {
    return redirect()->to(session()->get('is_logged_in') ? '/dashboard' : '/login');
});

// ─── Auth (Guest only) ────────────────────────────────────────────
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::loginPost');
});

$routes->get('logout', 'Auth::logout');

// ─── Protected Routes (Auth required) ────────────────────────────
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Kategori
    $routes->get('categories', 'Category::index');
    $routes->get('categories/create', 'Category::create');
    $routes->post('categories/store', 'Category::store');
    $routes->get('categories/(:num)/edit', 'Category::edit/$1');
    $routes->post('categories/(:num)/update', 'Category::update/$1');
    $routes->get('categories/(:num)/delete', 'Category::delete/$1');

    // Produk
    $routes->get('products', 'Product::index');
    $routes->get('products/create', 'Product::create');
    $routes->post('products/store', 'Product::store');
    $routes->get('products/(:num)/edit', 'Product::edit/$1');
    $routes->post('products/(:num)/update', 'Product::update/$1');
    $routes->get('products/(:num)/delete', 'Product::delete/$1');

    // Penjualan
    $routes->get('sales', 'Sale::index');
    $routes->get('sales/create', 'Sale::create');
    $routes->post('sales/store', 'Sale::store');
    $routes->get('sales/(:num)/show', 'Sale::show/$1');
    $routes->get('sales/(:num)/delete', 'Sale::delete/$1');
});
