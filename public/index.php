<?php

use App\Http\Controller\Auth;
use App\Http\Controller\TodoController;
use App\Http\Controller\StepController;
use App\Http\Controller\UserStepController;

require_once __DIR__ . '/../bootstrap/app.php';

$router = new \App\Router();

// Main
$router->get('index','/', function () {
    return new \App\View\View('index');
});
$router->setController((new StepController())->setName('steps')->setPath('/steps'));

// User list
$router->get('todos.index', '/todos',TodoController::class . '@index');
$router->get('todos.show','/todos/*',TodoController::class . '@show');
$router->post('todos.store', '/todos',TodoController::class . '@store');
$router->delete('todos.destroy', '/todos/*',TodoController::class . '@destroy');
$router->setController((new UserStepController())->setName('todos.steps')->setPath('/todos/*/steps'));

// User
$router->get('registration.get', '/registration', Auth\RegistrationController::class . '@get');
$router->post('registration.post', '/registration', Auth\RegistrationController::class . '@post');
$router->get('login.get', '/login', Auth\LoginController::class . '@get');
$router->post('login.post', '/login', Auth\LoginController::class . '@post');
$router->get('logout', '/logout', Auth\LogoutController::class . '@get');

(new \App\Application($router))->run();
