<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // Halaman utama (public)

// --- GRUP RUTE ADMIN (NON-AJAX / PHP STANDAR) ---
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {

    // Dashboard (Asumsi Anda punya Dashboard Controller)
    $routes->get('/', 'Dashboard::index', ['as' => 'admin.dashboard']);

    // --- Modul Kategori ---
    $routes->get('categories', 'CategoryController::index', ['as' => 'admin.categories']);
    $routes->get('categories/new', 'CategoryController::new', ['as' => 'admin.categories.new']); // Membuka modal 'create'
    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1', ['as' => 'admin.categories.edit']); // Membuka modal 'edit'
    $routes->post('categories/save', 'CategoryController::save', ['as' => 'admin.categories.save']); // Proses form 'create'
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1', ['as' => 'admin.categories.update']); // Proses form 'edit'
    $routes->get('categories/delete/(:num)', 'CategoryController::delete/$1', ['as' => 'admin.categories.delete']); // Hapus data

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

    // --- Modul Pengaturan (Ini sudah benar dari awal, tidak pakai modal) ---
    $routes->get('settings', 'SettingController::index', ['as' => 'admin.settings']);
    $routes->post('settings/update', 'SettingController::update', ['as' => 'admin.settings.update']);
});