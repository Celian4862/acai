<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

use App\Controllers\Accounts;

$routes->get('accounts', [Accounts::class, 'view']);
$routes->get('accounts/(:segment)', [Accounts::class, 'view']);
$routes->post('accounts/create-account', [Accounts::class, 'create_account']);
$routes->post('accounts/login', [Accounts::class, 'login']);
$routes->post('accounts/logout', [Accounts::class, 'logout']);

use App\Controllers\Home;

$routes->get('/', [Home::class, 'index']);
$routes->get('home', [Home::class, 'index']);
$routes->get('(:segment)', [Home::class, 'view']);