<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('forum', static function ($routes) {
    $routes->get('(:segment)', 'Forum::view/$1');
    $routes->post('newpost', 'Forum::newpost');
});

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
    $routes->post('settings', 'Accounts::settings');
    $routes->post('delete-account', 'Accounts::delete_account');
});

$routes->get('/', 'Home::index');
$routes->get('(:segment)', 'Home::view/$1');