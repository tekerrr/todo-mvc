<?php

use App\Http\Controller\StepController;
use App\Http\Controller\Auth;

require_once __DIR__ . '/../bootstrap/app.php';

$router = new \App\Router();

// Front
$router->get('index','/', function () {
    return new \App\View\View('index');
});
$router->setController((new StepController())->setName('steps')->setPath('/steps'));

// User
$router->get('registration.get', '/registration', Auth\RegistrationController::class . '@get');
$router->post('registration.post', '/registration', Auth\RegistrationController::class . '@post');
$router->get('login.get', '/login', Auth\LoginController::class . '@get');
$router->post('login.post', '/login', Auth\LoginController::class . '@post');
$router->get('logout', '/logout', Auth\LogoutController::class . '@get');

$router->get('index.tmp','/index', function () {
    return new \App\View\View('tmp.index');
});

(new \App\Application($router))->run();
