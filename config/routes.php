<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

$router->get('/', HomeController::class, 'index');

$router->get('/register', AuthController::class, 'showRegister');
$router->post('/register', AuthController::class, 'register');

$router->get('/login', AuthController::class, 'showLogin');
$router->post('/login', AuthController::class, 'login');

$router->get('/logout', AuthController::class, 'logout');

$router->get('/dashboard', DashboardController::class, 'index');
