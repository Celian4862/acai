<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

use App\Controllers\Accounts;

$routes->get('login', [Accounts::class, 'index']);
$routes->post('login', [Accounts::class, 'login']);
$routes->get('forgot-password', [Accounts::class, 'fpass']);
$routes->post('forgot-password', [Accounts::class, 'send_email']);
$routes->get('signup', [Accounts::class, 'signup']);
$routes->post('signup', [Accounts::class, 'create_account']);

use App\Controllers\Home;

$routes->get('/', [Home::class, 'index']);
$routes->get('home', [Home::class, 'index']);
$routes->get('(:segment)', [Home::class, 'view']);