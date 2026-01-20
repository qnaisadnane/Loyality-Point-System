<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
session_start();


$router = new App\Core\Router();
require_once __DIR__ . '/../config/routes.php';

$uri = str_replace('/loyality_point_system/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (empty($uri)) $uri = '/';

$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);