<?php

declare(strict_types=1);

use App\Router;

include __DIR__ . '/logger.php';
include __DIR__ . '/vendor/autoload.php';

$router = new Router();
$router->run();
