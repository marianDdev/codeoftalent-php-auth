<?php

use App\Router;
use App\Session;
use Dotenv\Dotenv;

const BASE_PATH = __DIR__.'/';

session_start();

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'bootstrap.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$router = new Router();
require BASE_PATH . 'routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);

Session::unflash();