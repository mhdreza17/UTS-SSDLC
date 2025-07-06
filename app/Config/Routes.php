<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/quiz', 'Quiz::index');
$routes->get('/quiz/level/(:num)', 'Quiz::level/$1');
$routes->post('/quiz/submitAnswer', 'Quiz::submitAnswer');
$routes->post('/quiz/saveResult', 'Quiz::saveResult');
$routes->get('/quiz/leaderboard', 'Quiz::leaderboard');

// Add authentication routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('attemptLogin', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('attemptRegister', 'Auth::attemptRegister');
    $routes->get('logout', 'Auth::logout');
    $routes->get('profile', 'Auth::profile');
    $routes->post('updateProfile', 'Auth::updateProfile');
});

// Add dashboard route
$routes->get('/dashboard', 'Dashboard::index');
