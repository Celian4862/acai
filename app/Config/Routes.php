<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('dashboard', 'Posts::view');
$routes->group('forum', static function ($routes) {
    $routes->get('(:segment)', 'Posts::view/$1');
    $routes->post('newpost', 'Posts::newpost');
});

$routes->get('/', 'Home::index');
$routes->get('about-us', 'Home::view/about-us');

$routes->get('login', 'Accounts::view');
$routes->get('signup', 'Accounts::view/signup');
$routes->get('forgot-password', 'Accounts::view/forgot-password');
$routes->get('reset-password', 'Accounts::view/reset-password');
$routes->get('reset-success', 'Accounts::view/reset-success');
$routes->get('logout', 'Accounts::logout');

$routes->get('(:segment)', 'Accounts::user_view/$1');

$routes->post('login', 'Accounts::login');
$routes->post('signup', 'Accounts::create_account');
$routes->post('forgot-password', 'Accounts::forgot_password');
$routes->post('reset-password', 'Accounts::reset_password');

$routes->group('accounts', static function ($routes) {
    $routes->get('(:segment)', 'Accounts::user_view/$1');
    $routes->post('settings', 'Accounts::settings');
    $routes->post('delete-account', 'Accounts::delete_account');
});