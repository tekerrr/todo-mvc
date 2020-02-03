<?php

require_once __DIR__ . '/../bootstrap/app.php';

\App\Model\User::createUser('login', 'password');
\App\Model\Todo::create(['session' => 'session'])
    ->steps()
    ->create(['body' => 'body']);
