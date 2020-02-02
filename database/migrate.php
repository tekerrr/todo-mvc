<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/../bootstrap/app.php';

Capsule::schema()->dropIfExists('users');
Capsule::schema()->create('users', function (Illuminate\Database\Schema\Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('login')->unique();
    $table->string('password');
    $table->timestamps();
});
