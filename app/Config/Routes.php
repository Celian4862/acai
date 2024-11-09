<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('accounts', static function ($routes) {
    $routes->get('/', 'Accounts::view');
    $routes->get('login', 'Accounts::view');
    $routes->get('signup', 'Accounts::view/signup');
    $routes->get('forgot-password', 'Accounts::view/forgot-password');
    $routes->get('logout', 'Accounts::logout');
    $routes->get('(:segment)', 'Accounts::user_views/$1');
    $routes->post('login', 'Accounts::login');
    $routes->post('signup', 'Accounts::create_account');
    $routes->post('forgot-password', 'Accounts::forgot_password');
});

use App\Controllers\Home;

$routes->get('/', [Home::class, 'index']);
$routes->get('home', [Home::class, 'index']);
$routes->get('(:segment)', [Home::class, 'view']);