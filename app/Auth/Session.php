<?php

namespace App\Auth;

use App\Config;

class Session
{
    public function start(): void
    {
        $config = Config::getInstance()->get('session');

        session_name($config['name']);
        ini_set('session.gc_maxlifetime', $config['session_lifetime']);
        session_start();

        (new Cookies())->set(session_name(), session_id(), $config['session_lifetime']);
    }

    public function get(string $key, $default = null)
    {
        return array_get($_SESSION, $key, $default);
    }

    public function getId()
    {
        return session_id();
    }

    public function put(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function destroy(): void
    {
        (new Cookies())->clean([session_name()]);
        session_destroy();
        unset($_SESSION);
    }

    public function clean(): void
    {
        $_SESSION = [];
    }

    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }
}
