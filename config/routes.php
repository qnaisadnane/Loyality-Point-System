<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HistoryController;
use App\Controllers\RewardsController;
$router->get('/', HomeController::class, 'index');

$router->get('/register', AuthController::class, 'showRegister');
$router->post('/register', AuthController::class, 'register');

$router->get('/login', AuthController::class, 'showLogin');
$router->post('/login', AuthController::class, 'login');

$router->get('/logout', AuthController::class, 'logout');

$router->get('/history', HistoryController::class, 'index');

$router->get('/rewards', RewardsController::class, 'index');

$router->post('/rewards/redeem', RewardsController::class, 'redeem');