<?php

// Warnings
error_reporting(E_ALL);
ini_set('display_errors',true);

require __DIR__ . '/../vendor/autoload.php';

$db = \App\Config::getInstance()->get('db');

$capsule = new \Illuminate\Database\Capsule\Manager();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $db['host'],
    'database'  => $db['database'],
    'username'  => $db['user'],
    'password'  => $db['password'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
