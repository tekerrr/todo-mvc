<?php

require_once __DIR__ . '/../bootstrap/app.php';

$router = new \App\Router();

$router->get('/test1', \App\Http\Controllers\TestController::class . '@index');

(new \App\Application($router))->run();
