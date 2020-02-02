<?php

require_once __DIR__ . '/../bootstrap/app.php';

$router = new \App\Router();

$router->get('index','/index', function () {
    return new \App\View\View('index');
});

$router->get('registration.get', '/registration', \App\Http\Controller\Auth\RegistrationController::class . '@get');
$router->post('registration.post', '/registration', \App\Http\Controller\Auth\RegistrationController::class . '@post');

$router->get('login.get', '/login', \App\Http\Controller\Auth\LoginController::class . '@get');
$router->post('login.post', '/login', \App\Http\Controller\Auth\LoginController::class . '@post');

$router->get('logout', '/logout', \App\Http\Controller\Auth\LogoutController::class . '@get');

$router->get('test','/test', \App\Http\Controller\TestController::class . '@test');
$router->post('test_post','/test', function () {
    return 'test_post';
});
$router->put('test_put','/test', function () {
    return 'test_put';
});
$router->delete('test_delete','/test', function () {
    return 'test_delete';
});
$router->get('test1','/test1', \App\Http\Controller\TestController::class . '@test1');
$router->get('phpinfo','/phpinfo', function () {
    return new \App\View\View('master');
});

(new \App\Application($router))->run();
