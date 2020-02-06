<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../bootstrap/app.php';

Capsule::schema()->dropIfExists('steps');
Capsule::schema()->dropIfExists('todos');
Capsule::schema()->dropIfExists('users');

Capsule::schema()->create('users', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('login')->unique();
    $table->string('password');
});

Capsule::schema()->create('todos', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('session')->nullable()->unique();
    $table->string('name')->nullable();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

Capsule::schema()->create('steps', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('todo_id');
    $table->string('body');
    $table->boolean('is_completed')->default(false);

    $table->foreign('todo_id')->references('id')->on('todos')->onDelete('cascade');
});
