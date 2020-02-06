<?php

namespace App\Http;

use App\Formatter\Path;
use App\Renderable;
use App\Router;

class Redirect implements Renderable
{
    protected $code;
    protected $redirect = '';

    public static function redirect(string $path = '/'): Renderable
    {
        $response = new self();
        $response->code = 303;
        $response->redirect = (new Path())->format($path);

        return $response;
    }

    /**
     * @param string $routeName
     * @return Renderable
     * @throws \Exception
     */
    public static function redirectToRoute(string $routeName): Renderable
    {
        $response = new self();
        $response->code = 303;
        $response->redirect = (new Router())->getRoutePath($routeName);

        return $response;
    }

    public function render()
    {
        if ($this->code) {
            http_response_code($this->code);
        }

        header('Location: ' . $this->redirect);
    }
}
