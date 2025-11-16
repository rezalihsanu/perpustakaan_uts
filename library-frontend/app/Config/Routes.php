<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Book::index');

// Book routes
$routes->group('book', function ($routes) {
    $routes->get('/', 'Book::index');                    // Daftar buku
    $routes->get('create', 'Book::create');              // Form tambah buku
    $routes->post('store', 'Book::store');               // Proses tambah
    $routes->get('show/(:num)', 'Book::show/$1');        // Detail buku
    $routes->get('edit/(:num)', 'Book::edit/$1');        // Form edit buku
    $routes->post('update/(:num)', 'Book::update/$1');   // Proses update
    $routes->get('delete/(:num)', 'Book::delete/$1');    // Hapus buku
});