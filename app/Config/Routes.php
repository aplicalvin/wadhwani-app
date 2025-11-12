<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTE PUBLIK & AUTENTIKASI ---
// Rute publik (jika ada)
$routes->get('/', 'Home::index'); 

// Rute Login
$routes->get('login', 'Admin\AuthController::login', ['as' => 'login']);
$routes->post('login/attempt', 'Admin\AuthController::attemptLogin', ['as' => 'login.attempt']);
$routes->get('logout', 'Admin\AuthController::logout', ['as' => 'logout']);


// --- GRUP RUTE ADMIN (DILINDUNGI) ---
// Semua rute di dalam grup ini akan dicek oleh filter 'auth'
// Jika belum login atau bukan admin, akan ditendang ke 'login'

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('/', 'Dashboard::index', ['as' => 'admin.dashboard.redirect']); // Redirect /admin ke /admin/dashboard
    $routes->get('dashboard', 'Dashboard::index', ['as' => 'admin.dashboard']);

    // --- Modul Kategori ---
    $routes->get('categories', 'CategoryController::index', ['as' => 'admin.categories']);
    $routes->get('categories/new', 'CategoryController::new', ['as' => 'admin.categories.new']);
    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1', ['as' => 'admin.categories.edit']);
    $routes->post('categories/save', 'CategoryController::save', ['as' => 'admin.categories.save']);
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1', ['as' => 'admin.categories.update']);
    $routes->get('categories/delete/(:num)', 'CategoryController::delete/$1', ['as' => 'admin.categories.delete']);

    // --- Modul Produk ---
    $routes->get('products', 'ProductController::index', ['as' => 'admin.products']);
    $routes->get('products/new', 'ProductController::new', ['as' => 'admin.products.new']);
    $routes->get('products/edit/(:num)', 'ProductController::edit/$1', ['as' => 'admin.products.edit']);
    $routes->post('products/save', 'ProductController::save', ['as' => 'admin.products.save']);
    $routes->post('products/update/(:num)', 'ProductController::update/$1', ['as' => 'admin.products.update']);
    $routes->get('products/delete/(:num)', 'ProductController::delete/$1', ['as' => 'admin.products.delete']);

    // --- Modul Testimoni ---
    $routes->get('testimonials', 'TestimonialController::index', ['as' => 'admin.testimonials']);
    $routes->get('testimonials/new', 'TestimonialController::new', ['as' => 'admin.testimonials.new']);
    $routes->get('testimonials/edit/(:num)', 'TestimonialController::edit/$1', ['as' => 'admin.testimonials.edit']);
    $routes->post('testimonials/save', 'TestimonialController::save', ['as' => 'admin.testimonials.save']);
    $routes->post('testimonials/update/(:num)', 'TestimonialController::update/$1', ['as' => 'admin.testimonials.update']);
    $routes->get('testimonials/delete/(:num)', 'TestimonialController::delete/$1', ['as' => 'admin.testimonials.delete']);

    // --- Modul Users ---
    $routes->get('users', 'UserController::index', ['as' => 'admin.users']);
    $routes->get('users/new', 'UserController::new', ['as' => 'admin.users.new']);
    $routes->get('users/edit/(:num)', 'UserController::edit/$1', ['as' => 'admin.users.edit']);
    $routes->post('users/save', 'UserController::save', ['as' => 'admin.users.save']);
    $routes->post('users/update/(:num)', 'UserController::update/$1', ['as' => 'admin.users.update']);
    $routes->get('users/delete/(:num)', 'UserController::delete/$1', ['as' => 'admin.users.delete']);

    // --- Modul Pengaturan ---
    $routes->get('settings', 'SettingController::index', ['as' => 'admin.settings']);
    $routes->post('settings/update', 'SettingController::update', ['as' => 'admin.settings.update']);

});