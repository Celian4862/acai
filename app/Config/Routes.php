<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

use App\Controllers\Home;

$routes->get('/', [Home::class, 'index']);

use App\Controllers\Images;

$routes->get('images/(:segment)', [Images::class, 'get_image']);