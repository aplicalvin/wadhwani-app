<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // Halaman utama (public)

// --- GRUP RUTE ADMIN ---
// 'namespace' membantu kita agar tidak perlu menulis 'App\Controllers\Admin\' berulang kali
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {

    // Dashboard
    $routes->get('/', 'Dashboard::index', ['as' => 'admin.dashboard']);

    // Categories (Dirancang untuk AJAX/Modal)
    $routes->get('categories', 'CategoryController::index', ['as' => 'admin.categories.index']); // Halaman utama (tabel)
    $routes->post('categories/store', 'CategoryController::store', ['as' => 'admin.categories.store']); // AJAX Create
    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1', ['as' => 'admin.categories.edit']); // AJAX Get data for Edit
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1', ['as' => 'admin.categories.update']); // AJAX Update
    $routes->delete('categories/delete/(:num)', 'CategoryController::delete/$1', ['as' => 'admin.categories.delete']); // AJAX Delete

    // Products (Pola yang sama)
    $routes->get('products', 'ProductController::index', ['as' => 'admin.products.index']);
    $routes->post('products/store', 'ProductController::store', ['as' => 'admin.products.store']);
    $routes->get('products/edit/(:num)', 'ProductController::edit/$1', ['as' => 'admin.products.edit']);
    $routes->post('products/update/(:num)', 'ProductController::update/$1', ['as' => 'admin.products.update']);
    $routes->delete('products/delete/(:num)', 'ProductController::delete/$1', ['as' => 'admin.products.delete']);

    // Testimonials (Pola yang sama)
    $routes->get('testimonials', 'TestimonialController::index', ['as' => 'admin.testimonials.index']);
    $routes->post('testimonials/store', 'TestimonialController::store', ['as' => 'admin.testimonials.store']);
    $routes->get('testimonials/edit/(:num)', 'TestimonialController::edit/$1', ['as' => 'admin.testimonials.edit']);
    $routes->post('testimonials/update/(:num)', 'TestimonialController::update/$1', ['as' => 'admin.testimonials.update']);
    $routes->delete('testimonials/delete/(:num)', 'TestimonialController::delete/$1', ['as' => 'admin.testimonials.delete']);

    // Settings (Lebih sederhana, tidak perlu modal)
    $routes->get('settings', 'SettingController::index', ['as' => 'admin.settings.index']);
    $routes->post('settings/update', 'SettingController::update', ['as' => 'admin.settings.update']);
});