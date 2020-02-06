<?php

use App\Http\Controller\StepController;
use App\Http\Controller\Auth;

require_once __DIR__ . '/../bootstrap/app.php';

$router = new \App\Router();

// Front
$router->get('index','/', function () {
    return new \App\View\View('index');
});
$router->get('steps.index', '/steps', StepController::class . '@index');
$router->post('steps.store', '/steps', StepController::class . '@store');
$router->put('steps.update', '/steps/*', StepController::class . '@update');
$router->delete('steps.destroy.completed', '/steps/completed', StepController::class . '@deleteCompleted');
$router->delete('steps.destroy', '/steps/*', StepController::class . '@delete');
$router->put('steps.all.complete', '/steps/all/complete', StepController::class . '@completeAll');
$router->put('steps.all.uncomplete', '/steps/all/activate', StepController::class . '@activateAll');
$router->put('steps.complete', '/steps/*/complete', StepController::class . '@complete');
$router->put('steps.uncomplete', '/steps/*/activate', StepController::class . '@activate');

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
