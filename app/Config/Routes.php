<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('forum', static function ($routes) {
    $routes->get('(:segment)', 'Forum::view/$1');
    $routes->post('newpost', 'Forum::newpost');
});

$routes->get('/', 'Home::index');
$routes->get('about-us', 'Home::view/about-us');

$routes->get('login', 'Accounts::view');
$routes->get('signup', 'Accounts::view/signup');
$routes->get('forgot-password', 'Accounts::view/forgot-password');
$routes->get('reset-password', 'Accounts::view/reset-password');
$routes->get('reset-success', 'Accounts::view/reset-success');
$routes->get('logout', 'Accounts::logout');
$routes->get('dashboard', 'Posts::view');
$routes->get('(:segment)', 'Accounts::user_views/$1');

$routes->post('login', 'Accounts::login');
$routes->post('signup', 'Accounts::create_account');
$routes->post('forgot-password', 'Accounts::forgot_password');
$routes->post('reset-password', 'Accounts::reset_password');

$routes->group('accounts', static function ($routes) {
    $routes->get('settings', 'Accounts::settings');
    $routes->get('delete-account', 'Accounts::delete_account');
});