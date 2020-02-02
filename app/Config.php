<?php

namespace App;

final class Config // Singleton
{
    /*** @var Config */
    private static $instance;
    private $configs = [];

    private function __construct()
    {
        foreach (glob(CONFIG_DIR . '/*.php') as $path) {
            $this->configs[pathinfo($path, PATHINFO_FILENAME)] = require($path);
        }
    }

    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function get(string $request, $default = null)
    {
        return array_get($this->configs, $request, $default);
    }
}
