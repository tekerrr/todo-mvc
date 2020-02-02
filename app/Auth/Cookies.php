<?php

namespace App\Auth;

use App\Config;

class Cookies
{
    public function get(string $key, $default = null)
    {
        return $_COOKIE[$key] ?? $default;
    }

    public function set(string $key, string $value, int $lifetime = 0): void
    {
        setcookie(
            $key,
            $value,
            time() + ($lifetime ?: Config::getInstance()->get('session.cookie_lifetime')),
            '/'
        );
    }

    private function delete(string $name): void
    {
        setcookie($name, '', time() - 3600 * 24 * 30, '/');
    }

    public function clean(array $keys): void
    {
        foreach ($keys as $key) {
            $this->delete($key);

            unset($_COOKIE[$key]);
        }
    }
}
