<?php

namespace App\View;

use App\Renderable;

class View implements Renderable
{
    protected $location;
    protected $config;

    public function __construct(string $location, array $config = [])
    {
        $this->location = $location;
        $this->config = $config;
    }

    public function render()
    {
        if (file_exists($page = VIEW_DIR . $this->formatLocation($this->location))) {
            extract($this->config);
            include $page;
        }
    }

    protected function formatLocation(string $path): string
    {
        return '/' . str_replace('.','/', trim($path)) . '.php';
    }
}
