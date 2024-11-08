<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

use App\Controllers\Login;

$routes->get('login', [Login::class, 'index']);
$routes->get('forgot-password', [Login::class, 'fpass']);

use App\Controllers\Home;

$routes->get('/', [Home::class, 'index']);
$routes->get('home', [Home::class, 'index']);
$routes->get('(:segment)', [Home::class, 'view']);